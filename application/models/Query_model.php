<?php

class Query_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function all($table)
    {
        return $this->db->get($table)->result_array();
    }
    public function get_where($table, $where)
    {
        return $this->db->get_where($table, $where)->row_array();
    }
    public function first($table, $where)
    {
        return $this->db->get_where($table, $where)->row_array();
    }
    public function insert($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }
    public function update($table, $data, $where)
    {
        $res = $this->db->update($table, $data, $where);
        return $res;
    }
    public function delete($table, $where)
    {
        $res = $this->db->delete($table, $where);
        return $res;
    }
}
