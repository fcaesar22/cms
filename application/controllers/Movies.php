<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Movies extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user')) {
            redirect('auth');
        }
        if (!has_permission('view_movies')) {
            show_error('Anda tidak memiliki akses ke halaman ini', 403, 'Forbidden');
        }
        $this->load->config('secure_config');
        $this->load->library('pagination');
        $this->load->library('libadapter');
        $this->load->model('Movie_model');
    }

    private static $baseurlimage = 'https://picture.dens.tv/';

    public function index()
    {
        $data['title'] = 'Movies';
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('movies/index', $data);
        $this->load->view('layouts/footer');
    }

    public function category_movies()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }
        $results = $this->Movie_model->category_movies($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Movie_model->category_movies($perPage, $page, $searchTerm, 'count');
        $data = array();
        foreach ($results as $row) {
            $data[] = array(
                "id"=>$row['keyword_id'],
                "text"=>$row['keyword_name']
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

    public function list_movies($key_search=null, $sort_by='movie_id', $order_sort='desc', $visible='Y', $category, $rowperpage=10, $rowno=0)
    {
        if ($rowno != 0) {
            $rowno = ($rowno-1) * $rowperpage;
        }
        
        $allcount = $this->Movie_model->getCountAll($key_search, $visible, $category);

        $users_record = $this->Movie_model->getDatas($key_search, $sort_by, $order_sort, $visible, $category, $rowperpage, $rowno);
        
        // Pagination Configuration
        $config['base_url'] = base_url().'movies/list_movies/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$visible.'/'.$category.'/'.$rowperpage.'/'.$rowno;
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

    public function activated_movie($id)
    {
        if (!isset($id)) show_404();
        
        if ($this->Movie_model->activated_movie($id)) {
            redirect(site_url('movies'));
        }
    }

    public function inactivated_movie($id)
    {
        if (!isset($id)) show_404();
        
        if ($this->Movie_model->inactivated_movie($id)) {
            redirect(site_url('movies'));
        }
    }

    public function get_list_movie_code()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }
        $results = $this->Movie_model->get_list_movie_code($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Movie_model->get_list_movie_code($perPage, $page, $searchTerm, 'count');
        $data = array();
        foreach ($results as $row) {
            $data[] = array(
                "id"=>$row['code_init'],
                "text"=>$row['code_init'].' - '.$row['code_remark']
            );
        }
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function get_single_movie_code()
    {
        $id = $this->input->post('id');
        $data = $this->Movie_model->get_movie_code_by_id($id);
        echo json_encode([
            'id' => $data['id'],
            'text' => $data['title']
        ]);
    }

    public function get_list_movie_parent()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $movie_type = $this->input->post('movie_type');
        switch ($movie_type) {
            case 'SIN':
                $data = array(
                    array(
                        'id' => 'STD',
                        'text' => 'Studio'
                    ),
                    array(
                        'id' => 'SER',
                        'text' => 'Series'
                    ),
                    array(
                        'id' => 'SEA',
                        'text' => 'Season'
                    ),
                    array(
                        'id' => 'DPL',
                        'text' => 'DensPlay'
                    ),
                );
                break;
            case 'SEA':
                $data = array(
                    array(
                        'id' => 'SER',
                        'text' => 'Series'
                    )
                );
                break;
            case 'SER':
                $data = array(
                    array(
                        'id' => 'STD',
                        'text' => 'Studio'
                    )
                );
                break;
            default:
                $data = array();
                break;
        }
        $select['total_count'] = count($data);
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function get_single_movie_parent()
    {
        $id = $this->input->post('id');

        // Simulasi label dari ID yang dikirim
        $labels = array(
            'STD' => 'Studio',
            'SER' => 'Series',
            'SEA' => 'Season',
            'DPL' => 'DensPlay'
        );

        $response = [];
        if (array_key_exists($id, $labels)) {
            $response = [
                'id' => $id,
                'text' => $labels[$id]
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function get_list_movie_parent_id()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        if($page != 0){
            $page = ($page-1) * $perPage;
        }
        $movie_parent = $this->input->post('movie_parent');
        $data = $this->Movie_model->get_list_movie_parent_id($perPage, $page, $searchTerm, $movie_parent, 'data');
        $countResults = $this->Movie_model->get_list_movie_parent_id($perPage, $page, $searchTerm, $movie_parent, 'count');
        
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function get_single_movie_parent_id()
    {
        $id = $this->input->post('id');
        $parent = $this->input->post('movie_parent');

        if (!$id || !$parent) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([]));
            return;
        }

        $data = $this->Movie_model->get_single_movie_parent_id($id, $parent);

        if ($data) {
            $result = [
                'id' => $data['id'],
                'text' => $data['text']
            ];
        } else {
            $result = [];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function get_list_group_keyword()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }
        $results = $this->Movie_model->get_list_group_keyword($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Movie_model->get_list_group_keyword($perPage, $page, $searchTerm, 'count');
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

    public function get_multiple_group_keyword()
    {
        $ids = $this->input->post('ids');
        if (!is_array($ids)) {
            $ids = [$ids];
        }
        $genres = [];
        foreach ($ids as $id) {
            $group = $this->Movie_model->get_group_keyword_by_id($id);
            if ($group) {
                $genres[] = [
                    'id' => $group->keyword_id,
                    'text' => $group->keyword_name
                ];
            }
        }
        echo json_encode($genres);
    }

    public function prefixmovie($movietype='')
    {
        if ($movietype=='SIN') {
            $result = array(
                'flag'=>'0',
                'remark'=>"Single/Episodes"
            );
        } elseif($movietype=='SEA') {
            $result = array(
                'flag'=>'2',
                'remark'=>"Season"
            );
        } elseif($movietype=='SER') {
            $result = array(
                'flag'=>'1',
                'remark'=>"Series"
            );
        }
        return $result;
    }

    public function create() {
        $CI =& get_instance();
        $data['title'] = 'Add Movie';

        $this->form_validation->set_rules('movie_code', 'Movie Code', 'required', ['required' => 'Movie Code harus dipilih']);
        $this->form_validation->set_rules('movie_type', 'Movie Type', 'required', ['required' => 'Movie Type harus dipilih']);
        $this->form_validation->set_rules('movie_parent', 'Movie Parent', 'required', ['required' => 'Movie Parent harus dipilih']);
        $this->form_validation->set_rules('movie_parent_id', 'Movie Parent ID', 'required', ['required' => 'Movie Parent ID harus dipilih']);
        $this->form_validation->set_rules('movie_child', 'Movie Child', 'required', ['required' => 'Movie Child harus dipilih']);
        $this->form_validation->set_rules('group_keyword[]', 'Group Keyword', 'required', ['required' => 'Group Keyword harus dipilih']);
        $this->form_validation->set_rules('title', 'Title', 'required', ['required' => 'Title harus diisi']);
        $this->form_validation->set_rules('description', 'Description', 'required', ['required' => 'Description harus diisi']);
        $this->form_validation->set_rules('actor', 'Actor', 'required', ['required' => 'Actor harus diisi']);
        $this->form_validation->set_rules('director', 'Director', 'required', ['required' => 'Director harus diisi']);
        $this->form_validation->set_rules('year', 'Year', 'required|regex_match[/^[0-9]+$/]', [
            'required' => 'Year harus diisi',
            'regex_match' => 'Year diisi harus dengan angka'
        ]);
        $this->form_validation->set_rules('parental_guide', 'Parental Guide', 'required', ['required' => 'Parental Guide harus diisi']);
        $this->form_validation->set_rules('publish_date', 'Publish Date', 'required', ['required' => 'Publish Date harus dipilih']);

        if ($this->form_validation->run() == FALSE) {
            $data['selected_movie_code'] = set_value('movie_code');
            $data['selected_movie_parent'] = set_value('movie_parent');
            $data['selected_movie_parent_id'] = set_value('movie_parent_id');
            $data['selected_group_keyword'] = $this->input->post('group_keyword');
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('movies/create', $data);
            $this->load->view('layouts/footer');
        } else {
            $movieCode = $this->input->post('movie_code');
            $movieType = $this->input->post('movie_type');
            $publishDate = $this->input->post('publish_date');
            $prefixmovie = $this->prefixmovie($movieType);
            $premode = $movieCode.$prefixmovie['flag'];
            $findcode = $this->Movie_model->new_movie_code($premode);
            $newmoviecode = $findcode['newmoviecode'];
            $dates = explode(" to ", $publishDate);
            $start_date = $dates[0] . ' 00:00:00';
            $end_date = $dates[1] . ' 23:59:59';
            $allowed_pc = ($this->input->post('allowed_pc') == '1') ? 1 : 0;
            $allowed_stb = ($this->input->post('allowed_stb') == '1') ? 1 : 0;
            $allowed_android = ($this->input->post('allowed_android') == '1') ? 1 : 0;
            $allowed_ios = ($this->input->post('allowed_ios') == '1') ? 1 : 0;
            $allowed_device = $allowed_pc.$allowed_stb.$allowed_android.$allowed_ios;
            $movie_data = [
                'movie_code' => $newmoviecode,
                'movie_title' => $this->input->post('title'),
                'movie_description' => $this->input->post('description'),
                'movie_seq' => $this->input->post('sequence_number'),
                'movie_actor' => $this->input->post('actor'),
                'movie_director' => $this->input->post('director'),
                'movie_keywords' => ',' . implode(",", $this->input->post('group_keyword',TRUE)) . ',',
                'movie_rating' => $this->input->post('parental_guide'),
                'movie_year' => $this->input->post('year'),
                'movie_trailer' => $this->input->post('url_trailer'),
                'movie_watching' => $this->input->post('rental_duration'),
                'movie_price' => $this->input->post('price'),
                'movie_date1' => $start_date,
                'movie_date2' => $end_date,
                'movie_allowapps' => $allowed_device,
                'movie_type' => $movieType,
                'movie_parent_id' => $this->input->post('movie_parent_id'),
                'movie_parentype' => $this->input->post('movie_parent'),
                'movie_childtype' => $this->input->post('movie_child'),
                'movie_payable' => $this->input->post('sell_methode'),
            ];
            $saved = $this->Movie_model->insert_movie($movie_data);
            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Movie berhasil disimpan</div>'); 
                return redirect('movies/create_edit_poster_stream/'.$saved.'/'.$movieType);
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Movie tidak berhasil disimpan</div>');
                return redirect('movies');
            }
        }
    }

    public function edit($id = null) {
        $CI =& get_instance();
        if (!$id) show_404();
        $movie = $this->Movie_model->get_movie_by_id($id);
        if (!$movie) show_404();

        $data['title'] = 'Edit Movie';
        $data['movie'] = $movie[0];

        $this->form_validation->set_rules('movie_code', 'Movie Code', 'required', ['required' => 'Movie Code harus dipilih']);
        $this->form_validation->set_rules('movie_type', 'Movie Type', 'required', ['required' => 'Movie Type harus dipilih']);
        $this->form_validation->set_rules('movie_parent', 'Movie Parent', 'required', ['required' => 'Movie Parent harus dipilih']);
        $this->form_validation->set_rules('movie_parent_id', 'Movie Parent ID', 'required', ['required' => 'Movie Parent ID harus dipilih']);
        $this->form_validation->set_rules('movie_child', 'Movie Child', 'required', ['required' => 'Movie Child harus dipilih']);
        $this->form_validation->set_rules('group_keyword[]', 'Group Keyword', 'required', ['required' => 'Group Keyword harus dipilih']);
        $this->form_validation->set_rules('title', 'Title', 'required', ['required' => 'Title harus diisi']);
        $this->form_validation->set_rules('description', 'Description', 'required', ['required' => 'Description harus diisi']);
        $this->form_validation->set_rules('actor', 'Actor', 'required', ['required' => 'Actor harus diisi']);
        $this->form_validation->set_rules('director', 'Director', 'required', ['required' => 'Director harus diisi']);
        $this->form_validation->set_rules('year', 'Year', 'required|regex_match[/^[0-9]+$/]', [
            'required' => 'Year harus diisi',
            'regex_match' => 'Year diisi harus dengan angka'
        ]);
        $this->form_validation->set_rules('parental_guide', 'Parental Guide', 'required', ['required' => 'Parental Guide harus diisi']);
        $this->form_validation->set_rules('publish_date', 'Publish Date', 'required', ['required' => 'Publish Date harus dipilih']);

        if ($this->form_validation->run() == FALSE) {
            $data['selected_movie_code'] = set_value('movie_code');
            $data['selected_movie_parent'] = set_value('movie_parent');
            $data['selected_movie_parent_id'] = set_value('movie_parent_id');
            $data['selected_group_keyword'] = $this->input->post('group_keyword');
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('movies/edit', $data);
            $this->load->view('layouts/footer');
        } else {
            $movieCodeExist = $this->input->post('movie_code_exist');
            $getCodeExist = substr($movieCodeExist, 0, 5);
            $movieCode = $this->input->post('movie_code');
            $movieType = $this->input->post('movie_type');
            $publishDate = $this->input->post('publish_date');
            if ($movieCode == $getCodeExist) {
                $mvCode = $movieCodeExist;
            } else {
                $prefixmovie = $this->prefixmovie($movieType);
                $premode = $movieCode.$prefixmovie['flag'];
                $findcode = $this->Movie_model->new_movie_code($premode);
                $mvCode = $findcode['newmoviecode'];
            }
            $dates = explode(" to ", $publishDate);
            $start_date = $dates[0] . ' 00:00:00';
            $end_date = $dates[1] . ' 23:59:59';
            $allowed_pc = ($this->input->post('allowed_pc') == '1') ? 1 : 0;
            $allowed_stb = ($this->input->post('allowed_stb') == '1') ? 1 : 0;
            $allowed_android = ($this->input->post('allowed_android') == '1') ? 1 : 0;
            $allowed_ios = ($this->input->post('allowed_ios') == '1') ? 1 : 0;
            $allowed_device = $allowed_pc.$allowed_stb.$allowed_android.$allowed_ios;
            $movie_data = [
                'movie_id' => $id,
                'movie_code' => $mvCode,
                'movie_title' => $this->input->post('title'),
                'movie_description' => $this->input->post('description'),
                'movie_seq' => $this->input->post('sequence_number'),
                'movie_actor' => $this->input->post('actor'),
                'movie_director' => $this->input->post('director'),
                'movie_keywords' => ',' . implode(",", $this->input->post('group_keyword',TRUE)) . ',',
                'movie_rating' => $this->input->post('parental_guide'),
                'movie_year' => $this->input->post('year'),
                'movie_trailer' => $this->input->post('url_trailer'),
                'movie_watching' => $this->input->post('rental_duration'),
                'movie_price' => $this->input->post('price'),
                'movie_date1' => $start_date,
                'movie_date2' => $end_date,
                'movie_allowapps' => $allowed_device,
                'movie_type' => $movieType,
                'movie_parent_id' => $this->input->post('movie_parent_id'),
                'movie_parentype' => $this->input->post('movie_parent'),
                'movie_childtype' => $this->input->post('movie_child'),
                'movie_payable' => $this->input->post('sell_methode'),
            ];
            $saved = $this->Movie_model->update_movie($movie_data);
            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Movie berhasil diubah</div>'); 
                return redirect('movies/create_edit_poster_stream/'.$id.'/'.$movieType);
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Movie tidak berhasil diubah</div>');
                return redirect('movies');
            }
        }
    }

    public function list_movie_code($key_search=null, $sort_by='code_id', $order_sort='asc', $visible='Y', $rowno=0)
    {
        // Row per page
        $rowperpage = 10;

        // Row position
        if ($rowno != 0) {
            $rowno = ($rowno-1) * $rowperpage;
        }

        if ($sort_by == 'null') {
            $sort_by='code_id';
        }

        if ($order_sort == 'null') {
            $order_sort='DESC';
        }

        $key_search = urldecode($key_search);
        
        // All records count
        $allcount = $this->Movie_model->getListCodeCount($key_search,$visible);

        // Get  records
        $users_record = $this->Movie_model->getDataListCode($rowno,$rowperpage,$order_sort,$sort_by,$key_search,$visible);
        
        // Pagination Configuration
        $config['base_url'] = base_url().'movies/list_movie_code/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$visible.'/'.$rowno;
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
        $data['result'] = $users_record;
        $data['row'] = $rowno;
        $data['order'] = $order_sort;

        echo json_encode($data);
    }

    public function insert_code()
    {
        $this->form_validation->set_rules('initial_code', 'Initial Code', 'trim|required');
        $this->form_validation->set_rules('remark', 'Remark', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            alert('silahkan isi initial code atau remark!');
        } else {
            $initial_code = $this->input->post('initial_code');
            $remark = $this->input->post('remark');
            if ($initial_code != null) {
                $data = array(
                    'code_parent' => '87',
                    'code_init' => $initial_code,
                    'code_sort' => '0',
                    'code_remark' => $remark,
                    'code_visible' => 'N',
                );
                $insert = $this->Movie_model->insert_code($data);
                if ($insert == true) {
                    $results = array(
                        'error' => '0',
                        'message' => 'Data berhasil disimpan'
                    );
                } else {
                    $results = array(
                        'error' => '1',
                        'message' => 'Data gagal disimpan karna initial code sudah ada'
                    );
                }
            } else {
                $results = array(
                    'error' => '1',
                    'message' => 'Data gagal disimpan'
                );
            }
            echo json_encode($results);
        }
    }

    public function get_data_edit_code()
    {
        $id = $this->input->post('id',TRUE);
        $code = $this->Movie_model->get_data_edit_code($id);
        if ($code!=null) {
            $data = $code;
        } else {
            die("Data not found");
        }
        echo json_encode($data);
    }

    public function update_code()
    {
        $code_id = $this->input->post('code_id');
        $initial_code = $this->input->post('initial_code');
        $remark = $this->input->post('remark');
        
        $update = $this->Movie_model->update_code($code_id,$initial_code,$remark);
        if ($update==true) {
            $results = array(
                'error' => '0',
                'message' => 'Data berhasil disimpan'
            );
        } else {
            $results = array(
                'error' => '1',
                'message' => 'Data gagal disimpan karna initial code sudah ada'
            );
        }
        echo json_encode($results);
    }

    public function activate_code()
    {
        $id = $this->input->post('id');

        $inactive = $this->Movie_model->activate_code($id);
        if ($inactive==true) {
            $results = array(
                'error' => '0',
                'message' => 'Data berhasil disimpan'
            );
        } else {
            $results = array(
                'error' => '1',
                'message' => 'Data gagal disimpan'
            );
        }
        echo json_encode($results);
    }

    public function inactivate_code()
    {
        $id = $this->input->post('id');

        $inactive = $this->Movie_model->inactivate_code($id);
        if ($inactive==true) {
            $results = array(
                'error' => '0',
                'message' => 'Data berhasil disimpan'
            );
        } else {
            $results = array(
                'error' => '1',
                'message' => 'Data gagal disimpan'
            );
        }
        echo json_encode($results);
    }

    public function update_sort()
    {
        if (isset($_POST["action"])) {
            if ($_POST['action'] == 'update') {
                for ($count = 0;  $count < count($_POST["page_id_array"]); $count++) {
                   $query = "
                   UPDATE keywords 
                   SET keyword_sort = '".($count+1)."' 
                   WHERE keyword_id = '".$_POST["page_id_array"][$count]."'
                   ";
                   $data = $this->Movie_model->update_sort($query);
                }
            }
        }
    }

    public function list_movie_keyword($key_search=null, $sort_by='keyword_id', $order_sort='asc', $visible='Y', $contentKey=null, $rowperpage, $rowno=0)
    {
        // Row per page
        if ($rowperpage==null) {
            $rowperpage = 10;
        }

        // Row position
        if ($rowno != 0) {
            $rowno = ($rowno-1) * $rowperpage;
        }

        if ($sort_by == 'null') {
            $sort_by='keyword_id';
        }

        if ($order_sort == 'null') {
            $order_sort='DESC';
        }

        $key_search = urldecode($key_search);
        
        // All records count
        $allcount = $this->Movie_model->getListKeywordCount($key_search,$visible,$contentKey);

        // Get  records
        $users_record = $this->Movie_model->getDataListKeyword($rowno,$rowperpage,$order_sort,$sort_by,$key_search,$visible,$contentKey);
        
        // Pagination Configuration
        $config['base_url'] = base_url().'movies/list_movie_keyword/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$visible.'/'.$contentKey.'/'.$rowperpage.'/'.$rowno;
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
        $data['result'] = $users_record;
        $data['row'] = $rowno;
        $data['order'] = $order_sort;

        echo json_encode($data);
    }

    public function get_list_genre()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }
        $data = $this->Movie_model->get_list_genre($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Movie_model->get_list_genre($perPage, $page, $searchTerm, 'count');
        
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function cu_keyword()
    {
        $keyword_name = $this->input->post('keyword_name');
        $keyword_child = $this->input->post('keyword_child');
        $keyword_ref = $this->input->post('keyword_ref');
        $genre_id = $this->input->post('genre_id');
        $keyword_id = $this->input->post('keyword_id');
        if ($keyword_id==null || $keyword_id=="") {
            $cu = $this->Movie_model->cu_keyword($keyword_id,$keyword_name,$keyword_child,$keyword_ref,$genre_id,'create');
        } else {
            $cu = $this->Movie_model->cu_keyword($keyword_id,$keyword_name,$keyword_child,$keyword_ref,$genre_id,'update');
        }

        if ($cu==true) {
            $results = array(
                'error' => '0',
                'message' => 'Data berhasil disimpan'
            );
        } else {
            $results = array(
                'error' => '1',
                'message' => 'Data gagal disimpan'
            );
        }
        echo json_encode($results);
    }

    public function get_data_edit_keyword()
    {
        $id = $this->input->post('id',TRUE);
        $code = $this->Movie_model->get_data_edit_keyword($id);
        if ($code!=null) {
            $data = $code;
        } else {
            die("Data not found");
        }
        echo json_encode($data);
    }

    public function create_edit_poster_stream($movie_id=null, $movie_type=null) {
        if (!$movie_id) show_404();
        if (!$movie_type) show_404();

        $data['title'] = 'Manage Poster & Stream';
        $data['movie_id'] = $movie_id;
        $data['movie_type'] = $movie_type;
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('movies/poster_stream', $data);
        $this->load->view('layouts/footer');
    }

    public function get_data_poster_stream()
    {
        $movie_id = $this->input->post('movie_id',TRUE);
        $movie = $this->Movie_model->get_data_poster_stream($movie_id);
        if ($movie!=null) {
            $data = $movie;
        } else {
            die("Data not found");
        }
        echo json_encode($data);
    }

    public function poster_and_stream()
    {
        $duration = $this->input->post('duration');
        $movie_id = $this->input->post('movie_id');
        $movie_type = $this->input->post('movie_type');

        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');

        $check_movie_id = $this->Movie_model->check_movie_id($movie_id);
        if ($check_movie_id['num_rows'] <= 0) {
            $response = array(
                'res' => '1',
                'msg' => 'Error',
            );
        } else {
            $vod_sizes = array(
                '1280x720',
                '410x230',
                '235x132',
                '549x825',
                '183x275',
                '170x252',
                '122x182'
            );

            foreach ($vod_sizes as $size) {
                $url_key = 'url_vod_' . $size;
                $id_key  = 'id_vod_' . $size;

                $url = $this->input->post($url_key);
                $id  = $this->input->post($id_key);

                $data_poster = array(
                    'poster_type' => 'vod_' . $size,
                    'poster_url' => $url,
                    'poster_visible' => 'Y',
                    'product_id' => $check_movie_id['movie_code'],
                    'poster_update' => $time,
                );

                if (!empty($id)) {
                    // update poster exist
                    $this->Movie_model->update_poster_exist($id, $data_poster);
                } else {
                    // insert poster baru
                    $this->Movie_model->insert_poster_new($data_poster);
                }
            }

            if ($movie_type == 'SIN') {
                $streams = array(
                    'web' => array(
                        'url' => $this->input->post('web_stream_url'),
                        'id' => $this->input->post('web_stream_id'),
                        'screen' => '101'
                    ),
                    'stb' => array(
                        'url' => $this->input->post('stb_stream_url'),
                        'id' => $this->input->post('stb_stream_id'),
                        'screen' => '201'
                    ),
                    'ios' => array(
                        'url' => $this->input->post('ios_stream_url'),
                        'id' => $this->input->post('ios_stream_id'),
                        'screen' => '301'
                    ),
                    'ios_pad' => array(
                        'url' => $this->input->post('ios_pad_stream_url'),
                        'id' => $this->input->post('ios_pad_stream_id'),
                        'screen' => '401'
                    ),
                    'android' => array(
                        'url' => $this->input->post('android_stream_url'),
                        'id' => $this->input->post('android_stream_id'),
                        'screen' => '501'
                    ),
                    'android_pad' => array(
                        'url' => $this->input->post('android_pad_stream_url'),
                        'id' => $this->input->post('android_pad_stream_id'),
                        'screen' => '601'
                    ),
                    'octoshape' => array(
                        'url' => $this->input->post('octoshape_stream_url'),
                        'id' => $this->input->post('octoshape_stream_id'),
                        'screen' => '202'
                    ),
                    'octoshape2400k' => array(
                        'url' => $this->input->post('octoshape2400k_stream_url'),
                        'id' => $this->input->post('octoshape2400k_stream_id'),
                        'screen' => '102'
                    ),
                    'trailer' => array(
                        'url' => $this->input->post('trailer_stream_url'),
                        'id' => $this->input->post('trailer_stream_id'),
                        'screen' => '103'
                    ),
                    'download' => array(
                        'url' => $this->input->post('download_stream_url'),
                        'id' => $this->input->post('download_stream_id'),
                        'screen' => '701'
                    ),
                );

                foreach ($streams as $platform => $data) {
                    $stream_id  = trim($data['id']);
                    $stream_url = trim($data['url']);
                    $stream_screen = trim($data['screen']);

                    // Skip kalau URL kosong
                    if (empty($stream_url)) {
                        continue;
                    }

                    $data_stream = array(
                        'stream_type' => 'MOV',
                        'stream_screen' => $stream_screen,
                        'stream_length' => $duration,
                        'product_id' => $check_movie_id['movie_code'],
                        'stream_visible' => 'Y',
                        'stream_pass' => '0',
                        'stream_url' => $stream_url,
                    );

                    if (!empty($stream_id)) {
                        // update streams
                        $this->Movie_model->update_stream_exist($stream_id, $data_stream);
                    } else {
                        // insert streams
                        $this->Movie_model->insert_stream_new($data_stream);
                    }
                }
            }
            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Movie berhasil disimpan</div>');
            $response = array(
                'res' => '0',
                'msg' => 'Success',
            );
        }
        echo json_encode($response);
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
        $path = 'poster/files/lands/vod_235x132/';
        $changeDir = 'poster/files/lands/vod_235x132/';
        $listimg = $this->libadapter->getImages($path, $changeDir);
        if ($listimg['error'] == 0) {
            $_arrFolder = array();
            $listimg1 = $listimg['content'];
            foreach ($listimg1 as $key => $value) {
                $_arrFolder[] = $value['url'];
            }
            krsort($_arrFolder);

            //formed array from database
            $urlimage = $this->Movie_model->getimagelandcape();
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
        echo json_encode($this->get_image_potrait());
    }

    private function get_image_potrait()
    {
        $data = array();
        $_arrFolder = array();
        $_urlimage = array();

        //formed array from server
        $path = 'poster/files/port/vod_122x182/';
        $changeDir = 'poster/files/port/vod_122x182/';
        $listimg = $this->libadapter->getImages($path, $changeDir);
        if ($listimg['error'] == 0) {
            $_arrFolder = array();
            $listimg1 = $listimg['content'];
            foreach ($listimg1 as $key => $value) {
                $_arrFolder[] = $value['url'];
            }
            krsort($_arrFolder);

            //formed array from database
            $urlimage = $this->Movie_model->getimageportrait();
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
}
