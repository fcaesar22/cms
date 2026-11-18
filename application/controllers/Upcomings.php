<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upcomings extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user')) {
            redirect('auth');
        }
        if (!has_permission('view_upcomings')) {
            show_error('Anda tidak memiliki akses ke halaman ini', 403, 'Forbidden');
        }
        $this->load->config('secure_config');
        $this->load->library('pagination');
        $this->load->library('libadapter');
        $this->load->model('Upcoming_model');
    }

    private static $baseurlimage = 'https://picture.dens.tv/wp/';

    public function index()
    {
        $data['title'] = 'List Upcoming Trailer';
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('upcomings/index', $data);
        $this->load->view('layouts/footer');
    }

    public function list_upcomings($key_search=null, $sort_by='id_upcoming', $order_sort='desc', $visible='Y', $rowperpage=10, $rowno=0)
    {
        if ($rowno != 0) {
            $rowno = ($rowno-1) * $rowperpage;
        }

        $allcount = $this->Upcoming_model->getCountAll($key_search, $visible);
        $users_record = $this->Upcoming_model->getDatas($key_search, $sort_by, $order_sort, $visible, $rowperpage, $rowno);

        // Pagination Configuration
        $config['base_url'] = base_url().'upcomings/list_upcomings/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$visible.'/'.$rowperpage.'/'.$rowno;
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
            $idUpcoming = $page_id_array[$count];

            $this->Upcoming_model->update_sort($idUpcoming, $sort);
        }

        echo json_encode([
            'error' => '0',
            'message' => 'Sorting updated successfully'
        ]);
    }

    public function activated_upcoming($id)
    {
        if (!isset($id)) show_404();
        
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');
        $active = $this->Upcoming_model->activated_upcoming($id, $time);
        if ($active == true) {
            $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Activated has been successfully!</div>');
            redirect(site_url('upcomings'));
        } else {
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Activated is failed!</div>');
            redirect(site_url('upcomings'));
        }
    }

    public function inactivated_upcoming($id)
    {
        if (!isset($id)) show_404();
        
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');
        $inactivated = $this->Upcoming_model->inactivated_upcoming($id, $time);
        if ($inactivated == true) {
            $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Inactivated has been successfully!</div>');
            redirect(site_url('upcomings'));
        } else {
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Inactivated is failed!</div>');
            redirect(site_url('upcomings'));
        }
    }

    public function getListGenre()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }

        $results = $this->Upcoming_model->getListGenre($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Upcoming_model->getListGenre($perPage, $page, $searchTerm, 'count');
        $data = array();
        
        foreach ($results as $row) {
            $data[] = array(
                "id" => $row['keyword_id'],
                "text" => $row['keyword_name']
            );
        }
        
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function getSingleGenre()
    {
        $id = $this->input->post('id');
        $data = $this->Upcoming_model->getSingleGenre($id);
        echo json_encode([
            'id' => $data->keyword_id,
            'text' => $data->keyword_name
        ]);
    }

    public function getListRated()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        
        $offset = max(0, ($page - 1) * $perPage);

        $results = $this->Upcoming_model->getListRated($perPage, $offset, $searchTerm, 'data');

        $countResults = $this->Upcoming_model->getListRated($perPage, $offset, $searchTerm, 'count');

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

    public function getSingleRated()
    {
        $id = $this->input->post('id');

        $data = $this->Upcoming_model->getSingleRated($id);

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
        $data['title'] = 'Add Upcoming Trailer';
        $this->form_validation->set_rules('title', 'Title', 'required', ['required' => 'Title harus diisi']);
        $this->form_validation->set_rules('description', 'Description', 'required', ['required' => 'Description harus diisi']);
        $this->form_validation->set_rules('genre', 'Genre', 'required', ['required' => 'Genre harus dipilih']);
        $this->form_validation->set_rules('year', 'Year', 'required', ['required' => 'Year harus diisi']);
        $this->form_validation->set_rules('rated', 'Rated', 'required', ['required' => 'Rated harus dipilih']);
        $this->form_validation->set_rules('director', 'Director', 'required', ['required' => 'Director harus diisi']);
        $this->form_validation->set_rules('cast', 'Cast', 'required', ['required' => 'Cast harus diisi']);
        $this->form_validation->set_rules('duration', 'Duration', 'required', ['required' => 'Duration harus diisi']);
        $this->form_validation->set_rules('trailer_url', 'Trailer URL', 'required', ['required' => 'Trailer URL harus dipilih']);
        $this->form_validation->set_rules('banner_image', 'Banner Image', 'required', ['required' => 'Banner Image harus dipilih']);
        $this->form_validation->set_rules('popup_image', 'Banner Pop Up', 'required', ['required' => 'Banner Pop Up harus dipilih']);

        if ($this->form_validation->run() == FALSE) {
            $data['selected_genre'] = set_value('genre');
            $data['selected_rated'] = set_value('rated');
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('upcomings/create', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $upcoming_data = [
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'genre' => $this->input->post('genre'),
                'year' => $this->input->post('year'),
                'duration' => $this->input->post('duration'),
                'rated' => $this->input->post('rated'),
                'director' => $this->input->post('director'),
                'cast' => $this->input->post('cast'),
                'duration' => $this->input->post('duration'),
                'url_trailer' => $this->input->post('trailer_url'),
                'url_trailer_hover' => $this->input->post('trailer_url_hover'),
                'image_potrait' => $this->input->post('banner_image'),
                'image_landscape' => $this->input->post('popup_image'),
                'visible' => 'N',
                'create_date' => $time,
                'update_date' => $time,
                'ctrloc' => '/upcomings/create'
            ];

            $saved = $this->Upcoming_model->insert_upcoming($upcoming_data);

            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Upcoming berhasil disimpan</div>');
                return redirect('upcomings');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Upcoming tidak berhasil disimpan</div>');
                return redirect('upcomings');
            }
        }
    }

    public function edit($id = null)
    {
        $CI =& get_instance();
        if (!$id) show_404();
        $upcoming = $this->Upcoming_model->get_upcoming_by_id($id);
        if (!$upcoming) show_404();
        $data['title'] = 'Edit Upcoming Trailer';
        $data['upcoming'] = $upcoming[0];

        $this->form_validation->set_rules('title', 'Title', 'required', ['required' => 'Title harus diisi']);
        $this->form_validation->set_rules('description', 'Description', 'required', ['required' => 'Description harus diisi']);
        $this->form_validation->set_rules('genre', 'Genre', 'required', ['required' => 'Genre harus dipilih']);
        $this->form_validation->set_rules('year', 'Year', 'required', ['required' => 'Year harus diisi']);
        $this->form_validation->set_rules('rated', 'Rated', 'required', ['required' => 'Rated harus dipilih']);
        $this->form_validation->set_rules('director', 'Director', 'required', ['required' => 'Director harus diisi']);
        $this->form_validation->set_rules('cast', 'Cast', 'required', ['required' => 'Cast harus diisi']);
        $this->form_validation->set_rules('duration', 'Duration', 'required', ['required' => 'Duration harus diisi']);
        $this->form_validation->set_rules('trailer_url', 'Trailer URL', 'required', ['required' => 'Trailer URL harus dipilih']);
        $this->form_validation->set_rules('banner_image', 'Banner Image', 'required', ['required' => 'Banner Image harus dipilih']);
        $this->form_validation->set_rules('popup_image', 'Banner Pop Up', 'required', ['required' => 'Banner Pop Up harus dipilih']);

        if ($this->form_validation->run() == FALSE) {
            $data['selected_genre'] = set_value('genre') ?: $upcoming[0]['genre'];
            $data['selected_rated'] = set_value('rated') ?: $upcoming[0]['rated'];
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('upcomings/edit', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $upcoming_data = [
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'genre' => $this->input->post('genre'),
                'year' => $this->input->post('year'),
                'duration' => $this->input->post('duration'),
                'rated' => $this->input->post('rated'),
                'director' => $this->input->post('director'),
                'cast' => $this->input->post('cast'),
                'duration' => $this->input->post('duration'),
                'url_trailer' => $this->input->post('trailer_url'),
                'url_trailer_hover' => $this->input->post('trailer_url_hover'),
                'image_potrait' => $this->input->post('banner_image'),
                'image_landscape' => $this->input->post('popup_image'),
                'update_date' => $time,
                'ctrloc' => '/upcomings/edit'
            ];

            $saved = $this->Upcoming_model->update_upcoming($id, $upcoming_data);

            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Upcoming berhasil diubah</div>'); 
                return redirect('upcomings');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Upcoming tidak berhasil diubah</div>');
                return redirect('upcomings');
            }
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

    public function compareBannerImage()
    {
        echo json_encode($this->getImageBanner());
    }

    private function getImageBanner()
    {
        $data = array();
        $_arrFolder = array();
        $_urlimage = array();
        
        //formed array from server
        $path = 'wp/img/upcoming_potrait_v1/575x1028//';
        $changeDir = 'wp/img/upcoming_potrait_v1/575x1028//';
        $listimg = $this->libadapter->getImages($path, $changeDir);
        
        if ($listimg['error'] == 0) {
            $_arrFolder = array();
            $listimg1 = $listimg['content'];
            foreach ($listimg1 as $key => $value) {
                $_arrFolder[] = $value['url'];
            }
            krsort($_arrFolder);
            
            //formed array from database
            $urlimage = $this->Upcoming_model->getImageBanner();
            
            if ($urlimage != null) {
                foreach ($urlimage as $key => $value) {
                    array_push($_urlimage, self::$baseurlimage . $path . basename($value['image_potrait']));
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

    public function comparePopUpImage()
    {
        echo json_encode($this->getImagePopUp());
    }

    private function getImagePopUp()
    {
        $data = array();
        $_arrFolder = array();
        $_urlimage = array();
        
        //formed array from server
        $path = 'wp/img/upcoming_landscape_v1/1280x720/';
        $changeDir = 'wp/img/upcoming_landscape_v1/1280x720/';
        $listimg = $this->libadapter->getImages($path, $changeDir);
        
        if ($listimg['error'] == 0) {
            $_arrFolder = array();
            $listimg1 = $listimg['content'];
            foreach ($listimg1 as $key => $value) {
                $_arrFolder[] = $value['url'];
            }
            krsort($_arrFolder);
            
            //formed array from database
            $urlimage = $this->Upcoming_model->getImagePopUp();
            
            if ($urlimage != null) {
                foreach ($urlimage as $key => $value) {
                    array_push($_urlimage, self::$baseurlimage . $path . basename($value['image_landscape']));
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
