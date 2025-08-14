<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Movie_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    public function category_movies($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('keywords');
        if ($type == 'data') {
            if ($searchTerm!=null) {
                $this->db->like('keyword_name', $searchTerm);
            }
            $this->db->where('keyword_visible', 'Y');
            $this->db->where_in('keyword_ref', array('STD','GEN'));
            $this->db->where('keyword_parentid IS NULL', null, false);
            $this->db->order_by('keyword_ref', 'DESC');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm!=null) {
                $this->db->like('keyword_name', $searchTerm);
            }
            $this->db->where('keyword_visible', 'Y');
            $this->db->where_in('keyword_ref', array('STD','GEN'));
            $this->db->where('keyword_parentid IS NULL', null, false);
            return $this->db->get()->num_rows();
        }
    }

    public function getCountAll($key_search, $visible, $category)
    {
        $this->db->select('movie_id');
        $this->db->from('movies');
        if ($category!='null' && $category != '-1') {
            $this->db->like('movie_keywords', $category);
        }
        if ($key_search!='null') {
            $this->db->like('movie_title', $key_search);
            $this->db->or_like('movie_code', $key_search);
        }
        $this->db->where('movie_visible', $visible);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getDatas($key_search, $sort_by, $order_sort, $visible, $category, $rowperpage, $rowno)
    {
        $this->db->select('*');
        $this->db->from('movies');
        if ($category!='null' && $category != '-1') {
            $this->db->like('movie_keywords', $category);
        }
        if ($key_search!='null') {
            $this->db->like('movie_title', $key_search);
            $this->db->or_like('movie_code', $key_search);
        }
        $this->db->where('movie_visible', $visible);
        $this->db->order_by($sort_by, $order_sort);
        $this->db->limit($rowperpage, $rowno);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function activated_movie($id)
    {
        $data = array(
            'movie_id' => $id,
            'movie_visible' => 'Y'
        );
        $this->db->where('movie_id', $id);
        $this->db->update('movies', $data);
        redirect(site_url('movies'));
    }

    public function inactivated_movie($id)
    {
        $data = array(
            'movie_id' => $id,
            'movie_visible' => 'N'
        );
        $this->db->where('movie_id', $id);
        $this->db->update('movies', $data);
        redirect(site_url('movies'));
    }

    public function get_list_movie_code($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('mng_code');
        if ($type == 'data') {
            if ($searchTerm!=null) {
                $this->db->like('code_init', $searchTerm);
                $this->db->or_like('code_remark', $searchTerm);
            }
            $this->db->where('code_visible', 'Y');
            $this->db->where('code_parent', '87');
            $this->db->order_by('code_id', 'DESC');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm!=null) {
                $this->db->like('code_init', $searchTerm);
                $this->db->or_like('code_remark', $searchTerm);
            }
            $this->db->where('code_visible', 'Y');
            $this->db->where('code_parent', '87');
            return $this->db->get()->num_rows();
        }
    }

    public function get_movie_code_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('mng_code');
        $this->db->where('code_init', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $key => $value) {
                $data = array(
                    'id' => $value['code_init'],
                    'title' => $value['code_init'] . ' - ' . $value['code_remark']
                );
            }
        } else {
            $data = array();
        }
        return $data;
    }

    public function get_list_movie_parent_id($perPage, $page, $searchTerm, $movie_parent, $type)
    {
        switch ($movie_parent) {
            case 'STD':
                $result = $this->getKeywords($perPage, $page, $searchTerm, $movie_parent, $type);
                break;
            case 'SER':
                $result = $this->GetMovies($perPage, $page, $searchTerm, $movie_parent, $type);
                break;
            case 'SEA':
                $result = $this->GetMovies($perPage, $page, $searchTerm, $movie_parent, $type);
                break;
            case 'DPL':
                $result = $this->getKeywords($perPage, $page, $searchTerm, $movie_parent, $type);
                break;
            default:
                $result = null;
                break;
        }
        return $result;
    }

    public function getKeywords($perPage, $page, $searchTerm, $movie_parent, $type)
    {
        $this->db->select('*');
        $this->db->from('keywords');
        if ($type == 'data') {
            if ($searchTerm!=null) {
                $this->db->like('keyword_name', $searchTerm);
            }
            $this->db->where('keyword_visible', 'Y');
            $this->db->where('keyword_ref', $movie_parent);
            $this->db->order_by('keyword_id', 'DESC');
            $this->db->limit($perPage, $page);
            $query_res = $this->db->get()->result_array();
            $data = array();
            if (count($query_res) > 0) {
                foreach ($query_res as $row) {
                    $data[] = array(
                        "id"=>$row['keyword_id'],
                        "text"=>$row['keyword_name']
                    );
                }
            }
            return $data;
        } else {
            if ($searchTerm!=null) {
                $this->db->like('keyword_name', $searchTerm);
            }
            $this->db->where('keyword_visible', 'Y');
            $this->db->where('keyword_ref', $movie_parent);
            return $this->db->get()->num_rows();
        }
    }

    public function GetMovies($perPage, $page, $searchTerm, $movie_parent, $type)
    {
        $this->db->select('*');
        $this->db->from('movies');
        if ($type == 'data') {
            if ($searchTerm!=null) {
                $this->db->like('movie_title', $searchTerm);
            }
            $this->db->where('movie_visible', 'Y');
            $this->db->where('movie_type', $movie_parent);
            $this->db->order_by('movie_id', 'DESC');
            $this->db->limit($perPage, $page);
            $query_res = $this->db->get()->result_array();
            $data = array();
            if (count($query_res) > 0) {
                foreach ($query_res as $row) {
                    $data[] = array(
                        "id"=>$row['movie_id'],
                        "text"=>$row['movie_title']
                    );
                }
            }
            return $data;
        } else {
            if ($searchTerm!=null) {
                $this->db->like('movie_title', $searchTerm);
            }
            $this->db->where('movie_visible', 'Y');
            $this->db->where('movie_type', $movie_parent);
            return $this->db->get()->num_rows();
        }
    }

    public function get_single_movie_parent_id($id, $movie_parent)
    {
        switch ($movie_parent) {
            case 'STD':
            case 'DPL':
                return $this->getKeywordById($id, $movie_parent);
            case 'SER':
            case 'SEA':
                return $this->getMovieById($id, $movie_parent);
            default:
                return null;
        }
    }

    private function getKeywordById($id, $ref)
    {
        $this->db->select('keyword_id, keyword_name');
        $this->db->from('keywords');
        $this->db->where('keyword_id', $id);
        $this->db->where('keyword_ref', $ref);
        $this->db->where('keyword_visible', 'Y');
        $row = $this->db->get()->row_array();

        if ($row) {
            return [
                'id' => $row['keyword_id'],
                'text' => $row['keyword_name']
            ];
        }
        return null;
    }

    private function getMovieById($id, $type)
    {
        $this->db->select('movie_id, movie_title');
        $this->db->from('movies');
        $this->db->where('movie_id', $id);
        $this->db->where('movie_type', $type);
        $this->db->where('movie_visible', 'Y');
        $row = $this->db->get()->row_array();

        if ($row) {
            return [
                'id' => $row['movie_id'],
                'text' => $row['movie_title']
            ];
        }
        return null;
    }

    public function get_list_group_keyword($perPage, $page, $searchTerm, $type)
    {
        if ($type == 'data') {
            $this->db->select('k.keyword_id AS id');
            $this->db->select("
                CASE 
                    WHEN k.keyword_ref = 'GEN' AND k.keyword_parentid IS NOT NULL AND k.keyword_parentid != ''
                    THEN CONCAT(k.keyword_name, ':SUBGEN-', kp.keyword_name)
                    ELSE CONCAT(k.keyword_name, ':', k.keyword_ref)
                END AS title
            ", false);
            $this->db->from('keywords k');
            $this->db->join(
                'keywords kp',
                "kp.keyword_id = CAST(SUBSTRING_INDEX(TRIM(BOTH ',' FROM k.keyword_parentid), ',', 1) AS UNSIGNED)",
                'LEFT'
            );
            if ($searchTerm!=null) {
                $this->db->like('k.keyword_name', $searchTerm);
            }
            $this->db->where_in('k.keyword_ref', array('STD','VBX','SEO','REC','CMB','DPL','GEN'));
            $this->db->where('k.keyword_visible', 'Y');
            $this->db->order_by('k.keyword_ref', 'ASC');
            $this->db->order_by('k.keyword_name', 'ASC');
            $this->db->order_by("
                CASE 
                    WHEN k.keyword_parentid IS NULL OR k.keyword_parentid = '' THEN k.keyword_id
                    ELSE CAST(SUBSTRING_INDEX(TRIM(BOTH ',' FROM k.keyword_parentid), ',', 1) AS UNSIGNED) + 0.1
                END,
                k.keyword_id
            ", '', false);
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            $this->db->select('k.keyword_id AS id');
            $this->db->select("
                CASE 
                    WHEN k.keyword_ref = 'GEN' AND k.keyword_parentid IS NOT NULL AND k.keyword_parentid != ''
                    THEN CONCAT(k.keyword_name, ':SUBGEN-', kp.keyword_name)
                    ELSE CONCAT(k.keyword_name, ':', k.keyword_ref)
                END AS title
            ", false);
            $this->db->from('keywords k');
            $this->db->join(
                'keywords kp',
                "kp.keyword_id = CAST(SUBSTRING_INDEX(TRIM(BOTH ',' FROM k.keyword_parentid), ',', 1) AS UNSIGNED)",
                'LEFT'
            );
            // Tambahkan search filter jika ada
            if ($searchTerm!=null) {
                $this->db->like('k.keyword_name', $searchTerm);
            }
            $this->db->where_in('k.keyword_ref', array('STD','VBX','SEO','REC','CMB','DPL','GEN'));
            $this->db->where('k.keyword_visible', 'Y');
            return $this->db->get()->num_rows();
        }
    }

    public function get_group_keyword_by_id($id)
    {
        return $this->db->get_where('keywords', ['keyword_id' => $id])->row();
    }

    public function new_movie_code($premode)
    {
        $data = array();
        $strsql = "SELECT SUBSTRING(movie_code,7,4) as topcode FROM movies WHERE movie_code LIKE '$premode%'  ORDER BY movie_code DESC LIMIT 3";
        $query = $this->db->query($strsql);
        $num = $query->num_rows();
        $exist_int_endcode = 0000;
        $datas = array();
        if ($num > 0) {
            $data = $query->result_array();
            $exist_int_endcode = $data[0]['topcode'];
            $datas = $data[0];
        }
        $new_int_endcode = $exist_int_endcode+1;
        $g = strlen($new_int_endcode);
        switch ($g) {
            case 1:
                $newcode = $premode.'000'.$new_int_endcode;
                break;
            case 2:
                $newcode = $premode.'00'.$new_int_endcode;
                break;
            case 3:
                $newcode = $premode.'0'.$new_int_endcode;
                break;
            case 4:
                $newcode = $premode.$new_int_endcode;
                break;
        }
        $check['data'] = $data;
        $check['newmoviecode'] = $newcode;
        $check['strsql'] = $strsql;
        $check['topcode'] = $datas;
        $check['endcode'] = $exist_int_endcode;
        return $check;
    }

    public function insert_movie($movie_data)
    {
        $this->db->insert('movies', $movie_data);
        return $movie_id = $this->db->insert_id();
    }

    public function get_movie_by_id($id)
    {
        $data = array();
        $this->db->select('*');
        $this->db->from('movies');
        $this->db->where('movie_id', $id);
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        if ($num_rows > 0) {
            $return = $query->result_array();
            foreach ($return as $key => $value) {
                $mvCode = substr($value['movie_code'], 0, 5);
                $mvParent = $value['movie_parentype'];
                $mvParentID = $value['movie_parent_id'];
                $mvKeywords = $value['movie_keywords'];
                $this->db->select('*');
                $this->db->from('mng_code');
                $this->db->where('code_init', $mvCode);
                $queryCode = $this->db->get();
                $num_rows_code = $queryCode->num_rows();
                $movie_code_init = null;
                $movie_code_remark = null;
                if ($num_rows_code > 0) {
                    $returnCode = $queryCode->result_array();
                    $movie_code_init = $returnCode[0]['code_init'];
                    $movie_code_remark = $returnCode[0]['code_remark'];
                }
                $movie_parent_id_name = null;
                if ($mvParent == 'STD' || $mvParent == 'DPL') {
                    $this->db->select('*');
                    $this->db->from('keywords');
                    $this->db->where('keyword_id', $mvParentID);
                    $queryKeyword = $this->db->get();
                    $num_rows_keyword = $queryKeyword->num_rows();
                    if ($num_rows_keyword > 0) {
                        $returnKeyword = $queryKeyword->result_array();
                        $movie_parent_id_name = $returnKeyword[0]['keyword_name'];
                    }
                } else {
                    $this->db->select('*');
                    $this->db->from('movies');
                    $this->db->where('movie_id', $mvParentID);
                    $queryMovie = $this->db->get();
                    $num_rows_movie = $queryMovie->num_rows();
                    if ($num_rows_movie > 0) {
                        $returnMovie = $queryMovie->result_array();
                        $movie_parent_id_name = $returnMovie[0]['movie_title'];
                    }
                }
                $value['movie_code_init'] = $movie_code_init;
                $value['movie_code_remark'] = $movie_code_remark;
                $value['movie_parent_id_name'] = $movie_parent_id_name;

                $explodeKeywords = array_filter(array_values(explode(',', $mvKeywords)));
                $this->db->select('k.keyword_id AS id');
                $this->db->select("
                    CASE 
                        WHEN k.keyword_ref = 'GEN' AND k.keyword_parentid IS NOT NULL AND k.keyword_parentid != ''
                        THEN CONCAT(k.keyword_name, ':SUBGEN-', kp.keyword_name)
                        ELSE CONCAT(k.keyword_name, ':', k.keyword_ref)
                    END AS title
                ", false);
                $this->db->from('keywords k');
                $this->db->join(
                    'keywords kp',
                    "kp.keyword_id = CAST(SUBSTRING_INDEX(TRIM(BOTH ',' FROM k.keyword_parentid), ',', 1) AS UNSIGNED)",
                    'LEFT'
                );
                $this->db->where_in('k.keyword_ref', array('STD','VBX','SEO','CMB','REC','DPL','GEN'));
                $this->db->where_in('k.keyword_id', $explodeKeywords);
                $queryGroupKeyword = $this->db->get();
                $num_rows_group_keyword = $queryGroupKeyword->num_rows();
                $groupKeywords = array();
                if ($num_rows_group_keyword > 0)
                {
                    $groupKeywords = $queryGroupKeyword->result_array();
                }
                $value['group_keywords'] = $groupKeywords;
                $value['movie_date1'] = date('Y-m-d', strtotime($value['movie_date1']));
                $value['movie_date2'] = date('Y-m-d', strtotime($value['movie_date2']));
                $data[] = $value;
            }
        }
        return $data;
    }

    public function update_movie($movie_data)
    {
        $this->db->set('movie_code', $movie_data['movie_code']);
        $this->db->set('movie_title', $movie_data['movie_title']);
        $this->db->set('movie_description', $movie_data['movie_description']);
        $this->db->set('movie_seq', $movie_data['movie_seq']);
        $this->db->set('movie_actor', $movie_data['movie_actor']);
        $this->db->set('movie_director', $movie_data['movie_director']);
        $this->db->set('movie_keywords', $movie_data['movie_keywords']);
        $this->db->set('movie_rating', $movie_data['movie_rating']);
        $this->db->set('movie_year', $movie_data['movie_year']);
        $this->db->set('movie_trailer', $movie_data['movie_trailer']);
        $this->db->set('movie_watching', $movie_data['movie_watching']);
        $this->db->set('movie_price', $movie_data['movie_price']);
        $this->db->set('movie_date1', $movie_data['movie_date1']);
        $this->db->set('movie_date2', $movie_data['movie_date2']);
        $this->db->set('movie_allowapps', $movie_data['movie_allowapps']);
        $this->db->set('movie_type', $movie_data['movie_type']);
        $this->db->set('movie_parent_id', $movie_data['movie_parent_id']);
        $this->db->set('movie_parentype', $movie_data['movie_parentype']);
        $this->db->set('movie_childtype', $movie_data['movie_childtype']);
        $this->db->set('movie_payable', $movie_data['movie_payable']);
        $this->db->where('movie_id', $movie_data['movie_id']);
        return $this->db->update('movies');
    }

    public function getListCodeCount($key_search,$visible)
    {
        $this->db->select('count(code_id) as allcount');
        $this->db->from('mng_code');
        if ($key_search!='null') {
            $this->db->like('code_init', $key_search);
            $this->db->or_like('code_remark', $key_search);
        }
        $this->db->where('code_visible', $visible);
        $this->db->where('code_parent', '87');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result[0]['allcount'];
    }

    public function getDataListCode($rowno,$rowperpage,$order_sort,$sort_by,$key_search,$visible)
    {
        $this->db->select('*');
        $this->db->from('mng_code');
        if ($key_search!='null') {
            $this->db->like('code_init', $key_search);
            $this->db->or_like('code_remark', $key_search);
        }
        $this->db->where('code_visible', $visible);
        $this->db->where('code_parent', '87');
        $this->db->order_by($sort_by, $order_sort);
        $this->db->limit($rowperpage, $rowno);  
        $query = $this->db->get();
        return $query->result_array();
    }

    public function insert_code($data)
    {
        $this->db->select('*');
        $this->db->from('mng_code');
        $this->db->where('code_init', $data['code_init']);
        $query = $this->db->get();
        if ($query->num_rows() <= 0) {
            $this->db->insert('mng_code', $data);
            return true;
        } else {
            return false;
        }
    }

    public function get_data_edit_code($id)
    {
        $this->db->select('*');
        $this->db->from('mng_code');
        $this->db->where('code_id', $id);
        $query = $this->db->get()->result();
        return $query;
    }

    public function update_code($code_id,$initial_code,$remark)
    {
        $this->db->select('*');
        $this->db->from('mng_code');
        $this->db->where('code_init', $initial_code);
        $query = $this->db->get();
        if ($query->num_rows() <= 0) {
            $this->db->set('code_init', $initial_code);
            $this->db->set('code_remark', $remark);
            $this->db->where('code_id', $code_id);
            $this->db->update('mng_code');
            return true;
        } else {
            return false;
        }
    }

    public function activate_code($id)
    {
        $this->db->select('code_sort');
        $this->db->from('mng_code');
        $this->db->where('code_visible', 'Y');
        $this->db->order_by('CAST(code_sort AS DECIMAL)', 'DESC');
        $this->db->limit(1);
        $querysort = $this->db->get();
        if ($querysort->num_rows() <= 0) {
            $sort = 1;
        } else {
            $returnsort = $querysort->result_array();
            $sort = $returnsort[0]['code_sort'] + 1;
        }

        $this->db->set('code_visible', 'Y');
        $this->db->set('code_sort', $sort);
        $this->db->where('code_id', $id);
        return $this->db->update('mng_code');
    }

    public function inactivate_code($id)
    {
        $this->db->set('code_visible', 'N');
        $this->db->set('code_sort', '0');
        $this->db->where('code_id', $id);
        return $this->db->update('mng_code');
    }

    public function update_sort($query)
    {
        return $this->db->query($query);
    }

    public function getListKeywordCount($key_search,$visible,$contentKey)
    {
        $this->db->select('count(k.keyword_id) as allcount');
        if ($contentKey=='SUBGEN') {
            $this->db->select("
                CASE 
                    WHEN k.keyword_ref = 'GEN' AND k.keyword_parentid IS NOT NULL AND k.keyword_parentid != ''
                    THEN CONCAT(k.keyword_name, ':SUBGEN-', kp.keyword_name)
                    ELSE CONCAT(k.keyword_name, ':', k.keyword_ref)
                END AS title
            ", false);
            $this->db->from('keywords k');
            $this->db->join('keywords kp', "kp.keyword_id = CAST(SUBSTRING_INDEX(TRIM(BOTH ',' FROM k.keyword_parentid), ',', 1) AS UNSIGNED)",
                'LEFT');
            $this->db->where('k.keyword_ref', 'GEN');
            $this->db->where('k.keyword_parentid IS NOT NULL', null, false);
            $this->db->where('k.keyword_visible', $visible);
            if ($key_search!='null') {
                $this->db->like('k.keyword_name', $key_search);
            }
        } elseif ($contentKey=='GEN') {
            $this->db->from('keywords k');
            $this->db->where('k.keyword_ref', $contentKey);
            $this->db->where('k.keyword_parentid IS NULL', null, false);
            $this->db->where('k.keyword_visible', $visible);
            if ($key_search!='null') {
                $this->db->like('k.keyword_name', $key_search);
            }
        } elseif ($contentKey=='STD') {
            $this->db->from('keywords k');
            $this->db->where('k.keyword_ref', $contentKey);
            $this->db->where('k.keyword_visible', $visible);
            if ($key_search!='null') {
                $this->db->like('k.keyword_name', $key_search);
            }
            $this->db->order_by('CAST(k.keyword_sort AS DECIMAL)', 'ASC');
        }
        $query = $this->db->get();
        $result = $query->result_array();
        return $result[0]['allcount'];
    }

    public function getDataListKeyword($rowno,$rowperpage,$order_sort,$sort_by,$key_search,$visible,$contentKey)
    {
        $this->db->select('k.*');
        if ($contentKey=='SUBGEN') {
            $this->db->select("kp.keyword_name AS genre_name", false);
            $this->db->from('keywords k');
            $this->db->join('keywords kp', "kp.keyword_id = CAST(SUBSTRING_INDEX(TRIM(BOTH ',' FROM k.keyword_parentid), ',', 1) AS UNSIGNED)",
                'LEFT');
            $this->db->where('k.keyword_ref', 'GEN');
            $this->db->where('k.keyword_parentid IS NOT NULL', null, false);
                if ($key_search!='null') {
                $this->db->like('k.keyword_name', $key_search);
            }
        } elseif ($contentKey=='GEN') {
            $this->db->from('keywords k');
            $this->db->where('k.keyword_ref', $contentKey);
            $this->db->where('k.keyword_parentid IS NULL', null, false);
            if ($key_search!='null') {
                $this->db->like('k.keyword_name', $key_search);
            }
        } elseif ($contentKey=='STD') {
            $this->db->from('keywords k');
            $this->db->where('k.keyword_ref', $contentKey);
            if ($key_search!='null') {
                $this->db->like('k.keyword_name', $key_search);
            }
            $this->db->order_by('CAST(k.keyword_sort AS DECIMAL)', 'ASC');
        }
        $this->db->where('k.keyword_visible', $visible);
        $this->db->order_by($sort_by, $order_sort);
        $this->db->limit($rowperpage, $rowno);  
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_list_genre($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('keywords');
        if ($type == 'data') {
            if ($searchTerm!=null) {
                $this->db->like('keyword_name', $searchTerm);
            }
            $this->db->where('keyword_visible', 'Y');
            $this->db->where('keyword_ref', 'GEN');
            $this->db->where('keyword_parentid IS NULL', null, false);
            $this->db->order_by('keyword_id', 'DESC');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm!=null) {
                $this->db->like('keyword_name', $searchTerm);
            }
            $this->db->where('keyword_visible', 'Y');
            $this->db->where('keyword_ref', 'GEN');
            $this->db->where('keyword_parentid IS NULL', null, false);
            return $this->db->get()->num_rows();
        }
    }

    public function cu_keyword($keyword_id,$keyword_name,$keyword_child,$keyword_ref,$genre_id,$type)
    {
        if ($type=='create') {
            if ($keyword_id!=null || $keyword_id!="") {
                return false;
            }
            switch ($keyword_ref) {
                case 'STD':
                    $data = array(
                        'keyword_name' => $keyword_name,
                        'keyword_child' => $keyword_child,
                        'keyword_sub' => 'N',
                        'keyword_ref' => $keyword_ref,
                    );
                    break;
                case 'GEN':
                    $data = array(
                        'keyword_name' => $keyword_name,
                        'keyword_child' => $keyword_child,
                        'keyword_sub' => 'N',
                        'keyword_ref' => $keyword_ref,
                    );
                    break;
                case 'SUBGEN':
                    $data = array(
                        'keyword_name' => $keyword_name,
                        'keyword_child' => $keyword_child,
                        'keyword_sub' => 'N',
                        'keyword_ref' => $keyword_ref,
                        'keyword_parentid' => ','.$genre_id.',',
                    );
                    break;
                default:
                    return false;
                    break;
            }
            $this->db->insert('keywords', $data);
            return true;
        } else {
            if ($keyword_id==null || $keyword_id=="") {
                return false;
            }
            switch ($keyword_ref) {
                case 'STD':
                    $this->db->set('keyword_name', $keyword_name);
                    $this->db->where('keyword_id', $keyword_id);
                    $this->db->update('keywords');
                    return true;
                    break;
                case 'GEN':
                    $this->db->set('keyword_name', $keyword_name);
                    $this->db->where('keyword_id', $keyword_id);
                    $this->db->update('keywords');
                    return true;
                    break;
                case 'SUBGEN':
                    $keywordparentid = ','.$genre_id.',';
                    $this->db->set('keyword_name', $keyword_name);
                    $this->db->set('keyword_parentid', $keywordparentid);
                    $this->db->where('keyword_id', $keyword_id);
                    $this->db->update('keywords');
                    return true;
                    break;
                default:
                    return false;
                    break;
            }
        }
    }

    public function get_data_edit_keyword($id)
    {
        $this->db->select('k.*, kp.keyword_id as id_parent, kp.keyword_name as name_parent');
        $this->db->from('keywords k');
        $this->db->join('keywords kp', "kp.keyword_id = CAST(SUBSTRING_INDEX(TRIM(BOTH ',' FROM k.keyword_parentid), ',', 1) AS UNSIGNED)",
                'LEFT');
        $this->db->where('k.keyword_id', $id);
        $query = $this->db->get()->result();
        return $query;
    }

    public function get_data_poster_stream($movie_id)
    {
        $data = array();
        $this->db->select('*');
        $this->db->from('movies');
        $this->db->where('movie_id', $movie_id);
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        if ($num_rows > 0) {
            $return = $query->result_array();
            $movie_code = $return[0]['movie_code'];
            $this->db->select('*');
            $this->db->from('poster');
            $this->db->where('product_id', $movie_code);
            $this->db->where_in('poster_type', array('vod_1280x720','vod_410x230','vod_235x132','vod_549x825','vod_183x275','vod_170x252','vod_122x182'));
            $queryPoster = $this->db->get();
            $num_rowsPoster = $queryPoster->num_rows();
            $grouped = array(
                'portrait' => array(),
                'landscape' => array()
            );
            if ($num_rowsPoster > 0) {
                $returnPoster = $queryPoster->result_array();
                foreach ($returnPoster as $poster) {
                    if (preg_match('/vod_(\d+)x(\d+)/', $poster['poster_type'], $matches)) {
                        $width = (int)$matches[1];
                        $height = (int)$matches[2];

                        if ($height > $width) {
                            $grouped['portrait'][] = $poster;
                        } else {
                            $grouped['landscape'][] = $poster;
                        }
                    }
                }
            }
            $this->db->select('*');
            $this->db->from('streams');
            $this->db->where('product_id', $movie_code);
            $queryStream = $this->db->get();
            $returnStream = $queryStream->result_array();
            $data = array(
                'movie_id' => $return[0]['movie_id'],
                'movie_code' => $return[0]['movie_code'],
                'poster' => $grouped,
                'stream' => $returnStream
            );
        }
        return $data;
    }

    public function check_movie_id($movie_id)
    {
        $this->db->select('movie_code');
        $this->db->from('movies');
        $this->db->where('movie_id', $movie_id);
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        $movie_code = null;
        if ($num_rows > 0) {
            $return = $query->result_array();
            $movie_code = $return[0]['movie_code'];
        }
        return $data = array(
            'num_rows' => $num_rows,
            'movie_code' => $movie_code
        );
    }

    public function insert_poster_new($data_poster)
    {
        $this->db->insert('poster', $data_poster);
    }

    public function update_poster_exist($id, $data_poster)
    {
        $this->db->where('poster_id', $id);
        $this->db->update('poster', $data_poster);
    }

    public function insert_stream_new($data_stream)
    {
        $this->db->insert('streams', $data_stream);
    }

    public function update_stream_exist($stream_id, $data_stream)
    {
        $this->db->where('stream_id', $stream_id);
        $this->db->update('streams', $data_stream);
    }

    public function getimagelandcape()
    {
        $data = $this->db->query("select poster_url from poster where poster_visible='Y' and poster_type='vod_235x132'");
        return $data->result_array();
    }

    public function getimageportrait()
    {
        $data = $this->db->query("select poster_url from poster where poster_visible='Y' and poster_type='vod_122x182'");
        return $data->result_array();
    }
}
