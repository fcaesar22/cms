<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catchup_schedule_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    public function category_catchup($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('category_tvshow');
        if ($type == 'data') {
            if ($searchTerm!=null) {
                $this->db->like('title_tvshow', $searchTerm);
            }
            $this->db->where('model', 'top_tvshow');
            $this->db->where('visible', 'Y');
            $this->db->order_by('CAST(sort AS DECIMAL)', 'ASC', FALSE);
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm!=null) {
                $this->db->like('title_tvshow', $searchTerm);
            }
            $this->db->where('model', 'top_tvshow');
            $this->db->where('visible', 'Y');
            return $this->db->get()->num_rows();
        }
    }

    public function getCountAll($key_search, $visible, $category)
    {
        $this->db->select('a.id_top_tvshow');
        $this->db->from('top_tvshow a');
        $this->db->join('tv_channel b', 'a.id_channel = b.seq');
        $this->db->join('category_tvshow c', 'a.category_tvshow = c.category_tvshow_id');
        if ($key_search != 'null') {
            $this->db->like('a.title', $key_search);
            $this->db->or_like('b.title', $key_search);
        }
        if ($category != 'null' && $category != '-1') {
            $this->db->where('a.category_tvshow', $category);
        }
        $this->db->where('a.visible', $visible);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getDatas($key_search, $sort_by, $order_sort, $visible, $category, $rowperpage, $rowno)
    {
        $this->db->select('a.id_top_tvshow, a.id_channel, a.title AS title_tvshow, a.description AS description_tvshow, a.sort, a.create_date, a.update_date, a.visible, b.title, b.description, c.category_tvshow_id, c.title_tvshow AS category_title');
        $this->db->from('top_tvshow a');
        $this->db->join('tv_channel b', 'a.id_channel = b.seq');
        $this->db->join('category_tvshow c', 'a.category_tvshow = c.category_tvshow_id');
        if ($key_search != 'null') {
            $this->db->like('a.title', $key_search);
            $this->db->or_like('b.title', $key_search);
        }
        if ($category != 'null' && $category != '-1') {
            $this->db->where('a.category_tvshow', $category);
        }
        $this->db->where('a.visible', $visible);
        if ($visible == 'Y') {
            $this->db->order_by('CAST(a.sort AS decimal) ASC', false);
        } else {
            $this->db->order_by($sort_by, $order_sort);
        }
        $this->db->limit($rowperpage, $rowno);  
        $query = $this->db->get();
        return $query->result_array();
    }

    public function update_sort($id_top_tvshow, $id_cat, $sort)
    {
        $this->db
            ->where('category_tvshow', $id_cat)
            ->where('id_top_tvshow', $id_top_tvshow)
            ->update('top_tvshow', [
                'sort' => $sort
            ]);

        return $this->db->affected_rows();
    }

    public function activated_catchup($id, $category, $time)
    {
        if (empty($id) && empty($category)) {
            return false;
        }

        $this->db->trans_start();

        $this->db->select('sort');
        $this->db->from('top_tvshow');
        $this->db->where('category_tvshow', $category);
        $this->db->where('visible', 'Y');
        $this->db->order_by('CAST(sort AS decimal) DESC', false);
        $sort = $this->db->get()->row('sort');

        $this->db->set('visible', 'Y');
        $this->db->set('sort', $sort + 1);
        $this->db->where('id_top_tvshow', $id);
        $this->db->update('top_tvshow');
        $this->db->trans_complete();
        
        $msg = true;

        if ($this->db->trans_status() === FALSE) {
            $msg = false;
        }

        return $msg;
    }

    public function inactivated_catchup($id, $category, $time)
    {
        if (empty($id) && empty($category)) {
            return false;
        }

        $this->db->trans_start();

        $this->db->set('visible', 'N');
        $this->db->set('sort', NULL);
        $this->db->where('id_top_tvshow', $id);
        $this->db->update('top_tvshow');

        $this->db->select('id_top_tvshow, sort');
        $this->db->from('top_tvshow');
        $this->db->where('category_tvshow', $category);
        $this->db->where('visible', 'Y');
        $this->db->order_by('CAST(sort AS decimal) ASC', false);
        $result = $this->db->get()->result_array();

        $data = array();
        $i=1;
        foreach ($result as $key => $value) {
            $data[] = array(
                'sort'=>$i,
                'id_top_tvshow'=>$value['id_top_tvshow']
            );
            $i++;
        }

        $this->db->update_batch('top_tvshow', $data, 'id_top_tvshow');
        
        $this->db->trans_complete();
        
        $msg = true;
        
        if ($this->db->trans_status() === FALSE) {
            $msg = false;
        }

        return $msg;
    }

    public function get_list_toptvshow_category($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('category_tvshow');
        if ($type == 'data') {
            if ($searchTerm!=null) {
                $this->db->like('title_tvshow', $searchTerm);
            }
            $this->db->where('model', 'top_tvshow');
            $this->db->where('visible', 'Y');
            $this->db->order_by('category_tvshow_id', 'asc');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm!=null) {
                $this->db->like('title_tvshow', $searchTerm);
            }
            $this->db->where('model', 'top_tvshow');
            $this->db->where('visible', 'Y');
            return $this->db->get()->num_rows();
        }
    }

    public function get_single_toptvshow_category($id)
    {
        $this->db->select('category_tvshow_id, title_tvshow');
        $this->db->from('category_tvshow');
        $this->db->where('category_tvshow_id', $id);
        return $this->db->get()->row();
    }

    public function get_list_category_channel($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('genre_tv');
        if ($type == 'data') {
            if ($searchTerm!=null) {
                $this->db->like('catname', $searchTerm);
            }
            $this->db->where_in('seq', [1, 2, 3, 13]);
            $this->db->where('visible', 'Y');
            $this->db->order_by('seq', 'asc');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm!=null) {
                $this->db->like('catname', $searchTerm);
            }
            $this->db->where_in('seq', [1, 2, 3, 13]);
            $this->db->where('visible', 'Y');
            return $this->db->get()->num_rows();
        }
    }

    public function get_single_category_channel($id)
    {
        $this->db->select('seq, catname');
        $this->db->from('genre_tv');
        $this->db->where('seq', $id);
        return $this->db->get()->row();
    }

    public function get_list_channel($categoryChannel, $perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('tv_channel');
        if ($type == 'data') {
            if ($searchTerm!=null) {
                $this->db->like('title', $searchTerm);
            }
            $this->db->like('genrelist', ',' . $categoryChannel . ',', 'both');
            $this->db->where('visible', 'Y');
            $this->db->order_by('seq', 'desc');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm!=null) {
                $this->db->like('title', $searchTerm);
            }
            $this->db->like('genrelist', ',' . $categoryChannel . ',', 'both');
            $this->db->where('visible', 'Y');
            return $this->db->get()->num_rows();
        }
    }

    public function get_single_channel($id)
    {
        $this->db->select('seq, title');
        $this->db->from('tv_channel');
        $this->db->where('seq', $id);
        return $this->db->get()->row();
    }

    public function list_schedule($idChannel="", $searchTerm="")
    {
        $data = array();

        $start = date('Y-m-d 00:00:00', strtotime('-6 days'));
        $end = date('Y-m-d 23:59:59');

        $this->db->select('seq, title, channel_code, start_time, end_time');
        $this->db->from('tv_schedule');
        $this->db->where('channel_code', $idChannel);
        $this->db->where('start_time >=', $start);
        $this->db->where('start_time <=', $end);

        if ($searchTerm != "") {
            $searchTerm = trim($searchTerm);

            $this->db->group_start();

            $this->db->like('title', $searchTerm, 'both');
            $this->db->or_like('start_time', $searchTerm, 'both');

            $this->db->group_end();
        }

        $this->db->order_by('start_time', 'ASC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $cat) {
                $data[] = array(
                    "id" => $cat['seq'],
                    "text" => $cat['title'] . ' | ' . $cat['start_time'] . ' - ' . $cat['end_time'],
                    "data" => $cat
                );
            }
        }

        return $data;
    }

    public function insert_catchup($catchup_data)
    {
        return $this->db->insert('top_tvshow', $catchup_data);
    }

    public function get_catchup_by_id($id)
    {
        $result = array();
        
        $this->db->select('*');
        $this->db->from('top_tvshow');
        $this->db->where('id_top_tvshow', $id);
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        
        if ($num_rows > 0) {
            $result = $query->result_array();
        }

        return $result;
    }

    public function update_catchup($id, $catchup_data)
    {
        $this->db->where('id_top_tvshow', $id);
        return $this->db->update('top_tvshow', $catchup_data);
    }

    public function getListKeywordCount($key_search, $visible)
    {
        $this->db->select('category_tvshow_id');
        $this->db->from('category_tvshow');
        
        if ($key_search != 'null') {
            $this->db->like('title_tvshow', $key_search);
        }

        $this->db->where('model', 'top_tvshow');
        $this->db->where('visible', $visible);
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function getDataListKeyword($key_search, $visible, $order_sort, $sort_by, $rowperpage, $rowno)
    {
        $this->db->select('category_tvshow_id, title_tvshow, show_number, visible, create_date, update_date');
        $this->db->from('category_tvshow');
        
        if ($key_search != 'null') {
            $this->db->like('title_tvshow', $key_search);
        }

        $this->db->where('model', 'top_tvshow');
        $this->db->where('visible', $visible);

        if ($visible == 'Y') {
            $this->db->order_by('CAST(sort AS decimal) ASC', false);
        } else {
            $this->db->order_by($sort_by, $order_sort);
        }

        $this->db->limit($rowperpage, $rowno);  
        $query = $this->db->get();
        
        return $query->result_array();
    }

    public function update_sort_category($page_id_array)
    {
        $this->db->trans_start();
        
        $data = [];
        $i = 1;
        
        foreach ($page_id_array as $id) {
            $data[] = [
                'category_tvshow_id'   => $id,
                'sort' => $i++
            ];
        }
        
        if (!empty($data)) {
            $this->db->update_batch('category_tvshow', $data, 'category_tvshow_id');
        }
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === false) {
            return ['error' => '1', 'message' => 'Failed to update sorting'];
        }
        
        return ['error' => '0', 'message' => 'Sorting updated successfully'];
    }

    public function activate_shownumber($id)
    {
        $this->db->set('show_number', 'Y');
        $this->db->where('category_tvshow_id', $id);
        return $this->db->update('category_tvshow');
    }

    public function inactivate_shownumber($id)
    {
        $this->db->set('show_number', 'N');
        $this->db->where('category_tvshow_id', $id);
        return $this->db->update('category_tvshow');
    }

    public function activate_keyword($id)
    {
        $this->db->select('sort');
        $this->db->from('category_tvshow');
        $this->db->where('model', 'top_tvshow');
        $this->db->where('visible', 'Y');
        $this->db->order_by('CAST(sort AS decimal) DESC', false);
        $sort = $this->db->get()->row('sort');

        $this->db->set('sort', $sort + 1);
        $this->db->set('visible', 'Y');
        $this->db->where('category_tvshow_id', $id);
        return $this->db->update('category_tvshow');
    }

    public function inactivate_keyword($id)
    {
        $this->db->trans_start();
        
        $this->db->set('sort', NULL);
        $this->db->set('visible', 'N');
        $this->db->where('category_tvshow_id', $id);
        $this->db->update('category_tvshow');
        
        $result = $this->db
            ->select('category_tvshow_id')
            ->where('model', 'top_tvshow')
            ->where('visible', 'Y')
            ->order_by('CAST(sort AS DECIMAL)', 'ASC', false)
            ->get('category_tvshow')
            ->result_array();
        
        $data = [];
        $i = 1;
        
        foreach ($result as $row) {
            $data[] = [
                'category_tvshow_id'   => $row['category_tvshow_id'],
                'sort' => $i++
            ];
        }

        if (!empty($data)) {
            $this->db->update_batch('category_tvshow', $data, 'category_tvshow_id');
        }

        $this->db->trans_complete();
        
        if ($this->db->trans_status() === false) {
            return false;
        }

        return true;
    }

    public function cu_keyword($category_tvshow_id, $titleCategory, $time, $type)
    {
        if ($type == 'create') {
            if ($category_tvshow_id != null || $category_tvshow_id != "") {
                return [
                    'status' => false,
                    'message' => 'Category ID must be empty when creating'
                ];
            }
            
            $data = [
                'title_tvshow' => $titleCategory,
                'show_number' => 'N',
                'model' => 'top_tvshow',
                'visible' => 'N',
                'create_date' => $time,
                'update_date' => $time
            ];

            $this->db->insert('category_tvshow', $data);

            return [
                'status' => true,
                'message' => 'Category successfully created'
            ];
        } else {
            if ($category_tvshow_id == null || $category_tvshow_id == "") {
                return [
                    'status' => false,
                    'message' => 'Category ID cannot be empty when updating'
                ];
            }
            
            $this->db->set('title_tvshow', $titleCategory);
            $this->db->set('update_date', $time);
            $this->db->where('category_tvshow_id', $category_tvshow_id);
            $this->db->update('category_tvshow');
            return [
                'status' => true,
                'message' => 'Category successfully updated'
            ];
        }
    }

    public function get_data_edit_keyword($id)
    {
        $this->db->select('*');
        $this->db->from('category_tvshow');
        $this->db->where('category_tvshow_id', $id);
        $query = $this->db->get()->result();
        return $query;
    }

    public function getImageBannerLandscape()
    {
        $data = $this->db->query("select banner_image from top_tvshow");
        return $data->result_array();
    }

    public function getImageBannerPortrait()
    {
        $data = $this->db->query("select banner_image_potrait from top_tvshow");
        return $data->result_array();
    }

    public function getImagePopUp()
    {
        $data = $this->db->query("select popup_image from top_tvshow");
        return $data->result_array();
    }
}
