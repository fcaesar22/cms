<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Highlights extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user')) {
            redirect('auth');
        }
        if (!has_permission('view_highlights')) {
            show_error('Anda tidak memiliki akses ke halaman ini', 403, 'Forbidden');
        }
        $this->load->config('secure_config');
        $this->load->library('pagination');
        $this->load->library('libadapter');
        $this->load->model('Highlight_model');
    }

    private static $baseurlimage = 'https://picture.dens.tv/';

    public function index()
    {
        $data['title'] = 'List Highlight';
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('highlights/index', $data);
        $this->load->view('layouts/footer');
    }

    public function get_list_content()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }
        $results = $this->Highlight_model->get_list_content($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Highlight_model->get_list_content($perPage, $page, $searchTerm, 'count');
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

    public function list_highlight($key_search=null, $sort_by='covers_id', $order_sort='desc', $category, $rowperpage=10, $rowno=0)
    {
        if ($rowno != 0) {
            $rowno = ($rowno-1) * $rowperpage;
        }
        $allcount = $this->Highlight_model->getCountAll($key_search, $category);
        $users_record = $this->Highlight_model->getDatas($key_search, $sort_by, $order_sort, $category, $rowperpage, $rowno);
        // Pagination Configuration
        $config['base_url'] = base_url().'highlights/list_highlight/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$category.'/'.$rowperpage.'/'.$rowno;
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

    public function get_list_category()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }
        $results = $this->Highlight_model->get_list_category($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Highlight_model->get_list_category($perPage, $page, $searchTerm, 'count');
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

    public function get_single_category()
    {
        $id = $this->input->post('id');
        $data = $this->Highlight_model->get_category_by_id($id);
        echo json_encode([
            'id' => $data['id'],
            'text' => $data['title']
        ]);
    }

    public function get_list_type()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $category_id = $this->input->post('category_id');
        $perPage = 10;
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }
        $results = $this->Highlight_model->get_list_type($perPage, $page, $searchTerm, $category_id, 'data');
        $countResults = $this->Highlight_model->get_list_type($perPage, $page, $searchTerm, $category_id, 'count');
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

    public function get_single_type()
    {
        $id = $this->input->post('id');
        $data = $this->Highlight_model->get_type_by_id($id);
        echo json_encode([
            'id' => $data['id'],
            'text' => $data['title']
        ]);
    }

    public function get_list_content_article()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $category_id = $this->input->post('category_id');
        $type_id = $this->input->post('type_id');
        $perPage = 10;
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }
        $results = $this->Highlight_model->get_list_content_article($perPage, $page, $searchTerm, $category_id, $type_id, 'data');
        $countResults = $this->Highlight_model->get_list_content_article($perPage, $page, $searchTerm, $category_id, $type_id, 'count');
        $data = array();
        foreach ($results as $row) {
            $data[] = array(
                "id"=>$row['article_id'],
                "text"=>$row['article_title'],
                $row
            );
        }
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function get_list_content_tvchannel()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $category_id = $this->input->post('category_id');
        $type_id = $this->input->post('type_id');
        $perPage = 10;
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }
        $results = $this->Highlight_model->get_list_content_tvchannel($perPage, $page, $searchTerm, $category_id, $type_id, 'data');
        $countResults = $this->Highlight_model->get_list_content_tvchannel($perPage, $page, $searchTerm, $category_id, $type_id, 'count');
        $data = array();
        foreach ($results as $row) {
            $data[] = array(
                "id"=>$row['seq'],
                "text"=>$row['title'],
                $row
            );
        }
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function get_list_content_movie()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $category_id = $this->input->post('category_id');
        $type_id = $this->input->post('type_id');
        $perPage = 10;
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }
        $results = $this->Highlight_model->get_list_content_movie($perPage, $page, $searchTerm, $category_id, $type_id, 'data');
        $countResults = $this->Highlight_model->get_list_content_movie($perPage, $page, $searchTerm, $category_id, $type_id, 'count');
        $data = array();
        foreach ($results as $row) {
            $data[] = array(
                "id"=>$row['movie_code'],
                "text"=>$row['movie_title'],
                $row
            );
        }
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function get_list_content_webinar()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $category_id = $this->input->post('category_id');
        $type_id = $this->input->post('type_id');
        $perPage = 10;
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }
        $results = $this->Highlight_model->get_list_content_webinar($perPage, $page, $searchTerm, $category_id, $type_id, 'data');
        $countResults = $this->Highlight_model->get_list_content_webinar($perPage, $page, $searchTerm, $category_id, $type_id, 'count');
        $data = array();
        foreach ($results as $row) {
            $data[] = array(
                "id"=>$row['webinar_id'],
                "text"=>$row['topic'],
                $row
            );
        }
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function get_single_content()
    {
        $id = $this->input->post('id');
        $category = $this->input->post('category');
        $type = $this->input->post('type');
        $data = $this->Highlight_model->get_content_by_id($id, $category, $type);
        echo json_encode($data);
    }

    public function create()
    {
        $CI =& get_instance();
        $data['title'] = 'Add Highlight';
        $this->form_validation->set_rules('category_highlight', 'Category', 'required', ['required' => 'Category harus dipilih']);
        $this->form_validation->set_rules('type_highlight', 'Type', 'required', ['required' => 'Type harus dipilih']);
        $this->form_validation->set_rules('content_highlight', 'Content', 'required', ['required' => 'Content harus dipilih']);
        $this->form_validation->set_rules('startdate_highlight', 'Start Date', 'required', ['required' => 'Start Date harus dipilih']);
        $this->form_validation->set_rules('enddate_highlight', 'End Date', 'required', ['required' => 'End Date harus dipilih']);
        $this->form_validation->set_rules('banner_highlight', 'Poster Landscape', 'required', ['required' => 'Poster Landscape harus diisi']);
        $this->form_validation->set_rules('id_content', 'ID Content', 'required', ['required' => 'ID Content harus diisi']);
        $this->form_validation->set_rules('title_content', 'Title Content', 'required', ['required' => 'Title Content harus diisi']);
        $this->form_validation->set_rules('poster_content1', 'Poster', 'required', ['required' => 'Poster harus diisi']);
        $this->form_validation->set_rules('poster_content2', 'Poster', 'required', ['required' => 'Poster harus diisi']);
        $this->form_validation->set_rules('poster_content3', 'Poster', 'required', ['required' => 'Poster harus diisi']);
        if ($this->form_validation->run() == FALSE) {
            $data['selected_category'] = set_value('category_highlight');
            $data['selected_type'] = set_value('type_highlight');
            $data['selected_content'] = set_value('content_highlight');
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('highlights/create', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $category_highlight = $this->input->post('category_highlight',TRUE);
            $type_highlight = $this->input->post('type_highlight',TRUE);
            $id_content = $this->input->post('id_content',TRUE);
            $title_content = $this->input->post('title_content',TRUE);
            $poster_content1 = $this->input->post('poster_content1',TRUE);
            $poster_content2 = $this->input->post('poster_content2',TRUE);
            $poster_content3 = $this->input->post('poster_content3',TRUE);
            $startdate_highlight = $this->input->post('startdate_highlight',TRUE);
            $enddate_highlight = $this->input->post('enddate_highlight',TRUE);
            $subtitle = $this->input->post('subtitle',TRUE);
            $url_image_portrait = $this->input->post('url_image_portrait',TRUE);
            $saved = $this->Highlight_model->insert_highlight($category_highlight, $type_highlight, $id_content, $title_content, $poster_content1, $poster_content2, $poster_content3, $startdate_highlight, $enddate_highlight, $subtitle, $url_image_portrait, $time);
            if ($saved == true) {
                $this->Highlight_model->set_highlight($saved);
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Highlight berhasil disimpan</div>'); 
                return redirect('highlights');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Highlight tidak berhasil disimpan</div>');
                return redirect('highlights');
            }
        }
    }

    public function edit($id = null) {
        $CI =& get_instance();
        if (!$id) show_404();
        $highlight = $this->Highlight_model->get_highlight_by_id($id);
        if (!$highlight) show_404();
        $data['title'] = 'Edit Highlight';
        $data['highlight'] = $highlight;
        $this->form_validation->set_rules('category_highlight', 'Category', 'required', ['required' => 'Category harus dipilih']);
        $this->form_validation->set_rules('type_highlight', 'Type', 'required', ['required' => 'Type harus dipilih']);
        $this->form_validation->set_rules('content_highlight', 'Content', 'required', ['required' => 'Content harus dipilih']);
        $this->form_validation->set_rules('startdate_highlight', 'Start Date', 'required', ['required' => 'Start Date harus dipilih']);
        $this->form_validation->set_rules('enddate_highlight', 'End Date', 'required', ['required' => 'End Date harus dipilih']);
        $this->form_validation->set_rules('banner_highlight', 'Poster Landscape', 'required', ['required' => 'Poster Landscape harus diisi']);
        $this->form_validation->set_rules('id_content', 'ID Content', 'required', ['required' => 'ID Content harus diisi']);
        $this->form_validation->set_rules('title_content', 'Title Content', 'required', ['required' => 'Title Content harus diisi']);
        $this->form_validation->set_rules('poster_content1', 'Poster', 'required', ['required' => 'Poster harus diisi']);
        $this->form_validation->set_rules('poster_content2', 'Poster', 'required', ['required' => 'Poster harus diisi']);
        $this->form_validation->set_rules('poster_content3', 'Poster', 'required', ['required' => 'Poster harus diisi']);
        $this->form_validation->set_rules('poster_id1', 'Poster', 'required', ['required' => 'Poster harus diisi']);
        $this->form_validation->set_rules('poster_id2', 'Poster', 'required', ['required' => 'Poster harus diisi']);
        $this->form_validation->set_rules('poster_id3', 'Poster', 'required', ['required' => 'Poster harus diisi']);
        if ($this->form_validation->run() == FALSE) {
            $data['selected_category'] = set_value('category_highlight') ?: $highlight['category_covers'];
            $data['selected_type'] = set_value('type_highlight') ?: $highlight['type_goto'];
            $data['selected_content'] = set_value('content_highlight') ?: $highlight['id_goto'];
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('highlights/edit', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $category_highlight = $this->input->post('category_highlight',TRUE);
            $type_highlight = $this->input->post('type_highlight',TRUE);
            $id_content = $this->input->post('id_content',TRUE);
            $title_content = $this->input->post('title_content',TRUE);
            $poster_content1 = $this->input->post('poster_content1',TRUE);
            $poster_content2 = $this->input->post('poster_content2',TRUE);
            $poster_content3 = $this->input->post('poster_content3',TRUE);
            $poster_id1 = $this->input->post('poster_id1',TRUE);
            $poster_id2 = $this->input->post('poster_id2',TRUE);
            $poster_id3 = $this->input->post('poster_id3',TRUE);
            $startdate_highlight = $this->input->post('startdate_highlight',TRUE);
            $enddate_highlight = $this->input->post('enddate_highlight',TRUE);
            $subtitle = $this->input->post('subtitle',TRUE);
            $url_image_portrait = $this->input->post('url_image_portrait',TRUE);
            $saved = $this->Highlight_model->update_highlight($id, $category_highlight, $type_highlight, $id_content, $title_content, $poster_id1, $poster_content1, $poster_id2, $poster_content2, $poster_id3, $poster_content3, $startdate_highlight, $enddate_highlight, $subtitle, $url_image_portrait, $time);
            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Highlight berhasil diubah</div>'); 
                return redirect('highlights');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Highlight tidak berhasil diubah</div>');
                return redirect('highlights');
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

    public function compare_image_landscape()
    {
        echo json_encode($this->get_image_landscape());
    }

    private function get_image_landscape()
    {
        $data = array();
        $_arrFolder = array();
        $_urlimage = array();
        //formed array from server
        $path = 'wp/img/highlight_v1/1280x720/';
        $changeDir = 'wp/img/highlight_v1/1280x720/';
        $listimg = $this->libadapter->getImages($path, $changeDir);
        if ($listimg['error'] == 0) {
            $_arrFolder = array();
            $listimg1 = $listimg['content'];
            foreach ($listimg1 as $key => $value) {
                $_arrFolder[] = $value['url'];
            }
            krsort($_arrFolder);
            //formed array from database
            $urlimage = $this->Highlight_model->getimagelandscape();
            if ($urlimage!=null) {
                foreach ($urlimage as $key => $value) {
                    array_push($_urlimage, self::$baseurlimage . $path . basename($value['poster_url']));
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
        $path = 'wp/img/highlight_v1/549x825/';
        $changeDir = 'wp/img/highlight_v1/549x825/';
        $listimg = $this->libadapter->getImages($path, $changeDir);
        if ($listimg['error'] == 0) {
            $_arrFolder = array();
            $listimg1 = $listimg['content'];
            foreach ($listimg1 as $key => $value) {
                $_arrFolder[] = $value['url'];
            }
            krsort($_arrFolder);
            //formed array from database
            $urlimage = $this->Highlight_model->getimagepotrait();
            if ($urlimage!=null) {
                foreach ($urlimage as $key => $value) {
                    array_push($_urlimage, self::$baseurlimage . $path . basename($value['url_image_potrait']));
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
