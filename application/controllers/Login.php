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
        $user = $this->db->get('users')->row_array();
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $data = [
                    'user' => $user,
                    'role' => $user['role']
                ];
                $this->session->set_userdata('login', $data);
                echo json_encode(['status' => 'success', "result" => $data, "msg" => "Login Berhasil"]);
            } else {
                echo json_encode(['status' => 'error', "result" => "password", "msg" => "Password Salah"]);
            }
        } else {
            echo json_encode(['status' => 'error', "result" => "username", "msg" => "Username tidak ditemukan"]);
        }
    }
}
