<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \phpseclib\Net\SFTP;

class Whatsons extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user')) {
            redirect('auth');
        }
        if (!has_permission('view_whatsons')) {
            show_error('Anda tidak memiliki akses ke halaman ini', 403, 'Forbidden');
        }
        $this->load->config('secure_config');
        $this->load->library('pagination');
        $this->load->library('libadapter');
        $this->load->model('Whatson_model');
    }

    private static $baseurlimage = 'https://picture.dens.tv/wp/';

    public function index()
    {
        $data['title'] = 'What\'s On';
        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('whatson/index', $data);
        $this->load->view('layouts/footer');
    }

    public function list_whatsons($key_search=null, $sort_by='id', $order_sort='asc', $visible='0', $rowperpage=10, $rowno=0)
    {
        if ($rowno != 0) {
            $rowno = ($rowno-1) * $rowperpage;
        }
        
        $allcount = $this->Whatson_model->getCountAll($key_search, $visible);

        $users_record = $this->Whatson_model->getDatas($key_search, $sort_by, $order_sort, $visible, $rowperpage, $rowno);
        
        // Pagination Configuration
        $config['base_url'] = base_url().'whatson/list_whatsons/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$visible.'/'.$rowperpage.'/'.$rowno;
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
        $results = $this->Whatson_model->get_list_category($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Whatson_model->get_list_category($perPage, $page, $searchTerm, 'count');
        $data = array();
        foreach ($results as $row) {
            $data[] = array(
                "id"=>$row['category_whatson_id'],
                "text"=>$row['category_whatson_name']
            );
        }
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function get_single_category()
    {
        $id = $this->input->post('id');
        $data = $this->Whatson_model->get_category_by_id($id);
        echo json_encode([
            'id' => $data->id,
            'text' => $data->title
        ]);
    }

    public function get_list_subcategory()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }
        $results = $this->Whatson_model->get_list_subcategory($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Whatson_model->get_list_subcategory($perPage, $page, $searchTerm, 'count');
        $data = array();
        foreach ($results as $row) {
            $data[] = array(
                "id"=>$row['sub_category_whatson_id'],
                "text"=>$row['sub_category_whatson_name']
            );
        }
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function get_single_sub_category()
    {
        $id = $this->input->post('id');
        $data = $this->Whatson_model->get_sub_category_by_id($id);
        echo json_encode([
            'id' => $data->id,
            'text' => $data->title
        ]);
    }

    public function get_list_channel()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }
        $results = $this->Whatson_model->get_list_channel($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Whatson_model->get_list_channel($perPage, $page, $searchTerm, 'count');
        $data = array();
        foreach ($results as $row) {
            $data[] = array(
                "id"=>$row['channel_whatson_id'],
                "text"=>$row['channel_whatson_name']
            );
        }
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function get_single_channel()
    {
        $id = $this->input->post('id');
        $data = $this->Whatson_model->get_channel_by_id($id);
        echo json_encode([
            'id' => $data->id,
            'text' => $data->title
        ]);
    }

    public function get_list_thumbnail()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }
        $results = $this->Whatson_model->get_list_thumbnail($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Whatson_model->get_list_thumbnail($perPage, $page, $searchTerm, 'count');
        $data = array();
        foreach ($results as $row) {
            $data[] = array(
                "id"=>$row['thumbnail_whatson_id'],
                "text"=>$row['thumbnail_whatson_name']
            );
        }
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function get_single_thumbnail()
    {
        $id = $this->input->post('id');
        $data = $this->Whatson_model->get_thumbnail_by_id($id);
        echo json_encode([
            'id' => $data->id,
            'text' => $data->title
        ]);
    }

    public function create() {
        $data['title'] = 'Add What\'s On';

        $this->form_validation->set_rules('whatson_title', 'Title', 'required', ['required' => 'Title harus diisi']);
        $this->form_validation->set_rules('whatson_description', 'Description', 'required', ['required' => 'Description harus diisi']);
        $this->form_validation->set_rules('whatson_image', 'Image Landscape', 'required', ['required' => 'Image Landscape harus diisi']);
        $this->form_validation->set_rules('whatson_image_potrait', 'Image Potrait', 'required', ['required' => 'Image Potrait harus diisi']);
        $this->form_validation->set_rules('whatson_type', 'Type', 'required', ['required' => 'Type harus dipilih']);
        $this->form_validation->set_rules('category_whatson', 'Category', 'required', ['required' => 'Category harus dipilih']);
        $this->form_validation->set_rules('sub_category_whatson', 'Sub Category', 'required', ['required' => 'Sub Category harus dipilih']);
        $this->form_validation->set_rules('channel_whatson', 'Channel', 'required', ['required' => 'Channel harus dipilih']);
        $this->form_validation->set_rules('thumbnail_whatson', 'Thumbnail', 'required', ['required' => 'Thumbnail harus dipilih']);
        $this->form_validation->set_rules('content_id', 'Content ID', 'required', ['required' => 'Content ID harus diisi']);
        $this->form_validation->set_rules('whatson_schedule', 'Schedule', 'required', ['required' => 'Schedule harus dipilih']);

        if ($this->form_validation->run() == FALSE) {
            $data['selected_category'] = set_value('category_whatson');
            $data['selected_sub_category'] = set_value('sub_category_whatson');
            $data['selected_channel'] = set_value('channel_whatson');
            $data['selected_thumbnail'] = set_value('thumbnail_whatson');
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('whatson/create', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $whatson_data = [
                'whatson_title' => $this->input->post('whatson_title', TRUE),
                'whatson_description' => $this->input->post('whatson_description', TRUE),
                'whatson_image' => basename($this->input->post('whatson_image', TRUE)),
                'whatson_image_potrait' => $this->input->post('whatson_image_potrait', TRUE),
                'content_url_image' => 'https://picture.dens.tv/wp/img/whatson_v2/1280x720/'.basename($this->input->post('whatson_image', TRUE)),
                'category_whatson_id' => $this->input->post('category_whatson', TRUE),
                'sub_category_whatson_id' => $this->input->post('sub_category_whatson', TRUE),
                'channel_whatson_id' => $this->input->post('channel_whatson', TRUE),
                'thumbnail_whatson_id' => $this->input->post('thumbnail_whatson', TRUE),
                'content_id' => $this->input->post('content_id', TRUE),
                'whatson_schedule_time' => $this->input->post('whatson_schedule', TRUE),
                'link_url' => $this->input->post('link_goto', TRUE),
                'whatson_video' => $this->input->post('whatson_video', TRUE),
                'whatson_type' => $this->input->post('whatson_type', TRUE),
                'content_url' => 'http://stage.dens.tv/whatson/highlight',
                'deleted' => '0',
                'whatson_purpose' => '0',
                'is_pinned' => '0',
                'created_date_whatson' => $time
            ];
            $saved = $this->Whatson_model->insert_whatson($whatson_data);
            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Whats On berhasil disimpan</div>'); 
                return redirect('whatsons');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Whats On tidak berhasil disimpan</div>');
                return redirect('whatsons');
            }
        }
    }

    public function edit($id = null) {
        if (!$id) show_404();
        $whatson = $this->Whatson_model->get_whatson_by_id($id);
        if (!$whatson) show_404();

        $data['title'] = 'Edit What\'s On';
        $data['whatson'] = $whatson;

        $this->form_validation->set_rules('whatson_title', 'Title', 'required', ['required' => 'Title harus diisi']);
        $this->form_validation->set_rules('whatson_description', 'Description', 'required', ['required' => 'Description harus diisi']);
        $this->form_validation->set_rules('whatson_image', 'Image Landscape', 'required', ['required' => 'Image Landscape harus diisi']);
        $this->form_validation->set_rules('whatson_image_potrait', 'Image Potrait', 'required', ['required' => 'Image Potrait harus diisi']);
        $this->form_validation->set_rules('whatson_type', 'Type', 'required', ['required' => 'Type harus dipilih']);
        $this->form_validation->set_rules('category_whatson', 'Category', 'required', ['required' => 'Category harus dipilih']);
        $this->form_validation->set_rules('sub_category_whatson', 'Sub Category', 'required', ['required' => 'Sub Category harus dipilih']);
        $this->form_validation->set_rules('channel_whatson', 'Channel', 'required', ['required' => 'Channel harus dipilih']);
        $this->form_validation->set_rules('thumbnail_whatson', 'Thumbnail', 'required', ['required' => 'Thumbnail harus dipilih']);
        $this->form_validation->set_rules('content_id', 'Content ID', 'required', ['required' => 'Content ID harus diisi']);
        $this->form_validation->set_rules('whatson_schedule', 'Schedule', 'required', ['required' => 'Schedule harus dipilih']);

        if ($this->form_validation->run() == FALSE) {
            $data['selected_category'] = set_value('category_whatson');
            $data['selected_sub_category'] = set_value('sub_category_whatson');
            $data['selected_channel'] = set_value('channel_whatson');
            $data['selected_thumbnail'] = set_value('thumbnail_whatson');
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('whatson/edit', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $whatson_data = [
                'whatson_id' => $id,
                'whatson_title' => $this->input->post('whatson_title', TRUE),
                'whatson_description' => $this->input->post('whatson_description', TRUE),
                'whatson_image' => basename($this->input->post('whatson_image', TRUE)),
                'whatson_image_potrait' => $this->input->post('whatson_image_potrait', TRUE),
                'content_url_image' => 'http://picture.dens.tv/wp/img/whatson_v2/1280x720/'.basename($this->input->post('whatson_image', TRUE)),
                'category_whatson_id' => $this->input->post('category_whatson', TRUE),
                'sub_category_whatson_id' => $this->input->post('sub_category_whatson', TRUE),
                'channel_whatson_id' => $this->input->post('channel_whatson', TRUE),
                'thumbnail_whatson_id' => $this->input->post('thumbnail_whatson', TRUE),
                'content_id' => $this->input->post('content_id', TRUE),
                'whatson_schedule_time' => $this->input->post('whatson_schedule', TRUE),
                'link_url' => $this->input->post('link_goto', TRUE),
                'whatson_video' => $this->input->post('whatson_video', TRUE),
                'whatson_type' => $this->input->post('whatson_type', TRUE)
            ];

            $saved = $this->Whatson_model->update_whatson($whatson_data);

            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Whats On berhasil diubah</div>'); 
                return redirect('whatsons');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Whats On tidak berhasil diubah</div>');
                return redirect('whatsons');
            }
        }
    }

    public function activated_whatson($id)
    {
        if (!isset($id)) show_404();
        
        if ($this->Whatson_model->activated_whatson($id)) {
            redirect(site_url('whatsons'));
        }
    }

    public function inactivated_whatson($id)
    {
        if (!isset($id)) show_404();
        
        if ($this->Whatson_model->inactivated_whatson($id)) {
            redirect(site_url('whatsons'));
        }
    }

    public function activated_banner($id)
    {
        if (!isset($id)) show_404();
        
        if ($this->Whatson_model->activated_banner($id)) {
            redirect(site_url('whatsons'));
        }
    }

    public function inactivated_banner($id)
    {
        if (!isset($id)) show_404();
        
        if ($this->Whatson_model->inactivated_banner($id)) {
            redirect(site_url('whatsons'));
        }
    }

    public function pinbanner($id)
    {
        if (!isset($id)) show_404();
        
        if ($this->Whatson_model->pinbanner($id)) {
            redirect(site_url('whatsons'));
        }
    }

    public function unpinbanner($id)
    {
        if (!isset($id)) show_404();
        
        if ($this->Whatson_model->unpinbanner($id)) {
            redirect(site_url('whatsons'));
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
        $path = 'img/whatson_v2/1280x720/';
        $changeDir = 'wp/img/whatson_v2/1280x720/';
        $listimg = $this->libadapter->getImages($path, $changeDir);
        if ($listimg['error'] == 0) {
            $_arrFolder = array();
            $listimg1 = $listimg['content'];
            foreach ($listimg1 as $key => $value) {
                $_arrFolder[] = $value['url'];
            }
            krsort($_arrFolder);

            //formed array from database
            $urlimage = $this->Whatson_model->getimagelandscape();
            if ($urlimage!=null) {
                foreach ($urlimage as $key => $value) {
                    array_push($_urlimage, self::$baseurlimage . 'img/whatson_v2/1280x720/' . basename($value['whatson_image']));
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
        $path = 'img/whatson_v2/375x375/';
        $changeDir = 'wp/img/whatson_v2/375x375/';
        $listimg = $this->libadapter->getImages($path, $changeDir);
        if ($listimg['error'] == 0) {
            $_arrFolder = array();
            $listimg1 = $listimg['content'];
            foreach ($listimg1 as $key => $value) {
                $_arrFolder[] = $value['url'];
            }
            krsort($_arrFolder);

            //formed array from database
            $urlimage = $this->Whatson_model->getimageportrait();
            if ($urlimage!=null) {
                foreach ($urlimage as $key => $value) {
                    array_push($_urlimage, self::$baseurlimage . 'img/whatson_v2/375x375/' . basename($value['whatson_image_potrait']));
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

    public function list_category_whatson($key_search=null,$sort_by='category_whatson_name', $order_sort='asc', $table, $rowno=0)
    {
        // Row per page
        $rowperpage = 10;

        // Row position
        if ($rowno != 0) {
            $rowno = ($rowno-1) * $rowperpage;
        }

        if ($sort_by == 'null') {
            $sort_by='category_whatson_id';
        }

        if ($order_sort == 'null') {
            $order_sort='asc';
        }
        
        // All records count
        $allcount = $this->Whatson_model->getListCategoryCount($key_search,$table);

        // Get  records
        $users_record = $this->Whatson_model->getDataListCategory($rowno,$rowperpage,$order_sort,$sort_by,$key_search,$table);
        
        // Pagination Configuration
        $config['base_url'] = base_url().'whatson/list_category_whatson/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$table.'/'.$rowno;
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

    public function add_category()
    {
        $post = $this->input->post();
        $table = $post['table_info'];
        $data = array_diff($post, array('table_info'=>$table));

        $insert = $this->Whatson_model->add_category($data, $table);
        if ($insert==true) {
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

    public function get_data_edit_category()
    {
        $id = $this->input->post('id',TRUE);
        $name = $this->input->post('name',TRUE);
        $desc = $this->input->post('desc',TRUE);
        $seq = $this->input->post('seq',TRUE);
        $table = $this->input->post('table',TRUE);
        $whatson = $this->Whatson_model->get_data_edit_category($id,$name,$desc,$seq,$table);
        if ($whatson!=null) {
            if ($table=='channel_whatson') {
                $data = array(
                    $seq => $whatson[0]->$seq,
                    $name => $whatson[0]->$name,
                    $desc => $whatson[0]->$desc,
                    'channel_whatson_logo' => $whatson[0]->channel_whatson_logo
                );
            } else {
                $data = array(
                    $seq => $whatson[0]->$seq,
                    $name => $whatson[0]->$name,
                    $desc => $whatson[0]->$desc
                );
            }
        } else {
            die("Data not found");
        }
        echo json_encode($data);
    }

    public function edit_category()
    {
        $post = $this->input->post();
        $table = $post['table_info'];
        $img = null;
        $val_img = null;
        if ($table=='category_whatson') {
            $name = 'category_whatson_name';
            $val_name = $post['category_whatson_name'];
            $desc = 'category_whatson_description';
            $val_desc = $post['category_whatson_description'];
            $seq = 'category_whatson_id';
            $val_seq = $post['category_whatson_id'];
        } elseif ($table=='sub_category_whatson') {
            $name = 'sub_category_whatson_name';
            $val_name = $post['sub_category_whatson_name'];
            $desc = 'sub_category_whatson_description';
            $val_desc = $post['sub_category_whatson_description'];
            $seq = 'sub_category_whatson_id';
            $val_seq = $post['sub_category_whatson_id'];
        } elseif ($table=='channel_whatson') {
            $name = 'channel_whatson_name';
            $val_name = $post['channel_whatson_name'];
            $desc = 'channel_whatson_description';
            $val_desc = $post['channel_whatson_description'];
            $img = 'channel_whatson_logo';
            $val_img = $post['channel_whatson_logo'];
            $seq = 'channel_whatson_id';
            $val_seq = $post['channel_whatson_id'];
        }

        $insert = $this->Whatson_model->edit_category($name, $val_name, $desc, $val_desc, $img, $val_img, $seq, $val_seq, $table);
        if ($insert==true) {
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
        $field = $this->input->post('field');
        $table = $this->input->post('table');

        $inactive = $this->Whatson_model->inactive_category($id,$field,$table);
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
}
