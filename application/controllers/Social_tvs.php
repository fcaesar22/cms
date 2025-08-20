<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Social_tvs extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user')) {
            redirect('auth');
        }
        if (!has_permission('view_socialtvs')) {
            show_error('Anda tidak memiliki akses ke halaman ini', 403, 'Forbidden');
        }
        $this->load->config('secure_config');
        $this->load->library('pagination');
        $this->load->library('libadapter');
        $this->load->model('Social_tv_model');
    }

    private static $baseurlimage = 'https://picture.dens.tv/';

    public function index()
    {
        $data['title'] = 'List Social TV';
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('social_tvs/index', $data);
        $this->load->view('layouts/footer');
    }

    public function list_social_tv($key_search=null, $sort_by='socialtv_id', $order_sort='desc', $visible='Y', $category, $rowperpage=10, $rowno=0)
    {
        if ($rowno != 0) {
            $rowno = ($rowno-1) * $rowperpage;
        }
        $allcount = $this->Social_tv_model->getCountAll($key_search, $visible, $category);
        $users_record = $this->Social_tv_model->getDatas($key_search, $sort_by, $order_sort, $visible, $category, $rowperpage, $rowno);
        // Pagination Configuration
        $config['base_url'] = base_url().'social_tvs/list_social_tv/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$visible.'/'.$category.'/'.$rowperpage.'/'.$rowno;
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

    public function activated_social_tv($id)
    {
        if (!isset($id)) show_404();
        if ($this->Social_tv_model->activated_social_tv($id)) {
            redirect(site_url('social_tvs'));
        }
    }

    public function inactivated_social_tv($id)
    {
        if (!isset($id)) show_404();
        if ($this->Social_tv_model->inactivated_social_tv($id)) {
            redirect(site_url('social_tvs'));
        }
    }

    public function get_content_type()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }
        $results = $this->Social_tv_model->get_content_type($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Social_tv_model->get_content_type($perPage, $page, $searchTerm, 'count');
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

    public function get_single_content_type()
    {
        $id = $this->input->post('id');
        $data = $this->Social_tv_model->get_content_type_by_id($id);
        echo json_encode([
            'id' => $data['id'],
            'text' => $data['title']
        ]);
    }

    public function get_list_category()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $category_id = $this->input->post('category_id');
        $perPage = 10;
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }
        $results = $this->Social_tv_model->get_list_category($perPage, $page, $searchTerm, $category_id, 'data');
        $countResults = $this->Social_tv_model->get_list_category($perPage, $page, $searchTerm, $category_id, 'count');
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

    public function get_multiple_category()
    {
        $ids = $this->input->post('ids');
        if (!is_array($ids)) {
            $ids = [$ids];
        }
        $genres = [];
        foreach ($ids as $id) {
            $group = $this->Social_tv_model->get_categories_by_id($id);
            if ($group) {
                $genres[] = [
                    'id' => $group->keyword_id,
                    'text' => $group->keyword_name
                ];
            }
        }
        echo json_encode($genres);
    }

    public function get_source()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }
        $results = $this->Social_tv_model->get_source($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Social_tv_model->get_source($perPage, $page, $searchTerm, 'count');
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

    public function get_single_source()
    {
        $id = $this->input->post('id');
        $data = $this->Social_tv_model->get_source_by_id($id);
        echo json_encode([
            'id' => $data['id'],
            'text' => $data['title']
        ]);
    }

    public function create()
    {
        $CI =& get_instance();
        $data['title'] = 'Add Social TV';
        $this->form_validation->set_rules('content_type', 'Content Type', 'required', ['required' => 'Content Type harus dipilih']);
        $this->form_validation->set_rules('category_social_tv[]', 'Category Social TV', 'required', ['required' => 'Category Social TV harus dipilih']);
        $this->form_validation->set_rules('source', 'Source', 'required', ['required' => 'Source harus dipilih']);
        $this->form_validation->set_rules('channel_id', 'Channel ID', 'required', ['required' => 'Channel ID harus diisi']);
        $this->form_validation->set_rules('title', 'Title', 'required', ['required' => 'Title harus diisi']);
        $this->form_validation->set_rules('description', 'Description', 'required', ['required' => 'Description harus diisi']);
        $this->form_validation->set_rules('poster_content1', 'Poster', 'required', ['required' => 'Poster harus diisi']);
        $this->form_validation->set_rules('poster_content2', 'Poster', 'required', ['required' => 'Poster harus diisi']);
        $this->form_validation->set_rules('poster_content3', 'Poster', 'required', ['required' => 'Poster harus diisi']);
        if ($this->form_validation->run() == FALSE) {
            $data['selected_content_type'] = set_value('content_type');
            $data['selected_category'] = $this->input->post('category_social_tv');
            $data['selected_source'] = set_value('source');
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('social_tvs/create', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $by = $CI->session->userdata('username');
            $content_type = $this->input->post('content_type',TRUE);
            $category_content = implode(",",$this->input->post('category_social_tv',TRUE));
            $id_cat = ',' . $content_type . ',' . $category_content . ',';
            $poster_content1 = $this->input->post('poster_content1',TRUE);
            $poster_content2 = $this->input->post('poster_content2',TRUE);
            $poster_content3 = $this->input->post('poster_content3',TRUE);
            $socialtv_data = [
                'socialtv_name' => $this->input->post('title',TRUE),
                'description' => $this->input->post('description', TRUE),
                'channel_id' => $this->input->post('channel_id', TRUE),
                'source' => $this->input->post('source', TRUE),
                'sortid' => '1',
                'visible' => 'N',
                'keyword_parent_id' => $id_cat,
                'created_at' => $time,
                'created_by' => $by,
                'updated_at' => $time,
                'updated_by' => $by,
                'ctrloc' => '/social_tvs/create'
            ];
            $saved = $this->Social_tv_model->insert_social_tv($socialtv_data,$poster_content1,$poster_content2,$poster_content3,$time);
            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Social TV berhasil disimpan</div>'); 
                return redirect('social_tvs');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Social TV tidak berhasil disimpan</div>');
                return redirect('social_tvs');
            }
        }
    }

    public function edit($id = null) {
        $CI =& get_instance();
        if (!$id) show_404();
        $socialtv = $this->Social_tv_model->get_social_tv_by_id($id);
        if (!$socialtv) show_404();
        $data['title'] = 'Edit Social TV';
        $data['socialtv'] = $socialtv;
        $this->form_validation->set_rules('content_type', 'Content Type', 'required', ['required' => 'Content Type harus dipilih']);
        $this->form_validation->set_rules('category_social_tv[]', 'Category Social TV', 'required', ['required' => 'Category Social TV harus dipilih']);
        $this->form_validation->set_rules('source', 'Source', 'required', ['required' => 'Source harus dipilih']);
        $this->form_validation->set_rules('channel_id', 'Channel ID', 'required', ['required' => 'Channel ID harus diisi']);
        $this->form_validation->set_rules('title', 'Title', 'required', ['required' => 'Title harus diisi']);
        $this->form_validation->set_rules('description', 'Description', 'required', ['required' => 'Description harus diisi']);
        $this->form_validation->set_rules('poster_content1', 'Poster', 'required', ['required' => 'Poster harus diisi']);
        $this->form_validation->set_rules('poster_content2', 'Poster', 'required', ['required' => 'Poster harus diisi']);
        $this->form_validation->set_rules('poster_content3', 'Poster', 'required', ['required' => 'Poster harus diisi']);
        if ($this->form_validation->run() == FALSE) {
            $data['selected_content_type'] = set_value('content_type') ?: $socialtv['content_id'];
            $data['selected_category'] = $this->input->post('category_social_tv') ?: array_column($socialtv['categories'], 'category_id');
            $data['selected_source'] = set_value('source') ?: $socialtv['source_id'];
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('social_tvs/edit', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta");
            $time = date('Y-m-d H:i:s');
            $by = $CI->session->userdata('username');
            $socialtv_name = $this->input->post('title',TRUE);
            $description = $this->input->post('description', TRUE);
            $channel_id = $this->input->post('channel_id', TRUE);
            $source = $this->input->post('source', TRUE);
            $content_type = $this->input->post('content_type',TRUE);
            $category_content = implode(",",$this->input->post('category_social_tv',TRUE));
            $keyword_parent_id = ','.$content_type.','.$category_content.',';
            $poster_content1 = $this->input->post('poster_content1',TRUE);
            $poster_content2 = $this->input->post('poster_content2',TRUE);
            $poster_content3 = $this->input->post('poster_content3',TRUE);
            $poster_id1 = $this->input->post('poster_id1',TRUE);
            $poster_id2 = $this->input->post('poster_id2',TRUE);
            $poster_id3 = $this->input->post('poster_id3',TRUE);
            $saved = $this->Social_tv_model->update_social_tv($id,$time,$by,$socialtv_name,$description,$channel_id,$source,$content_type,$keyword_parent_id,$poster_content1,$poster_content2,$poster_content3,$poster_id1,$poster_id2,$poster_id3);
            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Social TV berhasil diubah</div>'); 
                return redirect('social_tvs');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Social TV tidak berhasil diubah</div>');
                return redirect('social_tvs');
            }
        }
    }

    public function list_category_social_tv($key_search=null, $sort_by='keyword_name', $order_sort='asc', $visible='Y', $contentid, $rowno=0)
    {
        // Row per page
        $rowperpage = 10;
        // Row position
        if ($rowno != 0) {
            $rowno = ($rowno-1) * $rowperpage;
        }
        if ($contentid == 'null') {
            $contentid='246';
        }
        switch ($contentid) {
            case '246':
                $keyword_refer='SDL';
                break;
            case '247':
                $keyword_refer='SCV';
                break;
            case '325':
                $keyword_refer='SDK';
                break;
            case '1076':
                $keyword_refer='SDP';
                break;
            case '1077':
                $keyword_refer='SDM';
                break;
            default:
                $keyword_refer='SDL';
                break;
        }
        if ($sort_by == 'null') {
            $sort_by='keyword_id';
        }
        if ($order_sort == 'null') {
            $order_sort='asc';
        }
        $key_search = urldecode($key_search);
        // All records count
        $allcount = $this->Social_tv_model->getListCategoryCount($key_search,$visible,$contentid,$keyword_refer);
        // Get  records
        $users_record = $this->Social_tv_model->getDataListCategory($rowno,$rowperpage,$order_sort,$sort_by,$key_search,$visible,$contentid,$keyword_refer);
        // Pagination Configuration
        $config['base_url'] = base_url().'social_tvs/list_category_social_tv/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$visible.'/'.'/'.$contentid.'/'.$rowno;
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

    public function save_category()
    {
        $this->form_validation->set_rules('keyword_name', 'Category name', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            alert('silahkan isi category!');
        } else {
            $keyword_ref = $this->input->post('idcontent');
            if ($keyword_ref==246) {
                $keyword_refer='SDL';
            }
            if ($keyword_ref==247) {
                $keyword_refer='SCV';
            }
            if ($keyword_ref==325) {
                $keyword_refer='SDK';
            }
            if ($keyword_ref==1076) {
                $keyword_refer='SDP';
            }
            if ($keyword_ref==1077) {
                $keyword_refer='SDM';
            }
            $keyword_name = $this->input->post('keyword_name');
            if ($keyword_name != null) {
                $data = array(
                    'keyword_name'     => $keyword_name,
                    'keyword_sort'     => '1',
                    'keyword_child'    => 'SIN',
                    'keyword_sub'      => 'N',
                    'keyword_ref'      => $keyword_refer,
                    'keyword_visible'  => 'Y',
                    'keyword_parentid' => ','.$keyword_ref.','
                );
                $insert = $this->Social_tv_model->save_category($data);
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
    }

    public function get_data_edit_category()
    {
        $id = $this->input->post('id',TRUE);
        $socialtv = $this->Social_tv_model->get_data_edit_category($id);
        if ($socialtv!=null) {
            $data = $socialtv;
        } else {
            die("Data not found");
        }
        echo json_encode($data);
    }

    public function edit_category()
    {
        $keyword_id = $this->input->post('keyword_id');
        $keyword_name = $this->input->post('keyword_name');
        $update = $this->Social_tv_model->edit_category($keyword_id,$keyword_name);
        if ($update==true) {
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

    public function active_category()
    {
        $id = $this->input->post('id');
        $inactive = $this->Social_tv_model->active_category($id);
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

    public function inactive_category()
    {
        $id = $this->input->post('id');
        $inactive = $this->Social_tv_model->inactive_category($id);
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
        $path = 'wp/img/socialtv_v1/1280x720/';
        $changeDir = 'wp/img/socialtv_v1/1280x720/';
        $listimg = $this->libadapter->getImages($path, $changeDir);
        if ($listimg['error'] == 0) {
            $_arrFolder = array();
            $listimg1 = $listimg['content'];
            foreach ($listimg1 as $key => $value) {
                $_arrFolder[] = $value['url'];
            }
            krsort($_arrFolder);
            //formed array from database
            $urlimage = $this->Social_tv_model->getimagelandscape();
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
