<?php

defined('BASEPATH') or exit('No direct script access allowed');

class PrintingAdmin extends CI_Controller
{
    // constructor
    private $page = "Printing/";
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Nasabah_model');
        $this->load->library('form_validation');
        $this->load->model('Nasabah_model');
    }
    public function index()
    {
    }
    public function RekapBeratTahunanPrint($id_bank_sampah, $th = null)
    {
        $data = [
            "rekap" => $this->getTransaksi($id_bank_sampah),
            "jenis_sampah" => $this->jenis_sampah($id_bank_sampah),
            "dataPerTahun" => $this->getDataRekaptahunan($id_bank_sampah, $th)
        ];
        $this->load->view('Admin/Printing/RekapBeratTahunan', $data);
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

        return [
            "list" => $result,
            "total" => $total,
            "satuan" => $satuan,
            "bulan" => $bulan
        ];
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
    public function HargaSampah($id_bank_sampah)
    {
        $this->db->join("jenis_sampah", 'jenis_sampah.kode = sampah.kode_jenis_sampah', "left");
        $g = $this->db->get_where("sampah", ["sampah.id_bank" => $id_bank_sampah])->result_array();
        return $g;
    }
    public function print_harga($id_bank_sampah)
    {
        $data["harga_sampah"] = $this->HargaSampah($id_bank_sampah);
        $this->load->view('Admin/Printing/JenisSampah', $data);
    }
}
