<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tv_channel_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    public function category_tvchannels($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('genre_tv');
        if ($type == 'data')
        {
            $this->db->like('catname', $searchTerm);
            $this->db->where('visible', 'Y');
            $this->db->order_by('seq', 'asc');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        }
        else
        {
            if ($searchTerm!=null) {
                $this->db->like('catname', $searchTerm);
            }
            $this->db->where('visible', '0');
            return $this->db->get()->num_rows();
        }
    }

    public function getCountAll($key_search, $visible, $category)
    {
        $this->db->select('seq');
        $this->db->from('tv_channel');
        if ($key_search != 'null') {
            $this->db->like('title', $key_search);
        }
        if ($category != 'null' && $category != '-1') {
            $this->db->like('genrelist', ','.$category.',');
        }
        $this->db->where('visible', $visible);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getDatas($key_search, $sort_by, $order_sort, $visible, $category, $rowperpage, $rowno)
    {
        $this->db->select('*');
        $this->db->from('tv_channel');
        if ($key_search != 'null') {
            $this->db->like('title', $key_search);
        }
        if ($category != 'null' && $category != '-1') {
            $this->db->like('genrelist', ','.$category.',');
        }
        $this->db->where('visible', $visible);
        $this->db->order_by($sort_by, $order_sort);
        $this->db->limit($rowperpage, $rowno);  
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_list_genre($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('genre_tv');
        if ($type == 'data') {
            if ($searchTerm!=null) {
                $this->db->like('catname', $searchTerm);
            }
            $this->db->where('visible', 'Y');
            $this->db->order_by('seq', 'asc');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm!=null) {
                $this->db->like('catname', $searchTerm);
            }
            $this->db->where('visible', 'Y');
            return $this->db->get()->num_rows();
        }
    }

    public function get_genre_by_id($id)
    {
        return $this->db->get_where('genre_tv', ['seq' => $id])->row();
    }

    public function get_list_owner($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('client_app');
        if ($type == 'data') {
            if ($searchTerm!=null) {
                $this->db->like('name_client', $searchTerm);
            }
            $this->db->where('genre_tv_id is NOT NULL', NULL, FALSE);
            $this->db->where('visible', 'Y');
            $this->db->order_by('id_client', 'desc');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm!=null) {
                $this->db->like('name_client', $searchTerm);
            }
            $this->db->where('genre_tv_id is NOT NULL', NULL, FALSE);
            $this->db->where('visible', 'Y');
            return $this->db->get()->num_rows();
        }
    }

    public function get_owner_by_id($id)
    {
        $this->db->select('id_client as id, name_client as title');
        $this->db->from('client_app');
        $this->db->where('id_client', $id);
        return $this->db->get()->row();
    }

    public function sid()
    {
        $this->db->select_max('sortid');
        $this->db->from('tv_channel');
        $query = $this->db->get()->result_array();
        return $query[0]['sortid'];
    }

    public function insert_tv_channel($tv_data)
    {
        $owner_val = $tv_data['owner'];
        if ($owner_val == 'NULL') {
            $owner_val = NULL;
        }
        $tv_data['flag'] = bindec($tv_data['flag']);
        $insert_data = [
            'channelid' => $tv_data['channelid'],
            'genrelist' => $tv_data['genrelist'],
            'sortid' => $tv_data['sortid'],
            'title' => $tv_data['title'],
            'description' => $tv_data['description'],
            'file1' => $tv_data['file1'],
            'file3' => $tv_data['file3'],
            'play_url' => $tv_data['play_url'],
            'play_url_stb' => $tv_data['play_url_stb'],
            'play_url_ios_phone' => $tv_data['play_url_ios_phone'],
            'play_url_ios_pad' => $tv_data['play_url_ios_pad'],
            'play_url_android_phone' => $tv_data['play_url_android_phone'],
            'play_url_android_pad' => $tv_data['play_url_android_pad'],
            'tvod_url' => $tv_data['tvod_url'],
            'tvod_url_stb' => $tv_data['tvod_url_stb'],
            'tvod_url_ios_phone' => $tv_data['tvod_url_ios_phone'],
            'tvod_url_ios_pad' => $tv_data['tvod_url_ios_pad'],
            'tvod_url_android_phone' => $tv_data['tvod_url_android_phone'],
            'tvod_url_android_pad' => $tv_data['tvod_url_android_pad'],
            'watching' => $tv_data['watching'],
            'price' => $tv_data['price'],
            'price2' => $tv_data['price2'],
            'date1' => $tv_data['date1'],
            'date2' => $tv_data['date2'],
            'flag' => $tv_data['flag'],
            'update_date' => $tv_data['update_date'],
            'member_area' => $tv_data['member_area'],
            'member_id' => $tv_data['member_id'],
            'catchup_day_limit' => $tv_data['catchup_day_limit'],
            'banner_url' => $tv_data['banner_url'],
            'event' => $tv_data['event'],
            'link_url' => $tv_data['link_url'],
            'limit_access' => $tv_data['limit_access'],
            'trailer_url' => $tv_data['trailer_url'],
            'owner' => $tv_data['owner'],
        ];
        return $this->db->insert('tv_channel', $insert_data);
    }

    public function get_tv_by_id($id)
    {
        $this->db->select('*, CONV(flag, 10, 2) as flag_check');
        $this->db->from('tv_channel');
        $this->db->where('seq', $id);
        $query = $this->db->get()->result_array();
        $id_genre = trim($query[0]['genrelist'], ',');
        $dataflag = $query[0]['flag_check'];
        $id_owner = $query[0]['owner'];
        $flag = array(
            'catchup' => substr(substr('00000'.$dataflag,-5),0,1),
            'pc' => substr(substr('00000'.$dataflag,-5),1,1),
            'stb' => substr(substr('00000'.$dataflag,-5),2,1),
            'ios' => substr(substr('00000'.$dataflag,-5),3,1),
            'android' => substr(substr('00000'.$dataflag,-5),4,1)
        );
        
        $catchup_day_limit = str_split($query[0]['catchup_day_limit']);
        if ($catchup_day_limit[0]==0) {
            $catchup_web = 0;
            $catchup_stb = 0;
            $catchup_adr = 0;
            $catchup_ios = 0;
        } else {
            $count = count($catchup_day_limit);
            if ($count == '1') {
                $catchup_web = 0;
                $catchup_stb = 0;
                $catchup_adr = 0;
                $catchup_ios = $catchup_day_limit[0];
            } elseif ($count == '2') {
                $catchup_web = 0;
                $catchup_stb = 0;
                $catchup_adr = $catchup_day_limit[0];
                $catchup_ios = $catchup_day_limit[1];
            } elseif ($count == '3') {
                $catchup_web = 0;
                $catchup_stb = $catchup_day_limit[0];
                $catchup_adr = $catchup_day_limit[1];
                $catchup_ios = $catchup_day_limit[2];
            } elseif ($count == '4') {
                $catchup_web = $catchup_day_limit[0];
                $catchup_stb = $catchup_day_limit[1];
                $catchup_adr = $catchup_day_limit[2];
                $catchup_ios = $catchup_day_limit[3];
            }
        }
        $catchup_day_limit = array(
            'catchup_day_limit_web' => $catchup_web,
            'catchup_day_limit_stb' => $catchup_stb,
            'catchup_day_limit_adr' => $catchup_adr,
            'catchup_day_limit_ios' => $catchup_ios,
        );

        $this->db->select('seq as genre_id, catname as genre_name');
        $this->db->from('genre_tv');
        $this->db->where('seq in ('.$id_genre.')');
        $query_genre = $this->db->get()->result_array();

        $this->db->select('id_client, name_client');
        $this->db->from('client_app');
        $this->db->where('id_client', $id_owner);
        $query_owner = $this->db->get()->result_array();

        $data = array(
            'tv_channel' => $query[0],
            'genre_tv' => $query_genre,
            'owner' => $query_owner,
            'flag' => $flag,
            'catchup_day_limit' => $catchup_day_limit
        );
        return $data;
    }

    public function update_tv_channel($tv_data)
    {
        $owner_val = $tv_data['owner'];
        if ($owner_val == 'NULL') {
            $owner_val = NULL;
        }
        $tv_data['flag'] = bindec($tv_data['flag']);
        $update_data = [
            'genrelist' => $tv_data['genrelist'],
            'title' => $tv_data['title'],
            'description' => $tv_data['description'],
            'file1' => $tv_data['file1'],
            'file3' => $tv_data['file3'],
            'play_url' => $tv_data['play_url'],
            'play_url_stb' => $tv_data['play_url_stb'],
            'play_url_ios_phone' => $tv_data['play_url_ios_phone'],
            'play_url_ios_pad' => $tv_data['play_url_ios_pad'],
            'play_url_android_phone' => $tv_data['play_url_android_phone'],
            'play_url_android_pad' => $tv_data['play_url_android_pad'],
            'tvod_url' => $tv_data['tvod_url'],
            'tvod_url_stb' => $tv_data['tvod_url_stb'],
            'tvod_url_ios_phone' => $tv_data['tvod_url_ios_phone'],
            'tvod_url_ios_pad' => $tv_data['tvod_url_ios_pad'],
            'tvod_url_android_phone' => $tv_data['tvod_url_android_phone'],
            'tvod_url_android_pad' => $tv_data['tvod_url_android_pad'],
            'watching' => $tv_data['watching'],
            'price' => $tv_data['price'],
            'price2' => $tv_data['price2'],
            'date1' => $tv_data['date1'],
            'date2' => $tv_data['date2'],
            'flag' => $tv_data['flag'], // sudah berupa integer
            'update_date' => $tv_data['update_date'],
            'member_area' => $tv_data['member_area'],
            'member_id' => $tv_data['member_id'],
            'catchup_day_limit' => $tv_data['catchup_day_limit'],
            'banner_url' => $tv_data['banner_url'],
            'event' => $tv_data['event'],
            'link_url' => $tv_data['link_url'],
            'limit_access' => $tv_data['limit_access'],
            'trailer_url' => $tv_data['trailer_url'],
            'owner' => $owner_val
        ];
        $this->db->where('seq', $tv_data['seq']);
        return $this->db->update('tv_channel', $update_data);
    }

    public function activated_tv_channel($id)
    {
        $data = array(
            'seq' => $id,     
            'visible' => 'Y',
            'sortid' => $this->sid() + 1
        );
        $this->db->where('seq', $id);
        $this->db->update('tv_channel', $data);
        redirect(site_url('tv_channels'));
    }

    public function inactivated_tv_channel($id)
    {
        $data = array(
            'seq' => $id,     
            'visible' => 'N',
            'sortid' => 0
        );
        $this->db->where('seq', $id);
        $this->db->update('tv_channel', $data);
        redirect(site_url('tv_channels'));
    }

    public function getimagesquare()
    {
        $data = $this->db->query("select file1 from tv_channel");
        return $data->result_array();
    }

    public function getimagelandscape()
    {
        $data = $this->db->query("select file3 from tv_channel");
        return $data->result_array();
    }
}
