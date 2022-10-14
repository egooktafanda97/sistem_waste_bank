<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Keuangan extends CI_Controller
{
    // constructor
    private $page = "Keuangan/";
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Nasabah_model');
        $this->load->library('form_validation');

        if (!auth()["user"]["id_bank_sampah"]) {
            redirect("Login");
        }
    }
    public function index($search = null)
    {
        $data = [
            "title" => "Keuangan Bank",
            "page" => $this->page . "index.php",
            "script" => $this->page . "script_index",
            "main" => $this->getData($search)
        ];
        $this->load->view('Router/route', $data);
    }
    public function getData($bln = null)
    {
        $bulan = $bln != null ? $bln : date("Y-m");
        $this->db->order_by("id_keuangan", "DESC");
        $this->db->like("tanggal", $bulan, 'both');
        $this->db->where("id_bank", auth()["user"]["id_bank_sampah"]);
        $data = $this->db->get_where("keuangan")->result_array();
        return $data;
    }
    public function data_keuangan($bln = null)
    {

        $bulan = $bln != null ? $bln : date("Y-m");
        $this->db->order_by("id_keuangan", "DESC");
        $this->db->like("tanggal", $bulan, 'both');
        $this->db->where("id_bank", auth()["user"]["id_bank_sampah"]);
        $data = $this->db->get_where("keuangan")->result_array();
        echo json_encode($data);
    }
    public function action_keuangan()
    {
        $req = $_POST;

        $this->form_validation->set_rules('jenis_transaksi', 'jenis_transaksi', 'required');
        $this->form_validation->set_rules('tanggal', 'tanggal', 'required');
        $this->form_validation->set_rules('masuk', 'masuk', 'required');
        $this->form_validation->set_rules('keluar', 'keluar', 'required');

        if ($this->form_validation->run() != false) {
            if (!empty($req['id_keuangan']) && $req['id_keuangan'] != "" && $req['id_keuangan'] != null) {
                $getbank = $this->db->get_where("bank_sampah", ["id_bank_sampah" => auth()["user"]["id_bank_sampah"]])->row_array();

                $getKeaungan = $this->db->get_where("keuangan", ["id_keuangan" => $req['id_keuangan'], "id_bank" => auth()["user"]["id_bank_sampah"]])->row_array();

                $saldo = (floatval($getbank['saldo']) - floatval($getKeaungan['masuk'])) + floatval($getKeaungan['keluar']);

                $reset_saldo = $this->db->update("bank_sampah", ["saldo" => $saldo], ["id_bank_sampah" => auth()["user"]["id_bank_sampah"]]);
                if ($reset_saldo) {
                    $getbank = $this->db->get_where("bank_sampah", ["id_bank_sampah" => auth()["user"]["id_bank_sampah"]])->row_array();
                    $this->db->select("sum(saldo) as total_saldo");
                    $saldo_nasabah = $this->db->get_where("nasabah", ["id_bank" => auth()["user"]["id_bank_sampah"]])->row_array();
                    $total = floatval($getbank['saldo']) + floatval($getbank['kas']);
                    $saldo_akhir = ($total + floatval($req['masuk'])) - floatval($req['keluar']);
                    $upSaldo = $this->db->update("bank_sampah", ["saldo" => $saldo_akhir], ["id_bank_sampah" => auth()["user"]["id_bank_sampah"]]);

                    $data = [
                        "id_bank" =>  auth()["user"]["id_bank_sampah"],
                        "user_entry" => auth()["user"]["id"],
                        "tanggal" => $req['tanggal'],
                        "jenis_transaksi" =>  $req['jenis_transaksi'],
                        "masuk" =>  $req['masuk'],
                        "keluar" => $req['keluar'],
                        "saldo_awal" => $total,
                        "saldo" =>  $saldo_akhir,
                        "saldo_nasabah" => $saldo_nasabah['total_saldo'],
                        "tipe" =>  "-",
                        "jam" =>   date("H:i:s"),
                        "create_at" =>  date("Y-m-d H:i:s"),
                    ];

                    $save = $this->db->update("keuangan", $data, ["id_keuangan" => $req['id_keuangan'], "id_bank" => auth()["user"]["id_bank_sampah"]]);
                    if ($save) {
                        $this->session->set_flashdata("success", "berhasil diubah");
                        redirect("Keuangan/index");
                    } else {
                        $this->session->set_flashdata("error", "gagal diubah");
                        redirect("Keuangan/index");
                    }
                }
            } else {
                $getbank = $this->db->get_where("bank_sampah", ["id_bank_sampah" => auth()["user"]["id_bank_sampah"]])->row_array();
                $this->db->select("sum(saldo) as total_saldo");
                $saldo_nasabah = $this->db->get_where("nasabah", ["id_bank" => auth()["user"]["id_bank_sampah"]])->row_array();
                $total = floatval($getbank['saldo']) + floatval($getbank['kas']);
                $saldo_akhir = ($total + floatval($req['masuk'])) - floatval($req['keluar']);

                $upSaldo = $this->db->update("bank_sampah", ["saldo" => $saldo_akhir], ["id_bank_sampah" => auth()["user"]["id_bank_sampah"]]);
                if ($upSaldo) :
                    $data = [
                        "id_bank" =>  auth()["user"]["id_bank_sampah"],
                        "user_entry" => auth()["user"]["id"],
                        "tanggal" => $req['tanggal'],
                        "jenis_transaksi" =>  $req['jenis_transaksi'],
                        "masuk" =>  $req['masuk'],
                        "keluar" => $req['keluar'],
                        "saldo_awal" => $total,
                        "saldo" =>  $saldo_akhir,
                        "saldo_nasabah" => $saldo_nasabah['total_saldo'],
                        "tipe" =>  "-",
                        "jam" =>   date("H:i:s"),
                        "create_at" =>  date("Y-m-d H:i:s"),
                    ];
                    $save = $this->db->insert("keuangan", $data);
                    if ($save) {
                        $this->session->set_flashdata("success", "berhasil ditambahkan");
                        redirect("Keuangan/index");
                    } else {
                        $this->session->set_flashdata("error", "gagal ditambahkan");
                        redirect("Keuangan/index");
                    }
                else :
                    $this->session->set_flashdata("error", "gagal ditambahkan");
                    redirect("Keuangan/index");
                endif;
            }
        } else {
            $this->session->set_flashdata("error", "gagal ditambahkan");
            redirect("Keuangan/index");
        }
    }
    public function catatan_bulanan()
    {
        $data = [
            "title" => "Pencatatan Bulanan",
            "page" => $this->page . "c__bulanan.php",
            "script" => $this->page . "script",
            "rekap" => $this->getTransaksi(),
            "jenis_sampah" => $this->jenis_sampah(),
        ];
        $this->load->view('Router/route', $data);
    }
    public function jenis_sampah()
    {
        $this->db->where("id_bank", auth()["user"]["id_bank_sampah"]);
        $ck = $this->db->get_where("jenis_sampah")->result_array();
        return $ck;
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
        if (!empty($_GET['tanggal']) && $_GET['tanggal'] != "") {
            $this->db->like('transaksi.tanggal', $_GET['tanggal'], 'both');
        } else {
            $this->db->like('transaksi.tanggal', date("Y-m"), 'both');
        }
        $this->db->order_by('transaksi.id_transaksi', 'DESC');
        $result = $this->db->get_where("transaksi")->result_array();
        if (!empty($result) && $result != null) {
            $result = array_reduce($result, function ($carry, $item) {
                $carry[$item['tanggal']][] = $item;
                return $carry;
            });
            $r = [];
            $tr_bool = false;
            foreach ($result as $key => $value) {
                $in = 0;
                $total_kilo = array_sum(array_column($value, 'berat'));
                $tr_bool = !$tr_bool;
                foreach ($value as $y => $vv) {
                    $__ = $vv + [
                        "index" => $in,
                        "rowspan" => count($value),
                        "total_berat" => $total_kilo,
                        "bg"   => $tr_bool
                    ];
                    array_push($r, $__);
                    $in++;
                }
            }

            return $r;
        } else {
            return [];
        }
    }
    public function getDataJenisBySearch($_tgl = null)
    {

        $tahun =  date('Y');
        $bulan = date('m');

        if ($_tgl != null) {
            $ex = explode("-", $_tgl);
            $tahun = $ex[0];
            $bulan = $ex[1];
        }

        $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $tg = [];
        for ($i = 1; $i < $tanggal + 1; $i++) {
            array_push($tg, $tahun . "-" . $bulan . "-" . $i);
        }
        $results = [];
        $jenis_default = $this->db->get_where("jenis_sampah")->row_array();

        if (!empty($_GET['jenis']) && $_GET['jenis'] != "") {
            $this->db->where("kode", $_GET['jenis']);
        } else {
            $this->db->where("kode", $jenis_default['kode']);
        }
        $getJenisBySearch = $this->db->get_where("jenis_sampah")->row_array();

        $this->db->join("jenis_sampah", "jenis_sampah.kode = sampah.kode_jenis_sampah");
        $this->db->where("kode", $getJenisBySearch['kode']);
        $sampah = $this->db->get_where("sampah")->result_array();



        $results = [];
        foreach ($tg as  $tanggal) {
            $ress = [];
            foreach ($sampah as $ky => $va) {
                $this->db->select("*, transaksi.tanggal as tanggal,transaksi.id_transaksi as id_transaksi");
                $this->db->join("riwayat_saldo", "riwayat_saldo.id_riwayat  = transaksi.riwayat_id");
                $this->db->where("transaksi.id_bank", auth()["user"]["id_bank_sampah"]);
                $this->db->where('transaksi.tanggal', $tanggal);
                $this->db->where('transaksi.kode_barang', $va['kode_sampah']);
                $this->db->order_by('transaksi.id_transaksi', 'DESC');
                $r = $this->db->get_where("transaksi")->result_array();
                $ress[] = [
                    "tanggal" => $tanggal,
                    "kode_jenis_sampah" => $va['kode_jenis_sampah'],
                    "jenis_sampah" => $va['jenis'],
                    "kode_sampah"  => $va['kode_sampah'],
                    "nama_barang"  => $va['nama_barang'],
                    "total_berat"  => array_sum(array_column($r, 'berat')),
                    "satuan"       => $va['satuan'],
                    "harga"        => $va['harga'],
                    "total"        => array_sum(array_column($r, 'total')),
                ];
            }
            array_push($results, $ress);
        }

        echo json_encode([
            "header" => $sampah,
            "result" => $results
        ]);
    }
    public function getById()
    {
        $req = $this->input->post();
        $this->db->where("id_keuangan", $req['id']);
        $data = $this->db->get_where("keuangan")->row_array();
        echo json_encode($data);
    }
    public function chartLineSaldo($bln = null)
    {
        $tahun = date('Y');
        $bulan = date('m');

        if ($bln != null) {
            $ex = explode("-", $bln);
            $tahun = $ex[0];
            $bulan = $ex[1];
        }

        $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $tg = [];
        for ($i = 1; $i < $tanggal + 1; $i++) {
            $__tgl = $i < 10 ? "0" . $i : $i;
            if ($tahun . "-" . $bulan . "-" . $__tgl <= date("Y-m-d")) {
                array_push($tg, $tahun . "-" . $bulan . "-" . $__tgl);
            }
        }
        $results = [];
        foreach ($tg as  $tanggal) {

            $this->db->where("tanggal", $tanggal, 'both');
            $this->db->where("id_bank", auth()["user"]["id_bank_sampah"]);
            $this->db->order_by("id_keuangan", "DESC");
            $data = $this->db->get_where("keuangan")->result_array();
            $saldo = 0;
            $masuk = 0;
            $keluar = 0;
            foreach ($data as $sumarry) {
                $saldo = floatval($sumarry['saldo']);
                $masuk += floatval($sumarry['masuk']);
                $keluar += floatval($sumarry['keluar']);
            }
            @$data = [
                "tanggal" => $tanggal,
                "saldo" => $saldo ?? 0,
                "masuk" => $masuk ?? 0,
                "keluar" => $keluar ?? 0
            ];
            array_push($results, $data);
        }
        echo json_encode($results);
    }
}
