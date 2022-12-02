<?php


defined('BASEPATH') or exit('No direct script access allowed');

class ImportData extends CI_Controller
{
    public function index()
    {
    }
    public function ImportDataNasabah()
    {
        $json_nasabah = json_decode(file_get_contents(base_url("assets/data/import/nasabah.json")), true);
        $json_saldo = json_decode(file_get_contents(base_url("assets/data/import/saldo_nasabah.json")), true);

        foreach ($json_nasabah as $value) {
            $UserData = [
                "id_bank_sampah" => 6,
                "pin" => "1234",
                "username" => $value["NO. REKENING"] ?? "-",
                "password" => password_hash($value["NO. REKENING"] ?? "-", PASSWORD_DEFAULT),
                "role" => "NASABAH",
                "status_account" => "active",
                "foto" => "default.jpg",
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
            ];
            $this->db->insert("users", $UserData);
            $insUser = $this->db->insert_id();
            $nasabah = [
                "id_bank" => 6,
                "user_entry" => 6,
                "id_user" => $insUser,
                "nama_nasabah" => $value["NAMA"] ?? "-",
                "no_telepon" => $value["NO. TELFON"] ?? "-",
                "alamat" => $value["ALAMAT"] ?? "-",
                "pekerjaan" => $value["PEKERJAAN"] ?? "-",
                "no_rekening" => $value["NO. REKENING"] ?? "-",
                "tanggal" => $value['TANGGAL'] ?? "-",
                "saldo" => $this->search_exif($json_saldo, $value['NO. REKENING'] ?? "-") ?? "0",
                "tanggal" => date("Y-m-d"),
                "created_at" => date("Y-m-d H:i:s"),
            ];
            $sv = $this->db->insert("nasabah", $nasabah);
        }
    }
    public function search_exif($exif, $field)
    {
        foreach ($exif as $data) {
            if ($data['NOMOR INDUK'] == $field)
                return $data['SALDO'] ?? "0";
        }
    }

    // $camera = search_exif($exif['photo']['exif'], 'model');
}
