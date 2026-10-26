<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Explore_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    public function getCountAll($key_search, $visible)
    {
        $this->db->select('id');
        $this->db->from('section');

        if ($key_search != 'null') {
            $this->db->like('title', $key_search);
        }

        $this->db->where('visible', $visible);
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function getDatas($key_search, $sort_by, $order_sort, $visible, $rowperpage, $rowno)
    {
        $this->db->select('id, title, type, show_number, visible, create_date, update_date');
        $this->db->from('section');

        if ($key_search != 'null') {
            $this->db->like('title', $key_search);
        }

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

    public function update_sort($idExplore, $sort)
    {
        $this->db
            ->where('id', $idExplore)
            ->update('section', [
                'sort' => $sort
            ]);

        return $this->db->affected_rows();
    }

    public function activated_explore($id, $time)
    {
        if (empty($id)) {
            return false;
        }

        $this->db->trans_start();

        $this->db->select('sort');
        $this->db->from('section');
        $this->db->where('visible', 'Y');
        $this->db->order_by('CAST(sort AS decimal) DESC', false);
        $sort = $this->db->get()->row('sort');

        $this->db->set('visible', 'Y');
        $this->db->set('sort', $sort + 1);
        $this->db->where('id', $id);
        $this->db->update('section');
        $this->db->trans_complete();
        
        $msg = true;

        if ($this->db->trans_status() === FALSE) {
            $msg = false;
        }

        return $msg;
    }

    public function inactivated_explore($id, $time)
    {
        if (empty($id)) {
            return false;
        }

        $this->db->trans_start();

        $this->db->set('visible', 'N');
        $this->db->set('sort', NULL);
        $this->db->where('id', $id);
        $this->db->update('section');

        $this->db->select('id, sort');
        $this->db->from('section');
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

        $this->db->update_batch('section', $data, 'id');
        
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
            $this->db->order_by('movies.movie_id', 'desc');
            $this->db->limit($perPage, $page);
            $query = $this->db->get();
            
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                foreach ($result as $key => $value) {
                    $movie_code = $value['movie_code'];
                    $query_streams = $this->db->query("SELECT stream_screen, stream_url FROM streams WHERE product_id='$movie_code' AND stream_screen IN ('101','201','301','401','501','601')");
                    
                    if ($query_streams->num_rows() == 6 || $value['movie_type'] == 'SER') {
                        foreach ($query_streams->result_array() as $keys) {
                            if ($keys['stream_screen'] == '101') {
                                $value['url_web'] = $keys['stream_url'];
                            } elseif ($keys['stream_screen'] == '201') {
                                $value['url_stb'] = $keys['stream_url'];
                            } elseif ($keys['stream_screen'] == '301') {
                                $value['url_ios'] = $keys['stream_url'];
                            } elseif ($keys['stream_screen'] == '501') {
                                $value['url_android'] = $keys['stream_url'];
                            }
                        }
                    }

                    $query_posters = $this->db->query("SELECT poster_type, poster_url FROM poster WHERE product_id='$movie_code' AND poster_type IN ('vod_1280x720','vod_549x825','vod_183x275')");
                    
                    if ($query_posters->num_rows() > 0) {
                        $value['image_landscape'] = null;
                        $value['image_potrait'] = null;
                        foreach ($query_posters->result_array() as $key2) {
                            if ($key2['poster_type'] == 'vod_1280x720') {
                                $value['image_landscape'] = $key2['poster_url'];
                            } elseif ($key2['poster_type'] == 'vod_549x825') {
                                $value['image_potrait'] = $key2['poster_url'];
                            } elseif ($key2['poster_type'] == 'vod_183x275' && $value['image_potrait'] === null) {
                                $value['image_potrait'] = $key2['poster_url'];
                            }
                        }
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

    public function getListEpisode($perPage, $page, $searchTerm, $movie_id, $type)
    {
        $this->db->select('movies.*');
        $this->db->from('movies');

        if ($type == 'data') {
            $data = array();
            
            if ($searchTerm != null) {
                $this->db->like('movies.movie_title', $searchTerm);
            }

            $this->db->where('movies.movie_parent_id', $movie_id);
            $this->db->where('movies.movie_parentype', 'SER');
            $this->db->where('movies.movie_childtype', 'SIN');
            $this->db->where('movies.movie_visible', 'Y');
            $this->db->order_by('movies.movie_id', 'desc');
            $this->db->limit($perPage, $page);
            $query = $this->db->get();
            
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                foreach ($result as $key => $value) {
                    $movie_code = $value['movie_code'];
                    $query_streams = $this->db->query("SELECT stream_screen, stream_url FROM streams WHERE product_id='$movie_code' AND stream_screen IN ('101','201','301','401','501','601')");
                    
                    if ($query_streams->num_rows() == 6) {
                        foreach ($query_streams->result_array() as $keys) {
                            if ($keys['stream_screen'] == '101') {
                                $value['url_web'] = $keys['stream_url'];
                            } elseif ($keys['stream_screen'] == '201') {
                                $value['url_stb'] = $keys['stream_url'];
                            } elseif ($keys['stream_screen'] == '301') {
                                $value['url_ios'] = $keys['stream_url'];
                            } elseif ($keys['stream_screen'] == '501') {
                                $value['url_android'] = $keys['stream_url'];
                            }
                        }
                    }

                    $query_posters = $this->db->query("SELECT poster_type, poster_url FROM poster WHERE product_id='$movie_code' AND poster_type IN ('vod_1280x720','vod_549x825','vod_183x275')");
                    
                    if ($query_posters->num_rows() > 0) {
                        $value['image_landscape'] = null;
                        $value['image_potrait'] = null;
                        foreach ($query_posters->result_array() as $key2) {
                            if ($key2['poster_type'] == 'vod_1280x720') {
                                $value['image_landscape'] = $key2['poster_url'];
                            } elseif ($key2['poster_type'] == 'vod_549x825') {
                                $value['image_potrait'] = $key2['poster_url'];
                            } elseif ($key2['poster_type'] == 'vod_183x275' && $value['image_potrait'] === null) {
                                $value['image_potrait'] = $key2['poster_url'];
                            }
                        }
                    }

                    $data[] = $value;
                }
            } else {
                $data = array();
            }
            
            return $data;
        } else {
            if ($searchTerm != null) {
                $this->db->like('movies.movie_title', $searchTerm);
            }

            $this->db->where('movies.movie_parent_id', $movie_id);
            $this->db->where('movies.movie_parentype', 'SER');
            $this->db->where('movies.movie_childtype', 'SIN');
            $this->db->where('movies.movie_visible', 'Y');
            
            return $this->db->get()->num_rows();
        }
    }

    public function getListTv($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('tv_channel');

        if ($type == 'data') {
            if ($searchTerm != null) {
                $this->db->like('title', $searchTerm);
            }

            $this->db->where("(SUBSTRING(LPAD(BIN(flag+0),6,'0'),3,1)='1' OR SUBSTRING(LPAD(BIN(flag+0),6,'0'),5,1)='1' OR SUBSTRING(LPAD(BIN(flag+0),6,'0'),6,1)='1')");
            $this->db->where('visible', 'Y');
            $this->db->order_by('sortid', 'asc');
            $this->db->limit($perPage, $page);
            
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm!=null) {
                $this->db->like('title', $searchTerm);
            }

            $this->db->where("(SUBSTRING(LPAD(BIN(flag+0),6,'0'),3,1)='1' OR SUBSTRING(LPAD(BIN(flag+0),6,'0'),5,1)='1' OR SUBSTRING(LPAD(BIN(flag+0),6,'0'),6,1)='1')");
            $this->db->where('visible', 'Y');
            
            return $this->db->get()->num_rows();
        }
    }

    public function getListCatchupSelection($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('catchup_content.*,tv_channel.tvod_url,tv_channel.tvod_url_stb,tv_channel.tvod_url_android_phone,tv_channel.tvod_url_ios_phone,tv_channel.flag');
        $this->db->from('catchup_content');
        $this->db->join('tv_channel','tv_channel.seq = catchup_content.id_channel','Left');
        
        if ($type == 'data') {
            if ($searchTerm != null) {
                $this->db->like('catchup_content.title', $searchTerm);
            }

            $this->db->where('catchup_content.visible', 'Y');
            $this->db->where('NOW() - INTERVAL 7 DAY < catchup_content.start_date');
            $this->db->where_in('catchup_content.category_catchup', array('1', '2', '4'));
            $this->db->order_by('catchup_content.id', 'desc');
            $this->db->limit($perPage, $page);
            
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm != null) {
                $this->db->like('catchup_content.title', $searchTerm);
            }

            $this->db->where('catchup_content.visible', 'Y');
            $this->db->where('NOW() - INTERVAL 7 DAY < catchup_content.start_date');
            $this->db->where_in('catchup_content.category_catchup', array('1', '2', '4'));
            
            return $this->db->get()->num_rows();
        }
    }

    public function getListArticle($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('article.*,poster.poster_url');
        $this->db->from('article');
        $this->db->join('poster','SUBSTRING_INDEX(SUBSTRING_INDEX(poster.product_id,"_",2),"_",-1) = article.article_id','Left');
        
        if ($type == 'data') {
            $result = array();
            
            if ($searchTerm != null) {
                $this->db->like('article.article_title', $searchTerm);
            }

            $this->db->where('article.active', 'Y');
            $this->db->where('poster.poster_type', 'ARP_1280x720');
            $this->db->where('poster.poster_visible', 'Y');
            $this->db->order_by('article.article_id', 'desc');
            $this->db->limit($perPage, $page);
            $query_data = $this->db->get();
            $num_data = $query_data->num_rows();
            
            if ($num_data > 0) {
                $result_data = $query_data->result_array();
                foreach ($result_data as $key => $value) {
                    $category_article = explode(',', $value['kategori_id']);
                    
                    if (count($category_article) >= 3) {
                        $category_article = array_filter($category_article);
                        $this->db->select('keyword_parentid');
                        $this->db->from('keywords');
                        $this->db->where_in('keyword_id', $category_article);
                        $query_category = $this->db->get();
                        $num_category = $query_category->num_rows();
                        
                        if ($num_category > 0) {
                            $result_category = $query_category->result_array();
                            $id_category = trim($result_category[0]['keyword_parentid'], ',');
                            $this->db->select('keyword_id as id_content_category, keyword_name as title_content_category');
                            $this->db->from('keywords');
                            $this->db->where('keyword_id', $id_category);
                            $this->db->limit(1);
                            $query_content_category = $this->db->get();
                            $num_content_category = $query_content_category->num_rows();
                            
                            if ($num_content_category > 0) {
                                $result_content_category = $query_content_category->result_array();
                                $idcontent = $result_content_category[0]['id_content_category'];
                                $titlecontent = $result_content_category[0]['title_content_category'];
                                $result[] = array(
                                    'article_id' => $value['article_id'],
                                    'id_content_category' => $idcontent,
                                    'title_content_category' => $titlecontent,
                                    'kategori_id' => $value['kategori_id'],
                                    'article_by' => $value['article_by'],
                                    'article_title' => $value['article_title'],
                                    'article_summary' => $value['article_summary'],
                                    'article_content_1' => $value['article_content_1'],
                                    'article_content_2' => $value['article_content_2'],
                                    'tags' => $value['tags'],
                                    'url_google_maps' => $value['url_google_maps'],
                                    'meta_title' => $value['meta_title'],
                                    'meta_description' => $value['meta_description'],
                                    'meta_keywords' => $value['meta_keywords'],
                                    'active' => $value['active'],
                                    'pdf_url' => $value['pdf_url'],
                                    'views' => $value['views'],
                                    'created_at' => $value['created_at'],
                                    'updated_at' => $value['updated_at'],
                                    'created_by' => $value['created_by'],
                                    'updated_by' => $value['updated_by'],
                                    'ctrloc' => $value['ctrloc'],
                                    'poster_url' => $value['poster_url']
                                );
                            }
                        }
                    }
                }
            }

            return $result;
        } else {
            if ($searchTerm != null) {
                $this->db->like('article.article_title', $searchTerm);
            }

            $this->db->where('article.active', 'Y');
            $this->db->where('poster.poster_type', 'ARP_1280x720');
            $this->db->where('poster.poster_visible', 'Y');
            
            return $this->db->get()->num_rows();
        }
    }

    public function getListTrailer($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('upcoming');
        
        if ($type == 'data') {
            if ($searchTerm != null) {
                $this->db->like('title', $searchTerm);
            }

            $this->db->where('visible', 'Y');
            $this->db->order_by('id_upcoming', 'desc');
            $this->db->limit($perPage, $page);
            
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm != null) {
                $this->db->like('title', $searchTerm);
            }

            $this->db->where('visible', 'Y');
            
            return $this->db->get()->num_rows();
        }
    }

    public function getListCatchupSchedule($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('top_tvshow.*, tv_channel.tvod_url as stream_url_web, tv_channel.tvod_url_stb as stream_url_stb, tv_channel.tvod_url_ios_phone as stream_url_android, tv_channel.tvod_url_android_phone as stream_url_ios, tv_channel.catchup_day_limit');
        $this->db->from('top_tvshow');
        $this->db->join('tv_channel','tv_channel.seq = top_tvshow.id_channel','Left');
        
        if ($type == 'data') {
            if ($searchTerm != null) {
                $this->db->like('top_tvshow.title', $searchTerm);
            }

            $this->db->where('top_tvshow.visible', 'Y');
            $this->db->order_by('top_tvshow.id_top_tvshow', 'desc');
            $this->db->limit($perPage, $page);
            $query = $this->db->get();
            $result = array();
            
            if ($query->num_rows() > 0) {
                $return = $query->result_array();
                foreach ($return as $item) {
                    $start_date = date_parse($item['start_date']);
                    $end_date = date_parse($item['end_date']);
                    $start_time = mktime($start_date['hour'],$start_date['minute'],$start_date['second'],$start_date['month'],$start_date['day'],$start_date['year']);
                    $end_time = mktime($end_date['hour'],$end_date['minute'],$end_date['second'],$end_date['month'],$end_date['day'],$end_date['year']);
                    $catchupdaylimitweb = substr($item['catchup_day_limit'],0,1);
                    $catchupdaylimitstb = substr($item['catchup_day_limit'],1,1);
                    $catchupdaylimitandroid = substr($item['catchup_day_limit'],2,1);
                    $catchupdaylimitios = substr($item['catchup_day_limit'],3,1);
                    $item['catchup_day_limit_web'] = $catchupdaylimitweb;
                    $item['catchup_day_limit_stb'] = $catchupdaylimitstb;
                    $item['catchup_day_limit_android'] = $catchupdaylimitandroid;
                    $item['catchup_day_limit_ios'] = $catchupdaylimitios;
                    $item['starttime'] = $start_time;
                    $item['endtime'] = $end_time;
                    $item['stream_url_web'] = $item['stream_url_web'].'&starttime='.$start_time.'&endtime='.$end_time;
                    $item['stream_url_stb'] = $item['stream_url_stb'].'&starttime='.$start_time.'&endtime='.$end_time;
                    $item['stream_url_android'] = $item['stream_url_android'].'&starttime='.$start_time.'&endtime='.$end_time;
                    $item['stream_url_ios'] = $item['stream_url_ios'].'&starttime='.$start_time.'&endtime='.$end_time;
                    $result[] = $item;
                }
                
                return $result;
            }
        } else {
            if ($searchTerm != null) {
                $this->db->like('top_tvshow.title', $searchTerm);
            }

            $this->db->where('top_tvshow.visible', 'Y');
            
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
            $this->db->order_by('id_ads', 'desc');
            $this->db->limit($perPage, $page);
            
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm != null) {
                $this->db->like('title', $searchTerm);
            }

            $this->db->where('visible', 'Y');
            
            return $this->db->get()->num_rows();
        }
    }

    public function insertExplore($data)
    {
        return $this->db->insert('section', $data);
    }

    public function getDataEdit($id)
    {
        $data = null;
        $this->db->select('*');
        $this->db->from('section');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        
        if ($num_rows > 0) {
            $result = $query->result_array();
            $data = $result[0];
        }

        return $data;
    }

    public function updateExplore($id, $title, $type, $show_number, $json_content, $time, $ctrloc)
    {
        $this->db->set('title', $title);
        $this->db->set('type', $type);
        $this->db->set('show_number', $show_number);
        $this->db->set('json_content', $json_content);
        $this->db->set('update_date', $time);
        $this->db->set('ctrloc', $ctrloc);
        $this->db->where('id', $id);
        
        return $this->db->update('section');
    }

    public function get_json_content()
    {
        $this->db->select('id, type, json_content');
        $this->db->from('section');
        $this->db->where('visible', 'Y');
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        if ($num_rows > 0) {
            $result_array = $query->result_array();
            foreach ($result_array as $key => $value) {
                if ($value['type'] == 1) { // random
                    $new_json = $this->sync_random($value['json_content']);
                    $new_json = json_encode($new_json, TRUE);
                }
                elseif ($value['type'] == 2) { // tv
                    $new_json = $this->sync_tv($value['json_content']);
                    $new_json = json_encode($new_json, TRUE);
                }
                elseif ($value['type'] == 3) { // catchup selection
                    $new_json = $this->sync_catchupselection($value['json_content']);
                    $new_json = json_encode($new_json, TRUE);
                }
                elseif ($value['type'] == 4) { // vod
                    $new_json = $this->sync_vod($value['json_content']);
                    $new_json = json_encode($new_json, TRUE);
                }
                elseif ($value['type'] == 5) { // article
                    $new_json = $this->sync_article($value['json_content']);
                    $new_json = json_encode($new_json, TRUE);
                }
                elseif ($value['type'] == 6) { // trailer
                    $new_json = $this->sync_trailer($value['json_content']);
                    $new_json = json_encode($new_json, TRUE);
                }
                elseif ($value['type'] == 7) { // catchup schedule
                    $new_json = $this->sync_catchupschedule($value['json_content']);
                    $new_json = json_encode($new_json, TRUE);
                }
                elseif ($value['type'] == 8) { // banner ads
                    $new_json = $this->sync_bannerads($value['json_content']);
                    $new_json = json_encode($new_json, TRUE);
                } else {
                    $new_json = $value['json_content'];
                }

                $data[] = array(
                    'id' => $value['id'],
                    'type' => $value['type'],
                    'json_content' => $new_json
                );
            }
        }

        return $data;
    }

    public function sync_random($value='')
    {
        $data = array();

        if (!empty($value)) {
            $jsondecode = json_decode($value, true);
            if ($jsondecode == true) {
                $datajson = $jsondecode;
                foreach ($datajson as $key => $value) {
                    if ($value['type'] == 'live_tv') {
                        $new_json = $this->sync_tv(json_encode(array($value),true));
                        if (count($new_json) > 0) {
                            $new_json = $new_json[0];
                        }
                    } elseif ($value['type'] == 'catchup_selection') {
                        $new_json = $this->sync_catchupselection(json_encode(array($value),true));
                        if (count($new_json) > 0) {
                            $new_json = $new_json[0];
                        }
                    } elseif ($value['type'] == 'vod') {
                        $new_json = $this->sync_vod(json_encode(array($value),true));
                        if (count($new_json) > 0) {
                            $new_json = $new_json[0];
                        }
                    } elseif ($value['type'] == 'article') {
                        $new_json = $this->sync_article(json_encode(array($value),true));
                        if (count($new_json) > 0) {
                            $new_json = $new_json[0];
                        }
                    } elseif ($value['type'] == 'trailer') {
                        $new_json = $this->sync_trailer(json_encode(array($value),true));
                        if (count($new_json) > 0) {
                            $new_json = $new_json[0];
                        }
                    } elseif ($value['type'] == 'catchup_schedule') {
                        $new_json = $this->sync_catchupschedule(json_encode(array($value),true));
                        if (count($new_json) > 0) {
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

    public function sync_tv($value='')
    {
        $data = array();
        
        if (!empty($value)) {
            $jsondecode = json_decode($value, true);
            
            if ($jsondecode == true) {
                $datajson = $jsondecode;

                foreach ($datajson as $key => $value) {
                    $query = $this->db->query('SELECT * FROM tv_channel WHERE seq="'.$value['id'].'" AND visible="Y" LIMIT 1');
                    
                    if ($query->num_rows() > 0) {
                        $result = $query->result_array();
                        $id = $result[0]['seq'];
                        $title = $result[0]['title'];
                        $slug = url_title($title,'-',TRUE);
                        $description = $result[0]['description'];
                        $image_square = 'https://pic.dens.tv/tv_183x174/'.$result[0]['file1'];
                        
                        if (in_array(',1,', array($result[0]['genrelist']))) {
                            $category = '1';
                        } elseif (in_array(',2,', array($result[0]['genrelist']))) {
                            $category = '2';
                        } elseif (in_array(',3,', array($result[0]['genrelist']))) {
                            $category = '3';
                        } elseif (in_array(',13,', array($result[0]['genrelist']))) {
                            $category = '13';
                        }
                        
                        $trailer_url = "";
                        if ($result[0]['trailer_url'] == null||$result[0]['trailer_url'] == '') {
                            $trailer_url = "";
                        } else {
                            $trailer_url = $result[0]['trailer_url'];
                        }
                        
                        $data[] = array(
                            'no' => $value['no'],
                            'id' => $value['id'],
                            'title' => $title,
                            'slug' => $slug,
                            'description' => $description,
                            'type' => $value['type'],
                            'image_square' => $image_square,
                            'image_landscape' => "",
                            'image_potrait' => "",
                            'category' => $value['category'],
                            'trailer_url' => $trailer_url
                        );
                    }
                }
            }
        }

        return $data;
    }

    public function sync_catchupselection($value='')
    {
        $data = array();

        if (!empty($value)) {
            $jsondecode = json_decode($value, true);
            
            if ($jsondecode == true) {
                $datajson = $jsondecode;
                
                foreach ($datajson as $key => $value) {
                    $query = $this->db->query('SELECT * FROM catchup_content WHERE id="'.$value['id'].'" AND visible="Y" LIMIT 1');
                    
                    if ($query->num_rows() > 0) {
                        $result = $query->result_array();
                        $id = $result[0]['id'];
                        $title = $result[0]['title'];
                        $slug = url_title($title,'-',TRUE);
                        $description = $result[0]['description'];
                        $image_landscape = $result[0]['thumbnail'];
                        $data[] = array(
                            'no' => $value['no'],
                            'id' => $value['id'],
                            'title' => $title,
                            'slug' => $slug,
                            'description' => $description,
                            'type' => $value['type'],
                            'image_square' => "",
                            'image_landscape' => $image_landscape,
                            'image_potrait' => "",
                            'trailer_url' => ""
                        );
                    }
                }
            }
        }

        return $data;
    }

    public function sync_vod($value='')
    {
        $data = array();
        
        if (!empty($value)) {
            $jsondecode = json_decode($value, true);
            
            if ($jsondecode == true) {
                $datajson = $jsondecode;

                foreach ($datajson as $key => $value) {
                    $query = $this->db->query('SELECT * FROM movies WHERE movie_id="'.$value['id'].'" AND movie_visible="Y" LIMIT 1');
                    
                    if ($query->num_rows() > 0) {
                        $result = $query->result_array();
                        $productid = $result[0]['movie_code'];
                        $query_poster = $this->db->query('SELECT * FROM poster WHERE product_id="'.$productid.'" AND poster_type IN ("vod_1280x720","vod_549x825","vod_183x275")');
                        
                        if ($query_poster->num_rows() > 0) {
                            $result_poster = $query_poster->result_array();
                            $poster_landscape = null;
                            $poster_potrait = null;

                            foreach ($result_poster as $keys) {
                                if ($keys['poster_type'] == 'vod_1280x720') {
                                    $poster_landscape = $keys['poster_url'];
                                } elseif ($keys['poster_type'] == 'vod_549x825') {
                                    $poster_potrait = $keys['poster_url'];
                                } elseif ($keys['poster_type'] == 'vod_183x275' && $poster_potrait === null) {
                                    $poster_potrait = $keys['poster_url'];
                                }
                            }
                        }

                        $query_streams = $this->db->query('SELECT * FROM streams WHERE product_id="'.$productid.'" AND stream_screen IN ("101","201","301","401","501","601")');
                        
                        if ($query_streams->num_rows() > 0) {
                            $url_web = null;
                            $url_stb = null;
                            $url_android = null;
                            $url_ios = null;
                            
                            foreach ($query_streams->result_array() as $keys2) {
                                if ($keys2['stream_screen'] == '101') {
                                    $url_web = $keys2['stream_url'];
                                } elseif ($keys2['stream_screen'] == '201') {
                                    $url_stb = $keys2['stream_url'];
                                } elseif ($keys2['stream_screen'] == '301') {
                                    $url_android = $keys2['stream_url'];
                                } elseif ($keys2['stream_screen'] == '501') {
                                    $url_ios = $keys2['stream_url'];
                                }
                            }
                        }

                        $id = $result[0]['movie_id'];
                        $title = $result[0]['movie_title'];
                        $slug = url_title($title,'-',TRUE);
                        $description = $result[0]['movie_description'];
                        $trailer_url = "";
                        
                        if ($result[0]['movie_trailer'] == null||$result[0]['movie_trailer'] == '') {
                            $trailer_url = "";
                        } else {
                            $trailer_url = $result[0]['movie_trailer'];
                        }

                        $data[] = array(
                            'no' => $value['no'],
                            'id' => $value['id'],
                            'title' => $title,
                            'slug' => $slug,
                            'description' => $description,
                            'type' => $value['type'],
                            'image_square' => "",
                            'image_landscape' => $poster_landscape,
                            'image_potrait' => $poster_potrait,
                            'trailer_url' => $trailer_url,
                            'vod_url_web' => $url_web,
                            'vod_url_stb' => $url_stb,
                            'vod_url_android' => $url_android,
                            'vod_url_ios' => $url_ios
                        );
                    }
                }
            }
        }

        return $data;
    }

    public function sync_article($value='')
    {
        $data = array();
        
        if (!empty($value)) {
            $jsondecode = json_decode($value, true);
            
            if ($jsondecode == true) {
                $datajson = $jsondecode;
                
                foreach ($datajson as $key => $value) {
                    $query = $this->db->query('SELECT article.*, poster.poster_url FROM article LEFT JOIN poster ON SUBSTRING_INDEX(SUBSTRING_INDEX(poster.product_id,"_",2),"_",-1) = article.article_id WHERE article.article_id="'.$value['id'].'" AND article.active="Y" AND poster_type="ARP_1280x720" AND poster_visible="Y" LIMIT 1');
                    
                    if ($query->num_rows() > 0) {
                        $result = $query->result_array();
                        $category_article = explode(',', $result[0]['kategori_id']);
                        
                        if (count($category_article) >= 3) {
                            $category_article = array_filter($category_article);
                            $this->db->select('keyword_parentid');
                            $this->db->from('keywords');
                            $this->db->where_in('keyword_id', $category_article);
                            $query_category = $this->db->get();
                            $num_category = $query_category->num_rows();
                            
                            if ($num_category > 0) {
                                $result_category = $query_category->result_array();
                                $id_category = trim($result_category[0]['keyword_parentid'], ',');
                                $this->db->select('keyword_id as id_content_category, keyword_name as title_content_category');
                                $this->db->from('keywords');
                                $this->db->where('keyword_id', $id_category);
                                $this->db->limit(1);
                                $query_content_category = $this->db->get();
                                $num_content_category = $query_content_category->num_rows();
                                
                                if ($num_content_category > 0) {
                                    $result_content_category = $query_content_category->result_array();
                                    $idcontent = $result_content_category[0]['id_content_category'];
                                    $titlecontent = $result_content_category[0]['title_content_category'];
                                    $id = $result[0]['article_id'];
                                    $title = $result[0]['article_title'];
                                    $slug = url_title($title,'-',TRUE);
                                    $description = $result[0]['article_summary'];
                                    $image_landscape = $result[0]['poster_url'];
                                    $data[] = array(
                                        'no' => $value['no'],
                                        'id' => $value['id'],
                                        'title' => $title,
                                        'slug' => $slug,
                                        'description' => $description,
                                        'type' => $value['type'],
                                        'image_square' => "",
                                        'image_landscape' => $image_landscape,
                                        'image_potrait' => "",
                                        'id_content_category' => $idcontent,
                                        'title_content_category' => $titlecontent,
                                        'trailer_url' => ""
                                    );
                                }
                            }
                        }
                    }
                }
            }
        }
        return $data;
    }

    public function sync_trailer($value='')
    {
        $data = array();
        
        if (!empty($value)) {
            $jsondecode = json_decode($value, true);
            
            if ($jsondecode == true) {
                $datajson = $jsondecode;
                
                foreach ($datajson as $key => $value) {
                    $query = $this->db->query('SELECT * FROM upcoming WHERE id_upcoming="'.$value['id'].'" AND visible="Y" LIMIT 1');
                    
                    if ($query->num_rows() > 0) {
                        $result = $query->result_array();
                        $id = $result[0]['id_upcoming'];
                        $title = $result[0]['title'];
                        $slug = url_title($title,'-',TRUE);
                        $description = $result[0]['description'];
                        $image_landscape = $result[0]['image_landscape'];
                        $image_potrait = $result[0]['image_potrait'];
                        $trailer_url = $result[0]['url_trailer'];
                        
                        if ($trailer_url == null||$trailer_url == '') {
                            $trailer_url = "";
                        } else {
                            $trailer_url = $result[0]['url_trailer'];
                        }

                        $data[] = array(
                            'no' => $value['no'],
                            'id' => $value['id'],
                            'title' => $title,
                            'slug' => $slug,
                            'description' => $description,
                            'type' => $value['type'],
                            'image_square' => "",
                            'image_landscape' => $image_landscape,
                            'image_potrait' => $image_potrait,
                            'trailer_url' => $trailer_url
                        );
                    }
                }
            }
        }

        return $data;
    }

    public function sync_catchupschedule($value='')
    {
        $data = array();
        if (!empty($value)) {
            $jsondecode = json_decode($value, true);
            
            if ($jsondecode == true) {
                $datajson = $jsondecode;
                
                foreach ($datajson as $key => $value) {
                    $query = $this->db->query('SELECT top_tvshow.*, tv_channel.tvod_url AS stream_url_web, tv_channel.tvod_url_stb AS stream_url_stb, tv_channel.tvod_url_ios_phone AS stream_url_android, tv_channel.tvod_url_android_phone AS stream_url_ios, tv_channel.catchup_day_limit FROM top_tvshow LEFT JOIN tv_channel ON tv_channel.seq = top_tvshow.id_channel WHERE top_tvshow.id_top_tvshow="'.$value['id'].'" AND top_tvshow.visible="Y" LIMIT 1');
                    
                    if ($query->num_rows() > 0) {
                        $result = array();
                        $return = $query->result_array();
                        
                        foreach ($return as $key => $valuenew) {
                            $start_date = date_parse($valuenew['start_date']);
                            $end_date = date_parse($valuenew['end_date']);
                            $start_time = mktime($start_date['hour'],$start_date['minute'],$start_date['second'],$start_date['month'],$start_date['day'],$start_date['year']);
                            $end_time = mktime($end_date['hour'],$end_date['minute'],$end_date['second'],$end_date['month'],$end_date['day'],$end_date['year']);
                            $catchupdaylimitweb = substr($valuenew['catchup_day_limit'],0,1);
                            $catchupdaylimitstb = substr($valuenew['catchup_day_limit'],1,1);
                            $catchupdaylimitandroid = substr($valuenew['catchup_day_limit'],2,1);
                            $catchupdaylimitios = substr($valuenew['catchup_day_limit'],3,1);
                            $result[] = array(
                                'id_top_tvshow' => $valuenew['id_top_tvshow'],
                                'title' => $valuenew['title'],
                                'description' => $valuenew['description'],
                                'banner_image' => $valuenew['banner_image'],
                                'banner_image_potrait' => $valuenew['banner_image_potrait'],
                                'trailer_url' => $valuenew['trailer_url'],
                                'category_channel' => $valuenew['category_channel'],
                                'id_channel' => $valuenew['id_channel'],
                                'catchup_day_limit_web' => $catchupdaylimitweb,
                                'catchup_day_limit_stb' => $catchupdaylimitstb,
                                'catchup_day_limit_android' => $catchupdaylimitandroid,
                                'catchup_day_limit_ios' => $catchupdaylimitios,
                                'starttime' => $start_time,
                                'endtime' => $end_time,
                                'stream_url_web' => $valuenew['stream_url_web'].'&starttime='.$start_time.'&endtime='.$end_time,
                                'stream_url_stb' => $valuenew['stream_url_stb'].'&starttime='.$start_time.'&endtime='.$end_time,
                                'stream_url_android' => $valuenew['stream_url_android'].'&starttime='.$start_time.'&endtime='.$end_time,
                                'stream_url_ios' => $valuenew['stream_url_ios'].'&starttime='.$start_time.'&endtime='.$end_time,
                            );
                        }
                        $id = $result[0]['id_top_tvshow'];
                        $title = $result[0]['title'];
                        $slug = url_title($title,'-',TRUE);
                        $description = $result[0]['description'];
                        $image_landscape = $result[0]['banner_image'];
                        $image_potrait = $result[0]['banner_image_potrait'];
                        $trailer_url = "";
                        
                        if ($result[0]['trailer_url'] == null||$result[0]['trailer_url'] == '') {
                            $trailer_url = "";
                        } else {
                            $trailer_url = $result[0]['trailer_url'];
                        }

                        $category_channel = $result[0]['category_channel'];
                        $id_channel = $result[0]['id_channel'];
                        $catchup_day_limit_web = $result[0]['catchup_day_limit_web'];
                        $catchup_day_limit_stb = $result[0]['catchup_day_limit_stb'];
                        $catchup_day_limit_android = $result[0]['catchup_day_limit_android'];
                        $catchup_day_limit_ios = $result[0]['catchup_day_limit_ios'];
                        $starttime = $result[0]['starttime'];
                        $endtime = $result[0]['endtime'];
                        $stream_url_web = $result[0]['stream_url_web'];
                        $stream_url_stb = $result[0]['stream_url_stb'];
                        $stream_url_android = $result[0]['stream_url_android'];
                        $stream_url_ios = $result[0]['stream_url_ios'];
                        $data[] = array(
                            'no' => $value['no'],
                            'id' => $value['id'],
                            'title' => $title,
                            'slug' => $slug,
                            'description' => $description,
                            'type' => $value['type'],
                            'image_square' => "",
                            'image_landscape' => $image_landscape,
                            'image_potrait' => $image_potrait,
                            'trailer_url' => $trailer_url,
                            'category_channel' => $category_channel,
                            'id_channel' => $id_channel,
                            'catchup_day_limit_web' => $catchup_day_limit_web,
                            'catchup_day_limit_stb' => $catchup_day_limit_stb,
                            'catchup_day_limit_android' => $catchup_day_limit_android,
                            'catchup_day_limit_ios' => $catchup_day_limit_ios,
                            'starttime' => $starttime,
                            'endtime' => $endtime,
                            'stream_url_web' => $stream_url_web,
                            'stream_url_stb' => $stream_url_stb,
                            'stream_url_android' => $stream_url_android,
                            'stream_url_ios' => $stream_url_ios,
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
        
        if (!empty($value)) {
            $jsondecode = json_decode($value, true);
            
            if ($jsondecode == true) {
                $datajson = $jsondecode;
                
                foreach ($datajson as $key => $value) {
                    $query = $this->db->query('SELECT * FROM ads_homepage WHERE id_ads="'.$value['id'].'" AND visible="Y" LIMIT 1');
                    
                    if ($query->num_rows() > 0) {
                        $result = $query->result_array();
                        $id = $result[0]['id_ads'];
                        $title = $result[0]['title'];
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
                            'type' => $value['type'],
                            'banner_url' => $image_url,
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
        return $this->db->update_batch('section', $get_json_content, 'id');
    }

    public function getListKeywordCount($key_search, $visible)
    {
        $this->db->select('id_ads');
        $this->db->from('ads_homepage');
        
        if ($key_search != 'null') {
            $this->db->like('title', $key_search);
        }

        $this->db->where('on_feature', 'homepage');
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

        $this->db->where('on_feature', 'homepage');
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
        $this->db->where('on_feature', 'homepage');
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
            ->where('on_feature', 'homepage')
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
                'on_feature' => 'homepage',
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
