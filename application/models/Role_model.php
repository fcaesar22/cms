<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_model extends CI_Model {
	public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    public function getCountAll($key_search)
    {
        $this->db->select('id');
        $this->db->from('roles');
        if ($key_search!='null') {
            $this->db->like('name', $key_search);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getDatas($key_search, $sort_by, $order_sort, $rowperpage, $rowno)
    {
        $this->db->select('*');
        $this->db->from('roles');
        if ($key_search!='null') {
            $this->db->like('name', $key_search);
        }
        $this->db->order_by($sort_by, $order_sort);
        $this->db->limit($rowperpage, $rowno);  
        $query = $this->db->get();
        return $query->result_array();
    }

    public function insert($data)
    {
        return $this->db->insert('roles', $data);
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('roles', ['id' => $id])->row();
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('roles');
        $this->db->where('role_id', $id);
        $this->db->delete('role_permissions');
    }

    public function get_role_permissions($role_id)
    {
        $this->db->select('permission_id');
        $this->db->where('role_id', $role_id);
        $res = $this->db->get('role_permissions')->result();
        return array_column($res, 'permission_id');
    }

    public function update_permissions($role_id, $permission_ids)
    {
        $this->db->trans_start();

        $this->db->where('role_id', $role_id)->delete('role_permissions');

        if (!empty($permission_ids)) {
            foreach ($permission_ids as $pid) {
                $this->db->insert('role_permissions', [
                    'role_id' => $role_id,
                    'permission_id' => $pid
                ]);
            }
        }

        $this->db->trans_complete();
    }

    // controllers Users.php
    public function get_all_roles()
    {
        return $this->db->get('roles')->result();
    }
}
