<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \phpseclib\Net\SFTP;

class Libadapter {
    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->config('secure_config');
    }

    private static $baseurlimage = 'https://picture.dens.tv/wp/';

    public function execurl($toURL, $post) {
        if (stristr($toURL, 'olap')==true) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $toURL=$toURL.'&ipclient='.$_SERVER['HTTP_X_FORWARDED_FOR'];
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

        if (! $sftp->login($remote_user, $remote_pass))
        {
            restore_error_handler();
            return $data = array(
                'error' => '1',
                'message' => 'Login Failed'
            );
        }

        restore_error_handler();

        $changeDir = $sftp->chdir($changeDir);
        if ($changeDir == false)
        {
            return $data = array(
                'error' => '1',
                'message' => 'Folder not exist'
            );
        }
        else
        {
            $files = $sftp->rawlist();            
            if ($files==false)
            {
                return $data = array(
                    'error' => '1',
                    'message' => 'File not exist'
                );
            }
            else
            {
                $files_only_callback = function($a) { return ($a["type"] == NET_SFTP_TYPE_REGULAR); };
                $files = array_filter($files, $files_only_callback);

                // sort by timestamp
                // usort($files, function($a, $b) { return $b["mtime"] - $a["mtime"]; });
                // In PHP 7, you can use spaceship operator instead:
                usort($files, function($a, $b) { return $a["mtime"] <=> $b["mtime"]; }); 

                // pick the latest file
                $list = array();
                foreach ($files as $key => $value) {
                    $list[] = $value['filename'];
                }
                
                $cntlist=count($list);
                $listimg=array();
                if($cntlist>0)
                {
                    $n=0;$g=0;
                    while ($n <$cntlist){
                        if($this->filter_img($list[$n])>0)
                        {
                            $listimg[$g]['name']=$list[$n];
                            $listimg[$g]['url']=self::$baseurlimage.$path.$list[$n];
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
        while ($n <count($imgallow))
        {
            if(stristr($string,$imgallow[$n]))
            {
                $res=1;
            }
            $n++;
        }
        return $res;
    }
}
