<?php

class Nasabah_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getAll()
    {
        $this->db->join("users", "users.id = nasabah.id_user");
        $this->db->where("nasabah.id_bank", auth()["user"]["id_bank_sampah"]);
        return $this->db->get("nasabah")->result_array();
    }
    public function getById($id)
    {
        $this->db->join("users", "users.id = nasabah.id_user");
        $this->db->where("nasabah.id_bank", auth()["user"]["id_bank_sampah"]);
        return $this->db->get_where("nasabah", ["nasabah.id_nasabah" => $id])->row_array();
    }
}
