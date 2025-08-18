<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Article_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    public function getCountAll($key_search, $visible, $category)
    {
        $this->db->select('keyword_id');
        $this->db->from('keywords');
        $this->db->where('keyword_parentid', ','.$category.',');
        $query1 = $this->db->get();
        $result1 = $query1->result_array();
        foreach ($result1 as $key => $value) {
            $category_id[] = 'kategori_id LIKE "%,'.$value['keyword_id'].',%"';
        }
        $category_id = implode(' OR ', $category_id);

        $this->db->select('article_id');
        $this->db->from('article');
        if ($key_search!='null') {
            $this->db->like('article_id', $key_search);
            $this->db->or_like('article_title', $key_search);
        }
        $this->db->where('('.$category_id.')');
        $this->db->where('active', $visible);
        $query2 = $this->db->get();
        return $query2->num_rows();
    }

    public function getDatas($key_search, $sort_by, $order_sort, $visible, $category, $rowperpage, $rowno)
    {
        $this->db->select('keyword_id');
        $this->db->from('keywords');
        $this->db->where('keyword_parentid', ','.$category.',');
        $query1 = $this->db->get();
        $result1 = $query1->result_array();
        foreach ($result1 as $key => $value) {
            $category_id[] = 'kategori_id LIKE "%,'.$value['keyword_id'].',%"';
        }
        $category_id = implode(' OR ', $category_id);

        $this->db->select('*');
        $this->db->from('article');
        if ($key_search!='null') {
            $this->db->like('article_id', $key_search);
            $this->db->or_like('article_title', $key_search);
        }
        $this->db->where('('.$category_id.')');
        $this->db->where('active', $visible);
        $this->db->order_by($sort_by, $order_sort);
        $this->db->limit($rowperpage, $rowno);  
        $query2 = $this->db->get();
        $result2 = $query2->result_array();

        $data = array();
        $i=0;
        foreach ($result2 as $key => $value) {
            $_categories = $this->getCategoryName(explode(',', trim($value['kategori_id'], ',')));
            $data[$i] = array(
                'article_id'=>$value['article_id'],
                'article_title'=>$value['article_title'],
                'article_by'=>$value['article_by'],
                'categories'=>implode(', ', $_categories),
                'active'=>$value['active'],
                'pdf_url'=>$value['pdf_url']
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

    public function activated_article($id)
    {
        $data = array(
            'article_id' => $id,     
            'active' => 'Y'
        );
        $this->db->where('article_id', $id);
        $this->db->update('article', $data);
        redirect(site_url('articles'));
    }

    public function inactivated_article($id)
    {
        $data = array(
            'article_id' => $id,     
            'active' => 'N'
        );
        $this->db->where('article_id', $id);
        $this->db->update('article', $data);
        redirect(site_url('articles'));
    }

    public function get_products_by_id($id)
    {
        $_arr = array();
        $this->db->select('article.*, poster.*');
        $this->db->from('article');
        $this->db->join('poster','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = article.article_id','Left');
        $this->db->like(array('poster.poster_type' => 'ARP_1280x720'));
        $this->db->where(array('poster.poster_visible' => 'Y'));
        $this->db->where(array('article.article_id' => $id));
        $this->db->order_by('poster.poster_type', 'ASC');
        $query = $this->db->get()->result_array();
        if ($query!=null) {
            $i=0;
            foreach ($query as $key => $value) {
                $_categories = $this->getCategoryName(explode(',', trim($value['kategori_id'], ',')));
                $_tags = $this->getCategoryName(explode(',', trim($value['tags'], ',')));
                $_arr[$i] = array(
                    'article_id'=>$value['article_id'],
                    'article_title'=>$value['article_title'],
                    'article_by'=>$value['article_by'],
                    'article_summary'=>$value['article_summary'],
                    'article_content_1'=>$value['article_content_1'],
                    'article_content_2'=>$value['article_content_2'],
                    'url_google_maps'=>$value['url_google_maps'],
                    'categories'=>implode(', ', $_categories),
                    'tags'=>implode(', ', $_tags),
                    'pdf_url'=>$value['pdf_url'],
                    'poster_url'=>$value['poster_url'],
                );
                $i++;
            }
        }
        return $_arr;
    }

    public function get_poster_by_id($id)
    {
        $this->db->select('article.article_id, poster.*');
        $this->db->from('article');
        $this->db->join('poster','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = article.article_id','Left');
        $types = array('arpc_1280x720', 'dls_1280x720');
        $this->db->where_in('poster.poster_type', $types);
        $this->db->where(array('poster.poster_visible' => 'Y'));
        $this->db->where(array('article.article_id' => $id));
        $this->db->order_by('poster.poster_type', 'ASC');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function insert_pdf($data)
    {
        $this->db->set('pdf_url', $data['pdf_url']);
        $this->db->where('article_id', $data['article_id']);
        $this->db->update('article');
    }

    public function get_content_type($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('keywords');
        if ($type == 'data')
        {
            if ($searchTerm!=null) {
                $this->db->like('keyword_name', $searchTerm);
            }
            $this->db->where('keyword_visible', 'Y');
            $this->db->where('keyword_ref', 'CYC');
            $this->db->not_like('keyword_name', 'WBR-WEBINAR');
            $this->db->order_by('keyword_id', 'asc');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        }
        else
        {
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
        if ($type == 'data')
        {
            if ($searchTerm!=null) {
                $this->db->like('keyword_name', $searchTerm);
            }
            if ($category_id=='246') // denslife
            {
                $this->db->where('keyword_parentid', ','.$category_id.',');
            }
            elseif ($category_id=='247') // densplay
            {
                $this->db->where('keyword_parentid', ','.$category_id.',');
            }
            elseif ($category_id=='325') // densknowledge
            {
                $this->db->where('keyword_parentid', ','.$category_id.',');
            }
            elseif ($category_id=='1076') // denssport
            {
                $this->db->where('keyword_parentid', ','.$category_id.',');
            }
            elseif ($category_id=='1077') // densshort
            {
                $this->db->where('keyword_parentid', ','.$category_id.',');
            }
            $this->db->where('keyword_ref', 'ARC');
            $this->db->where('keyword_visible', 'Y');
            $this->db->order_by('keyword_id', 'desc');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        }
        else
        {
            if ($searchTerm!=null) {
                $this->db->like('keyword_name', $searchTerm);
            }
            if ($category_id=='246') // denslife
            {
                $this->db->where('keyword_parentid', ','.$category_id.',');
            }
            elseif ($category_id=='247') // densplay
            {
                $this->db->where('keyword_parentid', ','.$category_id.',');
            }
            elseif ($category_id=='325') // densknowledge
            {
                $this->db->where('keyword_parentid', ','.$category_id.',');
            }
            elseif ($category_id=='1076') // denssport
            {
                $this->db->where('keyword_parentid', ','.$category_id.',');
            }
            elseif ($category_id=='1077') // densshort
            {
                $this->db->where('keyword_parentid', ','.$category_id.',');
            }
            $this->db->where('keyword_ref', 'ARC');
            $this->db->where('keyword_visible', 'Y');
            return $this->db->get()->num_rows();
        }
    }

    public function get_categories_by_id($id)
    {
        return $this->db->get_where('keywords', ['keyword_id' => $id])->row();
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
            $this->db->where('keyword_ref', 'TDL');
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
            $this->db->where('keyword_ref', 'TDL');
            return $this->db->get()->num_rows();
        }
    }

    public function get_tags_by_id($id)
    {
        return $this->db->get_where('keywords', ['keyword_id' => $id])->row();
    }

    public function insert_article($article_data)
    {
        $this->db->insert('article', $article_data);
        return $article_id = $this->db->insert_id();
    }

    public function get_article_by_id($article_id)
    {
        $this->db->select('article_id, kategori_id, tags, article_title, article_by, article_summary, url_google_maps');
        $this->db->from('article');
        $this->db->where('article_id', $article_id);
        $query1 = $this->db->get()->result_array();

        $category_id = $query1[0]['kategori_id'];
        $trimexplodecategories =explode(',', trim($category_id,','));

        $tags_id = $query1[0]['tags'];
        $trimexplodetags =explode(',', trim($tags_id,','));

        $this->db->select('keyword_id, keyword_name, keyword_parentid');
        $this->db->from('keywords');
        $this->db->where_in('keyword_id', $trimexplodecategories);
        $query2 = $this->db->get()->result_array();

        $this->db->select('keyword_id, keyword_name');
        $this->db->from('keywords');
        $this->db->where_in('keyword_id', $trimexplodetags);
        $query3 = $this->db->get()->result_array();

        $content_type_id = trim($query2[0]['keyword_parentid'],',');
        $this->db->select('keyword_id, keyword_name');
        $this->db->from('keywords');
        $this->db->where('keyword_id', $content_type_id);
        $query4 = $this->db->get()->result_array();

        $data = array(
            'article_id' => $query1[0]['article_id'],
            'article_title' => $query1[0]['article_title'],
            'article_by' => $query1[0]['article_by'],
            'article_summary' => $query1[0]['article_summary'],
            'url_google_maps' => $query1[0]['url_google_maps'],
            'content_type_id' => $query4[0]['keyword_id'],
            'content_type_name' => $query4[0]['keyword_name'],
            'categories' => $query2,
            'tags' => $query3
        );
        return $data;
    }

    public function update_article($article_data)
    {
        $this->db->set('article_title', $article_data['article_title']);
        $this->db->set('kategori_id', $article_data['kategori_id']);
        $this->db->set('tags', $article_data['tags']);
        $this->db->set('article_by', $article_data['article_by']);
        $this->db->set('article_summary', $article_data['article_summary']);
        $this->db->set('url_google_maps', $article_data['url_google_maps']);
        $this->db->set('updated_at', $article_data['updated_at']);
        $this->db->set('updated_by', $article_data['updated_by']);
        $this->db->set('ctrloc', '/article/update_article');
        $this->db->where('article_id', $article_data['article_id']);
        return $this->db->update('article');
    }

    public function getListCategoryCount($key_search,$visible,$contentid,$keyword_refer)
    {
        $this->db->select('count(keyword_id) as allcount');
        $this->db->from('keywords');
        if ($key_search!='null') {
            $this->db->like('keyword_name', $key_search);
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
            $this->db->like('keyword_name', $key_search);
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

    public function save_tags($name_tag, $sort_tag, $child_tag, $sub_tag, $ref_tag, $visible_tag, $par_tag)
    { 
        $count = count($name_tag);
        for ($i = 0; $i<$count; $i++) {
            $entries[] = array(
                'keyword_name'=>$name_tag[$i],
                'keyword_sort'=>$sort_tag[$i],
                'keyword_child'=>$child_tag[$i],
                'keyword_sub'=>$sub_tag[$i],
                'keyword_ref'=>$ref_tag[$i],
                'keyword_visible'=>$visible_tag[$i],
                'keyword_parentid'=>$par_tag[$i],
            );
        }
        return $this->db->insert_batch('keywords', $entries); 
    }

    public function get_article_content_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('article');
        $this->db->where('article_id', $id);
        $query = $this->db->get();
        return $result = $query->result_array();
    }

    public function getimagearticle()
    {
        $data = $this->db->query("select poster_url from poster where poster_visible='Y' and poster_type in ('arpc_1280x720','arp_1280x720','art_1280x720')");
        return $data->result_array();
    }

    public function insert_poster_article($urlimage,$article_id)
    {
        $data = array(
            'poster_type' => 'art_1280x720',
            'poster_url' => $urlimage,
            'poster_visible' => 'Y',
            'product_id' => 'ART_'.$article_id.'_1',
            'poster_update' => date("Y-m-d H:i:s")
        );
        $this->db->insert('poster',$data);
        return $this->db->insert_id();
    }

    public function create_edit_article_content($article_data)
    {
        $this->db->set('article_content_1', $article_data['article_content_1']);
        $this->db->set('article_content_2', $article_data['article_content_2']);
        $this->db->where('article_id', $article_data['article_id']);
        return $this->db->update('article');
    }

    public function get_poster_banner_by_id($article_id)
    {
        $this->db->select('article.article_id, poster.*');
        $this->db->from('article');
        $this->db->join('poster','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = article.article_id','Left');
        $this->db->like(array('poster.product_id' => 'ARP_'));
        $this->db->where(array('poster.poster_visible' => 'Y'));
        $this->db->where(array('article.article_id' => $article_id));
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
                'poster_type' => 'arp_1280x720',
                'poster_url' => $poster_banner1,
                'poster_visible' => 'Y',
                'product_id' => 'ARP_'.$article_id.'_1',
                'poster_update' => $time
            ),
            array(
                'poster_type' => 'arp_410x230',
                'poster_url' => $poster_banner2,
                'poster_visible' => 'Y',
                'product_id' => 'ARP_'.$article_id.'_1',
                'poster_update' => $time
            ),
            array(
                'poster_type' => 'arp_235x132',
                'poster_url' => $poster_banner3,
                'poster_visible' => 'Y',
                'product_id' => 'ARP_'.$article_id.'_1',
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
        $data = $this->db->query("select poster_url from poster where poster_visible='Y' and poster_type in ('arpc_1280x720','arp_1280x720','art_1280x720')");
        return $data->result_array();
    }

    public function insert_image_content($insert_image)
    {
        return $this->db->insert_batch('poster', $insert_image);
    }

    public function update_image_content($edit_image_exist)
    {
        return $this->db->update_batch('poster', $edit_image_exist, 'poster_id');
    }

    public function insert_image_video_content($insert_image_videos)
    {
        return $this->db->insert_batch('poster', $insert_image_videos);
    }

    public function insert_video_content($insert_videos)
    {
        return $this->db->insert_batch('streams', $insert_videos);
    }

    public function update_image_video_content($update_image_videos)
    {
        return $this->db->update_batch('poster', $update_image_videos, 'poster_id');
    }

    public function update_video_content($update_videos)
    {
        return $this->db->update_batch('streams', $update_videos, 'stream_id');
    }

    public function get_image_content_by_id($article_id)
    {
        $sql =' SELECT article.article_id, poster.* FROM article LEFT JOIN poster ON SUBSTRING_INDEX(SUBSTRING_INDEX(poster.product_id,"_",2),"_",-1) = article.article_id WHERE poster.poster_visible=? AND article.article_id=? AND poster.product_id LIKE ?  ORDER BY poster.poster_id ASC ';
        $query = $this->db->query($sql, array('Y', $article_id, 'ARPC_%'));
        $query = $query->result_array();
        return $query;
    }

    public function get_video_content_by_id($article_id)
    {
        $sql =' SELECT article.article_id, poster.*, poster.product_id as productid_poster, streams.* FROM article LEFT JOIN poster ON SUBSTRING_INDEX(SUBSTRING_INDEX(poster.product_id,"_",2),"_",-1) = article.article_id LEFT JOIN streams ON SUBSTRING_INDEX(SUBSTRING_INDEX(streams.product_id,"_",2),"_",-1) = article.article_id WHERE poster.poster_visible=? AND streams.stream_visible=? AND article.article_id=? AND poster.product_id LIKE ?  ORDER BY poster.poster_id ASC ';
        $query = $this->db->query($sql, array('Y', 'Y', $article_id, 'DLS_%'));
        $query = $query->result_array();
        return $query;
    }

    public function getimagevideo()
    {
        $data = $this->db->query("select poster_url from poster where poster_visible='Y' and poster_type in ('dls_1280x720')");
        return $data->result_array();
    }
}
