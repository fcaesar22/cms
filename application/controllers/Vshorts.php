<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vshorts extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user')) {
            redirect('auth');
        }
        if (!has_permission('view_vshorts')) {
            show_error('Anda tidak memiliki akses ke halaman ini', 403, 'Forbidden');
        }
        $this->load->config('secure_config');
        $this->load->library('pagination');
        $this->load->library('libadapter');
        $this->load->model('Vshort_model');
    }

    private static $baseurlimage = 'https://picture.dens.tv/';

    public function index()
    {
        $data['title'] = 'List Vshort';
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('vshorts/index', $data);
        $this->load->view('layouts/footer');
    }

    public function list_vshort($key_search=null, $sort_by='covers_id', $order_sort='desc', $visible='Y', $rowperpage=10, $rowno=0)
    {
        if ($rowno != 0) {
            $rowno = ($rowno-1) * $rowperpage;
        }
        $allcount = $this->Vshort_model->getCountAll($key_search, $visible);
        $users_record = $this->Vshort_model->getDatas($key_search, $sort_by, $order_sort, $visible, $rowperpage, $rowno);
        // Pagination Configuration
        $config['base_url'] = base_url().'vshorts/list_vshort/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$visible.'/'.$rowperpage.'/'.$rowno;
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

    public function activated($id)
    {
        if (!isset($id)) show_404();
        
        if ($this->Vshort_model->activated($id)) {
            redirect(site_url('vshorts'));
        }
    }

    public function inactivated($id)
    {
        if (!isset($id)) show_404();
        
        if ($this->Vshort_model->inactivated($id)) {
            redirect(site_url('vshorts'));
        }
    }

    public function activated_highlight_vshort($id)
    {
        if (!isset($id)) {
            show_404();
        } else {
            $activate = $this->Vshort_model->activated_highlight_vshort($id);
            if ($activate['error']==false) {
                $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>tidak bisa activate highlight karna sudah lebih dari 15</div>');
            } else {
                $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil activate highlight</div>');
            }
            redirect(site_url('vshorts'));
        }
    }

    public function inactivated_highlight_vshort($id)
    {
        if (!isset($id)) show_404();
        
        if ($this->Vshort_model->inactivated_highlight_vshort($id)) {
            redirect(site_url('vshorts'));
        }
    }

    public function get_tags()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }
        $results = $this->Vshort_model->get_tags($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Vshort_model->get_tags($perPage, $page, $searchTerm, 'count');
        $data = array();
        foreach ($results as $row) {
            $data[] = array(
                "id"=>$row['keyword_id'],
                "text"=>$row['keyword_name']
            );
        }
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function get_multiple_tags()
    {
        $ids = $this->input->post('ids');
        if (!is_array($ids)) {
            $ids = [$ids];
        }
        $genres = [];
        foreach ($ids as $id) {
            $group = $this->Vshort_model->get_tags_by_id($id);
            if ($group) {
                $genres[] = [
                    'id' => $group->keyword_id,
                    'text' => $group->keyword_name
                ];
            }
        }
        echo json_encode($genres);
    }

    public function create()
    {
        $CI =& get_instance();
        $data['title'] = 'Add Vshorts';
        $this->form_validation->set_rules('title', 'Title', 'required', ['required' => 'Title harus diisi']);
        $this->form_validation->set_rules('description', 'Description', 'required', ['required' => 'Description harus diisi']);
        $this->form_validation->set_rules('video_url', 'Video URL', 'required', ['required' => 'Video URL harus diisi']);
        $this->form_validation->set_rules('tags[]', 'Tag', 'required', ['required' => 'Tag harus dipilih']);
        $this->form_validation->set_rules('type', 'Type', 'required', ['required' => 'Type harus dipilih']);
        $this->form_validation->set_rules('content_id', 'Content ID', 'required', ['required' => 'Content ID harus diisi']);
        $this->form_validation->set_rules('location', 'Location', 'required', ['required' => 'Location harus diisi']);
        $this->form_validation->set_rules('unlimited_list', 'Unlimited List', 'required', ['required' => 'Unlimited List harus dipilih']);
        if ($this->form_validation->run() == FALSE) {
            $data['selected_tag'] = $this->input->post('tags');
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('vshorts/create', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $vshort_data = [
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'thumbnail_url' => $this->input->post('thumbnail_url'),
                'video_url' => $this->input->post('video_url'),
                'content_type' => $this->input->post('type'),
                'content_id' => $this->input->post('content_id'),
                'target' => $this->input->post('target'),
                'location' => $this->input->post('location'),
                'unlimited_list' => $this->input->post('unlimited_list'),
                'tags' => ',' . implode(',', $this->input->post('tags',TRUE)) . ',',
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date'),
                'create_date' => $time,
                'update_date' => $time,
                'ctrloc' => '/vshorts/create'
            ];
            $saved = $this->Vshort_model->insert_vshort($vshort_data);
            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Vshorts berhasil disimpan</div>'); 
                return redirect('vshorts');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Vshorts tidak berhasil disimpan</div>');
                return redirect('vshorts');
            }
        }
    }

    public function edit($id = null) {
        $CI =& get_instance();
        if (!$id) show_404();
        $vshort = $this->Vshort_model->get_vshort_by_id($id);
        if (!$vshort) show_404();
        $data['title'] = 'Edit Vshorts';
        $data['vshort'] = $vshort;
        $this->form_validation->set_rules('title', 'Title', 'required', ['required' => 'Title harus diisi']);
        $this->form_validation->set_rules('description', 'Description', 'required', ['required' => 'Description harus diisi']);
        $this->form_validation->set_rules('video_url', 'Video URL', 'required', ['required' => 'Video URL harus diisi']);
        $this->form_validation->set_rules('tags[]', 'Tag', 'required', ['required' => 'Tag harus dipilih']);
        $this->form_validation->set_rules('type', 'Type', 'required', ['required' => 'Type harus dipilih']);
        $this->form_validation->set_rules('content_id', 'Content ID', 'required', ['required' => 'Content ID harus diisi']);
        $this->form_validation->set_rules('location', 'Location', 'required', ['required' => 'Location harus diisi']);
        $this->form_validation->set_rules('unlimited_list', 'Unlimited List', 'required', ['required' => 'Unlimited List harus dipilih']);
        if ($this->form_validation->run() == FALSE) {
            $data['selected_tag'] = $this->input->post('tags') ?: array_column($vshort['tags'], 'keyword_id');
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('vshorts/edit', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $vshort_data = [
                'id' => $id,
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'thumbnail_url' => $this->input->post('thumbnail_url'),
                'video_url' => $this->input->post('video_url'),
                'content_type' => $this->input->post('type'),
                'content_id' => $this->input->post('content_id'),
                'target' => $this->input->post('target'),
                'location' => $this->input->post('location'),
                'unlimited_list' => $this->input->post('unlimited_list'),
                'tags' => ',' . implode(',', $this->input->post('tags',TRUE)) . ',',
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date'),
                'update_date' => $time,
                'ctrloc' => '/vshorts/edit'
            ];
            $saved = $this->Vshort_model->update_vshort($vshort_data);
            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Vshort berhasil diubah</div>'); 
                return redirect('vshorts');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Vshort tidak berhasil diubah</div>');
                return redirect('vshorts');
            }
        }
    }

    public function save_tags()
    {
        $name_tag = $this->input->post('jtag',TRUE);
        $sort_tag = $this->input->post('jsort',TRUE);
        $child_tag = $this->input->post('jchild',TRUE);
        $sub_tag = $this->input->post('jsub',TRUE);
        $ref_tag = $this->input->post('jref',TRUE);
        $visible_tag = $this->input->post('jvis',TRUE);
        $par_tag = $this->input->post('jpar',TRUE);
        if ($name_tag != null) {
            $result = $this->Vshort_model->save_tags($name_tag, $sort_tag, $child_tag, $sub_tag, $ref_tag, $visible_tag, $par_tag);
            echo json_encode(array("status" => TRUE));
        } else {
            alert('data gagal disimpan');
        }
    }

    public function get_token()
    {
        $toURL = $this->config->item('url_token_uploader');
        $post = array();
        $exe = $this->libadapter->execurl($toURL, $post);
        $_token = json_decode($exe['data'],true);
        echo $_token['token'];
    }

    public function compare_image_portrait()
    {
        echo json_encode($this->get_image_portrait());
    }

    private function get_image_portrait()
    {
        $data = array();
        $_arrFolder = array();
        $_urlimage = array();
        //formed array from server
        $path = 'wp/img/reels_v1/720x1280/';
        $changeDir = 'wp/img/reels_v1/720x1280/';
        $listimg = $this->libadapter->getImages($path, $changeDir);
        if ($listimg['error'] == 0) {
            $_arrFolder = array();
            $listimg1 = $listimg['content'];
            foreach ($listimg1 as $key => $value) {
                $_arrFolder[] = $value['url'];
            }
            krsort($_arrFolder);
            //formed array from database
            $urlimage = $this->Vshort_model->getimagepotrait();
            if ($urlimage!=null) {
                foreach ($urlimage as $key => $value) {
                    array_push($_urlimage, self::$baseurlimage . $path . basename($value['thumbnail_url']));
                }
            }
            $datas=array_values(array_diff($_arrFolder,$_urlimage));
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
