<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menus extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('user')) {
            redirect('auth');
        }
        if (!has_permission('view_menus')) {
            show_error('Anda tidak memiliki akses ke halaman ini', 403, 'Forbidden');
        }
        $this->load->library('pagination');
        $this->load->model('Menu_model');
        $this->load->model('Permission_model');
        $this->load->model('Role_model');
    }

    public function index()
    {
        $data['title'] = 'List Menu';
        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('menus/index', $data);
        $this->load->view('layouts/footer');
    }

    public function list_menus($key_search=null, $sort_by='id', $order_sort='asc', $rowperpage=10, $rowno=0)
    {
        if($rowno != 0){
            $rowno = ($rowno-1) * $rowperpage;
        }
        
        $allcount = $this->Menu_model->getCountAll($key_search);

        $users_record = $this->Menu_model->getDatas($key_search, $sort_by, $order_sort, $rowperpage, $rowno);
        
        // Pagination Configuration
        $config['base_url'] = base_url().'menus/list_menus/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$rowperpage.'/'.$rowno;
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
        $data['title'] = 'Add Menu';
        $data['parents'] = $this->Menu_model->get_parents();

        $this->form_validation->set_rules('name', 'Name', 'required|is_unique[menus.name]', [
            'required' => 'Name harus diisi',
            'is_unique' => 'Name sudah digunakan'
        ]);        
        $this->form_validation->set_rules('sort_order', 'Sort', 'required', ['required' => 'Sort harus diisi']);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header');
            $this->load->view('layouts/sidebar');
            $this->load->view('menus/create', $data);
            $this->load->view('layouts/footer');
        } else {
            $menu = [
                'name' => $this->input->post('name'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'parent_id' => $this->input->post('parent_id') ?: null,
                'sort_order' => $this->input->post('sort_order') ?: 0,
            ];
            $this->Menu_model->insert($menu);
            redirect('menus');
        }
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Menu';
        $data['menu'] = $this->Menu_model->get_by_id($id);
        if (!$data['menu']) {
            show_404();
        }
        $data['parents'] = $this->Menu_model->get_parents($id);

        $this->form_validation->set_rules('name', 'Name', 'required', [
            'required' => 'Name harus diisi'
        ]);
        $this->form_validation->set_rules('sort_order', 'Sort', 'required', ['required' => 'Sort harus diisi']);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('menus/edit', $data);
            $this->load->view('layouts/footer');
        } else {
            $update = [
                'name' => $this->input->post('name'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'parent_id' => $this->input->post('parent_id') ?: null,
                'sort_order' => $this->input->post('sort_order') ?: 0,
            ];
            $this->Menu_model->update($id, $update);
            redirect('menus');
        }
    }

    public function delete($id)
    {
        $menu = $this->Menu_model->get_by_id($id);
        if (!$menu) {
            show_404();
        }
        $this->Menu_model->delete($id);
        redirect('menus');
    }

    public function set_permission_menu($id)
    {
        $data['menu'] = $this->Menu_model->get_by_id($id);
        if (!$data['menu']) {
            show_404();
        }

        $this->load->model('Permission_model');

        $data['permissions'] = $this->Permission_model->get_all();

        // Ambil permission yang sudah dikaitkan
        $this->db->select('permission_id');
        $this->db->from('menu_permissions');
        $this->db->where('menu_id', $id);
        $query = $this->db->get();
        $menu_permission_ids = array_column($query->result_array(), 'permission_id');
        $data['menu_permission_ids'] = $menu_permission_ids;

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->db->delete('menu_permissions', ['menu_id' => $id]);

            $permissions = $this->input->post('permissions');
            if ($permissions && is_array($permissions)) {
                foreach ($permissions as $permission_id) {
                    $this->db->insert('menu_permissions', [
                        'menu_id' => $id,
                        'permission_id' => $permission_id
                    ]);
                }
            }

            $this->session->set_flashdata('success', 'Permission updated successfully.');
            redirect('menus');
        }

        $data['title'] = 'Set Permission Menu';

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('menus/set_permission_menu', $data);
        $this->load->view('layouts/footer');
    }
}
