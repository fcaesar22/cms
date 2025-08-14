<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tv_channels extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user')) {
            redirect('auth');
        }
        if (!has_permission('view_tvchannels')) {
            show_error('Anda tidak memiliki akses ke halaman ini', 403, 'Forbidden');
        }
        $this->load->config('secure_config');
        $this->load->library('pagination');
        $this->load->library('libadapter');
        $this->load->model('Tv_channel_model');
    }

    private static $baseurlimage = 'https://picture.dens.tv/wp/';

    public function index()
    {
        $data['title'] = 'List TV Channels';
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('tv_channels/index', $data);
        $this->load->view('layouts/footer');
    }

    public function category_tvchannels()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }
        $results = $this->Tv_channel_model->category_tvchannels($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Tv_channel_model->category_tvchannels($perPage, $page, $searchTerm, 'count');
        $data = array();
        foreach ($results as $row) {
            $data[] = array(
                "id"=>$row['seq'],
                "text"=>$row['catname']
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

    public function list_tv_channels($key_search=null, $sort_by='seq', $order_sort='desc', $visible='Y', $category, $rowperpage=10, $rowno=0)
    {
        if ($rowno != 0) {
            $rowno = ($rowno-1) * $rowperpage;
        }
        
        $allcount = $this->Tv_channel_model->getCountAll($key_search, $visible, $category);

        $users_record = $this->Tv_channel_model->getDatas($key_search, $sort_by, $order_sort, $visible, $category, $rowperpage, $rowno);
        
        // Pagination Configuration
        $config['base_url'] = base_url().'tv_channels/list_tv_channels/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$visible.'/'.$category.'/'.$rowperpage.'/'.$rowno;
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

    public function get_list_genre()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }
        $results = $this->Tv_channel_model->get_list_genre($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Tv_channel_model->get_list_genre($perPage, $page, $searchTerm, 'count');
        $data = array();
        foreach ($results as $row) {
            $data[] = array(
                "id"=>$row['seq'],
                "text"=>$row['catname']
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
            $genre = $this->Tv_channel_model->get_genre_by_id($id);
            if ($genre) {
                $genres[] = [
                    'id' => $genre->seq,
                    'text' => $genre->catname
                ];
            }
        }
        echo json_encode($genres);
    }

    public function get_list_owner()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }
        $results = $this->Tv_channel_model->get_list_owner($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Tv_channel_model->get_list_owner($perPage, $page, $searchTerm, 'count');
        $data = array();
        foreach ($results as $row) {
            $data[] = array(
                "id"=>$row['id_client'],
                "text"=>$row['name_client']
            );
        }
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function get_single_owner()
    {
        $id = $this->input->post('id');
        $data = $this->Tv_channel_model->get_owner_by_id($id);
        echo json_encode([
            'id' => $data->id,
            'text' => $data->title
        ]);
    }

    public function create() {
        $CI =& get_instance();
        $data['title'] = 'Add TV Channel';

        $this->form_validation->set_rules('poster_content1', 'Logo Square', 'required', ['required' => 'Logo Square harus dipilih']);
        $this->form_validation->set_rules('poster_content2', 'Logo Landscape', 'required', ['required' => 'Logo Landscape harus dipilih']);
        $this->form_validation->set_rules('genre[]', 'Genre', 'required', ['required' => 'Genre harus dipilih']);
        $this->form_validation->set_rules('title', 'Title', 'required|is_unique[tv_channel.title]', [
            'required' => 'Title harus diisi',
            'is_unique' => 'Title sudah digunakan'
        ]);
        $this->form_validation->set_rules('description', 'Description', 'required', ['required' => 'Description harus diisi']);
        $this->form_validation->set_rules('sort_id', 'Sort ID', 'required|regex_match[/^[0-9]+$/]', [
            'required' => 'Sort ID harus diisi',
            'regex_match' => 'Sort ID diisi harus dengan angka'
        ]);
        $this->form_validation->set_rules('trial_period', 'Trial Period', 'required|regex_match[/^[0-9]+$/]', [
            'required' => 'Trial Period harus diisi',
            'regex_match' => 'Trial Period diisi harus dengan angka'
        ]);
        $this->form_validation->set_rules('list_price', 'List Price', 'required|regex_match[/^[0-9]+$/]', [
            'required' => 'List Price harus diisi',
            'regex_match' => 'List Price diisi harus dengan angka'
        ]);
        $this->form_validation->set_rules('sell_price', 'Sell Price', 'required|regex_match[/^[0-9]+$/]', [
            'required' => 'Sell Price harus diisi',
            'regex_match' => 'Sell Price diisi harus dengan angka'
        ]);
        $this->form_validation->set_rules('start_time', 'Start Time', 'required', ['required' => 'Start Time harus dipilih']);
        $this->form_validation->set_rules('end_time', 'End Time', 'required', ['required' => 'End Time harus dipilih']);
        $this->form_validation->set_rules('web_catchup', 'Limit Day Catchup PC', 'required|integer|greater_than[0]|less_than_equal_to[7]');
        $this->form_validation->set_rules('stb_catchup', 'Limit Day Catchup STB', 'required|integer|greater_than[0]|less_than_equal_to[7]');
        $this->form_validation->set_rules('android_catchup', 'Limit Day Catchup Android', 'required|integer|greater_than[0]|less_than_equal_to[7]');
        $this->form_validation->set_rules('ios_catchup', 'Limit Day Catchup IOS', 'required|integer|greater_than[0]|less_than_equal_to[7]');

        if ($this->form_validation->run() == FALSE) {
            $data['selected_genres'] = $this->input->post('genre');
            $data['selected_owner'] = set_value('owner');
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('tv_channels/create', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $sid = $this->Tv_channel_model->sid();
            $allowed_pc = ($this->input->post('allowed_pc') == '1') ? 1 : 0;
            $allowed_stb = ($this->input->post('allowed_stb') == '1') ? 1 : 0;
            $allowed_android = ($this->input->post('allowed_android') == '1') ? 1 : 0;
            $allowed_ios = ($this->input->post('allowed_ios') == '1') ? 1 : 0;
            $allowed_catchup = ($this->input->post('allowed_catchup') == '1') ? 1 : 0;
            $flag = $allowed_catchup.$allowed_pc.$allowed_stb.$allowed_ios.$allowed_android;
            $web_catchup = $this->input->post('web_catchup');
            $stb_catchup = $this->input->post('stb_catchup');
            $android_catchup = $this->input->post('android_catchup');
            $ios_catchup = $this->input->post('ios_catchup');
            $catchup_day_limit = $web_catchup.$stb_catchup.$android_catchup.$ios_catchup;
            $tv_data = [
                'channelid' => $this->input->post('sort_id'),
                'genrelist' => ','.implode(",", $this->input->post('genre',TRUE)).',',
                'sortid' => $sid + 1,
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'file1' => basename($this->input->post('poster_content1')),
                'file3' => $this->input->post('poster_content2'),
                'play_url' => $this->input->post('url_web'),
                'play_url_stb' => $this->input->post('url_stb'),
                'play_url_ios_phone' => $this->input->post('url_iphone'),
                'play_url_ios_pad' => $this->input->post('url_ipad'),
                'play_url_android_phone' => $this->input->post('url_adrphone'),
                'play_url_android_pad' => $this->input->post('url_adrpad'),
                'tvod_url' => $this->input->post('tvod_web'),
                'tvod_url_stb' => $this->input->post('tvod_stb'),
                'tvod_url_ios_phone' => $this->input->post('tvod_iphone'),
                'tvod_url_ios_pad' => $this->input->post('tvod_ipad'),
                'tvod_url_android_phone' => $this->input->post('tvod_adrphone'),
                'tvod_url_android_pad' => $this->input->post('tvod_adrpad'),
                'watching' => $this->input->post('trial_period'),
                'price' => $this->input->post('list_price'),
                'price2' => $this->input->post('sell_price'),
                'date1' => $this->input->post('start_time'),
                'date2' => $this->input->post('end_time'),
                'flag' => $flag,
                'update_date' => $time,
                'member_area' => $CI->session->userdata('role_id'),
                'member_id' => $CI->session->userdata('username'),
                'catchup_day_limit' => $catchup_day_limit,
                'event' => $this->input->post('event'),
                'limit_access' => $this->input->post('limit_access'),
                'banner_url' => $this->input->post('banner_url'),
                'link_url' => $this->input->post('link_url'),
                'trailer_url' => $this->input->post('trailer_url'),
                'owner' => $this->input->post('owner'),
            ];
            $saved = $this->Tv_channel_model->insert_tv_channel($tv_data);
            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>TV Channel berhasil disimpan</div>'); 
                return redirect('tv_channels');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>TV Channel tidak berhasil disimpan</div>');
                return redirect('tv_channels');
            }
        }
    }

    public function edit($id = null) {
        $CI =& get_instance();
        if (!$id) show_404();
        $tvchannel = $this->Tv_channel_model->get_tv_by_id($id);
        if (!$tvchannel) show_404();

        $data['title'] = 'Edit TV Channel';
        $data['tvchannel'] = $tvchannel;

        $this->form_validation->set_rules('poster_content1', 'Logo Square', 'required', ['required' => 'Logo Square harus dipilih']);
        $this->form_validation->set_rules('poster_content2', 'Logo Landscape', 'required', ['required' => 'Logo Landscape harus dipilih']);
        $this->form_validation->set_rules('genre[]', 'Genre', 'required', ['required' => 'Genre harus dipilih']);
        $current_title = $tvchannel['tv_channel']['title'];
        $input_title = $this->input->post('title');
        $title_rule = 'required';
        if (trim(strtolower($input_title)) !== trim(strtolower($current_title))) {
            $title_rule .= '|is_unique[tv_channel.title]';
        }
        $this->form_validation->set_rules('title', 'Title', $title_rule, [
            'required' => 'Title harus diisi',
            'is_unique' => 'Title sudah digunakan'
        ]);
        $this->form_validation->set_rules('description', 'Description', 'required', ['required' => 'Description harus diisi']);
        $this->form_validation->set_rules('sort_id', 'Sort ID', 'required|regex_match[/^[0-9]+$/]', [
            'required' => 'Sort ID harus diisi',
            'regex_match' => 'Sort ID diisi harus dengan angka'
        ]);
        $this->form_validation->set_rules('trial_period', 'Trial Period', 'required|regex_match[/^[0-9]+$/]', [
            'required' => 'Trial Period harus diisi',
            'regex_match' => 'Trial Period diisi harus dengan angka'
        ]);
        $this->form_validation->set_rules('list_price', 'List Price', 'required|regex_match[/^[0-9]+$/]', [
            'required' => 'List Price harus diisi',
            'regex_match' => 'List Price diisi harus dengan angka'
        ]);
        $this->form_validation->set_rules('sell_price', 'Sell Price', 'required|regex_match[/^[0-9]+$/]', [
            'required' => 'Sell Price harus diisi',
            'regex_match' => 'Sell Price diisi harus dengan angka'
        ]);
        $this->form_validation->set_rules('start_time', 'Start Time', 'required', ['required' => 'Start Time harus dipilih']);
        $this->form_validation->set_rules('end_time', 'End Time', 'required', ['required' => 'End Time harus dipilih']);
        $this->form_validation->set_rules('web_catchup', 'Limit Day Catchup PC', 'required|integer|greater_than[0]|less_than_equal_to[7]');
        $this->form_validation->set_rules('stb_catchup', 'Limit Day Catchup STB', 'required|integer|greater_than[0]|less_than_equal_to[7]');
        $this->form_validation->set_rules('android_catchup', 'Limit Day Catchup Android', 'required|integer|greater_than[0]|less_than_equal_to[7]');
        $this->form_validation->set_rules('ios_catchup', 'Limit Day Catchup IOS', 'required|integer|greater_than[0]|less_than_equal_to[7]');

        if ($this->form_validation->run() == FALSE) {
            $data['selected_genres'] = $this->input->post('genre');
            $data['selected_owner'] = set_value('owner');
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('tv_channels/edit', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $sid = $this->Tv_channel_model->sid();
            $allowed_pc = ($this->input->post('allowed_pc') == '1') ? 1 : 0;
            $allowed_stb = ($this->input->post('allowed_stb') == '1') ? 1 : 0;
            $allowed_android = ($this->input->post('allowed_android') == '1') ? 1 : 0;
            $allowed_ios = ($this->input->post('allowed_ios') == '1') ? 1 : 0;
            $allowed_catchup = ($this->input->post('allowed_catchup') == '1') ? 1 : 0;
            $flag = $allowed_catchup.$allowed_pc.$allowed_stb.$allowed_ios.$allowed_android;
            $web_catchup = $this->input->post('web_catchup');
            $stb_catchup = $this->input->post('stb_catchup');
            $android_catchup = $this->input->post('android_catchup');
            $ios_catchup = $this->input->post('ios_catchup');
            $catchup_day_limit = $web_catchup.$stb_catchup.$android_catchup.$ios_catchup;
            $tv_data = [
                'seq' => $id,
                'channelid' => $this->input->post('sort_id'),
                'genrelist' => ','.implode(",", $this->input->post('genre',TRUE)).',',
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'file1' => basename($this->input->post('poster_content1')),
                'file3' => $this->input->post('poster_content2'),
                'play_url' => $this->input->post('url_web'),
                'play_url_stb' => $this->input->post('url_stb'),
                'play_url_ios_phone' => $this->input->post('url_iphone'),
                'play_url_ios_pad' => $this->input->post('url_ipad'),
                'play_url_android_phone' => $this->input->post('url_adrphone'),
                'play_url_android_pad' => $this->input->post('url_adrpad'),
                'tvod_url' => $this->input->post('tvod_web'),
                'tvod_url_stb' => $this->input->post('tvod_stb'),
                'tvod_url_ios_phone' => $this->input->post('tvod_iphone'),
                'tvod_url_ios_pad' => $this->input->post('tvod_ipad'),
                'tvod_url_android_phone' => $this->input->post('tvod_adrphone'),
                'tvod_url_android_pad' => $this->input->post('tvod_adrpad'),
                'watching' => $this->input->post('trial_period'),
                'price' => $this->input->post('list_price'),
                'price2' => $this->input->post('sell_price'),
                'date1' => $this->input->post('start_time'),
                'date2' => $this->input->post('end_time'),
                'flag' => $flag,
                'update_date' => $time,
                'member_area' => $CI->session->userdata('role_id'),
                'member_id' => $CI->session->userdata('username'),
                'catchup_day_limit' => $catchup_day_limit,
                'event' => $this->input->post('event'),
                'limit_access' => $this->input->post('limit_access'),
                'banner_url' => $this->input->post('banner_url'),
                'link_url' => $this->input->post('link_url'),
                'trailer_url' => $this->input->post('trailer_url'),
                'owner' => $this->input->post('owner'),
            ];
            $saved = $this->Tv_channel_model->update_tv_channel($tv_data);
            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>TV Channel berhasil diubah</div>'); 
                return redirect('tv_channels');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>TV Channel tidak berhasil diubah</div>');
                return redirect('tv_channels');
            }
        }
    }

    public function activated_tv_channel($id)
    {
        if (!isset($id)) show_404();
        
        if ($this->Tv_channel_model->activated_tv_channel($id)) {
            redirect(site_url('tv_channels'));
        }
    }

    public function inactivated_tv_channel($id)
    {
        if (!isset($id)) show_404();
        
        if ($this->Tv_channel_model->inactivated_tv_channel($id)) {
            redirect(site_url('tv_channels'));
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

    public function compare_image_square()
    {
        echo json_encode($this->get_image_square());
    }

    private function get_image_square()
    {
        $data = array();
        $_arrFolder = array();
        $_urlimage = array();

        //formed array from server
        $path = 'tv_183x174/';
        $changeDir = 'tv_183x174/';
        $listimg = $this->libadapter->getImages($path, $changeDir);
        if ($listimg['error'] == 0) {
            $_arrFolder = array();
            $listimg1 = $listimg['content'];
            foreach ($listimg1 as $key => $value) {
                $_arrFolder[] = $value['url'];
            }
            krsort($_arrFolder);

            //formed array from database
            $urlimage = $this->Tv_channel_model->getimagesquare();
            if ($urlimage!=null) {
                foreach ($urlimage as $key => $value) {
                    array_push($_urlimage, 'https://picture.dens.tv/tv_183x174/' . basename($value['file1']));
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
        $path = 'wp/img/tvchannels_v1/340x160/';
        $changeDir = 'wp/img/tvchannels_v1/340x160/';
        $listimg = $this->libadapter->getImages($path, $changeDir);
        if ($listimg['error'] == 0) {
            $_arrFolder = array();
            $listimg1 = $listimg['content'];
            foreach ($listimg1 as $key => $value) {
                $_arrFolder[] = $value['url'];
            }
            krsort($_arrFolder);

            //formed array from database
            $urlimage = $this->Tv_channel_model->getimagelandscape();
            if ($urlimage!=null) {
                foreach ($urlimage as $key => $value) {
                    array_push($_urlimage, self::$baseurlimage . $path . basename($value['file3']));
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
