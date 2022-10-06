<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Rekap extends CI_Controller
{
    // constructor
    private $page = "Sampah/";
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Nasabah_model');
        $this->load->library('form_validation');
    }
    public function index()
    {
        $data = [
            "title" => "Rekapitulasi Sampah Masuk",
            "page" => $this->page . "rekap",
            "script" => $this->page . "script_rekap",
            "jenis"  => $this->jenis_sampah(),
            "rekap" => $this->getRekap()
        ];
        $this->load->view('Router/route', $data);
    }
    public function jenis_sampah()
    {
        $this->db->where("id_bank", auth()["user"]["id_bank_sampah"]);
        $ck = $this->db->get_where("jenis_sampah")->result_array();
        return $ck;
    }
    public function getRekap()
    {
        $this->db->where("bulan", date("Y-m"));
        $d = $this->db->get_where("rekapitulasi", ["id_bank" => auth()["user"]["id_bank_sampah"]])->result_array();
        return $d;
    }
    public function action()
    {
        $req = $_POST;
        if (empty(auth()["user"]["id_bank_sampah"])) {
            redirect("Login");
        }
        $this->form_validation->set_rules('bulan', 'bulan', 'required');
        $this->form_validation->set_rules('tanggal', 'tanggal', 'required');
        $this->form_validation->set_rules('jenis_sampah', 'jenis_sampah', 'required');
        $this->form_validation->set_rules('kode_jenis_sampah', 'kode_jenis_sampah', 'required');
        $this->form_validation->set_rules('nama_barang', 'nama_barang', 'required');
        $this->form_validation->set_rules('kode_barang', 'kode_barang', 'required');
        $this->form_validation->set_rules('berat', 'berat', 'required');
        $this->form_validation->set_rules('satuan', 'satuan', 'required');
        if ($this->form_validation->run() != false) {
            if (!empty($req['id_rekap'])) {
            } else {
                $data = [
                    "id_bank" =>  auth()["user"]["id_bank_sampah"],
                    "id_user_entry" => auth()["user"]["id"],
                    "tahun" => !empty($req['bulan']) ? explode("-", $req['bulan'])[0] : "",
                    "bulan" => $req['bulan'],
                    "tanggal" => $req['tanggal'],
                    "kode_jenis_sampah" => $req['kode_jenis_sampah'],
                    "jenis_sampah" => $req['jenis_sampah'],
                    "kode_barang" => $req['kode_barang'],
                    "nama_barang" => $req['nama_barang'],
                    "bobot" => $req['berat'],
                    "satuan" => $req['satuan'],
                    "created_at" => date("Y-m-d H:i:s")
                ];
                $save = $this->db->insert("rekapitulasi", $data);
            }

            if ($save) {
                $this->session->set_flashdata("success", "Jenis Sampah berhasil ditambahkan");
                redirect("Rekap/index");
            } else {
                $this->session->set_flashdata("error", "Jenis Sampah gagal ditambahkan");
                redirect("Rekap/index");
            }
        } else {
            $this->session->set_flashdata("error", "Entry gagal");
            redirect("Rekap/index");
        }
    }
}
