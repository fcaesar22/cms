<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Section_package_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    private function getTypeSectionOptions()
    {
        return array(
            array(
                'id' => '0',
                'title' => 'Main Package'
            ),
            array(
                'id' => '1',
                'title' => 'Add-On Package'
            ),
        );
    }

    public function getListTypeSection($perPage, $page, $searchTerm, $type)
    {
        $data = $this->getTypeSectionOptions();

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

    public function getSingleTypeSection($id)
    {
        foreach ($this->getTypeSectionOptions() as $row) {
            if ($row['id'] === $id) {
                return (object) $row;
            }
        }

        return null;
    }

    private function getDeviceSectionOptions()
    {
        return array(
            array(
                'id' => '10',
                'title' => 'WEB'
            ),
            array(
                'id' => '20',
                'title' => 'STB'
            ),
            array(
                'id' => '30',
                'title' => 'ANDROID'
            ),
            array(
                'id' => '40',
                'title' => 'IOS'
            ),
        );
    }

    public function getListDeviceSection($perPage, $page, $searchTerm, $type)
    {
        $data = $this->getDeviceSectionOptions();

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

    public function getSingleDeviceSection($id)
    {
        foreach ($this->getDeviceSectionOptions() as $row) {
            if ($row['id'] === $id) {
                return (object) $row;
            }
        }

        return null;
    }

    public function getCountSectionAll($key_search, $visible, $type, $device)
    {
        $this->db->select('COUNT(package_ott.id_package_ott) AS total', false);
        $this->db->from('package_ott');
        $this->db->join('package', 'package.seq = package_ott.id_package', 'left');
        
        if ($key_search != 'null') {
            $this->db->like('package.title', $key_search);
        }

        $this->db->where('package_ott.visible', $visible);
        $this->db->where('package_ott.type_package', $type);
        $this->db->where('package_ott.app_type', $device);

        $result = $this->db->get()->row_array();

        return (int) $result['total'];
    }

    public function getDatasSection($key_search, $sort_by, $order_sort, $visible, $type, $device, $rowperpage, $rowno)
    {
        $this->db->select('package_ott.*, package.title');
        $this->db->from('package_ott');
        $this->db->join('package', 'package.seq = package_ott.id_package', 'left');

        if ($key_search != 'null') {
            $this->db->like('package.title', $key_search);
        }

        $this->db->where('package_ott.visible', $visible);
        $this->db->where('package_ott.type_package', $type);
        $this->db->where('package_ott.app_type', $device);

        if ($visible == 'Y') {
            $this->db->order_by('CAST(package_ott.sort AS decimal) ASC', false);
        } else {
            $this->db->order_by($sort_by, $order_sort);
        }

        $this->db->limit($rowperpage, $rowno);
        $query = $this->db->get();
        
        return $query->result_array();
    }

    public function update_sort($idPackage, $sort, $type, $device)
    {
        $this->db->where('id_package_ott', $idPackage);
        $this->db->where('type_package', $type);
        $this->db->where('app_type', $device);
        $this->db->where('visible', 'Y');

        $this->db->update('package_ott', [
            'sort' => $sort
        ]);

        return $this->db->affected_rows();
    }

    public function activatedSection($id, $type, $device, $time)
    {
        if (empty($id)) {
            return false;
        }

        $this->db->trans_start();

        $this->db->select('sort');
        $this->db->from('package_ott');
        $this->db->where('visible', 'Y');
        $this->db->where('type_package', $type);
        $this->db->where('app_type', $device);
        $this->db->order_by('CAST(sort AS decimal) DESC', false);
        $sort = $this->db->get()->row('sort');

        $this->db->set('visible', 'Y');
        $this->db->set('sort', $sort + 1);
        $this->db->where('id_package_ott', $id);
        $this->db->update('package_ott');
        $this->db->trans_complete();
        
        $msg = true;

        if ($this->db->trans_status() === FALSE) {
            $msg = false;
        }

        return $msg;
    }

    public function inactivatedSection($id, $type, $device, $time)
    {
        if (empty($id)) {
            return false;
        }

        $this->db->trans_start();

        $this->db->set('visible', 'N');
        $this->db->set('sort', NULL);
        $this->db->where('id_package_ott', $id);
        $this->db->update('package_ott');

        $this->db->select('id_package_ott, sort');
        $this->db->from('package_ott');
        $this->db->where('visible', 'Y');
        $this->db->where('type_package', $type);
        $this->db->where('app_type', $device);
        $this->db->order_by('CAST(sort AS decimal) ASC', false);
        $result = $this->db->get()->result_array();

        $data = array();
        $i=1;
        foreach ($result as $key => $value) {
            $data[] = array(
                'sort' => $i,
                'id_package_ott' => $value['id_package_ott']
            );
            $i++;
        }

        $this->db->update_batch('package_ott', $data, 'id_package_ott');
        
        $this->db->trans_complete();
        
        $msg = true;
        
        if ($this->db->trans_status() === FALSE) {
            $msg = false;
        }

        return $msg;
    }

    public function getListPackageSection($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('package');
        if ($type == 'data') {
            if ($searchTerm!=null) {
                $this->db->like('title', $searchTerm);
            }
            $this->db->where('pkgtype', '0');
            $this->db->where('visible', 'Y');
            $this->db->where('affiliate', 'OTT');
            $this->db->order_by('seq', 'desc');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm!=null) {
                $this->db->like('title', $searchTerm);
            }
            $this->db->where('pkgtype', '0');
            $this->db->where('visible', 'Y');
            $this->db->where('affiliate', 'OTT');
            return $this->db->get()->num_rows();
        }
    }

    public function getSinglePackageSection($id)
    {
        $this->db->select('*');
        $this->db->from('package');
        $this->db->where('seq', $id);
        return $this->db->get()->row();
    }

    private function getBooleanSectionOptions()
    {
        return array(
            array(
                'id' => '0',
                'title' => 'Inactive'
            ),
            array(
                'id' => '1',
                'title' => 'Active'
            ),
        );
    }

    public function getListBooleanSection($perPage, $page, $searchTerm, $type)
    {
        $data = $this->getBooleanSectionOptions();

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

    public function getSingleBooleanSection($id)
    {
        foreach ($this->getBooleanSectionOptions() as $row) {
            if ($row['id'] === $id) {
                return (object) $row;
            }
        }

        return null;
    }

    public function getListPackageAddonSection($perPage, $page, $searchTerm, $type)
    {
        $this->db->select('*');
        $this->db->from('package');
        if ($type == 'data') {
            if ($searchTerm!=null) {
                $this->db->like('title', $searchTerm);
            }
            $this->db->where('pkgtype', '1');
            $this->db->where('visible', 'Y');
            $this->db->where('affiliate', 'OTT');
            $this->db->order_by('seq', 'desc');
            $this->db->limit($perPage, $page);
            return $this->db->get()->result_array();
        } else {
            if ($searchTerm!=null) {
                $this->db->like('title', $searchTerm);
            }
            $this->db->where('pkgtype', '1');
            $this->db->where('visible', 'Y');
            $this->db->where('affiliate', 'OTT');
            return $this->db->get()->num_rows();
        }
    }

    public function getMultiplePackageAddonSection($id)
    {
        return $this->db->get_where('package', ['seq' => $id])->row();
    }

    private function getButtonFlagSectionOptions()
    {
        return array(
            array(
                'id' => 'page_watch',
                'title' => 'Page Watch'
            ),
            array(
                'id' => 'page_add_on',
                'title' => 'Page Add On'
            ),
            array(
                'id' => 'page_offer',
                'title' => 'Page Offer'
            ),
        );
    }

    public function getListButtonFlagSection($perPage, $page, $searchTerm, $type)
    {
        $data = $this->getButtonFlagSectionOptions();

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

    public function getSingleButtonFlagSection($id)
    {
        foreach ($this->getButtonFlagSectionOptions() as $row) {
            if ($row['id'] === $id) {
                return (object) $row;
            }
        }

        return null;
    }

    private function getBuyAddonSectionOptions()
    {
        return array(
            array(
                'id' => '0',
                'title' => 'Must Buy Main Package'
            ),
            array(
                'id' => '1',
                'title' => 'Only Addon'
            ),
        );
    }

    public function getListBuyAddonSection($perPage, $page, $searchTerm, $type)
    {
        $data = $this->getBuyAddonSectionOptions();

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

    public function getSingleBuyAddonSection($id)
    {
        foreach ($this->getBuyAddonSectionOptions() as $row) {
            if ($row['id'] === $id) {
                return (object) $row;
            }
        }

        return null;
    }

    public function getImageBannerLandscape()
    {
        $data = $this->db->query("select banner_url from package_ott");
        return $data->result_array();
    }

    public function getImagePopupLandscape()
    {
        $data = $this->db->query("select popup_url from package_ott");
        return $data->result_array();
    }

    public function insertSection($section_data)
    {
        return $this->db->insert('package_ott', $section_data);
    }

    public function getSectionById($id)
    {
        $result = array();
        
        $this->db->select('*');
        $this->db->from('package_ott');
        $this->db->where('id_package_ott', $id);
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        
        if ($num_rows > 0) {
            $result = $query->row_array();
            
            $labelButton = $result['label_button'];
            $decodeLabel = json_decode($labelButton, TRUE);
            $result['label_button_sudah_signin'] = $decodeLabel['signin'] ?? null;
            $result['label_button_belum_signin'] = $decodeLabel['not_signin'] ?? null;
            $result['flag'] = $decodeLabel['flag'] ?? null;
            $result['required_signin'] = ($decodeLabel['required_signin'] ?? 0) ? 1 : 0;
            
            $include_addon = $result['include_addon'];
            $trimexplodeaddon = array_filter(explode(',', trim($include_addon, ',')));

            if (!empty($trimexplodeaddon)) {
                $this->db->select('seq, title');
                $this->db->from('package');
                $this->db->where_in('seq', $trimexplodeaddon);

                $result['include_addon'] = $this->db->get()->result_array();
            } else {
                $result['include_addon'] = array();
            }
        }

        return $result;
    }

    public function updateSection($id, $section_data)
    {
        $this->db->where('id_package_ott', $id);
        return $this->db->update('package_ott', $section_data);
    }
}
