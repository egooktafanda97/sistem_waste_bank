<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    // constructor
    private $page = "Home/";
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Nasabah_model');
        if (!auth()["user"]["id_bank_sampah"]) {
            redirect("Login");
        }
    }
    public function index()
    {
        $data = [
            "title" => "Rekapitulasi Penjualan Sampah",
            "page" => $this->page . "index",
            "script" => $this->page . "script",
            "grafik" => $this->total(),
            "counting" => $this->counting()
        ];
        $this->load->view('Router/route', $data);
    }
    public function counting()
    {
        $this->db->join("users", "users.id = nasabah.id_user", "left");
        $Q1 = $this->db->get_where("nasabah")->num_rows();
        $Q2 = $this->db->get_where("bank_sampah", ["status" => "AKTIF"])->num_rows();
        return [
            "nasabah" => $Q1,
            "bank" => $Q2
        ];
    }

    public function total()
    {
        $nasabah = $this->db->get_where("nasabah", ["id_bank" => auth()["user"]["id_bank_sampah"]])->num_rows();

        $this->db->select("sum(saldo) as saldo_nasabah");
        $total_saldo = $this->db->get_where("nasabah", ["id_bank" => auth()["user"]["id_bank_sampah"]])->row_array();

        $saldo_bank = $this->db->get_where("bank_sampah", ["id_bank_sampah" => auth()["user"]["id_bank_sampah"]])->row_array();

        return [
            "total_nasabah" => $nasabah,
            "total_saldo" => $total_saldo,
            "saldo_bank" => $saldo_bank["saldo"] ?? 0
        ];
    }
}
