<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends CI_Controller {
	public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user')) {
            redirect('auth');
        }
        if (!has_permission('view_roles')) {
            show_error('Anda tidak memiliki akses ke halaman ini', 403, 'Forbidden');
        }
        $this->load->library('pagination');
        $this->load->model('Role_model');
        $this->load->model('Permission_model');
    }

    public function index()
    {
        $data['title'] = 'List Roles';
        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('roles/index', $data);
        $this->load->view('layouts/footer');
    }

    public function list_roles($key_search=null, $sort_by='id', $order_sort='asc', $rowperpage=10, $rowno=0)
    {
        if($rowno != 0){
            $rowno = ($rowno-1) * $rowperpage;
        }
        
        $allcount = $this->Role_model->getCountAll($key_search);

        $users_record = $this->Role_model->getDatas($key_search, $sort_by, $order_sort, $rowperpage, $rowno);
        
        // Pagination Configuration
        $config['base_url'] = base_url().'roles/list_roles/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$rowperpage.'/'.$rowno;
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

    public function create()
    {
        $data['title'] = 'Add Role';
        $this->form_validation->set_rules('name', 'Nama Role', 'required|is_unique[roles.name]', [
            'required' => 'Nama role harus diisi',
            'is_unique' => 'Nama role sudah ada'
        ]);
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('roles/create', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->Role_model->insert(['name' => $this->input->post('name')]);
            redirect('roles');
        }
    }

    public function delete($id)
    {
        if (!$id) {
            show_404();
        }

        $role = $this->Role_model->get_by_id($id);
        if (!$role) {
            show_404();
        }

        $this->Role_model->delete($id);
        redirect('roles');
    }

    public function permissions($role_id)
    {
        if (!$role_id) {
            show_404();
        }

        $data['role'] = $this->Role_model->get_by_id($role_id);
        if (!$data['role']) {
            show_404();
        }

        $data['permissions'] = $this->Permission_model->get_all_with_menus();
        $data['role_permissions'] = $this->Role_model->get_role_permissions($role_id); // array id permission
        $data['title'] = 'Set Permissions Role: ' . $data['role']->name;

        if ($this->input->post()) {
            $selected_permissions = $this->input->post('permissions') ?? [];
            $this->Role_model->update_permissions($role_id, $selected_permissions);
            redirect('roles');
        }

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('roles/permissions', $data);
        $this->load->view('layouts/footer');
    }
}
