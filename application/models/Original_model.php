<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Original_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    public function getCountAll($key_search, $visible)
    {
        $this->db->select('id');
        $this->db->from('section_for_mobile');

        if ($key_search != 'null') {
            $this->db->like('title', $key_search);
        }

        $this->db->where('visible', $visible);
        $this->db->where('on_feature', 'homepage');
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function getDatas($key_search, $sort_by, $order_sort, $visible, $rowperpage, $rowno)
    {
        $this->db->select('id, title, visible, create_date, update_date');
        $this->db->from('section_for_mobile');

        if ($key_search != 'null') {
            $this->db->like('title', $key_search);
        }

        $this->db->where('visible', $visible);
        $this->db->where('on_feature', 'homepage');

        if ($visible == 'Y') {
            $this->db->order_by('CAST(sort AS decimal) ASC', false);
        } else {
            $this->db->order_by($sort_by, $order_sort);
        }

        $this->db->limit($rowperpage, $rowno);  
        $query = $this->db->get();
        
        return $query->result_array();
    }

    public function update_sort($idOriginal, $sort)
    {
        $this->db
            ->where('id', $idOriginal)
            ->where('on_feature', 'homepage')
            ->update('section_for_mobile', [
                'sort' => $sort
            ]);

        return $this->db->affected_rows();
    }

    public function activated_original($id, $time)
    {
        if (empty($id)) {
            return false;
        }

        $this->db->trans_start();

        $this->db->select('sort');
        $this->db->from('section_for_mobile');
        $this->db->where('visible', 'Y');
        $this->db->order_by('CAST(sort AS decimal) DESC', false);
        $sort = $this->db->get()->row('sort');

        $this->db->set('visible', 'Y');
        $this->db->set('sort', $sort + 1);
        $this->db->where('id', $id);
        $this->db->update('section_for_mobile');
        $this->db->trans_complete();
        
        $msg = true;

        if ($this->db->trans_status() === FALSE) {
            $msg = false;
        }

        return $msg;
    }

    public function inactivated_original($id, $time)
    {
        if (empty($id)) {
            return false;
        }

        $this->db->trans_start();

        $this->db->set('visible', 'N');
        $this->db->set('sort', NULL);
        $this->db->where('id', $id);
        $this->db->update('section_for_mobile');

        $this->db->select('id, sort');
        $this->db->from('section_for_mobile');
        $this->db->where('visible', 'Y');
        $this->db->order_by('CAST(sort AS decimal) ASC', false);
        $result = $this->db->get()->result_array();

        $data = array();
        $i=1;
        foreach ($result as $key => $value) {
            $data[] = array(
                'sort' => $i,
                'id' => $value['id']
            );
            $i++;
        }

        $this->db->update_batch('section_for_mobile', $data, 'id');
        
        $this->db->trans_complete();
        
        $msg = true;
        
        if ($this->db->trans_status() === FALSE) {
            $msg = false;
        }

        return $msg;
    }

    public function getListVod($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('movies.*');
        $this->db->from('movies');

        if ($type == 'data') {
            $data = array();
            
            if ($searchTerm != null) {
                $this->db->like('movies.movie_title', $searchTerm);
            }

            $this->db->where_in('movies.movie_parentype', array('STD','DPL'));
            $this->db->where('movies.movie_childtype', 'SIN');
            $this->db->where('movies.movie_visible', 'Y');
            $this->db->order_by('movies.movie_id', 'DESC');
            $this->db->limit($perPage, $page);
            $query = $this->db->get();
            if ($query->num_rows()>0)
            {
                $result = $query->result_array();
                
                foreach ($result as $key => $value) {
                    $movie_code = $value['movie_code'];
                    $movie_id = $value['movie_id'];
                    if ($value['movie_type']=='SIN') {
                        $query_posters = $this->db->query("SELECT poster_type, poster_url FROM poster WHERE product_id='$movie_code' AND poster_type IN ('vod_1280x720','vod_183x275','vod_549x825')");
                        
                        if ($query_posters->num_rows() > 0) {
                            $found_vod_549x825 = false;
                            
                            foreach ($query_posters->result_array() as $key2) {
                                if ($key2['poster_type'] == 'vod_549x825') {
                                    $value['image_potrait'] = array(array(
                                        'movie_id' => $movie_id,
                                        'poster_url' => $key2['poster_url']
                                    ));
                                    $found_vod_549x825 = true;
                                } elseif (!$found_vod_549x825 && $key2['poster_type'] == 'vod_183x275') {
                                    $value['image_potrait'] = array(array(
                                        'movie_id' => $movie_id,
                                        'poster_url' => $key2['poster_url']
                                    ));
                                } elseif ($key2['poster_type'] == 'vod_1280x720') {
                                    $value['image_landscape'] = array(array(
                                        'movie_id' => $movie_id,
                                        'poster_url' => $key2['poster_url']
                                    ));
                                }
                            }
                        } else {
                            $value['image_potrait'] = null;
                            $value['image_landscape'] = null;
                        }
                    } elseif ($value['movie_type']=='SER') {
                        $getListMovieCodes = $this->db->query("SELECT movie_code FROM movies WHERE movie_parent_id='$movie_id'");
                        $movie_codes = array_column($getListMovieCodes->result_array(), 'movie_code');
                        $list_movie_codes = '"' . implode('","', $movie_codes) . '"';
                        $list_movie_codes = $list_movie_codes.',"'.$movie_code.'"';
                        $getImageLandscapes = $this->db->query("SELECT movies.movie_id, poster.poster_url FROM poster LEFT JOIN movies ON poster.product_id=movies.movie_code WHERE poster.product_id IN ($list_movie_codes) AND poster.poster_type='vod_1280x720'")->result_array();
                        $value['image_landscape'] = $getImageLandscapes;
                        $getImagePotraits = $this->db->query("SELECT movies.movie_id, poster.poster_url, poster.poster_type FROM poster LEFT JOIN movies ON poster.product_id=movies.movie_code WHERE poster.product_id IN ($list_movie_codes) AND poster.poster_type IN ('vod_183x275','vod_549x825')")->result_array();
                        $filterImagePotraits = array();
                        $movie_map = array();
                        
                        foreach ($getImagePotraits as $movie) {
                            $movie_id = $movie['movie_id'];
                            if (!isset($movie_map[$movie_id])) {
                                $movie_map[$movie_id] = $movie;
                            } else {
                                if ($movie['poster_type'] == 'vod_549x825') {
                                    $movie_map[$movie_id] = $movie;
                                }
                            }
                        }

                        foreach ($movie_map as &$movie) {
                            unset($movie['poster_type']);
                        }

                        $filterImagePotraits = array_values($movie_map);
                        $value['image_potrait'] = $filterImagePotraits;
                    }
                    $keywords = trim($value['movie_keywords'], ',');
                    $getKeywords = $this->db->query("SELECT keyword_id, keyword_name FROM keywords WHERE keyword_visible='Y' AND keyword_ref='GEN' AND keyword_id IN ($keywords)");
                    $value['keywords'] = "";
                    
                    if ($getKeywords->num_rows() > 0) {
                        $value['keywords'] = $getKeywords->result_array();
                    }
                    $data[] = $value;
                }
            }

            return $data;
        } else {
            if ($searchTerm != null) {
                $this->db->like('movies.movie_title', $searchTerm);
            }

            $this->db->where_in('movies.movie_parentype', array('STD','DPL'));
            $this->db->where('movies.movie_childtype', 'SIN');
            $this->db->where('movies.movie_visible', 'Y');
            
            return $this->db->get()->num_rows();
        }
    }

    public function getListBannerAds($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('ads_homepage');
        
        if ($type == 'data') {
            if ($searchTerm != null) {
                $this->db->like('title', $searchTerm);
            }

            $this->db->where('visible', 'Y');
            $this->db->where('on_feature', 'homepage_mobile');
            $this->db->order_by('id_ads', 'desc');
            $this->db->limit($perPage, $page);
            
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm != null) {
                $this->db->like('title', $searchTerm);
            }

            $this->db->where('visible', 'Y');
            $this->db->where('on_feature', 'homepage_mobile');
            
            return $this->db->get()->num_rows();
        }
    }

    public function insertOriginal($data)
    {
        return $this->db->insert('section_for_mobile', $data);
    }

    public function getDataEdit($id)
    {
        $data = null;
        $this->db->select('*');
        $this->db->from('section_for_mobile');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        
        if ($num_rows > 0) {
            $result = $query->result_array();
            $data = $result[0];
        }

        return $data;
    }

    public function updateOrginal($id, $title, $json_content, $time, $ctrloc)
    {
        $this->db->set('title', $title);
        $this->db->set('json_content', $json_content);
        $this->db->set('update_date', $time);
        $this->db->set('ctrloc', $ctrloc);
        $this->db->where('id', $id);
        
        return $this->db->update('section_for_mobile');
    }

    public function get_json_content()
    {
        $this->db->select('id, json_content');
        $this->db->from('section_for_mobile');
        $this->db->where('visible', 'Y');
        $this->db->where('on_feature', 'homepage');
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        if ($num_rows>0)
        {
            $result_array = $query->result_array();
            foreach ($result_array as $key => $value) {
                $new_json = $this->sync_random($value['json_content']);
                $new_json = json_encode($new_json, TRUE);
                $data[] = array(
                    'id' => $value['id'],
                    'json_content' => $new_json
                );
            }
        }
        return $data;
    }

    public function sync_random($value='')
    {
        $data = array();
        if (!empty($value))
        {
            $jsondecode = json_decode($value, true);
            if ($jsondecode==true)
            {
                $datajson = $jsondecode;
                foreach ($datajson as $key => $value) {
                    if ($value['type']=='vod')
                    {
                        $new_json = $this->sync_vod(json_encode(array($value),true));
                        if (count($new_json)>0)
                        {
                            $new_json = $new_json[0];
                        }
                    }
                    elseif ($value['type']=='banner_ads')
                    {
                        $new_json = $this->sync_bannerads(json_encode(array($value),true));
                        if (count($new_json)>0)
                        {
                            $new_json = $new_json[0];
                        }
                    }
                    if (!empty($new_json)) {
                        $data[] = $new_json;
                    }
                }
            }
        }
        return $data;
    }

    public function sync_vod($value='')
    {
        $data = array();
        if (!empty($value))
        {
            $jsondecode = json_decode($value, true);
            if ($jsondecode==true)
            {
                $datajson = $jsondecode;
                foreach ($datajson as $key => $value) {
                    $query = $this->db->query('SELECT * FROM movies WHERE movie_id="'.$value['id'].'" AND movie_visible="Y" LIMIT 1');
                    if ($query->num_rows()>0)
                    {
                        $result = $query->result_array();
                        foreach ($result as $keys => $values) {
                            $movie_code = $values['movie_code'];
                            $movie_id = $values['movie_id'];
                            $trailer_url = "";
                            if ($values['movie_trailer']==null||$values['movie_trailer']=='')
                            {
                                $trailer_url = "";
                            }
                            else
                            {
                                $trailer_url = $values['movie_trailer'];
                            }
                            if ($values['movie_type']=='SIN')
                            {
                                $query_posters = $this->db->query("SELECT poster_type, poster_url FROM poster WHERE product_id='$movie_code' AND poster_type IN ('vod_1280x720','vod_183x275','vod_549x825')");
                                if ($query_posters->num_rows() > 0)
                                {
                                    $found_vod_549x825 = false;
                                    foreach ($query_posters->result_array() as $key2) {
                                        if ($key2['poster_type'] == 'vod_549x825') {
                                            $imgPtr = array(array(
                                                'movie_id' => $movie_id,
                                                'poster_url' => $key2['poster_url']
                                            ));
                                            $found_vod_549x825 = true;
                                        }
                                        elseif (!$found_vod_549x825 && $key2['poster_type'] == 'vod_183x275')
                                        {
                                            $imgPtr = array(array(
                                                'movie_id' => $movie_id,
                                                'poster_url' => $key2['poster_url']
                                            ));
                                        }
                                        elseif ($key2['poster_type'] == 'vod_1280x720')
                                        {
                                            $imgLnd = array(array(
                                                'movie_id' => $movie_id,
                                                'poster_url' => $key2['poster_url']
                                            ));
                                        }
                                    }
                                }
                                else
                                {
                                    $imgPtr = null;
                                    $imgLnd = null;
                                }
                            }
                            elseif ($values['movie_type']=='SER')
                            {
                                $getListMovieCodes = $this->db->query("SELECT movie_code FROM movies WHERE movie_parent_id='$movie_id'");
                                $movie_codes = array_column($getListMovieCodes->result_array(), 'movie_code');
                                $list_movie_codes = '"' . implode('","', $movie_codes) . '"';
                                $list_movie_codes = $list_movie_codes.',"'.$movie_code.'"';
                                $getImageLandscapes = $this->db->query("SELECT movies.movie_id, poster.poster_url FROM poster LEFT JOIN movies ON poster.product_id=movies.movie_code WHERE poster.product_id IN ($list_movie_codes) AND poster.poster_type='vod_1280x720'")->result_array();
                                $imgLnd = $getImageLandscapes;
                                $getImagePotraits = $this->db->query("SELECT movies.movie_id, poster.poster_url, poster.poster_type FROM poster LEFT JOIN movies ON poster.product_id=movies.movie_code WHERE poster.product_id IN ($list_movie_codes) AND poster.poster_type IN ('vod_183x275','vod_549x825')")->result_array();
                                $filterImagePotraits = array();
                                $movie_map = array();
                                foreach ($getImagePotraits as $movie) {
                                    $movie_id = $movie['movie_id'];
                                    if (!isset($movie_map[$movie_id]))
                                    {
                                        $movie_map[$movie_id] = $movie;
                                    }
                                    else
                                    {
                                        if ($movie['poster_type'] == 'vod_549x825')
                                        {
                                            $movie_map[$movie_id] = $movie;
                                        }
                                    }
                                }
                                foreach ($movie_map as &$movie) {
                                    unset($movie['poster_type']);
                                }
                                $filterImagePotraits = array_values($movie_map);
                                $imgPtr = $filterImagePotraits;
                            }
                        }
                        $keywords = trim($values['movie_keywords'], ',');
                        $getKeywords = $this->db->query("SELECT keyword_id, keyword_name FROM keywords WHERE keyword_visible='Y' AND keyword_ref='GEN' AND keyword_id IN ($keywords)");
                        $keywords_value = null;
                        if ($getKeywords->num_rows() > 0)
                        {
                            $keywords_value = $getKeywords->result_array();
                        }
                        $title = $values['movie_title'];
                        $slug = url_title($title,'-',TRUE);
                        $description = $values['movie_description'];
                        $data[] = array(
                            'no' => $value['no'],
                            'id' => $value['id'],
                            'title' => $title,
                            'subtitle' => $value['subtitle'],
                            'slug' => $slug,
                            'description' => $description,
                            'type' => $value['type'],
                            'size' => $value['size'],
                            'image_landscape' => $imgLnd,
                            'image_potrait' => $imgPtr,
                            'trailer_url' => $trailer_url,
                            'keywords' => $keywords_value
                        );
                    }
                }
            }
        }
        return $data;
    }

    public function sync_bannerads($value='')
    {
        $data = array();
        if (!empty($value))
        {
            $jsondecode = json_decode($value, true);
            if ($jsondecode==true)
            {
                $datajson = $jsondecode;
                foreach ($datajson as $key => $value) {
                    $query = $this->db->query('SELECT * FROM ads_homepage WHERE id_ads="'.$value['id'].'" AND visible="Y" LIMIT 1');
                    if ($query->num_rows()>0)
                    {
                        $result = $query->result_array();
                        $id = $result[0]['id_ads'];
                        $title = $result[0]['title'];
                        $slug = url_title($title,'-',TRUE);
                        $image_url = $result[0]['image_url'];
                        $target = $result[0]['target'];
                        $location = $result[0]['location'];
                        $type_content = $result[0]['type_content'];
                        $content_id = $result[0]['content_id'];
                        $start_date = $result[0]['start_date'];
                        $end_date = $result[0]['end_date'];
                        $data[] = array(
                            'no' => $value['no'],
                            'id' => $value['id'],
                            'title' => $title,
                            'slug' => $slug,
                            'description' => "",
                            'type' => $value['type'],
                            'banner_ads_url' => $image_url,
                            'target' => $target,
                            'location' => $location,
                            'category_content' => $type_content,
                            'content_id' => $content_id,
                            'start_date' => $start_date,
                            'end_date' => $end_date
                        );
                    }
                }
            }
        }
        return $data;
    }

    public function update_jsoncontent($get_json_content)
    {
        return $this->db->update_batch('section_for_mobile', $get_json_content, 'id');
    }

    public function getListKeywordCount($key_search, $visible)
    {
        $this->db->select('id_ads');
        $this->db->from('ads_homepage');
        
        if ($key_search != 'null') {
            $this->db->like('title', $key_search);
        }

        $this->db->where('on_feature', 'homepage_mobile');
        $this->db->where('visible', $visible);
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function getDataListKeyword($key_search, $visible, $order_sort, $sort_by, $rowperpage, $rowno)
    {
        $this->db->select('*');
        $this->db->from('ads_homepage');
        
        if ($key_search != 'null') {
            $this->db->like('title', $key_search);
        }

        $this->db->where('on_feature', 'homepage_mobile');
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

    public function updateSortAds($id_ads, $on_feature, $sort)
    {
        $this->db
            ->where('visible', 'Y')
            ->where('on_feature', $on_feature)
            ->where('id_ads', $id_ads)
            ->update('ads_homepage', [
                'sort' => $sort
            ]);

        return $this->db->affected_rows();
    }

    public function activate_ads($id)
    {
        $this->db->select('sort');
        $this->db->from('ads_homepage');
        $this->db->where('on_feature', 'homepage_mobile');
        $this->db->where('visible', 'Y');
        $this->db->order_by('CAST(sort AS decimal) DESC', false);
        $sort = $this->db->get()->row('sort');

        $this->db->set('sort', $sort + 1);
        $this->db->set('visible', 'Y');
        $this->db->where('id_ads', $id);
        return $this->db->update('ads_homepage');
    }

    public function inactivate_ads($id)
    {
        $this->db->trans_start();
        
        $this->db->set('sort', NULL);
        $this->db->set('visible', 'N');
        $this->db->where('id_ads', $id);
        $this->db->update('ads_homepage');
        
        $result = $this->db
            ->select('id_ads')
            ->where('on_feature', 'homepage_mobile')
            ->where('visible', 'Y')
            ->order_by('CAST(sort AS DECIMAL)', 'ASC', false)
            ->get('ads_homepage')
            ->result_array();
        
        $data = [];
        $i = 1;
        
        foreach ($result as $row) {
            $data[] = [
                'id_ads'   => $row['id_ads'],
                'sort' => $i++
            ];
        }

        if (!empty($data)) {
            $this->db->update_batch('ads_homepage', $data, 'id_ads');
        }

        $this->db->trans_complete();
        
        if ($this->db->trans_status() === false) {
            return false;
        }

        return true;
    }

    public function get_data_edit_ads($id)
    {
        $this->db->select('*');
        $this->db->from('ads_homepage');
        $this->db->where('id_ads', $id);
        $query = $this->db->get()->result();
        return $query;
    }

    public function cu_ads($id_ads, $image_url, $title, $target, $location, $type_content, $content_id, $start_date, $end_date, $time, $type)
    {
        if ($type == 'create') {
            if ($id_ads != null || $id_ads != "") {
                return [
                    'status' => false,
                    'message' => 'Ads ID must be empty when creating'
                ];
            }
            
            $data = [
                'image_url' => $image_url,
                'title' => $title,
                'target' => $target,
                'location' => $location,
                'type_content' => $type_content,
                'content_id' => $content_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'on_feature' => 'homepage_mobile',
                'visible' => 'N',
                'create_date' => $time,
                'update_date' => $time
            ];

            $this->db->insert('ads_homepage', $data);

            return [
                'status' => true,
                'message' => 'Ads successfully created'
            ];
        } else {
            if ($id_ads == null || $id_ads == "") {
                return [
                    'status' => false,
                    'message' => 'Ads ID cannot be empty when updating'
                ];
            }
            
            $this->db->set('image_url', $image_url);
            $this->db->set('title', $title);
            $this->db->set('target', $target);
            $this->db->set('location', $location);
            $this->db->set('type_content', $type_content);
            $this->db->set('content_id', $content_id);
            $this->db->set('start_date', $start_date);
            $this->db->set('end_date', $end_date);
            $this->db->set('update_date', $time);
            $this->db->where('id_ads', $id_ads);
            $this->db->update('ads_homepage');
            return [
                'status' => true,
                'message' => 'Ads successfully updated'
            ];
        }
    }

    public function getImageBannerLandscape()
    {
        $data = $this->db->query("select image_url from ads_homepage");
        return $data->result_array();
    }
}
