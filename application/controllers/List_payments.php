<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class List_payments extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user')) {
            redirect('auth');
        }
        if (!has_permission('view_listpayments')) {
            show_error('Anda tidak memiliki akses ke halaman ini', 403, 'Forbidden');
        }
        $this->load->config('secure_config');
        $this->load->library('pagination');
        $this->load->library('libadapter');
        $this->load->model('List_payment_model');
    }

    private static $baseurlimage = 'https://picture.dens.tv/wp/';

    public function index()
    {
        $data['title'] = 'List Payments';
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('list_payments/index', $data);
        $this->load->view('layouts/footer');
    }

    public function list_payments($key_search=null, $sort_by='seq', $order_sort='desc', $visible='Y', $rowperpage=10, $rowno=0)
    {
        if ($rowno != 0) {
            $rowno = ($rowno-1) * $rowperpage;
        }

        $key_search = urldecode($key_search);

        $allcount = $this->List_payment_model->getCountSectionAll($key_search, $visible);
        $users_record = $this->List_payment_model->getDatasSection($key_search, $sort_by, $order_sort, $visible, $rowperpage, $rowno);

        // Pagination Configuration
        $config['base_url'] = base_url().'list_payments/list_payments/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$visible.'/'.$rowperpage.'/'.$rowno;
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
            $idPayment = $page_id_array[$count];

            $this->List_payment_model->update_sort($idPayment, $sort);
        }

        echo json_encode([
            'error' => '0',
            'message' => 'Sorting updated successfully'
        ]);
    }

    public function activatedPayment($id)
    {
        if (!isset($id)) show_404();
        
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');
        $inactivated = $this->List_payment_model->activatedPayment($id, $time);
        if ($inactivated == true) {
            $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Activated has been successfully!</div>');
            redirect(site_url('list_payments'));
        } else {
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Activated is failed!</div>');
            redirect(site_url('list_payments'));
        }
    }

    public function inactivatedPayment($id)
    {
        if (!isset($id)) show_404();
        
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');
        $inactivated = $this->List_payment_model->inactivatedPayment($id, $time);
        if ($inactivated == true) {
            $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Inactivated has been successfully!</div>');
            redirect(site_url('list_payments'));
        } else {
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Inactivated is failed!</div>');
            redirect(site_url('list_payments'));
        }
    }

    public function getListType()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        
        $offset = max(0, ($page - 1) * $perPage);

        $results = $this->List_payment_model->getListType($perPage, $offset, $searchTerm, 'data');

        $countResults = $this->List_payment_model->getListType($perPage, $offset, $searchTerm, 'count');

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

        $data = $this->List_payment_model->getSingleType($id);

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
        $path = 'wp/img/paymentch_v1/10000x535/';
        $changeDir = 'wp/img/paymentch_v1/10000x535/';
        $listimg = $this->libadapter->getImages($path, $changeDir);
        
        if ($listimg['error'] == 0) {
            $_arrFolder = array();
            $listimg1 = $listimg['content'];
            foreach ($listimg1 as $key => $value) {
                $_arrFolder[] = $value['url'];
            }
            krsort($_arrFolder);
            
            //formed array from database
            $urlimage = $this->List_payment_model->getImageBannerLandscape();
            
            if ($urlimage != null) {
                foreach ($urlimage as $key => $value) {
                    array_push($_urlimage, self::$baseurlimage . $path . basename($value['payment_image']));
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
        $data['title'] = 'Add Payment';
        
        $this->form_validation->set_rules('title', 'Title', 'required', ['required' => 'Title harus diisi']);
        $this->form_validation->set_rules('payment_channel', 'Payment Channel', 'required', ['required' => 'Payment Channel harus diisi']);
        $this->form_validation->set_rules('bank_code', 'Bank Code', 'required', ['required' => 'Bank Code harus diisi']);
        $this->form_validation->set_rules('type', 'Admin Fee Type', 'required', ['required' => 'Admin Fee Type harus dipilih']);
        $this->form_validation->set_rules('admin_fee', 'Admin Fee', 'required', ['required' => 'Admin Fee harus diisi']);
        $this->form_validation->set_rules('url_api_transaction', 'URL API Transaction', 'required', ['required' => 'URL API Transaction harus diisi']);
        $this->form_validation->set_rules('banner_image', 'Image', 'required', ['required' => 'Image harus dipilih']);

        if ($this->form_validation->run() == FALSE) {
            $data['selected_type'] = set_value('type');
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('list_payments/create', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');

            $payment_data = [
                'payment_title' => $this->input->post('title'),
                'payment_channel' => $this->input->post('payment_channel'),
                'bank_code' => $this->input->post('bank_code'),
                'payment_image' => $this->input->post('banner_image'),
                'api_url' => $this->input->post('url_api_transaction'),
                'api_url_status' => $this->input->post('url_api_status'),
                'admin_fee' => $this->input->post('admin_fee'),
                'admin_fee_type' => $this->input->post('type'),
                'create_date' => $time,
                'update_date' => $time,
                'ctrloc' => '/list_payments/create'
            ];

            $saved = $this->List_payment_model->insertPayment($payment_data);

            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Data berhasil disimpan</div>');
                return redirect('list_payments');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Data tidak berhasil disimpan</div>');
                return redirect('list_payments');
            }
        }
    }

    public function edit($id = null)
    {
        $CI =& get_instance();
        if (!$id) show_404();
        $payments = $this->List_payment_model->getPaymentById($id);
        if (!$payments) show_404();
        $data['title'] = 'Edit Payment';
        $data['payments'] = $payments;

        $this->form_validation->set_rules('title', 'Title', 'required', ['required' => 'Title harus diisi']);
        $this->form_validation->set_rules('payment_channel', 'Payment Channel', 'required', ['required' => 'Payment Channel harus diisi']);
        $this->form_validation->set_rules('bank_code', 'Bank Code', 'required', ['required' => 'Bank Code harus diisi']);
        $this->form_validation->set_rules('type', 'Admin Fee Type', 'required', ['required' => 'Admin Fee Type harus dipilih']);
        $this->form_validation->set_rules('admin_fee', 'Admin Fee', 'required', ['required' => 'Admin Fee harus diisi']);
        $this->form_validation->set_rules('url_api_transaction', 'URL API Transaction', 'required', ['required' => 'URL API Transaction harus diisi']);
        $this->form_validation->set_rules('banner_image', 'Image', 'required', ['required' => 'Image harus dipilih']);

        if ($this->form_validation->run() == FALSE) {
            $data['selected_type'] = set_value('type') ?: $payments['admin_fee_type'];
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('list_payments/edit', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');

            $payment_data = [
                'payment_title' => $this->input->post('title'),
                'payment_channel' => $this->input->post('payment_channel'),
                'bank_code' => $this->input->post('bank_code'),
                'payment_image' => $this->input->post('banner_image'),
                'api_url' => $this->input->post('url_api_transaction'),
                'api_url_status' => $this->input->post('url_api_status'),
                'admin_fee' => $this->input->post('admin_fee'),
                'admin_fee_type' => $this->input->post('type'),
                'update_date' => $time,
                'ctrloc' => '/list_payments/edit'
            ];
            
            $saved = $this->List_payment_model->updatePayment($id, $payment_data);

            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Data berhasil diubah</div>'); 
                return redirect('list_payments');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Data tidak berhasil diubah</div>');
                return redirect('list_payments');
            }
        }
    }
}
