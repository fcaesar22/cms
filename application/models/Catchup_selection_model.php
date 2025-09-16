<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catchup_selection_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    public function category_catchup($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('category_catchup');
        if ($type == 'data') {
            if ($searchTerm!=null) {
                $this->db->like('title', $searchTerm);
            }
            $this->db->where('visible', 'Y');
            $this->db->where('title !=', 'Trailer');
            $this->db->order_by('id', 'asc');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm!=null) {
                $this->db->like('title', $searchTerm);
            }
            $this->db->where('visible', 'Y');
            $this->db->where('title !=', 'Trailer');
            return $this->db->get()->num_rows();
        }
    }

    public function getCountAll($key_search, $visible, $category)
    {
        $this->db->select('catchup.id');
        $this->db->from('catchup');
        $this->db->join('tv_channel', 'tv_channel.seq = catchup.id_channel');
        $this->db->join('category_catchup', 'category_catchup.id = catchup.category_catchup');
        if ($key_search != 'null') {
            $this->db->like('catchup.title', $key_search);
            $this->db->or_like('tv_channel.title', $key_search);
            $this->db->or_like('category_catchup.title', $key_search);
        }
        if ($category != 'null' && $category != '-1') {
            $this->db->where('category_catchup', $category);
        }
        $this->db->where('catchup.visible', $visible);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getDatas($key_search, $sort_by, $order_sort, $visible, $category, $rowperpage, $rowno)
    {
        $this->db->select('catchup.*, tv_channel.title as channel_name, catchup.title as catchup_title, catchup.visible as catchup_status, catchup.id as id_catchup, category_catchup.title as title_category');
        $this->db->from('catchup');
        $this->db->join('tv_channel', 'tv_channel.seq = catchup.id_channel');
        $this->db->join('category_catchup', 'category_catchup.id = catchup.category_catchup');
        if ($key_search != 'null') {
            $this->db->like('catchup.title', $key_search);
            $this->db->or_like('tv_channel.title', $key_search);
            $this->db->or_like('category_catchup.title', $key_search);
        }
        if ($category != 'null' && $category != '-1') {
            $this->db->where('category_catchup', $category);
        }
        $this->db->where('catchup.visible', $visible);
        if ($visible == 'Y') {
            $this->db->order_by('CAST(catchup.sort AS decimal) ASC', false);
        } else {
            $this->db->order_by($sort_by, $order_sort);
        }
        $this->db->limit($rowperpage, $rowno);  
        $query = $this->db->get();
        return $query->result_array();
    }

    public function update_sort($query)
    {
        return $this->db->query($query);
    }

    public function activated_catchup($id)
    {
        $this->db->trans_start();

        $this->db->select('sort');
        $this->db->from('catchup');
        $this->db->where('visible', 'Y');
        $this->db->order_by('CAST(sort AS decimal) DESC', false);
        $sort = $this->db->get()->row('sort');

        $this->db->set('visible', 'Y');
        $this->db->set('sort', $sort+1);
        $this->db->where('id', $id);
        $this->db->update('catchup');
        $this->db->trans_complete();
        $msg = true;
        if ($this->db->trans_status() === FALSE) {
            $msg = false;
        }
        return $msg;
    }

    public function inactivated_catchup($id)
    {
        $this->db->trans_start();
        $this->db->set('visible', 'N');
        $this->db->set('sort', NULL);
        $this->db->where('id', $id);
        $this->db->update('catchup');

        $this->db->select('id, sort');
        $this->db->from('catchup');
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
        $this->db->update_batch('catchup', $data, 'id');
        $this->db->trans_complete();
        $msg = true;
        if ($this->db->trans_status() === FALSE) {
            $msg = false;
        }
        return $msg;
    }

    public function get_list_channel($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('tv_channel');
        if ($type == 'data') {
            if ($searchTerm!=null) {
                $this->db->like('title', $searchTerm);
            }
            $this->db->where('visible', 'Y');
            $this->db->where("SUBSTRING(LPAD(BIN(flag+0),6,'0'),2,1)='1'");
            $this->db->order_by('seq', 'asc');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm!=null) {
                $this->db->like('title', $searchTerm);
            }
            $this->db->where('visible', 'Y');
            $this->db->where("SUBSTRING(LPAD(BIN(flag+0),6,'0'),2,1)='1'");
            return $this->db->get()->num_rows();
        }
    }

    public function get_channel_by_id($id)
    {
        $this->db->select('seq as id, title');
        $this->db->from('tv_channel');
        $this->db->where('seq', $id);
        return $this->db->get()->row();
    }

    public function get_list_category($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('category_catchup');
        if ($type == 'data') {
            if ($searchTerm!=null) {
                $this->db->like('title', $searchTerm);
            }
            $this->db->where('visible', 'Y');
            $this->db->where('title !=', 'Trailer');
            $this->db->order_by('id', 'asc');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm!=null) {
                $this->db->like('title', $searchTerm);
            }
            $this->db->where('visible', 'Y');
            $this->db->where('title !=', 'Trailer');
            return $this->db->get()->num_rows();
        }
    }

    public function get_category_by_id($id)
    {
        $this->db->select('id, title');
        $this->db->from('category_catchup');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }

    public function get_list_genre($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('tag');
        if ($type == 'data') {
            if ($searchTerm!=null) {
                $this->db->like('name', $searchTerm);
            }
            $this->db->order_by('id', 'asc');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm!=null) {
                $this->db->like('name', $searchTerm);
            }
            return $this->db->get()->num_rows();
        }
    }

    public function get_genre_by_id($id)
    {
        return $this->db->get_where('tag', ['id' => $id])->row();
    }

    public function sid()
    {
        $this->db->select_max('sortid');
        $this->db->from('tv_channel');
        $query = $this->db->get()->result_array();
        return $query[0]['sortid'];
    }

    public function insert_catchup($catchup_data)
    {
        $this->db->insert('catchup', $catchup_data);
        return $id = $this->db->insert_id();
    }

    public function insert_genre($id_catchup, $genre)
    {
        $genre = array_filter($genre);
        $count_genre = count($genre);
        if ($count_genre != 0) {
            for ($i=0; $i < $count_genre; $i++) {
                $sql = "insert into model_tag (tag_id, id, model) values ('".$genre[$i]."', '$id_catchup', 'catchup')";
                $query = $this->db->query($sql);
            }
        }
    }

    public function insert_catchup_content($catchup_content_data)
    {
        $this->db->insert('catchup_content', $catchup_content_data);
        return $id = $this->db->insert_id();
    }

    public function insert_genre_content($id_catchup_content, $genre)
    {
        $genre = array_filter($genre);
        $count_genre = count($genre);
        if ($count_genre != 0) {
            for ($i=0; $i < $count_genre; $i++) {
                $sql = "insert into model_tag (tag_id, id, model) values ('".$genre[$i]."', '$id_catchup_content', 'catchup_content')";
                $query = $this->db->query($sql);
            }
        }
    }

    public function get_catchup_by_id($id)
    {
        $result = array();
        $this->db->select('catchup.*, catchup_content.id as id_catchup_content, catchup_content.start_date, catchup_content.end_date, catchup_content.coming_soon');
        $this->db->from('catchup');
        $this->db->join('catchup_content', 'catchup_content.id_catchup = catchup.id');
        $this->db->where('catchup.id', $id);
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        if ($num_rows > 0) {
            $this->db->select('tag.id, tag.name as title');
            $this->db->from('model_tag');
            $this->db->join('tag', 'tag.id = model_tag.tag_id');
            $this->db->where('model_tag.id', $id);
            $this->db->where('model_tag.model', 'catchup');
            $genre = $this->db->get()->result_array();
            $result = $query->result_array();
            $result[0]['genre'] = $genre;
        }
        return $result;
    }

    public function update_catchup($id, $catchup_data)
    {
        $this->db->where('id', $id);
        return $this->db->update('catchup', $catchup_data);
    }

    public function update_genre($id, $genre)
    {
        $genre = array_filter($genre);
        $count_genre = count($genre);
        if ($count_genre != 0) {
            $this->db->where('id', $id);
            $this->db->where('model', 'catchup');
            $query = $this->db->delete('model_tag');
            if ($query==true) {
                for ($i=0; $i < $count_genre; $i++) {
                    $sql = "insert into model_tag (tag_id, id, model) values ('".$genre[$i]."', '$id', 'catchup')";
                    $this->db->query($sql);
                }
            }
        }
    }

    public function update_catchup_content($id, $catchup_content_data)
    {
        $id_catchup_content = 0;
        $this->db->select('id');
        $this->db->from('catchup_content');
        $this->db->where('id_catchup', $id);
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        if ($num_rows <= 0) {
            $id_catchup_content = 0;
        } else {
            $id_catchup_content = $query->row('id');
            $this->db->where('id', $id_catchup_content);
            $this->db->update('catchup_content', $catchup_content_data);
        }
        return $id_catchup_content;
    }

    public function update_genre_content($id_catchup_content, $genre)
    {
        $genre = array_filter($genre);
        $count_genre = count($genre);
        if ($count_genre != 0) {
            $this->db->where('id', $id_catchup_content);
            $this->db->where('model', 'catchup_content');
            $query = $this->db->delete('model_tag');
            if ($query==true) {
                for ($i=0; $i < $count_genre; $i++) {
                    $sql = "insert into model_tag (tag_id, id, model) values ('".$genre[$i]."', '$id_catchup_content', 'catchup_content')";
                    $this->db->query($sql);
                }
            }
        }
    }

    public function get_catchup_content_by_id($id)
    {
        $result = array();
        $this->db->select('catchup.*, tv_channel.title as name_channel, category_catchup.title as category_catchup_name');
        $this->db->from('catchup');
        $this->db->join('tv_channel', 'tv_channel.seq = catchup.id_channel');
        $this->db->join('category_catchup', 'category_catchup.id = catchup.category_catchup');
        $this->db->where('catchup.id', $id);
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        if ($num_rows > 0) {
            $this->db->select('tag.id, tag.name as title');
            $this->db->from('model_tag');
            $this->db->join('tag', 'tag.id = model_tag.tag_id');
            $this->db->where('model_tag.id', $id);
            $this->db->where('model_tag.model', 'catchup');
            $genre = $this->db->get()->result_array();
            $result = $query->result_array();
            $result[0]['genre'] = $genre;
        }
        return $result;
    }

    public function get_list_category_content($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('category_catchup');
        if ($type == 'data') {
            if ($searchTerm!=null) {
                $this->db->like('title', $searchTerm);
            }
            $this->db->where('visible', 'Y');
            $this->db->order_by('id', 'asc');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm!=null) {
                $this->db->like('title', $searchTerm);
            }
            $this->db->where('visible', 'Y');
            return $this->db->get()->num_rows();
        }
    }

    public function get_category_content_by_id($id)
    {
        $this->db->select('id, title');
        $this->db->from('category_catchup');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }

    public function create_catchup_content($catchup_content_data)
    {
        $this->db->insert('catchup_content', $catchup_content_data);
        return $id = $this->db->insert_id();
    }

    public function get_detail_by_id($id)
    {
        $result = array();
        $this->db->select('catchup.*, catchup_content.id as id_catchup_content, catchup_content.start_date, catchup_content.end_date, catchup_content.coming_soon, tv_channel.title as name_channel, category_catchup.title as category_catchup_name');
        $this->db->from('catchup');
        $this->db->join('catchup_content', 'catchup_content.id_catchup = catchup.id');
        $this->db->join('category_catchup', 'category_catchup.id = catchup.category_catchup');
        $this->db->join('tv_channel', 'tv_channel.seq = catchup.id_channel');
        $this->db->where('catchup.id', $id);
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        if ($num_rows > 0) {
            $this->db->select('tag.id, tag.name as title');
            $this->db->from('model_tag');
            $this->db->join('tag', 'tag.id = model_tag.tag_id');
            $this->db->where('model_tag.id', $id);
            $this->db->where('model_tag.model', 'catchup');
            $genre = $this->db->get();
            $genres = array();
            if ($genre->num_rows() > 0) {
                $titles = array_column($genre->result_array(), 'title');
                $genres = strtolower(implode(', ', $titles));
            }
            $result = $query->result_array();
            $result[0]['genre'] = $genres;
        }
        return $result;
    }

    public function category_season($perPage, $page, $searchTerm, $id_catchup, $category_catchup, $type)
    {
        $this->db->select('a.season');
        $this->db->from('catchup_content as a');
        $this->db->join('category_catchup as b', 'b.id=a.category_catchup');
        if ($type == 'data') {
            if ($searchTerm!=null) {
                $this->db->like('a.season', $searchTerm);
            }
            $this->db->where('a.id_catchup', $id_catchup);
            $this->db->where('b.title', $category_catchup);
            $this->db->order_by('a.id', 'asc');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm!=null) {
                $this->db->like('a.season', $searchTerm);
            }
            $this->db->where('a.id_catchup', $id_catchup);
            $this->db->where('b.title', $category_catchup);
            return $this->db->get()->num_rows();
        }
    }

    public function getListCountContent($key_search, $id_catchup, $select_content, $cat_season)
    {
        $this->db->select('count(A.id) as allcount');
        $this->db->from('catchup_content AS A');
        $this->db->join('category_catchup AS B','B.id = A.category_catchup');
        if ($key_search!='null') {
            $this->db->like('A.title', $key_search);
        }
        $this->db->where('A.id_catchup', $id_catchup);
        if ($select_content == "episode") {
            $this->db->where('B.title !=', 'Trailer');
        } else {
            $this->db->where('B.title ', $select_content);
        }
        if ($cat_season != 'null') {
            $this->db->where('A.season', $cat_season);
        }
        $query  = $this->db->get();
        $result = $query->result_array();
        return $result[0]['allcount'];
    }

    public function getContentList($id_catchup,$select_content,$rowno,$rowperpage,$order_sort,$sort_by,$key_search,$cat_season)
    {
        $this->db->select('*, A.title as content_title, A.visible as content_status, A.id as id_content');
        $this->db->from('catchup_content AS A');
        if ($key_search!='null') {
            $this->db->like('A.title', $key_search);
        }
        $this->db->join('category_catchup AS B', 'B.id = A.category_catchup');
        $this->db->where('A.id_catchup', $id_catchup);
        if ($select_content == "episode") {
            $this->db->where('B.title !=', 'Trailer');
        } else {
            $this->db->where('B.title ', $select_content);
        }
        if ($cat_season != 'null') {
            $this->db->where('A.season', $cat_season);
        }
        $this->db->order_by('A.'.$sort_by, $order_sort);
        $this->db->limit($rowperpage, $rowno);  
        $query = $this->db->get();
        return $query->result_array();
    }

    public function activated_content($id)
    {
        $sql = "UPDATE catchup_content SET visible='Y' WHERE id='$id'";
        return $query = $this->db->query($sql);
    }

    public function inactivated_content($id)
    {
        $sql = "UPDATE catchup_content SET visible='N' WHERE id='$id'";
        return $query = $this->db->query($sql);
    }

    public function get_edit_catchup_content_by_id($id)
    {
        $result = array();
        $this->db->select('catchup_content.*');
        $this->db->from('catchup_content');
        $this->db->where('catchup_content.id', $id);
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        if ($num_rows > 0) {
            $this->db->select('tag.id, tag.name as title');
            $this->db->from('model_tag');
            $this->db->join('tag', 'tag.id = model_tag.tag_id');
            $this->db->where('model_tag.id', $id);
            $this->db->where('model_tag.model', 'catchup_content');
            $genre = $this->db->get()->result_array();
            $result = $query->result_array();
            $result[0]['genre'] = $genre;
        }
        return $result;
    }

    public function edit_catchup_content($id, $catchup_content_data)
    {
        $this->db->where('id', $id);
        return $this->db->update('catchup_content', $catchup_content_data);
    }

    public function getimagethumbnail()
    {
        $data = $this->db->query("select thumbnail from catchup");
        $img['catchup'] = $data->result_array();
        $data = $this->db->query("select thumbnail from catchup_content");
        $img['content'] = $data->result_array();
        return $img;
    }

    public function getimagebanner()
    {
        $data = $this->db->query("select banner from catchup");
        $img['catchup'] = $data->result_array();
        $data = $this->db->query("select banner from catchup_content");
        $img['content'] = $data->result_array();
        return $img;
    }
}
