<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Originals extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user')) {
            redirect('auth');
        }
        if (!has_permission('view_originals')) {
            show_error('Anda tidak memiliki akses ke halaman ini', 403, 'Forbidden');
        }
        $this->load->config('secure_config');
        $this->load->library('pagination');
        $this->load->library('libadapter');
        $this->load->model('Original_model');
    }

    private static $baseurlimage = 'https://picture.dens.tv/wp/';

    public function index()
    {
        $data['title'] = 'List Originals';
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('originals/index', $data);
        $this->load->view('layouts/footer');
    }

    public function list_originals($key_search=null, $sort_by='id', $order_sort='desc', $visible='Y', $rowperpage=10, $rowno=0)
    {
        if ($rowno != 0) {
            $rowno = ($rowno-1) * $rowperpage;
        }

        $allcount = $this->Original_model->getCountAll($key_search, $visible);
        $users_record = $this->Original_model->getDatas($key_search, $sort_by, $order_sort, $visible, $rowperpage, $rowno);

        // Pagination Configuration
        $config['base_url'] = base_url().'originals/list_originals/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$visible.'/'.$rowperpage.'/'.$rowno;
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $allcount;
        $config['per_page'] = $rowperpage;
        $config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close'] = '</span>Next</li>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close'] = '</span></li>';
        $this->pagination->initialize($config);
        $data['z'] = $config['total_rows'];
        $data['x'] = (int)$rowno + 1;
        if ($rowno + $config['per_page'] > $config['total_rows']) {
            $data['y'] = $config['total_rows'];
        } else {
            $data['y'] = (int)$rowno + $config['per_page'];
        }
        // Initialize $data Array
        $data['pagination'] = $this->pagination->create_links();
        $data['result'] = $users_record;
        $data['row'] = $rowno;
        $data['order'] = $order_sort;
        echo json_encode($data);
    }

    public function update_sort()
    {
        $page_id_array = $this->input->post('page_id_array');
        $action = $this->input->post('action');

        if (empty($page_id_array) || $action != 'update') {
            echo json_encode([
                'error' => '1',
                'message' => 'Invalid request'
            ]);
            return;
        }

        for ($count = 0; $count < count($page_id_array); $count++) {
            $sort = $count + 1;
            $idOriginal = $page_id_array[$count];

            $this->Original_model->update_sort($idOriginal, $sort);
        }

        echo json_encode([
            'error' => '0',
            'message' => 'Sorting updated successfully'
        ]);
    }

    public function activated_original($id)
    {
        if (!isset($id)) show_404();
        
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');
        $active = $this->Original_model->activated_original($id, $time);
        if ($active == true) {
            $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Activated has been successfully!</div>');
            redirect(site_url('originals'));
        } else {
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Activated is failed!</div>');
            redirect(site_url('originals'));
        }
    }

    public function inactivated_original($id)
    {
        if (!isset($id)) show_404();
        
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');
        $inactivated = $this->Original_model->inactivated_original($id, $time);
        if ($inactivated == true) {
            $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Inactivated has been successfully!</div>');
            redirect(site_url('originals'));
        } else {
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Inactivated is failed!</div>');
            redirect(site_url('originals'));
        }
    }

    public function getListVod()
    {
        $searchTerm = $this->input->post('searchTerm');
        $searchTerm = urldecode($searchTerm);
        $page = $this->input->post('page');
        $perPage = 10;
        
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }

        $results = $this->Original_model->getListVod($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Original_model->getListVod($perPage, $page, $searchTerm, 'count');
        $data = array();
        
        foreach ($results as $row) {
            $data[] = array(
                "id" => $row['movie_id'],
                "text" => $row['movie_title'],
                "data" => $row
            );
        }
        
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function getListBannerAds()
    {
        $searchTerm = $this->input->post('searchTerm');
        $searchTerm = urldecode($searchTerm);
        $page = $this->input->post('page');
        $perPage = 10;
        
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }

        $results = $this->Original_model->getListBannerAds($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Original_model->getListBannerAds($perPage, $page, $searchTerm, 'count');
        $data = array();
        
        foreach ($results as $row) {
            $data[] = array(
                "id" => $row['id_ads'],
                "text" => $row['title'],
                "data" => $row
            );
        }
        
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function create()
    {
        $CI =& get_instance();
        $data['title'] = 'Add Original';
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('originals/create', $data);
        $this->load->view('layouts/footer');
    }

    public function insertOriginal()
    {
        $title = $this->input->post('title');
        $json_content = $this->input->post('json_content');

        if ($title == null || $json_content == null) {
            $data = array(
                'res' => '1',
                'msg' => 'Error'
            );
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $data = array(
                'title' => $title,
                'json_content' => $json_content,
                'on_feature' => 'homepage',
                'create_date' => $time,
                'update_date' => $time,
                'ctrloc' => '/originals/insertOriginal'
            );
            $create = $this->Original_model->insertOriginal($data);
            
            if ($create == true) {
                $data = array(
                    'res' => '0',
                    'msg' => 'Success'
                );
            } else {
                $data = array(
                    'res' => '1',
                    'msg' => 'Error'
                );
            }
        }

        echo json_encode($data);
    }

    public function edit($id = null)
    {
        $CI =& get_instance();
        if (!$id) show_404();
        $data['title'] = 'Edit Original';
        $data['idSection'] = $id;
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('originals/edit', $data);
        $this->load->view('layouts/footer');
    }

    public function getDataEdit()
    {
        $id = $this->input->post('id', TRUE);
        $results = $this->Original_model->getDataEdit($id);
        
        if ($results != null) {
            $data = $results;
        } else {
            die("Data not found");
        }

        echo json_encode($data);
    }

    public function updateOrginal($value='')
    {
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $json_content = $this->input->post('json_content');

        if ($id == null || $title == null || $json_content == null) {
            $data = array(
                'res' => '1',
                'msg' => 'Error'
            );
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $ctrloc = '/originals/updateOriginal';
            $create = $this->Original_model->updateOrginal($id, $title, $json_content, $time, $ctrloc);
            
            if ($create == true) {
                $data = array(
                    'res' => '0',
                    'msg' => 'Success'
                );
            } else {
                $data = array(
                    'res' => '1',
                    'msg' => 'Error'
                );
            }
        }

        echo json_encode($data);
    }

    public function sync_all()
    {
        $get_json_content = $this->Original_model->get_json_content();
        
        if (!empty($get_json_content)) {
            $update_jsoncontent = $this->Original_model->update_jsoncontent($get_json_content);

            if ($update_jsoncontent == true) {
                redirect(site_url('originals'));
            }
        }
    }

    public function listAds($key_search=null, $sort_by='id_ads', $order_sort='DESC', $visible='Y', $rowperpage, $rowno=0)
    {
        if ($rowperpage == null) {
            $rowperpage = 10;
        }

        if ($rowno != 0) {
            $rowno = ($rowno-1) * $rowperpage;
        }
        
        $key_search = urldecode($key_search);

        $allcount = $this->Original_model->getListKeywordCount($key_search, $visible);
        $users_record = $this->Original_model->getDataListKeyword($key_search, $visible, $order_sort, $sort_by, $rowperpage, $rowno);

        $config['base_url'] = base_url().'originals/listAds/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$visible.'/'.$rowperpage.'/'.$rowno;
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $allcount;
        $config['per_page'] = $rowperpage;
        $config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close'] = '</span>Next</li>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close'] = '</span></li>';
        $this->pagination->initialize($config);
        $data['z'] = $config['total_rows'];
        $data['x'] = (int)$rowno + 1;
        
        if ($rowno + $config['per_page'] > $config['total_rows']) {
            $data['y'] = $config['total_rows'];
        } else {
            $data['y'] = (int)$rowno + $config['per_page'];
        }

        $data['pagination'] = $this->pagination->create_links();
        $data['result'] = $users_record;
        $data['row'] = $rowno;
        $data['order'] = $order_sort;
        echo json_encode($data);
    }

    public function updateSortAds()
    {
        $page_id_array = $this->input->post('page_id_array');
        $on_feature = 'homepage_mobile';
        $action = $this->input->post('action');

        if (empty($page_id_array) || empty($on_feature) || $action != 'update') {
            echo json_encode([
                'error' => '1',
                'message' => 'Invalid request'
            ]);
            return;
        }

        for ($count = 0; $count < count($page_id_array); $count++) {
            $sort = $count + 1;
            $id_ads = $page_id_array[$count];

            $this->Original_model->updateSortAds($id_ads, $on_feature, $sort);
        }

        echo json_encode([
            'error' => '0',
            'message' => 'Sorting updated successfully'
        ]);
    }

    public function activate_ads()
    {
        $id = $this->input->post('id');
        $inactive = $this->Original_model->activate_ads($id);
        if ($inactive == true) {
            $results = array(
                'error' => '0',
                'message' => 'The ads has been successfully activated.'
            );
        } else {
            $results = array(
                'error' => '1',
                'message' => 'Failed to activate the ads.'
            );
        }
        echo json_encode($results);
    }

    public function inactivate_ads()
    {
        $id = $this->input->post('id');
        $inactive = $this->Original_model->inactivate_ads($id);
        if ($inactive == true) {
            $results = array(
                'error' => '0',
                'message' => 'The ads has been successfully deactivated.'
            );
        } else {
            $results = array(
                'error' => '1',
                'message' => 'Failed to deactivate the ads.'
            );
        }
        echo json_encode($results);
    }

    public function get_data_edit_ads()
    {
        $id = $this->input->post('id',TRUE);
        $code = $this->Original_model->get_data_edit_ads($id);
        
        if ($code != null) {
            $data = $code;
        } else {
            die("Data not found");
        }

        echo json_encode($data);
    }

    public function cu_ads()
    {
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');

        $id_ads = $this->input->post('id_ads_form');
        $image_url = $this->input->post('imgAdsUrl');
        $title = $this->input->post('titleAds');
        $target = $this->input->post('target');
        $location = $this->input->post('location');
        $type_content = $this->input->post('type_content');
        $content_id = $this->input->post('content_id');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        
        if ($id_ads == null || $id_ads == "") {
            $cu = $this->Original_model->cu_ads($id_ads, $image_url, $title, $target, $location, $type_content, $content_id, $start_date, $end_date, $time, 'create');
        } else {
            $cu = $this->Original_model->cu_ads($id_ads, $image_url, $title, $target, $location, $type_content, $content_id, $start_date, $end_date, $time, 'update');
        }

        if ($cu['status'] == true) {
            $results = array(
                'error' => '0',
                'message' => $cu['message']
            );
        } else {
            $results = array(
                'error' => '1',
                'message' => $cu['message']
            );
        }

        echo json_encode($results);
    }

    public function get_token()
    {
        $toURL = $this->config->item('url_token_uploader');
        $post = array();
        $exe = $this->libadapter->execurl($toURL, $post);
        $_token = json_decode($exe['data'],true);
        echo $_token['token'];
    }

    public function compare_image_landscape()
    {
        echo json_encode($this->getImageBannerLandscape());
    }

    private function getImageBannerLandscape()
    {
        $data = array();
        $_arrFolder = array();
        $_urlimage = array();
        
        //formed array from server
        $path = 'wp/img/banner_v1/1008x300/';
        $changeDir = 'wp/img/banner_v1/1008x300/';
        $listimg = $this->libadapter->getImages($path, $changeDir);
        
        if ($listimg['error'] == 0) {
            $_arrFolder = array();
            $listimg1 = $listimg['content'];
            foreach ($listimg1 as $key => $value) {
                $_arrFolder[] = $value['url'];
            }
            krsort($_arrFolder);
            
            //formed array from database
            $urlimage = $this->Original_model->getImageBannerLandscape();
            
            if ($urlimage != null) {
                foreach ($urlimage as $key => $value) {
                    array_push($_urlimage, self::$baseurlimage . $path . basename($value['image_url']));
                }
            }
            
            $datas=array_values(array_diff($_arrFolder, $_urlimage));
            $data = array_slice($datas,0,10);
            $results = array(
                'error' => '0',
                'message' => 'success',
                'content' => $data,
            );
        } else {
            $results = array(
                'error' => '1',
                'message' => 'failed',
                'content' => $data,
            );
        }
        return $results;
    }
}
