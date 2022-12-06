<?php

use SebastianBergmann\Environment\Console;

defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function index()
    {
        $this->load->view('auth/login');
    }
    public function auth()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $this->db->where('username', $username);
        $user = $this->db->get_where('users')->row_array();
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $data = [
                    'user' => $user,
                    'role' => $user['role'],
                ];

                if ($data["role"] == "ADMIN_BANK") {
                    $this->db->select("*, bank_sampah.status as status");
                    $this->db->join("bank_sampah", "bank_sampah.id_bank_sampah  = users.id_bank_sampah", "left");
                    $get = $this->db->get_where("users", ["id" => $user['id']])->row_array();
                    $data += ["nama" => $get['nama_bank']];
                } else {
                    $data += ["nama" => "ADMIN"];
                }

                $this->session->set_userdata('login', $data);
                echo json_encode(['status' => 'success', "result" => $data, "msg" => "Login Berhasil"]);
            } else {
                echo json_encode(['status' => 'error', "result" => "password", "msg" => "Password Salah"]);
            }
        } else {
            echo json_encode(['status' => 'error', "result" => "username", "msg" => "Username tidak ditemukan"]);
        }
    }
    public function logout()
    {
        session_destroy();
        redirect(base_url("Login"));
    }
    public function perbaiki()
    {
        $get = $this->db->get_where("users", ["username" => "n_pb297"])->result_array();
        $index = 1;
        foreach ($get as $v) {
            $i = $index;
            $this->db->update("users", ["username" => "n_pb-" . $i], ["id" => $v['id']]);
            $index++;
        }
    }
}
