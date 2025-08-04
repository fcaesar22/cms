<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user')) {
            redirect('auth');
        }
        if (!has_permission('view_users')) {
            show_error('Anda tidak memiliki akses ke halaman ini', 403, 'Forbidden');
        }
        $this->load->library('pagination');
        $this->load->model('Role_model');
        $this->load->model('User_model');
    }

    public function index()
    {
        $data['title'] = 'Users';
        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('users/index', $data);
        $this->load->view('layouts/footer');
    }

    public function list_users($key_search=null, $sort_by='id', $order_sort='asc', $rowperpage=10, $rowno=0)
    {
        if($rowno != 0){
            $rowno = ($rowno-1) * $rowperpage;
        }
        
        $allcount = $this->User_model->getCountAll($key_search);

        $users_record = $this->User_model->getDatas($key_search, $sort_by, $order_sort, $rowperpage, $rowno);
        
        // Pagination Configuration
        $config['base_url'] = base_url().'users/list_users/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$rowperpage.'/'.$rowno;
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

    public function create() {
        $data['title'] = 'Add User';
        $data['roles'] = $this->Role_model->get_all_roles();

        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]', [
            'required' => 'Username harus diisi',
            'is_unique' => 'Username sudah digunakan'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]', [
            'required' => 'Password harus diisi',
            'min_length' => 'Password minimal 6 karakter'
        ]);
        $this->form_validation->set_rules('name_account', 'Nama', 'required', ['required' => 'Nama harus diisi']);
        $this->form_validation->set_rules('role_id', 'Role', 'required', ['required' => 'Role harus dipilih']);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('users/create', $data);
            $this->load->view('layouts/footer');
        } else {
            $save = [
                'username' => $this->input->post('username'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'name_account' => $this->input->post('name_account'),
                'role_id' => $this->input->post('role_id')
            ];
            $this->User_model->insert_user($save);
            redirect('users');
        }
    }

    public function edit($id = null) {
        if (!$id) show_404();
        $user = $this->User_model->get_user_by_id($id);
        if (!$user) show_404();

        $data['title'] = 'Edit User';
        $data['user'] = $user;
        $data['roles'] = $this->Role_model->get_all_roles();

        $this->form_validation->set_rules('password', 'Password', 'min_length[6]', [
            'min_length' => 'Password minimal 6 karakter'
        ]);
        $this->form_validation->set_rules('name_account', 'Nama', 'required', ['required' => 'Nama harus diisi']);
        $this->form_validation->set_rules('role_id', 'Role', 'required', ['required' => 'Role harus dipilih']);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('users/edit', $data);
            $this->load->view('layouts/footer');
        } else {
            $update = [
                'name_account' => $this->input->post('name_account'),
                'role_id' => $this->input->post('role_id')
            ];

            if ($this->input->post('password')) {
                $update['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            }

            $this->User_model->update_user($id, $update);
            redirect('users');
        }
    }

    public function delete($id = null) {
        if (!$id) show_404();

        $user = $this->User_model->get_user_by_id($id);
        if (!$user) show_404();

        $this->User_model->delete_user($id);
        redirect('users');
    }
}
