<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function index()
    {
        $Q = $this->Query_model->all('users');
        $data = [
            "title" => "Nasabah",
            "page" => "Home/index",
            "script" => "Home/script",
        ];
        $this->load->view('Router/route', $data);
    }
}
