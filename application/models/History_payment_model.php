<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class History_payment_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    public function getCountSectionAll($key_search, $date)
    {
        $this->db->select('COUNT(*) AS total, COALESCE(SUM(totalprice), 0) AS total_price', false);
        $this->db->from('orders');

        if (!empty($key_search) && $key_search != 'null') {
            $this->db->group_start();
            $this->db->like('orderid', $key_search);
            $this->db->or_like('userid', $key_search);
            $this->db->group_end();
        } else {
            if (!empty($date) && $date != 'null') {
                $date_range = explode(' to ', $date);

                if (count($date_range) == 2) {
                    $start_date = trim($date_range[0]) . ' 00:00:00';
                    $end_date   = trim($date_range[1]) . ' 23:59:59';

                    $this->db->where('paiddate >=', $start_date);
                    $this->db->where('paiddate <=', $end_date);
                }
            }
        }

        $this->db->where('orderstatus', '02');
        $this->db->like('description', 'GO PREMIUM');

        $this->db->group_start();
        $this->db->where_in('payment_channel', array('02', '06', '07', '08', '04004', '04015', '04018', '04026', '04028', '04035', '09'));
        $this->db->or_where('ctrloc', 'v2010/ch02_redeem_v6/index');
        $this->db->group_end();

        return $result = $this->db->get()->row_array();
    }

    public function getDatasSection($key_search, $sort_by, $order_sort, $date, $rowperpage, $rowno)
    {
        $this->db->select('seq, orderid, userid, description, totalprice, payment_channel, paiddate');
        $this->db->from('orders');

        if (!empty($key_search) && $key_search != 'null') {
            $this->db->group_start();
            $this->db->like('orderid', $key_search);
            $this->db->or_like('userid', $key_search);
            $this->db->group_end();
        } else {
            if (!empty($date) && $date != 'null') {
                $date_range = explode(' to ', $date);

                if (count($date_range) == 2) {
                    $start_date = trim($date_range[0]);
                    $end_date   = trim($date_range[1]);

                    $this->db->where('paiddate >=', $start_date . ' 00:00:00');
                    $this->db->where('paiddate <=', $end_date . ' 23:59:59');
                }
            }
        }

        $this->db->where('orderstatus', '02');
        $this->db->like('description', 'GO PREMIUM');
        
        $this->db->group_start();
        $this->db->where_in('payment_channel', array('02', '06', '07', '08', '04004', '04015', '04018', '04026', '04028', '04035', '09'));
        $this->db->or_where('ctrloc', 'v2010/ch02_redeem_v6/index');
        $this->db->group_end();

        $this->db->order_by($sort_by, $order_sort);
        $this->db->limit($rowperpage, $rowno);

        $query = $this->db->get();
        
        return $query->result_array();
    }

    public function getExportDatas($date)
    {
        $this->db->select('seq, orderid, userid, description, totalprice, payment_channel, paiddate');
        $this->db->from('orders');

        if (!empty($date) && $date != 'null') {
            $date_range = explode(' to ', $date);

            if (count($date_range) == 2) {
                $start_date = trim($date_range[0]);
                $end_date   = trim($date_range[1]);

                $this->db->where('paiddate >=', $start_date . ' 00:00:00');
                $this->db->where('paiddate <=', $end_date . ' 23:59:59');
            }
        }

        $this->db->where('orderstatus', '02');
        $this->db->like('description', 'GO PREMIUM');
        
        $this->db->group_start();
        $this->db->where_in('payment_channel', array('02', '06', '07', '08', '04004', '04015', '04018', '04026', '04028', '04035', '09'));
        $this->db->or_where('ctrloc', 'v2010/ch02_redeem_v6/index');
        $this->db->group_end();

        $this->db->order_by('seq', 'ASC');
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
