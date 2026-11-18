<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class List_payment_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    public function getCountSectionAll($key_search, $visible)
    {
        $this->db->select('COUNT(*) AS total', false);
        $this->db->from('list_payment');
        
        if ($key_search != 'null') {
            $this->db->like('payment_title', $key_search);
        }

        $this->db->where('visible', $visible);

        $result = $this->db->get()->row_array();

        return (int) $result['total'];
    }

    public function getDatasSection($key_search, $sort_by, $order_sort, $visible, $rowperpage, $rowno)
    {
        $this->db->select('*');
        $this->db->from('list_payment');

        if ($key_search != 'null') {
            $this->db->like('payment_title', $key_search);
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

    public function update_sort($idPayment, $sort)
    {
        $this->db->where('payment_id', $idPayment);
        $this->db->where('visible', 'Y');

        $this->db->update('list_payment', [
            'sort' => $sort
        ]);

        return $this->db->affected_rows();
    }

    public function activatedPayment($id, $time)
    {
        if (empty($id)) {
            return false;
        }

        $this->db->trans_start();

        $this->db->select('sort');
        $this->db->from('list_payment');
        $this->db->where('visible', 'Y');
        $this->db->order_by('CAST(sort AS decimal) DESC', false);
        $sort = $this->db->get()->row('sort');

        $this->db->set('visible', 'Y');
        $this->db->set('sort', $sort + 1);
        $this->db->where('payment_id', $id);
        $this->db->update('list_payment');
        $this->db->trans_complete();
        
        $msg = true;

        if ($this->db->trans_status() === FALSE) {
            $msg = false;
        }

        return $msg;
    }

    public function inactivatedPayment($id, $time)
    {
        if (empty($id)) {
            return false;
        }

        $this->db->trans_start();

        $this->db->set('visible', 'N');
        $this->db->set('sort', NULL);
        $this->db->where('payment_id', $id);
        $this->db->update('list_payment');

        $this->db->select('payment_id, sort');
        $this->db->from('list_payment');
        $this->db->where('visible', 'Y');
        $this->db->order_by('CAST(sort AS decimal) ASC', false);
        $result = $this->db->get()->result_array();

        $data = array();
        $i=1;
        foreach ($result as $key => $value) {
            $data[] = array(
                'sort' => $i,
                'payment_id' => $value['payment_id']
            );
            $i++;
        }

        $this->db->update_batch('list_payment', $data, 'payment_id');
        
        $this->db->trans_complete();
        
        $msg = true;
        
        if ($this->db->trans_status() === FALSE) {
            $msg = false;
        }

        return $msg;
    }

    private function getTypeOptions()
    {
        return array(
            array(
                'id' => 'nominal',
                'title' => 'Nominal'
            ),
            array(
                'id' => 'percent',
                'title' => 'Percent'
            ),
        );
    }

    public function getListType($perPage, $page, $searchTerm, $type)
    {
        $data = $this->getTypeOptions();

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

    public function getSingleType($id)
    {
        foreach ($this->getTypeOptions() as $row) {
            if ($row['id'] === $id) {
                return (object) $row;
            }
        }

        return null;
    }

    public function getImageBannerLandscape()
    {
        $data = $this->db->query("select payment_image from list_payment");
        return $data->result_array();
    }

    public function insertPayment($payment_data)
    {
        return $this->db->insert('list_payment', $payment_data);
    }

    public function getPaymentById($id)
    {
        $result = array();
        
        $this->db->select('*');
        $this->db->from('list_payment');
        $this->db->where('payment_id', $id);
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        
        if ($num_rows > 0) {
            $result = $query->row_array();
        }

        return $result;
    }

    public function updatePayment($id, $payment_data)
    {
        $this->db->where('payment_id', $id);
        return $this->db->update('list_payment', $payment_data);
    }
}
