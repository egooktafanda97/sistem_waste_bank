<?php

use function PHPSTORM_META\map;

defined('BASEPATH') or exit('No direct script access allowed');

class RekapAdmin extends CI_Controller
{
    // constructor
    private $page = "RekapSampah/";
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
        $data = [
            "title" => "Rekapitulasi Pengurangan Sampah",
            "page" => $this->page . "index",
            "script" => $this->page . "script",
            "BankRekap" => $this->buildRekap()
        ];
        $this->load->view('Router/route', $data);
    }
    public function chart_BankRekap()
    {
        echo json_encode($this->buildRekap());
    }
    public function printRekap()
    {
        $data = [
            "BankRekap" => $this->buildRekap(),
        ];
        $this->load->view('Admin/RekapSampah/PrintRekapDataSampah', $data);
    }
    public function buildRekap()
    {
        $allbank = $this->db->get_where("bank_sampah")->result_array();
        $results = [];
        $month = [];
        $tatal_allKG = 0;
        $tatal_allBH = 0;
        $tahun = !empty($_GET['tahun']) ? $_GET['tahun'] : date("Y");
        if (!empty($th) && $th != null && $th != "" && $th != "null") {
            $tahun = $th;
        }
        for ($m = 1; $m <= 12; ++$m) {
            $mm = $m < 10 ? "0" . $m : $m;
            $bln = $tahun . "-" . $mm;
            array_push($month, bln_aja($bln));
        }
        foreach ($allbank as $bk) {


            $res = [];
            $this->db->select("satuan");
            $this->db->group_by("satuan");
            $_satuan = $this->db->get_where("sampah")->result_array();
            $satuan = [];
            foreach ($_satuan as $v)
                array_push($satuan, $v['satuan']);
            $main_res = [];
            $total = [];
            for ($m = 1; $m <= 12; ++$m) {
                $mm = $m < 10 ? "0" . $m : $m;
                $bln = $tahun . "-" . $mm;
                // $this->db->join("jenis_sampah", "jenis_sampah.kode = sampah.kode_jenis_sampah");
                // $b = $this->db->get_where("sampah")->result_array();
                $this->db->select("*, transaksi.tanggal as tanggal,transaksi.id_transaksi as id_transaksi");
                $this->db->join("riwayat_saldo", "riwayat_saldo.id_riwayat  = transaksi.riwayat_id");
                $this->db->where("transaksi.id_bank", $bk["id_bank_sampah"]);
                $this->db->like('transaksi.tanggal', $bln, 'both');
                $r = $this->db->get_where("transaksi")->result_array();
                // foreach ($satuan as $_) {
                foreach ($r as $__) {
                    $res[$bln][$__['satuan']][] = $__['berat'];
                    $res[$bln]["total"][]   = $__['berat'];
                }
                // }
                if (empty($res[$bln])) {
                    foreach ($satuan as $s) {
                        $res[$bln][$s] = 0;
                        $total[$s] = empty($total[$s]) ? 0 : $total[$s] + 0;
                        $res[$bln]["total"] = empty($res[$bln]["total"]) ? 0 : $res[$bln]["total"] + 0;
                    }
                } else {
                    foreach ($satuan as $sa) {
                        if (empty($res[$bln][$sa])) {
                            $summar = 0;
                            $res[$bln][$sa] = $summar;
                            $total[$sa] = $total[$sa] + $summar;
                        } else {
                            $summar = array_sum($res[$bln][$sa]);
                            $res[$bln][$sa] = $summar;
                            $total[$sa] = $total[$sa] + $summar;
                        }
                    }
                    if (!empty($res[$bln]["total"])) {
                        $summar = array_sum($res[$bln]["total"]);
                        $res[$bln]["total"] = $summar;
                    }
                }
                $res[$bln]["bulan"] = $bln;
            }

            $result = [];
            $bulan = [];
            foreach ($res as $keys =>  $val) {
                array_push($result, $val);
                array_push($bulan, $keys);
            }
            $tatal_allKG +=  $total['KG'];
            $tatal_allBH +=  $total['BH'];;

            array_push($results, [
                "bank" => $bk,
                "list" => $result,
                "total" => $total,
                "satuan" => $satuan,
                "bulan" => $bulan
            ]);
        }
        return [
            "bulan" => $month,
            "result" => $results,
            "total" => [
                "KG" => $tatal_allKG,
                "BH" =>  $tatal_allBH
            ]
        ];
    }
    public function RekapBank($id_bank_sampah)
    {
        // echo json_encode($this->HargaSampah($id_bank_sampah));
        // die();
        $data = [
            "title" => "Rekapitulasi Penjualan Sampah",
            "page" => $this->page . "RekapDataSampah",
            "script" => $this->page . "scriptRekap",
            "rekap" => $this->getTransaksi($id_bank_sampah),
            "jenis_sampah" => $this->jenis_sampah($id_bank_sampah),
            "harga_sampah" => $this->HargaSampah($id_bank_sampah)
        ];
        $this->load->view('Router/route', $data);
    }

    public function rekap_penjualan_sampah($id_bank_sampah, $search = null)
    {
        $data = [
            "title" => "Rekapitulasi Penjualan Sampah",
            "page" => $this->page . "rekap_penjulan",
            "script" => $this->page . "script_rekap",
            "jenis"  => $this->jenis_sampah($id_bank_sampah),
            "rekap" => $this->getRekap($id_bank_sampah),
        ];
        $this->load->view('Router/route', $data);
    }
    public function getDataJenisBySearch($id_bank_sampah, $_tgl = null)
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
                $this->db->where("transaksi.id_bank", $id_bank_sampah);
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
                    "total_uang"   => array_sum(array_column($r, 'total')),
                    "satuan"       => $va['satuan'],
                ];
            }
            array_push($results, $ress);
        }

        echo json_encode([
            "header" => $sampah,
            "result" => $results
        ]);
    }
    public function chartDataRekap($id_bank_sampah, $_tgl = null)
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
        $this->db->join("jenis_sampah", "jenis_sampah.kode = sampah.kode_jenis_sampah");
        $sampah = $this->db->get_where("sampah")->result_array();

        $result = [];
        $cc = [];
        foreach ($sampah as $value) {
            $this->db->select("*,SUM(transaksi.berat) as total");
            $this->db->where("transaksi.id_bank", $id_bank_sampah);
            $this->db->like('transaksi.tanggal', $tahun . "-" . $bulan, 'both');
            $this->db->where('transaksi.kode_barang', $value['kode_sampah']);
            $r = $this->db->get_where("transaksi")->row_array();

            $data = [
                "date" => $tahun . "-" . $bulan,
                "jenis" => $value['jenis'],
                "total" => $r['total'] == null ? 0 : $r['total'],
                "barang" => $value['nama_barang'],
                "satuan" => $value['satuan']
            ];
            $cc["label"][] = $data['barang'];
            $cc["total"][] = $r['total'] == null ? 0 : $r['total'];
            $cc["jenis"][] =  $value['jenis'] == null ? 0 : $value['jenis'];

            array_push($result, $data);
        }
        echo json_encode([
            "result" => $result,
            "chart"  => $cc
        ]);
    }
    public function getDataRekaptahunan($id_bank_sampah, $th = null)
    {
        $tahun = date("Y");
        if (!empty($th) && $th != null && $th != "" && $th != "null") {
            $tahun = $th;
        }

        $res = [];
        $this->db->select("satuan");
        $this->db->group_by("satuan");
        $_satuan = $this->db->get_where("sampah")->result_array();
        $satuan = [];
        foreach ($_satuan as $v)
            array_push($satuan, $v['satuan']);
        $main_res = [];
        $total = [];
        for ($m = 1; $m <= 12; ++$m) {
            $mm = $m < 10 ? "0" . $m : $m;
            $bln = $tahun . "-" . $mm;
            // $this->db->join("jenis_sampah", "jenis_sampah.kode = sampah.kode_jenis_sampah");
            // $b = $this->db->get_where("sampah")->result_array();
            $this->db->select("*, transaksi.tanggal as tanggal,transaksi.id_transaksi as id_transaksi");
            $this->db->join("riwayat_saldo", "riwayat_saldo.id_riwayat  = transaksi.riwayat_id");
            $this->db->where("transaksi.id_bank", $id_bank_sampah);
            $this->db->like('transaksi.tanggal', $bln, 'both');
            $r = $this->db->get_where("transaksi")->result_array();
            // foreach ($satuan as $_) {
            foreach ($r as $__) {
                $res[$bln][$__['satuan']][] = $__['berat'];
                $res[$bln]["total"][]   = $__['berat'];
            }
            // }
            if (empty($res[$bln])) {
                foreach ($satuan as $s) {
                    $res[$bln][$s] = 0;
                    $total[$s] = empty($total[$s]) ? 0 : $total[$s] + 0;
                    $res[$bln]["total"] = empty($res[$bln]["total"]) ? 0 : $res[$bln]["total"] + 0;
                }
            } else {
                foreach ($satuan as $sa) {
                    if (empty($res[$bln][$sa])) {
                        $summar = 0;
                        $res[$bln][$sa] = $summar;
                        $total[$sa] = $total[$sa] + $summar;
                    } else {
                        $summar = array_sum($res[$bln][$sa]);
                        $res[$bln][$sa] = $summar;
                        $total[$sa] = $total[$sa] + $summar;
                    }
                }
                if (!empty($res[$bln]["total"])) {
                    $summar = array_sum($res[$bln]["total"]);
                    $res[$bln]["total"] = $summar;
                }
            }
            $res[$bln]["bulan"] = $bln;
        }

        $result = [];
        $bulan = [];
        foreach ($res as $keys =>  $val) {
            array_push($result, $val);
            array_push($bulan, $keys);
        }

        echo json_encode([
            "list" => $result,
            "total" => $total,
            "satuan" => $satuan,
            "bulan" => $bulan
        ]);
    }
    public function getJenisSampah($id_bank_sampah)
    {
        $tahun = date('Y');
        $bulan = date('m');
        $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $tg = [];
        for ($i = 1; $i < $tanggal + 1; $i++) {
            array_push($tg, date("Y-m") . "-" . $i);
        }
        $results = [];
        foreach ($tg as  $tanggal) {
            $this->db->join("jenis_sampah", "jenis_sampah.kode = sampah.kode_jenis_sampah");
            if (!empty($_GET['jenis']) && $_GET['jenis'] != "") {
                $this->db->where("kode", $_GET['jenis']);
            }
            $b = $this->db->get_where("sampah")->result_array();
            $ress = [];
            foreach ($b as $ky => $va) {
                $this->db->select("*, transaksi.tanggal as tanggal,transaksi.id_transaksi as id_transaksi");
                $this->db->join("riwayat_saldo", "riwayat_saldo.id_riwayat  = transaksi.riwayat_id");
                $this->db->where("transaksi.id_bank", $id_bank_sampah);
                $this->db->where('transaksi.tanggal', $tanggal);
                $this->db->where('transaksi.kode_barang', $va['kode_sampah']);
                $this->db->order_by('transaksi.id_transaksi', 'DESC');
                $r = $this->db->get_where("transaksi")->result_array();

                $ress[$va['jenis']][] = [
                    "tanggal" => $tanggal,
                    "kode_jenis_sampah" => $va['kode_jenis_sampah'],
                    "jenis_sampah" => $va['jenis'],
                    "kode_sampah"  => $va['kode_sampah'],
                    "nama_barang"  => $va['nama_barang'],
                    "total_berat"  => array_sum(array_column($r, 'berat'))
                ];
            }
            $results[$tanggal][] = $ress;
        }

        echo json_encode($results);
    }
    public function getTransaksi($id_bank_sampah)
    {
        $this->db->select("*, transaksi.tanggal as tanggal,transaksi.id_transaksi as id_transaksi");
        $this->db->join("users", "users.id = transaksi.id_user_petugas");
        $this->db->join("nasabah", "nasabah.id_nasabah = transaksi.id_nasabah");
        $this->db->join("riwayat_saldo", "riwayat_saldo.id_riwayat  = transaksi.riwayat_id");
        $this->db->where("nasabah.id_bank", $id_bank_sampah);
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
    public function jenis_sampah($id_bank_sampah)
    {
        $this->db->where("id_bank", $id_bank_sampah);
        $ck = $this->db->get_where("jenis_sampah")->result_array();
        return $ck;
    }
    public function getRekap($id_bank_sampah)
    {
        $this->db->where("bulan", date("Y-m"));
        $d = $this->db->get_where("rekapitulasi", ["id_bank" => $id_bank_sampah])->result_array();
        return $d;
    }


    public function barangbyid($id_bank_sampah, $kode_barang)
    {
        $this->db->join("jenis_sampah", "jenis_sampah.kode = sampah.kode_jenis_sampah");
        $this->db->where("sampah.id_bank", $id_bank_sampah);
        $this->db->where("sampah.kode_sampah", $kode_barang);
        $b = $this->db->get_where("sampah")->row_array();
        echo json_encode($b);
    }

    public function HargaSampah($id_bank_sampah)
    {
        $this->db->join("jenis_sampah", 'jenis_sampah.kode = sampah.kode_jenis_sampah', "left");
        $g = $this->db->get_where("sampah", ["sampah.id_bank" => $id_bank_sampah])->result_array();
        return $g;
    }
}
