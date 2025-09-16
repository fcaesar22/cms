<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catchup_selections extends CI_Controller {
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
        $this->load->model('Catchup_selection_model');
    }

    private static $baseurlimage = 'https://picture.dens.tv/wp/';

    public function index()
    {
        $data['title'] = 'List Catch Up Selection';
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('catchup_selections/index', $data);
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
        $results = $this->Catchup_selection_model->category_catchup($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Catchup_selection_model->category_catchup($perPage, $page, $searchTerm, 'count');
        $data = array();
        foreach ($results as $row) {
            $data[] = array(
                "id"=>$row['id'],
                "text"=>$row['title']
            );
        }
        if (empty($page) || $page==1) {
            $hc = array(
                array(
                    "id" => -1,
                    "text" => 'All'
                )
            );
            $data = array_merge($hc,$data);
        }
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function list_catchup_selection($key_search=null, $sort_by='seq', $order_sort='desc', $visible='Y', $category, $rowperpage=10, $rowno=0)
    {
        if ($rowno != 0) {
            $rowno = ($rowno-1) * $rowperpage;
        }
        $allcount = $this->Catchup_selection_model->getCountAll($key_search, $visible, $category);
        $users_record = $this->Catchup_selection_model->getDatas($key_search, $sort_by, $order_sort, $visible, $category, $rowperpage, $rowno);
        // Pagination Configuration
        $config['base_url'] = base_url().'catchup_selections/list_catchup_selection/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$visible.'/'.$category.'/'.$rowperpage.'/'.$rowno;
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
        if (isset($_POST["action"])) {
            if ($_POST['action'] == 'update') {
                // $id_cat = $_POST['id_cat'];
                $page_id_array = $this->input->post('page_id_array');
                for ($count = 0;  $count < count($page_id_array); $count++) {
                    $query = "
                    UPDATE catchup 
                    SET sort = '".($count+1)."' 
                    WHERE id = '".$page_id_array[$count]."' AND visible ='Y'
                    ";
                    $data = $this->Catchup_selection_model->update_sort($query);
                }
            }
        }
    }

    public function activated_catchup($id)
    {
        if (!isset($id)) show_404();
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');
        $active = $this->Catchup_selection_model->activated_catchup($id, $time);
        if ($active == true) {
            $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Activated has been successfully!</div>');
            redirect(site_url('catchup_selections'));
        } else {
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Activated is failed!</div>');
            redirect(site_url('catchup_selections'));
        }
    }

    public function inactivated_catchup($id)
    {
        if (!isset($id)) show_404();
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');
        $inactivated = $this->Catchup_selection_model->inactivated_catchup($id, $time);
        if ($inactivated == true) {
            $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Inactivated has been successfully!</div>');
            redirect(site_url('catchup_selections'));
        } else {
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Inactivated is failed!</div>');
            redirect(site_url('catchup_selections'));
        }
    }

    public function get_list_channel()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }
        $results = $this->Catchup_selection_model->get_list_channel($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Catchup_selection_model->get_list_channel($perPage, $page, $searchTerm, 'count');
        $data = array();
        foreach ($results as $row) {
            $data[] = array(
                "id"=>$row['seq'],
                "text"=>$row['title']
            );
        }
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function get_single_channel()
    {
        $id = $this->input->post('id');
        $data = $this->Catchup_selection_model->get_channel_by_id($id);
        echo json_encode([
            'id' => $data->id,
            'text' => $data->title
        ]);
    }

    public function get_list_category()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }
        $results = $this->Catchup_selection_model->get_list_category($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Catchup_selection_model->get_list_category($perPage, $page, $searchTerm, 'count');
        $data = array();
        foreach ($results as $row) {
            $data[] = array(
                "id"=>$row['id'],
                "text"=>$row['title']
            );
        }
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function get_single_category()
    {
        $id = $this->input->post('id');
        $data = $this->Catchup_selection_model->get_category_by_id($id);
        echo json_encode([
            'id' => $data->id,
            'text' => $data->title
        ]);
    }

    public function get_list_genre()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }
        $results = $this->Catchup_selection_model->get_list_genre($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Catchup_selection_model->get_list_genre($perPage, $page, $searchTerm, 'count');
        $data = array();
        foreach ($results as $row) {
            $data[] = array(
                "id"=>$row['id'],
                "text"=>$row['name']
            );
        }
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function get_multiple_genres()
    {
        $ids = $this->input->post('ids');
        if (!is_array($ids)) {
            $ids = [$ids];
        }
        $genres = [];
        foreach ($ids as $id) {
            $genre = $this->Catchup_selection_model->get_genre_by_id($id);
            if ($genre) {
                $genres[] = [
                    'id' => $genre->id,
                    'text' => $genre->name
                ];
            }
        }
        echo json_encode($genres);
    }

    public function create() {
        $CI =& get_instance();
        $data['title'] = 'Add Catch Up';
        $this->form_validation->set_rules('thumbnail', 'Thumbnail', 'required', ['required' => 'Thumbnail harus dipilih']);
        $this->form_validation->set_rules('banner', 'Banner', 'required', ['required' => 'Banner harus dipilih']);
        $this->form_validation->set_rules('id_channel', 'Channel', 'required', ['required' => 'Channel harus dipilih']);
        $this->form_validation->set_rules('category_catchup', 'Category', 'required', ['required' => 'Category harus dipilih']);
        $this->form_validation->set_rules('title', 'Title', 'required|is_unique[catchup.title]', [
            'required' => 'Title harus diisi',
            'is_unique' => 'Title sudah digunakan'
        ]);
        $this->form_validation->set_rules('description', 'Description', 'required', ['required' => 'Description harus diisi']);
        $this->form_validation->set_rules('genre[]', 'Genre', 'required', ['required' => 'Genre harus dipilih']);
        $this->form_validation->set_rules('year', 'Year', 'required|regex_match[/^[0-9]+$/]', [
            'required' => 'Year harus diisi',
            'regex_match' => 'Year diisi harus dengan angka'
        ]);
        if ($this->form_validation->run() == FALSE) {
            $data['selected_channel'] = set_value('id_channel');
            $data['selected_category'] = set_value('category_catchup');
            $data['selected_genres'] = $this->input->post('genre');
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('catchup_selections/create', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $catchup_data = [
                'id_channel' => $this->input->post('id_channel'),
                'category_catchup' => $this->input->post('category_catchup'),
                'title' => addslashes($this->input->post('title')),
                'year' => $this->input->post('year'),
                'jamtayang' => $this->input->post('jam_tayang'),
                'durasi' => $this->input->post('durasi'),
                'rating' => $this->input->post('rating'),
                'description' => addslashes($this->input->post('description')),
                'cast' => $this->input->post('cast'),
                'thumbnail' => $this->input->post('thumbnail'),
                'banner' => $this->input->post('banner'),
                'visible' => 'N',
                'create_date' => $time,
                'update_date' => $time,
            ];
            $lastID = $this->Catchup_selection_model->insert_catchup($catchup_data);
            if ($lastID > 0) {
                $genre = $this->input->post('genre', TRUE);
                // insert model_tag for catchup
                $this->Catchup_selection_model->insert_genre($lastID, $genre);
                if ($this->input->post('category_catchup') == '1') {
                    $b_rating;
                    $b_jamtayang;
                    $b_year;
                    if ($this->input->post('rating') != "") {
                        $b_rating = " | ";
                    } else {
                        $b_rating = "";
                    }
                    if ($this->input->post('year') != "") {
                        $b_year = " | ";
                    } else {
                        $b_year = "";
                    }
                    if ($this->input->post('jam_tayang') != "") {
                        $b_jamtayang = " | ";
                    } else {
                        $b_jamtayang = "";
                    }
                    $catchup_content_data = array(
                        'id_catchup' => $lastID,
                        'id_channel' => $this->input->post('id_channel'),
                        'category_catchup' => $this->input->post('category_catchup'),
                        'title' => $this->input->post('title'),
                        'subtitle' => $this->input->post('rating').$b_rating.$this->input->post('year').$b_year.$this->input->post('jam_tayang').$b_jamtayang.$this->input->post('durasi'),
                        'description' => $this->input->post('description'),
                        'year' => $this->input->post('year'),
                        'jamtayang' => $this->input->post('jam_tayang'),
                        'durasi' => $this->input->post('durasi'),
                        'rating' => $this->input->post('rating'),
                        'episode' => '0',
                        'label_group' => null,
                        'season' => '0',
                        'thumbnail' => $this->input->post('thumbnail'),
                        'banner' => $this->input->post('banner'),
                        'trailer_url' => '',
                        'visible' => 'N',
                        'coming_soon' => $this->input->post('coming_soon'),
                        'cast' => $this->input->post('cast'),
                        'create_date' => $time,
                        'update_date' => $time,
                        'start_date' => $this->input->post('start_date'),
                        'end_date' => $this->input->post('end_date')
                    );
                    $lastContentID = $this->Catchup_selection_model->insert_catchup_content($catchup_content_data);
                    if ($lastContentID == true) {
                        // insert model_tag for catchup_content
                        $this->Catchup_selection_model->insert_genre_content($lastContentID, $genre);
                        $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Catch Up berhasil disimpan</div>');
                        return redirect('catchup_selections');
                    } else {
                        $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Catch Up tidak berhasil disimpan</div>');
                        return redirect('catchup_selections');
                    }
                } else {
                    $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Catch Up berhasil disimpan</div>');
                    return redirect('catchup_selections/create_catchup_content/'.$lastID);
                }
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Catch Up tidak berhasil disimpan</div>');
                return redirect('catchup_selections');
            }
        }
    }

    public function edit($id = null) {
        $CI =& get_instance();
        if (!$id) show_404();
        $catchup = $this->Catchup_selection_model->get_catchup_by_id($id);
        if (!$catchup) show_404();
        $data['title'] = 'Edit Catch Up';
        $data['catchup'] = $catchup[0];
        $this->form_validation->set_rules('thumbnail', 'Thumbnail', 'required', ['required' => 'Thumbnail harus dipilih']);
        $this->form_validation->set_rules('banner', 'Banner', 'required', ['required' => 'Banner harus dipilih']);
        $this->form_validation->set_rules('id_channel', 'Channel', 'required', ['required' => 'Channel harus dipilih']);
        $this->form_validation->set_rules('category_catchup', 'Category', 'required', ['required' => 'Category harus dipilih']);
        $current_title = $catchup[0]['title'];
        $input_title = $this->input->post('title');
        $title_rule = 'required';
        if (trim(strtolower($input_title)) !== trim(strtolower($current_title))) {
            $title_rule .= '|is_unique[catchup.title]';
        }
        $this->form_validation->set_rules('title', 'Title', $title_rule, [
            'required' => 'Title harus diisi',
            'is_unique' => 'Title sudah digunakan'
        ]);
        $this->form_validation->set_rules('description', 'Description', 'required', ['required' => 'Description harus diisi']);
        $this->form_validation->set_rules('genre[]', 'Genre', 'required', ['required' => 'Genre harus dipilih']);
        $this->form_validation->set_rules('year', 'Year', 'required|regex_match[/^[0-9]+$/]', [
            'required' => 'Year harus diisi',
            'regex_match' => 'Year diisi harus dengan angka'
        ]);
        if ($this->form_validation->run() == FALSE) {
            $data['selected_channel'] = set_value('id_channel') ?: $catchup[0]['id_channel'];
            $data['selected_category'] = set_value('category_catchup') ?: $catchup[0]['category_catchup'];
            $data['selected_genres'] = $this->input->post('genre') ?: array_column($catchup[0]['genre'], 'id');
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('catchup_selections/edit', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $catchup_data = [
                'id_channel' => $this->input->post('id_channel'),
                'category_catchup' => $this->input->post('category_catchup'),
                'title' => addslashes($this->input->post('title')),
                'year' => $this->input->post('year'),
                'jamtayang' => $this->input->post('jam_tayang'),
                'durasi' => $this->input->post('durasi'),
                'rating' => $this->input->post('rating'),
                'description' => addslashes($this->input->post('description')),
                'cast' => $this->input->post('cast'),
                'thumbnail' => $this->input->post('thumbnail'),
                'banner' => $this->input->post('banner'),
                'visible' => 'N',
                'create_date' => $time,
                'update_date' => $time,
            ];
            $update = $this->Catchup_selection_model->update_catchup($id, $catchup_data);
            if ($update > 0) {
                $genre = $this->input->post('genre', TRUE);
                // insert model_tag for catchup
                $this->Catchup_selection_model->update_genre($id, $genre);
                if ($this->input->post('category_catchup') == '1') {
                    $b_rating;
                    $b_jamtayang;
                    $b_year;
                    if ($this->input->post('rating') != "") {
                        $b_rating = " | ";
                    } else {
                        $b_rating = "";
                    }
                    if ($this->input->post('year') != "") {
                        $b_year = " | ";
                    } else {
                        $b_year = "";
                    }
                    if ($this->input->post('jam_tayang') != "") {
                        $b_jamtayang = " | ";
                    } else {
                        $b_jamtayang = "";
                    }
                    $catchup_content_data = array(
                        'id_channel' => $this->input->post('id_channel'),
                        'category_catchup' => $this->input->post('category_catchup'),
                        'title' => $this->input->post('title'),
                        'subtitle' => $this->input->post('rating').$b_rating.$this->input->post('year').$b_year.$this->input->post('jam_tayang').$b_jamtayang.$this->input->post('durasi'),
                        'description' => $this->input->post('description'),
                        'year' => $this->input->post('year'),
                        'jamtayang' => $this->input->post('jam_tayang'),
                        'durasi' => $this->input->post('durasi'),
                        'rating' => $this->input->post('rating'),
                        'episode' => '0',
                        'label_group' => null,
                        'season' => '0',
                        'thumbnail' => $this->input->post('thumbnail'),
                        'banner' => $this->input->post('banner'),
                        'trailer_url' => '',
                        'visible' => 'N',
                        'coming_soon' => $this->input->post('coming_soon'),
                        'cast' => $this->input->post('cast'),
                        'create_date' => $time,
                        'update_date' => $time,
                        'start_date' => $this->input->post('start_date'),
                        'end_date' => $this->input->post('end_date')
                    );
                    $id_catchup_content = $this->Catchup_selection_model->update_catchup_content($id, $catchup_content_data);
                    if ($id_catchup_content > 0) {
                        // insert model_tag for catchup_content
                        $this->Catchup_selection_model->update_genre_content($id_catchup_content, $genre);
                        $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Catch Up berhasil disimpan</div>');
                        return redirect('catchup_selections');
                    } else {
                        $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Catch Up tidak berhasil disimpan</div>');
                        return redirect('catchup_selections');
                    }
                } else {
                    $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Catch Up berhasil disimpan</div>');
                    return redirect('catchup_selections/create_catchup_content/'.$id);
                }
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Catch Up tidak berhasil disimpan</div>');
                return redirect('catchup_selections');
            }
        }
    }

    public function get_list_category_content()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }
        $results = $this->Catchup_selection_model->get_list_category_content($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Catchup_selection_model->get_list_category_content($perPage, $page, $searchTerm, 'count');
        $data = array();
        foreach ($results as $row) {
            $data[] = array(
                "id"=>$row['id'],
                "text"=>$row['title']
            );
        }
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function get_single_category_content()
    {
        $id = $this->input->post('id');
        $data = $this->Catchup_selection_model->get_category_content_by_id($id);
        echo json_encode([
            'id' => $data->id,
            'text' => $data->title
        ]);
    }

    public function create_catchup_content($id = null) {
        $CI =& get_instance();
        if (!$id) show_404();
        $catchup = $this->Catchup_selection_model->get_catchup_content_by_id($id);
        if (!$catchup) show_404();
        $data['title'] = 'Add Catch Up Content';
        $data['catchup'] = $catchup[0];
        $this->form_validation->set_rules('thumbnail_content', 'Thumbnail', 'required', ['required' => 'Thumbnail harus dipilih']);
        $this->form_validation->set_rules('banner_content', 'Banner', 'required', ['required' => 'Banner harus dipilih']);
        $this->form_validation->set_rules('id_channel_content', 'Channel', 'required', ['required' => 'Channel harus dipilih']);
        $this->form_validation->set_rules('category_catchup_content', 'Category', 'required', ['required' => 'Category harus dipilih']);
        $this->form_validation->set_rules('title_content', 'Title', 'required|is_unique[catchup_content.title]', [
            'required' => 'Title harus diisi',
            'is_unique' => 'Title sudah digunakan'
        ]);
        $this->form_validation->set_rules('description_content', 'Description', 'required', ['required' => 'Description harus diisi']);
        $this->form_validation->set_rules('genre_content[]', 'Genre', 'required', ['required' => 'Genre harus dipilih']);
        $this->form_validation->set_rules('year_content', 'Year', 'required|regex_match[/^[0-9]+$/]', [
            'required' => 'Year harus diisi',
            'regex_match' => 'Year diisi harus dengan angka'
        ]);
        if ($this->form_validation->run() == FALSE) {
            $data['selected_channel'] = set_value('id_channel_content');
            $data['selected_category'] = set_value('category_catchup_content');
            $data['selected_genres'] = $this->input->post('genre_content');
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('catchup_selections/create_catchup_content', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $b_rating;
            $b_jamtayang;
            $b_year;
            if ($this->input->post('rating') != "") {
                $b_rating = " | ";
            } else {
                $b_rating = "";
            }
            if ($this->input->post('year') != "") {
                $b_year = " | ";
            } else {
                $b_year = "";
            }
            if ($this->input->post('jam_tayang') != "") {
                $b_jamtayang = " | ";
            } else {
                $b_jamtayang = "";
            }
            if (empty($this->input->post('label_content', true))) {
                $labels = '';
            } else {
                $labels = $this->input->post('label_content', true) . ' ' . $this->input->post('season_content', true);
            }
            $catchup_content_data = [
                'id_catchup' => $id,
                'id_channel' => $this->input->post('id_channel_content'),
                'category_catchup' => $this->input->post('category_catchup_content'),
                'title' => $this->input->post('title_content'),
                'subtitle' => $this->input->post('rating_content').$b_rating.$this->input->post('year_content').$b_year.$this->input->post('jam_tayang_content').$b_jamtayang.$this->input->post('durasi_content'),
                'description' => $this->input->post('description_content'),
                'year' => $this->input->post('year_content'),
                'jamtayang' => $this->input->post('jam_tayang_content'),
                'durasi' => $this->input->post('durasi_content'),
                'rating' => $this->input->post('rating_content'),
                'episode' => $this->input->post('episode_content', true) ?: '',
                'label_group' => $labels,
                'season' => $this->input->post('season_content', true) ?: '',
                'thumbnail' => $this->input->post('thumbnail_content'),
                'banner' => $this->input->post('banner_content'),
                'trailer_url' => $this->input->post('trailer_url', true) ?: '',
                'visible' => 'N',
                'coming_soon' => $this->input->post('coming_soon_content'),
                'cast' => $this->input->post('cast_content'),
                'create_date' => $time,
                'update_date' => $time,
                'start_date' => $this->input->post('start_date_content'),
                'end_date' => $this->input->post('end_date_content')
            ];
            $lastID = $this->Catchup_selection_model->create_catchup_content($catchup_content_data);
            if ($lastID == true) {
                $genre = $this->input->post('genre_content', TRUE);
                // insert model_tag for catchup_content
                $this->Catchup_selection_model->insert_genre_content($lastID, $genre);
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Catch Up berhasil diubah</div>');
                return redirect('catchup_selections/detail/'.$id);
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Catch Up tidak berhasil diubah</div>');
                return redirect('catchup_selections');
            }
        }
    }

    public function detail($id = null)
    {
        $CI =& get_instance();
        if (!$id) show_404();
        $catchup = $this->Catchup_selection_model->get_detail_by_id($id);
        if (!$catchup) show_404();
        $data['title'] = 'Detail Catch Up';
        $data['catchup'] = $catchup[0];
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('catchup_selections/detail', $data);
        $this->load->view('layouts/footer');
    }

    public function category_season()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $id_catchup = $this->input->post('id_catchup');
        $category_catchup = $this->input->post('category_catchup');
        $perPage = 10;
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }
        $results = $this->Catchup_selection_model->category_season($perPage, $page, $searchTerm, $id_catchup, $category_catchup, 'data');
        $countResults = $this->Catchup_selection_model->category_season($perPage, $page, $searchTerm, $id_catchup, $category_catchup, 'count');
        $data = array();
        foreach ($results as $row) {
            $data[] = array(
                "id" => $row['season'],
                "text" => $row['season']
            );
        }
        $data = array_intersect_key($data, array_unique(array_column($data, 'text')));
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function contentList($id_catchup, $key_search, $cat_season, $sort_by, $order_sort, $select_content, $rowno)
    {
        // Row per page
        $rowperpage = 10;
        // Row position
        if($rowno != 0){
            $rowno = ($rowno-1) * $rowperpage;
        }
        $key_search = urldecode($key_search);
        // All records count
        $allcount = $this->Catchup_selection_model->getListCountContent($key_search,  $id_catchup, $select_content, $cat_season);
        // Get  records
        $users_record = $this->Catchup_selection_model->getContentList($id_catchup,$select_content,$rowno,$rowperpage,$order_sort,$sort_by,$key_search,$cat_season);
        // Pagination Configuration
        $config['base_url']         = base_url().'catchup_selections/contentList/'.$id_catchup.'/'.$key_search.'/'.$cat_season.'/'.$sort_by.'/'.$order_sort.'/'.$select_content.'/'.$rowno;
        $config['use_page_numbers'] = TRUE;
        $config['total_rows']       = $allcount;
        $config['per_page']         = $rowperpage;
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
        // Initialize
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
        $data['result']     = $users_record;
        $data['row']        = $rowno;
        $data['order']      = $order_sort;
        echo json_encode($data);
    }

    public function activated_content($id='', $id_parent='')
    {
        if (!isset($id)) show_404();
        $activated = $this->Catchup_selection_model->activated_content($id);
        if($activated == 1) {
            $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Activated Status Catch Up Content has been successfully!</div>');
            redirect(site_url('catchup_selections/detail/'.$id_parent.''));
        } else {
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Activated Status Catch Up Content is failed!</div>');
            redirect(site_url('catchup_selections/detail/'.$id_parent.''));
        }
    }

    public function inactivated_content($id='', $id_parent='')
    {
        if (!isset($id)) show_404();
        $inactived = $this->Catchup_selection_model->inactivated_content($id);
        if($inactived == 1) {
            $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Inactivated Status Catch Up Content has been successfully!</div>');
            redirect(site_url('catchup_selections/detail/'.$id_parent.''));
        } else {
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Inactivated Status Catch Up Content is failed!</div>');
            redirect(site_url('catchup_selections/detail/'.$id_parent.''));
        }
    }

    public function edit_catchup_content($id = null) {
        $CI =& get_instance();
        if (!$id) show_404();
        $catchup = $this->Catchup_selection_model->get_edit_catchup_content_by_id($id);
        if (!$catchup) show_404();
        $data['title'] = 'Edit Catch Up Content';
        $data['catchup'] = $catchup[0];
        $this->form_validation->set_rules('thumbnail_content', 'Thumbnail', 'required', ['required' => 'Thumbnail harus dipilih']);
        $this->form_validation->set_rules('banner_content', 'Banner', 'required', ['required' => 'Banner harus dipilih']);
        $this->form_validation->set_rules('category_catchup_content', 'Category', 'required', ['required' => 'Category harus dipilih']);
        $current_title = $catchup[0]['title'];
        $input_title = $this->input->post('title_content');
        $title_rule = 'required';
        if (trim(strtolower($input_title)) !== trim(strtolower($current_title))) {
            $title_rule .= '|is_unique[catchup_content.title]';
        }
        $this->form_validation->set_rules('title_content', 'Title', $title_rule, [
            'required' => 'Title harus diisi',
            'is_unique' => 'Title sudah digunakan'
        ]);
        $this->form_validation->set_rules('description_content', 'Description', 'required', ['required' => 'Description harus diisi']);
        $this->form_validation->set_rules('genre_content[]', 'Genre', 'required', ['required' => 'Genre harus dipilih']);
        $this->form_validation->set_rules('year_content', 'Year', 'required|regex_match[/^[0-9]+$/]', [
            'required' => 'Year harus diisi',
            'regex_match' => 'Year diisi harus dengan angka'
        ]);
        if ($this->form_validation->run() == FALSE) {
            $data['selected_category'] = set_value('category_catchup') ?: $catchup[0]['category_catchup'];
            $data['selected_genres'] = $this->input->post('genre') ?: array_column($catchup[0]['genre'], 'id');
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('catchup_selections/edit_catchup_content', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $b_rating;
            $b_jamtayang;
            $b_year;
            if ($this->input->post('rating') != "") {
                $b_rating = " | ";
            } else {
                $b_rating = "";
            }
            if ($this->input->post('year') != "") {
                $b_year = " | ";
            } else {
                $b_year = "";
            }
            if ($this->input->post('jam_tayang') != "") {
                $b_jamtayang = " | ";
            } else {
                $b_jamtayang = "";
            }
            if (empty($this->input->post('label_content', true))) {
                $labels = '';
            } else {
                $labels = $this->input->post('label_content', true) . ' ' . $this->input->post('season_content', true);
            }
            $catchup_content_data = [
                'category_catchup' => $this->input->post('category_catchup_content'),
                'title' => $this->input->post('title_content'),
                'subtitle' => $this->input->post('rating_content').$b_rating.$this->input->post('year_content').$b_year.$this->input->post('jam_tayang_content').$b_jamtayang.$this->input->post('durasi_content'),
                'description' => $this->input->post('description_content'),
                'year' => $this->input->post('year_content'),
                'jamtayang' => $this->input->post('jam_tayang_content'),
                'durasi' => $this->input->post('durasi_content'),
                'rating' => $this->input->post('rating_content'),
                'episode' => $this->input->post('episode_content', true) ?: '',
                'label_group' => $labels,
                'season' => $this->input->post('season_content', true) ?: '',
                'thumbnail' => $this->input->post('thumbnail_content'),
                'banner' => $this->input->post('banner_content'),
                'trailer_url' => $this->input->post('trailer_url', true) ?: '',
                'visible' => 'N',
                'coming_soon' => $this->input->post('coming_soon_content'),
                'cast' => $this->input->post('cast_content'),
                'create_date' => $time,
                'update_date' => $time,
                'start_date' => $this->input->post('start_date_content'),
                'end_date' => $this->input->post('end_date_content')
            ];
            $saved = $this->Catchup_selection_model->edit_catchup_content($id, $catchup_content_data);
            if ($saved == true) {
                $genre = $this->input->post('genre_content', TRUE);
                // insert model_tag for catchup_content
                $this->Catchup_selection_model->update_genre_content($id, $genre);
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Catch Up berhasil diubah</div>');
                return redirect('catchup_selections/detail/'.$catchup[0]['id_catchup']);
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Catch Up tidak berhasil diubah</div>');
                return redirect('catchup_selections');
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

    public function compare_image_thumbnail()
    {
        echo json_encode($this->get_image_thumbnail());
    }

    private function get_image_thumbnail()
    {
        $data = array();
        $_arrFolder = array();
        $_urlimage = array();
        $_urlimage_catchup = array();
        $_urlimage_content = array();
        //formed array from server
        $path = 'wp/img/catchup_thumbnail/410x230/';
        $changeDir = 'wp/img/catchup_thumbnail/410x230/';
        $listimg = $this->libadapter->getImages($path, $changeDir);
        if ($listimg['error'] == 0) {
            $_arrFolder = array();
            $listimg1 = $listimg['content'];
            foreach ($listimg1 as $key => $value) {
                $_arrFolder[] = $value['url'];
            }
            krsort($_arrFolder);
            //formed array from database
            $urlimage = $this->Catchup_selection_model->getimagethumbnail();
            $urlimage_catchup = $urlimage['catchup'];
            $urlimage_content = $urlimage['content'];
            if ($urlimage_catchup!=null) {
                foreach ($urlimage_catchup as $key => $value) {
                    array_push($_urlimage_catchup, self::$baseurlimage . 'img/catchup_thumbnail/410x230/' . basename($value['thumbnail']));
                }
            }
            if ($urlimage_content!=null) {
                foreach ($urlimage_content as $key => $value) {
                    array_push($_urlimage_content, self::$baseurlimage . 'img/catchup_thumbnail/410x230/' . basename($value['thumbnail']));
                }
            }
            $_urlimage = array_unique(array_merge($_urlimage_catchup, $_urlimage_content));
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

    public function compare_image_banner()
    {
        echo json_encode($this->get_image_banner());
    }

    private function get_image_banner()
    {
        $data = array();
        $_arrFolder = array();
        $_urlimage = array();
        $_urlimage_catchup = array();
        $_urlimage_content = array();
        //formed array from server
        $path = 'wp/img/catchup_banner/1280x720/';
        $changeDir = 'wp/img/catchup_banner/1280x720/';
        $listimg = $this->libadapter->getImages($path, $changeDir);
        if ($listimg['error'] == 0) {
            $_arrFolder = array();
            $listimg1 = $listimg['content'];
            foreach ($listimg1 as $key => $value) {
                $_arrFolder[] = $value['url'];
            }
            krsort($_arrFolder);
            //formed array from database
            $urlimage = $this->Catchup_selection_model->getimagebanner();
            $urlimage_catchup = $urlimage['catchup'];
            $urlimage_content = $urlimage['content'];
            if ($urlimage_catchup!=null) {
                foreach ($urlimage_catchup as $key => $value) {
                    array_push($_urlimage_catchup, self::$baseurlimage . 'img/catchup_banner/1280x720/' . basename($value['banner']));
                }
            }
            if ($urlimage_content!=null) {
                foreach ($urlimage_content as $key => $value) {
                    array_push($_urlimage_content, self::$baseurlimage . 'img/catchup_banner/1280x720/' . basename($value['banner']));
                }
            }
            $_urlimage = array_unique(array_merge($_urlimage_catchup, $_urlimage_content));
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
