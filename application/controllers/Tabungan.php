<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Tabungan extends CI_Controller
{
    // constructor
    private $page = "Tabungan/";
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Nasabah_model');
        $this->load->library('form_validation');
    }
    public function index($id_nasabah = null)
    {
        // print_r($this->Dashboarsd($id_nasabah));
        // die();
        if (!empty($_GET['page']) && $_GET['page'] == "1") {
            $data = $this->home();
        } elseif (!empty($_GET['page']) && $_GET['page'] == "detail") {
            $data = $this->detail($id_nasabah);
        }
        $this->load->view('Router/route', $data);
    }
    public function home()
    {
        $data = [
            "title" => "Tabungan",
            "page" => $this->page . "index",
            "script" => $this->page . "script",
            "nasabah" => $this->Nasabah_model->getAll()
        ];
        return $data;
    }
    public function detail($id_nasabah = null)
    {
        $nasabah = $this->db->get_where("nasabah", [
            "id_nasabah" => $id_nasabah
        ])->row_array();
        if (empty($nasabah)) {
            redirect("Tabungan/index?page=1");
        }
        $data = [
            "title" => "Buku Tabungan",
            "page" => $this->page . "detail",
            "script" => $this->page . "script",
            "nasabah" => $this->db->get_where("nasabah", ["id_nasabah" => $id_nasabah])->row_array(),
            "riwayat" => $this->getRiwayatSaldo($id_nasabah),
            "buku_tabungan" => $this->getRiwayat($id_nasabah),
            "transaksi" => $this->getTransaksi($id_nasabah),
            "chartSaldo" => json_encode($this->Dashboarsd($id_nasabah))
        ];
        return $data;
    }
    public function buku_tabungan_counter($id_nasabah = null)
    {
        $this->db->order_by("created_at", "DESC");
        $riwayat = $this->db->get_where("riwayat_saldo", [
            "id_bank" => auth()["user"]["id_bank_sampah"],
            "id_nasabah" => $id_nasabah
        ])->result_array();
        $res = [];
        // foreach ($riwayat as $v) {
        //     if ($v['actions'] == 'setor') {
        //         $res[$v['tanggal']]['setor'][] = $v;
        //     } else
        //     if ($v['actions'] == 'tarik' || $v['actions'] == 'pencairan') {
        //         $res[$v['tanggal']]['tarik'][] = $v;
        //     } else
        //     if ($v['actions'] == 'batal') {
        //         $res[$v['tanggal']]['batal'][] = $v;
        //     }
        // }
        $result = array_reduce($riwayat, function ($carry, $item) {
            if (!isset($carry[$item['tanggal']])) {
                $set = 0;
                $tar = 0;
                $penc = 0;
                if ($item['actions'] == "setor") {
                    $set = $item['jumlah_aksi'];
                } else if ($item['actions'] == 'tarik') {
                    $tar = $item['jumlah_aksi'];
                } elseif ($item['actions'] == 'pencairan') {
                    $penc = $item['jumlah_aksi'];
                }
                $carry[$item['tanggal']] = [
                    'tanggal' => $item['tanggal'],
                    'setor' => $set,
                    'tarik' => $tar,
                    'pencairan' => $penc,
                    'saldo' => $item['saldo_akhir']
                ];
            } else {
                if ($item['actions'] == "setor") {
                    $carry[$item['tanggal']]['setor'] += $item['jumlah_aksi'];
                    $carry[$item['tanggal']]['saldo'] += $item['jumlah_aksi'];
                } else if ($item['actions'] == "tarik") {
                    $carry[$item['tanggal']]['tarik'] += $item['jumlah_aksi'];
                    $carry[$item['tanggal']]['saldo'] -= $item['jumlah_aksi'];
                } else if ($item['actions'] == 'pencairan') {
                    $carry[$item['tanggal']]['pencairan'] += $item['jumlah_aksi'];
                }
            }
            return $carry;
        });
        $arr = array_values($result);
        echo json_encode($res);
    }
    public function Dashboarsd($id_nasabah = null)
    {
        $this->db->where("id_bank", auth()["user"]["id_bank_sampah"]);
        $nasabah = $this->db->get_where("nasabah", [
            "id_nasabah" => $id_nasabah
        ])->row_array();

        $st_date = $nasabah['tanggal'];
        $ed_date = date("Y-m-d");
        $dates = range(strtotime($st_date), strtotime($ed_date), 86400);
        $range_of_dates = array_map(function ($x) {
            return date('Y-m-d', $x);
        }, $dates);
        $mapSaldo = [];
        $tanggal = [];
        $sal = 0;
        foreach ($range_of_dates as $key => $value) {
            $riwayat = $this->getRiwayat($id_nasabah);
            $saldo = 0;
            foreach ($riwayat as $v) {
                if ($v['tanggal'] == $value) {
                    $saldo = $v['saldo'];
                    $sal = $v['saldo'];
                } else {
                    $saldo = $sal;
                }
            }
            array_push($tanggal, $value);
            array_push($mapSaldo, $saldo);
        }

        return [
            "tanggal" => $tanggal,
            "saldo" => $mapSaldo
        ];
    }
    public function getTransaksi($id_nasabah = null)
    {
        $this->db->select("*, transaksi.tanggal as tanggal, riwayat_saldo.tanggal as tgl_riwayat");
        $this->db->join("users", "users.id = transaksi.id_user_petugas");
        $this->db->join("nasabah", "nasabah.id_nasabah = transaksi.id_nasabah");
        $this->db->join("riwayat_saldo", "riwayat_saldo.id_riwayat  = transaksi.riwayat_id");
        $this->db->where("transaksi.id_bank", auth()["user"]["id_bank_sampah"]);
        $this->db->where("transaksi.id_nasabah", $id_nasabah);
        $this->db->order_by('transaksi.id_transaksi ', 'DESC');
        $result = $this->db->get_where("transaksi")->result_array();
        return $result;
    }
    public function getRiwayat($id_nasabah)
    {
        $riwayat = $this->db->get_where("riwayat_saldo", [
            "id_bank" => auth()["user"]["id_bank_sampah"],
            "id_nasabah" => $id_nasabah,
        ])->result_array();
        if (!empty($riwayat)) {
            $result = array_reduce($riwayat, function ($carry, $item) {
                if (!isset($carry[$item['tanggal']])) {
                    $set = 0;
                    $tar = 0;
                    $penc = 0;
                    if ($item['actions'] == "setor") {
                        $set = $item['jumlah_aksi'];
                    } else if ($item['actions'] == 'tarik') {
                        $tar = $item['jumlah_aksi'];
                    } elseif ($item['actions'] == 'pencairan') {
                        $penc = $item['jumlah_aksi'];
                    }
                    $carry[$item['tanggal']] = [
                        'tanggal' => $item['tanggal'],
                        'setor' => $set,
                        'tarik' => $tar,
                        'pencairan' => $penc,
                        'saldo' => $item['saldo_akhir']
                    ];
                } else {
                    if ($item['actions'] == "setor") {
                        $carry[$item['tanggal']]['setor'] += $item['jumlah_aksi'];
                        $carry[$item['tanggal']]['saldo'] += $item['jumlah_aksi'];
                    } else if ($item['actions'] == "tarik") {
                        $carry[$item['tanggal']]['tarik'] += $item['jumlah_aksi'];
                        $carry[$item['tanggal']]['saldo'] -= $item['jumlah_aksi'];
                    } else if ($item['actions'] == 'pencairan') {
                        $carry[$item['tanggal']]['pencairan'] += $item['jumlah_aksi'];
                    }
                }
                return $carry;
            });
            $arr = array_values($result);
            return $arr;
        } else {
            return [];
        }
    }
    public function getRiwayatSaldo($id_nasabah)
    {
        $this->db->order_by('id_riwayat', 'DESC');
        $riwayat = $this->db->get_where("riwayat_saldo", ["id_bank" => auth()["user"]["id_bank_sampah"], "id_nasabah" => $id_nasabah])->result_array();
        return ($riwayat);
    }
    public function cek_saldo($id_nasabah)
    {
    }
    public function tarik_dana()
    {
        $data = $this->input->post();
        if (empty(auth()["user"]["id_bank_sampah"])) {
            redirect("Login");
        }
        $this->form_validation->set_rules('id_nasabah', 'id_nasabah', 'required');
        $this->form_validation->set_rules('jumlah_aksi', 'jumlah_aksi', 'required');
        $this->form_validation->set_rules('pin', 'pin', 'required');
        if ($this->form_validation->run() != false) {
            $auth = $this->db->get_where("users", ["pin" => $data['pin'], "role !=" => "NASABAH"])->num_rows();
            if ($auth) {
                $nasabah = $this->db->get_where("nasabah", ["id_nasabah" => $data['id_nasabah']])->row_array();
                if ((float)$data['jumlah_aksi'] <= (float) $nasabah['saldo']) {
                    $kurangi_saldo = (float) $nasabah['saldo'] - (float)$data['jumlah_aksi'];
                    $upSaldo = $this->updateSaldo([
                        "id_nasabah" => $data['id_nasabah'],
                        "saldo" => $kurangi_saldo
                    ]);
                    if ($upSaldo['status_update']) {
                        $riwayat =  $this->riwayat([
                            "id_nasabah"    => $data['id_nasabah'],
                            "jumlah_aksi"   => $data['jumlah_aksi'],
                            "saldo"         => $nasabah['saldo'],
                            "saldo_akhir"   => $this->db->get_where("nasabah", ["id_nasabah" => $data['id_nasabah']])->row_array()['saldo'],
                            "msg"           => "Penarikan Dana",
                            "actions"       => "tarik",
                            "tbl_action"    => "",
                            "tipe" => "penarikan"
                        ]);
                        if ($riwayat["id_riwayat"]) {
                            echo json_encode([
                                "response" => "berhasil",
                                "msg" => "Pencairan dana berhasil",
                                "status" => true,
                                "nasabah" => $this->db->get_where("nasabah", ["id_nasabah" => $data['id_nasabah']])->row_array(),
                                "riwayat" => $riwayat['data']
                            ]);
                        } else {
                            $upSaldo = $this->updateSaldo([
                                "id_nasabah" => $data['id_nasabah'],
                                "saldo" => $nasabah['saldo']
                            ]);
                            echo json_encode([
                                "response" => "gagal",
                                "msg" => "gagal pencairan",
                                "status" => false
                            ]);
                        }
                    }
                } else {
                    echo json_encode([
                        "response" => "gagal",
                        "msg" => "saldo anda kurang",
                        "status" => false
                    ]);
                }
            } else {
                echo json_encode([
                    "response" => "gagal",
                    "msg" => "pin salah",
                    "status" => false
                ]);
            }
        } else {
            echo json_encode([
                "response" => "gagal",
                "msg" => "inputan tidak boleh kosong",
                "status" => false
            ]);
        }
    }
    public function setor_dana()
    {
        $data = $this->input->post();
        if (empty(auth()["user"]["id_bank_sampah"])) {
            redirect("Login");
        }
        $this->form_validation->set_rules('id_nasabah', 'id_nasabah', 'required');
        $this->form_validation->set_rules('jumlah_aksi', 'jumlah_aksi', 'required');
        $this->form_validation->set_rules('pin', 'pin', 'required');
        if ($this->form_validation->run() != false) {

            $auth = $this->db->get_where("users", ["pin" => $data['pin'], "role !=" => "NASABAH"])->num_rows();
            if ($auth) {
                $nasabah = $this->db->get_where("nasabah", ["id_nasabah" => $data['id_nasabah']])->row_array();
                if ((float)$data['jumlah_aksi'] > 0) {
                    $tambah_saldo = (float) $nasabah['saldo'] + (float)$data['jumlah_aksi'];
                    $upSaldo = $this->updateSaldo([
                        "id_nasabah" => $data['id_nasabah'],
                        "saldo" => $tambah_saldo
                    ]);
                    if ($upSaldo['status_update']) {
                        $riwayat =  $this->riwayat([
                            "id_nasabah"    => $data['id_nasabah'],
                            "jumlah_aksi"   => $data['jumlah_aksi'],
                            "saldo"         => $nasabah['saldo'],
                            "saldo_akhir"   => $this->db->get_where("nasabah", ["id_nasabah" => $data['id_nasabah']])->row_array()['saldo'],
                            "msg"           => "Setor Dana Tunai",
                            "actions"       => "setor",
                            "tbl_action"    => "",
                            "tipe" => "setor_tunai"
                        ]);
                        if ($riwayat["id_riwayat"]) {
                            echo json_encode([
                                "response" => "berhasil",
                                "msg" => "Dana berhasil disetor",
                                "status" => true,
                                "nasabah" => $this->db->get_where("nasabah", ["id_nasabah" => $data['id_nasabah']])->row_array(),
                                "riwayat" => $riwayat['data']
                            ]);
                        } else {
                            $upSaldo = $this->updateSaldo([
                                "id_nasabah" => $data['id_nasabah'],
                                "saldo" => $nasabah['saldo']
                            ]);
                            echo json_encode([
                                "response" => "gagal",
                                "msg" => "gagal setor",
                                "status" => false
                            ]);
                        }
                    }
                } else {
                    echo json_encode([
                        "response" => "gagal",
                        "msg" => "saldo anda kurang",
                        "status" => false
                    ]);
                }
            } else {
                echo json_encode([
                    "response" => "gagal",
                    "msg" => "pin salah",
                    "status" => false
                ]);
            }
        } else {
            echo json_encode([
                "response" => "gagal",
                "msg" => "inputan tidak boleh kosong",
                "status" => false
            ]);
        }
    }
    public function batalTransaksi()
    {
        $data = $this->input->post();
        if (empty(auth()["user"]["id_bank_sampah"])) {
            redirect("Login");
        }
        $this->form_validation->set_rules('id_nasabah', 'id_nasabah', 'required');
        $this->form_validation->set_rules('id_riwayat', 'id_riwayat', 'required');
        $this->form_validation->set_rules('pin', 'pin', 'required');
        if ($this->form_validation->run() != false) {

            $auth = $this->db->get_where("users", ["pin" => $data['pin'], "role !=" => "NASABAH"])->num_rows();
            if ($auth) {
                $getRiwayat = $this->db->get_where("riwayat_saldo", ["id_riwayat" => $data['id_riwayat']])->row_array();
                $nasabah = $this->db->get_where("nasabah", ["id_nasabah" => $data['id_nasabah']])->row_array();
                $total = 0;
                $msg = "";
                if ($getRiwayat['actions'] == "tarik") {
                    $total = $nasabah['saldo'] + $getRiwayat['jumlah_aksi'];
                    $msg = "penarikan";
                } else if ($getRiwayat['actions'] == "setor") {
                    $total = $nasabah['saldo'] - $getRiwayat['jumlah_aksi'];
                    $msg = "setor";
                }
                $upSaldo = $this->updateSaldo([
                    "id_nasabah" => $data['id_nasabah'],
                    "saldo" => $total
                ]);
                if ($upSaldo['status_update']) {
                    $delRiwayat = $this->db->update("riwayat_saldo", ["actions" => "batal"], ["id_riwayat" => $data['id_riwayat']]);
                    if ($delRiwayat) {
                        echo json_encode([
                            "response" => "berhasil",
                            "msg" => "Dana berhasil dibatalkan",
                            "status" => true,
                            "nasabah" => $this->db->get_where("nasabah", ["id_nasabah" => $data['id_nasabah']])->row_array(),
                        ]);
                    } else {
                        $upSaldo = $this->updateSaldo([
                            "id_nasabah" => $data['id_nasabah'],
                            "saldo" => $nasabah['saldo']
                        ]);
                        echo json_encode([
                            "response" => "gagal",
                            "msg" => "gagal dibatalkan",
                            "status" => false
                        ]);
                    }
                }
            }
        } else {
            echo json_encode([
                "response" => "gagal",
                "msg" => "inputan tidak boleh kosong",
                "status" => false
            ]);
        }
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
            "actions"       => $data["actions"],
            "pesan" => $data['msg'],
            "tbl_action"    => $data['tbl_action'],
            "tanggal" => date("Y-m-d"),
            "jam" => date("H:i:s"),
            "tipe" => $data['tipe'],
            "created_at" => date("Y-m-d H:i:s")
        ];

        $this->db->insert('riwayat_saldo', $riwayat);
        $insert_id = $this->db->insert_id();
        return [
            "id_riwayat" => $insert_id,
            "data" => $riwayat,
        ];
    }
}
