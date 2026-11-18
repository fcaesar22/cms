<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Packages extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user')) {
            redirect('auth');
        }
        if (!has_permission('view_packages')) {
            show_error('Anda tidak memiliki akses ke halaman ini', 403, 'Forbidden');
        }
        $this->load->config('secure_config');
        $this->load->library('pagination');
        $this->load->library('libadapter');
        $this->load->model('Package_model');
    }

    private static $baseurlimage = 'https://picture.dens.tv/wp/';

    public function index()
    {
        $data['title'] = 'List Packages';
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('packages/index', $data);
        $this->load->view('layouts/footer');
    }

    public function list_packages($key_search=null, $sort_by='seq', $order_sort='desc', $status='active', $rowperpage=10, $rowno=0)
    {
        if ($rowno != 0) {
            $rowno = ($rowno-1) * $rowperpage;
        }

        $key_search = urldecode($key_search);

        $allcount = $this->Package_model->getCountAll($key_search, $status);
        $users_record = $this->Package_model->getDatas($key_search, $sort_by, $order_sort, $status, $rowperpage, $rowno);

        // Pagination Configuration
        $config['base_url'] = base_url().'packages/list_packages/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$status.'/'.$rowperpage.'/'.$rowno;
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

    public function activatedPackage($id)
    {
        if (!isset($id)) show_404();
        
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');
        $inactivated = $this->Package_model->activatedPackage($id, $time);
        if ($inactivated == true) {
            $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Activated has been successfully!</div>');
            redirect(site_url('packages'));
        } else {
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Activated is failed!</div>');
            redirect(site_url('packages'));
        }
    }

    public function inactivatedPackage($id)
    {
        if (!isset($id)) show_404();
        
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');
        $inactivated = $this->Package_model->inactivatedPackage($id, $time);
        if ($inactivated == true) {
            $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Inactivated has been successfully!</div>');
            redirect(site_url('packages'));
        } else {
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Inactivated is failed!</div>');
            redirect(site_url('packages'));
        }
    }

    public function getListType()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        
        $offset = max(0, ($page - 1) * $perPage);

        $results = $this->Package_model->getListType($perPage, $offset, $searchTerm, 'data');

        $countResults = $this->Package_model->getListType($perPage, $offset, $searchTerm, 'count');

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

    public function getSingleType()
    {
        $id = $this->input->post('id');

        $data = $this->Package_model->getSingleType($id);

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

    public function getListAffiliate()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }

        $results = $this->Package_model->getListAffiliate($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Package_model->getListAffiliate($perPage, $page, $searchTerm, 'count');
        $data = array();
        
        foreach ($results as $row) {
            $data[] = array(
                "id" => $row['code_init'],
                "text" => $row['code_remark']
            );
        }
        
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function getSingleAffiliate()
    {
        $id = $this->input->post('id');
        $data = $this->Package_model->getSingleAffiliate($id);
        echo json_encode([
            'id' => $data->code_init,
            'text' => $data->code_remark
        ]);
    }

    public function getListTv()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        if($page != 0){
            $page = ($page-1) * $perPage;
        }
        $results = $this->Package_model->getListTv($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Package_model->getListTv($perPage, $page, $searchTerm, 'count');
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

    public function getMultipleTv()
    {
        $ids = $this->input->post('ids');
        if (!is_array($ids)) {
            $ids = [$ids];
        }
        $genres = [];
        foreach ($ids as $id) {
            $group = $this->Package_model->getMultipleTv($id);
            if ($group) {
                $genres[] = [
                    'id' => $group->seq,
                    'text' => $group->title
                ];
            }
        }
        echo json_encode($genres);
    }

    public function getListVod()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        if($page != 0){
            $page = ($page-1) * $perPage;
        }
        $results = $this->Package_model->getListVod($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Package_model->getListVod($perPage, $page, $searchTerm, 'count');
        $data = array();
        foreach ($results as $row) {
            $data[] = array(
                "id" => $row['movie_id'],
                "text" => $row['movie_title']
            );
        }
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function getMultipleVod()
    {
        $ids = $this->input->post('ids');
        if (!is_array($ids)) {
            $ids = [$ids];
        }
        $genres = [];
        foreach ($ids as $id) {
            $group = $this->Package_model->getMultipleVod($id);
            if ($group) {
                $genres[] = [
                    'id' => $group->movie_id,
                    'text' => $group->movie_title
                ];
            }
        }
        echo json_encode($genres);
    }

    public function getListMovie()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        if($page != 0){
            $page = ($page-1) * $perPage;
        }
        $results = $this->Package_model->getListMovie($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Package_model->getListMovie($perPage, $page, $searchTerm, 'count');
        $data = array();
        foreach ($results as $row) {
            $data[] = array(
                "id" => $row['movie_id'],
                "text" => $row['movie_title']
            );
        }
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function getMultipleMovie()
    {
        $ids = $this->input->post('ids');
        if (!is_array($ids)) {
            $ids = [$ids];
        }
        $genres = [];
        foreach ($ids as $id) {
            $group = $this->Package_model->getMultipleMovie($id);
            if ($group) {
                $genres[] = [
                    'id' => $group->movie_id,
                    'text' => $group->movie_title
                ];
            }
        }
        echo json_encode($genres);
    }

    public function getListKeyword()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        if($page != 0){
            $page = ($page-1) * $perPage;
        }
        $results = $this->Package_model->getListKeyword($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Package_model->getListKeyword($perPage, $page, $searchTerm, 'count');
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

    public function getMultipleKeyword()
    {
        $ids = $this->input->post('ids');
        if (!is_array($ids)) {
            $ids = [$ids];
        }
        $genres = [];
        foreach ($ids as $id) {
            $group = $this->Package_model->getMultipleKeyword($id);
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
        $data['title'] = 'Add Package';
        
        $this->form_validation->set_rules('pkgtype', 'Type', 'required', ['required' => 'Type harus dipilih']);
        $this->form_validation->set_rules('affiliate', 'Affiliate', 'required', ['required' => 'Affiliate harus dipilih']);
        $this->form_validation->set_rules('title', 'Title', 'required', ['required' => 'Title harus diisi']);
        $this->form_validation->set_rules('description', 'Description', 'required', ['required' => 'Description harus diisi']);
        $this->form_validation->set_rules('price', 'List Price', 'required', ['required' => 'List Price harus diisi']);
        $this->form_validation->set_rules('price2', 'Sell Price', 'required', ['required' => 'Sell Price harus diisi']);
        $this->form_validation->set_rules('publish_date', 'Publish Date', 'required', ['required' => 'Publish Date harus dipilih']);

        if ($this->form_validation->run() == FALSE) {
            $data['selected_type'] = set_value('pkgtype');
            $data['selected_affiliate'] = set_value('affiliate');
            $data['selected_tv'] = $this->input->post('tv_id');
            $data['selected_vod'] = $this->input->post('vod_id');
            $data['selected_movie'] = $this->input->post('movie_id');
            $data['selected_category'] = $this->input->post('keyword');
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('packages/create', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $publishDate = $this->input->post('publish_date');
            $dates = explode(" to ", $publishDate);
            $start_date = $dates[0] . ' 00:00:00';
            $end_date = $dates[1] . ' 23:59:59';
            
            $tv_id = $this->input->post('tv_id');
            $tvId = "";
            if ($tv_id != null || $tv_id != "") {
                $tvId = ','.implode(",", $tv_id).',';
            }
            
            $vod_id = $this->input->post('vod_id');
            $vodId = "";
            if ($vod_id != null || $vod_id != "") {
                $vodId = ','.implode(",", $vod_id).',';
            }
            
            $movie_id = $this->input->post('movie_id');
            $movieId = "";
            if ($movie_id != null || $movie_id != "") {
                $movieId = ','.implode(",", $movie_id).',';
            }
            
            $keyword = $this->input->post('keyword');
            $keywordId = "";
            if ($keyword != null || $keyword != "") {
                $keywordId = ','.implode(",", $keyword).',';
            }
            
            $package_data = [
                'pkgtype' => (int) $this->input->post('pkgtype'),
                'affiliate' => $this->input->post('affiliate'),
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'price' => $this->input->post('price'),
                'price2' => $this->input->post('price2'),
                'date1' => $start_date,
                'date2' => $end_date,
                'optVod' => (int) $this->input->post('optVod'),
                'optTv' => (int) $this->input->post('optTv'),
                'tv_id' => $tvId,
                'vod_id' => $vodId,
                'movie_id' => $vodId,
                'keyword' => $keywordId,
                'update_date' => $time,
                'visible' => 'N'
            ];

            $saved = $this->Package_model->insertPackage($package_data);

            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Data berhasil disimpan</div>');
                return redirect('packages');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Data tidak berhasil disimpan</div>');
                return redirect('packages');
            }
        }
    }

    public function edit($id = null)
    {
        $CI =& get_instance();
        if (!$id) show_404();
        $packages = $this->Package_model->getPackageById($id);
        if (!$packages) show_404();
        $data['title'] = 'Edit Package';
        $data['packages'] = $packages;

        $this->form_validation->set_rules('pkgtype', 'Type', 'required', ['required' => 'Type harus dipilih']);
        $this->form_validation->set_rules('affiliate', 'Affiliate', 'required', ['required' => 'Affiliate harus dipilih']);
        $this->form_validation->set_rules('title', 'Title', 'required', ['required' => 'Title harus diisi']);
        $this->form_validation->set_rules('description', 'Description', 'required', ['required' => 'Description harus diisi']);
        $this->form_validation->set_rules('price', 'List Price', 'required', ['required' => 'List Price harus diisi']);
        $this->form_validation->set_rules('price2', 'Sell Price', 'required', ['required' => 'Sell Price harus diisi']);
        $this->form_validation->set_rules('publish_date', 'Publish Date', 'required', ['required' => 'Publish Date harus dipilih']);

        if ($this->form_validation->run() == FALSE) {
            $data['selected_type'] = set_value('pkgtype') ?: $packages['pkgtype'];
            $data['selected_affiliate'] = set_value('affiliate') ?: $packages['affiliate'];
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('packages/edit', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $publishDate = $this->input->post('publish_date');
            $dates = explode(" to ", $publishDate);
            $start_date = $dates[0] . ' 00:00:00';
            $end_date = $dates[1] . ' 23:59:59';
            
            $tv_id = $this->input->post('tv_id');
            $tvId = "";
            if ($tv_id != null || $tv_id != "") {
                $tvId = ','.implode(",", $tv_id).',';
            }
            
            $vod_id = $this->input->post('vod_id');
            $vodId = "";
            if ($vod_id != null || $vod_id != "") {
                $vodId = ','.implode(",", $vod_id).',';
            }
            
            $movie_id = $this->input->post('movie_id');
            $movieId = "";
            if ($movie_id != null || $movie_id != "") {
                $movieId = ','.implode(",", $movie_id).',';
            }
            
            $keyword = $this->input->post('keyword');
            $keywordId = "";
            if ($keyword != null || $keyword != "") {
                $keywordId = ','.implode(",", $keyword).',';
            }
            
            $package_data = [
                'pkgtype' => (int) $this->input->post('pkgtype'),
                'affiliate' => $this->input->post('affiliate'),
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'price' => $this->input->post('price'),
                'price2' => $this->input->post('price2'),
                'date1' => $start_date,
                'date2' => $end_date,
                'optVod' => (int) $this->input->post('optVod'),
                'optTv' => (int) $this->input->post('optTv'),
                'tv_id' => $tvId,
                'vod_id' => $vodId,
                'movie_id' => $vodId,
                'keyword' => $keywordId,
                'update_date' => $time
            ];

            $saved = $this->Package_model->updatePackage($id, $package_data);

            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Data berhasil diubah</div>'); 
                return redirect('packages');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Data tidak berhasil diubah</div>');
                return redirect('packages');
            }
        }
    }
}
