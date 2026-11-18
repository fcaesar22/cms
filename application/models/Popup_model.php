<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Popup_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    public function getCountAll($key_search, $visible)
    {
        $this->db->select('COUNT(tab_popup.id) AS total', false);
        $this->db->from('tab_popup');
        $this->db->join('tab_popup_location', 'tab_popup.location_id = tab_popup_location.id', 'left');
        
        if ($key_search != 'null') {
            $this->db->like('tab_popup_location.location_name', $key_search);
        }

        $this->db->where('status', $visible);
        $result = $this->db->get()->row_array();

        return (int) $result['total'];
    }

    public function getDatas($key_search, $sort_by, $order_sort, $visible, $rowperpage, $rowno)
    {
        $this->db->select('tab_popup.*, tab_popup_location.location_name');
        $this->db->from('tab_popup');
        $this->db->join('tab_popup_location', 'tab_popup.location_id = tab_popup_location.id', 'left');

        if ($key_search != 'null') {
            $this->db->like('tab_popup_location.location_name', $key_search);
        }

        $this->db->where('status', $visible);
        $this->db->order_by($sort_by, $order_sort);
        $this->db->limit($rowperpage, $rowno);  
        $query = $this->db->get();
        
        return $query->result_array();
    }

    public function inactivatedPopups($id, $time)
    {
        if (empty($id)) {
            return false;
        }

        $this->db->trans_start();

        $this->db->set('status', 'not_active');
        $this->db->where('id', $id);
        $this->db->update('tab_popup');
        
        $this->db->trans_complete();
        
        $msg = true;
        
        if ($this->db->trans_status() === FALSE) {
            $msg = false;
        }

        return $msg;
    }

    public function getListLocation($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('tab_popup_location');
        if ($type == 'data') {
            if ($searchTerm!=null) {
                $this->db->like('location_name', $searchTerm);
            }
            $this->db->order_by('id', 'asc');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm!=null) {
                $this->db->like('location_name', $searchTerm);
            }
            return $this->db->get()->num_rows();
        }
    }

    public function getSingleLocation($id)
    {
        $this->db->select('*');
        $this->db->from('tab_popup_location');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }

    private function getDeviceOptions()
    {
        return array(
            array(
                'id' => 'all',
                'title' => 'All'
            ),
            array(
                'id' => 'website',
                'title' => 'Website'
            ),
            array(
                'id' => 'android',
                'title' => 'Android'
            ),
            array(
                'id' => 'ios',
                'title' => 'Ios'
            ),
            array(
                'id' => 'stb',
                'title' => 'Stb'
            ),
        );
    }

    public function getListDevice($perPage, $page, $searchTerm, $type)
    {
        $data = $this->getDeviceOptions();

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

    public function getSingleDevice($id)
    {
        foreach ($this->getDeviceOptions() as $row) {
            if ($row['id'] === $id) {
                return (object) $row;
            }
        }

        return null;
    }

    private function getCategoryOptions()
    {
        return array(
            array(
                'id' => 'external',
                'title' => 'External'
            ),
            array(
                'id' => 'tv',
                'title' => 'Tv'
            ),
            array(
                'id' => 'vod',
                'title' => 'Vod'
            ),
        );
    }

    public function getListCategory($perPage, $page, $searchTerm, $type)
    {
        $data = $this->getCategoryOptions();

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

    public function getSingleCategory($id)
    {
        foreach ($this->getCategoryOptions() as $row) {
            if ($row['id'] === $id) {
                return (object) $row;
            }
        }

        return null;
    }

    public function insertPopup($data)
    {
        return $this->db->insert('tab_popup', $data);
    }

    public function getPopupById($id)
    {
        $result = array();
        
        $this->db->select('tab_popup.*, tab_popup_location.location_name');
        $this->db->from('tab_popup');
        $this->db->join('tab_popup_location', 'tab_popup.location_id = tab_popup_location.id', 'left');
        $this->db->where('tab_popup.id', $id);
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        
        if ($num_rows > 0) {
            $result = $query->result_array();
        }

        return $result;
    }

    public function updatePopup($id, $popup_data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tab_popup', $popup_data);
    }
}
