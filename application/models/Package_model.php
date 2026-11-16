<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Package_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    public function getCountAll($key_search, $status)
    {
        $this->db->select('COUNT(*) AS total', false);
        $this->db->from('package');
        
        if ($key_search != 'null') {
            $this->db->like('title', $key_search);
        }

        switch ($status) {
            case 'active':
                $this->db->where('visible', 'Y');
                break;
            case 'main':
                $this->db->where('pkgtype', "b'00'", false);
                break;
            case 'addon':
                $this->db->where('pkgtype', "b'01'", false);
                break;
            case 'coupon':
                $this->db->where('pkgtype', "b'11'", false);
                $this->db->or_where('affiliate', 'CPN');
                break;
            case 'stb':
                $this->db->where('pkgtype', "b'10'", false);
                break;
            case 'inactive':
                $this->db->where('visible', 'N');
                break;
        }

        $result = $this->db->get()->row_array();

        return (int) $result['total'];
    }

    public function getDatas($key_search, $sort_by, $order_sort, $status, $rowperpage, $rowno)
    {
        $this->db->select('*');
        $this->db->from('package');

        if ($key_search != 'null') {
            $this->db->like('title', $key_search);
        }

        switch ($status) {
            case 'active':
                $this->db->where('visible', 'Y');
                break;
            case 'main':
                $this->db->where('pkgtype', "b'00'", false);
                break;
            case 'addon':
                $this->db->where('pkgtype', "b'01'", false);
                break;
            case 'coupon':
                $this->db->where('pkgtype', "b'11'", false);
                $this->db->or_where('affiliate', 'CPN');
                break;
            case 'stb':
                $this->db->where('pkgtype', "b'10'", false);
                break;
            case 'inactive':
                $this->db->where('visible', 'N');
                break;
        }

        $this->db->order_by($sort_by, $order_sort);
        $this->db->limit($rowperpage, $rowno);
        $query = $this->db->get();
        
        return $query->result_array();
    }

    public function activatedPackage($id, $time)
    {
        if (empty($id)) {
            return false;
        }

        $this->db->trans_start();

        $this->db->set('visible', 'Y');
        $this->db->where('seq', $id);
        $this->db->update('package');
        
        $this->db->trans_complete();
        
        $msg = true;
        
        if ($this->db->trans_status() === FALSE) {
            $msg = false;
        }

        return $msg;
    }

    public function inactivatedPackage($id, $time)
    {
        if (empty($id)) {
            return false;
        }

        $this->db->trans_start();

        $this->db->set('visible', 'N');
        $this->db->where('seq', $id);
        $this->db->update('package');
        
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
                'id' => '0',
                'title' => 'Main Package'
            ),
            array(
                'id' => '1',
                'title' => 'Addon Package'
            ),
            array(
                'id' => '2',
                'title' => 'STB Rental'
            ),
            array(
                'id' => '3',
                'title' => 'Ticket Voucher'
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

    public function getListAffiliate($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('mng_code');
        if ($type == 'data') {
            if ($searchTerm!=null) {
                $this->db->like('code_remark', $searchTerm);
            }
            $this->db->where('code_parent', '117');
            $this->db->order_by('code_id', 'asc');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm!=null) {
                $this->db->like('code_remark', $searchTerm);
            }
            $this->db->where('code_parent', '117');
            return $this->db->get()->num_rows();
        }
    }

    public function getSingleAffiliate($id)
    {
        $this->db->select('*');
        $this->db->from('mng_code');
        $this->db->where('code_init', $id);
        return $this->db->get()->row();
    }

    public function getListTv($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('tv_channel');
        if ($type == 'data')
        {
            if ($searchTerm!=null) {
                $this->db->like('title', $searchTerm);
            }
            
            $this->db->where('visible', 'Y');
            $this->db->order_by('seq', 'desc');
            $this->db->limit($perPage, $page);
            
            return $this->db->get()->result_array();
        }
        else
        {
            if ($searchTerm!=null) {
                $this->db->like('title', $searchTerm);
            }
            
            $this->db->where('visible', 'Y');
            
            return $this->db->get()->num_rows();
        }
    }

    public function getMultipleTv($id)
    {
        return $this->db->get_where('tv_channel', ['seq' => $id])->row();
    }

    public function getListVod($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('movies');
        if ($type == 'data')
        {
            if ($searchTerm!=null) {
                $this->db->like('movie_title', $searchTerm);
            }
            
            $this->db->where('movie_visible', 'Y');
            $this->db->order_by('movie_id', 'desc');
            $this->db->limit($perPage, $page);
            
            return $this->db->get()->result_array();
        }
        else
        {
            if ($searchTerm!=null) {
                $this->db->like('movie_title', $searchTerm);
            }
            
            $this->db->where('movie_visible', 'Y');
            
            return $this->db->get()->num_rows();
        }
    }

    public function getMultipleVod($id)
    {
        return $this->db->get_where('movies', ['movie_id' => $id])->row();
    }

    public function getListMovie($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('movies');
        if ($type == 'data')
        {
            if ($searchTerm!=null) {
                $this->db->like('movie_title', $searchTerm);
            }
            
            $this->db->where('movie_visible', 'Y');
            $this->db->order_by('movie_id', 'desc');
            $this->db->limit($perPage, $page);
            
            return $this->db->get()->result_array();
        }
        else
        {
            if ($searchTerm!=null) {
                $this->db->like('movie_title', $searchTerm);
            }
            
            $this->db->where('movie_visible', 'Y');
            
            return $this->db->get()->num_rows();
        }
    }

    public function getMultipleMovie($id)
    {
        return $this->db->get_where('movies', ['movie_id' => $id])->row();
    }

    public function getListKeyword($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('keywords');
        if ($type == 'data')
        {
            if ($searchTerm!=null) {
                $this->db->like('keyword_name', $searchTerm);
            }
            
            $this->db->where('keyword_visible', 'Y');
            $this->db->where_in('keyword_ref', array('STD', 'VBX', 'EDU', 'SKO', 'SEO'));
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
            $this->db->where_in('keyword_ref', array('STD', 'VBX', 'EDU', 'SKO', 'SEO'));
            
            return $this->db->get()->num_rows();
        }
    }

    public function getMultipleKeyword($id)
    {
        return $this->db->get_where('keywords', ['keyword_id' => $id])->row();
    }

    public function insertPackage($package_data)
    {
        return $this->db->insert('package', $package_data);
    }

    public function getPackageById($id)
    {
        $result = array();
        
        $this->db->select('*');
        $this->db->from('package');
        $this->db->where('seq', $id);
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        
        if ($num_rows > 0) {
            $result = $query->row_array();
            
            $tvId = $result['tv_id'];
            $trimexplodetvid = array_filter(explode(',', trim($tvId, ',')));
            if (!empty($trimexplodetvid)) {
                $this->db->select('seq, title');
                $this->db->from('tv_channel');
                $this->db->where_in('seq', $trimexplodetvid);

                $result['tv_id'] = $this->db->get()->result_array();
            } else {
                $result['tv_id'] = array();
            }

            $vodId = $result['vod_id'];
            $trimexplodevodid = array_filter(explode(',', trim($vodId, ',')));
            if (!empty($trimexplodevodid)) {
                $this->db->select('movie_id, movie_title');
                $this->db->from('movies');
                $this->db->where_in('movie_id', $trimexplodevodid);

                $result['vod_id'] = $this->db->get()->result_array();
            } else {
                $result['vod_id'] = array();
            }

            $movieId = $result['movie_id'];
            $trimexplodemovieid = array_filter(explode(',', trim($movieId, ',')));
            if (!empty($trimexplodemovieid)) {
                $this->db->select('movie_id, movie_title');
                $this->db->from('movies');
                $this->db->where_in('movie_id', $trimexplodemovieid);

                $result['movie_id'] = $this->db->get()->result_array();
            } else {
                $result['movie_id'] = array();
            }

            $keywordId = $result['keyword'];
            $trimexplodekeywordid = array_filter(explode(',', trim($keywordId, ',')));
            if (!empty($trimexplodekeywordid)) {
                $this->db->select('keyword_id, keyword_name');
                $this->db->from('keywords');
                $this->db->where_in('keyword_id', $trimexplodekeywordid);

                $result['keyword'] = $this->db->get()->result_array();
            } else {
                $result['keyword'] = array();
            }
        }

        return $result;
    }

    public function updatePackage($id, $package_data)
    {
        $this->db->where('seq', $id);
        return $this->db->update('package', $package_data);
    }
}
