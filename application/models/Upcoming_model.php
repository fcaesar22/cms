<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upcoming_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    public function getCountAll($key_search, $visible)
    {
        $this->db->select('id_upcoming');
        $this->db->from('upcoming');

        if ($key_search != 'null') {
            $this->db->like('title', $key_search);
        }

        $this->db->where('visible', $visible);
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function getDatas($key_search, $sort_by, $order_sort, $visible, $rowperpage, $rowno)
    {
        $this->db->select('id_upcoming, title, description, director, cast, sort, visible, create_date, update_date');
        $this->db->from('upcoming');

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

    public function update_sort($idUpcoming, $sort)
    {
        $this->db
            ->where('id_upcoming', $idUpcoming)
            ->update('upcoming', [
                'sort' => $sort
            ]);

        return $this->db->affected_rows();
    }

    public function activated_upcoming($id, $time)
    {
        if (empty($id)) {
            return false;
        }

        $this->db->trans_start();

        $this->db->select('sort');
        $this->db->from('upcoming');
        $this->db->where('visible', 'Y');
        $this->db->order_by('CAST(sort AS decimal) DESC', false);
        $sort = $this->db->get()->row('sort');

        $this->db->set('visible', 'Y');
        $this->db->set('sort', $sort + 1);
        $this->db->where('id_upcoming', $id);
        $this->db->update('upcoming');
        $this->db->trans_complete();
        
        $msg = true;

        if ($this->db->trans_status() === FALSE) {
            $msg = false;
        }

        return $msg;
    }

    public function inactivated_upcoming($id, $time)
    {
        if (empty($id)) {
            return false;
        }

        $this->db->trans_start();

        $this->db->set('visible', 'N');
        $this->db->set('sort', NULL);
        $this->db->where('id_upcoming', $id);
        $this->db->update('upcoming');

        $this->db->select('id_upcoming, sort');
        $this->db->from('upcoming');
        $this->db->where('visible', 'Y');
        $this->db->order_by('CAST(sort AS decimal) ASC', false);
        $result = $this->db->get()->result_array();

        $data = array();
        $i=1;
        foreach ($result as $key => $value) {
            $data[] = array(
                'sort' => $i,
                'id_upcoming' => $value['id_upcoming']
            );
            $i++;
        }

        $this->db->update_batch('upcoming', $data, 'id_upcoming');
        
        $this->db->trans_complete();
        
        $msg = true;
        
        if ($this->db->trans_status() === FALSE) {
            $msg = false;
        }

        return $msg;
    }

    public function getListGenre($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('keywords');
        if ($type == 'data') {
            if ($searchTerm!=null) {
                $this->db->like('keyword_name', $searchTerm);
            }
            $this->db->where('keyword_ref', 'GEN');
            $this->db->where('keyword_visible', 'Y');
            $this->db->order_by('keyword_name', 'asc');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm!=null) {
                $this->db->like('keyword_name', $searchTerm);
            }
            $this->db->where('keyword_ref', 'GEN');
            $this->db->where('keyword_visible', 'Y');
            return $this->db->get()->num_rows();
        }
    }

    public function getSingleGenre($id)
    {
        $this->db->select('keyword_id, keyword_name');
        $this->db->from('keywords');
        $this->db->where('keyword_id', $id);
        return $this->db->get()->row();
    }

    private function getRatedOptions()
    {
        return array(
            array(
                'id' => 'Rated : G',
                'title' => 'G (Semua Umur)'
            ),
            array(
                'id' => 'Rated : PG',
                'title' => 'PG (Perlu bimbingan orang tua)'
            ),
            array(
                'id' => 'Rated : PG13',
                'title' => 'PG-13 (Usia 13 tahun atau lebih)'
            ),
            array(
                'id' => 'Rated : R',
                'title' => 'R (Restricted)'
            ),
            array(
                'id' => 'Rated : X',
                'title' => 'X (Dewasa-17 tahun keatas)'
            ),
        );
    }

    public function getListRated($perPage, $page, $searchTerm, $type)
    {
        $data = $this->getRatedOptions();

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

    public function getSingleRated($id)
    {
        foreach ($this->getRatedOptions() as $row) {
            if ($row['id'] === $id) {
                return (object) $row;
            }
        }

        return null;
    }

    public function insert_upcoming($upcoming_data)
    {
        return $this->db->insert('upcoming', $upcoming_data);
    }

    public function get_upcoming_by_id($id)
    {
        $result = array();
        
        $this->db->select('*');
        $this->db->from('upcoming');
        $this->db->where('id_upcoming', $id);
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        
        if ($num_rows > 0) {
            $result = $query->result_array();
        }

        return $result;
    }

    public function update_upcoming($id, $upcoming_data)
    {
        $this->db->where('id_upcoming', $id);
        return $this->db->update('upcoming', $upcoming_data);
    }

    public function getImageBanner()
    {
        $data = $this->db->query("select image_potrait from upcoming");
        return $data->result_array();
    }

    public function getImagePopUp()
    {
        $data = $this->db->query("select image_landscape from upcoming");
        return $data->result_array();
    }
}
