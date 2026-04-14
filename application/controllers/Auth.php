<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index()
    {
        if ($this->session->userdata('user')) {
            redirect('dashboard');
        }
        $this->load->view('auth/login');
    }

    public function login()
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            $this->session->set_flashdata('username', $username);
            redirect('auth');
        }

        $user = $this->User_model->get_user($username);

        if (!$user) {
            $this->session->set_flashdata('error', 'Username not found');
            $this->session->set_flashdata('username', $username);
            redirect('auth');
        }

        if (!password_verify($password, $user->password)) {
            $this->session->set_flashdata('error', 'Password is wrong');
            $this->session->set_flashdata('username', $username);
            redirect('auth');
        }

        $this->session->set_userdata([
            'user'     => $user,
            'role_id'  => $user->role_id,
            'username' => $user->username,
        ]);
        redirect('dashboard');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }
}
