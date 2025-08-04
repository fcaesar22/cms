<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission_model extends CI_Model {
	public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    public function getCountAll($key_search)
    {
        $this->db->select('permissions.id');
        $this->db->from('permissions');
        if ($key_search!='null') {
            $this->db->like('permissions.name', $key_search);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getDatas($key_search, $sort_by, $order_sort, $rowperpage, $rowno)
    {
        $this->db->select('permissions.*');
        $this->db->from('permissions');
        if ($key_search!='null') {
            $this->db->like('permissions.name', $key_search);
        }
        $this->db->order_by($sort_by, $order_sort);
        $this->db->limit($rowperpage, $rowno);  
        $query = $this->db->get();
        return $query->result_array();
    }

    public function insert($data)
    {
        return $this->db->insert('permissions', $data);
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('permissions', ['id' => $id])->row();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('permissions', $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete('permissions');
    }

    // controllers Roles.php
    public function get_all_with_menus()
    {
        $this->db->select('
            permissions.*,
            child_menu.name as child_menu_name,
            parent_menu.name as parent_menu_name
        ');
        $this->db->from('permissions');
        $this->db->join('menu_permissions', 'menu_permissions.permission_id = permissions.id', 'left');
        $this->db->join('menus as child_menu', 'child_menu.id = menu_permissions.menu_id', 'left');
        $this->db->join('menus as parent_menu', 'parent_menu.id = child_menu.parent_id', 'left');

        $res = $this->db->get()->result();

        foreach ($res as $perm) {
            if (!$perm->child_menu_name) {
                $perm->child_menu_name = $perm->parent_menu_name ?: 'Uncategorized';
                $perm->parent_menu_name = 'Main Menu';
            } else {
                if (!$perm->parent_menu_name) {
                    $perm->parent_menu_name = 'Main Menu';
                }
            }
        }

        return $res;
    }

    // controllers Menus.php
    public function get_all()
    {
        $this->db->select('permissions.*');
        $this->db->from('permissions');
        return $this->db->get()->result();
    }
}
