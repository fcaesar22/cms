<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webinar_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    public function getCountAll($key_search, $visible)
    {
        $this->db->select('*');
        $this->db->from('tab_webinar');
        if ($key_search!='null') {
            $this->db->like('topic', $key_search);
        }
        $this->db->where('is_visible', $visible);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getDatas($key_search, $sort_by, $order_sort, $visible, $rowperpage, $rowno)
    {
        $this->db->select('keyword_id');
        $this->db->from('keywords');
        $this->db->where('keyword_ref', 'WBR');
        $this->db->where('keyword_visible', 'Y');
        $query1 = $this->db->get();
        $result1 = $query1->result_array();
        foreach ($result1 as $key => $value) {
            $category_id[] = ','.$value["keyword_id"].',';
        }
        $this->db->select('*');
        $this->db->from('tab_webinar');
        if ($key_search!='null') {
            $this->db->like('topic', $key_search);
        }
        $this->db->where('is_visible', $visible);
        $this->db->order_by($sort_by, $order_sort);
        $this->db->limit($rowperpage, $rowno);  
        $query2 = $this->db->get();
        $result2 = $query2->result_array();
        $data = array();
        $i=0;
        foreach ($result2 as $key2 => $value2) {
            $pattern = '/(' . implode('|', $category_id) . ')/'; // $pattern = /(one|two|three)/
            $result = preg_match($pattern, $value2['keyword_id']);
            if ($result==1) {
                $_categories = $this->getCategoryName(explode(',', trim($value['keyword_id'], ',')));
                $data[$i] = array(
                    'webinar_id' => $value2['webinar_id'],
                    'webinarID' => $value2['webinarID'],
                    'topic' => $value2['topic'],
                    'start_time' => date_format(date_create($value2['start_time']), "d F Y H:i:s"),
                    'keywords' => implode(', ', $_categories),
                    'is_visible' => $value2['is_visible']
                );
                $i++;
            }
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

    public function activated($id)
    {
        $data = array(
            'webinar_id' => $id,     
            'is_visible' => 'Y'
        );
        $this->db->where('webinar_id', $id);
        $this->db->update('tab_webinar', $data);
        redirect(site_url('webinars'));
    }

    public function inactivated($id)
    {
        $data = array(
            'webinar_id' => $id,     
            'is_visible' => 'N'
        );
        $this->db->where('webinar_id', $id);
        $this->db->update('tab_webinar', $data);
        redirect(site_url('webinars'));
    }

    public function getData($type, $select, $table, $limit = null, $offset = null, $joins = null, $where = null, $group = null, $order = null)
    {
        if ($select != null) {
            $data = $this->db->select($select);
        }
        if ($joins != null) {
            foreach ($joins as $key => $values) {
                $data = $this->db->join($key, $values,'LEFT');
            }
        }
        if ($where != null) {
            foreach ($where as $key => $values) {
                $data = $this->db->where($key, $values);
            }
        }
        if ($group != null) {
            $data = $this->db->group_by($group);
        }
        if ($order != null) {
            foreach ($order as $key => $values) {
                $data = $this->db->order_by($key, $values);
            }
        }
        if ($limit != null) {
            if ($offset != null) {
                $data = $this->db->limit($limit, $offset);
            } else {
                $data = $this->db->limit($limit);
            }
        }
        if ($table != null) {
            $data = $this->db->get($table);
        }
        if ($data->num_rows() > 0) {
            return  ($type == 'result') ? $data->result() : $data->row();
        } else {
            return false;
        }
    }

    public function updateData($table = null, $data = null, $where = null)
    {
        $this->db->update($table, $data, $where);
        return $this->db->affected_rows();
    }

    public function get_category($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('keywords');
        if ($type == 'data') {
            if ($searchTerm!=null) {
                $this->db->like('keyword_name', $searchTerm);
            }
            $this->db->where('keyword_visible', 'Y');
            $this->db->where('keyword_ref', 'WBR');
            $this->db->order_by('keyword_id', 'desc');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm!=null) {
                $this->db->like('keyword_name', $searchTerm);
            }
            $this->db->where('keyword_visible', 'Y');
            $this->db->where('keyword_ref', 'WBR');
            return $this->db->get()->num_rows();
        }
    }

    public function get_category_by_id($id)
    {
        return $this->db->get_where('keywords', ['keyword_id' => $id])->row();
    }

    public function save_keyword($data)
    {
        $this->db->insert('keywords', $data);
        return $this->db->insert_id();
    }

    public function checkData($select, $table, $where)
    {
        if ($select != null) {
            $data = $this->db->select($select);
        }
        if ($where != null) {   
            foreach ($where as $key => $values) {
                $data = $this->db->where($key, $values);
            }
        }
        if ($table != null) {
            $data = $this->db->get($table);
        }
        if ($data->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function insert_webinar($webinar_data)
    {
        return $this->db->insert('tab_webinar', $webinar_data);
    }

    public function get_webinar_by_id($id)
    {
        $data = null;
        $this->db->select('*');
        $this->db->from('tab_webinar');
        $this->db->where('webinar_id', $id);
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        if ($num_rows>0) {
            $result = $query->result_array();
            $keywords = $result[0]['keyword_id'];
            if ($keywords!=null||$keywords!="") {
                $trimexplodetags =explode(',', trim($keywords,','));
                $this->db->select('keyword_id, keyword_name');
                $this->db->from('keywords');
                $this->db->where_in('keyword_id', $trimexplodetags);
                $querykeywords = $this->db->get()->result_array();
            } else {
                $querykeywords = null;
            }
            $result[0]['categories'] = $querykeywords;
            $data = $result[0];
        }
        return $data;
    }

    public function update_webinar($webinar_data)
    {
        $this->db->set('webinarID', $webinar_data['webinarID']);
        $this->db->set('uuid', $webinar_data['uuid']);
        $this->db->set('host_id', $webinar_data['host_id']);
        $this->db->set('host_email', $webinar_data['host_email']);
        $this->db->set('webinarPassword', $webinar_data['webinarPassword']);
        $this->db->set('keyword_id', $webinar_data['keyword_id']);
        $this->db->set('topic', $webinar_data['topic']);
        $this->db->set('agenda', $webinar_data['agenda']);
        $this->db->set('email_confirmation', $webinar_data['email_confirmation']);
        $this->db->set('vendor', $webinar_data['vendor']);
        $this->db->set('flag', $webinar_data['flag']);
        $this->db->set('start_time', $webinar_data['start_time']);
        $this->db->set('end_time', $webinar_data['end_time']);
        $this->db->set('duration', $webinar_data['duration']);
        $this->db->set('join_url', $webinar_data['join_url']);
        $this->db->set('registration_url', $webinar_data['registration_url']);
        $this->db->set('dens_join_url', $webinar_data['dens_join_url']);
        $this->db->set('dens_regis_url', $webinar_data['dens_regis_url']);
        $this->db->set('updated_by', $webinar_data['updated_by']);
        $this->db->set('updated_at', $webinar_data['updated_at']);
        $this->db->where('webinar_id', $webinar_data['webinar_id']);
        return $this->db->update('tab_webinar');
    }

    public function get_poster_banner_by_id($id)
    {
        $this->db->select('tab_webinar.webinar_id, poster.*');
        $this->db->from('tab_webinar');
        $this->db->join('poster','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = tab_webinar.webinar_id','Left');
        $this->db->like(array('poster.product_id' => 'WBR_'));
        $this->db->where(array('poster.poster_visible' => 'Y'));
        $this->db->where(array('tab_webinar.webinar_id' => $id));
        $this->db->order_by('poster.poster_id', 'ASC');
        $query = $this->db->get();
        $result = $query->result_array();
        $num = $query->num_rows();
        $data = array(
            'num' => $num,
            'result' => $result
        );
        return $data;
    }

    public function add_poster_banner($article_id,$poster_banner1,$poster_banner2,$poster_banner3,$time)
    {
        $entries = [
            array(
                'poster_type' => 'wbr_1280x720',
                'poster_url' => $poster_banner1,
                'poster_visible' => 'Y',
                'product_id' => 'WBR_'.$article_id.'_1',
                'poster_update' => $time
            ),
            array(
                'poster_type' => 'wbr_410x230',
                'poster_url' => $poster_banner2,
                'poster_visible' => 'Y',
                'product_id' => 'WBR_'.$article_id.'_1',
                'poster_update' => $time
            ),
            array(
                'poster_type' => 'wbr_235x132',
                'poster_url' => $poster_banner3,
                'poster_visible' => 'Y',
                'product_id' => 'WBR_'.$article_id.'_1',
                'poster_update' => $time
            )
        ];
        return $this->db->insert_batch('poster',$entries);
    }

    public function edit_poster_banner($article_id,$poster_banner1,$poster_banner2,$poster_banner3,$poster_id1,$poster_id2,$poster_id3,$time)
    {
        $entries = [
            array(
                'poster_id' => $poster_id1,
                'poster_url' => $poster_banner1,
                'poster_update' => $time
            ),
            array(
                'poster_id' => $poster_id2,
                'poster_url' => $poster_banner2,
                'poster_update' => $time
            ),
            array(
                'poster_id' => $poster_id3,
                'poster_url' => $poster_banner3,
                'poster_update' => $time
            )
        ];
        return $this->db->update_batch('poster', $entries, 'poster_id');
    }

    public function getimagebanner()
    {
        $data = $this->db->query("select poster_url from poster where poster_visible='Y'");
        return $data->result_array();
    }
}
