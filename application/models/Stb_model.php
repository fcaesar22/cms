<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stb_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    public function getCountAll($key_search=null, $model='', $status='', $date='')
    {
        $this->db->select('COUNT(*) AS total', false);
        $this->db->from('stb');

        if (!empty($key_search) && $key_search != 'null') {
            $this->db->like('serial_number', $key_search);
            $this->db->or_like('user', $key_search);
        }

        if ($model != '' && $model != 'ALL') {
            $this->db->where('model', $model);
        } else {
            $listModels = array('DENS10 MRVL88DE3108', 'DENS20 CASTPAL-AW526', 'DENS2X MKTECH-MMP-OTT 888', 'DENSZTE', 'ZTEATV', 'MNC');
            $this->db->where_in('model', $listModels);
        }

        if ($status != '' && $status != 'All') {
            $this->db->where('status', $status);
        } else {
            $listStatus = array(
                1,
                2
            );
            $this->db->where_in('status', $listStatus);
        }

        if (!empty($date) && $date != 'null') {
            $date_range = explode(' to ', $date);

            if (count($date_range) == 2) {
                $start_date = trim($date_range[0]);
                $end_date   = trim($date_range[1]);

                $this->db->where('DATE(active_date) >=', $start_date);
                $this->db->where('DATE(active_date) <=', $end_date);
            }
        }

        $result = $this->db->get()->row_array();

        return (int) $result['total'];
    }

    public function getDatas($key_search='', $model='', $status='', $date='', $sort_by='', $order_by='', $row_per_page='', $page_number='')
    {
        $data = array();
        $this->db->select('seq, serial_number, model, status, user, active_date, device_product');
        $this->db->from('stb');
        
        if (!empty($key_search) && $key_search != 'null') {
            $this->db->like('serial_number', $key_search);
            $this->db->or_like('user', $key_search);
        }

        if ($model != '' && $model != 'ALL') {
            $this->db->where('model', $model);
        } else {
            $listModels = array(
                'DENS10 MRVL88DE3108',
                'DENS20 CASTPAL-AW526',
                'DENS2X MKTECH-MMP-OTT 888',
                'DENSZTE',
                'ZTEATV',
                'MNC'
            );
            $this->db->where_in('model', $listModels);
        }

        if ($status != '' && $status != 'All') {
            $this->db->where('status', $status);
        } else {
            $listStatus = array(
                1,
                2
            );
            $this->db->where_in('status', $listStatus);
        }

        if (!empty($date) && $date != 'null') {
            $date_range = explode(' to ', $date);

            if (count($date_range) == 2) {
                $start_date = trim($date_range[0]);
                $end_date   = trim($date_range[1]);

                $this->db->where('DATE(active_date) >=', $start_date);
                $this->db->where('DATE(active_date) <=', $end_date);
            }
        }

        $this->db->order_by($sort_by, $order_by);
        $this->db->limit($row_per_page, $page_number);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getEmail($perPage, $page, $searchTerm, $type)
    {
        if ($type == 'data') {
            $this->db->select('email, fullname');
        } else {
            $this->db->select('COUNT(*) AS total', false);
        }

        $this->db->from('member');

        if (!empty($searchTerm)) {
            $this->db->group_start();
                $this->db->like('email', $searchTerm);
                $this->db->or_like('fullname', $searchTerm);
            $this->db->group_end();
        }

        $this->db->where('visible', 'Y');

        if ($type == 'data') {
            $this->db->order_by('seq', 'DESC');
            $this->db->limit($perPage, $page);

            return $this->db->get()->result_array();
        } else {
            $result = $this->db->get()->row_array();

            return (int) $result['total'];
        }
    }

    public function activateStb($id, $email, $time)
    {
        $this->db->set('status', 2);
        $this->db->set('user', $email);
        $this->db->set('update_date', $time);
        $this->db->set('active_date', $time);
        $this->db->set('ctrloc', 'cms-aid stb/activateStb');
        $this->db->where('seq', $id);
        return $this->db->update('stb');
    }

    public function checkClientLog($device_product, $time)
    {
        $deletePreference = 'Delete-' . $time . '-' . $device_product;
        
        $this->db->set('preference', $deletePreference);
        $this->db->set('expire', $time);
        $this->db->set('update_date', $time);
        $this->db->where('preference', $device_product);
        $this->db->update('client_log');
        
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        
        return false;
    }

    public function deactivateStb($id, $time)
    {
        $this->db->set('status', 1);
        $this->db->set('user', NULL);
        $this->db->set('update_date', $time);
        $this->db->set('ctrloc', 'cms-aid stb/deactivateStb');
        $this->db->where('seq', $id);
        return $this->db->update('stb');
    }

    public function stbActivityLog($dataLog=[])
    {
        if (!is_array($dataLog) || empty($dataLog)) {
            return false;
        }

        $insert = $this->db->insert('stb_activity_logs', $dataLog);

        return $insert;
    }

    public function getCountAllLogStb($model='', $serialNumber='', $deviceProduct='')
    {
        switch ($model) {
            case 'DENS10 MRVL88DE3108':
            case 'DENS20 CASTPAL-AW526':
            case 'DENS2X MKTECH-MMP-OTT 888':
            case 'DENSZTE':
                return 0;
                break;
            case 'ZTEATV':
                $this->db->select('COUNT(*) AS total', false);
                $this->db->from('client_log');
                $this->db->like('preference', $deviceProduct, 'both');
                $this->db->where('device', '20');
                $result = $this->db->get()->row_array();
                return (int) $result['total'];
                break;
            case 'MNC':
                $this->db->select('COUNT(*) AS total', false);
                $this->db->from('stb_activity_logs');
                $this->db->where('serial_number', $serialNumber);
                $result = $this->db->get()->row_array();
                return (int) $result['total'];
                break;
            default:
                return 0;
                break;
        }
    }

    public function getDataLogStb($model='', $serialNumber='', $deviceProduct='', $orderBy='', $rowPerPage='', $pageNumber='')
    {
        switch ($model) {
            case 'DENS10 MRVL88DE3108':
            case 'DENS20 CASTPAL-AW526':
            case 'DENS2X MKTECH-MMP-OTT 888':
            case 'DENSZTE':
                return array();
                break;
            case 'ZTEATV':
                $this->db->select('seq, userid, update_date');
                $this->db->from('client_log');
                $this->db->like('preference', $deviceProduct, 'both');
                $this->db->where('device', '20');
                $this->db->order_by('seq', $orderBy);
                $this->db->limit($rowPerPage, $pageNumber);
                $query = $this->db->get();
                $data = array();
                if ($query->num_rows() > 0) {
                    foreach ($query->result_array() as $key => $value) {
                        $email = $value['userid'];
                        $this->db->select('email');
                        $this->db->from('member');
                        $this->db->where('dens_id', $email);
                        $this->db->or_where('email', $email);
                        $queryMember = $this->db->get();
                        if ($queryMember->num_rows() > 0) {
                            $email = $queryMember->row('email');
                        }
                        $data[] = array(
                            'id' => $value['seq'],
                            'serial_number' => $serialNumber,
                            'user' => $email,
                            'action' => 'ACTIVATION',
                            'status' => 'SUCCESS',
                            'device_product' => $deviceProduct,
                            'created_at' => $value['update_date']
                        );
                    }
                }
                return $data;
                break;
            case 'MNC':
                $this->db->select('id, serial_number, user, action, status, device_product, created_at');
                $this->db->from('stb_activity_logs');
                $this->db->where('serial_number', $serialNumber);
                $this->db->order_by('created_at', $orderBy);
                $this->db->limit($rowPerPage, $pageNumber);
                $query = $this->db->get();
                return $query->result_array();
                break;
            default:
                return array();
                break;
        }
    }

    public function getDetailStbLog($id='', $model='', $serialNumber='', $deviceProduct='')
    {
        switch ($model) {
            case 'DENS10 MRVL88DE3108':
            case 'DENS20 CASTPAL-AW526':
            case 'DENS2X MKTECH-MMP-OTT 888':
            case 'DENSZTE':
                return array();
                break;
            case 'ZTEATV':
                $this->db->select('seq, userid, update_date');
                $this->db->from('client_log');
                $this->db->where('seq', $id);
                $query = $this->db->get();
                $data = array();
                if ($query->num_rows() > 0) {
                    foreach ($query->result_array() as $key => $value) {
                        $email = $value['userid'];
                        $this->db->select('email');
                        $this->db->from('member');
                        $this->db->where('dens_id', $email);
                        $this->db->or_where('email', $email);
                        $queryMember = $this->db->get();
                        if ($queryMember->num_rows() > 0) {
                            $email = $queryMember->row('email');
                        }
                        $data[] = array(
                            'id' => $value['seq'],
                            'serial_number' => $serialNumber,
                            'user' => $email,
                            'action' => 'ACTIVATION',
                            'status' => 'SUCCESS',
                            'device_product' => $deviceProduct,
                            'created_at' => $value['update_date']
                        );
                    }
                }
                return $data;
                break;
            case 'MNC':
                $this->db->select('*');
                $this->db->from('stb_activity_logs');
                $this->db->where('id', $id);
                $query = $this->db->get();
                return $query->result_array();
                break;
            default:
                return array();
                break;
        }
    }

    public function getExportDatas($date)
    {
        $this->db->select('id, serial_number, user, model, device_product, action, created_at');
        $this->db->from('stb_activity_logs');
        $this->db->where('model', 'MNC');
        $this->db->where('action', 'ACTIVATION');
        $this->db->where('status', 'SUCCESS');
        if (!empty($date) && $date != 'null') {
            $date_range = explode(' to ', $date);

            if (count($date_range) == 2) {
                $start_date = trim($date_range[0]);
                $end_date   = trim($date_range[1]);

                $this->db->where('DATE(created_at) >=', $start_date);
                $this->db->where('DATE(created_at) <=', $end_date);
            }
        }
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        $records = $query->result_array();

        $result = array(
            'num_rows' => $num_rows,
            'records' => $records
        );

        return $result;
    }

    private function getModelOptions()
    {
        return array(
            array(
                'id' => 'DENS10 MRVL88DE3108',
                'title' => 'STB V1'
            ),
            array(
                'id' => 'DENS20 CASTPAL-AW526',
                'title' => 'STB V2'
            ),
            array(
                'id' => 'DENS2X MKTECH-MMP-OTT 888',
                'title' => 'STB V2x'
            ),
            array(
                'id' => 'DENSZTE',
                'title' => 'STB V2y'
            ),
            array(
                'id' => 'ZTEATV',
                'title' => 'STB V3'
            ),
            array(
                'id' => 'MNC',
                'title' => 'STB MNC'
            ),
        );
    }

    public function getListModels($perPage, $page, $searchTerm, $type)
    {
        $data = $this->getModelOptions();

        if ($searchTerm !== null && $searchTerm !== '') {
            $data = array_filter($data, function ($row) use ($searchTerm) {
                return stripos($row['title'], $searchTerm) !== false
                    || stripos($row['id'], $searchTerm) !== false;
            });

            $data = array_values($data);
        }

        if ($type == 'count') {
            return count($data);
        }

        return array_slice($data, $page, $perPage);
    }

    public function getSingleModel($id)
    {
        foreach ($this->getModelOptions() as $row) {
            if ($row['id'] === $id) {
                return (object) $row;
            }
        }

        return null;
    }

    public function insertStb($stb_data)
    {
        if (
            !is_array($stb_data) ||
            !array_key_exists('serial_number', $stb_data) ||
            !array_key_exists('model', $stb_data) ||
            $stb_data['serial_number'] === null ||
            $stb_data['serial_number'] === '' ||
            $stb_data['model'] === null ||
            $stb_data['model'] === ''
        ) {
            return array(
                'status' => false,
                'message' => 'Data STB tidak valid'
            );
        } else {
            $this->db->select('seq');
            $this->db->from('stb');
            $this->db->where('serial_number', $stb_data['serial_number']);
            $this->db->where('model', $stb_data['model']);
            $checkSn = $this->db->get()->num_rows();
            if ($checkSn > 0) {
                return array(
                    'status' => false,
                    'message' => 'STB tidak berhasil disimpan, Serial Number sudah ada!'
                );
            } else {
                $create = $this->db->insert('stb', $stb_data);
                if ($create != true) {
                    return array(
                        'status' => false,
                        'message' => 'STB tidak berhasil disimpan'
                    );
                } else {
                    return array(
                        'status' => true,
                        'message' => 'STB berhasil disimpan'
                    );
                }
            }
        }
    }

    public function getStbById($id)
    {
        $result = array();
        
        $this->db->select('*');
        $this->db->from('stb');
        $this->db->where('seq', $id);
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        
        if ($num_rows > 0) {
            $result = $query->result_array();
        }

        return $result;
    }

    public function updateStb($id, $stb_data)
    {
        if ($stb_data['serial_number'] != $stb_data['serial_number_existing']) {
            $this->db->select('COUNT(*) AS total', false);
            $this->db->from('stb');
            $this->db->where('serial_number', $stb_data['serial_number']);
            $result = $this->db->get()->row_array();
            
            if ($result['total'] > 0) {
                return array(
                    'status' => false,
                    'message' => 'STB tidak berhasil diubah, Serial Number sudah ada!'
                );
            }

            $this->db->set('serial_number', $stb_data['serial_number']);
            $this->db->set('model', $stb_data['model']);
            $this->db->set('current_version', $stb_data['current_version']);
            $this->db->set('mac', $stb_data['mac']);
            $this->db->set('support', $stb_data['support']);
            $this->db->set('update_date', $stb_data['update_date']);
            $this->db->set('ctrloc', $stb_data['ctrloc']);
            $this->db->where('seq', $stb_data['seq']);
            $update = $this->db->update('stb');

            if ($update != false) {
                return array(
                    'status' => false,
                    'message' => 'STB tidak berhasil diubah'
                );
            }

            return array(
                'status' => true,
                'message' => 'STB berhasil diubah'
            );
        }

        $this->db->set('model', $stb_data['model']);
        $this->db->set('current_version', $stb_data['current_version']);
        $this->db->set('mac', $stb_data['mac']);
        $this->db->set('support', $stb_data['support']);
        $this->db->set('update_date', $stb_data['update_date']);
        $this->db->set('ctrloc', $stb_data['ctrloc']);
        $this->db->where('seq', $stb_data['seq']);
        $update = $this->db->update('stb');

        if ($update != false) {
            return array(
                'status' => false,
                'message' => 'STB tidak berhasil diubah'
            );
        }

        return array(
            'status' => true,
            'message' => 'STB berhasil diubah'
        );
    }
}
