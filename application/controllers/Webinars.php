<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webinars extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user')) {
            redirect('auth');
        }
        if (!has_permission('view_webinars')) {
            show_error('Anda tidak memiliki akses ke halaman ini', 403, 'Forbidden');
        }
        $this->load->config('secure_config');
        $this->load->library('pagination');
        $this->load->library('libadapter');
        $this->load->library('zoom_meetings');
        $this->load->model('Webinar_model');
    }

    private static $baseurlimage = 'https://picture.dens.tv/';

    public function index()
    {
        $data['title'] = 'List Webinar';
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('webinars/index', $data);
        $this->load->view('layouts/footer');
    }

    public function list_webinar($key_search=null, $sort_by='webinar_id', $order_sort='desc', $visible='Y', $rowperpage=10, $rowno=0)
    {
        if ($rowno != 0) {
            $rowno = ($rowno-1) * $rowperpage;
        }
        $allcount = $this->Webinar_model->getCountAll($key_search, $visible);
        $users_record = $this->Webinar_model->getDatas($key_search, $sort_by, $order_sort, $visible, $rowperpage, $rowno);
        // Pagination Configuration
        $config['base_url'] = base_url().'webinars/list_webinar/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$visible.'/'.$rowperpage.'/'.$rowno;
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

    public function activated($id)
    {
        if (!isset($id)) show_404();
        
        if ($this->Webinar_model->activated($id)) {
            redirect(site_url('webinars'));
        }
    }

    public function inactivated($id)
    {
        if (!isset($id)) show_404();
        
        if ($this->Webinar_model->inactivated($id)) {
            redirect(site_url('webinars'));
        }
    }

    public function get_urlrecord($webinar_id)
    {
        $get_url = $this->Webinar_model->getData('result', 'record_url, webinar_id', 'tab_webinar w', null, null, null, array('webinar_id' => $webinar_id));
        echo json_encode($get_url);
    }

    public function get_urlvod($webinar_id)
    {
        $get_url = $this->Webinar_model->getData('result', 'vod_url, webinar_id', 'tab_webinar w', null, null, null, array('webinar_id' => $webinar_id));
        echo json_encode($get_url);
    }

    public function update_record()
    {
        $CI =& get_instance();
        $this->form_validation->set_rules('urlrecord', 'Url Record', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->list();
        } else {
            $data = array(
                'record_url' => $this->input->post('urlrecord'),
                'updated_by' => $CI->session->userdata('username'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            $update = $this->Webinar_model->updateData('tab_webinar', $data, array('webinar_id' => $this->input->post('webinar_id')));
            if ($update) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil Disimpan</div>');
                redirect('webinars');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-warning alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Gagal di simpan</div>');
                redirect('webinars');
            }
        }
    }

    public function update_vod()
    {
        $CI =& get_instance();
        $this->form_validation->set_rules('urlvod', 'Url VOD', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->list();
        } else {
            $data = array(
                'vod_url' => $this->input->post('urlvod'),
                'updated_by' => $CI->session->userdata('username'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            $update = $this->Webinar_model->updateData('tab_webinar', $data, array('webinar_id' => $this->input->post('webinar_id')));
            if ($update) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil Disimpan</div>');
                redirect('webinars');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-warning alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Gagal di simpan</div>');
                redirect('webinars');
            }
        }
    }

    public function get_category()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }
        $results = $this->Webinar_model->get_category($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Webinar_model->get_category($perPage, $page, $searchTerm, 'count');
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
            $group = $this->Webinar_model->get_category_by_id($id);
            if ($group) {
                $genres[] = [
                    'id' => $group->keyword_id,
                    'text' => $group->keyword_name
                ];
            }
        }
        echo json_encode($genres);
    }

    public function save_keyword()
    {
        $this->form_validation->set_rules('keyword_name', 'Category name', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            alert('silahkan isi category!');
        } else {
            $keyword_name = $this->input->post('keyword_name');
            if ($keyword_name != null) { // && $keyword_ref != null
                $data = array(
                    'keyword_name'     => $keyword_name,
                    'keyword_sort'     => '1',
                    'keyword_child'    => 'SIN',
                    'keyword_sub'      => 'N',
                    'keyword_ref'      => 'WBR',
                    'keyword_visible'  => 'Y',
                );
                $insert = $this->Webinar_model->save_keyword($data);
                echo json_encode(array("status" => TRUE));
            } else {
                alert('data gagal disimpan');
            }
        }
    }

    public function create()
    {
        $CI =& get_instance();
        $data['title'] = 'Add Webinar';
        $this->form_validation->set_rules('category_id[]', 'Category', 'trim|required', [
            'required' => 'Category harus dipilih'
        ]);
        $this->form_validation->set_rules('email_confirmation', 'Email Template', 'trim|required', [
            'required' => 'Email Template harus diisi'
        ]);
        $this->form_validation->set_rules('vendor', 'Vendor', 'trim|required', [
            'required' => 'Vendor harus diisi'
        ]);
        $this->form_validation->set_rules('flag', 'Flag', 'required', [
            'required' => 'Flag harus dipilih'
        ]);
        $this->form_validation->set_rules('webinarID', 'Webinar ID', 'trim|required', [
            'required' => 'Webinar ID harus diisi'
        ]);
        $this->form_validation->set_rules('uuid', 'uuid', 'trim|required', [
            'required' => 'uuid harus diisi'
        ]);
        $this->form_validation->set_rules('webinarPassword', 'Webinar Password', 'trim');
        $this->form_validation->set_rules('hostID', 'hostID', 'trim|required', [
            'required' => 'hostID harus diisi'
        ]);
        $this->form_validation->set_rules('hostEmail', 'hostEmail', 'trim|required', [
            'required' => 'hostEmail harus diisi'
        ]);
        $this->form_validation->set_rules('topic', 'topic', 'trim|required', [
            'required' => 'topic harus diisi'
        ]);
        $this->form_validation->set_rules('agenda', 'agenda', 'trim|required', [
            'required' => 'agenda harus diisi'
        ]);
        $this->form_validation->set_rules('startTime', 'startTime', 'trim|required', [
            'required' => 'startTime harus diisi'
        ]);
        $this->form_validation->set_rules('duration', 'duration', 'trim|required', [
            'required' => 'duration harus diisi'
        ]);
        $this->form_validation->set_rules('joinUrl', 'joinUrl', 'trim|required', [
            'required' => 'joinUrl harus diisi'
        ]);
        $this->form_validation->set_rules('regisUrl', 'regisUrl', 'trim|required', [
            'required' => 'regisUrl harus diisi'
        ]);
        $this->form_validation->set_rules('dens_regis', 'dens_regis', 'trim|required', [
            'required' => 'dens_regis harus diisi'
        ]);
        $this->form_validation->set_rules('dens_join', 'dens_join', 'trim|required', [
            'required' => 'dens_join harus diisi'
        ]);
        if ($this->form_validation->run() == FALSE) {
            $data['selected_category'] = $this->input->post('category_id');
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('webinars/create', $data);
            $this->load->view('layouts/footer');
        } else {
            $webinarID = $this->input->post('webinarID', TRUE);
            $topic = $this->input->post('topic', TRUE);
            $checkData = $this->Webinar_model->checkData('webinarID', 'tab_webinar', array('webinarID' => $webinarID));
            if ($checkData != FALSE) {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Webinar ' . $topic . ' sudah di tambahkan sebelumnya!</div>');
                return redirect('webinars');
            } else {
                date_default_timezone_set("Asia/Jakarta");
                $time = date('Y-m-d H:i:s');
                $start = $this->input->post('startTime', TRUE);
                $durasi = $this->input->post('duration', TRUE);
                $end = date('Y-m-d H:i:s', strtotime('+' . $durasi . ' minutes', strtotime($start)));
                $keyid = implode(",", $this->input->post('category_id', TRUE));
                $webinar_data = [
                    'webinarID' => $webinarID,
                    'uuid' => $this->input->post('uuid', TRUE),
                    'host_id' => $this->input->post('hostID', TRUE),
                    'host_email' => $this->input->post('hostEmail', TRUE),
                    'webinarPassword' => $this->input->post('webinarPassword', TRUE),
                    'keyword_id' => ',' . $keyid . ',',
                    'topic' => $topic,
                    'agenda' => $this->input->post('agenda', TRUE),
                    'email_confirmation' => $this->input->post('email_confirmation', TRUE),
                    'vendor' => $this->input->post('vendor', TRUE),
                    'flag' => $this->input->post('flag', TRUE),
                    'start_time' => $start,
                    'end_time' => $end,
                    'duration' => $durasi,
                    'join_url' => $this->input->post('joinUrl', TRUE),
                    'registration_url' => $this->input->post('regisUrl', TRUE),
                    'dens_join_url' => $this->input->post('dens_join', TRUE),
                    'dens_regis_url' => $this->input->post('dens_regis', TRUE),
                    'is_visible' => 'Y',
                    'created_by' => $CI->session->userdata('username'),
                    'created_at' => $time
                ];
                $saved = $this->Webinar_model->insert_webinar($webinar_data);
                if ($saved == true) {
                    $getID = $this->mod->getData('row', 'webinar_id', 'tab_webinar', null, null, null, array('webinarID' => $webinarID));
                    $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Webinar berhasil disimpan</div>'); 
                    return redirect('webinars/create_edit_poster/'.$getID->webinar_id);
                } else {
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Webinar tidak berhasil disimpan</div>');
                    return redirect('webinars');
                }
            }
        }
    }

    public function edit($id = null) {
        $CI =& get_instance();
        if (!$id) show_404();
        $webinar = $this->Webinar_model->get_webinar_by_id($id);
        if (!$webinar) show_404();
        $data['title'] = 'Edit Webinar';
        $data['webinar'] = $webinar;
        $this->form_validation->set_rules('category_id[]', 'Category', 'trim|required', [
            'required' => 'Category harus dipilih'
        ]);
        $this->form_validation->set_rules('email_confirmation', 'Email Template', 'trim|required', [
            'required' => 'Email Template harus diisi'
        ]);
        $this->form_validation->set_rules('vendor', 'Vendor', 'trim|required', [
            'required' => 'Vendor harus diisi'
        ]);
        $this->form_validation->set_rules('flag', 'Flag', 'required', [
            'required' => 'Flag harus dipilih'
        ]);
        $this->form_validation->set_rules('webinarID', 'Webinar ID', 'trim|required', [
            'required' => 'Webinar ID harus diisi'
        ]);
        $this->form_validation->set_rules('uuid', 'uuid', 'trim|required', [
            'required' => 'uuid harus diisi'
        ]);
        $this->form_validation->set_rules('webinarPassword', 'Webinar Password', 'trim');
        $this->form_validation->set_rules('hostID', 'hostID', 'trim|required', [
            'required' => 'hostID harus diisi'
        ]);
        $this->form_validation->set_rules('hostEmail', 'hostEmail', 'trim|required', [
            'required' => 'hostEmail harus diisi'
        ]);
        $this->form_validation->set_rules('topic', 'topic', 'trim|required', [
            'required' => 'topic harus diisi'
        ]);
        $this->form_validation->set_rules('agenda', 'agenda', 'trim|required', [
            'required' => 'agenda harus diisi'
        ]);
        $this->form_validation->set_rules('startTime', 'startTime', 'trim|required', [
            'required' => 'startTime harus diisi'
        ]);
        $this->form_validation->set_rules('duration', 'duration', 'trim|required', [
            'required' => 'duration harus diisi'
        ]);
        $this->form_validation->set_rules('joinUrl', 'joinUrl', 'trim|required', [
            'required' => 'joinUrl harus diisi'
        ]);
        $this->form_validation->set_rules('regisUrl', 'regisUrl', 'trim|required', [
            'required' => 'regisUrl harus diisi'
        ]);
        $this->form_validation->set_rules('dens_regis', 'dens_regis', 'trim|required', [
            'required' => 'dens_regis harus diisi'
        ]);
        $this->form_validation->set_rules('dens_join', 'dens_join', 'trim|required', [
            'required' => 'dens_join harus diisi'
        ]);
        if ($this->form_validation->run() == FALSE) {
            $data['selected_category'] = $this->input->post('category_id') ?: array_column($webinar['categories'], 'keyword_id');
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('webinars/edit', $data);
            $this->load->view('layouts/footer');
        } else {
            $webinar_id = $this->input->post('webinar_id', TRUE);
            $start = $this->input->post('startTime', TRUE);
            $durasi = $this->input->post('duration', TRUE);
            $end = date('Y-m-d H:i:s', strtotime('+' . $durasi . ' minutes', strtotime($start)));
            $keyid = implode(",", $this->input->post('category_id', TRUE));
            date_default_timezone_set("Asia/Jakarta");
            $time = date('Y-m-d H:i:s');
            $webinar_data = [
                'webinar_id' => $webinar_id,
                'webinarID' => $webinarID,
                'uuid' => $this->input->post('uuid', TRUE),
                'host_id' => $this->input->post('hostID', TRUE),
                'host_email' => $this->input->post('hostEmail', TRUE),
                'webinarPassword' => $this->input->post('webinarPassword', TRUE),
                'keyword_id' => ',' . $keyid . ',',
                'topic' => $topic,
                'agenda' => $this->input->post('agenda', TRUE),
                'email_confirmation' => $this->input->post('email_confirmation', TRUE),
                'vendor' => $this->input->post('vendor', TRUE),
                'flag' => $this->input->post('flag', TRUE),
                'start_time' => $start,
                'end_time' => $end,
                'duration' => $durasi,
                'join_url' => $this->input->post('joinUrl', TRUE),
                'registration_url' => $this->input->post('regisUrl', TRUE),
                'dens_join_url' => $this->input->post('dens_join', TRUE),
                'dens_regis_url' => $this->input->post('dens_regis', TRUE),
                'updated_by' => $CI->session->userdata('username'),
                'updated_at' => $time
            ];
            $saved = $this->Webinar_model->update_webinar($webinar_data);
            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Webinar berhasil disimpan</div>'); 
                return redirect('webinars/create_edit_poster/'.$webinar_id);
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Webinar tidak berhasil disimpan</div>');
                return redirect('webinars');
            }
        }
    }

    private function _remap_webinar($data)
    {
        $result = $data;
        $routeRegis = 'https://www.dens.tv/webinar/register';
        $routeJoin = 'https://stage.dens.tv/webinar/join';
        // check its source data not empty
        if (!empty($data)) {
            // check if dataset of 'data' index is exist as an array
            if (is_array($data) && count($data) > 0) {
                foreach ($data as $key => $value) {
                    // store remap data contents
                    $result[$key] = $value;
                    // add 'title_slug' index into remap data contents
                    $result['dens_regis_url'] = $routeRegis . '?id=' . $result['id'] . '&t=' . $this->sanitizeString(strtolower($result['topic']));
                    $result['dens_join_url'] = $routeJoin . '?id=' . $result['id'] . '&t=' . $this->sanitizeString(strtolower($result['topic']));
                }
            }
        }
        return $result;
    }

    public function sanitizeString($string)
    {
        $special_chars = array("?", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "’", "&", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}");
        $string = str_replace($special_chars, '', $string);
        $string = preg_replace('/[\s-]+/', '-', $string);
        $string = trim($string, '.-_');
        return $string;
    }

    public function getWebinar()
    {
        $webID = $this->input->post('webinarID');
        $getAccess = json_decode($this->zoom_meetings->getAccessToken(), true);
        if (isset($getAccess["access_token"])) {
            $response = $this->zoom_meetings->webinar($webID, $getAccess["access_token"]);
            $decodeRes = json_decode($response, true);
            if (isset($decodeRes['code'])) {
                return $this->output->set_status_header(401)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($decodeRes));
            } else {
                $resp = $this->_remap_webinar($decodeRes);
                return $this->output->set_status_header(200)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($resp));
            }
        } else {
            return $this->output->set_status_header(401)
                ->set_content_type('application/json')
                ->set_output(json_encode($getAccess));
        }
    }

    public function create_edit_poster($id = null) {
        $CI =& get_instance();
        if (!$id) show_404();
        $webinar = $this->Webinar_model->get_poster_banner_by_id($id);
        if (!$webinar) show_404();
        $data['title'] = 'Manage Poster Banner';
        $data['webinar_id'] = $id;
        $data['posters'] = $webinar['result'] ?? [];
        $data['status'] = count($data['posters']) > 0 ? 'edit' : 'add';

        $this->form_validation->set_rules('poster_banner1', 'Poster Banner 1', 'required', ['required' => 'Poster Banner 1 harus dipilih']);
        $this->form_validation->set_rules('poster_banner2', 'Poster Banner 2', 'required', ['required' => 'Poster Banner 2 harus dipilih']);
        $this->form_validation->set_rules('poster_banner3', 'Poster Banner 3', 'required', ['required' => 'Poster Banner 3 harus dipilih']);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('webinars/poster_banner', $data);
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
                $saved = $this->Webinar_model->add_poster_banner($id,$poster_banner1,$poster_banner2,$poster_banner3,$time);
            } else {
                $saved = $this->Webinar_model->edit_poster_banner($id,$poster_banner1,$poster_banner2,$poster_banner3,$poster_id1,$poster_id2,$poster_id3,$time);
            }
            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Webinar & Poster berhasil disimpan</div>'); 
                return redirect('webinars');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Webinar & Poster tidak berhasil disimpan</div>');
                return redirect('webinars');
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
        $path = 'wp/img/webinar_v1/1280x720/';
        $changeDir = 'wp/img/webinar_v1/1280x720/';
        $listimg = $this->libadapter->getImages($path, $changeDir);
        if ($listimg['error'] == 0) {
            $_arrFolder = array();
            $listimg1 = $listimg['content'];
            foreach ($listimg1 as $key => $value) {
                $_arrFolder[] = $value['url'];
            }
            krsort($_arrFolder);
            //formed array from database
            $urlimage = $this->Webinar_model->getimagebanner();
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
