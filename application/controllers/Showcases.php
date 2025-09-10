<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Showcases extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user')) {
            redirect('auth');
        }
        if (!has_permission('view_showcases')) {
            show_error('Anda tidak memiliki akses ke halaman ini', 403, 'Forbidden');
        }
        $this->load->config('secure_config');
        $this->load->library('pagination');
        $this->load->library('libadapter');
        $this->load->model('Showcase_model');
    }

    private static $baseurlimage = 'http://showcase.dens.tv/assets/images/';

    public function index()
    {
        $data['title'] = 'List Showcase';
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('showcases/index', $data);
        $this->load->view('layouts/footer');
    }

    public function category_showcase()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }
        $results = $this->Showcase_model->category_showcase($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Showcase_model->category_showcase($perPage, $page, $searchTerm, 'count');
        $data = array();
        foreach ($results as $row) {
            $data[] = array(
                "id"=>$row['id'],
                "text"=>$row['category_name']
            );
        }
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function list_showcases($key_search=null, $sort_by='seq', $order_sort='desc', $visible='Y', $category, $rowperpage=10, $rowno=0)
    {
        if ($rowno != 0) {
            $rowno = ($rowno-1) * $rowperpage;
        }
        $allcount = $this->Showcase_model->getCountAll($key_search, $visible, $category);
        $users_record = $this->Showcase_model->getDatas($key_search, $sort_by, $order_sort, $visible, $category, $rowperpage, $rowno);
        // Pagination Configuration
        $config['base_url'] = base_url().'showcases/list_showcases/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$visible.'/'.$category.'/'.$rowperpage.'/'.$rowno;
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
                for ($count = 0;  $count < count($_POST["page_id_array"]); $count++) {
                   $query = "
                   UPDATE showcase 
                   SET sort = '".($count+1)."' 
                   WHERE visible = 'Y' AND id = '".$_POST["page_id_array"][$count]."'
                   ";
                   $data = $this->Showcase_model->update_sort($query);
                }
            }
        }
    }

    public function visible_showcase($id='')
    {
        if (!isset($id)) show_404();
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');
        $visible   = $this->Showcase_model->visible_showcase($id, $time);
        if ($visible == true) {
            $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Visible Showcase has been successfully!</div>');
            redirect(site_url('showcases'));
        } else {
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Visible Showcase is failed!</div>');
            redirect(site_url('showcases'));
        }
    }

    public function unvisible_showcase($id='')
    {
        if (!isset($id)) show_404();
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');
        $unvisible = $this->Showcase_model->unvisible_showcase($id, $time);
        if($unvisible == true) {
            $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Unvisible Showcase has been successfully!</div>');
            redirect(site_url('showcases'));
        } else {
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Unvisible Showcase is failed!</div>');
            redirect(site_url('showcases'));
        }
    }

    public function activated($id='')
    {
        if (!isset($id)) show_404();
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');
        $activated = $this->Showcase_model->activated_showcase($id, $time);
        if ($activated == true) {
            $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Activated Showcase has been successfully!</div>');
            redirect(site_url('showcases'));
        } else {
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Activated Showcase is failed!</div>');
            redirect(site_url('showcases'));
        }

    }

    public function inactivated($id='')
    {
        if (!isset($id)) show_404();
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');
        $inactived = $this->Showcase_model->inactivated_showcase($id, $time);
        if ($inactived == true) {
            $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Inactivated Showcase has been successfully!</div>');
            redirect(site_url('showcases'));
        } else {
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Inactivated Showcase is failed!</div>');
            redirect(site_url('showcases'));
        }

    }

    public function get_list_category()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }
        $results = $this->Showcase_model->get_list_category($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Showcase_model->get_list_category($perPage, $page, $searchTerm, 'count');
        $data = array();
        foreach ($results as $row) {
            $data[] = array(
                "id"=>$row['id'],
                "text"=>$row['category_name']
            );
        }
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function get_single_category()
    {
        $id = $this->input->post('id');
        $data = $this->Showcase_model->get_category_by_id($id);
        echo json_encode([
            'id' => $data->id,
            'text' => $data->title
        ]);
    }

    public function list_category_showcase($key_search=null, $sort_by='id', $order_sort='asc', $visible='Y', $rowperpage, $rowno=0)
    {
        // Row per page
        if ($rowperpage==null) {
            $rowperpage = 10;
        }
        // Row position
        if ($rowno != 0) {
            $rowno = ($rowno-1) * $rowperpage;
        }
        $key_search = urldecode($key_search);
        $allcount = $this->Showcase_model->getListCategoryCount($key_search,$visible);
        $users_record = $this->Showcase_model->getDataListCategory($rowno,$rowperpage,$order_sort,$sort_by,$key_search,$visible);
        $config['base_url'] = base_url().'movies/list_movie_keyword/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$visible.'/'.$rowperpage.'/'.$rowno;
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

    public function update_sort_category()
    {
        if (isset($_POST["action"])) {
            if ($_POST['action'] == 'update') {
                for ($count = 0;  $count < count($_POST["page_id_array"]); $count++) {
                   $query = "
                   UPDATE category_showcase 
                   SET sort = '".($count+1)."' 
                   WHERE visible = 'Y' AND id = '".$_POST["page_id_array"][$count]."'
                   ";
                   $data = $this->Showcase_model->update_sort_category($query);
                }
            }
        }
    }

    public function get_data_edit_category()
    {
        $id = $this->input->post('id',TRUE);
        $code = $this->Showcase_model->get_data_edit_category($id);
        if ($code!=null) {
            $data = $code;
        } else {
            die("Data not found");
        }
        echo json_encode($data);
    }

    public function cu_category()
    {
        $CI =& get_instance();
        $by = $CI->session->userdata('username');
        date_default_timezone_set("Asia/Jakarta");
        $time = date('Y-m-d H:i:s');
        $category_name = $this->input->post('category_name');
        $cat_id = $this->input->post('cat_id');
        if ($cat_id==null || $cat_id=="") {
            $cu = $this->Showcase_model->cu_category($cat_id,$category_name,$time,$by,'create');
        } else {
            $cu = $this->Showcase_model->cu_category($cat_id,$category_name,$time,$by,'update');
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

    public function activeCategoryConfirm($id='')
    {
        $id = $this->input->post('id');
        if (!isset($id)) show_404();
        $CI =& get_instance();
        $by = $CI->session->userdata('username');
        date_default_timezone_set("Asia/Jakarta");
        $time = date('Y-m-d H:i:s');
        $activated = $this->Showcase_model->activeCategoryConfirm($id, $time, $by);
        if ($activated == true) {
            $result = array(
                'error' => '0',
                'message' => 'success'
            );
        } else {
            $result = array(
                'error' => '1',
                'message' => 'failed'
            );
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function inactiveCategoryConfirm($id='')
    {
        $id = $this->input->post('id');
        if (!isset($id)) show_404();
        $CI =& get_instance();
        $by = $CI->session->userdata('username');
        date_default_timezone_set("Asia/Jakarta");
        $time = date('Y-m-d H:i:s');
        $inactived = $this->Showcase_model->inactiveCategoryConfirm($id, $time, $by);
        if ($inactived == true) {
            $result = array(
                'error' => '0',
                'message' => 'success'
            );
        } else {
            $result = array(
                'error' => '1',
                'message' => 'failed'
            );
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function create() {
        $CI =& get_instance();
        $data['title'] = 'Add Showcase';

        $this->form_validation->set_rules('poster_url', 'Image', 'required', ['required' => 'Image harus dipilih']);
        $this->form_validation->set_rules('category_id', 'Category', 'required', ['required' => 'Category harus dipilih']);
        $this->form_validation->set_rules('title', 'Title', 'required', ['required' => 'Title harus diisi']);
        $this->form_validation->set_rules('barcode_url', 'Barcode URL', 'required', ['required' => 'Barcode URL harus diisi']);
        $this->form_validation->set_rules('start_date', 'Start Date', 'required', ['required' => 'Start Date harus dipilih']);
        $this->form_validation->set_rules('end_date', 'End Date', 'required', ['required' => 'End Date harus dipilih']);

        if ($this->form_validation->run() == FALSE) {
            $data['selected_category'] = set_value('category_id');
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('showcases/create', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $showcase_data = [
                'category_id' => $this->input->post('category_id'),
                'title' => $this->input->post('title'),
                'barcode_url' => $this->input->post('barcode_url'),
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date'),
                'poster_url' => $this->input->post('poster_url'),
                'poster_type' => '1280x720',
                'visible' => 'N',
                'active' => 'N',
                'created_at' => $time,
                'created_by' => $CI->session->userdata('username'),
                'ctrloc' => '/showcases/create'
            ];
            $saved = $this->Showcase_model->insert_showcase($showcase_data);
            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Showcase berhasil disimpan</div>'); 
                return redirect('showcases');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Showcase tidak berhasil disimpan</div>');
                return redirect('showcases');
            }
        }
    }

    public function edit($id = null) {
        $CI =& get_instance();
        if (!$id) show_404();
        $showcase = $this->Showcase_model->get_showcase_by_id($id);
        if (!$showcase) show_404();
        $data['title'] = 'Edit Showcase';
        $data['showcase'] = $showcase[0];
        $this->form_validation->set_rules('poster_url', 'Image', 'required', ['required' => 'Image harus dipilih']);
        $this->form_validation->set_rules('category_id', 'Category', 'required', ['required' => 'Category harus dipilih']);
        $this->form_validation->set_rules('title', 'Title', 'required', ['required' => 'Title harus diisi']);
        $this->form_validation->set_rules('barcode_url', 'Barcode URL', 'required', ['required' => 'Barcode URL harus diisi']);
        $this->form_validation->set_rules('start_date', 'Start Date', 'required', ['required' => 'Start Date harus dipilih']);
        $this->form_validation->set_rules('end_date', 'End Date', 'required', ['required' => 'End Date harus dipilih']);
        if ($this->form_validation->run() == FALSE) {
            $data['selected_category'] = set_value('category_id') ?: $showcase[0]['category_id'];
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('showcases/edit', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $showcase_data = [
                'id' => $id,
                'category_id' => $this->input->post('category_id'),
                'title' => $this->input->post('title'),
                'barcode_url' => $this->input->post('barcode_url'),
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date'),
                'poster_url' => $this->input->post('poster_url'),
                'poster_type' => '1280x720',
                'created_at' => $time,
                'created_by' => $CI->session->userdata('username'),
                'ctrloc' => '/showcases/edit'
            ];
            $saved = $this->Showcase_model->update_showcase($showcase_data);
            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Showcase berhasil diubah</div>'); 
                return redirect('showcases');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Showcase tidak berhasil diubah</div>');
                return redirect('showcases');
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

    public function compare_image_showcase()
    {
        echo json_encode($this->get_image_showcase());
    }

    private function get_image_showcase()
    {
        $data = array();
        $_urlimage = array();
        //formed array from server
        $listimg = $this->libadapter->getShowcaseImages();
        if (!isset($listimg) || empty($listimg)) {
            $results = array(
                'error' => '1',
                'message' => 'failed',
                'content' => $data,
            );
        } else {
            //formed array from database
            $urlimage = $this->Showcase_model->getimagelandscape();
            if ($urlimage!=null) {
                foreach ($urlimage as $key => $value) {
                    array_push($_urlimage, self::$baseurlimage .  basename($value['poster_url']));
                }
            }
            $datas=array_values(array_diff($listimg,$_urlimage));
            $data = array_slice($datas,0,10);
            $results = array(
                'error' => '0',
                'message' => 'success',
                'content' => $data,
            );
        }
        return $results;
    }
}
