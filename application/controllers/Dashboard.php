<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('user')) {
            redirect('auth');
        }
        if (!has_permission('view_dashboard')) {
            show_error('Anda tidak memiliki akses ke halaman ini', 403, 'Forbidden');
        }
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/index', $data);
        $this->load->view('layouts/footer');
    }
}
