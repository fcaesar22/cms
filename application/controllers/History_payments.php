<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class History_payments extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user')) {
            redirect('auth');
        }
        if (!has_permission('view_historypayments')) {
            show_error('Anda tidak memiliki akses ke halaman ini', 403, 'Forbidden');
        }
        $this->load->config('secure_config');
        $this->load->library('pagination');
        $this->load->library('libadapter');
        $this->load->model('History_payment_model');
    }

    public function index()
    {
        $data['title'] = 'List History Payments';
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('history_payments/index', $data);
        $this->load->view('layouts/footer');
    }

    public function history_payments($key_search=null, $sort_by='seq', $order_sort='desc', $date='', $rowperpage=10, $rowno=0)
    {
        if ($rowno != 0) {
            $rowno = ($rowno-1) * $rowperpage;
        }

        if ($date=='null') {
            $getToday = date('Y-m-d');
            $date = $getToday . '%20to%20' . $getToday;
        }

        $key_search = urldecode($key_search);
        $date = urldecode($date);

        $countData = $this->History_payment_model->getCountSectionAll($key_search, $date);
        $allcount = (int) $countData['total'];
        $total_price = $countData['total_price'];
        $users_record = $this->History_payment_model->getDatasSection($key_search, $sort_by, $order_sort, $date, $rowperpage, $rowno);

        // Pagination Configuration
        $config['base_url'] = base_url().'history_payments/history_payments/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$date.'/'.$rowperpage.'/'.$rowno;
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
        $data['total_price'] = $total_price;
        echo json_encode($data);
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

        $getExportDatas = $this->History_payment_model->getExportDatas($date);

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
        $sheet->setCellValue('A1', 'Seq');
        $sheet->setCellValue('B1', 'Order ID');
        $sheet->setCellValue('C1', 'User ID');
        $sheet->setCellValue('D1', 'Description');
        $sheet->setCellValue('E1', 'Total Price');
        $sheet->setCellValue('F1', 'Payment Channel');
        $sheet->setCellValue('G1', 'Paid Date');

        // Menambahkan data ke spreadsheet
        $row = 2; // Mulai dari baris kedua (baris pertama adalah header)
        foreach ($data as $rowData) {
            $sheet->setCellValue('A' . $row, $rowData['seq']);
            $sheet->setCellValue('B' . $row, $rowData['orderid']);
            $sheet->setCellValue('C' . $row, $rowData['userid']);
            $sheet->setCellValue('D' . $row, $rowData['description']);
            $sheet->setCellValue('E' . $row, $rowData['totalprice']);
            $sheet->setCellValue('F' . $row, $rowData['payment_channel']);
            $sheet->setCellValue('G' . $row, $rowData['paiddate']);
            $row++;
        }

        // Menyimpan file Excel ke output
        $writer = new Xlsx($spreadsheet);

        // Menyimpan file sementara di direktori temp
        $filename = 'order_data_export_' . date('Y-m-d_H-i-s') . '.xlsx';
        // $tempFile = '/var/www/html/aid.digdaya.co.id/temp/'.$filename;
        $tempFile = FCPATH . 'temp/' . $filename;
        $writer->save($tempFile);

        // Menyediakan file untuk diunduh
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        readfile($tempFile);
        unlink($tempFile);
    }
}
