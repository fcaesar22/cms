<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Popups extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user')) {
            redirect('auth');
        }
        if (!has_permission('view_popups')) {
            show_error('Anda tidak memiliki akses ke halaman ini', 403, 'Forbidden');
        }
        $this->load->config('secure_config');
        $this->load->library('pagination');
        $this->load->library('libadapter');
        $this->load->model('Popup_model');
    }

    private static $baseurlimage = 'https://picture.dens.tv/wp/';

    public function index()
    {
        $data['title'] = 'List Pop Up, Logo & Splashscreen';
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('popups/index', $data);
        $this->load->view('layouts/footer');
    }

    public function list_popups($key_search=null, $sort_by='id', $order_sort='desc', $status='active', $rowperpage=10, $rowno=0)
    {
        if ($rowno != 0) {
            $rowno = ($rowno-1) * $rowperpage;
        }

        $key_search = urldecode($key_search);

        $allcount = $this->Popup_model->getCountAll($key_search, $status);
        $users_record = $this->Popup_model->getDatas($key_search, $sort_by, $order_sort, $status, $rowperpage, $rowno);

        // Pagination Configuration
        $config['base_url'] = base_url().'popups/list_popups/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$status.'/'.$rowperpage.'/'.$rowno;
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

    public function inactivatedPopups($id)
    {
        if (!isset($id)) show_404();
        
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');
        $inactivated = $this->Popup_model->inactivatedPopups($id, $time);
        if ($inactivated == true) {
            $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Inactivated has been successfully!</div>');
            redirect(site_url('popups'));
        } else {
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Inactivated is failed!</div>');
            redirect(site_url('popups'));
        }
    }

    public function getListLocation()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }

        $results = $this->Popup_model->getListLocation($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Popup_model->getListLocation($perPage, $page, $searchTerm, 'count');
        $data = array();
        
        foreach ($results as $row) {
            $data[] = array(
                "id" => $row['id'],
                "text" => $row['location_name']
            );
        }
        
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function getSingleLocation()
    {
        $id = $this->input->post('id');
        $data = $this->Popup_model->getSingleLocation($id);
        echo json_encode([
            'id' => $data->id,
            'text' => $data->location_name
        ]);
    }

    public function getListDevice()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        
        $offset = max(0, ($page - 1) * $perPage);

        $results = $this->Popup_model->getListDevice($perPage, $offset, $searchTerm, 'data');

        $countResults = $this->Popup_model->getListDevice($perPage, $offset, $searchTerm, 'count');

        $data = array();

        foreach ($results as $row) {
            $data[] = array(
                'id' => $row['id'],
                'text' => $row['title']
            );
        }

        $select = array(
            'total_count' => $countResults,
            'items' => $data
        );

        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function getSingleDevice()
    {
        $id = $this->input->post('id');

        $data = $this->Popup_model->getSingleDevice($id);

        if ($data === null) {
            $this->output
                ->set_status_header(404)
                ->set_content_type('application/json')
                ->set_output(json_encode(array(
                    'id' => null,
                    'text' => ''
                )));
            return;
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                'id' => $data->id,
                'text' => $data->title
            )));
    }

    public function getListCategory()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        
        $offset = max(0, ($page - 1) * $perPage);

        $results = $this->Popup_model->getListCategory($perPage, $offset, $searchTerm, 'data');

        $countResults = $this->Popup_model->getListCategory($perPage, $offset, $searchTerm, 'count');

        $data = array();

        foreach ($results as $row) {
            $data[] = array(
                'id' => $row['id'],
                'text' => $row['title']
            );
        }

        $select = array(
            'total_count' => $countResults,
            'items' => $data
        );

        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function getSingleCategory()
    {
        $id = $this->input->post('id');

        $data = $this->Popup_model->getSingleCategory($id);

        if ($data === null) {
            $this->output
                ->set_status_header(404)
                ->set_content_type('application/json')
                ->set_output(json_encode(array(
                    'id' => null,
                    'text' => ''
                )));
            return;
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                'id' => $data->id,
                'text' => $data->title
            )));
    }

    public function create()
    {
        $CI =& get_instance();
        $data['title'] = 'Add Pop Up, Logo & Splashscreen';
        
        $this->form_validation->set_rules('location_id', 'Location', 'required', ['required' => 'Location harus dipilih']);
        $this->form_validation->set_rules('device', 'Device', 'required', ['required' => 'Device harus dipilih']);
        $this->form_validation->set_rules('content_url', 'Content URL', 'required', ['required' => 'Content URL harus diisi']);
        $this->form_validation->set_rules('category', 'Category', 'required', ['required' => 'Category harus dipilih']);

        if ($this->form_validation->run() == FALSE) {
            $data['selected_location'] = set_value('location_id');
            $data['selected_device'] = set_value('device');
            $data['selected_category'] = $this->input->post('category');
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('popups/create', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $popup_data = [
                'img_url' => $this->input->post('content_url'),
                'link' => $this->input->post('link'),
                'location_id' => $this->input->post('location_id'),
                'status' => 'active',
                'device' => $this->input->post('device'),
                'category' => $this->input->post('category'),
                'content_id' => $this->input->post('content_id'),
                'created_at' => $time,
                'updated_at' => $time,
                'created_by' => $this->session->userdata('user')->username,
                'updated_by' => $this->session->userdata('user')->username,
                'ctrloc' => '/popups/create'
            ];

            $saved = $this->Popup_model->insertPopup($popup_data);

            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Data berhasil disimpan</div>');
                return redirect('popups');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Data tidak berhasil disimpan</div>');
                return redirect('popups');
            }
        }
    }

    public function edit($id = null)
    {
        $CI =& get_instance();
        if (!$id) show_404();
        $popups = $this->Popup_model->getPopupById($id);
        if (!$popups) show_404();
        $data['title'] = 'Edit Pop Up, Logo & Splashscreen';
        $data['popups'] = $popups[0];

        $this->form_validation->set_rules('location_id', 'Location', 'required', ['required' => 'Location harus dipilih']);
        $this->form_validation->set_rules('device', 'Device', 'required', ['required' => 'Device harus dipilih']);
        $this->form_validation->set_rules('content_url', 'Content URL', 'required', ['required' => 'Content URL harus diisi']);
        $this->form_validation->set_rules('category', 'Category', 'required', ['required' => 'Category harus dipilih']);

        if ($this->form_validation->run() == FALSE) {
            $data['selected_location'] = set_value('location_id') ?: $popups[0]['location_id'];
            $data['selected_device'] = set_value('device') ?: $popups[0]['device'];
            $data['selected_category'] = $this->input->post('category') ?: $popups[0]['category'];
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('popups/edit', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $popup_data = [
                'img_url' => $this->input->post('content_url'),
                'link' => $this->input->post('link'),
                'location_id' => $this->input->post('location_id'),
                'status' => 'active',
                'device' => $this->input->post('device'),
                'category' => $this->input->post('category'),
                'content_id' => $this->input->post('content_id'),
                'updated_at' => $time,
                'updated_by' => $this->session->userdata('user')->username,
                'ctrloc' => '/popups/edit'
            ];

            $saved = $this->Popup_model->updatePopup($id, $popup_data);

            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Data berhasil diubah</div>'); 
                return redirect('popups');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Data tidak berhasil diubah</div>');
                return redirect('popups');
            }
        }
    }
}
