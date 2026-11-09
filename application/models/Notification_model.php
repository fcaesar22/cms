<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    public function getCountAll($key_search, $visible)
    {
        $this->db->select('id');
        $this->db->from('notifications');

        if ($key_search != 'null') {
            $this->db->like('title', $key_search);
        }

        $this->db->where('visible', $visible);
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function getDatas($key_search, $sort_by, $order_sort, $visible, $rowperpage, $rowno)
    {
        $this->db->select('*');
        $this->db->from('notifications');

        if ($key_search != 'null') {
            $this->db->like('title', $key_search);
        }

        $this->db->where('visible', $visible);
        $this->db->order_by($sort_by, $order_sort);
        $this->db->limit($rowperpage, $rowno);  
        $query = $this->db->get();
        
        return $query->result_array();
    }

    public function inactivated_notification($id, $time)
    {
        if (empty($id)) {
            return false;
        }

        $this->db->trans_start();

        $this->db->set('visible', 'N');
        $this->db->where('id', $id);
        $this->db->update('notifications');
        
        $this->db->trans_complete();
        
        $msg = true;
        
        if ($this->db->trans_status() === FALSE) {
            $msg = false;
        }

        return $msg;
    }

    public function checkIdNotification($id)
    {
        $this->db->select('*');
        $this->db->from('notifications');
        $this->db->where('id', $id);
        $get = $this->db->get();
        $num = $get->num_rows();
        $result = null;
        
        if ($num > 0) {
            $result_array = $get->result_array();
            $result = $result_array[0];
        }

        $data = array(
            'num_rows' => $num,
            'result' => $result
        );
        return $data;
    }

    public function getFnId($fnid)
    {
        $this->db->select('*');
        $this->db->from('firebase_notifications');
        $this->db->where_in('id', $fnid);
        $get = $this->db->get();
        $num_rows = $get->num_rows();
        $result = null;
        if ($num_rows>0)
        {
            $result_array = $get->result_array();
            $result = $result_array;
        }
        $data = array(
            'num_rows' => $num_rows,
            'result' => $result
        );
        return $data;
    }

    public function messageStatus($notification_id)
    {
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');
        $this->db->set('status', '1');
        $this->db->set('update_date', $time);
        $this->db->where('id', $notification_id);
        $this->db->update('notifications');
    }

    private function getToOptions()
    {
        return array(
            array(
                'id' => 'ALL',
                'title' => 'All'
            ),
            array(
                'id' => 'DENS_ANDROID',
                'title' => 'Device Android'
            ),
            array(
                'id' => 'DENS_IOS',
                'title' => 'Device IOS'
            ),
            array(
                'id' => 'DENS_GUEST',
                'title' => 'User Guest'
            ),
            array(
                'id' => 'DENS_CBN',
                'title' => 'User CBN'
            ),
            array(
                'id' => 'DENS_NONSUBSCRIBE',
                'title' => 'User Belum Berlangganan'
            ),
            array(
                'id' => 'DENS_SUBSCRIBE',
                'title' => 'User Sudah Berlangganan'
            ),
            array(
                'id' => 'SELECTION',
                'title' => 'Selection'
            ),
        );
    }

    public function getListTo($perPage, $page, $searchTerm, $type)
    {
        $data = $this->getToOptions();

        if ($searchTerm !== null && $searchTerm !== '') {
            $data = array_filter($data, function ($row) use ($searchTerm) {
                return stripos($row['title'], $searchTerm) !== false
                    || stripos($row['id'], $searchTerm) !== false;
            });

            $data = array_values($data);
        }

        if ($type == 'count') {
            return count($data);
        }

        return array_slice($data, $page, $perPage);
    }

    public function getSingleTo($id)
    {
        foreach ($this->getToOptions() as $row) {
            if ($row['id'] === $id) {
                return (object) $row;
            }
        }

        return null;
    }

    private function getContentTypeOptions()
    {
        return array(
            array(
                'id' => 'tv_activity',
                'title' => 'TV'
            ),
            array(
                'id' => 'vod_activity',
                'title' => 'VOD'
            ),
        );
    }

    public function getListContentType($perPage, $page, $searchTerm, $type)
    {
        $data = $this->getContentTypeOptions();

        if ($searchTerm !== null && $searchTerm !== '') {
            $data = array_filter($data, function ($row) use ($searchTerm) {
                return stripos($row['title'], $searchTerm) !== false
                    || stripos($row['id'], $searchTerm) !== false;
            });

            $data = array_values($data);
        }

        if ($type == 'count') {
            return count($data);
        }

        return array_slice($data, $page, $perPage);
    }

    public function getSingleContentType($id)
    {
        foreach ($this->getContentTypeOptions() as $row) {
            if ($row['id'] === $id) {
                return (object) $row;
            }
        }

        return null;
    }

    public function getListUid($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('firebase_notifications');
        if ($type == 'data')
        {
            if ($searchTerm!=null) {
                $this->db->like('user_id', $searchTerm);
            }
            
            $this->db->where_in('id', array(19,20));
            $this->db->order_by('user_id', 'asc');
            $this->db->limit($perPage, $page);
            
            return $this->db->get()->result_array();
        }
        else
        {
            if ($searchTerm!=null) {
                $this->db->like('user_id', $searchTerm);
            }
            
            $this->db->where_in('id', array(19,20));
            
            return $this->db->get()->num_rows();
        }
    }

    public function getMultipleUid($id)
    {
        return $this->db->get_where('firebase_notifications', ['id' => $id])->row();
    }

    public function insertNotification($data)
    {
        return $this->db->insert('notifications', $data);
    }

    public function getNotificationById($id)
    {
        $result = array();
        
        $this->db->select('*');
        $this->db->from('notifications');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        
        if ($num_rows > 0) {
            $result = $query->row_array();
            $user_id = $result['firebase_notifications_id'];
            $trimexplodeuid = array_filter(explode(',', trim($user_id, ',')));

            if (!empty($trimexplodeuid)) {
                $this->db->select('id, user_id');
                $this->db->from('firebase_notifications');
                $this->db->where_in('id', $trimexplodeuid);

                $result['uid'] = $this->db->get()->result_array();
            } else {
                $result['uid'] = array();
            }
        }

        return $result;
    }

    public function updateNotification($id, $notification_data)
    {
        $this->db->where('id', $id);
        return $this->db->update('notifications', $notification_data);
    }

    public function getImageBannerLandscape()
    {
        $data = $this->db->query("select image_url from notifications");
        return $data->result_array();
    }
}
