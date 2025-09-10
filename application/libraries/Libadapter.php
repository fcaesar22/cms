<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \phpseclib\Net\SFTP;

class Libadapter {
    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->config('secure_config');
    }

    private static $baseurlimage = 'https://picture.dens.tv/';

    private static $baseurlimageshowcase = 'http://showcase.dens.tv/assets/images/';

    public function execurl($toURL, $post)
    {
        if (stristr($toURL, 'olap')==true) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $toURL = $toURL . '&ipclient=' . $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        }
        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $toURL,
            CURLOPT_HEADER => 0,
            CURLOPT_VERBOSE => 0,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => "Mozilla/4.0 (compatible;)",
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($post),
        );
        curl_setopt_array($ch, $options);
        $result = array(
            'data' => curl_exec($ch),
            'info' => curl_getinfo($ch)
        );
        curl_close($ch);
        return $result;
    }

    public function getImages($path='', $changeDir='')
    {
        if ($path == '' || $path == null || $changeDir == '' || $changeDir == null) {
            return $data = array(
                'error' => '1',
                'message' => 'path or directory empty'
            );
        }
        set_error_handler(function($errno, $errstr) {
            log_message('error', "SFTP Error: $errstr");
            return array(
                'error' => '1',
                'message' => 'SFTP Error: ' . $errstr
            );
        });
        $remote_ip = $this->CI->config->item('sftp_host');
        $remote_port = $this->CI->config->item('sftp_port');
        $remote_user = $this->CI->config->item('sftp_user');
        $remote_pass = $this->CI->config->item('sftp_pass');
        $sftp = new \phpseclib\Net\SFTP($remote_ip,$remote_port);
        if (! $sftp->login($remote_user, $remote_pass)) {
            restore_error_handler();
            return $data = array(
                'error' => '1',
                'message' => 'Login Failed'
            );
        }
        restore_error_handler();
        $changeDir = $sftp->chdir($changeDir);
        if ($changeDir == false) {
            return $data = array(
                'error' => '1',
                'message' => 'Folder not exist'
            );
        } else {
            $files = $sftp->rawlist();            
            if ($files==false) {
                return $data = array(
                    'error' => '1',
                    'message' => 'File not exist'
                );
            } else {
                $files_only_callback = function($a) { return ($a["type"] == NET_SFTP_TYPE_REGULAR); };
                $files = array_filter($files, $files_only_callback);
                usort($files, function($a, $b) { return $a["mtime"] <=> $b["mtime"]; }); 
                $list = array();
                foreach ($files as $key => $value) {
                    $list[] = $value['filename'];
                }
                $cntlist = count($list);
                $listimg = array();
                if ($cntlist>0) {
                    $n = 0;
                    $g = 0;
                    while ($n <$cntlist) {
                        if ($this->filter_img($list[$n])>0) {
                            $listimg[$g]['name'] = $list[$n];
                            $listimg[$g]['url'] = self::$baseurlimage . $path . $list[$n];
                            $g++;
                        }
                        $n++;
                    }
                }
                return $data = array(
                    'error' => '0',
                    'message' => 'success',
                    'content' => $listimg
                );
            }
        }
    }

    private function filter_img($string)
    {
        $imgallow=array('.jpg','.jpeg','.gif','.png');
        $n=0;$res=0;
        while ($n <count($imgallow)) {
            if (stristr($string,$imgallow[$n])) {
                $res = 1;
            }
            $n++;
        }
        return $res;
    }

    public function getShowcaseImages()
    {
        $remote_ip = $this->CI->config->item('sftp_host_showcase');
        $remote_port = $this->CI->config->item('sftp_port_showcase');
        $remote_user = $this->CI->config->item('sftp_user_showcase');
        $remote_pass = $this->CI->config->item('sftp_pass_showcase');
        $remote_dir = '/var/www/html/showcase.dens.tv/assets/images/';
        $sftp  = new \phpseclib\Net\SFTP($remote_ip, $remote_port);
        $image = array();
        if ($sftp->login($remote_user, $remote_pass)) {
            $sftp->chdir($remote_dir);
            $list = $sftp->nlist('.', true);
            foreach ($list as $val) {
                $pathexs = pathinfo($val, PATHINFO_EXTENSION);
                $pathdir = pathinfo($val, PATHINFO_DIRNAME);
                $exs = ['png', 'jpg', 'jpeg'];
                $folder = ['large', 'medium', 'small'];
                if (!is_dir($val) && in_array($pathexs, $exs) && !in_array($pathdir, $folder)) {
                    $x = (string)$sftp->filemtime($val);
                    $image[$x] = self::$baseurlimageshowcase . $val;

                }
            }
            krsort($image);
            $image = array_values($image);
        }
        return $image;
    }
}
