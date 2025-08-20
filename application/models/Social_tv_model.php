<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Social_tv_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    public function getCountAll($key_search, $visible, $category)
    {
        $this->db->select('A.socialtv_id');
        $this->db->from('tmp_socialtv AS A');
        $this->db->join('poster AS B','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = A.socialtv_id','Left');
        $this->db->like('A.keyword_parent_id', ','.$category.',');
        if ($key_search!='null') {
            $this->db->like('A.socialtv_id', $key_search);
            $this->db->or_like('A.socialtv_name', $key_search);
        }
        $this->db->where('A.visible', $visible);
        $this->db->where('B.poster_type', 'scvp_1280x720');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getDatas($key_search, $sort_by, $order_sort, $visible, $category, $rowperpage, $rowno)
    {
        $sort_by = 'A.'.$sort_by;
        $this->db->select('A.*, B.*');
        $this->db->from('tmp_socialtv AS A');
        $this->db->join('poster AS B','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = A.socialtv_id','Left');
        $this->db->like('A.keyword_parent_id', ','.$category.',');
        if ($key_search!='null') {
            $this->db->like('A.socialtv_id', $key_search);
            $this->db->or_like('A.socialtv_name', $key_search);
        }
        $this->db->where('A.visible', $visible);
        $this->db->where('B.poster_type', 'scvp_1280x720');
        $this->db->order_by($sort_by, $order_sort);
        $this->db->limit($rowperpage, $rowno);  
        $query = $this->db->get();
        $records = $query->result_array();
        $data = array();
        $i=0;
        foreach ($records as $key => $value) {
            $_categories = $this->getCategoryName(explode(',', trim($value['keyword_parent_id'], ',')));
            $data[$i] = array(
                'socialtv_id'=>$value['socialtv_id'],
                'socialtv_name'=>$value['socialtv_name'],
                'visible'=>$value['visible'],
                'categories'=>implode(', ', $_categories),
                'poster_url'=>$value['poster_url'],
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

    public function activated_social_tv($id)
    {
        $data = array(
            'socialtv_id'   => $id,     
            'visible'      => 'Y'
        );
        $this->db->where('socialtv_id', $id);
        $this->db->update('tmp_socialtv', $data);
        redirect(site_url('social_tvs'));
    }

    public function inactivated_social_tv($id)
    {
        $data = array(
            'socialtv_id'   => $id,     
            'visible'      => 'N'
        );
        $this->db->where('socialtv_id', $id);
        $this->db->update('tmp_socialtv', $data);
        redirect(site_url('social_tvs'));
    }

    public function get_content_type($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('keywords');
        if ($type == 'data') {
            if ($searchTerm!=null) {
                $this->db->like('keyword_name', $searchTerm);
            }
            $this->db->where('keyword_visible', 'Y');
            $this->db->where('keyword_ref', 'CYC');
            $this->db->not_like('keyword_name', 'WBR-WEBINAR');
            $this->db->order_by('keyword_id', 'asc');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm!=null) {
                $this->db->like('keyword_name', $searchTerm);
            }
            $this->db->where('keyword_visible', 'Y');
            $this->db->where('keyword_ref', 'CYC');
            $this->db->not_like('keyword_name', 'WBR-WEBINAR');
            return $this->db->get()->num_rows();
        }
    }

    public function get_content_type_by_id($id)
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

    public function get_list_category($perPage, $page, $searchTerm, $category_id, $type)
    {
        $this->db->select('*');
        $this->db->from('keywords');
        if ($type == 'data') {
            if ($searchTerm!=null) {
                $this->db->like('keyword_name', $searchTerm);
            }
            if ($category_id=='246') { // denslife
                $this->db->where('keyword_ref', 'SDL');
                $this->db->where('keyword_parentid', ','.$category_id.',');
            } elseif ($category_id=='247') { // densplay
                $this->db->where('keyword_ref', 'SCV');
                $this->db->where('keyword_parentid', ','.$category_id.',');
            } elseif ($category_id=='325') { // densknowledge
                $this->db->where('keyword_ref', 'SDK');
                $this->db->where('keyword_parentid', ','.$category_id.',');
            } elseif ($category_id=='1076') { // denssport
                $this->db->where('keyword_ref', 'SDP');
                $this->db->where('keyword_parentid', ','.$category_id.',');
            } elseif ($category_id=='1077') { // densshort
                $this->db->where('keyword_ref', 'SDM');
                $this->db->where('keyword_parentid', ','.$category_id.',');
            }
            $this->db->where('keyword_visible', 'Y');
            $this->db->order_by('keyword_id', 'desc');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm!=null) {
                $this->db->like('keyword_name', $searchTerm);
            }
            if ($category_id=='246') { // denslife
                $this->db->where('keyword_ref', 'SDL');
                $this->db->where('keyword_parentid', ','.$category_id.',');
            } elseif ($category_id=='247') { // densplay
                $this->db->where('keyword_ref', 'SCV');
                $this->db->where('keyword_parentid', ','.$category_id.',');
            } elseif ($category_id=='325') { // densknowledge
                $this->db->where('keyword_ref', 'SDK');
                $this->db->where('keyword_parentid', ','.$category_id.',');
            } elseif ($category_id=='1076') { // denssport
                $this->db->where('keyword_ref', 'SDP');
                $this->db->where('keyword_parentid', ','.$category_id.',');
            } elseif ($category_id=='1077') { // densshort
                $this->db->where('keyword_ref', 'SDM');
                $this->db->where('keyword_parentid', ','.$category_id.',');
            }
            $this->db->where('keyword_visible', 'Y');
            return $this->db->get()->num_rows();
        }
    }

    public function get_categories_by_id($id)
    {
        return $this->db->get_where('keywords', ['keyword_id' => $id])->row();
    }

    public function get_source($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('keywords');
        if ($type == 'data') {
            if ($searchTerm!=null) {
                $this->db->like('keyword_name', $searchTerm);
            }
            $this->db->where('keyword_visible', 'Y');
            $this->db->where('keyword_ref', 'SSC');
            $this->db->order_by('keyword_id', 'asc');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm!=null) {
                $this->db->like('keyword_name', $searchTerm);
            }
            $this->db->where('keyword_visible', 'Y');
            $this->db->where('keyword_ref', 'SSC');
            return $this->db->get()->num_rows();
        }
    }

    public function get_source_by_id($id)
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

    public function insert_social_tv($socialtv_data,$poster_content1,$poster_content2,$poster_content3,$time)
    {
        $this->db->insert('tmp_socialtv', $socialtv_data);
        $id_socialtv = $this->db->insert_id();
        $entries = [array(
            'poster_type' => 'scvp_1280x720',
            'poster_url' => $poster_content1,
            'poster_visible' => 'Y',
            'product_id' => 'SCVP_'.$id_socialtv.'_1',
            'poster_update' => $time
        ),
        array(
            'poster_type' => 'scvp_410x230',
            'poster_url' => $poster_content2,
            'poster_visible' => 'Y',
            'product_id' => 'SCVP_'.$id_socialtv.'_1',
            'poster_update' => $time
        ),
        array(
            'poster_type' => 'scvp_235x132',
            'poster_url' => $poster_content3,
            'poster_visible' => 'Y',
            'product_id' => 'SCVP_'.$id_socialtv.'_1',
            'poster_update' => $time
        )];
        return $this->db->insert_batch('poster',$entries);
    }

    public function get_social_tv_by_id($socialtv_id)
    {
        $this->db->select('A.socialtv_id, A.socialtv_name, A.description, A.channel_id, B.keyword_id AS source_id, B.keyword_name AS source_name, A.keyword_parent_id');
        $this->db->from('tmp_socialtv AS A');
        $this->db->join('keywords AS B', 'A.source = B.keyword_id', 'Left');
        $this->db->where('A.socialtv_id', $socialtv_id);
        $this->db->where('B.keyword_ref', 'SSC');
        $query1 = $this->db->get()->result_array();

        $this->db->select('poster_id, poster_url, poster_type');
        $this->db->from('poster');
        $this->db->where('product_id', 'SCVP_'.$socialtv_id.'_1');
        $this->db->where('poster_visible', 'Y');
        $this->db->order_by('poster_id', 'ASC');
        $query2 = $this->db->get()->result_array();

        $keyword_id = $query1[0]['keyword_parent_id'];
        $trimexplode =explode(',', trim($keyword_id,','));

        $this->db->select('keyword_id, keyword_name');
        $this->db->from('keywords');
        $this->db->where_in('keyword_id', $trimexplode);
        $this->db->where('keyword_visible', 'Y');
        $this->db->where('keyword_ref', 'CYC');
        $this->db->limit(1);
        $query3 = $this->db->get()->result_array();

        $content_id = $query3[0]['keyword_id'];

        $this->db->select('keyword_id AS category_id, keyword_name AS category_name');
        $this->db->from('keywords');
        $this->db->where_in('keyword_id', $trimexplode);
        $this->db->where('keyword_visible', 'Y');
        $this->db->where('keyword_parentid', ','.$content_id.',');
        $this->db->where('keyword_ref !=', 'CYC');
        $query4 = $this->db->get()->result_array();

        $data = array(
            'socialtv_id' => $query1[0]['socialtv_id'],
            'socialtv_name' => $query1[0]['socialtv_name'],
            'description' => $query1[0]['description'],
            'channel_id' => $query1[0]['channel_id'],
            'source_id' => $query1[0]['source_id'],
            'source_name' => $query1[0]['source_name'],
            'content_id' => $query3[0]['keyword_id'],
            'content_name' => $query3[0]['keyword_name'],
            'categories' => $query4,
            'posters' => $query2
        );
        return $data;
    }

    public function update_social_tv($socialtv_id,$time,$by,$socialtv_name,$description,$channel_id,$source,$content_type,$keyword_parent_id,$poster_content1,$poster_content2,$poster_content3,$poster_id1,$poster_id2,$poster_id3)
    {
        $this->db->set('socialtv_name', $socialtv_name);
        $this->db->set('description', $description);
        $this->db->set('channel_id', $channel_id);
        $this->db->set('source', $source);
        $this->db->set('keyword_parent_id', $keyword_parent_id);
        $this->db->set('updated_at', $time);
        $this->db->set('updated_by', $by);
        $this->db->set('ctrloc', '/social_tv/edit/');
        $this->db->where('socialtv_id', $socialtv_id);
        $this->db->update('tmp_socialtv');

        $entries = [array(
            'poster_url' => $poster_content1,
            'poster_id' => $poster_id1,
            'poster_update' => $time
        ),
        array(
            'poster_url' => $poster_content2,
            'poster_id' => $poster_id2,
            'poster_update' => $time
        ),
        array(
            'poster_url' => $poster_content3,
            'poster_id' => $poster_id3,
            'poster_update' => $time
        )];
        return $this->db->update_batch('poster',$entries, 'poster_id');
    }

    public function getListCategoryCount($key_search,$visible,$contentid,$keyword_refer)
    {
        $this->db->select('count(keyword_id) as allcount');
        $this->db->from('keywords');
        if ($key_search!='null') {
            $this->db->like('keyword_id', $key_search);
            $this->db->or_like('keyword_name', $key_search);
        }
        $this->db->where('keyword_visible', $visible);
        $this->db->where('keyword_ref', $keyword_refer);
        $this->db->where('keyword_parentid', ','.$contentid.',');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result[0]['allcount'];
    }

    public function getDataListCategory($rowno,$rowperpage,$order_sort,$sort_by,$key_search,$visible,$contentid,$keyword_refer)
    {
        $this->db->select('keyword_id,keyword_name,keyword_ref,keyword_parentid,keyword_visible');
        $this->db->from('keywords');
        if ($key_search!='null') {
            $this->db->like('keyword_id', $key_search);
            $this->db->or_like('keyword_name', $key_search);
        }
        $this->db->where('keyword_visible',$visible);
        $this->db->where('keyword_ref', $keyword_refer);
        $this->db->where('keyword_parentid', ','.$contentid.',');
        $this->db->order_by($sort_by, $order_sort);
        $this->db->limit($rowperpage, $rowno);  
        $query = $this->db->get();
        return $query->result_array();
    }

    public function save_category($data)
    {
        $this->db->insert('keywords', $data);
        return $this->db->insert_id();
    }

    public function get_data_edit_category($id)
    {
        $this->db->select('keyword_id,keyword_name');
        $this->db->from('keywords');
        $this->db->where('keyword_id', $id);
        $query = $this->db->get()->result();
        return $query;
    }

    public function edit_category($keyword_id,$keyword_name)
    {
        $this->db->set('keyword_name', $keyword_name);
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

    public function getimagelandscape()
    {
        $data = $this->db->query("select poster_url from poster where poster_visible='Y' and `product_id` like 'SCVP_%'");
        return $data->result_array();
    }
}
