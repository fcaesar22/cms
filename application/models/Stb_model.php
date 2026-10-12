<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stb_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    public function getCountAll($key_search=null, $model='', $status='', $date='')
    {
        $this->db->select('seq');
        $this->db->from('stb');

        if (!empty($key_search) && $key_search != 'null') {
            $this->db->like('serial_number', $key_search);
            $this->db->or_like('user', $key_search);
        }

        if ($model != '' && $model != 'ALL') {
            $this->db->where('model', $model);
        } else {
            $listModels = array('DENS10 MRVL88DE3108', 'DENS20 CASTPAL-AW526', 'DENS2X MKTECH-MMP-OTT 888', 'DENSZTE', 'ZTEATV', 'MNC');
            $this->db->where_in('model', $listModels);
        }

        if ($status != '' && $status != 'All') {
            $this->db->where('status', $status);
        } else {
            $listStatus = array(
                1,
                2
            );
            $this->db->where_in('status', $listStatus);
        }

        if (!empty($date) && $date != 'null') {
            $date_range = explode(' to ', $date);

            if (count($date_range) == 2) {
                $start_date = trim($date_range[0]);
                $end_date   = trim($date_range[1]);

                $this->db->where('DATE(active_date) >=', $start_date);
                $this->db->where('DATE(active_date) <=', $end_date);
            }
        }

        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getDatas($key_search='', $model='', $status='', $date='', $sort_by='', $order_by='', $row_per_page='', $page_number='')
    {
        $data = array();
        $this->db->select('seq, serial_number, model, status, user, active_date, device_product');
        $this->db->from('stb');
        
        if (!empty($key_search) && $key_search != 'null') {
            $this->db->like('serial_number', $key_search);
            $this->db->or_like('user', $key_search);
        }

        if ($model != '' && $model != 'ALL') {
            $this->db->where('model', $model);
        } else {
            $listModels = array(
                'DENS10 MRVL88DE3108',
                'DENS20 CASTPAL-AW526',
                'DENS2X MKTECH-MMP-OTT 888',
                'DENSZTE',
                'ZTEATV',
                'MNC'
            );
            $this->db->where_in('model', $listModels);
        }

        if ($status != '' && $status != 'All') {
            $this->db->where('status', $status);
        } else {
            $listStatus = array(
                1,
                2
            );
            $this->db->where_in('status', $listStatus);
        }

        if (!empty($date) && $date != 'null') {
            $date_range = explode(' to ', $date);

            if (count($date_range) == 2) {
                $start_date = trim($date_range[0]);
                $end_date   = trim($date_range[1]);

                $this->db->where('DATE(active_date) >=', $start_date);
                $this->db->where('DATE(active_date) <=', $end_date);
            }
        }

        $this->db->order_by($sort_by, $order_by);
        $this->db->limit($row_per_page, $page_number);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getEmail($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('email, fullname');
        $this->db->from('member');
        if ($type == 'data') {
            if ($searchTerm != null) {
                $this->db->like('email', $searchTerm);
                $this->db->or_like('fullname', $searchTerm);
            }
            $this->db->where('visible', 'Y');
            $this->db->order_by('seq', 'DESC');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm != null) {
                $this->db->like('email', $searchTerm);
                $this->db->or_like('fullname', $searchTerm);
            }
            $this->db->where('visible', 'Y');
            return $this->db->get()->num_rows();
        }
    }

    public function activateStb($id, $email, $time)
    {
        $this->db->set('status', 2);
        $this->db->set('user', $email);
        $this->db->set('update_date', $time);
        $this->db->set('active_date', $time);
        $this->db->set('ctrloc', 'cms-aid stb/activateStb');
        $this->db->where('seq', $id);
        return $this->db->update('stb');
    }

    public function checkClientLog($device_product, $time)
    {
        $deletePreference = 'Delete-' . $time . '-' . $device_product;
        
        $this->db->set('preference', $deletePreference);
        $this->db->set('expire', $time);
        $this->db->set('update_date', $time);
        $this->db->where('preference', $device_product);
        $this->db->update('client_log');
        
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        
        return false;
    }

    public function deactivateStb($id, $time)
    {
        $this->db->set('status', 1);
        $this->db->set('user', NULL);
        $this->db->set('update_date', $time);
        $this->db->set('ctrloc', 'cms-aid stb/deactivateStb');
        $this->db->where('seq', $id);
        return $this->db->update('stb');
    }

    public function getDataExport($key_search, $model, $status, $date)
    {
        $this->db->select('seq, serial_number, model, status, user, active_date, device_product');
        $this->db->from('stb');
        
        if (!empty($key_search) && $key_search != 'null') {
            $this->db->like('serial_number', $key_search);
            $this->db->or_like('user', $key_search);
        }

        if ($model != '' && $model != 'ALL') {
            $this->db->where('model', $model);
        } else {
            $listModels = array(
                'DENS10 MRVL88DE3108',
                'DENS20 CASTPAL-AW526',
                'DENS2X MKTECH-MMP-OTT 888',
                'DENSZTE',
                'ZTEATV',
                'MNC'
            );
            $this->db->where_in('model', $listModels);
        }

        if ($status != '' && $status != 'All') {
            $this->db->where('status', $status);
        } else {
            $listStatus = array(
                1,
                2
            );
            $this->db->where_in('status', $listStatus);
        }

        if (!empty($date) && $date != 'null') {
            $date_range = explode(' to ', $date);

            if (count($date_range) == 2) {
                $start_date = trim($date_range[0]);
                $end_date   = trim($date_range[1]);

                $this->db->where('DATE(active_date) >=', $start_date);
                $this->db->where('DATE(active_date) <=', $end_date);
            }
        }

        $this->db->order_by('seq', 'DESC');

        $query = $this->db->get();
        $num_rows = $query->num_rows();
        $records = $query->result_array();

        $result = array(
            'num_rows' => $num_rows,
            'records' => $records
        );

        return $result;
    }
}
