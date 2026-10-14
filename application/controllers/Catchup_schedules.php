<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catchup_schedules extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user')) {
            redirect('auth');
        }
        if (!has_permission('view_catchupselections')) {
            show_error('Anda tidak memiliki akses ke halaman ini', 403, 'Forbidden');
        }
        $this->load->config('secure_config');
        $this->load->library('pagination');
        $this->load->library('libadapter');
        $this->load->model('Catchup_schedule_model');
    }

    private static $baseurlimage = 'https://picture.dens.tv/wp/';

    public function index()
    {
        $data['title'] = 'List Catch Up Schedule';
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('catchup_schedules/index', $data);
        $this->load->view('layouts/footer');
    }

    public function category_catchup()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }
        $results = $this->Catchup_schedule_model->category_catchup($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Catchup_schedule_model->category_catchup($perPage, $page, $searchTerm, 'count');
        $data = array();
        foreach ($results as $row) {
            $data[] = array(
                "id" => $row['category_tvshow_id'],
                "text" => $row['title_tvshow']
            );
        }
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function list_catchup_schedules($key_search=null, $sort_by='a.id_top_tvshow', $order_sort='desc', $visible='Y', $category, $rowperpage=10, $rowno=0)
    {
        if ($rowno != 0) {
            $rowno = ($rowno-1) * $rowperpage;
        }

        $allcount = $this->Catchup_schedule_model->getCountAll($key_search, $visible, $category);
        $users_record = $this->Catchup_schedule_model->getDatas($key_search, $sort_by, $order_sort, $visible, $category, $rowperpage, $rowno);

        // Pagination Configuration
        $config['base_url'] = base_url().'catchup_schedules/list_catchup_schedules/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$visible.'/'.$category.'/'.$rowperpage.'/'.$rowno;
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
        $id_cat = $this->input->post('id_cat');
        $action = $this->input->post('action');

        if (empty($page_id_array) || empty($id_cat) || $action != 'update') {
            echo json_encode([
                'error' => '1',
                'message' => 'Invalid request'
            ]);
            return;
        }

        for ($count = 0; $count < count($page_id_array); $count++) {
            $sort = $count + 1;
            $id_top_tvshow = $page_id_array[$count];

            $this->Catchup_schedule_model->update_sort($id_top_tvshow, $id_cat, $sort);
        }

        echo json_encode([
            'error' => '0',
            'message' => 'Sorting updated successfully'
        ]);
    }

    public function activated_catchup($id, $category)
    {
        if (!isset($id)) show_404();
        if (!isset($category)) show_404();
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');
        $active = $this->Catchup_schedule_model->activated_catchup($id, $category, $time);
        if ($active == true) {
            $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Activated has been successfully!</div>');
            redirect(site_url('catchup_schedules'));
        } else {
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Activated is failed!</div>');
            redirect(site_url('catchup_schedules'));
        }
    }

    public function inactivated_catchup($id, $category)
    {
        if (!isset($id)) show_404();
        if (!isset($category)) show_404();
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');
        $inactivated = $this->Catchup_schedule_model->inactivated_catchup($id, $category, $time);
        if ($inactivated == true) {
            $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Inactivated has been successfully!</div>');
            redirect(site_url('catchup_schedules'));
        } else {
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Inactivated is failed!</div>');
            redirect(site_url('catchup_schedules'));
        }
    }

    public function get_list_toptvshow_category()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }

        $results = $this->Catchup_schedule_model->get_list_toptvshow_category($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Catchup_schedule_model->get_list_toptvshow_category($perPage, $page, $searchTerm, 'count');
        $data = array();
        
        foreach ($results as $row) {
            $data[] = array(
                "id" => $row['category_tvshow_id'],
                "text" => $row['title_tvshow']
            );
        }
        
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function get_single_toptvshow_category()
    {
        $id = $this->input->post('id');
        $data = $this->Catchup_schedule_model->get_single_toptvshow_category($id);
        echo json_encode([
            'id' => $data->category_tvshow_id,
            'text' => $data->title_tvshow
        ]);
    }

    public function get_list_category_channel()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }

        $results = $this->Catchup_schedule_model->get_list_category_channel($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Catchup_schedule_model->get_list_category_channel($perPage, $page, $searchTerm, 'count');
        $data = array();
        
        foreach ($results as $row) {
            $data[] = array(
                "id" => $row['seq'],
                "text" => $row['catname']
            );
        }
        
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function get_single_category_channel()
    {
        $id = $this->input->post('id');
        $data = $this->Catchup_schedule_model->get_single_category_channel($id);
        echo json_encode([
            'id' => $data->seq,
            'text' => $data->catname
        ]);
    }

    public function get_list_channel()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $categoryChannel = $this->input->post('categoryChannel');
        $perPage = 10;
        
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }

        $results = $this->Catchup_schedule_model->get_list_channel($categoryChannel, $perPage, $page, $searchTerm, 'data');
        $countResults = $this->Catchup_schedule_model->get_list_channel($categoryChannel, $perPage, $page, $searchTerm, 'count');
        $data = array();
        
        foreach ($results as $row) {
            $data[] = array(
                "id" => $row['seq'],
                "text" => $row['title']
            );
        }
        
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function get_single_channel()
    {
        $id = $this->input->post('id');
        $data = $this->Catchup_schedule_model->get_single_channel($id);
        echo json_encode([
            'id' => $data->seq,
            'text' => $data->title
        ]);
    }

    public function list_schedule()
    {
        $searchTerm = $this->input->post('searchTerm');
        $idChannel = $this->input->post('idChannel');
        $response = $this->Catchup_schedule_model->list_schedule($idChannel, $searchTerm);
        echo json_encode($response);
    }

    public function create()
    {
        $CI =& get_instance();
        $data['title'] = 'Add Catch Up';
        $this->form_validation->set_rules('toptvshow_category', 'Category TV Show', 'required', ['required' => 'Category Top TV Show harus dipilih']);
        $this->form_validation->set_rules('channel_category', 'Category Channel', 'required', ['required' => 'Category Channel harus dipilih']);
        $this->form_validation->set_rules('channel_id', 'Channel', 'required', ['required' => 'Channel harus dipilih']);
        $this->form_validation->set_rules('toptvshow_title', 'Title', 'required', ['required' => 'Title harus diisi']);
        $this->form_validation->set_rules('toptvshow_description', 'Description', 'required', ['required' => 'Description harus diisi']);
        $this->form_validation->set_rules('start_date', 'Start Date', 'required', ['required' => 'Start Date harus dipilih']);
        $this->form_validation->set_rules('end_date', 'End Date', 'required', ['required' => 'End Date harus dipilih']);
        $this->form_validation->set_rules('banner_image_landscape', 'Banner Landscape', 'required', ['required' => 'Banner Landscape harus dipilih']);
        $this->form_validation->set_rules('banner_image_portrait', 'Banner Portrait', 'required', ['required' => 'Banner Portrait harus dipilih']);
        $this->form_validation->set_rules('popup_image', 'Pop Up', 'required', ['required' => 'Pop Up harus dipilih']);

        if ($this->form_validation->run() == FALSE) {
            $data['selected_category_tvshow'] = set_value('toptvshow_category');
            $data['selected_category_channel'] = set_value('channel_category');
            $data['selected_channel'] = set_value('channel_id');
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('catchup_schedules/create', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $catchup_data = [
                'category_tvshow' => $this->input->post('toptvshow_category'),
                'id_channel' => $this->input->post('channel_id'),
                'title' => $this->input->post('toptvshow_title'),
                'description' => $this->input->post('toptvshow_description'),
                'category_channel' => $this->input->post('channel_category'),
                'banner_image' => $this->input->post('banner_image_landscape'),
                'banner_image_potrait' => $this->input->post('banner_image_portrait'),
                'popup_image' => $this->input->post('popup_image'),
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date'),
                'trailer_url' => $this->input->post('trailer_url'),
                'visible' => 'N',
                'create_date' => $time,
                'update_date' => $time,
                'ctrloc' => '/category_schedules/create'
            ];

            $saved = $this->Catchup_schedule_model->insert_catchup($catchup_data);

            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Catch Up Schedule berhasil disimpan</div>'); 
                return redirect('catchup_schedules');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Catch Up Schedule tidak berhasil disimpan</div>');
                return redirect('catchup_schedules');
            }
        }
    }

    public function edit($id = null)
    {
        $CI =& get_instance();
        if (!$id) show_404();
        $catchup = $this->Catchup_schedule_model->get_catchup_by_id($id);
        if (!$catchup) show_404();
        $data['title'] = 'Edit Catch Up';
        $data['catchup'] = $catchup[0];

        $this->form_validation->set_rules('toptvshow_category', 'Category TV Show', 'required', ['required' => 'Category Top TV Show harus dipilih']);
        $this->form_validation->set_rules('channel_category', 'Category Channel', 'required', ['required' => 'Category Channel harus dipilih']);
        $this->form_validation->set_rules('channel_id', 'Channel', 'required', ['required' => 'Channel harus dipilih']);
        $this->form_validation->set_rules('toptvshow_title', 'Title', 'required', ['required' => 'Title harus diisi']);
        $this->form_validation->set_rules('toptvshow_description', 'Description', 'required', ['required' => 'Description harus diisi']);
        $this->form_validation->set_rules('start_date', 'Start Date', 'required', ['required' => 'Start Date harus dipilih']);
        $this->form_validation->set_rules('end_date', 'End Date', 'required', ['required' => 'End Date harus dipilih']);
        $this->form_validation->set_rules('banner_image_landscape', 'Banner Landscape', 'required', ['required' => 'Banner Landscape harus dipilih']);
        $this->form_validation->set_rules('banner_image_portrait', 'Banner Portrait', 'required', ['required' => 'Banner Portrait harus dipilih']);
        $this->form_validation->set_rules('popup_image', 'Pop Up', 'required', ['required' => 'Pop Up harus dipilih']);
        if ($this->form_validation->run() == FALSE) {
            $data['selected_category_tvshow'] = set_value('toptvshow_category') ?: $catchup[0]['category_tvshow'];
            $data['selected_category_channel'] = set_value('channel_category') ?: $catchup[0]['category_channel'];
            $data['selected_channel'] = set_value('channel_id') ?: $catchup[0]['id_channel'];
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('catchup_schedules/edit', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $catchup_data = [
                'category_tvshow' => $this->input->post('toptvshow_category'),
                'id_channel' => $this->input->post('channel_id'),
                'title' => $this->input->post('toptvshow_title'),
                'description' => $this->input->post('toptvshow_description'),
                'category_channel' => $this->input->post('channel_category'),
                'banner_image' => $this->input->post('banner_image_landscape'),
                'banner_image_potrait' => $this->input->post('banner_image_portrait'),
                'popup_image' => $this->input->post('popup_image'),
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date'),
                'trailer_url' => $this->input->post('trailer_url'),
                'create_date' => $time,
                'update_date' => $time,
                'ctrloc' => '/category_schedules/edit'
            ];

            $saved = $this->Catchup_schedule_model->update_catchup($id, $catchup_data);

            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Catch Up Schedule berhasil diubah</div>'); 
                return redirect('catchup_schedules');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Catch Up Schedule tidak berhasil diubah</div>');
                return redirect('catchup_schedules');
            }
        }
    }

    public function listCategoryTopTvShow($key_search=null, $sort_by='category_tvshow_id', $order_sort='DESC', $visible='Y', $rowperpage, $rowno=0)
    {
        if ($rowperpage == null) {
            $rowperpage = 10;
        }

        if ($rowno != 0) {
            $rowno = ($rowno-1) * $rowperpage;
        }
        
        $key_search = urldecode($key_search);

        $allcount = $this->Catchup_schedule_model->getListKeywordCount($key_search, $visible);
        $users_record = $this->Catchup_schedule_model->getDataListKeyword($key_search, $visible, $order_sort, $sort_by, $rowperpage, $rowno);

        $config['base_url'] = base_url().'catchup_schedules/listCategoryTopTvShow/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$visible.'/'.$rowperpage.'/'.$rowno;
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $allcount;
        $config['per_page'] = $rowperpage;
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';
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

    public function update_sort_category()
    {
        $page_id_array = $this->input->post('page_id_array');
        $action = $this->input->post('action');
        if (!$page_id_array || $action != 'update') {
            echo json_encode(['error' => '1', 'message' => 'Invalid request']);
            return;
        }
        $result = $this->Catchup_schedule_model->update_sort_category($page_id_array);
        echo json_encode($result);
    }

    public function activate_shownumber()
    {
        $id = $this->input->post('id');
        $inactive = $this->Catchup_schedule_model->activate_shownumber($id);
        if ($inactive == true) {
            $results = array(
                'error' => '0',
                'message' => 'The show number has been successfully activated.'
            );
        } else {
            $results = array(
                'error' => '1',
                'message' => 'Failed to activate the show number.'
            );
        }
        echo json_encode($results);
    }

    public function inactivate_shownumber()
    {
        $id = $this->input->post('id');
        $inactive = $this->Catchup_schedule_model->inactivate_shownumber($id);
        if ($inactive == true) {
            $results = array(
                'error' => '0',
                'message' => 'The show number has been successfully deactivated.'
            );
        } else {
            $results = array(
                'error' => '1',
                'message' => 'Failed to deactivate the show number.'
            );
        }
        echo json_encode($results);
    }

    public function activate_keyword()
    {
        $id = $this->input->post('id');
        $inactive = $this->Catchup_schedule_model->activate_keyword($id);
        if ($inactive == true) {
            $results = array(
                'error' => '0',
                'message' => 'The category has been successfully activated.'
            );
        } else {
            $results = array(
                'error' => '1',
                'message' => 'Failed to activate the category.'
            );
        }
        echo json_encode($results);
    }

    public function inactivate_keyword()
    {
        $id = $this->input->post('id');
        $inactive = $this->Catchup_schedule_model->inactivate_keyword($id);
        if ($inactive == true) {
            $results = array(
                'error' => '0',
                'message' => 'The category has been successfully deactivated.'
            );
        } else {
            $results = array(
                'error' => '1',
                'message' => 'Failed to deactivate the category.'
            );
        }
        echo json_encode($results);
    }

    public function cu_keyword()
    {
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');

        $titleCategory = $this->input->post('titleCategory');
        $category_tvshow_id = $this->input->post('category_tvshow_id');
        
        if ($category_tvshow_id == null || $category_tvshow_id == "") {
            $cu = $this->Catchup_schedule_model->cu_keyword($category_tvshow_id, $titleCategory, $time, 'create');
        } else {
            $cu = $this->Catchup_schedule_model->cu_keyword($category_tvshow_id, $titleCategory, $time, 'update');
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

    public function get_data_edit_keyword()
    {
        $id = $this->input->post('id',TRUE);
        $code = $this->Catchup_schedule_model->get_data_edit_keyword($id);
        
        if ($code != null) {
            $data = $code;
        } else {
            die("Data not found");
        }

        echo json_encode($data);
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
        $path = 'wp/img/top_tvshowbanner_v1/1280x720/';
        $changeDir = 'wp/img/top_tvshowbanner_v1/1280x720/';
        $listimg = $this->libadapter->getImages($path, $changeDir);
        
        if ($listimg['error'] == 0) {
            $_arrFolder = array();
            $listimg1 = $listimg['content'];
            foreach ($listimg1 as $key => $value) {
                $_arrFolder[] = $value['url'];
            }
            krsort($_arrFolder);
            
            //formed array from database
            $urlimage = $this->Catchup_schedule_model->getImageBannerLandscape();
            
            if ($urlimage != null) {
                foreach ($urlimage as $key => $value) {
                    array_push($_urlimage, self::$baseurlimage . $path . basename($value['banner_image']));
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

    public function compare_image_portrait()
    {
        echo json_encode($this->getImageBannerPortrait());
    }

    private function getImageBannerPortrait()
    {
        $data = array();
        $_arrFolder = array();
        $_urlimage = array();
        
        //formed array from server
        $path = 'wp/img/top_tvshowpotrait_v1/575x1028/';
        $changeDir = 'wp/img/top_tvshowpotrait_v1/575x1028/';
        $listimg = $this->libadapter->getImages($path, $changeDir);
        
        if ($listimg['error'] == 0) {
            $_arrFolder = array();
            $listimg1 = $listimg['content'];
            foreach ($listimg1 as $key => $value) {
                $_arrFolder[] = $value['url'];
            }
            krsort($_arrFolder);
            
            //formed array from database
            $urlimage = $this->Catchup_schedule_model->getImageBannerPortrait();
            
            if ($urlimage != null) {
                foreach ($urlimage as $key => $value) {
                    array_push($_urlimage, self::$baseurlimage . $path . basename($value['banner_image_potrait']));
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

    public function compare_image_popup()
    {
        echo json_encode($this->getImagePopUp());
    }

    private function getImagePopUp()
    {
        $data = array();
        $_arrFolder = array();
        $_urlimage = array();
        
        //formed array from server
        $path = 'wp/img/top_tvshowpopup_v1/1280x720/';
        $changeDir = 'wp/img/top_tvshowpopup_v1/1280x720/';
        $listimg = $this->libadapter->getImages($path, $changeDir);
        
        if ($listimg['error'] == 0) {
            $_arrFolder = array();
            $listimg1 = $listimg['content'];
            foreach ($listimg1 as $key => $value) {
                $_arrFolder[] = $value['url'];
            }
            krsort($_arrFolder);
            
            //formed array from database
            $urlimage = $this->Catchup_schedule_model->getImagePopUp();
            
            if ($urlimage != null) {
                foreach ($urlimage as $key => $value) {
                    array_push($_urlimage, self::$baseurlimage . $path . basename($value['popup_image']));
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
