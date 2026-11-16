<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Section_packages extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user')) {
            redirect('auth');
        }
        if (!has_permission('view_sectionpackages')) {
            show_error('Anda tidak memiliki akses ke halaman ini', 403, 'Forbidden');
        }
        $this->load->config('secure_config');
        $this->load->library('pagination');
        $this->load->library('libadapter');
        $this->load->model('Section_package_model');
    }

    private static $baseurlimage = 'https://picture.dens.tv/wp/';

    public function index()
    {
        $data['title'] = 'List Section Packages';
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('section_packages/index', $data);
        $this->load->view('layouts/footer');
    }

    public function getListTypeSection()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        
        $offset = max(0, ($page - 1) * $perPage);

        $results = $this->Section_package_model->getListTypeSection($perPage, $offset, $searchTerm, 'data');

        $countResults = $this->Section_package_model->getListTypeSection($perPage, $offset, $searchTerm, 'count');

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

    public function getSingleTypeSection()
    {
        $id = $this->input->post('id');

        $data = $this->Section_package_model->getSingleTypeSection($id);

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

    public function getListDeviceSection()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        
        $offset = max(0, ($page - 1) * $perPage);

        $results = $this->Section_package_model->getListDeviceSection($perPage, $offset, $searchTerm, 'data');

        $countResults = $this->Section_package_model->getListDeviceSection($perPage, $offset, $searchTerm, 'count');

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

    public function getSingleDeviceSection()
    {
        $id = $this->input->post('id');

        $data = $this->Section_package_model->getSingleDeviceSection($id);

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

    public function list_sections($key_search=null, $sort_by='seq', $order_sort='desc', $visible='Y', $type='0', $device='10', $rowperpage=10, $rowno=0)
    {
        if ($rowno != 0) {
            $rowno = ($rowno-1) * $rowperpage;
        }

        $key_search = urldecode($key_search);

        $allcount = $this->Section_package_model->getCountSectionAll($key_search, $visible, $type, $device);
        $users_record = $this->Section_package_model->getDatasSection($key_search, $sort_by, $order_sort, $visible, $type, $device, $rowperpage, $rowno);

        // Pagination Configuration
        $config['base_url'] = base_url().'section_packages/list_sections/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$visible.'/'.$type.'/'.$device.'/'.$rowperpage.'/'.$rowno;
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
        $page_id_array = $this->input->post('page_id_array');
        $type = $this->input->post('type');
        $device = $this->input->post('device');
        $action = $this->input->post('action');

        if (empty($page_id_array) || $action != 'update') {
            echo json_encode([
                'error' => '1',
                'message' => 'Invalid request'
            ]);
            return;
        }

        for ($count = 0; $count < count($page_id_array); $count++) {
            $sort = $count + 1;
            $idPackage = $page_id_array[$count];

            $this->Section_package_model->update_sort($idPackage, $sort, $type, $device);
        }

        echo json_encode([
            'error' => '0',
            'message' => 'Sorting updated successfully'
        ]);
    }

    public function activatedSection($id, $type, $device)
    {
        if (!isset($id)) show_404();
        
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');
        $inactivated = $this->Section_package_model->activatedSection($id, $type, $device, $time);
        if ($inactivated == true) {
            $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Activated has been successfully!</div>');
            redirect(site_url('section_packages'));
        } else {
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Activated is failed!</div>');
            redirect(site_url('section_packages'));
        }
    }

    public function inactivatedSection($id, $type, $device)
    {
        if (!isset($id)) show_404();
        
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');
        $inactivated = $this->Section_package_model->inactivatedSection($id, $type, $device, $time);
        if ($inactivated == true) {
            $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Inactivated has been successfully!</div>');
            redirect(site_url('section_packages'));
        } else {
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Inactivated is failed!</div>');
            redirect(site_url('section_packages'));
        }
    }

    public function getListPackageSection()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }

        $results = $this->Section_package_model->getListPackageSection($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Section_package_model->getListPackageSection($perPage, $page, $searchTerm, 'count');
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

    public function getSinglePackageSection()
    {
        $id = $this->input->post('id');
        $data = $this->Section_package_model->getSinglePackageSection($id);
        echo json_encode([
            'id' => $data->seq,
            'text' => $data->title
        ]);
    }

    public function getListBooleanSection()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        
        $offset = max(0, ($page - 1) * $perPage);

        $results = $this->Section_package_model->getListBooleanSection($perPage, $offset, $searchTerm, 'data');

        $countResults = $this->Section_package_model->getListBooleanSection($perPage, $offset, $searchTerm, 'count');

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

    public function getSingleBooleanSection()
    {
        $id = $this->input->post('id');

        $data = $this->Section_package_model->getSingleBooleanSection($id);

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

    public function getListPackageAddonSection()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        
        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }

        $results = $this->Section_package_model->getListPackageAddonSection($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Section_package_model->getListPackageAddonSection($perPage, $page, $searchTerm, 'count');
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

    public function getMultiplePackageAddonSection()
    {
        $ids = $this->input->post('ids');
        if (!is_array($ids)) {
            $ids = [$ids];
        }
        $genres = [];
        foreach ($ids as $id) {
            $group = $this->Section_package_model->getMultiplePackageAddonSection($id);
            if ($group) {
                $genres[] = [
                    'id' => $group->seq,
                    'text' => $group->title
                ];
            }
        }
        echo json_encode($genres);
    }

    public function getListButtonFlagSection()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        
        $offset = max(0, ($page - 1) * $perPage);

        $results = $this->Section_package_model->getListButtonFlagSection($perPage, $offset, $searchTerm, 'data');

        $countResults = $this->Section_package_model->getListButtonFlagSection($perPage, $offset, $searchTerm, 'count');

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

    public function getSingleButtonFlagSection()
    {
        $id = $this->input->post('id');

        $data = $this->Section_package_model->getSingleButtonFlagSection($id);

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

    public function getListBuyAddonSection()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        
        $offset = max(0, ($page - 1) * $perPage);

        $results = $this->Section_package_model->getListBuyAddonSection($perPage, $offset, $searchTerm, 'data');

        $countResults = $this->Section_package_model->getListBuyAddonSection($perPage, $offset, $searchTerm, 'count');

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

    public function getSingleBuyAddonSection()
    {
        $id = $this->input->post('id');

        $data = $this->Section_package_model->getSingleBuyAddonSection($id);

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

    public function getToken()
    {
        $toURL = $this->config->item('url_token_uploader');
        $post = array();
        $exe = $this->libadapter->execurl($toURL, $post);
        $_token = json_decode($exe['data'],true);
        echo $_token['token'];
    }

    public function compareBannerImage()
    {
        echo json_encode($this->getImageBannerLandscape());
    }

    private function getImageBannerLandscape()
    {
        $data = array();
        $_arrFolder = array();
        $_urlimage = array();
        
        //formed array from server
        $path = 'wp/img/addon_banner_v1/470x260/';
        $changeDir = 'wp/img/addon_banner_v1/470x260/';
        $listimg = $this->libadapter->getImages($path, $changeDir);
        
        if ($listimg['error'] == 0) {
            $_arrFolder = array();
            $listimg1 = $listimg['content'];
            foreach ($listimg1 as $key => $value) {
                $_arrFolder[] = $value['url'];
            }
            krsort($_arrFolder);
            
            //formed array from database
            $urlimage = $this->Section_package_model->getImageBannerLandscape();
            
            if ($urlimage != null) {
                foreach ($urlimage as $key => $value) {
                    array_push($_urlimage, self::$baseurlimage . $path . basename($value['banner_url']));
                }
            }
            
            $datas=array_values(array_diff($_arrFolder, $_urlimage));
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

    public function comparePopupImage()
    {
        echo json_encode($this->getImagePopupLandscape());
    }

    private function getImagePopupLandscape()
    {
        $data = array();
        $_arrFolder = array();
        $_urlimage = array();
        
        //formed array from server
        $path = 'wp/img/addon_popup_v1/970x501/';
        $changeDir = 'wp/img/addon_popup_v1/970x501/';
        $listimg = $this->libadapter->getImages($path, $changeDir);
        
        if ($listimg['error'] == 0) {
            $_arrFolder = array();
            $listimg1 = $listimg['content'];
            foreach ($listimg1 as $key => $value) {
                $_arrFolder[] = $value['url'];
            }
            krsort($_arrFolder);
            
            //formed array from database
            $urlimage = $this->Section_package_model->getImagePopupLandscape();
            
            if ($urlimage != null) {
                foreach ($urlimage as $key => $value) {
                    array_push($_urlimage, self::$baseurlimage . $path . basename($value['popup_url']));
                }
            }
            
            $datas=array_values(array_diff($_arrFolder, $_urlimage));
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

    public function create()
    {
        $CI =& get_instance();
        $data['title'] = 'Add Section Package';
        
        $this->form_validation->set_rules('package_type', 'Package Type', 'required', ['required' => 'Package Type harus dipilih']);
        $this->form_validation->set_rules('device', 'Device', 'required', ['required' => 'Device harus dipilih']);

        if ($this->form_validation->run() == FALSE) {
            $data['selected_type'] = set_value('package_type');
            $data['selected_device'] = set_value('device');
            $data['selected_package'] = set_value('package');
            $data['selected_renewal'] = set_value('renewal');
            $data['selected_optional_addon'] = set_value('optional_addon');
            $data['selected_required_signin'] = set_value('required_signin');
            $data['selected_button_flag'] = set_value('button_flag');
            $data['selected_buy_addon'] = set_value('buy_addon');
            $data['selected_include_addon'] = $this->input->post('include_addon');
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('section_packages/create', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');

            $type = $this->input->post('package_type');
            if ($type == '0') {
                $includeAddon = $this->input->post('include_addon');
                if ($includeAddon != null) {
                    $includeAddon = ',' . implode(",", $includeAddon) . ',';
                }

                $labelButtonSudahSignin = $this->input->post('label_button_sudah_signin');
                $labelButtonBelumSignin = $this->input->post('label_button_belum_signin');
                if ($labelButtonSudahSignin == null || $labelButtonBelumSignin == null) {
                    $label_button = array();
                } else {
                    $requiredSignin = $this->input->post('required_signin');
                    if ($requiredSignin == 0) {
                        $requiredSignin = false;
                    } else {
                        $requiredSignin = true;
                    }

                    $label_button = array(
                        'signin' => $labelButtonSudahSignin,
                        'not_signin' => $labelButtonBelumSignin,
                        'flag' => $this->input->post('button_flag'),
                        'required_signin' => $requiredSignin,
                    );
                }

                $label_button = json_encode($label_button);

                $section_data = [
                    'id_package' => $this->input->post('package'),
                    'price1' => $this->input->post('price1'),
                    'price2' => $this->input->post('price2'),
                    'label1' => $this->input->post('label_deal'),
                    'label2' => $this->input->post('label_access'),
                    'list' => $this->input->post('list', false),
                    'include_addon' => $includeAddon,
                    'type_package' => '0',
                    'group_name' => $this->input->post('group_name'),
                    'optional_addon' => $this->input->post('optional_addon'),
                    'heading' => $this->input->post('heading'),
                    'sub_heading' => $this->input->post('sub_heading'),
                    'label_button' => $label_button,
                    'notes' => $this->input->post('notes'),
                    'app_type' => $this->input->post('device'),
                    'id_package_apple' => $this->input->post('id_package_apple') ?? null,
                    'id_package_android' => $this->input->post('id_package_android') ?? null,
                    'renewal' => $this->input->post('renewal'),
                    'visible' => 'N',
                    'create_date' => $time,
                    'update_date' => $time,
                    'ctrloc' => '/section_packages/create'
                ];
            } else {
                $section_data = array(
                    'id_package' => $this->input->post('package'),
                    'price1' => $this->input->post('price1'),
                    'price2' => $this->input->post('price2'),
                    'only_addon' => $this->input->post('buy_addon'),
                    'banner_url' => $this->input->post('banner_image'),
                    'popup_url' => $this->input->post('popup_image'),
                    'type_package' => '1',
                    'app_type' => $this->input->post('device'),
                    'id_package_apple' => $this->input->post('id_package_apple') ?? null,
                    'id_package_android' => $this->input->post('id_package_android') ?? null,
                    'visible' => 'N',
                    'create_date' => $time,
                    'update_date' => $time,
                    'ctrloc' => '/section_packages/create'
                );
            }

            $saved = $this->Section_package_model->insertSection($section_data);

            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Data berhasil disimpan</div>');
                return redirect('section_packages');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Data tidak berhasil disimpan</div>');
                return redirect('section_packages');
            }
        }
    }

    public function edit($id = null)
    {
        $CI =& get_instance();
        if (!$id) show_404();
        $sections = $this->Section_package_model->getSectionById($id);
        // print_r($sections);die();
        if (!$sections) show_404();
        $data['title'] = 'Edit Section Package';
        $data['sections'] = $sections;

        $this->form_validation->set_rules('package_type', 'Package Type', 'required', ['required' => 'Package Type harus dipilih']);
        $this->form_validation->set_rules('device', 'Device', 'required', ['required' => 'Device harus dipilih']);

        if ($this->form_validation->run() == FALSE) {
            $data['selected_type'] = set_value('package_type') ?: $sections['type_package'];
            $data['selected_device'] = set_value('device') ?: $sections['app_type'];
            $data['selected_package'] = set_value('package') ?: $sections['id_package'];
            $data['selected_renewal'] = set_value('renewal') ?: $sections['renewal'];
            $data['selected_optional_addon'] = set_value('optional_addon') ?: $sections['optional_addon'];
            $data['selected_required_signin'] = set_value('required_signin') ?: $sections['required_signin'];
            $data['selected_button_flag'] = set_value('button_flag') ?: $sections['flag'];
            $data['selected_buy_addon'] = set_value('buy_addon') ?: $sections['only_addon'];
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('section_packages/edit', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');

            $type = $this->input->post('package_type');
            if ($type == '0') {
                $includeAddon = $this->input->post('include_addon');
                if ($includeAddon != null) {
                    $includeAddon = ',' . implode(",", $includeAddon) . ',';
                }

                $labelButtonSudahSignin = $this->input->post('label_button_sudah_signin');
                $labelButtonBelumSignin = $this->input->post('label_button_belum_signin');
                if ($labelButtonSudahSignin == null || $labelButtonBelumSignin == null) {
                    $label_button = array();
                } else {
                    $requiredSignin = $this->input->post('required_signin');
                    if ($requiredSignin == 0) {
                        $requiredSignin = false;
                    } else {
                        $requiredSignin = true;
                    }

                    $label_button = array(
                        'signin' => $labelButtonSudahSignin,
                        'not_signin' => $labelButtonBelumSignin,
                        'flag' => $this->input->post('button_flag'),
                        'required_signin' => $requiredSignin,
                    );
                }

                $label_button = json_encode($label_button);

                $section_data = [
                    'id_package' => $this->input->post('package'),
                    'price1' => $this->input->post('price1'),
                    'price2' => $this->input->post('price2'),
                    'label1' => $this->input->post('label_deal'),
                    'label2' => $this->input->post('label_access'),
                    'list' => $this->input->post('list', false),
                    'include_addon' => $includeAddon,
                    'type_package' => '0',
                    'group_name' => $this->input->post('group_name'),
                    'optional_addon' => $this->input->post('optional_addon'),
                    'heading' => $this->input->post('heading'),
                    'sub_heading' => $this->input->post('sub_heading'),
                    'label_button' => $label_button,
                    'notes' => $this->input->post('notes'),
                    'app_type' => $this->input->post('device'),
                    'id_package_apple' => $this->input->post('id_package_apple') ?? null,
                    'id_package_android' => $this->input->post('id_package_android') ?? null,
                    'renewal' => $this->input->post('renewal'),
                    'update_date' => $time,
                    'ctrloc' => '/section_packages/edit'
                ];
            } else {
                $section_data = array(
                    'id_package' => $this->input->post('package'),
                    'price1' => $this->input->post('price1'),
                    'price2' => $this->input->post('price2'),
                    'only_addon' => $this->input->post('buy_addon'),
                    'banner_url' => $this->input->post('banner_image'),
                    'popup_url' => $this->input->post('popup_image'),
                    'type_package' => '1',
                    'app_type' => $this->input->post('device'),
                    'id_package_apple' => $this->input->post('id_package_apple') ?? null,
                    'id_package_android' => $this->input->post('id_package_android') ?? null,
                    'update_date' => $time,
                    'ctrloc' => '/section_packages/edit'
                );
            }
            
            $saved = $this->Section_package_model->updateSection($id, $section_data);

            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Data berhasil diubah</div>'); 
                return redirect('section_packages');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Data tidak berhasil diubah</div>');
                return redirect('section_packages');
            }
        }
    }
}
