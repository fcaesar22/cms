<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Podcast_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    public function getCountAll($key_search, $visible)
    {
        $this->db->select('A.podcast_id');
        $this->db->from('podcast AS A');
        $this->db->join('podcast_data AS B', 'A.podcast_id = B.podcast_id', 'Left');
        $this->db->join('podcast_recommendation AS C', 'A.podcast_id = C.podcast_id', 'Left');
        if ($key_search!='null') {
            $this->db->like('A.podcast_id', $key_search);
            $this->db->or_like('A.podcast_name', $key_search);
        }
        $this->db->where('A.visible', $visible);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getDatas($key_search, $sort_by, $order_sort, $visible, $rowperpage, $rowno)
    {
        $sort_by = 'A.'.$sort_by;
        $this->db->select('A.*, B.podcast_image, C.podcast_id as id_pod_rec, C.start_periode, C.end_periode');
        $this->db->from('podcast AS A');
        $this->db->join('podcast_data AS B', 'A.podcast_id = B.podcast_id', 'Left');
        $this->db->join('podcast_recommendation AS C', 'A.podcast_id = C.podcast_id', 'Left');
        if ($key_search!='null') {
            $this->db->like('A.podcast_id', $key_search);
            $this->db->or_like('A.podcast_name', $key_search);
        }
        $this->db->where('A.visible', $visible);
        $this->db->order_by($sort_by, $order_sort);
        $this->db->limit($rowperpage, $rowno);
        $query = $this->db->get();
        $records = $query->result_array();
        $data = array();
        date_default_timezone_set("Asia/Jakarta"); 
        $date_now = date('Y-m-d');
        $i=0;
        foreach ($records as $key => $value) {
            if ($date_now > $value['end_periode'] || $value['end_periode']==null) {
                $status = 'FALSE';
            }else{
                $status = 'TRUE';
            }
            $_categories = $this->getCategoryName(explode(',', trim($value['keyword_id'], ',')));
            $data[$i] = array(
                'podcast_id'=>$value['podcast_id'],
                'podcast_name'=>$value['podcast_name'],
                'podcast_image'=>$value['podcast_image'],
                'visible'=>$value['visible'],
                'categories'=>implode(', ', $_categories),
                'id_pod_rec'=>$value['id_pod_rec'],
                'start_periode'=>$value['start_periode'],
                'end_periode'=>$value['end_periode'],
                'status'=>$status,
            );
            $i++;
        }
        return $data;
    }

    public function getCategoryName($id)
    {
        $_arr = array();
        $sql = $this->db->select('*')
                        ->from('keywords')
                        ->where_in('keyword_id', $id)
                        ->get()
                        ->result_array();
        if (count($sql)==0) {
            return false;
        }
        foreach ($sql as $key => $value) {
            array_push($_arr, $value['keyword_name']);
        }
        return $_arr;
    }

    public function save_podcast_recom($podcast_id, $datetimestart, $datetimeend, $time, $by)
    {
        $this->db->select('*');
        $this->db->from('podcast_recommendation');
        $this->db->where(array('podcast_id' => $podcast_id));
        $query = $this->db->get()->result_array();
        if ($query==null) {
            $data = array(
                'podcast_id' => $podcast_id,
                'start_periode' => $datetimestart,
                'end_periode' => $datetimeend,
                'created_at' => $time,
                'created_by' => $by,
                'updated_at' => $time,
                'updated_by' => $by,
                'ctrloc' => '/podcasts/save_podcast_recom'
            );
            $this->db->insert('podcast_recommendation',$data);
            return $this->db->insert_id();
        } else {
            $this->db->set('start_periode', $datetimestart);
            $this->db->set('end_periode', $datetimeend);
            $this->db->set('updated_at', $time);
            $this->db->set('updated_by', $by);
            $this->db->set('ctrloc', '/podcasts/save_podcast_recom');
            $this->db->where('podcast_id', $podcast_id);
            $this->db->update('podcast_recommendation');
        }
    }

    public function activated($id)
    {
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');
        $data = array(
            'podcast_id' => $id,     
            'visible' => 'Y',
            'ctrloc' => '/podcasts/activated',
            'updated_at' => $time
        );
        $this->db->where('podcast_id', $id);
        $this->db->update('podcast', $data);
        redirect(site_url('podcasts'));
    }

    public function inactivated($id)
    {
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');
        $data = array(
            'podcast_id'   => $id,     
            'visible' => 'N',
            'ctrloc' => '/podcasts/inactivated',
            'updated_at' => $time
        );
        $this->db->where('podcast_id', $id);
        $this->db->update('podcast', $data);
        redirect(site_url('podcasts'));
    }

    public function get_list_category($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('keywords');
        if ($type == 'data')
        {
            if ($searchTerm!=null) {
                $this->db->like('keyword_name', $searchTerm);
            }
            $this->db->where('keyword_visible', 'Y');
            $this->db->where('keyword_ref', 'POD');
            $this->db->where('keyword_parentid', null);
            $this->db->order_by('keyword_id', 'desc');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        }
        else
        {
            if ($searchTerm!=null) {
                $this->db->like('keyword_name', $searchTerm);
            }
            $this->db->where('keyword_visible', 'Y');
            $this->db->where('keyword_ref', 'POD');
            $this->db->where('keyword_parentid', null);
            return $this->db->get()->num_rows();
        }
    }

    public function get_category_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->where('keyword_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $key => $value) {
                $data = array(
                    'id' => $value['keyword_id'],
                    'title' => $value['keyword_name']
                );
            }
        } else {
            $data = array();
        }
        return $data;
    }

    public function get_list_sub_category($perPage, $page, $searchTerm, $category_id, $type)
    {
        $this->db->select('*');
        $this->db->from('keywords');
        if ($type == 'data')
        {
            if ($searchTerm!=null) {
                $this->db->like('keyword_name', $searchTerm);
            }
            $this->db->where('keyword_visible', 'Y');
            $this->db->where('keyword_ref', 'POD');
            $this->db->where('keyword_parentid', ','.$category_id.',');
            $this->db->order_by('keyword_id', 'desc');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        }
        else
        {
            if ($searchTerm!=null) {
                $this->db->like('keyword_name', $searchTerm);
            }
            $this->db->where('keyword_visible', 'Y');
            $this->db->where('keyword_ref', 'POD');
            $this->db->where('keyword_parentid', ','.$category_id.',');
            return $this->db->get()->num_rows();
        }
    }

    public function get_sub_category_by_id($id)
    {
        return $this->db->get_where('keywords', ['keyword_id' => $id])->row();
    }

    public function insert_podcast($podcast_data)
    {
        $this->db->insert('podcast', $podcast_data);
        return $podcast_id = $this->db->insert_id();
    }

    public function insert_podcast_data($podcast_data)
    {
        $data = array(
            'podcast_id' => $podcast_data['podcast_id'],
            'podcast_title' => $podcast_data['podcast_title'],
            'podcast_desc' => $podcast_data['podcast_desc'],
            'podcast_link' => $podcast_data['podcast_link'],
            'podcast_image' => $podcast_data['podcast_image'],
            'podcast_author' => $podcast_data['podacst_author'],
            'podcast_copyright' => $podcast_data['podcast_copyright'],
            'podcast_builddate' => $podcast_data['podcast_builddate'],
            'podcast_lang' => $podcast_data['podcast_language'],
            'created_at' => $podcast_data['created_at'],
            'updated_at' => $podcast_data['updated_at'],
            'ctrloc' => $podcast_data['ctrloc']
        );
        $this->db->insert('podcast_data',$data);
        return $this->db->insert_id();
    }

    public function insert_podcast_episode($podcast_episode)
    {
        $this->db->insert_batch('podcast_episode',$podcast_episode);
        return $this->db->insert_id();
    }

    public function get_podcast_by_id($podcast_id)
    {
        $this->db->select('A.*');
        $this->db->from('podcast AS A');
        $this->db->where('A.podcast_id', $podcast_id);
        $query = $this->db->get()->result_array();
        $data = array();
        $i=0;
        foreach ($query as $key => $value) {
            $id_keywords = trim($value['keyword_id'], ',');
            $this->db->select('keyword_id as category_id, keyword_name as category_name');
            $this->db->from('keywords');
            $this->db->where('keyword_ref', 'POD');
            $this->db->where('keyword_parentid', null);
            $this->db->where('keyword_id in ('.$id_keywords.')');
            $this->db->limit(1);
            $query_category = $this->db->get()->result_array();

            $this->db->select('keyword_id as sub_category_id, keyword_name as sub_category_name');
            $this->db->from('keywords');
            $this->db->where('keyword_ref', 'POD');
            $this->db->where('keyword_parentid != "null"');
            $this->db->where('keyword_id in ('.$id_keywords.')');
            $query_subcategory = $this->db->get()->result_array();
            
            $data[$i] = array(
                'podcast_id'=>$value['podcast_id'],
                'podcast_name'=>$value['podcast_name'],
                'podcast_link_rss'=>$value['podcast_link_rss'],
                'category_id'=>$query_category[0]['category_id'],
                'category_name'=>$query_category[0]['category_name'],
                'sub_category'=>$query_subcategory,
                'visible'=>$value['visible']
            );
            $i++;
        }
        return $data;
    }

    public function update_podcast($podcast_data)
    {
        $this->db->set('podcast_name', $podcast_data['podcast_name']);
        $this->db->set('podcast_link_rss', $podcast_data['podcast_link_rss']);
        $this->db->set('keyword_id', $podcast_data['keyword_id']);
        $this->db->set('updated_at', $podcast_data['updated_at']);
        $this->db->set('updated_by', $podcast_data['updated_by']);
        $this->db->set('ctrloc', $podcast_data['ctrloc']);
        $this->db->where('podcast_id', $podcast_data['podcast_id']);
        return $this->db->update('podcast');
    }

    public function update_podcast_data($podcast_data)
    {
        $this->db->set('podcast_title', $podcast_data['podcast_title']);
        $this->db->set('podcast_desc', $podcast_data['podcast_desc']);
        $this->db->set('podcast_link', $podcast_data['podcast_link']);
        $this->db->set('podcast_image', $podcast_data['podcast_image']);
        $this->db->set('podcast_author', $podcast_data['podacst_author']);
        $this->db->set('podcast_copyright', $podcast_data['podcast_copyright']);
        $this->db->set('podcast_builddate', $podcast_data['podcast_builddate']);
        $this->db->set('podcast_lang', $podcast_data['podcast_language']);
        $this->db->set('updated_at', $podcast_data['updated_at']);
        $this->db->set('ctrloc', $podcast_data['ctrloc']);
        $this->db->where('podcast_id', $podcast_data['podcast_id']);
        $this->db->update('podcast_data');
    }

    public function get_pod_data_id($podcast_id)
    {
        $this->db->select('podcast_data_id');
        $this->db->from('podcast_data');
        $this->db->where('podcast_id', $podcast_id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_eps_data($podcast_id)
    {
        $this->db->select('A.*');
        $this->db->from('podcast_episode AS A');
        $this->db->where(array('A.podcast_data_id' => $podcast_id));
        $query = $this->db->get()->result_array();
        $_arr = array();
        if ($query!=null) {
            $i=0;
            foreach ($query as $key => $value) {
                $_arr[$i] = array(
                    'podcast_episode_id'=>$value['podcast_episode_id']
                );
                $i++;
            }
        }
        return $_arr;
    }

    public function insert_pod_eps($insert_podcast_eps)
    {
        $this->db->insert_batch('podcast_episode',$insert_podcast_eps);
        return $this->db->insert_id();
    }

    public function insert_batch_pod($podcast_batch)
    {
        $this->db->insert_batch('podcast_episode',$podcast_batch);
        return $this->db->insert_id();
    }

    public function save_category($data)
    {
        $this->db->insert('keywords', $data);
        return $this->db->insert_id();
    }

    public function getListCategoryCount($key_search,$visible,$keyword_refer)
    {
        $this->db->select('count(keyword_id) as allcount');
        $this->db->from('keywords');
        if ($key_search!='null') {
            $this->db->like('keyword_id', $key_search);
            $this->db->or_like('keyword_name', $key_search);
        }
        $this->db->where('keyword_visible', $visible);
        $this->db->where('keyword_ref', $keyword_refer);
        $this->db->where('keyword_parentid', null);
        $this->db->where('icon !=', null);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result[0]['allcount'];
    }

    public function getDataListCategory($rowno,$rowperpage,$order_sort,$sort_by,$key_search,$visible,$keyword_refer)
    {
        $this->db->select('keyword_id,keyword_name,keyword_ref,keyword_parentid,keyword_visible,icon');
        $this->db->from('keywords');
        if ($key_search!='null') {
            $this->db->like('keyword_id', $key_search);
            $this->db->or_like('keyword_name', $key_search);
        }
        $this->db->where('keyword_visible',$visible);
        $this->db->where('keyword_ref', $keyword_refer);
        $this->db->where('keyword_parentid', null);
        $this->db->where('icon !=', null);
        $this->db->order_by($sort_by, $order_sort);
        $this->db->limit($rowperpage, $rowno);  
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_data_edit_category($id)
    {
        $this->db->select('keyword_id,keyword_name,icon,color_background');
        $this->db->from('keywords');
        $this->db->where('keyword_id', $id);
        $query = $this->db->get()->result();
        return $query;
    }

    public function edit_category($keyword_id,$keyword_name,$keyword_icon,$color_background)
    {
        $this->db->set('keyword_name', $keyword_name);
        $this->db->set('icon', $keyword_icon);
        $this->db->set('color_background', $color_background);
        $this->db->where('keyword_id', $keyword_id);
        return $this->db->update('keywords');
    }

    public function active_category($id)
    {
        $this->db->set('keyword_visible','Y');
        $this->db->where('keyword_id',$id);
        return $this->db->update('keywords');
    }

    public function inactive_category($id)
    {
        $this->db->set('keyword_visible','N');
        $this->db->where('keyword_id',$id);
        return $this->db->update('keywords');
    }

    public function save_sub_category($data)
    {
        $this->db->insert('keywords', $data);
        return $this->db->insert_id();
    }

    public function getListSubCategoryCount($key_search,$visible,$keyword_refer,$conid)
    {
        $this->db->select('count(keyword_id) as allcount');
        $this->db->from('keywords');
        if ($key_search!='null') {
            $this->db->like('keyword_id', $key_search);
            $this->db->or_like('keyword_name', $key_search);
        }
        $this->db->where('keyword_visible', $visible);
        $this->db->where('keyword_ref', $keyword_refer);
        $this->db->where('keyword_parentid', ','.$conid.',');
        $this->db->where('icon', null);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result[0]['allcount'];
    }

    public function getDataListSubCategory($rowno,$rowperpage,$order_sort,$sort_by,$key_search,$visible,$keyword_refer,$conid)
    {
        $this->db->select('keyword_id,keyword_name,keyword_ref,keyword_parentid,keyword_visible,icon');
        $this->db->from('keywords');
        if ($key_search!='null') {
            $this->db->like('keyword_id', $key_search);
            $this->db->or_like('keyword_name', $key_search);
        }
        $this->db->where('keyword_visible',$visible);
        $this->db->where('keyword_ref', $keyword_refer);
        $this->db->where('keyword_parentid', ','.$conid.',');
        $this->db->where('icon', null);
        $this->db->order_by($sort_by, $order_sort);
        $this->db->limit($rowperpage, $rowno);  
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_data_edit_subcategory($id)
    {
        $this->db->select('keyword_id,keyword_name,icon');
        $this->db->from('keywords');
        $this->db->where('keyword_id', $id);
        $query = $this->db->get()->result();
        return $query;
    }

    public function edit_subcategory($keyword_id,$keyword_name)
    {
        $this->db->set('keyword_name', $keyword_name);
        $this->db->where('keyword_id', $keyword_id);
        return $this->db->update('keywords');
    }
}
