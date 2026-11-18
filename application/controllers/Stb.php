<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class Stb extends CI_Controller {

    private $baseUrl;
    private $usernamePartner;
    private $passwordPartner;
    private $getTokenPath;
    private $resetPath;
    private $tokenBearer;

	public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('user')) {
            redirect('auth');
        }
        if (!has_permission('view_stb')) {
            show_error('Anda tidak memiliki akses ke halaman ini', 403, 'Forbidden');
        }
        $this->load->config('secure_config');

        $this->baseUrl = $this->config->item('base_url_mnc');
        $this->usernamePartner = $this->config->item('username_mnc');
        $this->passwordPartner = $this->config->item('password_mnc');
        $this->getTokenPath = $this->config->item('path_token_mnc');
        $this->resetPath = $this->config->item('path_reset_mnc');
        $this->tokenBearer = $this->config->item('token_bearer_mnc');

        $this->load->library('pagination');
        $this->load->library('libadapter');
        $this->load->model('Stb_model');
    }

    public function index()
    {
        $data['title'] = 'STB';
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('stb/index', $data);
        $this->load->view('layouts/footer');
    }

    public function getListModel()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        
        $data = array(
            array(
                "id" => 'ALL',
                "text" => 'ALL'
            ),
            array(
                "id" => 'DENS10 MRVL88DE3108',
                "text" => 'STB V1'
            ),
            array(
                "id" => 'DENS20 CASTPAL-AW526',
                "text" => 'STB V2'
            ),
            array(
                "id" => 'DENS2X MKTECH-MMP-OTT 888',
                "text" => 'STB V2x'
            ),
            array(
                "id" => 'DENSZTE',
                "text" => 'STB V2y'
            ),
            array(
                "id" => 'ZTEATV',
                "text" => 'STB V3'
            ),
            array(
                "id" => 'MNC',
                "text" => 'STB MNC'
            ),
        );
        
        $select['total_count'] = count($data);
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function getListStatus()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        
        $data = array(
            array(
                "id" => 'All',
                "text" => 'All'
            ),
            array(
                "id" => '1',
                "text" => 'Not Login'
            ),
            array(
                "id" => '2',
                "text" => 'Login'
            ),
        );
        
        $select['total_count'] = count($data);
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function listStb($key_search=null, $model='ALL', $status='All', $date=null, $sort_by='seq', $order_by='DESC', $row_per_page=10, $page_number=0)
    {
        $key_search = urldecode($key_search);

        $model = urldecode($model);
        
        $date = urldecode($date);

        if ($page_number != 0) {
            $page_number = ($page_number-1) * $row_per_page;
        }

        $allcount = $this->Stb_model->getCountAll($key_search, $model, $status, $date);

        $users_record = $this->Stb_model->getDatas($key_search, $model, $status, $date, $sort_by, $order_by, $row_per_page, $page_number);
        
        $config['base_url'] = base_url().'stb/list_stb/'.$key_search.'/'.$model.'/'.$status.'/'.$date.'/'.$sort_by.'/'.$order_by.'/'.$row_per_page.'/'.$page_number;
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $allcount;
        $config['per_page'] = $row_per_page;
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
        $data['x'] = (int)$page_number + 1;
        
        if ($page_number + $config['per_page'] > $config['total_rows']) {
            $data['y'] = $config['total_rows'];
        } else {
            $data['y'] = (int)$page_number + $config['per_page'];
        }

        $data['pagination'] = $this->pagination->create_links();
        $data['result'] = $users_record;
        $data['row'] = $page_number;
        $data['order'] = $order_by;
        echo json_encode($data);
    }

    public function getEmail()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;

        if ($page != 0) {
            $page = ($page-1) * $perPage;
        }

        $results = $this->Stb_model->getEmail($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Stb_model->getEmail($perPage, $page, $searchTerm, 'count');
        $data = array();
        
        foreach ($results as $row) {
            $data[] = array(
                "id" => $row['email'],
                "text" => $row['email']
            );
        }

        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function activateStb()
    {
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');
        $id = $this->input->post('id');
        $model = $this->input->post('model');
        $email = $this->input->post('email');
        $device_product = $this->input->post('device_product');
        
        if (empty($id) || empty($model) || empty($email)) {
            return $this->_sendResponse('1', 'Failed to deactivate the STB.');
        }

        if ($model == 'MNC') {
            return $this->_sendResponse('1', 'Failed to deactivate the STB.');
        }

        $active = $this->Stb_model->activateStb($id, $email, $time);
        
        if (!$active) {
            return $this->_sendResponse('1', 'Failed to deactivate the STB.');
        }

        return $this->_sendResponse('0', 'STB has been successfully activated.');
    }

    public function deactivateStb()
    {
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');
        $id = $this->input->post('id');
        $model = $this->input->post('model');
        $email = $this->input->post('email');
        $device_product = $this->input->post('device_product');
        $serial_number = $this->input->post('serial_number');
        
        if (empty($id) || empty($model)) {
            return $this->_sendResponse('1', 'Failed to deactivate the STB.');
        }

        if ($model === 'ZTEATV') {
            $checkClientLog = $this->Stb_model->checkClientLog($device_product, $time);
            
            if (!$checkClientLog) {
                return $this->_sendResponse('1', 'Failed to deactivate the STB.');
            }
        }

        if ($model === 'MNC') {
            $endPoint = $this->baseUrl . $this->resetPath;

            $body = array(
                'sn' => $device_product,
            );

            $params = json_encode($body);

            $headers = array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($params),
                'Authorization: Bearer ' . $this->tokenBearer
            );

            $curl = $this->curlPost($endPoint, $headers, $params);

            $responseBody = json_decode($curl['body'], true);

            if (!is_array($responseBody)) {
                $responsePayload = $curl['body'];
                $status = 'FAILED';
                $errorMessage = 'Invalid JSON response from API';

                $this->createStbActivityLog($serial_number, $email, $device_product, $params, $responsePayload, $status, $errorMessage, $time);

                return $this->_sendResponse('1', 'Invalid JSON response from API.');
            }

            if ($curl['status_code'] != 200) {
                $responsePayload = $curl['body'];
                $status = 'FAILED';
                $errorMessage = isset($responseBody['message']) ? $responseBody['message'] : 'HTTP Error ' . $curl['status_code'];

                $this->createStbActivityLog($serial_number, $email, $device_product, $params, $responsePayload, $status, $errorMessage, $time);
                
                return $this->_sendResponse('1', $errorMessage);
            }

            $isRootTrue = isset($responseBody['status']) && $responseBody['status'] === true;
            $isDataTrue = isset($responseBody['data']['status']) && $responseBody['data']['status'] === true;

            if (!$isRootTrue || !$isDataTrue) {
                $responsePayload = $curl['body'];
                $status = 'FAILED';
                $errorMessage = 'Failed to reset stb.';

                if (isset($responseBody['data']['message'])) {
                    $errorMessage = $responseBody['data']['message'];
                } elseif (isset($responseBody['message'])) {
                    $errorMessage = $responseBody['message'];
                }

                $this->createStbActivityLog($serial_number, $email, $device_product, $params, $responsePayload, $status, $errorMessage, $time);

                return $this->_sendResponse('1', $errorMessage);
            }

            $status = 'SUCCESS';
            $errorMessage = null;
            $this->createStbActivityLog($serial_number, $email, $device_product, $params, $curl['body'], $status, $errorMessage, $time);
        }

        $inactive = $this->Stb_model->deactivateStb($id, $time);
        
        if (!$inactive) {
            return $this->_sendResponse('1', 'Failed to deactivate STB.');
        }

        return $this->_sendResponse('0', 'STB has been successfully deactivated.');
    }

    public function createStbActivityLog($serial_number, $email, $device_product, $params, $responsePayload, $status, $errorMessage, $time)
    {
        $dataLog = array(
            'serial_number' => $serial_number,
            'user' => $email,
            'model' => 'MNC',
            'action' => 'RESET_STB',
            'device_product' => $device_product,
            'request_payload' => $params,
            'response_payload' => $responsePayload,
            'status' => $status,
            'error_message' => $errorMessage,
            'created_at' => $time,
            'updated_at' => $time,
            'ctrloc' => 'cms /stb/stb/deactivateStb',
        );

        $this->Stb_model->stbActivityLog($dataLog);
    }

    public function getListStbLog($id='', $model='', $serialNumber='', $deviceProduct='', $rowPerPage=10, $pageNumber=0)
    {
        $model = urldecode($model);
        
        $deviceProduct = urldecode($deviceProduct);

        if ($pageNumber != 0) {
            $pageNumber = ($pageNumber-1) * $rowPerPage;
        }

        $orderBy = 'DESC';

        $allcount = $this->Stb_model->getCountAllLogStb($model, $serialNumber, $deviceProduct);

        $users_record = $this->Stb_model->getDataLogStb($model, $serialNumber, $deviceProduct, $orderBy, $rowPerPage, $pageNumber);
        
        $config['base_url'] = base_url().'stb/getListStbLog/'.$id.'/'.$model.'/'.$serialNumber.'/'.$deviceProduct.'/'.$rowPerPage.'/'.$pageNumber;
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $allcount;
        $config['per_page'] = $rowPerPage;
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
        $data['x'] = (int)$pageNumber + 1;
        
        if ($pageNumber + $config['per_page'] > $config['total_rows']) {
            $data['y'] = $config['total_rows'];
        } else {
            $data['y'] = (int)$pageNumber + $config['per_page'];
        }

        $data['pagination'] = $this->pagination->create_links();
        $data['result'] = $users_record;
        $data['row'] = $pageNumber;
        $data['order'] = $orderBy;
        echo json_encode($data);
    }

    public function curlPost($url, $headers=array(), $params)
    {        
        // Initialize cURL session
        $ch = curl_init($url);

        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Execute the request and capture the response
        $response = curl_exec($ch);

        // Get the HTTP status code
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Close cURL session
        curl_close($ch);
        $result = array(
            'status_code' => $status_code,
            'body' => $response
        );
        return $result;
    }

    private function _sendResponse($errorStatus, $message)
    {
        echo json_encode([
            'error'   => $errorStatus,
            'message' => $message
        ]);
        return;
    }

    public function getDetailStbLog($id='', $model='', $serialNumber='', $deviceProduct)
    {
        $model = urldecode($model);
        $serialNumber = urldecode($serialNumber);
        $deviceProduct = urldecode($deviceProduct);

        $getDetailStbLog = $this->Stb_model->getDetailStbLog($id, $model, $serialNumber, $deviceProduct);
        echo json_encode($getDetailStbLog);
    }

    public function exportDatas()
    {
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            return $this->output
                ->set_status_header(405)
                ->set_content_type('application/json')
                ->set_output(json_encode(array(
                    'status' => 'failed',
                    'message' => 'Method not allowed'
                )));
        }

        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('date', 'date', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            if (form_error('date')) {
                $message = form_error('date');
            } else {
                $message = 'Invalid or missing parameters';
            }

            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode(array(
                    'status' => 'failed',
                    'message' => trim($message)
                )));
        }

        $date = $this->input->post('date');

        $date = urldecode($date);

        $getExportDatas = $this->Stb_model->getExportDatas($date);

        if ($getExportDatas['num_rows'] <= 0) {
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json')
                ->set_output(json_encode(array(
                    'status' => 'failed',
                    'message' => 'Data not found'
                )));
        }

        $data = $getExportDatas['records'];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menambahkan header kolom
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'User');
        $sheet->setCellValue('C1', 'Serial Number');
        $sheet->setCellValue('D1', 'Model');
        $sheet->setCellValue('E1', 'Device ID');
        $sheet->setCellValue('F1', 'Action');
        $sheet->setCellValue('G1', 'Active Date');

        // Menambahkan data ke spreadsheet
        $row = 2; // Mulai dari baris kedua (baris pertama adalah header)
        foreach ($data as $rowData) {
            $sheet->setCellValueExplicit('A' . $row, (string)$rowData['id'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('B' . $row, (string)$rowData['user'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('C' . $row, (string)$rowData['serial_number'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('D' . $row, (string)$rowData['model'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('E' . $row, (string)$rowData['device_product'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('F' . $row, (string)$rowData['action'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('G' . $row, (string)$rowData['created_at'], DataType::TYPE_STRING);
            $row++;
        }

        // Menyimpan file Excel ke output
        $writer = new Xlsx($spreadsheet);

        // Menyimpan file sementara di direktori temp
        $filename = 'stb_data_export_' . date('Y-m-d_H-i-s') . '.xlsx';
        $tempFile = '/var/www/html/aid.digdaya.co.id/temp/'.$filename;
        $writer->save($tempFile);

        // Menyediakan file untuk diunduh
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        readfile($tempFile);
        unlink($tempFile);
    }

    public function getListModels()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        
        $offset = max(0, ($page - 1) * $perPage);

        $results = $this->Stb_model->getListModels($perPage, $offset, $searchTerm, 'data');

        $countResults = $this->Stb_model->getListModels($perPage, $offset, $searchTerm, 'count');

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

    public function getSingleModel()
    {
        $id = $this->input->post('id');

        $data = $this->Stb_model->getSingleModel($id);

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

    public function create()
    {
        $CI =& get_instance();
        $data['title'] = 'Add STB';
        $this->form_validation->set_rules('serial_number', 'Serial Number', 'required', ['required' => 'Serial Number harus diisi']);
        $this->form_validation->set_rules('model', 'Model', 'required', ['required' => 'Model harus dipilih']);

        if ($this->form_validation->run() == FALSE) {
            $data['selected_model'] = set_value('model');
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('stb/create', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $stb_data = [
                'serial_number' => $this->input->post('serial_number'),
                'model' => $this->input->post('model'),
                'status' => '1',
                'user' => '',
                'current_version' => $this->input->post('current_version'),
                'mac' => $this->input->post('mac'),
                'area' => 'SINGLE',
                'support' => 'cms aid/create',
                'update_date' => $time,
                'except_update' => '0',
                'ctrloc' => 'cms aid/stb/create'
            ];

            $saved = $this->Stb_model->insertStb($stb_data);

            if ($saved['status'] == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'.$saved['message'].'</div>');
                return redirect('stb');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'.$saved['message'].'</div>');
                return redirect('stb');
            }
        }
    }

    public function edit($id = null)
    {
        $CI =& get_instance();
        if (!$id) show_404();
        $stb = $this->Stb_model->getStbById($id);
        if (!$stb) show_404();
        $data['title'] = 'Edit STB';
        $data['stbs'] = $stb[0];

        $this->form_validation->set_rules('serial_number', 'Serial Number', 'required', ['required' => 'Serial Number harus diisi']);
        $this->form_validation->set_rules('model', 'Model', 'required', ['required' => 'Model harus dipilih']);

        if ($this->form_validation->run() == FALSE) {
            $data['selected_model'] = set_value('mdel') ?: $stb[0]['model'];
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('stb/edit', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $stb_data = [
                'seq' => $id,
                'serial_number_existing' => $this->input->post('serial_number_existing'),
                'serial_number' => $this->input->post('serial_number'),
                'model' => $this->input->post('model'),
                'current_version' => $this->input->post('current_version'),
                'mac' => $this->input->post('mac'),
                'support' => 'cms aid/edit',
                'update_date' => $time,
                'ctrloc' => 'cms aid/stb/edit'
            ];

            $saved = $this->Stb_model->updateStb($id, $stb_data);

            if ($saved['status'] == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'.$saved['message'].'</div>'); 
                return redirect('stb');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'.$saved['message'].'</div>');
                return redirect('stb');
            }
        }
    }
}
