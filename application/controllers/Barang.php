<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{
    // constructor
    private $page = "Barang/";
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
            "title" => "Sampah",
            "page" => $this->page . "index",
            "script" => $this->page . "script",
            "barang"  => $this->getDatabarang()
        ];
        $this->load->view('Router/route', $data);
    }
    public function getDatabarang()
    {
        $this->db->join("jenis_sampah", "jenis_sampah.kode = sampah.kode_jenis_sampah");
        $b = $this->db->get_where("sampah")->result_array();
        return $b;
    }
    public function kodeChecker($kode)
    {
        $this->db->where("id_bank", auth()["user"]["id_bank_sampah"]);
        $this->db->where("kode_sampah", $kode);
        $ck = $this->db->get_where("sampah")->num_rows();
        return $ck;
    }
    public function cekKode($kode)
    {
        echo json_encode($this->kodeChecker($kode));
    }
    public function getById()
    {
        $gt = $this->db->get_where("sampah", ["id_sampah" => $_POST['id']])->row_array();
        echo json_encode($gt);
    }
    public function action()
    {
        $req = $_POST;

        $check = $this->db->get_where("sampah", ["id_sampah" => $req['id_sampah']])->num_rows();
        if (!empty($req['id_sampah']) && $check > 0) {
            $data = [
                "id_bank" => auth()["user"]["id_bank_sampah"],
                "kode_sampah" =>  $req['kode_sampah'],
                "kode_jenis_sampah" => $req['kode_jenis_sampah'],
                "nama_barang" => $req['nama_barang'],
                "satuan"      => $req['satuan'],
                "harga"         => $req['harga'],
                "created_at" => date("Y-m-d")
            ];

            $save = $this->db->update("sampah", $data, ["id_sampah" => $req['id_sampah']]);
        } else {
            $data = [
                "id_bank" => auth()["user"]["id_bank_sampah"],
                "kode_sampah" =>  $req['kode_sampah'],
                "kode_jenis_sampah" => $req['kode_jenis_sampah'],
                "nama_barang" => $req['nama_barang'],
                "satuan"      => $req['satuan'],
                "harga"         => $req['harga'],
                "created_at" => date("Y-m-d")
            ];
            $save = $this->db->insert("sampah", $data);
        }
        if ($save) {
            $this->session->set_flashdata("success", "Barang berhasil ditambahkan");
            redirect("Barang/index");
        } else {
            $this->session->set_flashdata("error", "Barang gagal ditambahkan");
            redirect("Barang/index");
        }
    }
    public function delete($id)
    {
        $sm = $this->db->delete("sampah", [
            "id_sampah" => $id
        ]);
        if ($sm) {
            $this->session->set_flashdata("success", "Barang berhasil dihapus");
            redirect("Barang/index");
        } else {
            $this->session->set_flashdata("error", "Barang gagal dihapus");
            redirect("Barang/index");
        }
    }
}
