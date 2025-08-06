<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Whatson_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    public function getCountAll($key_search, $visible)
    {
        $this->db->select('a.whatson_id');
        $this->db->from('whatson AS a, category_whatson AS b, sub_category_whatson AS c, channel_whatson AS d');
        if ($key_search!='null') {
            $this->db->like('a.whatson_id', $key_search);
            $this->db->or_like('a.whatson_title', $key_search);
        }
        $this->db->where('a.category_whatson_id=b.category_whatson_id AND a.sub_category_whatson_id=c.sub_category_whatson_id AND a.channel_whatson_id=d.channel_whatson_id AND a.deleted="0"');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getDatas($key_search, $sort_by, $order_sort, $visible, $rowperpage, $rowno)
    {
        $sort_by = 'a.'.$sort_by;
        $this->db->select('a.whatson_id, a.whatson_title, a.whatson_description, a.whatson_image, a.whatson_banner_active, a.category_whatson_id, a.content_id, a.deleted, a.is_pinned, b.category_whatson_name, c.sub_category_whatson_name, d.channel_whatson_name');
        $this->db->from('whatson AS a, category_whatson AS b, sub_category_whatson AS c, channel_whatson AS d');
        if ($key_search!='null') {
            $this->db->like('a.whatson_id', $key_search);
            $this->db->or_like('a.whatson_title', $key_search);
        }
        $this->db->where('a.category_whatson_id=b.category_whatson_id AND a.sub_category_whatson_id=c.sub_category_whatson_id AND a.channel_whatson_id=d.channel_whatson_id');
        $this->db->where('a.deleted', $visible);
        $this->db->order_by($sort_by, $order_sort);
        $this->db->limit($rowperpage, $rowno);  
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_list_category($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('category_whatson_id, category_whatson_name');
        $this->db->from('category_whatson');
        if ($type == 'data')
        {
            $this->db->like('category_whatson_name', $searchTerm);
            $this->db->where('deleted', '0');
            $this->db->order_by('category_whatson_name', 'asc');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        }
        else
        {
            if ($searchTerm!=null) {
                $this->db->like('category_whatson_name', $searchTerm);
            }
            $this->db->where('deleted', '0');
            return $this->db->get()->num_rows();
        }
    }

    public function get_category_by_id($id)
    {
        $this->db->select('category_whatson_id as id, category_whatson_name as title');
        $this->db->from('category_whatson');
        $this->db->where('category_whatson_id', $id);
        return $this->db->get()->row();
    }

    public function get_list_subcategory($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('sub_category_whatson_id, sub_category_whatson_name');
        $this->db->from('sub_category_whatson');
        if ($type == 'data')
        {
            $this->db->like('sub_category_whatson_name', $searchTerm);
            $this->db->where('deleted', '0');
            $this->db->order_by('sub_category_whatson_name', 'asc');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        }
        else
        {
            if ($searchTerm!=null) {
                $this->db->like('sub_category_whatson_name', $searchTerm);
            }
            $this->db->where('deleted', '0');
            return $this->db->get()->num_rows();
        }
    }

    public function get_sub_category_by_id($id)
    {
        $this->db->select('sub_category_whatson_id as id, sub_category_whatson_name as title');
        $this->db->from('sub_category_whatson');
        $this->db->where('sub_category_whatson_id', $id);
        return $this->db->get()->row();
    }

    public function get_list_channel($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('channel_whatson_id, channel_whatson_name');
        $this->db->from('channel_whatson');
        if ($type == 'data')
        {
            $this->db->like('channel_whatson_name', $searchTerm);
            $this->db->where('deleted', '0');
            $this->db->order_by('channel_whatson_name', 'asc');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        }
        else
        {
            if ($searchTerm!=null) {
                $this->db->like('channel_whatson_name', $searchTerm);
            }
            $this->db->where('deleted', '0');
            return $this->db->get()->num_rows();
        }
    }

    public function get_channel_by_id($id)
    {
        $this->db->select('channel_whatson_id as id, channel_whatson_name as title');
        $this->db->from('channel_whatson');
        $this->db->where('channel_whatson_id', $id);
        return $this->db->get()->row();
    }

    public function get_list_thumbnail($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('thumbnail_whatson_id, thumbnail_whatson_name');
        $this->db->from('thumbnail_whatson');
        if ($type == 'data')
        {
            $this->db->like('thumbnail_whatson_name', $searchTerm);
            $this->db->where('deleted', '0');
            $this->db->order_by('thumbnail_whatson_name', 'asc');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        }
        else
        {
            if ($searchTerm!=null) {
                $this->db->like('thumbnail_whatson_name', $searchTerm);
            }
            $this->db->where('deleted', '0');
            return $this->db->get()->num_rows();
        }
    }

    public function get_thumbnail_by_id($id)
    {
        $this->db->select('thumbnail_whatson_id as id, thumbnail_whatson_name as title');
        $this->db->from('thumbnail_whatson');
        $this->db->where('thumbnail_whatson_id', $id);
        return $this->db->get()->row();
    }

    public function insert_whatson($whatson_data)
    {
        return $this->db->insert('whatson', $whatson_data);
    }

    public function get_whatson_by_id($id)
    {
        $this->db->select('A.*,B.category_whatson_name,C.sub_category_whatson_name,D.channel_whatson_name,E.thumbnail_whatson_name');
        $this->db->from('whatson AS A');
        $this->db->join('category_whatson AS B', 'A.category_whatson_id = B.category_whatson_id');
        $this->db->join('sub_category_whatson AS C', 'A.sub_category_whatson_id = C.sub_category_whatson_id');
        $this->db->join('channel_whatson AS D', 'A.channel_whatson_id = D.channel_whatson_id');
        $this->db->join('thumbnail_whatson AS E', 'A.thumbnail_whatson_id = E.thumbnail_whatson_id');
        $this->db->where(array('A.whatson_id' => $id));
        $query = $this->db->get()->row();
        return $query;
    }

    public function update_whatson($whatson_data)
    {
        $params['whatson_title'] = $whatson_data['whatson_title'];
        $params['whatson_description'] = $whatson_data['whatson_description'];
        $params['whatson_image'] = $whatson_data['whatson_image'];
        $params['whatson_image_potrait'] = $whatson_data['whatson_image_potrait'];
        $params['content_url_image'] = $whatson_data['content_url_image'];
        $params['category_whatson_id'] = $whatson_data['category_whatson_id'];
        $params['sub_category_whatson_id'] = $whatson_data['sub_category_whatson_id'];
        $params['channel_whatson_id'] = $whatson_data['channel_whatson_id'];
        $params['thumbnail_whatson_id'] = $whatson_data['thumbnail_whatson_id'];
        $params['content_id'] = $whatson_data['content_id'];
        $params['whatson_schedule_time'] = $whatson_data['whatson_schedule_time'];
        $params['link_url'] = $whatson_data['link_url'];
        $params['whatson_type'] = $whatson_data['whatson_type'];
        $params['whatson_video'] = $whatson_data['whatson_video'];
        $this->db->where('whatson_id', $whatson_data['whatson_id']);
        return $this->db->update('whatson', $params);
    }

    public function activated_whatson($id)
    {
        $data = array(
            'whatson_id'   => $id,     
            'deleted'      => $deleted='0'
        );
        $this->db->where('whatson_id', $id);
        $this->db->update('whatson', $data);
        redirect(site_url('whatsons'));
    }

    public function inactivated_whatson($id)
    {
        $data = array(
            'whatson_id' => $id,
            'deleted' => $deleted='1',
            'is_pinned' => '0'
        );
        $this->db->where('whatson_id', $id);
        $this->db->update('whatson', $data);
        redirect(site_url('whatsons'));
    }

    public function activated_banner($id)
    {
        $data = array(
            'whatson_id' => $id,     
            'whatson_banner_active' => '1'
        );
        $this->db->where('whatson_id', $id);
        $this->db->update('whatson', $data);
        redirect(site_url('whatsons'));
    }

    public function inactivated_banner($id)
    {
        $data = array(
            'whatson_id'   => $id,     
            'whatson_banner_active' => '0'
        );
        $this->db->where('whatson_id', $id);
        $this->db->update('whatson', $data);
        redirect(site_url('whatsons'));
    }

    public function pinbanner($id)
    {
        $this->db->select('count(*) as allcount');
        $this->db->from('whatson');
        $this->db->where(array('is_pinned' => '1', 'deleted' => '0'));
        $query = $this->db->get()->result();
        $totalRecord = $query[0]->allcount;

        if ($totalRecord >= 2) {
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Tidak berhasil pin whatson. Jumlah pin sudah maksimal, silahkan unpin salah satu whatson!</div>');
            redirect(site_url('whatsons'));
        } else {
            $this->db->set('is_pinned', "1");
            $this->db->where('whatson_id', $id);
            $this->db->update('whatson');
            $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil Pin Whatson</div>');
            redirect(site_url('whatsons'));
        }
    }

    public function unpinbanner($id)
    {
        $this->db->set('is_pinned', "0");
        $this->db->where('whatson_id', $id);
        $this->db->update('whatson');
        $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil Unpin Whatson</div>');
        redirect(site_url('whatsons'));
    }

    public function getimagelandscape()
    {
        $data = $this->db->query("SELECT `content_url_image` FROM whatson UNION ALL SELECT `url` FROM whatson_content");
        $query = $data->result_array();
        if($query!=null){
            $i=0;
            foreach ($query as $key => $value) {
                $_categories = (explode('/', $value['content_url_image']));
                $_arr[$i] = array(
                    'whatson_image'=>$_categories[6],
                );
                $i++;
            }
        }
        $test = $this->db->query("SELECT `whatson_image` FROM whatson UNION ALL SELECT `channel_whatson_logo` FROM channel_whatson");
        $query2 = $test->result_array();
        return (array_merge($_arr,$query2));
    }

    public function getimageportrait()
    {
        $data = $this->db->query("SELECT `whatson_image_potrait` FROM `whatson` WHERE `whatson_image_potrait` <> '' AND `whatson_image_potrait` IS NOT NULL");
        $query = $data->result_array();
        return $query;
    }

    public function getListCategoryCount($key_search,$table)
    {
        if ($table=='category_whatson') {
            $select = 'count(a.category_whatson_id) as allcount';
            $like = 'a.category_whatson_id';
            $orlike = 'a.category_whatson_name';
        } elseif ($table=='sub_category_whatson') {
            $select = 'count(a.sub_category_whatson_id) as allcount';
            $like = 'a.sub_category_whatson_id';
            $orlike = 'a.sub_category_whatson_name';
        } elseif ($table=='channel_whatson') {
            $select = 'count(a.channel_whatson_id) as allcount';
            $like = 'a.channel_whatson_id';
            $orlike = 'a.channel_whatson_name';
        }
        $this->db->select($select);
        $this->db->from($table.' AS a');
        if ($key_search!='null') {
            $this->db->like($like, $key_search);
            $this->db->or_like($orlike, $key_search);
        }
        $this->db->where('a.deleted="0"');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result[0]['allcount'];
    }

    public function getDataListCategory($rowno,$rowperpage,$order_sort,$sort_by,$key_search,$table)
    {
        if ($table=='category_whatson') {
            $select = 'a.category_whatson_id as id, a.category_whatson_name as name, a.category_whatson_description as description, a.deleted';
            $like = 'a.category_whatson_id';
            $orlike = 'a.category_whatson_name';
        } elseif ($table=='sub_category_whatson') {
            $select = 'a.sub_category_whatson_id as id, a.sub_category_whatson_name as name, a.sub_category_whatson_description as description, a.deleted';
            $like = 'a.sub_category_whatson_id';
            $orlike = 'a.sub_category_whatson_name';
        } elseif ($table=='channel_whatson') {
            $select = 'a.channel_whatson_id as id, a.channel_whatson_name as name, a.channel_whatson_description as description, a.deleted';
            $like = 'a.channel_whatson_id';
            $orlike = 'a.channel_whatson_name';
        }
        $sort_by = 'a.'.$sort_by;
        $this->db->select($select);
        $this->db->from($table.' AS a');
        if ($key_search!='null') {
            $this->db->like($like, $key_search);
            $this->db->or_like($orlike, $key_search);
        }
        $this->db->where('a.deleted="0"');
        $this->db->order_by($sort_by, $order_sort);
        $this->db->limit($rowperpage, $rowno);  
        $query = $this->db->get();
        return $query->result_array();
    }

    public function add_category($post, $table)
    {
        if ($table=='channel_whatson') {
            $tw = array(
                'thumbnail_whatson_name' => $post['channel_whatson_name'],
                'thumbnail_whatson_logo' => $post['channel_whatson_logo'],
                'deleted' => '0'
            );
            $this->db->insert('thumbnail_whatson', $tw);
        }
        $this->db->insert($table, $post);
        return $this->db->insert_id();
    }

    public function get_data_edit_category($id,$name,$desc,$seq,$table)
    {
        if ($table=='channel_whatson') {
            $select = $seq.','.$name.','.$desc.',channel_whatson_logo';
        } else {
            $select = $seq.','.$name.','.$desc;
        }
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($seq, $id);
        $query = $this->db->get()->result();
        return $query;
    }

    public function edit_category($name, $val_name, $desc, $val_desc, $img, $val_img, $seq, $val_seq, $table)
    {
        if ($table=='channel_whatson') {
            $this->db->select('channel_whatson_name');
            $this->db->from('channel_whatson');
            $this->db->where('channel_whatson_id', $val_seq);
            $data_old = $this->db->get()->result_array();
            $result = $data_old[0];
            $name_old = $result['channel_whatson_name'];
            $this->db->set('thumbnail_whatson_name', $val_name);
            $this->db->set('thumbnail_whatson_logo', $val_img);
            $this->db->where('thumbnail_whatson_name', $name_old);
            $this->db->update('thumbnail_whatson');
        }

        $this->db->set($name, $val_name);
        $this->db->set($desc, $val_desc);
        if ($img != null && $val_img != null) {
            $this->db->set($img, $val_img);
        }
        $this->db->where($seq, $val_seq);
        return $this->db->update($table);
    }

    public function inactive_category($id,$field,$table)
    {
        $this->db->set('deleted','1');
        $this->db->where($field,$id);
        return $this->db->update($table);
    }
}
