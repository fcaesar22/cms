<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permissions extends CI_Controller {
	public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('user')) {
            redirect('auth');
        }
        if (!has_permission('view_permissions')) {
            show_error('Anda tidak memiliki akses ke halaman ini', 403, 'Forbidden');
        }
        $this->load->library('pagination');
        $this->load->model('Menu_model');
        $this->load->model('Permission_model');
    }

    public function index()
    {
        $data['title'] = 'Permission';
        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('permissions/index', $data);
        $this->load->view('layouts/footer');
    }

    public function list_permissions($key_search=null, $sort_by='id', $order_sort='asc', $rowperpage=10, $rowno=0)
    {
        if($rowno != 0){
            $rowno = ($rowno-1) * $rowperpage;
        }
        
        $allcount = $this->Permission_model->getCountAll($key_search);

        $users_record = $this->Permission_model->getDatas($key_search, $sort_by, $order_sort, $rowperpage, $rowno);
        
        // Pagination Configuration
        $config['base_url'] = base_url().'users/list_permissions/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$rowperpage.'/'.$rowno;
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
        $data['title'] = 'Add Permission';        

        $this->form_validation->set_rules('name', 'Name', 'required|is_unique[permissions.name]', [
            'required' => 'Nama permission harus diisi',
            'is_unique' => 'Nama permission sudah ada'
        ]);

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('permissions/create', $data);
            $this->load->view('layouts/footer');
        } else {
            $insert_data = [
                'name' => $this->input->post('name')
            ];
            $this->Permission_model->insert($insert_data);
            redirect('permissions');
        }
    }

    public function edit($id = null)
    {
        if (!$id) show_404();

        $permission = $this->Permission_model->get_by_id($id);
        if (!$permission) show_404();

        $data['title'] = 'Edit Permission';
        $data['permission'] = $permission;

        $this->form_validation->set_rules('name', 'Name', 'required|callback_unique_except_current[' . $id . ']', [
            'required' => 'Nama permission harus diisi'
        ]);

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('permissions/edit', $data);
            $this->load->view('layouts/footer');
        } else {
            $update_data = [
                'name' => $this->input->post('name')
            ];
            $this->Permission_model->update($id, $update_data);
            redirect('permissions');
        }
    }

    public function unique_except_current($name, $id)
    {
        $this->db->where('name', $name);
        $this->db->where('id !=', $id);
        $exists = $this->db->get('permissions')->row();
        if ($exists) {
            $this->form_validation->set_message('unique_except_current', 'Nama permission sudah digunakan.');
            return FALSE;
        }
        return TRUE;
    }

    public function delete($id=null)
    {
        if (!$id) {
            show_404();
        }
        $permission = $this->Permission_model->get_by_id($id);
        if (!$permission) {
            show_404();
        }
        $this->Permission_model->delete($id);
        redirect('permissions');
    }
}
