<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class Stb extends CI_Controller {
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
            return $this->_sendResponse('1', 'Masih nunggu API dari MNC untuk reset STB.');
        }

        $inactive = $this->Stb_model->deactivateStb($id, $time);
        
        if (!$inactive) {
            return $this->_sendResponse('1', 'Failed to deactivate STB.');
        }

        return $this->_sendResponse('0', 'STB has been successfully deactivated.');
    }

    private function _sendResponse($errorStatus, $message)
    {
        echo json_encode([
            'error'   => $errorStatus,
            'message' => $message
        ]);
        return;
    }

    public function downloadFile($key_search=null, $model='ALL', $status='All', $date=null)
    {
        $key_search = urldecode($key_search);

        $model = urldecode($model);
        
        $date = urldecode($date);

        $getDataExport = $this->Stb_model->getDataExport($key_search, $model, $status, $date);
        $data = $getDataExport['records'];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menambahkan header kolom
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'User');
        $sheet->setCellValue('C1', 'Serial Number');
        $sheet->setCellValue('D1', 'Model');
        $sheet->setCellValue('E1', 'Status');
        $sheet->setCellValue('F1', 'Device ID');
        $sheet->setCellValue('G1', 'Active Date');

        // Menambahkan data ke spreadsheet
        $row = 2; // Mulai dari baris kedua (baris pertama adalah header)
        foreach ($data as $rowData) {
            $statusConvert = ($rowData['status'] == 1) ? 'Not Login' : 'Login';
            $sheet->setCellValueExplicit('A' . $row, (string)$rowData['seq'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('B' . $row, (string)$rowData['user'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('C' . $row, (string)$rowData['serial_number'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('D' . $row, (string)$rowData['model'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('E' . $row, (string)$statusConvert, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('F' . $row, (string)$rowData['device_product'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('G' . $row, (string)$rowData['active_date'], DataType::TYPE_STRING);
            $row++;
        }

        // Menyimpan file Excel ke output
        $writer = new Xlsx($spreadsheet);

        // Menyimpan file sementara di direktori temp
        $filename = 'order_data_export_' . date('Y-m-d_H-i-s') . '.xlsx';
        // $tempFile = '/var/www/html/aid.digdaya.co.id/temp/'.$filename;
        $tempFile = FCPATH .'/temp/'.$filename;
        $writer->save($tempFile);

        // Menyediakan file untuk diunduh
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        readfile($tempFile);
        unlink($tempFile);
    }
}
