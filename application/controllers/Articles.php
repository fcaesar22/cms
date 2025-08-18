<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Articles extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user')) {
            redirect('auth');
        }
        if (!has_permission('view_articles')) {
            show_error('Anda tidak memiliki akses ke halaman ini', 403, 'Forbidden');
        }
        $this->load->config('secure_config');
        $this->load->library('pagination');
        $this->load->library('libadapter');
        $this->load->model('Article_model');
        $this->url_image1='https://picture.dens.tv/wp/img/denslife_v1/1280x720/';
        $this->url_image2='https://picture.dens.tv/wp/img/denslife_v1/1280x720/thumbnail/';
    }

    private static $baseurlimage = 'https://picture.dens.tv/';

    public function index()
    {
        $data['title'] = 'List Articles';
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('articles/index', $data);
        $this->load->view('layouts/footer');
    }

    public function list_articles($key_search=null, $sort_by='article_id', $order_sort='desc', $visible='Y', $category, $rowperpage=10, $rowno=0)
    {
        if ($rowno != 0) {
            $rowno = ($rowno-1) * $rowperpage;
        }
        
        $allcount = $this->Article_model->getCountAll($key_search, $visible, $category);

        $users_record = $this->Article_model->getDatas($key_search, $sort_by, $order_sort, $visible, $category, $rowperpage, $rowno);
        
        // Pagination Configuration
        $config['base_url'] = base_url().'articles/list_articles/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$visible.'/'.$category.'/'.$rowperpage.'/'.$rowno;
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

    public function activated_article($id)
    {
        if (!isset($id)) show_404();
        
        if ($this->Article_model->activated_article($id)) {
            redirect(site_url('articles'));
        }
    }

    public function inactivated_article($id)
    {
        if (!isset($id)) show_404();
        
        if ($this->Article_model->inactivated_article($id)) {
            redirect(site_url('articles'));
        }
    }

    public function viewpdf($id)
    {
        $article = $this->Article_model->get_products_by_id($id);
        if ($article!=null) {
            $data = array(
                'article_title' => $article[0]['article_title'],
                'article_by' => $article[0]['article_by'],
                'article_content_1' => $article[0]['article_content_1'],
                'article_content_2' => $article[0]['article_content_2'],
                'poster_url' => $article[0]['poster_url'],
                'poster' => $this->Article_model->get_poster_by_id($id)
            );
            $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];

            $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];

            try {
                $mpdf = new \Mpdf\Mpdf([
                    'tempDir' => FCPATH."uploads/tmp/", // uses the current directory's parent "tmp" subfolder
                    'setAutoTopMargin' => 'stretch',
                    'margin_footer' => 0,
                    'default_font' => 'montserrat'
                ]);
                $html = $this->load->view('articles/pdf_view',$data,true);
                $pdfFilePath =$article[0]['article_id'].".pdf";
                // $mpdf->SetHTMLHeader('<img src="' . base_url() . 'assets/img/header.png"/>');
                // $mpdf->SetHTMLFooter('<img src="' . base_url() . 'assets/img/footer.png"/>');
                $mpdf->AddPage(
                    '',
                    '',
                    '',
                    '',
                    '',
                    15, // margin_left
                    15, // margin right
                    35, // margin top
                    40, // margin bottom
                    0, // margin header
                    0 // margin footer
                );
                $mpdf->SetDefaultBodyCSS('background', 'url("' . base_url('assets/img/denslife2.png') . '")');
                $mpdf->SetDefaultBodyCSS('background-image-resize', 6);
                $mpdf->WriteHTML($html);
                $mpdf->Output(); // opens in browser
                $mpdf->Output(FCPATH.'uploads/pdf/'.$pdfFilePath,'F'); // it downloads the file into the user system, with give name
                $data = array(
                    'pdf_url' => base_url().'uploads/pdf/'.$pdfFilePath,
                    'article_id' => $article[0]['article_id']
                );
                $insert = $this->Article_model->insert_pdf($data);
                echo json_encode(array("status" => TRUE));
            } catch (\Mpdf\MpdfException $e) {
                print "Creating an mPDF object failed with" . $e->getMessage();
            }
        } else {
            die("Data not found");
        }
    }

    public function get_content_type()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        if($page != 0){
            $page = ($page-1) * $perPage;
        }
        $results = $this->Article_model->get_content_type($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Article_model->get_content_type($perPage, $page, $searchTerm, 'count');
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
        $data = $this->Article_model->get_content_type_by_id($id);
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
        if($page != 0){
            $page = ($page-1) * $perPage;
        }
        $results = $this->Article_model->get_list_category($perPage, $page, $searchTerm, $category_id, 'data');
        $countResults = $this->Article_model->get_list_category($perPage, $page, $searchTerm, $category_id, 'count');
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
            $group = $this->Article_model->get_categories_by_id($id);
            if ($group) {
                $genres[] = [
                    'id' => $group->keyword_id,
                    'text' => $group->keyword_name
                ];
            }
        }
        echo json_encode($genres);
    }

    public function get_tags()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        if($page != 0){
            $page = ($page-1) * $perPage;
        }
        $results = $this->Article_model->get_tags($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Article_model->get_tags($perPage, $page, $searchTerm, 'count');
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
            $group = $this->Article_model->get_tags_by_id($id);
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
        $data['title'] = 'Add Article';

        $this->form_validation->set_rules('content_type', 'Content Type', 'required', ['required' => 'Content Type harus dipilih']);
        $this->form_validation->set_rules('category_article[]', 'Category Article', 'required', ['required' => 'Category Article harus dipilih']);
        $this->form_validation->set_rules('tags_article[]', 'Tag Article', 'required', ['required' => 'Tag Article harus dipilih']);
        $this->form_validation->set_rules('title', 'Title', 'required', ['required' => 'Title harus diisi']);
        $this->form_validation->set_rules('article_by', 'By', 'required', ['required' => 'By harus diisi']);
        $this->form_validation->set_rules('summary', 'Summary', 'required', ['required' => 'Summary harus diisi']);

        if ($this->form_validation->run() == FALSE) {
            $data['selected_content_type'] = set_value('content_type');
            $data['selected_category'] = $this->input->post('category_article');
            $data['selected_tag'] = $this->input->post('tags_article');
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('articles/create', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $article_data = [
                'kategori_id' => ','.implode(",",$this->input->post('category_article',TRUE)).',',
                'tags' => ','.implode(",",$this->input->post('tags_article',TRUE)).',',
                'article_title' => $this->input->post('title',TRUE),
                'article_by' => $this->input->post('article_by',TRUE),
                'article_summary' => $this->input->post('summary',TRUE),
                'url_google_maps' => $this->input->post('url_maps',TRUE),
                'created_at' => $time,
                'created_by' => $CI->session->userdata('username'),
                'updated_at' => $time,
                'updated_by' => $CI->session->userdata('username'),
                'ctrloc' => '/articles/create'
            ];
            $saved = $this->Article_model->insert_article($article_data);
            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Article berhasil disimpan</div>'); 
                return redirect('articles/create_edit_article_content/'.$saved);
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Article tidak berhasil disimpan</div>');
                return redirect('articles');
            }
        }
    }

    public function edit($id = null) {
        $CI =& get_instance();
        if (!$id) show_404();
        $article = $this->Article_model->get_article_by_id($id);
        if (!$article) show_404();

        $data['title'] = 'Edit Article';
        $data['article'] = $article;

        $this->form_validation->set_rules('content_type', 'Content Type', 'required', ['required' => 'Content Type harus dipilih']);
        $this->form_validation->set_rules('category_article[]', 'Category Article', 'required', ['required' => 'Category Article harus dipilih']);
        $this->form_validation->set_rules('tags_article[]', 'Tag Article', 'required', ['required' => 'Tag Article harus dipilih']);
        $this->form_validation->set_rules('title', 'Title', 'required', ['required' => 'Title harus diisi']);
        $this->form_validation->set_rules('article_by', 'By', 'required', ['required' => 'By harus diisi']);
        $this->form_validation->set_rules('summary', 'Summary', 'required', ['required' => 'Summary harus diisi']);

        if ($this->form_validation->run() == FALSE) {
            $data['selected_movie_code'] = set_value('movie_code');
            $data['selected_movie_parent'] = set_value('movie_parent');
            $data['selected_movie_parent_id'] = set_value('movie_parent_id');
            $data['selected_group_keyword'] = $this->input->post('group_keyword');
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('articles/edit', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $article_data = [
                'article_id' => $id,
                'kategori_id' => ','.implode(",",$this->input->post('category_article',TRUE)).',',
                'tags' => ','.implode(",",$this->input->post('tags_article',TRUE)).',',
                'article_title' => $this->input->post('title',TRUE),
                'article_by' => $this->input->post('article_by',TRUE),
                'article_summary' => $this->input->post('summary',TRUE),
                'url_google_maps' => $this->input->post('url_maps',TRUE),
                'updated_at' => $time,
                'updated_by' => $CI->session->userdata('username'),
                'ctrloc' => '/articles/create'
            ];
            $saved = $this->Article_model->update_article($article_data);
            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Article berhasil diubah</div>'); 
                return redirect('articles/create_edit_article_content/'.$id);
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Article tidak berhasil diubah</div>');
                return redirect('articles');
            }
        }
    }

    public function list_category_article($key_search=null, $sort_by='keyword_name', $order_sort='asc', $visible='Y', $contentid, $rowno=0)
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

        $keyword_refer='ARC';

        if ($sort_by == 'null') {
            $sort_by='keyword_id';
        }

        if ($order_sort == 'null') {
            $order_sort='asc';
        }

        $key_search = urldecode($key_search);
        
        // All records count
        $allcount = $this->Article_model->getListCategoryCount($key_search,$visible,$contentid,$keyword_refer);

        // Get  records
        $users_record = $this->Article_model->getDataListCategory($rowno,$rowperpage,$order_sort,$sort_by,$key_search,$visible,$contentid,$keyword_refer);
        
        // Pagination Configuration
        $config['base_url'] = base_url().'article/list_category_article/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$visible.'/'.$contentid.'/'.$rowno;
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
            $keyword_name = $this->input->post('keyword_name');
            if ($keyword_name != null) {
                $data = array(
                    'keyword_name'     => $keyword_name,
                    'keyword_sort'     => '1',
                    'keyword_child'    => 'SIN',
                    'keyword_sub'      => 'N',
                    'keyword_ref'      => 'ARC',
                    'keyword_visible'  => 'Y',
                    'keyword_parentid' => ','.$keyword_ref.','
                );
                $insert = $this->Article_model->save_category($data);
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
        $socialtv = $this->Article_model->get_data_edit_category($id);
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
        
        $update = $this->Article_model->edit_category($keyword_id,$keyword_name);
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

        $inactive = $this->Article_model->active_category($id);
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

        $inactive = $this->Article_model->inactive_category($id);
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
            $result = $this->Article_model->save_tags($name_tag, $sort_tag, $child_tag, $sub_tag, $ref_tag, $visible_tag, $par_tag);
            echo json_encode(array("status" => TRUE));
        } else {
            alert('data gagal disimpan');
        }
    }

    public function insert_poster_article()
    {
        $urlimage = $this->input->post('image');
        $article_id = $this->input->post('art_id');
        $_idposter   = $this->Article_model->insert_poster_article($urlimage,$article_id);
    }

    public function create_edit_article_content($id = null) {
        $CI =& get_instance();
        if (!$id) show_404();
        $article = $this->Article_model->get_article_content_by_id($id);
        if (!$article) show_404();

        $data['title'] = 'Manage Article Content';
        $data['article'] = $article[0];

        $this->form_validation->set_rules('article_content_1', 'Article Content 1', 'required', ['required' => 'Article Content 1 harus diisi']);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('articles/article_content', $data);
            $this->load->view('layouts/footer');
        } else {
            $article_content_1 = $this->input->post('article_content_1',FALSE);
            $article_content_2 = $this->input->post('article_content_2',FALSE);
            $article_content_1 = str_replace(['<span style="font-size: 1rem;">','style="font-size: 1rem;"'], '', $article_content_1);
            $article_content_2 = str_replace(['<span style="font-size: 1rem;">','style="font-size: 1rem;"'], '', $article_content_2);
            $article_data = [
                'article_id' => $id,
                'article_content_1' => $article_content_1,
                'article_content_2' => $article_content_2
            ];            
            $saved = $this->Article_model->create_edit_article_content($article_data);
            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Article berhasil diubah</div>'); 
                return redirect('articles/create_edit_poster_banner/'.$id);
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Article tidak berhasil diubah</div>');
                return redirect('articles');
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

    public function compare_image_article()
    {
        echo json_encode($this->get_image_article());
    }

    private function get_image_article()
    {
        $data = array();
        $_arrFolder = array();
        $_urlimage = array();

        //formed array from server
        $path = 'wp/img/denslife_v1/1280x720/';
        $changeDir = 'wp/img/denslife_v1/1280x720/';
        $listimg = $this->libadapter->getImages($path, $changeDir);
        if ($listimg['error'] == 0) {
            $_arrFolder = array();
            $listimg1 = $listimg['content'];
            foreach ($listimg1 as $key => $value) {
                $_arrFolder[] = $value['url'];
            }
            krsort($_arrFolder);

            //formed array from database
            $urlimage = $this->Article_model->getimagearticle();
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

    public function create_edit_poster_banner($id = null) {
        $CI =& get_instance();
        if (!$id) show_404();
        $article = $this->Article_model->get_poster_banner_by_id($id);

        if (!$article) show_404();

        $data['title'] = 'Manage Poster Banner';
        $data['article_id'] = $id;
        $data['posters'] = $article['result'] ?? [];
        $data['status'] = count($data['posters']) > 0 ? 'edit' : 'add';

        $this->form_validation->set_rules('poster_banner1', 'Poster Banner 1', 'required', ['required' => 'Poster Banner 1 harus dipilih']);
        $this->form_validation->set_rules('poster_banner2', 'Poster Banner 2', 'required', ['required' => 'Poster Banner 2 harus dipilih']);
        $this->form_validation->set_rules('poster_banner3', 'Poster Banner 3', 'required', ['required' => 'Poster Banner 3 harus dipilih']);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('articles/poster_banner', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $poster_banner1 = $this->input->post('poster_banner1',TRUE);
            $poster_banner2 = $this->input->post('poster_banner2',TRUE);
            $poster_banner3 = $this->input->post('poster_banner3',TRUE);
            $poster_id1 = $this->input->post('poster_id1',TRUE);
            $poster_id2 = $this->input->post('poster_id2',TRUE);
            $poster_id3 = $this->input->post('poster_id3',TRUE);
            $status = $this->input->post('status',TRUE);
            if ($status == 'add') {
                $saved = $this->Article_model->add_poster_banner($id,$poster_banner1,$poster_banner2,$poster_banner3,$time);
            } else {
                $saved = $this->Article_model->edit_poster_banner($id,$poster_banner1,$poster_banner2,$poster_banner3,$poster_id1,$poster_id2,$poster_id3,$time);
            }
            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Poster berhasil disimpan</div>'); 
                return redirect('articles/create_edit_poster_content/'.$id);
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Poster tidak berhasil disimpan</div>');
                return redirect('articles');
            }
        }
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

        //formed array from server
        $path = 'wp/img/denslife_v1/1280x720/';
        $changeDir = 'wp/img/denslife_v1/1280x720/';
        $listimg = $this->libadapter->getImages($path, $changeDir);
        if ($listimg['error'] == 0) {
            $_arrFolder = array();
            $listimg1 = $listimg['content'];
            foreach ($listimg1 as $key => $value) {
                $_arrFolder[] = $value['url'];
            }
            krsort($_arrFolder);

            //formed array from database
            $urlimage = $this->Article_model->getimagebanner();
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

    public function create_edit_poster_content($article_id = null)
    {
        if (!$article_id) show_404();
        $data['article_id'] = $article_id;

        $data['title'] = 'Manage Poster Banner';
        $posurl = $this->input->post('poster_url',TRUE);

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('poster_url[rowimg0][0]', 'Poster URL', 'trim|required');
            $this->form_validation->set_rules('stream_url[rowvid0][0]', 'Poster URL', 'trim|required');

            $this->form_validation->set_message('required', '%s masih kosong, silahkan isi');

            if ($this->form_validation->run() === FALSE) {
                $this->load->view('layouts/header', $data);
                $this->load->view('layouts/sidebar');
                $this->load->view('articles/poster_content', $data);
                $this->load->view('layouts/footer');
            }

            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $poster_id = $this->input->post('poster_id',TRUE);
            $poster_url = $this->input->post('poster_url',TRUE);
            $poster_type = $this->input->post('poster_type',TRUE);
            $productidimg = $this->input->post('productidimg',TRUE);
            $stream_id = $this->input->post('stream_id',TRUE);
            $stream_url = $this->input->post('stream_url',TRUE);
            $stream_type = $this->input->post('stream_type',TRUE);
            $poster_id_vid = $this->input->post('poster_id_vid',TRUE);
            $poster_url_vid = $this->input->post('poster_url_vid',TRUE);
            $productidvid = $this->input->post('productidvid',TRUE);
            $productidvidimg = $this->input->post('productidvidimg',TRUE);
            $productidstream = $this->input->post('productidstream',TRUE);
            $status_images = $this->input->post('status_images',TRUE);
            $status_videos = $this->input->post('status_videos',TRUE);
            
            if ($status_images=='add') {
                $insert_image = array();
                $i = 0;
                foreach ($productidimg as $key => $val) {
                    if (! empty($poster_url[$key][0])) {
                        array_push($insert_image,
                            array(
                                'product_id'=>'ARPC_' . $val[0] . '_' . ($i+1),
                                'poster_type'=>'arpc_1280x720',
                                'poster_url'=>$this->url_image1.basename($poster_url[$key][0]),
                                'poster_update'=>$time,
                                'poster_visible'=>'Y'
                            ),
                            array(
                                'product_id'=>'ARPC_' . $val[0] . '_' . ($i+1),
                                'poster_type'=>'arpc_410x230',
                                'poster_url'=>$this->url_image2.basename($poster_url[$key][0]),
                                'poster_update'=>$time,
                                'poster_visible'=>'Y'
                            ),
                            array(
                                'product_id'=>'ARPC_' . $val[0] . '_' . ($i+1),
                                'poster_type'=>'arpc_235x132',
                                'poster_url'=>$this->url_image2.basename($poster_url[$key][0]),
                                'poster_update'=>$time,
                                'poster_visible'=>'Y'
                            )
                        );
                    }
                    $i++;
                }
                if (count($insert_image) <= 0) {
                    $result = false;
                } else {
                    $insert_image_content = $this->Article_model->insert_image_content($insert_image);
                    $result = true;
                }
            } else {
                $ext_type = 1;
                if ($poster_type!=null && !empty($poster_type)) {
                    $pos_type = end($poster_type);
                    $indexone = $pos_type[0];
                    $ext_type = substr($indexone,-1)+1;
                }
                $edit_image_exist = array();
                if (! empty($poster_id) && ! empty($poster_url)) {
                    foreach($poster_id as $key1 => $datas){
                        foreach ($datas as $key2 => $value) {
                            if (! empty($poster_url[$key1][$key2])) {
                                if ($key2==0) {
                                    $edit_image_exist[] = array(
                                        'poster_url'=>$this->url_image1.basename($poster_url[$key1][$key2]),
                                        'poster_update'=>$time,
                                        'poster_id' => $poster_id[$key1][$key2],
                                    );
                                } else {
                                    $edit_image_exist[] = array(
                                        'poster_url'=>$this->url_image2.basename($poster_url[$key1][$key2]),
                                        'poster_update'=>$time,
                                        'poster_id' => $poster_id[$key1][$key2],
                                    );
                                }
                            }
                        }
                    }
                }
                $edit_image_new = array();
                foreach ($poster_url as $key1 => $datas) {
                    foreach ($datas as $key2 => $value) {
                        if (empty($poster_id[$key1][$key2]) && $poster_url[$key1][$key2] != null) {
                            array_push($edit_image_new,
                                array(
                                    'product_id'=>'ARPC_' . $productidimg[$key1][$key2] . '_' . ($ext_type),
                                    'poster_type'=>'arpc_1280x720',
                                    'poster_url'=>$this->url_image1.basename($poster_url[$key1][$key2]),
                                    'poster_update'=>$time,
                                    'poster_visible'=>'Y',
                                ),
                                array(
                                    'product_id'=>'ARPC_' . $productidimg[$key1][$key2] . '_' . ($ext_type),
                                    'poster_type'=>'arpc_410x230',
                                    'poster_url'=>$this->url_image2.basename($poster_url[$key1][$key2]),
                                    'poster_update'=>$time,
                                    'poster_visible'=>'Y',
                                ),
                                array(
                                    'product_id'=>'ARPC_' . $productidimg[$key1][$key2] . '_' . ($ext_type),
                                    'poster_type'=>'arpc_235x132',
                                    'poster_url'=>$this->url_image2.basename($poster_url[$key1][$key2]),
                                    'poster_update'=>$time,
                                    'poster_visible'=>'Y',
                                )
                            );
                            ++$ext_type;
                        }
                    }
                }

                if (count($edit_image_exist) <= 0 && count($edit_image_new) <= 0) {
                    $result = false;
                } else {
                    if ($edit_image_exist != null) {
                        $update_image_content = $this->Article_model->update_image_content($edit_image_exist);
                    }
                    if ($edit_image_new != null) {
                        $new_image_content = $this->Article_model->insert_image_content($edit_image_new);
                    }
                    $result = true;
                }
            }
            if ($status_videos=='add') {
                $insert_image_videos = array();
                $i = 0;
                foreach ($productidstream as $key1 => $datas) {
                    if (! empty($productidstream[$key1][0]) && $poster_url_vid[$key1][0] != "" && $poster_url_vid[$key1][0] != null) {
                        array_push($insert_image_videos,
                            array(
                                'product_id'=>'DLS_' . $datas[0] . '_' . ($i+1),
                                'poster_type'=>'dls_1280x720',
                                'poster_url'=>$poster_url_vid[$key1][0],
                                'poster_update'=>$time,
                                'poster_visible'=>'Y',
                            ),
                            array(
                                'product_id'=>'DLS_' . $datas[0] . '_' . ($i+1),
                                'poster_type'=>'dls_410x230',
                                'poster_url'=>$poster_url_vid[$key1][0],
                                'poster_update'=>$time,
                                'poster_visible'=>'Y',
                            ),
                            array(
                                'product_id'=>'DLS_' . $datas[0] . '_' . ($i+1),
                                'poster_type'=>'dls_235x132',
                                'poster_url'=>$poster_url_vid[$key1][0],
                                'poster_update'=>$time,
                                'poster_visible'=>'Y',
                            )
                        );
                        $i++;
                    }
                }
                $insert_videos = array();
                $i = 0;
                foreach ($stream_url as $key1 => $datas) {
                    foreach ($datas as $key2 => $value) {
                        if ($stream_url[$key1][$key2] != "" && $stream_url[$key1][$key2]!= null) {
                            array_push($insert_videos,
                                array(
                                    'stream_type'=>$stream_type[$key1][$key2],
                                    'stream_screen'=>'101',
                                    'stream_length'=>'98',
                                    'product_id'=>$productidvid[$key1][$key2],
                                    'stream_url'=>str_replace('"', "'", $stream_url[$key1][$key2]),
                                    'stream_pass'=>'0',
                                    'stream_visible'=>'Y',
                                )
                            );
                        }
                        $i++;
                    }
                }
                if (count($insert_image_videos) <= 0 && count($insert_videos) <= 0) {
                    $result = false;
                } else {
                    $insert_image_video_content = $this->Article_model->insert_image_video_content($insert_image_videos);
                    $insert_video_content = $this->Article_model->insert_video_content($insert_videos);
                    $result = true;
                }
            } else {
                $pos_ext_type  = 1;
                if ($productidvidimg!=null && !empty($productidvidimg)) {
                    $pos_type = end($productidvidimg);
                    $pos_test = $pos_type[0];
                    $pos_ext_type = substr($pos_test,-1)+1;
                }
                $update_image_videos = array();
                if (! empty($poster_id_vid)) {
                    foreach ($poster_id_vid as $key1 => $datas) {
                        foreach ($datas as $key2 => $value) {
                            if (!empty($poster_url_vid[$key1][$key2]) && !empty($poster_id_vid[$key1][$key2])) {
                                $update_image_videos[] = array(
                                    'poster_url'=>$poster_url_vid[$key1][$key2],
                                    'poster_id' => $poster_id_vid[$key1][$key2],
                                    'poster_update'=>$time,
                                );
                            }
                        }
                    }
                }
                $update_videos = array();
                if (! empty($stream_id)) {
                    foreach ($stream_id as $key1 => $datas) {
                        foreach ($datas as $key2 => $value) {
                            if (!empty($stream_url[$key1][$key2]) && !empty($stream_id[$key1][$key2])){
                                $update_videos[] = array(
                                    'stream_url'=>str_replace('"', "'", $stream_url[$key1][$key2]),
                                    'stream_id' => $stream_id[$key1][$key2],
                                    'product_id' => $productidvid[$key1][$key2],
                                    'stream_type' => $stream_type[$key1][$key2],
                                );
                            }
                        }
                    }
                }
                $tambah_poster = array();
                foreach ($poster_url_vid as $key1 => $datas) {
                    foreach ($datas as $key2 => $value) {
                        if (empty($poster_id_vid[$key1][$key2]) && $poster_url_vid[$key1][$key2] != null) {
                            array_push($tambah_poster,
                                array(
                                    'product_id'=>'DLS_' . $productidstream[$key1][$key2] . '_' . ($pos_ext_type),
                                    'poster_type'=>'dls_1280x720',
                                    'poster_url'=>$poster_url_vid[$key1][$key2],
                                    'poster_update'=>$time,
                                    'poster_visible'=>'Y',
                                ),
                                array(
                                    'product_id'=>'DLS_' . $productidstream[$key1][$key2] . '_' . ($pos_ext_type),
                                    'poster_type'=>'dls_410x230',
                                    'poster_url'=>$poster_url_vid[$key1][$key2],
                                    'poster_update'=>$time,
                                    'poster_visible'=>'Y',
                                ),
                                array(
                                    'product_id'=>'DLS_' . $productidstream[$key1][$key2] . '_' . ($pos_ext_type),
                                    'poster_type'=>'dls_235x132',
                                    'poster_url'=>$poster_url_vid[$key1][$key2],
                                    'poster_update'=>$time,
                                    'poster_visible'=>'Y',
                                )
                            );
                            ++$pos_ext_type;
                        }
                    }
                }
                $tambah_video = array();
                foreach ($stream_url as $key1 => $datas) {
                    foreach ($datas as $key2 => $value) {
                        if (empty($stream_id[$key1][$key2]) && $stream_url[$key1][$key2] != null) {
                            array_push($tambah_video,
                                array(
                                'stream_type'=>$stream_type[$key1][$key2],
                                'stream_screen'=>'101',
                                'stream_length'=>'98',
                                'product_id'=>$productidvid[$key1][$key2],
                                'stream_url'=>str_replace('"', "'", $stream_url[$key1][$key2]),
                                'stream_pass'=>'0',
                                'stream_visible'=>'Y',
                                )
                            );
                        }
                    }
                }
                if (count($update_image_videos) <= 0 && count($update_videos) <= 0 && count($tambah_poster) <= 0 && count($tambah_video) <= 0) {
                    $result = false;
                } else {
                    if ($update_image_videos != null && $update_videos != null) {
                        $update_image_video_content = $this->Article_model->update_image_video_content($update_image_videos);
                        $update_video_content = $this->Article_model->update_video_content($update_videos);
                    }
                    if ($tambah_poster != null && $tambah_video != null) {
                        $new_poster = $this->Article_model->insert_image_video_content($tambah_poster);
                        $new_video = $this->Article_model->insert_video_content($tambah_video);
                    }
                    $result = true;
                }
            }
            if ($result == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Article berhasil disimpan</div>'); 
                return redirect('articles');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Article tidak berhasil disimpan</div>');
                return redirect('articles');
            }
        }
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('articles/poster_content', $data);
        $this->load->view('layouts/footer');
    }

    public function get_data_images()
    {
        $article_id = $this->input->post('article_id',TRUE);
        if ($article_id!=null) {
            $group = $this->Article_model->get_image_content_by_id($article_id);
            foreach ($group as $key => $value) {
                $size[$value['product_id']][] = $value;
            }
            $data = array(
                'error' => '0',
                'poster' => $size
            );
        } else {
            $data = array(
                'error' => '1',
                'poster' => null
            );
        }
        echo json_encode($data);
    }

    public function get_data_videos()
    {
        $article_id = $this->input->post('article_id',TRUE);
        if ($article_id!=null) {
            $group = $this->Article_model->get_video_content_by_id($article_id);
            if (empty($group)) {
                $data = array(
                    'error' => '1',
                    'poster' => null
                );
            } else {
                foreach ($group as $key => $value) {
                    $size[$value['productid_poster']][] = $value;
                }
                $data = array(
                    'error' => '0',
                    'poster' => $size
                );
            }
        } else {
            $data = array(
                'error' => '1',
                'poster' => null
            );
        }
        echo json_encode($data);
    }

    public function get_video_on_server(){
        $toURL='http://aid.digdaya.co.id/uploader/getListMovie';
        $post=array();
        $exe = $this->libadapter->execurl($toURL, $post);
        $_token = json_decode($exe['data'],true);
        return $_token;
    }

    public function get_video(){
        //get from folder upload
        $urlvideos = $this->get_video_on_server();
        $urlvideo = $urlvideos['data'];
        krsort($urlvideo);


        $urlimage = $this->Article_model->getimagevideo();

        $tmpArray = array();
        if(is_array($urlvideo)&& count ($urlvideo)>0){
            foreach($urlvideo as $data1) {
                $duplicate = false;
                foreach($urlimage as $data2) {
                    if($data1['url_video_poster'] === $data2['poster_url']) $duplicate = true;
                }

                if($duplicate === false) $tmpArray[] = $data1;
            }
        }
        else{
            $tmpArray = 'data image not found';
        }
        echo json_encode($tmpArray);
    }
}
