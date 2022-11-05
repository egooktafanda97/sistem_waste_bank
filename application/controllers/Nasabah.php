<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Nasabah extends CI_Controller
{
    // constructor
    private $page = "Nasabah/";
    private $kode_rekening = "283-12-";
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
            "title" => "Nasabah",
            "page" => $this->page . "index",
            "script" => $this->page . "script",
            "nasabah" => $this->Nasabah_model->getAll(),
            "total" => $this->total()
        ];
        $this->load->view('Router/route', $data);
    }
    public function action()
    {
        // data 
        $post = $this->input->post();
        // cek username 
        if (!empty($post['id_user']) && $post['id_user'] != "") {
            $this->edit($post);
        } else {
            unset($post['id_user']);
            $this->save($post);
        }
    }
    public function save($post)
    {
        $cek_username = $this->Query_model->get_where("users", ["username" => $post["username"]]);
        if ($cek_username) {
            $this->session->set_flashdata("error", "Username sudah terdaftar");
            redirect("Nasabah");
        }
        // usuer
        $UserData = [
            "id_bank_sampah" => auth()["user"]["id_bank_sampah"],
            "pin" => "1111",
            "username" => $post["username"],
            "password" => $post["password"],
            "role" => "NASABAH",
            "status_account" => "active",
            "foto" => "default.jpg",
            "remember_token" => random(20),
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
        ];
        $saveUser = $this->Query_model->insert("users", $UserData);
        // nasabah
        // generate no rekening 00001 num
        $no_rekening = "";
        do {
            $no_rekening = $this->kode_rekening . random_num(5);
        } while ($this->Query_model->first("nasabah", ["no_rekening" => $this->kode_rekening . random_num(5)]));

        $nasabah = [
            "id_user" => $saveUser,
            "id_bank" => auth()["user"]["id_bank_sampah"],
            "user_entry" => auth()["user"]["id"],
            "nama_nasabah" => $post["nama_nasabah"],
            "no_telepon" => $post["no_telepon"],
            "alamat" => $post["alamat"],
            "no_rekening" => $no_rekening,
            "pekerjaan" => $post["pekerjaan"],
            "saldo" => $post["saldo"],
            "tanggal" => date("Y-m-d"),
            "created_at" => date("Y-m-d H:i:s"),
        ];
        $saveNasabah = $this->Query_model->insert("nasabah", $nasabah);
        if ($saveNasabah) {
            $this->session->set_flashdata("success", "Nasabah berhasil ditambahkan");
            redirect("Nasabah/index");
        } else {
            $this->session->set_flashdata("error", "Nasabah gagal ditambahkan");
            redirect("Nasabah/index");
        }
    }
    public function edit($post)
    {
        $cek_username = $this->Query_model->get_where("users", ["username" => $post["username"], "id !=" => $post["id_user"]]);
        if ($cek_username) {
            $this->session->set_flashdata("error", "Username sudah terdaftar");
            redirect("Nasabah");
        }
        // usuer
        $UserData = [
            "id_bank_sampah" => auth()["user"]["id_bank_sampah"],
            "pin" => "1111",
            "username" => $post["username"],
            "password" => $post["password"],
            "role" => "NASABAH",
            "status_account" => "active",
            "foto" => "default.jpg",
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
        ];

        $this->Query_model->update("users", $UserData, ["id" => $post["id_user"]]);

        $getNasabah = $this->Query_model->first("nasabah", ["id_user" => $post["id_user"]]);
        $nasabah = [
            "id_bank" => auth()["user"]["id_bank_sampah"],
            "user_entry" => auth()["user"]["id"],
            "nama_nasabah" => $post["nama_nasabah"],
            "no_telepon" => $post["no_telepon"],
            "alamat" => $post["alamat"],
            "pekerjaan" => $post["pekerjaan"],
            "saldo" => $post["saldo"],
            "tanggal" => date("Y-m-d"),
            "created_at" => date("Y-m-d H:i:s"),
        ];
        $saveNasabah = $this->Query_model->update("nasabah", $nasabah, ["id_nasabah" => $getNasabah["id_nasabah"]]);
        if ($saveNasabah) {
            $this->session->set_flashdata("success", "Nasabah berhasil diubah");
            redirect("Nasabah/index");
        } else {
            $this->session->set_flashdata("error", "Nasabah gagal diubah");
            redirect("Nasabah/index");
        }
    }
    public function getById()
    {
        $id = $this->input->post("id");
        $nasabah = $this->Nasabah_model->getById($id);
        echo json_encode($nasabah);
    }
    public function delete($id_user)
    {
        $delete = $this->Query_model->delete("nasabah", ["id_user" => $id_user]);
        $delete = $this->Query_model->delete("users", ["id" => $id_user]);
        if ($delete) {
            $this->session->set_flashdata("success", "Nasabah berhasil dihapus");
            redirect("Nasabah/index");
        } else {
            $this->session->set_flashdata("error", "Nasabah gagal dihapus");
            redirect("Nasabah/index");
        }
    }
    // tabungn
    public function tabungan()
    {
        $data = [
            "title" => "Nasabah",
            "page" => $this->page . "tabungan",
            "script" => $this->page . "script",
            "nasabah" => $this->Nasabah_model->getAll()
        ];
        $this->load->view('Router/route', $data);
    }
    // data tabungan
    public function data_tabungan()
    {
        $data = [
            "title" => "Tabungan",
            "page" => $this->page . "data_tabungan",
            "script" => $this->page . "script",
        ];
        $this->load->view('Router/route', $data);
    }
    public function total()
    {
        $nasabah = $this->db->get_where("nasabah", ["id_bank" => auth()["user"]["id_bank_sampah"]])->num_rows();
        $this->db->select("sum(saldo) as saldo_nasabah");
        $total_saldo = $this->db->get_where("nasabah", ["id_bank" => auth()["user"]["id_bank_sampah"]])->row_array();
        return [
            "total_nasabah" => $nasabah,
            "total_saldo" => $total_saldo
        ];
    }
}
