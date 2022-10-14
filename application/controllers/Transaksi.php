<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends CI_Controller
{
    // constructor
    private $page = "Transaksi/";
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Nasabah_model');
        $this->load->library('form_validation');
        if (!auth()["user"]["id_bank_sampah"]) {
            redirect("Login");
        }
    }
    public function index()
    {
        // print_r($this->getTransaksi());
        // die();
        $data = [
            "title" => "Transaksi",
            "page" => $this->page . "index",
            "script" => $this->page . "script",
            "jenis"  => $this->jenis_sampah(),
            "nasabah" => $this->Nasabah_model->getAll(),
            "transaksi" => $this->getTransaksi()
        ];
        $this->load->view('Router/route', $data);
    }
    public function getTransaksi()
    {
        $this->db->select("*, transaksi.tanggal as tanggal,transaksi.id_transaksi as id_transaksi");
        $this->db->join("users", "users.id = transaksi.id_user_petugas");
        $this->db->join("nasabah", "nasabah.id_nasabah = transaksi.id_nasabah");
        $this->db->join("riwayat_saldo", "riwayat_saldo.id_riwayat  = transaksi.riwayat_id");
        $this->db->where("nasabah.id_bank", auth()["user"]["id_bank_sampah"]);
        if (!empty($_GET['cari']) && $_GET['cari'] != "") {
            $this->db->like('nasabah.nama_nasabah', $_GET['cari'], 'both');
        }
        $this->db->order_by('transaksi.id_transaksi', 'DESC');
        $result = $this->db->get_where("transaksi")->result_array();
        return $result;
    }
    public function jenis_sampah()
    {
        $this->db->where("id_bank", auth()["user"]["id_bank_sampah"]);
        $ck = $this->db->get_where("jenis_sampah")->result_array();
        return $ck;
    }
    public function nama_barang_sampah($kode_jenis)
    {
        $this->db->join("jenis_sampah", "jenis_sampah.kode = sampah.kode_jenis_sampah");
        $this->db->where("sampah.id_bank", auth()["user"]["id_bank_sampah"]);
        $this->db->where("sampah.kode_jenis_sampah", $kode_jenis);
        $b = $this->db->get_where("sampah")->result_array();
        echo json_encode($b);
    }
    public function barangbyid($kode_barang)
    {
        $this->db->join("jenis_sampah", "jenis_sampah.kode = sampah.kode_jenis_sampah");
        $this->db->where("sampah.id_bank", auth()["user"]["id_bank_sampah"]);
        $this->db->where("sampah.kode_sampah", $kode_barang);
        $b = $this->db->get_where("sampah")->row_array();
        echo json_encode($b);
    }
    public function action()
    {
        $data = $this->input->post();
        if (empty(auth()["user"]["id_bank_sampah"])) {
            redirect("Login");
        }
        $this->form_validation->set_rules('id_nasabah', 'Nasabah', 'required');
        $this->form_validation->set_rules('berat', 'berat', 'required');
        $this->form_validation->set_rules('satuan', 'satuan', 'required');
        $this->form_validation->set_rules('harga', 'harga', 'required');
        $this->form_validation->set_rules('total', 'total', 'required');
        if ($this->form_validation->run() != false) {
            $nasabah = $this->db->get_where("nasabah", ["id_nasabah" => $data['id_nasabah']])->row_array();
            if (!empty($data['id_transaksi']) && $data['id_transaksi'] != "") {
                $getTr = $this->db->get_where("transaksi", ["id_transaksi" => $data['id_transaksi']])->row_array();
                $getRiwayat = $this->db->get_where("riwayat_saldo", ["id_riwayat" => $getTr['riwayat_id']])->row_array();
                // pengembalian saldo
                $saldo_init = 0;
                if ($getRiwayat["actions"] == "setor") {
                    $pengembalian = floatval($nasabah['saldo']) - floatval($getRiwayat['jumlah_aksi']);
                    $upSaldoAwal = $this->updateSaldo([
                        "id_nasabah" => $data['id_nasabah'],
                        "saldo" => $pengembalian
                    ]);
                    $saldo_init = $pengembalian;
                } else if ($getRiwayat["actions"] == "pencairan") {
                    $upSaldoAwal = $this->updateSaldo([
                        "id_nasabah" => $data['id_nasabah'],
                        "saldo" => $nasabah['saldo']
                    ]);
                    $saldo_init = $nasabah['saldo'];
                }
                if ($upSaldoAwal['status_update']) {
                    $new_nasabah = $this->db->get_where("nasabah", ["id_nasabah" => $data['id_nasabah']])->row_array();
                    if ($data['method'] == "setor") {
                        $tambah_saldo = (float) $new_nasabah['saldo'] + (float)$data['total'];
                        $upSaldo = $this->updateSaldo([
                            "id_nasabah" => $data['id_nasabah'],
                            "saldo" => $tambah_saldo
                        ]);
                        if ($upSaldo['status_update']) {
                            $riwayat =  $this->riwayat_update([
                                "id_nasabah"    => $data['id_nasabah'],
                                "jumlah_aksi"   => $data['total'],
                                "saldo"         => $new_nasabah['saldo'],
                                "saldo_akhir"   => $this->db->get_where("nasabah", ["id_nasabah" => $data['id_nasabah']])->row_array()['saldo'],
                                "msg"           => "penambahan saldo penjualan sampah",
                                "tbl_action"    => "transaksi"
                            ], $getTr['riwayat_id']);
                            if (!empty($riwayat['id_riwayat'])) {

                                $main = [
                                    "id_bank" => auth()["user"]["id_bank_sampah"],
                                    "id_nasabah" => $data['id_nasabah'],
                                    "id_user_petugas" => auth()["user"]["id"],
                                    "tanggal" => date("Y-m-d"),
                                    "jam" => date("H:i:s"),
                                    "kode_jenis_sampah" => $data['kode_jenis_sampah'],
                                    "jenis_sampah" => $data['jenis_sampah'],
                                    "kode_barang"  => $data['kode_barang'],
                                    "nama_barang"  => $data['nama_barang'],
                                    "jenis_sampah" => $data['jenis_sampah'],
                                    "berat" => $data['berat'],
                                    "satuan" => $data['satuan'],
                                    "harga" => $data['harga'],
                                    "total" => $data['total'],
                                    "riwayat_id" => $getTr['riwayat_id'],
                                    "method" => $data['method'],
                                ];
                                $action = $this->db->update("transaksi", $main, ["id_transaksi" => $data['id_transaksi']]);

                                if ($action) {
                                    $this->session->set_flashdata("success", "Transaksi berhasil");
                                    redirect("Transaksi/index");
                                } else {
                                    $upSaldoAwal = $this->updateSaldo([
                                        "id_nasabah" => $data['id_nasabah'],
                                        "saldo" => $getRiwayat['saldo_akhir']
                                    ]);
                                    unset($getRiwayat['riwayat_id']);
                                    $this->db->update("riwayat_saldo", $getRiwayat, ["id_riwayat" => $getTr['riwayat_id']]);
                                    $this->session->set_flashdata("error", "Transaksi gagal");
                                    redirect("Transaksi/index");
                                }
                            } else {
                                $upSaldoAwal = $this->updateSaldo([
                                    "id_nasabah" => $data['id_nasabah'],
                                    "saldo" => $getRiwayat['saldo_akhir']
                                ]);
                                $this->session->set_flashdata("error", "Transaksi gagal");
                                redirect("Transaksi/index");
                            }
                        } else {
                            $this->session->set_flashdata("error", "Transaksi gagal");
                            redirect("Transaksi/index");
                        }
                    } else if ($data['method'] == "tarik") {
                        $riwayat =  $this->riwayat_update([
                            "id_nasabah"    => $data['id_nasabah'],
                            "jumlah_aksi"   => $data['total'],
                            "saldo"         =>  $saldo_init,
                            "saldo_akhir"   => $this->db->get_where("nasabah", ["id_nasabah" => $data['id_nasabah']])->row_array()['saldo'],
                            "msg"           => "Pencairan langsung",
                            "actions"       => "pencairan",
                            "tbl_action"    => "transaksi"
                        ], $getTr['riwayat_id']);
                        if (!empty($riwayat['id_riwayat'])) {
                            $main = [
                                "id_bank" => auth()["user"]["id_bank_sampah"],
                                "id_nasabah" => $data['id_nasabah'],
                                "id_user_petugas" => auth()["user"]["id"],
                                "tanggal" => date("Y-m-d"),
                                "jam" => date("H:i:s"),
                                "kode_jenis_sampah" => $data['kode_jenis_sampah'],
                                "jenis_sampah" => $data['jenis_sampah'],
                                "kode_barang"  => $data['kode_barang'],
                                "nama_barang"  => $data['nama_barang'],
                                "jenis_sampah" => $data['jenis_sampah'],
                                "berat" => $data['berat'],
                                "satuan" => $data['satuan'],
                                "harga" => $data['harga'],
                                "total" => $data['total'],
                                "riwayat_id" => $getTr['riwayat_id'],
                                "method" => $data['method'],
                            ];
                            $action = $this->db->update("transaksi", $main, ["id_transaksi" => $data['id_transaksi']]);

                            if ($action) {
                                $this->session->set_flashdata("success", "Transaksi berhasil");
                                redirect("Transaksi/index");
                            } else {
                                $upSaldoAwal = $this->updateSaldo([
                                    "id_nasabah" => $data['id_nasabah'],
                                    "saldo" => $getRiwayat['saldo_akhir']
                                ]);
                                unset($getRiwayat['riwayat_id']);
                                $this->db->update("riwayat_saldo", $getRiwayat, ["id_riwayat" => $getTr['riwayat_id']]);
                                $this->session->set_flashdata("error", "Transaksi gagal");
                                // redirect("Transaksi/index");
                            }
                        } else {
                            $this->session->set_flashdata("error", "Transaksi gagal");
                            redirect("Transaksi/index");
                        }
                    }
                } else {
                    $this->session->set_flashdata("error", "Transaksi gagal");
                    redirect("Transaksi/index");
                }
            } else {
                if ($data['method'] == 'setor') {
                    $tambah_saldo = (float) $nasabah['saldo'] + (float)$data['total'];
                    $upSaldo = $this->updateSaldo([
                        "id_nasabah" => $data['id_nasabah'],
                        "saldo" => $tambah_saldo
                    ]);
                    if ($upSaldo['status_update']) {
                        $riwayat =  $this->riwayat([
                            "id_nasabah"    => $data['id_nasabah'],
                            "jumlah_aksi"   => $data['total'],
                            "saldo"         => $nasabah['saldo'],
                            "saldo_akhir"   => $this->db->get_where("nasabah", ["id_nasabah" => $data['id_nasabah']])->row_array()['saldo'],
                            "msg"           => "penambahan saldo penjualan sampah",
                            "tbl_action"    => "transaksi",
                        ]);
                        if (!empty($riwayat['id_riwayat'])) {
                            $main = [
                                "id_bank" => auth()["user"]["id_bank_sampah"],
                                "id_nasabah" => $data['id_nasabah'],
                                "id_user_petugas" => auth()["user"]["id"],
                                "tanggal" => date("Y-m-d"),
                                "jam" => date("H:i:s"),
                                "kode_jenis_sampah" => $data['kode_jenis_sampah'],
                                "jenis_sampah" => $data['jenis_sampah'],
                                "kode_barang"  => $data['kode_barang'],
                                "nama_barang"  => $data['nama_barang'],
                                "berat" => $data['berat'],
                                "satuan" => $data['satuan'],
                                "harga" => $data['harga'],
                                "total" => $data['total'],
                                "riwayat_id" => $riwayat['id_riwayat'],
                                "method" => $data['method'],
                                "created_at" => date("Y-m-d H:i:s")
                            ];
                            $action = $this->db->insert("transaksi", $main);
                            if ($action) {

                                $this->session->set_flashdata("success", "Transaksi berhasil");
                                redirect("Transaksi/index");
                            } else {
                                $upSaldo = $this->updateSaldo([
                                    "id_nasabah" => $data['id_nasabah'],
                                    "saldo" => $nasabah['saldo']
                                ]);
                                $this->db->delete("riwayat_saldo", ["id_riwayat" => $riwayat['id_riwayat']]);
                                $this->session->set_flashdata("error", "Transaksi gagal");
                                redirect("Transaksi/index");
                            }
                        } else {
                            $upSaldo = $this->updateSaldo([
                                "id_nasabah" => $data['id_nasabah'],
                                "saldo" => $nasabah['saldo']
                            ]);
                            $this->session->set_flashdata("error", "Transaksi gagal");
                            redirect("Transaksi/index");
                        }
                    } else {
                        $this->session->set_flashdata("error", "Transaksi gagal");
                        redirect("Transaksi/index");
                    }
                } else {
                    $riwayat =  $this->riwayat([
                        "id_nasabah"    => $data['id_nasabah'],
                        "jumlah_aksi"   => $data['total'],
                        "saldo"         => $nasabah['saldo'],
                        "saldo_akhir"   => $this->db->get_where("nasabah", ["id_nasabah" => $data['id_nasabah']])->row_array()['saldo'],
                        "msg"           => "Pencairan langsung",
                        "actions"       => "pencairan",
                        "tbl_action"    => "transaksi"
                    ]);
                    if (!empty($riwayat['id_riwayat'])) {
                        $main = [
                            "id_bank" => auth()["user"]["id_bank_sampah"],
                            "id_nasabah" => $data['id_nasabah'],
                            "id_user_petugas" => auth()["user"]["id"],
                            "tanggal" => date("Y-m-d"),
                            "jam" => date("H:i:s"),
                            "kode_jenis_sampah" => $data['kode_jenis_sampah'],
                            "jenis_sampah" => $data['jenis_sampah'],
                            "kode_barang"  => $data['kode_barang'],
                            "nama_barang"  => $data['nama_barang'],
                            "jenis_sampah" => $data['jenis_sampah'],
                            "berat" => $data['berat'],
                            "satuan" => $data['satuan'],
                            "harga" => $data['harga'],
                            "total" => $data['total'],
                            "riwayat_id" => $riwayat['id_riwayat'],
                            "method" => $data['method'],
                            "created_at" => date("Y-m-d H:i:s")
                        ];
                        $action = $this->db->insert("transaksi", $main);
                        if ($action) {
                            $this->session->set_flashdata("success", "Transaksi berhasil");
                            redirect("Transaksi/index");
                        } else {
                            $this->db->delete("riwayat_saldo", ["id_riwayat" => $riwayat['id_riwayat']]);
                            $this->session->set_flashdata("error", "Transaksi gagal");
                            redirect("Transaksi/index");
                        }
                    } else {
                        $this->session->set_flashdata("error", "Transaksi gagal");
                        redirect("Transaksi/index");
                    }
                }
            }
        } else {
            $this->session->set_flashdata("error", "Inputan tidak valid");
            redirect("Transaksi/index");
        }
    }

    public function batalTransaksi($id_transaksi)
    {
        $getTr = $this->db->get_where("transaksi", ["id_transaksi" => $id_transaksi])->row_array();
        $getRiwayat = $this->db->get_where("riwayat_saldo", ["id_riwayat" => $getTr['riwayat_id']])->row_array();

        if ($getTr['method'] == "setor") {
            $upSaldo = $this->updateSaldo([
                "id_nasabah" => $getTr['id_nasabah'],
                "saldo" => $getRiwayat['saldo_awal']
            ]);
            if ($upSaldo['status_update']) {

                $_ = $this->db->delete("riwayat_saldo", ["id_riwayat" => $getTr['riwayat_id']]);
                $__ = $this->db->delete("transaksi", ["id_transaksi" => $id_transaksi]);
                if ($__) {
                    $this->session->set_flashdata("success", "Berhasil dibatalkan");
                    redirect("Transaksi/index");
                } else {
                    $upSaldo = $this->updateSaldo([
                        "id_nasabah" => $getTr['id_nasabah'],
                        "saldo" => $getRiwayat['saldo_akhir']
                    ]);
                    $this->session->set_flashdata("error", "Gagal dibatalkan");
                    redirect("Transaksi/index");
                }
            } else {
                $this->session->set_flashdata("error", "Gagal dibatalkan");
                redirect("Transaksi/index");
            }
        } else {
            $_ = $this->db->delete("riwayat_saldo", ["id_riwayat" => $getTr['riwayat_id']]);
            $__ = $this->db->delete("transaksi", ["id_transaksi" => $id_transaksi]);
            if ($__) {
                $this->session->set_flashdata("success", "Berhasil dibatalkan");
                redirect("Transaksi/index");
            } else {
                $upSaldo = $this->updateSaldo([
                    "id_nasabah" => $getTr['id_nasabah'],
                    "saldo" => $getRiwayat['saldo_akhir']
                ]);
                $this->session->set_flashdata("error", "Gagal dibatalkan");
                redirect("Transaksi/index");
            }
        }
    }
    public function delete($id_transaksi)
    {
        $__ = $this->db->delete("transaksi", ["id_transaksi" => $id_transaksi]);
        if ($__) {
            $this->session->set_flashdata("success", "Berhasil dihapus");
            redirect("Transaksi/index");
        } else {
            $this->session->set_flashdata("error", "Gagal dihapus");
            redirect("Transaksi/index");
        }
    }
    public function getById()
    {
        $this->db->join("users", "users.id = transaksi.id_user_petugas");
        $this->db->join("nasabah", "nasabah.id_nasabah = transaksi.id_nasabah");
        $this->db->order_by('transaksi.tanggal', 'ASC');
        $this->db->where("transaksi.id_transaksi", $_POST['id']);
        $result = $this->db->get_where("transaksi")->row_array();
        echo json_encode($result);
    }
    public function updateSaldo($data)
    {
        $nasabah_sebelum = $this->db->get_where("nasabah", ["id_nasabah" => $data['id_nasabah']])->row_array();
        $up = $this->db->update("nasabah", ["saldo" => $data['saldo']], ["id_nasabah" => $data['id_nasabah']]);
        $nasabah_sesudah = $this->db->get_where("nasabah", ["id_nasabah" => $data['id_nasabah']])->row_array();
        return [
            "saldo_awal" => $nasabah_sebelum['saldo'],
            "status_update" => $up,
            "saldo_akhir" => $nasabah_sesudah['saldo']
        ];
    }
    public function riwayat($data)
    {
        $riwayat = [
            "id_user_bank"  => auth()["user"]["id"],
            "id_bank"   => auth()["user"]["id_bank_sampah"],
            "id_nasabah"    => $data['id_nasabah'],
            "saldo_awal"    => $data['saldo'],
            "jumlah_aksi"   => $data['jumlah_aksi'],
            "saldo_akhir"   => $data['saldo_akhir'],
            "actions"       => empty($data['actions']) ? "setor" : $data['actions'],
            "pesan" => $data['msg'],
            "tbl_action"    => $data['tbl_action'],
            "tanggal" => date("Y-m-d"),
            "jam" => date("H:i:s"),
            "tipe" => "transaksi_sampah",
            "created_at" => date("Y-m-d H:i:s")
        ];

        $this->db->insert('riwayat_saldo', $riwayat);
        $insert_id = $this->db->insert_id();
        return [
            "id_riwayat" => $insert_id,
            "data" => $riwayat,
        ];
    }
    public function riwayat_update($data, $riwayat_id)
    {
        $riwayat = [
            "id_user_bank"  => auth()["user"]["id"],
            "id_bank"   => auth()["user"]["id_bank_sampah"],
            "id_nasabah"    => $data['id_nasabah'],
            "saldo_awal"    => $data['saldo'],
            "jumlah_aksi"   => $data['jumlah_aksi'],
            "saldo_akhir"   => $data['saldo_akhir'],
            "actions"       => empty($data['actions']) ? "setor" : $data['actions'],
            "pesan" => $data['msg'],
            "tbl_action"    => $data['tbl_action'],
            "tanggal" => date("Y-m-d"),
            "jam" => date("H:i:s"),
        ];

        $update = $this->db->update('riwayat_saldo', $riwayat, ["id_riwayat" => $riwayat_id]);

        return [
            "id_riwayat" => $riwayat_id,
            "data" => $riwayat,
        ];
    }
}
