<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vshort_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    public function getCountAll($key_search, $visible)
    {
        $this->db->select('id');
        $this->db->from('reels');
        if ($key_search!='null') {
            $this->db->like('title', $key_search);
        }
        $this->db->where('visible', $visible);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getDatas($key_search, $sort_by, $order_sort, $visible, $rowperpage, $rowno)
    {
        $this->db->select('*');
        $this->db->from('reels');
        if ($key_search!='null') {
            $this->db->like('title', $key_search);
        }
        $this->db->where('visible', $visible);
        $this->db->order_by($sort_by, $order_sort);
        if ($sort_by=='highlight') {
            $this->db->order_by('create_date', 'DESC');
        }
        $this->db->limit($rowperpage, $rowno);  
        $query = $this->db->get();
        return $query->result_array();
    }

    public function activated($id)
    {
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');
        $this->db->set('visible', 'Y');
        $this->db->set('ctrloc', '/vshorts/activated');
        $this->db->set('update_date', $time);
        $this->db->where('id', $id);
        $this->db->update('reels', $data);
        redirect(site_url('vshorts'));
    }

    public function inactivated($id)
    {
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');
        $this->db->set('highlight', 0);
        $this->db->set('visible', 'N');
        $this->db->set('ctrloc', '/vshorts/inactivated');
        $this->db->set('update_date', $time);
        $this->db->where('id', $id);
        $this->db->update('reels', $data);
        redirect(site_url('vshorts'));
    }

    public function activated_highlight_vshort($id)
    {
        $this->db->select('*');
        $this->db->from('reels');
        $this->db->where('highlight', 1);
        $this->db->where('visible', 'Y');
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        if ($num_rows>=15) {
            $data = array(
                'error' => false,
                'status' => 'failed'
            );
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $this->db->set('highlight', 1);
            $this->db->set('ctrloc', '/vshorts/activated_highlight_vshort');
            $this->db->set('update_date', $time);
            $this->db->where('id', $id);
            $this->db->update('reels', $data);
            $data = array(
                'error' => true,
                'status' => 'success'
            );
        }
        return $data;
    }

    public function inactivated_highlight_vshort($id)
    {
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');
        $this->db->set('highlight', 0);
        $this->db->set('ctrloc', '/vshorts/inactivated_highlight_vshort');
        $this->db->set('update_date', $time);
        $this->db->where('id', $id);
        $this->db->update('reels', $data);
        redirect(site_url('vshorts'));
    }

    public function get_tags($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('keywords');
        if ($type == 'data')
        {
            if ($searchTerm!=null) {
                $this->db->like('keyword_name', $searchTerm);
            }
            $this->db->where('keyword_visible', 'Y');
            $this->db->where('keyword_ref', 'TSH');
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
            $this->db->where('keyword_ref', 'TSH');
            return $this->db->get()->num_rows();
        }
    }

    public function get_tags_by_id($id)
    {
        return $this->db->get_where('keywords', ['keyword_id' => $id])->row();
    }

    public function insert_vshort($vshort_data)
    {
        return $this->db->insert('reels', $vshort_data);
    }

    public function get_vshort_by_id($id)
    {
        $data = null;
        $this->db->select('*');
        $this->db->from('reels');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        if ($num_rows>0) {
            $result = $query->result_array();
            $tags = $result[0]['tags'];
            if ($tags!=null||$tags!="") {
                $trimexplodetags =explode(',', trim($tags,','));
                $this->db->select('keyword_id, keyword_name');
                $this->db->from('keywords');
                $this->db->where_in('keyword_id', $trimexplodetags);
                $querytags = $this->db->get()->result_array();
            } else {
                $querytags = null;
            }
            $data = array(
                'id' => $result[0]['id'],
                'title' => $result[0]['title'],
                'description' => $result[0]['description'],
                'thumbnail_url' => $result[0]['thumbnail_url'],
                'video_url' => $result[0]['video_url'],
                'content_type' => $result[0]['content_type'],
                'content_id' => $result[0]['content_id'],
                'target' => $result[0]['target'],
                'location' => $result[0]['location'],
                'start_date' => $result[0]['start_date'],
                'end_date' => $result[0]['end_date'],
                'unlimited_list' => $result[0]['unlimited_list'],
                'tags' => $querytags,
                'visible' => $result[0]['visible'],
                'create_date' => $result[0]['create_date'],
                'update_date' => $result[0]['update_date'],
                'ctrloc' => $result[0]['ctrloc'],
            );
        }
        return $data;
    }

    public function update_vshort($vshort_data)
    {
        $this->db->set('title', $vshort_data['title']);
        $this->db->set('description', $vshort_data['description']);
        $this->db->set('thumbnail_url', $vshort_data['thumbnail_url']);
        $this->db->set('video_url', $vshort_data['video_url']);
        $this->db->set('content_type', $vshort_data['content_type']);
        $this->db->set('content_id', $vshort_data['content_id']);
        $this->db->set('target', $vshort_data['target']);
        $this->db->set('location', $vshort_data['location']);
        $this->db->set('unlimited_list', $vshort_data['unlimited_list']);
        $this->db->set('tags', $vshort_data['tags']);
        $this->db->set('start_date', $vshort_data['start_date']);
        $this->db->set('end_date', $vshort_data['end_date']);
        $this->db->set('update_date', $vshort_data['time']);
        $this->db->set('ctrloc', $vshort_data['ctrloc']);
        $this->db->where('id', $vshort_data['id']);
        return $this->db->update('reels');
    }

    public function save_tags($name_tag, $sort_tag, $child_tag, $sub_tag, $ref_tag, $visible_tag, $par_tag)
    { 
        $count = count($name_tag);
        for ($i = 0; $i<$count; $i++) {
            $checktag = $this->checktag($name_tag[$i]);
            if ($checktag<=0) {
                $entries[] = array(
                    'keyword_name'=>$name_tag[$i],
                    'keyword_sort'=>$sort_tag[$i],
                    'keyword_child'=>$child_tag[$i],
                    'keyword_sub'=>$sub_tag[$i],
                    'keyword_ref'=>$ref_tag[$i],
                    'keyword_visible'=>$visible_tag[$i],
                    'keyword_parentid'=>$par_tag[$i],
                );
            } else {
                $entries = array();
            }
        }
        if (!empty($entries)) {
            $this->db->insert_batch('keywords', $entries);
        }
    }

    public function getimagepotrait()
    {
        $data = $this->db->query("select thumbnail_url from reels");
        return $data->result_array();
    }
}
