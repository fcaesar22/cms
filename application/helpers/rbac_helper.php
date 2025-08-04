<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('has_permission')) {
    function has_permission($permission_name)
    {
        $CI =& get_instance();

        $user = $CI->session->userdata('user');
        if (!$user || !isset($user->id)) return false;

        // Debug tipe data user
        log_message('debug', 'RBAC user data: ' . print_r($user, true));

        // Jika user adalah array, ambil id dari $user['id']
        if (is_array($user)) {
            $user_id = $user['id'] ?? null;
        } elseif (is_object($user)) {
            $user_id = $user->id;
        } else {
            return false;
        }

        if (!$user_id) return false;

        if (!isset($CI->User_model)) {
            $CI->load->model('User_model');
        }

        if (!method_exists($CI->User_model, 'check_permission')) {
            log_message('error', 'Method check_permission tidak ditemukan di User_model');
            return false;
        }

        return $CI->User_model->check_permission($user_id, $permission_name);
    }
}
