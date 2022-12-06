<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
{
    // constructor
    private $page = "Penjualan/";
    private $primary = "id_penjualan";
    private $table = "penjualan";
    private $table_penjulan = [
        "id_bank_sampah",
        "id_sampah",
        "id_tempat_jual",
        "berat",
        "satuan",
        "harga_jual",
        "harga_bank",
        "total",
        "tahun",
        "bulan",
        "tanggal",
        "create_at"
    ];
    public function __construct()
    {
        parent::__construct();
        if (!auth()["user"]["id_bank_sampah"]) {
            redirect("Login");
        }
    }

    public function index()
    {
        $data = [
            "title" => "Penjualan Sampah",
            "page" => $this->page . "index.php",
            "script" => $this->page . "script",
            "table" => $this->table_penjulan,
            "primary" => $this->primary,
            "data_penjualan" => $this->getDataPenjualan(),
            "jenis" => $this->getDatabarang(),
            "t_jual" => $this->t_jual()
        ];
        $this->load->view('Router/route', $data);
    }

    public function t_jual()
    {
        $this->db->where("id_bank", auth()["user"]["id_bank_sampah"]);
        $b = $this->db->get_where("tempat_jual")->result_array();
        return $b;
    }

    public function getDatabarang()
    {
        $this->db->join("jenis_sampah", "jenis_sampah.kode = sampah.kode_jenis_sampah", "left");
        $this->db->where("sampah.id_bank", auth()["user"]["id_bank_sampah"]);
        $b = $this->db->get_where("sampah")->result_array();
        return $b;
    }

    public function getDatabarangById($id)
    {
        $this->db->join("jenis_sampah", "jenis_sampah.kode = sampah.kode_jenis_sampah", "left");
        $this->db->where("sampah.id_bank", auth()["user"]["id_bank_sampah"]);
        $this->db->where("sampah.id_sampah", $id);
        $b = $this->db->get_where("sampah")->row_array();
        echo json_encode($b);
    }

    public function create_penjulan()
    {
        $post = $_POST;
        if (empty($post[$this->primary]) || $post[$this->primary] == "") {
            unset($post['id_penjualan']);
            $post += [
                "id_bank_sampah" => auth()["user"]["id_bank_sampah"],
                "tahun" => date("Y"),
                "bulan" => date("Y-m"),
                "tanggal" => date("Y-m-d"),
                "create_at" => date("Y-m-d H:i:s")
            ];
            $sv = $this->db->insert($this->table, $post);
            if ($sv) {
                $this->session->set_flashdata("success", "Penjualan berhasil ditambahkan");
                redirect("Penjualan/index");
            } else {
                $this->session->set_flashdata("error", "Penjualan gagal ditambahkan");
                redirect("Penjualan/index");
            }
        } else {
            unset($post[$this->primary]);
            $post += [
                "tahun" => date("Y"),
                "bulan" => date("Y-m"),
                "tanggal" => date("Y-m-d"),
                "create_at" => date("Y-m-d H:i:s")
            ];
            $this->db->where($this->primary, $_POST[$this->primary]);
            $sv = $this->db->update($this->table, $post);
            if ($sv) {
                $this->session->set_flashdata("success", "Penjualan berhasil di edit");
                redirect("Penjualan/index");
            } else {
                $this->session->set_flashdata("error", "Penjualan gagal di edit");
                redirect("Penjualan/index");
            }
        }
    }
    public function getDataPenjualan()
    {
        $this->db->join("sampah", "sampah.id_sampah = " . $this->table . ".id_sampah", "left");
        $this->db->join("tempat_jual", "tempat_jual.id_tempat_jaul = " . $this->table . ".id_tempat_jual", "left");
        $this->db->where("id_bank_sampah", auth()["user"]["id_bank_sampah"]);
        $get = $this->db->get_where($this->table)->result_array();
        return $get;
    }

    public function getDataPenjualanById($id)
    {
        $this->db->join("sampah", "sampah.id_sampah = " . $this->table . ".id_sampah", "left");
        $this->db->join("tempat_jual", "tempat_jual.id_tempat_jaul = " . $this->table . ".id_tempat_jual", "left");
        $this->db->where("id_bank_sampah", auth()["user"]["id_bank_sampah"]);
        $this->db->where($this->table . ".id_penjualan", $id);
        $get = $this->db->get_where($this->table)->row_array();
        echo json_encode($get);
    }

    public function delete($id)
    {
        $del = $this->db->delete($this->table, [$this->primary => $id]);
        if ($del) {
            $this->session->set_flashdata("success", "deleted success");
            redirect("Penjualan/index");
        } else {
            $this->session->set_flashdata("error", "Ooops error");
            redirect("Penjualan/index");
        }
    }


    public function tempat_jual()
    {
        $data = [
            "title" => "Tempat Jual Sampah",
            "page" => $this->page . "TempatJual.php",
            "script" => $this->page . "script_tempatJual",
            "tempat_jual" => $this->getDataTempatJual()
        ];
        $this->load->view('Router/route', $data);
    }
    public function getDataTempatJual()
    {
        $this->db->where("id_bank", auth()["user"]["id_bank_sampah"]);
        $get = $this->db->get_where("tempat_jual")->result_array();
        return $get;
    }
    public function create_tempat_jual()
    {
        $post = $_POST;
        if (empty($post['id_tempat_jaul']) || $post['id_tempat_jaul'] == "") {
            $post += ["id_bank" =>  auth()["user"]["id_bank_sampah"], "created_at" => date("Y-m-d H:i:s")];
            $save = $this->db->insert("tempat_jual", $post);
            if ($save) {
                $this->session->set_flashdata("success", "Tempat jual berhasil ditambahkan");
                redirect("Penjualan/tempat_jual");
            } else {
                $this->session->set_flashdata("error", "Tempat jual gagal ditambahkan");
                redirect("Penjualan/tempat_jual");
            }
        } else {
            unset($post['id_tempat_jaul']);
            $post += ["id_bank" =>  auth()["user"]["id_bank_sampah"]];
            $this->db->where("id_tempat_jaul", $_POST['id_tempat_jaul']);
            $save = $this->db->update("tempat_jual", $post);
            if ($save) {
                $this->session->set_flashdata("success", "Tempat jual berhasil di edit");
                redirect("Penjualan/tempat_jual");
            } else {
                $this->session->set_flashdata("error", "Tempat jual gagal di edit");
                redirect("Penjualan/tempat_jual");
            }
        }
    }
    public function getById($id)
    {
        $this->db->where("id_bank", auth()["user"]["id_bank_sampah"]);
        $this->db->where("id_tempat_jaul", $id);
        $get = $this->db->get_where("tempat_jual")->row_array();
        echo json_encode($get);
    }
    public function delete_tempat_jual($id)
    {
        $del = $this->db->delete("tempat_jual", ["id_tempat_jaul" => $id]);
        if ($del) {
            $this->session->set_flashdata("success", "deleted success");
            redirect("Penjualan/tempat_jual");
        } else {
            $this->session->set_flashdata("error", "Ooops error");
            redirect("Penjualan/tempat_jual");
        }
    }
}
