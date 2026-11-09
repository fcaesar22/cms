<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user')) {
            redirect('auth');
        }
        if (!has_permission('view_notifications')) {
            show_error('Anda tidak memiliki akses ke halaman ini', 403, 'Forbidden');
        }
        $this->load->config('secure_config');
        $this->load->library('pagination');
        $this->load->library('libadapter');
        $this->load->model('Notification_model');
    }

    private static $baseurlimage = 'https://picture.dens.tv/wp/';

    public function index()
    {
        $data['title'] = 'List Notifications';
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('notifications/index', $data);
        $this->load->view('layouts/footer');
    }

    public function list_notifications($key_search=null, $sort_by='id', $order_sort='desc', $visible='Y', $rowperpage=10, $rowno=0)
    {
        if ($rowno != 0) {
            $rowno = ($rowno-1) * $rowperpage;
        }

        $key_search = urldecode($key_search);

        $allcount = $this->Notification_model->getCountAll($key_search, $visible);
        $users_record = $this->Notification_model->getDatas($key_search, $sort_by, $order_sort, $visible, $rowperpage, $rowno);

        // Pagination Configuration
        $config['base_url'] = base_url().'notifications/list_notifications/'.$key_search.'/'.$sort_by.'/'.$order_sort.'/'.$visible.'/'.$rowperpage.'/'.$rowno;
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $allcount;
        $config['per_page'] = $rowperpage;
        $config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close'] = '</span>Next</li>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close'] = '</span></li>';
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

    public function inactivated_notification($id)
    {
        if (!isset($id)) show_404();
        
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');
        $inactivated = $this->Notification_model->inactivated_notification($id, $time);
        if ($inactivated == true) {
            $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Inactivated has been successfully!</div>');
            redirect(site_url('notifications'));
        } else {
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Inactivated is failed!</div>');
            redirect(site_url('notifications'));
        }
    }

    public function sendNotification()
    {
        $id = $this->input->post('id');
        
        if (empty($id)) {
            $res = false;
        }

        $checkIdNotification = $this->Notification_model->checkIdNotification($id);

        if ($checkIdNotification['num_rows'] <= 0) {
            $results = array(
                'error' => '1',
                'message' => 'Notification failed to send.'
            );
        } else {
            $result = $checkIdNotification['result'];
            $notification_id = $result['id'];
            $title = $result['title'];
            $message = $result['description'];
            $image_url = $result['image_url'];
            $content_type = $result['content_type'];
            $content_id = $result['content_id'];
            $location = $result['location'];
            $totype = $result['to'];
            
            if ($totype == 'SELECTION') {
                $res = true;
                $firebase_notifications_id = $result['firebase_notifications_id'];
                $explode_fid = explode(',', $firebase_notifications_id);
                $fnid = array_filter($explode_fid);
                $fnid = array_values($fnid);
                $getFnId = $this->Notification_model->getFnId($fnid);
                
                if ($getFnId['num_rows'] > 0) {
                    $result_fnid = $getFnId['result'];
                    $fcm_id = array();
                    foreach ($result_fnid as $key => $value) {
                        $fcm_id[] = $value['uid'];
                    }
                    // send notification selection
                    $this->sendnotifselection($title,$message,$image_url,$content_type,$content_id,$location,$fcm_id);
                    // update status notification
                    $this->Notification_model->messageStatus($notification_id);
                }
            } else {
                $res = true;
                $topic = $totype;
                // send notifications all
                $this->sendnotifglobal($title,$message,$image_url,$content_type,$content_id,$location,$topic);
                // update status notification
                $this->Notification_model->messageStatus($notification_id);
            }
        }

        if ($res == false) {
            $results = array(
                'error' => '1',
                'message' => 'Notification failed to send.'
            );
        } else {
            $results = array(
                'error' => '0',
                'message' => 'Notification success to send.'
            );
        }

        echo json_encode($results);
    }

    public function sendnotifselection($title=null, $message=null, $image_url=null, $content_type=null, $content_id=null, $location=null, $fcm_id=null)
    {
        $url = $this->config->item('url_project_fcm');
        $getToken = $this->getAccessToken();
        $accessToken = $getToken->access_token;
        $headers = array(
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json'
        );
        if (!empty($fcm_id))
        {
            if (is_array($fcm_id))
            {
                foreach ($fcm_id as $token) {
                    $fields = array(
                        'message' => array(
                            "token" => $token,
                            "notification" => array(
                                "body" => $message,
                                "title" => $title,
                                "image" => $image_url,
                            ),
                            "data" => array(
                                'content_id' => $content_id
                            ),
                            'android' => array(
                                'notification' => array(
                                    "click_action" => $content_type
                                )
                            ),
                            'apns' => array(
                                'payload' => array(
                                    'aps' => array(
                                        'category' => $content_type
                                    )
                                )
                            ),
                            'webpush' => array(
                                'fcm_options' => array(
                                    'link' => $location
                                )
                            )
                        ),
                    );
                    $fields = json_encode($fields);
                    $curl = $this->curlPost($url,$fields,$headers);
                }
            }
        }
    }

    public function sendnotifglobal($title=null, $message=null, $image_url=null, $content_type=null, $content_id=null, $location=null, $topic=null)
    {
        $url = $this->config->item('url_project_fcm');
        $getToken = $this->getAccessToken();
        $accessToken = $getToken->access_token;
        $headers = array (
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json'
        );

        $fields = array(
            'message' => array(
                'topic' => $topic,
                'notification' => array(
                    "body" => $message,
                    "title" => $title,
                    "image" => $image_url
                ),
                "data" => array(
                    'content_id' => $content_id
                ),
                'android' => array(
                    'notification' => array(
                        "click_action" => $content_type
                    )
                ),
                'apns' => array(
                    'payload' => array(
                        'aps' => array(
                            'category' => $content_type
                        )
                    )
                ),
                'webpush' => array(
                    'fcm_options' => array(
                        'link' => $location
                    )
                )
            )
        );
        $fields = json_encode($fields);

        $curl = $this->curlPost($url, $fields, $headers);
    }

    public function getAccessToken()
    {
        // Read service account details
        $urlAuth = $this->config->item('auth_config_fcm');
        $authConfigString = file_get_contents($urlAuth);

        // Parse service account details
        $authConfig = json_decode($authConfigString);        

        // Read private key from service account details
        $secret = openssl_get_privatekey($authConfig->private_key);

        // Create the token header
        $header = json_encode([
            'typ' => 'JWT',
            'alg' => 'RS256'
        ]);

        $time = time();

        // Allow 1 minute time deviation
        $start = $time - 60;
        $end = $time + 3600;

        $payload = json_encode([
            "iss" => $authConfig->client_email,
            "scope" => "https://www.googleapis.com/auth/firebase.messaging",
            "aud" => "https://oauth2.googleapis.com/token",
            "exp" => $end,
            "iat" => $start
        ]);

        // Encode Header
        $base64UrlHeader = $this->base64UrlEncode($header);

        // Encode Payload
        $base64UrlPayload = $this->base64UrlEncode($payload);

        // Create Signature Hash
        $result = openssl_sign($base64UrlHeader . "." . $base64UrlPayload, $signature, $secret, OPENSSL_ALGO_SHA256);

        // Encode Signature to Base64Url String
        $base64UrlSignature = $this->base64UrlEncode($signature);

        // Create JWT
        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

        //-----Request token------
        $options = array('http' => array(
            'method'  => 'POST',
            'content' => 'grant_type=urn:ietf:params:oauth:grant-type:jwt-bearer&assertion='.$jwt,
            'header'  =>
                "Content-Type: application/x-www-form-urlencoded"
        ));
        $context  = stream_context_create($options);
        $responseText = file_get_contents("https://oauth2.googleapis.com/token", false, $context);

        return json_decode($responseText);
    }

    function base64UrlEncode($text)
    {
        return str_replace(
            ['+', '/', '='],
            ['-', '_', ''],
            base64_encode($text)
        );
    }

    public function curlPost($url,$params,$headers)
    {        
        // Initialize cURL session
        $ch = curl_init($url);

        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Execute the request and capture the response
        $response = curl_exec($ch);

        // Get the HTTP status code
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Separate the header from the body of the response
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        // Close cURL session
        curl_close($ch);
        $result = array(
            'status_code' => $status_code,
            'headers' => $header,
            'body' => $body
        );
        return $result;
    }

    public function getListTo()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        
        $offset = max(0, ($page - 1) * $perPage);

        $results = $this->Notification_model->getListTo($perPage, $offset, $searchTerm, 'data');

        $countResults = $this->Notification_model->getListTo($perPage, $offset, $searchTerm, 'count');

        $data = array();

        foreach ($results as $row) {
            $data[] = array(
                'id' => $row['id'],
                'text' => $row['title']
            );
        }

        $select = array(
            'total_count' => $countResults,
            'items' => $data
        );

        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function getSingleTo()
    {
        $id = $this->input->post('id');

        $data = $this->Notification_model->getSingleTo($id);

        if ($data === null) {
            $this->output
                ->set_status_header(404)
                ->set_content_type('application/json')
                ->set_output(json_encode(array(
                    'id' => null,
                    'text' => ''
                )));
            return;
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                'id' => $data->id,
                'text' => $data->title
            )));
    }

    public function getListContentType()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        
        $offset = max(0, ($page - 1) * $perPage);

        $results = $this->Notification_model->getListContentType($perPage, $offset, $searchTerm, 'data');

        $countResults = $this->Notification_model->getListContentType($perPage, $offset, $searchTerm, 'count');

        $data = array();

        foreach ($results as $row) {
            $data[] = array(
                'id' => $row['id'],
                'text' => $row['title']
            );
        }

        $select = array(
            'total_count' => $countResults,
            'items' => $data
        );

        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function getSingleContentType()
    {
        $id = $this->input->post('id');

        $data = $this->Notification_model->getSingleContentType($id);

        if ($data === null) {
            $this->output
                ->set_status_header(404)
                ->set_content_type('application/json')
                ->set_output(json_encode(array(
                    'id' => null,
                    'text' => ''
                )));
            return;
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                'id' => $data->id,
                'text' => $data->title
            )));
    }

    public function getListUid()
    {
        $searchTerm = $this->input->post('searchTerm');
        $page = $this->input->post('page');
        $perPage = 10;
        if($page != 0){
            $page = ($page-1) * $perPage;
        }
        $results = $this->Notification_model->getListUid($perPage, $page, $searchTerm, 'data');
        $countResults = $this->Notification_model->getListUid($perPage, $page, $searchTerm, 'count');
        $data = array();
        foreach ($results as $row) {
            $data[] = array(
                "id" => $row['id'],
                "text" => $row['user_id']
            );
        }
        $select['total_count'] = $countResults;
        $select['items'] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function getMultipleUid()
    {
        $ids = $this->input->post('ids');
        if (!is_array($ids)) {
            $ids = [$ids];
        }
        $genres = [];
        foreach ($ids as $id) {
            $group = $this->Notification_model->getMultipleUid($id);
            if ($group) {
                $genres[] = [
                    'id' => $group->id,
                    'text' => $group->user_id
                ];
            }
        }
        echo json_encode($genres);
    }

    public function create()
    {
        $CI =& get_instance();
        $data['title'] = 'Add Notification';
        
        $this->form_validation->set_rules('to', 'To', 'required', ['required' => 'To harus dipilih']);
        $this->form_validation->set_rules('title', 'Title', 'required', ['required' => 'Title harus diisi']);
        $this->form_validation->set_rules('description', 'Description', 'required', ['required' => 'Description harus diisi']);
        $this->form_validation->set_rules('send_date', 'Send Date', 'required', ['required' => 'Send Date harus dipilih']);

        if ($this->form_validation->run() == FALSE) {
            $data['selected_to'] = set_value('to');
            $data['selected_content_type'] = set_value('content_type');
            $data['selected_uid'] = $this->input->post('uid');
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('notifications/create', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $to = $this->input->post('to');
            $uid = $this->input->post('uid');
            $fid = "";
            if ($to == 'SELECTION') {
                if ($uid != null || $uid != "") {
                    $fid = ','.implode(",",$uid).',';
                }
            }
            $notification_data = [
                'to' => $to,
                'firebase_notifications_id' => $fid,
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'content_type' => $this->input->post('content_type'),
                'content_id' => $this->input->post('content_id'),
                'location' => $this->input->post('location'),
                'send_date' => $this->input->post('send_date'),
                'image_url' => $this->input->post('banner_image'),
                'visible' => 'Y',
                'create_date' => $time,
                'update_date' => $time,
                'ctrloc' => '/notifications/create'
            ];

            $saved = $this->Notification_model->insertNotification($notification_data);

            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Notification berhasil disimpan</div>');
                return redirect('notifications');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Notification tidak berhasil disimpan</div>');
                return redirect('notifications');
            }
        }
    }

    public function edit($id = null)
    {
        $CI =& get_instance();
        if (!$id) show_404();
        $notification = $this->Notification_model->getNotificationById($id);
        if (!$notification) show_404();
        $data['title'] = 'Edit Notification';
        $data['notification'] = $notification;

        $this->form_validation->set_rules('to', 'To', 'required', ['required' => 'To harus dipilih']);
        $this->form_validation->set_rules('title', 'Title', 'required', ['required' => 'Title harus diisi']);
        $this->form_validation->set_rules('description', 'Description', 'required', ['required' => 'Description harus diisi']);
        $this->form_validation->set_rules('send_date', 'Send Date', 'required', ['required' => 'Send Date harus dipilih']);

        if ($this->form_validation->run() == FALSE) {
            $data['selected_to'] = set_value('to') ?: $notification['to'];
            $data['selected_content_type'] = set_value('content_type') ?: $notification['content_type'];
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar');
            $this->load->view('notifications/edit', $data);
            $this->load->view('layouts/footer');
        } else {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $to = $this->input->post('to');
            $uid = $this->input->post('uid');
            $fid = "";
            if ($to == 'SELECTION') {
                if ($uid != null || $uid != "") {
                    $fid = ','.implode(",",$uid).',';
                }
            }
            $notification_data = [
                'to' => $to,
                'firebase_notifications_id' => $fid,
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'content_type' => $this->input->post('content_type'),
                'content_id' => $this->input->post('content_id'),
                'location' => $this->input->post('location'),
                'send_date' => $this->input->post('send_date'),
                'image_url' => $this->input->post('banner_image'),
                'update_date' => $time,
                'ctrloc' => '/notifications/edit'
            ];

            $saved = $this->Notification_model->updateNotification($id, $notification_data);

            if ($saved == true) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Notification berhasil diubah</div>'); 
                return redirect('notifications');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Notification tidak berhasil diubah</div>');
                return redirect('notifications');
            }
        }
    }

    public function getToken()
    {
        $toURL = $this->config->item('url_token_uploader');
        $post = array();
        $exe = $this->libadapter->execurl($toURL, $post);
        $_token = json_decode($exe['data'],true);
        echo $_token['token'];
    }

    public function compareBannerImage()
    {
        echo json_encode($this->getImageBannerLandscape());
    }

    private function getImageBannerLandscape()
    {
        $data = array();
        $_arrFolder = array();
        $_urlimage = array();
        
        //formed array from server
        $path = 'wp/img/notif_v1/3840x3840/';
        $changeDir = 'wp/img/notif_v1/3840x3840/';
        $listimg = $this->libadapter->getImages($path, $changeDir);
        
        if ($listimg['error'] == 0) {
            $_arrFolder = array();
            $listimg1 = $listimg['content'];
            foreach ($listimg1 as $key => $value) {
                $_arrFolder[] = $value['url'];
            }
            krsort($_arrFolder);
            
            //formed array from database
            $urlimage = $this->Notification_model->getImageBannerLandscape();
            
            if ($urlimage != null) {
                foreach ($urlimage as $key => $value) {
                    array_push($_urlimage, self::$baseurlimage . $path . basename($value['image_url']));
                }
            }
            
            $datas=array_values(array_diff($_arrFolder, $_urlimage));
            $data = array_slice($datas,0,10);
            $results = array(
                'error' => '0',
                'message' => 'success',
                'content' => $data,
            );
        } else {
            $results = array(
                'error' => '1',
                'message' => 'failed',
                'content' => $data,
            );
        }
        return $results;
    }
}
