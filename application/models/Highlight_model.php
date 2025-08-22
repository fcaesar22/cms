<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Highlight_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    public function get_list_content($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('keywords');
        if ($type == 'data') {
            $this->db->like('keyword_name', $searchTerm);
            $this->db->where('keyword_visible', 'Y');
            $this->db->where('keyword_ref', 'CYC');
            $this->db->order_by('keyword_id', 'asc');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm!=null) {
                $this->db->like('keyword_name', $searchTerm);
            }
            $this->db->where('keyword_visible', '0');
            $this->db->where('keyword_ref', '0');
            return $this->db->get()->num_rows();
        }
    }

    public function getCountAll($key_search, $category)
    {
        $this->db->select('A.covers_id');
        $this->db->from('covers AS A');
        $this->db->join('keywords AS B', 'A.category_covers = B.keyword_id', 'INNER');
        $this->db->join('keywords AS C', 'A.type_goto = C.keyword_id', 'INNER');
        $this->db->join('poster AS D', 'SUBSTRING_INDEX(SUBSTRING_INDEX(D.product_id,"_",2),"_",-1) = A.covers_id AND D.poster_type = "crp_1280x720"', 'INNER');
        $this->db->join('article AS E', 'A.id_goto = E.article_id', 'LEFT');
        $this->db->join('movies AS F', 'A.id_goto = F.movie_id', 'LEFT');
        $this->db->join('tv_channel AS G', 'A.id_goto = G.seq', 'LEFT');
        $this->db->join('tab_webinar AS H', 'A.id_goto = H.webinar_id', 'LEFT');
        if (!empty($category) && $category !== 'null') {
            $this->db->where('A.category_covers', $category);
        }
        if (!empty($key_search) && $key_search !== 'null') {
            $this->db->group_start();
            $this->db->like('E.article_title', $key_search);
            $this->db->or_like('F.movie_title', $key_search);
            $this->db->or_like('G.title', $key_search);
            $this->db->or_like('H.topic', $key_search);
            $this->db->group_end();
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getDatas($key_search, $sort_by, $order_sort, $category, $rowperpage, $rowno)
    {
        $sort_by = 'A.' . $sort_by;
        $this->db->select('A.*, B.keyword_name AS cat_highlight, C.keyword_name AS type_highlight, D.poster_url, E.article_title, F.movie_title, G.title AS tv_title, H.topic AS webinar_topic');
        $this->db->from('covers AS A');
        $this->db->join('keywords AS B', 'A.category_covers = B.keyword_id', 'INNER');
        $this->db->join('keywords AS C', 'A.type_goto = C.keyword_id', 'INNER');
        $this->db->join('poster AS D', 'SUBSTRING_INDEX(SUBSTRING_INDEX(D.product_id,"_",2),"_",-1) = A.covers_id AND D.poster_type = "crp_1280x720"', 'INNER');
        $this->db->join('article AS E', 'A.id_goto = E.article_id', 'LEFT');
        $this->db->join('movies AS F', 'A.id_goto = F.movie_id', 'LEFT');
        $this->db->join('tv_channel AS G', 'A.id_goto = G.seq', 'LEFT');
        $this->db->join('tab_webinar AS H', 'A.id_goto = H.webinar_id', 'LEFT');
        if (!empty($category) && $category !== 'null') {
            $this->db->where('A.category_covers', $category);
        }
        if (!empty($key_search) && $key_search !== 'null') {
            $this->db->group_start();
            $this->db->like('E.article_title', $key_search);
            $this->db->or_like('F.movie_title', $key_search);
            $this->db->or_like('G.title', $key_search);
            $this->db->or_like('H.topic', $key_search);
            $this->db->group_end();
        }
        $this->db->order_by($sort_by, $order_sort);
        $this->db->limit($rowperpage, $rowno);
        $query = $this->db->get();
        $res = $query->result_array();
        $data = array();
        foreach ($res as $value) {
            $title_highlight = '';
            switch ($value['type_goto']) {
                case '245':
                    $title_highlight = $value['article_title'];
                    break;
                case '244':
                    $title_highlight = $value['movie_title'];
                    break;
                case '243':
                    $title_highlight = $value['tv_title'];
                    break;
                case '1517':
                    $title_highlight = $value['webinar_topic'];
                    break;
            }
            $data[] = array(
                'covers_id' => $value['covers_id'],
                'id_goto' => $title_highlight,
                'poster_url' => $value['poster_url'],
                'category_covers' => $value['cat_highlight'],
                'type_highlight' => $value['type_highlight'],
                'start_date' => $value['start_date'],
                'end_date' => $value['end_date'],
            );
        }
        return $data;
    }

    public function get_list_category($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('keywords');
        if ($type == 'data') {
            $this->db->like('keyword_name', $searchTerm);
            $this->db->where('keyword_visible', 'Y');
            $this->db->where('keyword_ref', 'CYC');
            $this->db->order_by('keyword_id', 'asc');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm!=null) {
                $this->db->like('keyword_name', $searchTerm);
            }
            $this->db->where('keyword_visible', 'Y');
            $this->db->where('keyword_ref', 'CYC');
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

    public function get_list_type($perPage, $page, $searchTerm, $category_id, $type)
    {
        $this->db->select('*');
        $this->db->from('keywords');
        if ($type == 'data') {
            if ($searchTerm!=null) {
                $this->db->like('keyword_name', $searchTerm);
            }
            if ($category_id=='247') { // densplay
                $this->db->not_like('keyword_name', 'Webinar');
            } elseif ($category_id=='246') { // denslife
                $this->db->where_not_in('keyword_name', array('Movie','Webinar'));
            } elseif ($category_id=='325') { // densknowledge
                $this->db->where_not_in('keyword_name', array('Movie','Webinar'));
            } elseif ($category_id=='1076') { // denssportmania
                $this->db->not_like('keyword_name', 'Webinar');
            } elseif ($category_id=='1077') { // densshortmovie
                $this->db->not_like('keyword_name', 'Webinar');
            } elseif ($category_id=='1462') { // webinar
                $this->db->where('keyword_name', 'Webinar');
            } elseif ($category_id=='2290') { // movies
                $this->db->where('keyword_name', 'Movie');
            }
            $this->db->where('keyword_visible', 'Y');
            $this->db->where('keyword_ref', 'TYC');
            $this->db->order_by('keyword_id', 'asc');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm!=null) {
                $this->db->like('keyword_name', $searchTerm);
            }
            if ($category_id=='247') { // densplay
                $this->db->not_like('keyword_name', 'Webinar');
            } elseif ($category_id=='246') { // denslife
                $this->db->where_not_in('keyword_name', array('Movie','Webinar'));
            } elseif ($category_id=='325') { // densknowledge
                $this->db->where_not_in('keyword_name', array('Movie','Webinar'));
            } elseif ($category_id=='1076') { // denssportmania
                $this->db->not_like('keyword_name', 'Webinar');
            } elseif ($category_id=='1077') { // densshortmovie
                $this->db->not_like('keyword_name', 'Webinar');
            } elseif ($category_id=='1462') { // webinar
                $this->db->where('keyword_name', 'Webinar');
            } elseif ($category_id=='2290') { // movies
                $this->db->where('keyword_name', 'Movie');
            }
            $this->db->where('keyword_visible', 'Y');
            $this->db->where('keyword_ref', 'TYC');
            return $this->db->get()->num_rows();
        }
    }

    public function get_type_by_id($id)
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

    public function get_list_content_article($perPage, $page, $searchTerm, $category_id, $type_id, $type)
    {
        $New_Array = array();
        $keys = $this->db->query("select keyword_id from keywords where keyword_parentid=',".$category_id.",' and keyword_visible='Y'");
        $sql = $keys->result_array();
        foreach ($sql as $key => $value) {
          $New_Array[] = ",".$value["keyword_id"].",";
        }
        $New_Array = implode('|', $New_Array);
        $this->db->select('article.article_id, article.article_title, article.kategori_id, article.active, poster.*');
        $this->db->from('article');
        if ($type == 'data') {
            $this->db->join('poster','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = article.article_id','Left');
            if ($searchTerm!=null) {
                $this->db->like('article.article_title', $searchTerm);
            }
            $this->db->where('article.kategori_id REGEXP "'.$New_Array.'"');
            $this->db->where('article.active', 'Y');
            $this->db->where('poster.poster_visible', 'Y');
            $this->db->where('poster.poster_type', 'arp_1280x720');
            $this->db->order_by('article.article_id', 'DESC');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            $this->db->join('poster','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = article.article_id','Left');
            if ($searchTerm!=null) {
                $this->db->like('article.article_title', $searchTerm);
            }
            $this->db->where('article.kategori_id REGEXP "'.$New_Array.'"');
            $this->db->where('article.active', 'Y');
            $this->db->where('poster.poster_visible', 'Y');
            $this->db->where('poster.poster_type', 'arp_1280x720');
            return $this->db->get()->num_rows();
        }
    }

    public function get_list_content_tvchannel($perPage, $page, $searchTerm, $category_id, $type_id, $type)
    {
        if ($category_id=='247') { // densplay
            $genrelist = ',4,';
        } elseif ($category_id=='246') { // denslife
            $genrelist = ',10,';
        } elseif ($category_id=='325') { // densknowledge
            $genrelist = ',11,';
        } elseif ($category_id=='1076') { // denssportmania
            $genrelist = ',12,';
        } elseif ($category_id=='1077') { // densshortmovie
            $genrelist = ',13,';
        } else {
            $genrelist = ',10,';
        }
        $this->db->select('*');
        $this->db->from('tv_channel');
        if ($type == 'data') {
            if ($searchTerm!=null) {
                $this->db->like('title', $searchTerm);
            }
            $this->db->like('genrelist', $genrelist);
            $this->db->where('visible', 'Y');
            $this->db->order_by('seq', 'DESC');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm!=null) {
                $this->db->like('title', $searchTerm);
            }
            $this->db->like('genrelist', $genrelist);
            $this->db->where('visible', 'Y');
            return $this->db->get()->num_rows();
        }
    }

    public function get_list_content_movie($perPage, $page, $searchTerm, $category_id, $type_id, $type)
    {
        $this->db->select('movies.*, poster.*');
        $this->db->from('movies');
        if ($type == 'data') {
            $this->db->join('poster','product_id = movies.movie_code','Left');
            if ($searchTerm!=null) {
                $this->db->like('movies.movie_title', $searchTerm);
            }
            $this->db->like('poster.poster_type', '1280x720');
            $this->db->where('poster.poster_visible', 'Y');
            if ($category_id=='247') { // densplay
                $this->db->where('movies.movie_parentype', 'DPL');
            } elseif ($category_id=='1076') { // denssportmania
                $this->db->where('movies.movie_parentype', 'DSP');
            } elseif ($category_id=='1077') { // densshortmovie
                $this->db->where('movies.movie_parentype', 'DSM');
            } elseif ($category_id=='2290') { // movies
                $this->db->where_not_in('movies.movie_parentype', array('EDU', 'DPL', 'DSP', 'DSM', 'CCV'));
            }
            $this->db->order_by('movies.movie_id', 'DESC');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            $this->db->join('poster','product_id = movies.movie_code','Left');
            if ($searchTerm!=null) {
                $this->db->like('movies.movie_title', $searchTerm);
            }
            $this->db->like('poster.poster_type', '1280x720');
            $this->db->where('poster.poster_visible', 'Y');
            if ($category_id=='247') { // densplay
                $this->db->where('movies.movie_parentype', 'DPL');
            } elseif ($category_id=='1076') { // denssportmania
                $this->db->where('movies.movie_parentype', 'DSP');
            } elseif ($category_id=='1077') { // densshortmovie
                $this->db->where('movies.movie_parentype', 'DSM');
            } elseif ($category_id=='2290') { // movies
                $this->db->where_not_in('movies.movie_parentype', array('EDU', 'DPL', 'DSP', 'DSM', 'CCV'));
            }
            return $this->db->get()->num_rows();
        }
    }

    public function get_list_content_webinar($perPage, $page, $searchTerm, $category_id, $type_id, $type)
    {
        if ($category_id=='1462') { // webinar
            $this->db->select('tab_webinar.webinar_id, tab_webinar.topic, poster.*');
            $this->db->from('tab_webinar');
            $this->db->join('poster','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = tab_webinar.webinar_id','Left');
            if ($type == 'data') {
                if ($searchTerm!=null) {
                    $this->db->like('tab_webinar.topic', $searchTerm);
                }
                $this->db->where('tab_webinar.is_visible', 'Y');
                $this->db->where('poster.poster_type', 'wbr_1280x720');
                $this->db->where('poster.poster_visible', 'Y');
                $this->db->order_by('tab_webinar.webinar_id', 'DESC');
                $this->db->limit($perPage, $page);
                return $this->db->get()->result_array();
            } else {
                if ($searchTerm!=null) {
                    $this->db->like('tab_webinar.topic', $searchTerm);
                }
                $this->db->where('tab_webinar.is_visible', 'Y');
                $this->db->where('poster.poster_type', 'wbr_1280x720');
                $this->db->where('poster.poster_visible', 'Y');
                return $this->db->get()->num_rows();
            }
        } else {
            array();
        }
    }

    public function get_content_by_id($id, $category, $type)
    {
        switch ($type) {
            case '245': // article
                $data = $this->getArticle($id, $category, $type);
                break;
            case '243': // tvchannel
                $data = $this->getTV($id, $category, $type);
                break;
            case '244': // movie
                $data = $this->getMovie($id, $category, $type);
                break;
            case '1517': // webinar
                $data = $this->getWebinar($id, $category, $type);
                break;
        }
        return $data;
    }

    public function getArticle($id, $category, $type)
    {
        $New_Array = array();
        $keys = $this->db->query("select keyword_id from keywords where keyword_parentid=',".$category.",' and keyword_visible='Y'");
        $sql = $keys->result_array();
        foreach ($sql as $key => $value) {
          $New_Array[] = ",".$value["keyword_id"].",";
        }
        $New_Array = implode('|', $New_Array);
        $this->db->select('article.article_id, article.article_title, article.kategori_id, article.active, poster.*');
        $this->db->from('article');
        $this->db->join('poster','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = article.article_id','Left');
        $this->db->where('article_id', $id);
        $this->db->where('article.kategori_id REGEXP "'.$New_Array.'"');
        $this->db->where('article.active', 'Y');
        $this->db->where('poster.poster_visible', 'Y');
        $this->db->where('poster.poster_type', 'arp_1280x720');
        $query = $this->db->get();
        $result = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $key => $value) {
                $result[] = array(
                    'id' => $value['article_id'],
                    'text' => $value['article_title'],
                    'data' => $value,
                );
            }
            $result = $result[0];
        }
        return $result;
    }

    public function getTV($id, $category, $type)
    {
        if ($category=='247') { // densplay
            $genrelist = ',4,';
        } elseif ($category=='246') { // denslife
            $genrelist = ',10,';
        } elseif ($category=='325') { // densknowledge
            $genrelist = ',11,';
        } elseif ($category=='1076') { // denssportmania
            $genrelist = ',12,';
        } elseif ($category=='1077') { // densshortmovie
            $genrelist = ',13,';
        } else {
            $genrelist = ',10,';
        }
        $this->db->select('*');
        $this->db->from('tv_channel');
        $this->db->like('genrelist', $genrelist);
        $this->db->where('seq', $id);
        $this->db->where('visible', 'Y');
        $query = $this->db->get();
        $result = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $key => $value) {
                $result[] = array(
                    'id' => $value['seq'],
                    'text' => $value['title'],
                    'data' => $value,
                );
            }
            $result = $result[0];
        }
        return $result;
    }

    public function getMovie($id, $category, $type)
    {
        $this->db->select('movies.*, poster.*');
        $this->db->from('movies');
        $this->db->join('poster','product_id = movies.movie_code','Left');
        $this->db->like('poster.poster_type', '1280x720');
        $this->db->group_start();
        $this->db->where('movies.movie_code', $id);
        $this->db->or_where('movies.movie_id', $id);
        $this->db->group_end();
        $this->db->where('poster.poster_visible', 'Y');
        if ($category=='247') { // densplay
            $this->db->where('movies.movie_parentype', 'DPL');
        } elseif ($category=='1076') { // denssportmania
            $this->db->where('movies.movie_parentype', 'DSP');
        } elseif ($category=='1077') { // densshortmovie
            $this->db->where('movies.movie_parentype', 'DSM');
        } elseif ($category=='2290') { // movies
            $this->db->where_not_in('movies.movie_parentype', array('EDU', 'DPL', 'DSP', 'DSM', 'CCV'));
        }
        $query = $this->db->get();
        $result = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $key => $value) {
                $result[] = array(
                    'id' => $value['movie_code'],
                    'text' => $value['movie_title'],
                    'data' => $value,
                );
            }
            $result = $result[0];
        }
        return $result;
    }

    public function getWebinar($id, $category, $type)
    {
        $this->db->select('tab_webinar.webinar_id, tab_webinar.topic, poster.*');
        $this->db->from('tab_webinar');
        $this->db->join('poster','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = tab_webinar.webinar_id','Left');
        $this->db->where('tab_webinar.webinar_id', $id);
        $this->db->where('tab_webinar.is_visible', 'Y');
        $this->db->where('poster.poster_type', 'wbr_1280x720');
        $this->db->where('poster.poster_visible', 'Y');
        $query = $this->db->get();
        $result = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $key => $value) {
                $result[] = array(
                    'id' => $value['webinar_id'],
                    'text' => $value['topic'],
                    'data' => $value,
                );
            }
            $result = $result[0];
        }
        return $result;
    }

    public function insert_highlight($category_highlight, $type_highlight, $id_content, $title_content, $poster_content1, $poster_content2, $poster_content3, $startdate_highlight, $enddate_highlight, $subtitle, $url_image_portrait, $time)
    {
        $data = array(
            'type_goto' => $type_highlight,
            'id_goto' => $id_content,
            'category_covers' => $category_highlight,
            'start_date' => $startdate_highlight,
            'end_date' => $enddate_highlight,
            'subtitle' => $subtitle,
            'url_image_potrait' => $url_image_portrait,
            'created_at' => $time,
            'updated_at' => $time
        );
        $this->db->insert('covers',$data);
        $id_covers = $this->db->insert_id();
        $entries = [array(
            'poster_type' => 'crp_1280x720',
            'poster_url' => $poster_content1,
            'poster_visible' => 'Y',
            'product_id' => 'CRP_'.$id_covers.'_1',
            'poster_update' => $time
        ),
        array(
            'poster_type' => 'crp_410x230',
            'poster_url' => $poster_content2,
            'poster_visible' => 'Y',
            'product_id' => 'CRP_'.$id_covers.'_1',
            'poster_update' => $time
        ),
        array(
            'poster_type' => 'crp_235x132',
            'poster_url' => $poster_content3,
            'poster_visible' => 'Y',
            'product_id' => 'CRP_'.$id_covers.'_1',
            'poster_update' => $time
        )];
        $this->db->insert_batch('poster',$entries);
        $id_poster = $this->db->insert_id();
        return array(
            'id_covers' => $id_covers,
            'id_poster' => $id_poster,
        );
    }

    public function set_highlight($_idHighlight)
    {
        $id_image2 = $_idHighlight['id_poster']+1;
        $id_image3 = $_idHighlight['id_poster']+2;
        $id_images = ','.$_idHighlight['id_poster'].','.$id_image2.','.$id_image3.',';
        $this->db->set('images', $id_images);
        $this->db->where('covers_id', $_idHighlight['id_covers']);
        $this->db->update('covers');
    }

    public function get_highlight_by_id($covers_id)
    {
        $this->db->select('A.*');
        $this->db->from('covers AS A');
        $this->db->where('A.covers_id', $covers_id);
        $query = $this->db->get()->result_array();
        if ($query[0]['type_goto']=='243') { // tv channel
            $this->db->select('A.covers_id, A.category_covers, A.type_goto, A.id_goto, A.start_date, A.end_date, A.subtitle, A.url_image_potrait, B.keyword_name as category_highlight, C.keyword_name as type_highlight, D.seq AS id_content, D.title AS title_content, E.poster_id, E.poster_type, E.poster_url');
            $this->db->from('covers AS A');
            $this->db->join('keywords AS B', 'A.category_covers = B.keyword_id', 'INNER');
            $this->db->join('keywords AS C', 'A.type_goto = C.keyword_id', 'INNER');
            $this->db->join('tv_channel AS D', 'A.id_goto = D.seq', 'LEFT');
            $this->db->join('poster AS E','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = A.covers_id','Left');
            $this->db->like('E.poster_type', 'crp_');
            $this->db->where('E.poster_visible', 'Y');
            $this->db->where('A.covers_id', $covers_id);
            $this->db->order_by('E.poster_id', 'ASC');
        } elseif ($query[0]['type_goto']=='244') { // movies
            $this->db->select('A.covers_id, A.category_covers, A.type_goto, A.id_goto, A.start_date, A.end_date, A.subtitle, A.url_image_potrait, B.keyword_name as category_highlight, C.keyword_name as type_highlight, D.movie_id AS id_content, D.movie_title AS title_content, E.poster_id, E.poster_type, E.poster_url');
            $this->db->from('covers AS A');
            $this->db->join('keywords AS B', 'A.category_covers = B.keyword_id', 'INNER');
            $this->db->join('keywords AS C', 'A.type_goto = C.keyword_id', 'INNER');
            $this->db->join('movies AS D', 'A.id_goto = D.movie_id', 'LEFT');
            $this->db->join('poster AS E','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = A.covers_id','Left');
            $this->db->like('E.poster_type', 'crp_');
            $this->db->where('E.poster_visible', 'Y');
            $this->db->where('A.covers_id', $covers_id);
            $this->db->order_by('E.poster_id', 'ASC');
        } elseif ($query[0]['type_goto']=='245') { // article
            $this->db->select('A.covers_id, A.category_covers, A.type_goto, A.id_goto, A.start_date, A.end_date, A.subtitle, A.url_image_potrait, B.keyword_name as category_highlight, C.keyword_name as type_highlight, D.article_id AS id_content, D.article_title AS title_content, E.poster_id, E.poster_type, E.poster_url');
            $this->db->from('covers AS A');
            $this->db->join('keywords AS B', 'A.category_covers = B.keyword_id', 'INNER');
            $this->db->join('keywords AS C', 'A.type_goto = C.keyword_id', 'INNER');
            $this->db->join('article AS D', 'A.id_goto = D.article_id', 'LEFT');
            $this->db->join('poster AS E','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = A.covers_id','Left');
            $this->db->like('E.poster_type', 'crp_');
            $this->db->where('E.poster_visible', 'Y');
            $this->db->where('A.covers_id', $covers_id);
            $this->db->order_by('E.poster_id', 'ASC');
        } elseif ($query[0]['type_goto']=='1517') { // webinar
            $this->db->select('A.covers_id, A.category_covers, A.type_goto, A.id_goto, A.start_date, A.end_date, A.subtitle, A.url_image_potrait, B.keyword_name as category_highlight, C.keyword_name as type_highlight, D.webinar_id AS id_content, D.topic AS title_content, E.poster_id, E.poster_type, E.poster_url');
            $this->db->from('covers AS A');
            $this->db->join('keywords AS B', 'A.category_covers = B.keyword_id', 'INNER');
            $this->db->join('keywords AS C', 'A.type_goto = C.keyword_id', 'INNER');
            $this->db->join('tab_webinar AS D', 'A.id_goto = D.webinar_id', 'LEFT');
            $this->db->join('poster AS E','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = A.covers_id','Left');
            $this->db->like('E.poster_type', 'crp_');
            $this->db->where('E.poster_visible', 'Y');
            $this->db->where('A.covers_id', $covers_id);
            $this->db->order_by('E.poster_id', 'ASC');
        }
        $query_highlight = $this->db->get()->result_array();
        $data = array();
        $i=1;
        foreach ($query_highlight as $key => $value) {
            $data['covers_id'] = $value['covers_id'];
            $data['category_covers'] = $value['category_covers'];
            $data['category_highlight'] = $value['category_highlight'];
            $data['type_goto'] = $value['type_goto'];
            $data['type_highlight'] = $value['type_highlight'];
            $data['id_goto'] = $value['id_goto'];
            $data['id_content'] = $value['id_content'];
            $data['title_content'] = $value['title_content'];
            $data['start_date'] = $value['start_date'];
            $data['end_date'] = $value['end_date'];
            $data['subtitle'] = $value['subtitle'];
            $data['url_image_portrait'] = $value['url_image_potrait'];
            $data['posters'][] = array(
                'poster_id_'.$i => $value['poster_id'],
                'poster_type_'.$i => $value['poster_type'],
                'poster_content_'.$i => $value['poster_url']
            );
            $i++;
        }
        return $data;
    }

    public function update_highlight($id, $category_highlight, $type_highlight, $id_content, $title_content, $poster_id1, $poster_content1, $poster_id2, $poster_content2, $poster_id3, $poster_content3, $startdate_highlight, $enddate_highlight, $subtitle, $url_image_portrait, $time)
    {
        $this->db->set('type_goto', $type_highlight);
        $this->db->set('id_goto', $id_content);
        $this->db->set('category_covers', $category_highlight);
        $this->db->set('start_date', $startdate_highlight);
        $this->db->set('end_date', $enddate_highlight);
        $this->db->set('subtitle', $subtitle);
        $this->db->set('url_image_potrait', $url_image_portrait);
        $this->db->set('updated_at', $time);
        $this->db->where('covers_id', $id);
        $this->db->update('covers');
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

    public function getimagelandscape()
    {
        $data = $this->db->query("select poster_url from poster where poster_visible='Y' and poster_type='crp_1280x720'");
        return $data->result_array();
    }

    public function getimagepotrait()
    {
        $data = $this->db->query("select url_image_potrait from covers");
        return $data->result_array();
    }
}
