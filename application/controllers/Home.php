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
        ];
        $this->load->view('Router/route', $data);
    }
}
