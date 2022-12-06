<?php


defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    // constructor
    private $page = "User/";
    public function __construct()
    {
        parent::__construct();
        if (auth()["role"] != "SUPER_ADMIN") {
            redirect("Login");
        }
    }
    public function index()
    {
        $data = [
            "title" => "Users",
            "page" => $this->page . "index",
            "script" => $this->page . "script",
            "result" => $this->getDataUser()
        ];
        $this->load->view('Router/route', $data);
    }
    public function getDataUser()
    {
        $this->db->join("users", "users.id_bank_sampah = bank_sampah.id_bank_sampah", "left");
        $get = $this->db->get_where("bank_sampah", ["role" => "ADMIN_BANK"])->result_array();
        return $get;
    }
    public function action()
    {
        $post = $_POST;

        if (empty($post['id_bank_sampah']) || $post['id_bank_sampah'] == "") {
            $valid = $this->db->get_where("users", ["username" => $post['username']])->num_rows();
            if ($valid  > 0) {
                $this->session->set_flashdata("error", "User gagal ditambah username sudah ada!");
                redirect("User/index");
            }
            $bnk = [
                "nama_bank"     => $post['nama_bank'],
                "saldo"         => 0,
                "kas"           => 0,
                "tahun"         => $post['tahun'],
                "alamat"        => $post['alamat'],
                "kecamatan"     => $post['kecamatan'],
                "desa"          => $post['desa'],
                "koordinat"     => $post['koordinat'],
                "status"        => "AKTIF"
            ];
            $this->db->insert("bank_sampah", $bnk);
            $insBank = $this->db->insert_id();
            if ($insBank) {
                $us = [
                    "id_bank_sampah" => $insBank,
                    "pin" => "1234",
                    "username" => $post['username'],
                    "password" => password_hash($post['password'], PASSWORD_DEFAULT),
                    "role" => "ADMIN_BANK",
                    "foto" => "default.jpg",
                ];
                $svUs = $this->db->insert("users", $us);
                if ($svUs) {
                    $this->session->set_flashdata("success", "User berhasil ditambah");
                    redirect("User/index");
                } else {
                    $this->session->set_flashdata("error", "User gagal ditambah");
                    redirect("User/index");
                }
            }
        } else {
            $bnk = [
                "nama_bank"     => $post['nama_bank'],
                "tahun"         => $post['tahun'],
                "alamat"        => $post['alamat'],
                "kecamatan"     => $post['kecamatan'],
                "desa"          => $post['desa'],
                "koordinat"     => $post['koordinat'],
                "status"        => $post['status'],
            ];
            $upBank = $this->db->update("bank_sampah", $bnk, ["id_bank_sampah" => $post['id_bank_sampah']]);

            if ($upBank) {
                $us = [
                    "username" => $post['username'],
                ];
                if (!empty($post['password'])) {
                    $us += ["password" => password_hash($post['password'], PASSWORD_DEFAULT)];
                }
                $svUs = $this->db->update("users", $us, ["id_bank_sampah" => $post['id_bank_sampah']]);
                if ($svUs) {
                    $this->session->set_flashdata("success", "User berhasil diubah");
                    redirect("User/index");
                } else {
                    $this->session->set_flashdata("error", "User gagal diubah");
                    redirect("User/index");
                }
            }
        }
    }
    public function getById()
    {
        $id = $_POST['id'];
        $this->db->select("*, bank_sampah.status as status");
        $this->db->join("bank_sampah", "bank_sampah.id_bank_sampah  = users.id_bank_sampah", "left");
        $get = $this->db->get_where("users", ["id" => $id])->row_array();

        echo json_encode($get);
    }
    public function deleted($id)
    {
        $del = $this->db->delete("users", ["id" => $id]);
        if ($del) {
            $this->session->set_flashdata("success", "User berhasil dihapus");
            redirect("User/index");
        } else {
            $this->session->set_flashdata("error", "User gagal dihapus");
            redirect("User/index");
        }
    }
}
