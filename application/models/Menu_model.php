<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model {
	public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    public function getCountAll($key_search)
    {
        $this->db->select('menus.id');
        $this->db->from('menus');
        if ($key_search!='null') {
            $this->db->like('menus.name', $key_search);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getDatas($key_search, $sort_by, $order_sort, $rowperpage, $rowno)
    {
        $this->db->select('*');
        $this->db->from('menus');
        if ($key_search!='null') {
            $this->db->like('menus.name', $key_search);
        }
        $this->db->order_by($sort_by, $order_sort);
        $this->db->limit($rowperpage, $rowno);  
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_parents($exclude_id = null)
    {
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        $this->db->where('parent_id IS NULL', null, false);
        return $this->db->get('menus')->result();
    }

    public function insert($data)
    {
        return $this->db->insert('menus', $data);
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('menus', ['id' => $id])->row();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('menus', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('menus');
    }

    public function get_permissions_by_role($role_id)
    {
        $this->db->select('permission_id');
        $this->db->from('role_permissions');
        $this->db->where('role_id', $role_id);
        $query = $this->db->get();
        return array_column($query->result_array(), 'permission_id');
    }

    // views /layouts/sidebar.php
    public function get_menu_by_role($role_id)
    {
        $permission_ids = $this->get_permissions_by_role($role_id);

        if (empty($permission_ids)) {
            return [];
        }

        $this->db->distinct();
        $this->db->select('menus.*');
        $this->db->from('menus');
        $this->db->join('menu_permissions', 'menus.id = menu_permissions.menu_id', 'inner');
        $this->db->where_in('menu_permissions.permission_id', $permission_ids);
        $this->db->order_by('menus.parent_id, menus.sort_order');

        $menus = $this->db->get()->result();

        $menu_ids = array_column($menus, 'id');

        $additional_parents = [];
        foreach ($menus as $menu) {
            if ($menu->parent_id && !in_array($menu->parent_id, $menu_ids)) {
                $additional_parents[] = $menu->parent_id;
            }
        }
        $additional_parents = array_unique($additional_parents);

        if (!empty($additional_parents)) {
            $this->db->where_in('id', $additional_parents);
            $parents = $this->db->get('menus')->result();
            $menus = array_merge($menus, $parents);
        }

        return $menus;
    }
}
