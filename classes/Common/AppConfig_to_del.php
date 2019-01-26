<?php 
/**
*-------------------------------------------------------------------------------
* Config Class
*-------------------------------------------------------------------------------
* This is a simple class for config.
* @package 	CommonNS 
* @author 	mixxxxx 
* @link 	top-secret
*/

namespace CommonNS;

class AppConfig 
{   
    public $auth_path_file;
    public $LOGIN;
    public $PWS;
    public $url_prototypes;
    public $TimeLastSync_prototypes=0;

    public function __construct()
    {
        $this->auth_path_file = $_SERVER["DOCUMENT_ROOT"] . '/bitrix/components/esfull/craftUpdateFull/AUTH.txt';
        $this->extractCredentials();
        $this->url_prototypes = "http://middle.craftmann.ru:8080/craftmiddle/ws/bitrixinfo/allDevices/" . $this->TimeLastSync_prototypes;
        
    }


    public  function extractCredentials()
    {   
        $file_auth = fopen($this->auth_path_file, 'r');
        $fread_result_auth = fread($file_auth, filesize($this->auth_path_file));
        fclose($file_auth);
        $pieces = explode(";", $fread_result_auth);
        $this->LOGIN = $pieces[0];
        $this->PWS = $pieces[1];
    }



}
/* @end config.php */
?>