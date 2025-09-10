<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Showcase_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    public function category_showcase($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('category_showcase');
        if ($type == 'data') {
            $this->db->like('category_name', $searchTerm);
            $this->db->where('visible', 'Y');
            $this->db->order_by('CAST(sort AS decimal) ASC', false);
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm!=null) {
                $this->db->like('category_name', $searchTerm);
            }
            $this->db->where('visible', 'Y');
            return $this->db->get()->num_rows();
        }
    }

    public function getCountAll($key_search, $visible, $category)
    {
        $this->db->select('showcase.id');
        $this->db->from('showcase');
        $this->db->join('category_showcase', 'showcase.category_id = category_showcase.id');
        if ($key_search != 'null') {
            $this->db->like('showcase.title', $key_search);
        }
        $this->db->where('showcase.category_id', $category);
        $this->db->where('showcase.visible', $visible);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getDatas($key_search, $sort_by, $order_sort, $visible, $category, $rowperpage, $rowno)
    {
        $this->db->select('showcase.id, showcase.sort, showcase.title, showcase.poster_url, category_showcase.category_name, showcase.visible, showcase.active, showcase.start_date, showcase.end_date');
        $this->db->from('showcase');
        $this->db->join('category_showcase', 'showcase.category_id = category_showcase.id');
        if ($key_search != 'null') {
            $this->db->like('showcase.title', $key_search);
        }
        $this->db->where('showcase.category_id', $category);
        $this->db->where('showcase.visible', $visible);
        if ($visible == 'Y') {
            $this->db->order_by('CAST(showcase.sort AS DECIMAL) ASC');
        }
        $this->db->order_by($sort_by, $order_sort);
        $this->db->limit($rowperpage, $rowno);  
        $query = $this->db->get();
        return $query->result_array();
    }

    public function update_sort($query)
    {
        return $this->db->query($query);
    }

    public function visible_showcase($id, $time)
    {
        $this->db->trans_start();
        $this->db->select('category_id');
        $this->db->from('showcase');
        $this->db->where('id', $id);
        $category_id = $this->db->get()->row('category_id');

        $this->db->select('sort');
        $this->db->from('showcase');
        $this->db->where('category_id', $category_id);
        $this->db->where('visible', 'Y');
        $this->db->order_by('CAST(sort AS decimal) DESC', false);
        $sort = $this->db->get()->row('sort');

        $this->db->set('visible', 'Y');
        $this->db->set('sort', $sort+1);
        $this->db->where('id', $id);
        $this->db->update('showcase');
        $this->db->trans_complete();
        $msg = true;
        if ($this->db->trans_status() === FALSE) {
            $msg = false;
        }
        return $msg;
    }

    public function unvisible_showcase($id, $time)
    {
        $this->db->trans_start();
        $this->db->set('visible', 'N');
        $this->db->set('sort', NULL);
        $this->db->where('id', $id);
        $this->db->update('showcase');

        $this->db->select('category_id');
        $this->db->from('showcase');
        $this->db->where('id', $id);
        $category_id = $this->db->get()->row('category_id');

        $this->db->select('id, sort');
        $this->db->from('showcase');
        $this->db->where('category_id', $category_id);
        $this->db->where('visible', 'Y');
        $this->db->order_by('CAST(sort AS decimal) ASC', false);
        $result = $this->db->get()->result_array();

        $data = array();
        $i=1;
        foreach ($result as $key => $value) {
            $data[] = array(
                'sort'=>$i,
                'id'=>$value['id']
            );
            $i++;
        }
        $this->db->update_batch('showcase', $data, 'id');
        $this->db->trans_complete();
        $msg = true;
        if ($this->db->trans_status() === FALSE) {
            $msg = false;
        }
        return $msg;
    }

    public function activated_showcase($id, $time)
    {
        $this->db->trans_start();
        $this->db->set('active', 'Y');
        $this->db->where('id', $id);
        $this->db->update('showcase');
        $this->db->trans_complete();
        $msg = true;
        if ($this->db->trans_status() === FALSE) {
            $msg = false;
        }
        return $msg;
    }

    public function inactivated_showcase($id, $time)
    {
        $this->db->trans_start();
        $this->db->set('active', 'N');
        $this->db->where('id', $id);
        $this->db->update('showcase');
        $this->db->trans_complete();
        $msg = true;
        if ($this->db->trans_status() === FALSE) {
            $msg = false;
        }
        return $msg;
    }

    public function get_list_category($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('category_showcase');
        if ($type == 'data') {
            if ($searchTerm!=null) {
                $this->db->like('category_name', $searchTerm);
            }
            $this->db->where('visible', 'Y');
            $this->db->order_by('CAST(sort AS decimal) ASC', false);
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm!=null) {
                $this->db->like('category_name', $searchTerm);
            }
            $this->db->where('visible', 'Y');
            return $this->db->get()->num_rows();
        }
    }

    public function get_category_by_id($id)
    {
        $this->db->select('id, category_name as title');
        $this->db->from('category_showcase');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }

    public function getListCategoryCount($key_search,$visible)
    {
        $this->db->select('id');
        $this->db->from('category_showcase');
        $this->db->where('visible', $visible);
        if ($key_search!='null') {
            $this->db->like('category_name', $key_search);
        }
        $query = $this->db->get();
        $result = $query->num_rows();
        return $result;
    }

    public function getDataListCategory($rowno,$rowperpage,$order_sort,$sort_by,$key_search,$visible)
    {
        $this->db->select('*');
        $this->db->from('category_showcase');
        $this->db->where('visible', $visible);
        if ($key_search!='null') {
            $this->db->like('category_name', $key_search);
        }
        if ($visible == 'Y') {
            $this->db->order_by('CAST(sort AS decimal) ASC', false);
        } else {
            $this->db->order_by($sort_by, $order_sort);
        }
        $this->db->limit($rowperpage, $rowno);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function update_sort_category($query)
    {
        return $this->db->query($query);
    }

    public function get_data_edit_category($id)
    {
        $this->db->select('*');
        $this->db->from('category_showcase');
        $this->db->where('id', $id);
        $query = $this->db->get()->result();
        return $query;
    }

    public function cu_category($cat_id,$category_name,$time,$by,$type)
    {
        if ($type=='create') {
            if ($cat_id!=null || $cat_id!="") {
                return false;
            }
            $data = array(
                'category_name' => $category_name,
                'visible' => 'N',
                'active' => 'N',
                'created_at' => $time,
                'created_by' => $by,
                'ctrloc' => '/showcases/cu_category'
            );
            $this->db->insert('category_showcase', $data);
            return true;
        } else {
            if ($cat_id==null || $cat_id=="") {
                return false;
            }
            $this->db->set('category_name', $category_name);
            $this->db->set('created_at', $time);
            $this->db->set('created_by', $by);
            $this->db->set('ctrloc', '/showcases/cu_category');
            $this->db->where('id', $cat_id);
            $this->db->update('category_showcase');
            return true;
        }
    }

    public function activeCategoryConfirm($id, $time, $by)
    {
        $this->db->trans_start();
        $this->db->select('sort');
        $this->db->from('category_showcase');
        $this->db->where('visible', 'Y');
        $this->db->order_by('CAST(sort AS decimal) DESC', false);
        $sort = $this->db->get()->row('sort');

        $this->db->set('visible', 'Y');
        $this->db->set('sort', $sort+1);
        $this->db->where('id', $id);
        $this->db->update('category_showcase');
        $this->db->trans_complete();
        $msg = true;
        if ($this->db->trans_status() === FALSE) {
            $msg = false;
        }
        return $msg;
    }

    public function inactiveCategoryConfirm($id, $time, $by)
    {
        $this->db->trans_start();
        $this->db->set('visible', 'N');
        $this->db->set('sort', NULL);
        $this->db->where('id', $id);
        $this->db->update('category_showcase');

        $this->db->select('id, sort');
        $this->db->from('category_showcase');
        $this->db->where('visible', 'Y');
        $this->db->order_by('CAST(sort AS decimal) ASC', false);
        $result = $this->db->get()->result_array();
        $data = array();
        $i=1;
        foreach ($result as $key => $value) {
            $data[] = array(
                'sort'=>$i,
                'id'=>$value['id']
            );
            $i++;
        }
        $this->db->update_batch('category_showcase', $data, 'id');
        $this->db->trans_complete();
        $msg = true;
        if ($this->db->trans_status() === FALSE) {
            $msg = false;
        }
        return $msg;
    }

    public function insert_showcase($showcase_data)
    {
        return $this->db->insert('showcase', $showcase_data);
    }

    public function get_showcase_by_id($id)
    {
        $_arr = array();
        $this->db->select('A.*, B.category_name');
        $this->db->from('showcase AS A');
        $this->db->join('category_showcase AS B', 'B.id = A.category_id');
        $this->db->where(array('A.id' => $id));
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function update_showcase($showcase_data)
    {
        $this->db->set('category_id', $showcase_data['category_id']);
        $this->db->set('title', $showcase_data['title']);
        $this->db->set('barcode_url', $showcase_data['barcode_url']);
        $this->db->set('start_date', $showcase_data['start_date']);
        $this->db->set('end_date', $showcase_data['end_date']);
        $this->db->set('poster_url', $showcase_data['poster_url']);
        $this->db->set('poster_type', $showcase_data['poster_type']);
        $this->db->set('created_at', $showcase_data['created_at']);
        $this->db->set('created_by', $showcase_data['created_by']);
        $this->db->set('ctrloc', $showcase_data['ctrloc']);
        $this->db->where('id', $showcase_data['id']);
        return $this->db->update('showcase');
    }

    public function getimagelandscape()
    {
        $data = $this->db->query("select poster_url from showcase where visible='Y'");
        return $data->result_array();
    }
}
