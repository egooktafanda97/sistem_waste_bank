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
                $this->session->set_flashdata("success", "User berhasil diubah");
                redirect("User/index");
            } else {
                $this->session->set_flashdata("error", "User gagal diubah");
                redirect("User/index");
            }
        }
    }
}
