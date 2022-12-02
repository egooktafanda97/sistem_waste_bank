<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Sampah extends CI_Controller
{
    // constructor
    private $page = "Sampah/";
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
            "title" => "Jenis Sampah",
            "page" => $this->page . "index",
            "script" => $this->page . "script",
            "jenis"  => $this->getDataJenis()
        ];
        $this->load->view('Router/route', $data);
    }
    public function getDataJenis()
    {
        $this->db->select("*,jenis_sampah.created_at as tgl_create");
        $this->db->join("users", "users.id = jenis_sampah.user_entry", "left");
        $this->db->where("jenis_sampah.id_bank", auth()["user"]["id_bank_sampah"]);
        $gett = $this->db->get_where("jenis_sampah")->result_array();
        return $gett;
    }
    public function kodeChecker($kode = null)
    {
        $this->db->where("id_bank", auth()["user"]["id_bank_sampah"]);
        $this->db->where("kode", $kode);
        $ck = $this->db->get_where("jenis_sampah")->num_rows();
        return $ck;
    }
    public function cekKode($kode)
    {
        echo json_encode($this->kodeChecker($kode));
    }
    public function getById($kode)
    {
        $this->db->where("id_bank", auth()["user"]["id_bank_sampah"]);
        $gt = $this->db->get_where("jenis_sampah", ["kode" => $kode])->row_array();
        echo json_encode($gt);
    }
    public function getMethodById()
    {
        $this->db->where("id_bank", auth()["user"]["id_bank_sampah"]);
        $gt = $this->db->get_where("jenis_sampah", ["kode" => $_POST['id']])->row_array();
        echo json_encode($gt);
    }
    public function action()
    {
        $req = $_POST;
        if ($this->kodeChecker($req['kode']) > 0) {
            $data = [
                "kode" => $req['kode'],
                "id_bank" => auth()["user"]["id_bank_sampah"],
                "user_entry" => auth()["user"]["id"],
                "jenis" => $req['jenis'],
                "created_at" => date("Y-m-d")
            ];
            $save = $this->db->update("jenis_sampah", $data, ["kode" => $req['kode']]);
        } else {
            $data = [
                "kode" => $req['kode'],
                "id_bank" => auth()["user"]["id_bank_sampah"],
                "user_entry" => auth()["user"]["id"],
                "jenis" => $req['jenis'],
                "created_at" => date("Y-m-d")
            ];
            $save = $this->db->insert("jenis_sampah", $data);
        }
        if ($save) {
            $this->session->set_flashdata("success", "Jenis Sampah berhasil ditambahkan");
            redirect("Sampah/index");
        } else {
            $this->session->set_flashdata("error", "Jenis Sampah gagal ditambahkan");
            redirect("Sampah/index");
        }
    }
    public function delete($kode)
    {
        $sm = $this->db->delete("jenis_sampah", [
            "kode" => $kode
        ]);
        if ($sm) {
            $this->session->set_flashdata("success", "Jenis Sampah berhasil dihapus");
            redirect("Sampah/index");
        } else {
            $this->session->set_flashdata("error", "Jenis Sampah gagal dihapus");
            redirect("Sampah/index");
        }
    }
}
