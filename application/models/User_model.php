<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    public function getCountAll($key_search)
    {
        $this->db->select('users.id');
        $this->db->from('users');
        $this->db->join('roles', 'roles.id = users.role_id');
        if ($key_search!='null') {
            $this->db->like('users.username', $key_search);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getDatas($key_search, $sort_by, $order_sort, $rowperpage, $rowno)
    {
        $this->db->select('users.id, users.username, users.name_account, users.role_id, roles.name as role_name');
        $this->db->from('users');
        $this->db->join('roles', 'roles.id = users.role_id');
        if ($key_search!='null') {
            $this->db->like('users.username', $key_search);
        }
        $this->db->order_by($sort_by, $order_sort);
        $this->db->limit($rowperpage, $rowno);  
        $query = $this->db->get();
        return $query->result_array();
    }

    public function insert_user($data)
    {
        return $this->db->insert('users', $data);
    }

    public function get_user_by_id($id)
    {
        return $this->db->get_where('users', ['id' => $id])->row();
    }

    public function update_user($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    public function delete_user($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('users');
    }

    // controllers Auth.php
    public function get_user($username)
    {
        return $this->db->get_where('users', ['username' => $username])->row();
    }

    // helper rbac_helper.php
    public function check_permission($user_id, $permission_name)
    {
        $this->db->select('permissions.*');
        $this->db->from('users');
        $this->db->join('roles', 'roles.id = users.role_id');
        $this->db->join('role_permissions', 'role_permissions.role_id = roles.id');
        $this->db->join('permissions', 'permissions.id = role_permissions.permission_id');
        $this->db->where('users.id', $user_id);
        $this->db->where('permissions.name', $permission_name);
        $query = $this->db->get();
        return $query->num_rows() > 0;
    }
}
