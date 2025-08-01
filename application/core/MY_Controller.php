<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	public function __construct(){
        parent::__construct();
        if(!$this->session->userdata('logged_in')) redirect('auth/login');
        $this->load->model('Menu_model');
        $this->menus = $this->Menu_model->get_menu_structure_by_role($this->session->userdata('role_id'));
    }

    protected function load_template($view,$data=[]){
        $data['menus'] = $this->menus;
        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar',$data);
        $this->load->view($view,$data);
        $this->load->view('template/footer',$data);
    }
}
