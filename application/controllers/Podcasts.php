<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Podcasts extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user')) {
            redirect('auth');
        }
        if (!has_permission('view_podcasts')) {
            show_error('Anda tidak memiliki akses ke halaman ini', 403, 'Forbidden');
        }
        $this->load->config('secure_config');
        $this->load->library('pagination');
        $this->load->library('libadapter');
        $this->load->model('Podcast_model');
    }

    private static $baseurlimage = 'https://picture.dens.tv/';

    public function index()
    {
        $data['title'] = 'List Podcast';
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('podcasts/index', $data);
        $this->load->view('layouts/footer');
    }

    public function list_podcast($key_search=null, $sort_by='podcast_id', $order_sort='desc', $visible='Y', $rowperpage=10, $rowno=0)
    {
        if ($rowno != 0) {
            $rowno = ($rowno-1) * $rowperpage;
        }
        
        $allcount = $this->Podcast_model->getCountAll($key_search, $visible);

        $users_record = $this->Podcast_model->getDatas($key_search, $sort_by, $order_sort, $visible, $rowperpage, $rowno);
        
        // Pagination Configuration
        $config['base_url'] = base_url().'podcasts/list_podcast/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$visible.'/'.$rowperpage.'/'.$rowno;
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

    public function save_podcast_recom()
    {
        $CI =& get_instance();
        $this->form_validation->set_rules('podcast_id', 'Podcast ID', 'trim|required');
        $this->form_validation->set_rules('datetimepickerstart', 'datetime start', 'trim|required');
        $this->form_validation->set_rules('datetimepickerend', 'datetime end', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Masih ada data yang belum terisi</div>');
            redirect('podcasts');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $by = $CI->session->userdata('username');
            $podcast_id = $this->input->post('podcast_id',TRUE);
            $datetimestart = $this->input->post('datetimepickerstart',TRUE);
            $datetimeend = $this->input->post('datetimepickerend',TRUE);
            if ($podcast_id==null) {
                $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Silahkan isi kembali data Podcast Recommendation dengan benar</div>');
                redirect('podcasts');
            } else {
                $_idPodcast = $this->Podcast_model->save_podcast_recom($podcast_id, $datetimestart, $datetimeend, $time, $by);
                $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil Disimpan</div>');
                redirect('podcasts');
            }
        }
    }

    public function activated($id)
    {
        if (!isset($id)) show_404();
        
        if ($this->Podcast_model->activated($id)) {
            redirect(site_url('podcast'));
        }
    }

    public function inactivated($id)
    {
        if (!isset($id)) show_404();
        
        if ($this->Podcast_model->inactivated($id)) {
            redirect(site_url('podcast'));
        }
    }

    public function get_list_category()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        if($page != 0){
            $page = ($page-1) * $perPage;
        }
        $results = $this->Podcast_model->get_list_category($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Podcast_model->get_list_category($perPage, $page, $searchTerm, 'count');
        $data = array();
        foreach ($results as $row) {
            $data[] = array(
                "id"=>$row['keyword_id'],
                "text"=>$row['keyword_name'],
                "icon"=>$row['icon']
            );
        }
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function get_single_category()
    {
        $id = $this->input->post('id');
        $data = $this->Podcast_model->get_category_by_id($id);
        echo json_encode([
            'id' => $data['id'],
            'text' => $data['title']
        ]);
    }

    public function get_list_sub_category()
    {
        $searchTerm = $this->input->post('searchTerm');
        $category_id = $this->input->post('category_id');
        $page = $this->input->post('page');
        $perPage = 10;
        if($page != 0){
            $page = ($page-1) * $perPage;
        }
        $results = $this->Podcast_model->get_list_sub_category($perPage, $page, $searchTerm, $category_id, 'data');
        $countResults = $this->Podcast_model->get_list_sub_category($perPage, $page, $searchTerm, $category_id, 'count');
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

    public function get_multiple_sub_category()
    {
        $ids = $this->input->post('ids');
        if (!is_array($ids)) {
            $ids = [$ids];
        }
        $subs = [];
        foreach ($ids as $id) {
            $group = $this->Podcast_model->get_sub_category_by_id($id);
            if ($group) {
                $subs[] = [
                    'id' => $group->keyword_id,
                    'text' => $group->keyword_name
                ];
            }
        }
        echo json_encode($subs);
    }

    public function create()
    {
        $CI =& get_instance();
        $data['title'] = 'Add Podcast';

        $this->form_validation->set_rules('category_podcast', 'Category', 'required', ['required' => 'Category harus dipilih']);
        $this->form_validation->set_rules('sub_category_podcast[]', 'Sub Category', 'required', ['required' => 'Sub Category harus dipilih']);
        $this->form_validation->set_rules('title', 'Title', 'required', ['required' => 'Title harus diisi']);
        $this->form_validation->set_rules('link_rss', 'Link RSS', 'required', ['required' => 'Link RSS harus diisi']);

        if ($this->form_validation->run() == FALSE) {
            $data['selected_category'] = set_value('category_podcast');
            $data['selected_sub_category'] = $this->input->post('sub_category_podcast');
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('podcasts/create', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta");
            $time = date('Y-m-d H:i:s');
            $by = $CI->session->userdata('username');
            $category_podcast = $this->input->post('category_podcast',TRUE);
            $sub_category_podcast = implode(',', $this->input->post('sub_category_podcast',TRUE));
            $keyword_id = ',' . $category_podcast . ',' . $sub_category_podcast . ',';
            $title = $this->input->post('title',TRUE);
            $link_rss = $this->input->post('link_rss',TRUE);
            $podcast_data = [
                'podcast_name' => $title,
                'podcast_link_rss' => $link_rss,
                'visible' => 'N',
                'keyword_id' => $keyword_id,
                'created_at' => $time,
                'created_by' => $by,
                'updated_at' => $time,
                'updated_by' => $by,
                'ctrloc' => '/podcasts/create'
            ];
            $saved = $this->Podcast_model->insert_podcast($podcast_data);
            if ($saved == true) {
                $this->parse_rss_insert($saved, $link_rss, $time);
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Podcast berhasil disimpan</div>'); 
                return redirect('podcasts');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Podcast tidak berhasil disimpan</div>');
                return redirect('podcasts');
            }
        }
    }

    public function parse_rss_insert($idPodcast="", $link_rss="", $time="")
    {
        $rss_item_tag = 'item';
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );  
        $fileContents = file_get_contents($link_rss, false, stream_context_create($arrContextOptions));
        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($fileContents);
        libxml_clear_errors();
        $fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
        $fileContents = trim(str_replace('"', "'", $fileContents));
        $simpleXml = simplexml_load_string($fileContents, 'SimpleXMLElement', LIBXML_NOCDATA);
        $getChannel = $simpleXml->channel;
        $getItunes = $getChannel->children('itunes', true);
        $data = json_decode(json_encode($simpleXml),true);
        if ($data !=null) {
            $podcast_data = array();
            if (array_key_exists('channel', $data)) {
                $_podcastdata = $data['channel'];
                //podcast data
                $podcast_data['podcast_id'] = $idPodcast; //podcast id
                $podcast_data['podcast_title'] = $_podcastdata['title'];
                $podcast_data['podcast_desc'] = $_podcastdata['description'];
                $podcast_data['podcast_link'] = $_podcastdata['link'];
                if (!empty($_podcastdata['image']['url'])) {
                    $podcast_data['podcast_image'] = $_podcastdata['image']['url'];
                } elseif (!empty($getItunes->image->attributes()->href)) {
                    $podcast_data['podcast_image'] = (string) $getItunes->image->attributes()->href;
                } else {
                    $podcast_data['podcast_image'] = null;
                }
                $podcast_data['podacst_author'] = $_podcastdata['author'];
                $podcast_data['podcast_copyright'] = $_podcastdata['copyright'];
                $podcast_data['podcast_language'] = $_podcastdata['language'];
                $podcast_data['podcast_builddate'] = $_podcastdata['lastBuildDate'];
                $podcast_data['created_at'] = $time;
                $podcast_data['updated_at'] = $time;
                $podcast_data['ctrloc'] = "/podcasts/parse_rss_insert";
                //save podcast_data and get podcast_data_id
                $idPodcast_data = $this->Podcast_model->insert_podcast_data($podcast_data);
                //podcast item
                if ($idPodcast_data != null) {
                    $podcast_episode = array();
                    $i=0;
                    $ns = $doc->lookupNamespaceURI('itunes');
                    foreach ($doc->getElementsByTagName($rss_item_tag) AS $keys => $node) {
                        $podcast_episode[$i] = array(
                            'podcast_data_id' => $idPodcast_data,
                            'episode_title' => $_podcastdata['item'][$i]['title'],
                            'episode_desc' => preg_replace('/<[^>]*>/', '', $_podcastdata['item'][$i]['description']),
                            'episode_pubdate' => $_podcastdata['item'][$i]['pubDate'],
                            'episode_enclosure_link' => $node->getElementsByTagName('enclosure')->item(0)->getAttribute('url'),
                            'episode_length' => $node->getElementsByTagName('enclosure')->item(0)->getAttribute('length'),
                            'episode_image' => $node->getElementsByTagNameNS($ns, 'image')->item(0)->getAttribute('href'),
                            'created_at' => $time,
                            'updated_at' => $time,
                            'ctrloc' => "/podcasts/parse_rss_insert",
                        );
                        $i++;
                    }
                    krsort($podcast_episode);
                    //save podcast_episode
                    $idPodcast_episode = $this->Podcast_model->insert_podcast_episode($podcast_episode);
                }
            }
        }
    }

    public function edit($id = null) {
        $CI =& get_instance();
        if (!$id) show_404();
        $podcast = $this->Podcast_model->get_podcast_by_id($id);
        if (!$podcast) show_404();

        $data['title'] = 'Edit Podcast';
        $data['podcast'] = $podcast[0];

        $this->form_validation->set_rules('category_podcast', 'Category', 'required', ['required' => 'Category harus dipilih']);
        $this->form_validation->set_rules('sub_category_podcast[]', 'Sub Category', 'required', ['required' => 'Sub Category harus dipilih']);
        $this->form_validation->set_rules('title', 'Title', 'required', ['required' => 'Title harus diisi']);
        $this->form_validation->set_rules('link_rss', 'Link RSS', 'required', ['required' => 'Link RSS harus diisi']);

        if ($this->form_validation->run() == FALSE) {
            $data['selected_category'] = set_value('category_podcast') ?: $podcast[0]['category_id'];
            $data['selected_sub_category'] = $this->input->post('sub_category_podcast') ?: array_column($podcast[0]['sub_category'], 'sub_category_id');
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('podcasts/edit', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta");
            $time = date('Y-m-d H:i:s');
            $by = $CI->session->userdata('username');
            $category_podcast = $this->input->post('category_podcast',TRUE);
            $sub_category_podcast = implode(',', $this->input->post('sub_category_podcast',TRUE));
            $keyword_id = ',' . $category_podcast . ',' . $sub_category_podcast . ',';
            $title = $this->input->post('title',TRUE);
            $link_rss = $this->input->post('link_rss',TRUE);
            $podcast_data = [
                'podcast_id' => $id,
                'podcast_name' => $title,
                'podcast_link_rss' => $link_rss,
                'keyword_id' => $keyword_id,
                'updated_at' => $time,
                'updated_by' => $by,
                'ctrloc' => '/podcasts/edit'
            ];
            $saved = $this->Podcast_model->update_podcast($podcast_data);
            if ($saved == true) {
                $this->parse_rss_update($id, $link_rss, $time);
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Podcast berhasil diubah</div>'); 
                return redirect('podcasts');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Podcast tidak berhasil diubah</div>');
                return redirect('podcasts');
            }
        }
    }

    public function parse_rss_update($podcast_id="", $link_rss="", $time="")
    {
        $rss_item_tag = 'item';
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        $fileContents = file_get_contents($link_rss, false, stream_context_create($arrContextOptions));
        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($fileContents);
        libxml_clear_errors();
        $fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
        $fileContents = trim(str_replace('"', "'", $fileContents));
        $simpleXml = simplexml_load_string($fileContents, 'SimpleXMLElement', LIBXML_NOCDATA);
        $getChannel = $simpleXml->channel;
        $getItunes = $getChannel->children('itunes', true);
        $data = json_decode(json_encode($simpleXml),true);
        if ($data !=null) {
            $podcast_data = array();
            if (array_key_exists('channel', $data)) {
                $_podcastdata = $data['channel'];
                //podcast data
                $podcast_data['podcast_id'] = $podcast_id; //podcast id
                $podcast_data['podcast_title'] = $_podcastdata['title'];
                $podcast_data['podcast_desc'] = $_podcastdata['description'];
                $podcast_data['podcast_link'] = $_podcastdata['link'];
                if (!empty($_podcastdata['image']['url']))
                {
                    $podcast_data['podcast_image'] = $_podcastdata['image']['url'];
                }
                elseif (!empty($getItunes->image->attributes()->href))
                {
                    $podcast_data['podcast_image'] = (string) $getItunes->image->attributes()->href;
                }
                else
                {
                    $podcast_data['podcast_image'] = null;
                }
                $podcast_data['podacst_author'] = $_podcastdata['author'];
                $podcast_data['podcast_copyright'] = $_podcastdata['copyright'];
                $podcast_data['podcast_language'] = $_podcastdata['language'];
                $podcast_data['podcast_builddate'] = $_podcastdata['lastBuildDate'];
                $podcast_data['updated_at'] = $time;
                $podcast_data['ctrloc'] = "/podcasts/parse_rss_update";
            }
        }
        //update podcast_data
        $_idPodcast_data = $this->Podcast_model->update_podcast_data($podcast_data);
        $pod_data = $this->Podcast_model->get_pod_data_id($podcast_id);
        $pod_data_id = $pod_data[0]['podcast_data_id'];
        //podcast item
        if ($podcast_id != null) {
            $podcast_episode = array();
            $i=0;
            $j=1;
            $ns = $doc->lookupNamespaceURI('itunes');
            foreach ($doc->getElementsByTagName($rss_item_tag) AS $keys => $node) {
                if (isset($_podcastdata['item'][$i])) {
                    $title_eps = $_podcastdata['item'][$i]['title'];
                    $desc_eps = $_podcastdata['item'][$i]['description'];
                    $pubdate_eps = $_podcastdata['item'][$i]['pubDate'];
                } else {
                    $title_eps = $_podcastdata['item']['title'];
                    $desc_eps = $_podcastdata['item']['description'];
                    $pubdate_eps = $_podcastdata['item']['pubDate'];
                }
                $podcast_episode[$i] = array(
                    'podcast_seq'=>$j,
                    'podcast_data_id'=>$pod_data_id,
                    'episode_title'=>$title_eps,
                    'episode_desc'=>preg_replace(['/<[^>]*>/', '/[\x{1F600}-\x{1F64F}]/u', '/[\x{1F300}-\x{1F5FF}]/u', '/[\x{1F680}-\x{1F6FF}]/u', '/[\x{2700}-\x{27BF}]/u', '/([0-9|#][\x{20E3}])|[\x{00ae}|\x{00a9}|\x{203C}|\x{2047}|\x{2048}|\x{2049}|\x{3030}|\x{303D}|\x{2139}|\x{2122}|\x{3297}|\x{3299}][\x{FE00}-\x{FEFF}]?|[\x{2190}-\x{21FF}][\x{FE00}-\x{FEFF}]?|[\x{2300}-\x{23FF}][\x{FE00}-\x{FEFF}]?|[\x{2460}-\x{24FF}][\x{FE00}-\x{FEFF}]?|[\x{25A0}-\x{25FF}][\x{FE00}-\x{FEFF}]?|[\x{2600}-\x{27BF}][\x{FE00}-\x{FEFF}]?|[\x{2600}-\x{27BF}][\x{1F000}-\x{1FEFF}]?|[\x{2900}-\x{297F}][\x{FE00}-\x{FEFF}]?|[\x{2B00}-\x{2BF0}][\x{FE00}-\x{FEFF}]?|[\x{1F000}-\x{1F9FF}][\x{FE00}-\x{FEFF}]?|[\x{1F000}-\x{1F9FF}][\x{1F000}-\x{1FEFF}]?/u'], ['', '', '', '', '', ''], $desc_eps),
                    'episode_pubdate'=>$pubdate_eps,
                    'episode_enclosure_link'=>$node->getElementsByTagName('enclosure')->item(0)->getAttribute('url'),
                    'episode_length'=>$node->getElementsByTagName('enclosure')->item(0)->getAttribute('length'),
                    'episode_image'=>$node->getElementsByTagNameNS($ns, 'image')->item(0)->getAttribute('href'),
                    'created_at'=>$time,
                    'updated_at'=>$time,
                    'ctrloc'=>"/podcasts/parse_rss_update",
                );
                $i++;
                $j++;
            }
        }
        usort($podcast_episode, function($a, $b) {
            return $b['podcast_seq'] - $a['podcast_seq'];
        });
        $_idPodcast_episode = $this->Podcast_model->get_eps_data($pod_data_id);
        if ($podcast_episode!=null && $_idPodcast_episode!=null) {
            $podcast_eps_seq = array();
            foreach ($podcast_episode as $index => $content) {
                foreach ($_idPodcast_episode as $keys => $values) {
                    $podcast_eps_seq[$keys]['podcast_episode_id'] = $values['podcast_episode_id'];
                    $podcast_eps_seq[$index]['podcast_data_id'] = $content['podcast_data_id'];
                    $podcast_eps_seq[$index]['episode_title'] = $content['episode_title'];
                    $podcast_eps_seq[$index]['episode_desc'] = $content['episode_desc'];
                    $podcast_eps_seq[$index]['episode_pubdate'] = $content['episode_pubdate'];
                    $podcast_eps_seq[$index]['episode_enclosure_link'] = $content['episode_enclosure_link'];
                    $podcast_eps_seq[$index]['episode_length'] = $content['episode_length'];
                    $podcast_eps_seq[$index]['episode_image'] = $content['episode_image'];
                    $podcast_eps_seq[$index]['created_at'] = $content['created_at'];
                    $podcast_eps_seq[$index]['updated_at'] = $content['updated_at'];
                    $podcast_eps_seq[$index]['ctrloc'] = $content['ctrloc'];
                }
            }
            if ($podcast_eps_seq!=null) {
                $update_podcast_eps=array();
                foreach ($podcast_eps_seq as $key1 => $value2) {
                    if (!empty($value2["podcast_episode_id"])) {
                        $update_podcast_eps[]=$value2;
                    }
                }
                $insert_podcast_eps=array();
                foreach ($podcast_eps_seq as $key2 => $value3) {
                    if (empty($value3["podcast_episode_id"])) {
                        $insert_podcast_eps[]=$value3;
                    }
                }
            }
        } else {
            $podcast_batch = array();
            foreach ($podcast_episode as $index1 => $content1) {
                $podcast_batch[$index1]['podcast_data_id'] = $content1['podcast_data_id'];
                $podcast_batch[$index1]['episode_title'] = $content1['episode_title'];
                $podcast_batch[$index1]['episode_desc'] = $content1['episode_desc'];
                $podcast_batch[$index1]['episode_pubdate'] = $content1['episode_pubdate'];
                $podcast_batch[$index1]['episode_enclosure_link'] = $content1['episode_enclosure_link'];
                $podcast_batch[$index1]['episode_length'] = $content1['episode_length'];
                $podcast_batch[$index1]['episode_image'] = $content1['episode_image'];
                $podcast_batch[$index1]['created_at'] = $content1['created_at'];
                $podcast_batch[$index1]['updated_at'] = $content1['updated_at'];
                $podcast_batch[$index1]['ctrloc'] = $content1['ctrloc'];
            }
        }
        //update new content podcast_episode
        if ($insert_podcast_eps!=null) {
            $insert_pod_eps = $this->Podcast_model->insert_pod_eps($insert_podcast_eps);
        }
        if ($update_podcast_eps==null && $insert_podcast_eps==null) {
            $insert_batch_pod = $this->Podcast_model->insert_batch_pod($podcast_batch);
        }
    }

    public function save_category()
    {
        $this->form_validation->set_rules('keyword_namecategory', 'Category name', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            alert('silahkan isi category!');
        } else {
            $keyword_name = $this->input->post('keyword_namecategory');
            $keyword_icon = $this->input->post('icon_category');
            $color1 = $this->input->post('color1');
            $color2 = $this->input->post('color2');
            if ($color1 == null && $color2 == null) {
                $results = array(
                    'error' => '1',
                    'message' => 'Data gagal disimpan'
                );
            } else {
                if ($keyword_name != null) {
                    $color_background = ','.$color1.','.$color2.',';
                    $data = array(
                        'keyword_name' => $keyword_name,
                        'keyword_sort' => '1',
                        'keyword_child' => 'SIN',
                        'keyword_sub' => 'N',
                        'keyword_ref' => 'POD',
                        'keyword_visible' => 'Y',
                        'icon' => $keyword_icon,
                        'color_background' => $color_background
                    );
                    $insert = $this->Podcast_model->save_category($data);
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
            }
            echo json_encode($results);
        }
    }

    public function list_category_podcast($key_search=null, $sort_by='keyword_name', $order_sort='asc', $visible='Y', $rowno=0)
    {
        // Row per page
        $rowperpage = 10;
        // Row position
        if ($rowno != 0) {
            $rowno = ($rowno-1) * $rowperpage;
        }
        if ($sort_by == 'null') {
            $sort_by='keyword_id';
        }
        if ($order_sort == 'null') {
            $order_sort='asc';
        }
        $keyword_refer='POD';
        $key_search = urldecode($key_search);
        // All records count
        $allcount = $this->Podcast_model->getListCategoryCount($key_search,$visible,$keyword_refer);
        // Get  records
        $users_record = $this->Podcast_model->getDataListCategory($rowno,$rowperpage,$order_sort,$sort_by,$key_search,$visible,$keyword_refer);
        // Pagination Configuration
        $config['base_url'] = base_url().'podcasts/list_category_podcast/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$visible.'/'.$rowno;
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

    public function get_data_edit_category()
    {
        $id = $this->input->post('id',TRUE);
        $podcast = $this->Podcast_model->get_data_edit_category($id);
        if ($podcast!=null) {
            $data = $podcast;
        } else {
            die("Data not found");
        }
        echo json_encode($data);
    }

    public function edit_category()
    {
        $keyword_id = $this->input->post('keyword_id');
        $keyword_name = $this->input->post('keyword_namecategory');
        $keyword_icon = $this->input->post('icon_category');
        $color1 = $this->input->post('color1edit');
        $color2 = $this->input->post('color2edit');
        if ($color1 == null && $color2 == null) {
            $results = array(
                'error' => '1',
                'message' => 'Data gagal disimpan'
            );
        } else {
            $color_background = ','.$color1.','.$color2.',';
            $update = $this->Podcast_model->edit_category($keyword_id,$keyword_name,$keyword_icon,$color_background);
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
        }
        echo json_encode($results);
    }

    public function active_category()
    {
        $id = $this->input->post('id');
        $inactive = $this->Podcast_model->active_category($id);
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
        $inactive = $this->Podcast_model->inactive_category($id);
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

    public function save_sub_category()
    {
        $this->form_validation->set_rules('keyword_namesubcategory', 'Sub Category name', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            alert('silahkan isi category!');
        } else {
            $keyword_ref = $this->input->post('contentidparent');
            $keyword_name = $this->input->post('keyword_namesubcategory');
            if ($keyword_name != null) {
                $data = array(
                    'keyword_name'     => $keyword_name,
                    'keyword_sort'     => '1',
                    'keyword_child'    => 'SIN',
                    'keyword_sub'      => 'N',
                    'keyword_ref'      => 'POD',
                    'keyword_visible'  => 'Y',
                    'keyword_parentid' => ','.$keyword_ref.','
                );
                $insert = $this->Podcast_model->save_sub_category($data);
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

    public function list_sub_category_podcast($key_search=null, $sort_by='keyword_name', $order_sort='asc', $visible='Y', $conid, $rowno=0)
    {
        // Row per page
        $rowperpage = 10;
        // Row position
        if ($rowno != 0) {
            $rowno = ($rowno-1) * $rowperpage;
        }
        if ($sort_by == 'null') {
            $sort_by='keyword_id';
        }
        if ($order_sort == 'null') {
            $order_sort='asc';
        }
        $keyword_refer='POD';
        $key_search = urldecode($key_search);
        // All records count
        $allcount = $this->Podcast_model->getListSubCategoryCount($key_search,$visible,$keyword_refer,$conid);
        // Get  records
        $users_record = $this->Podcast_model->getDataListSubCategory($rowno,$rowperpage,$order_sort,$sort_by,$key_search,$visible,$keyword_refer,$conid);
        // Pagination Configuration
        $config['base_url'] = base_url().'podcasts/list_category_podcast/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$visible.'/'.$conid.'/'.$rowno;
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

    public function get_data_edit_subcategory()
    {
        $id = $this->input->post('id',TRUE);
        $podcast = $this->Podcast_model->get_data_edit_subcategory($id);
        if ($podcast!=null) {
            $data = $podcast;
        } else {
            die("Data not found");
        }
        echo json_encode($data);
    }

    public function edit_subcategory()
    {
        $keyword_id = $this->input->post('keyword_id');
        $keyword_name = $this->input->post('keyword_namesubcategory');
        $update = $this->Podcast_model->edit_subcategory($keyword_id,$keyword_name);
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
}
