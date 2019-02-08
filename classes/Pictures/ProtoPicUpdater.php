<?php 
/**
*-------------------------------------------------------------------------------
* ProtoPicUpdater Class
*-------------------------------------------------------------------------------
* This is a class for updating pictures for Prototypes.
* @package  PicturesNS 
* @author   mixxxxx 
* @link     top-secret
*/

namespace PicturesNS;

interface ProtoPicUpdaterInterface
{
    public function getCurlTelPicToCurDirByArticle($ProtoArticle);
}

abstract class AbstractProtoPicUpdater implements ProtoPicUpdaterInterface
{
    protected $config;

    public function __construct($Config)
    {
        $this->config = $Config;
    }
}

class ProtoPicUpdater extends AbstractProtoPicUpdater
{
    public function getCurlTelPicToCurDirByArticle($ProtoArticle)
    {
        $ch_func = curl_init();
        curl_setopt($ch_func, CURLOPT_RETURNTRANSFER, 1);
        $CurlUrl = 'http://middle.craftmann.ru:8080/craftmiddle/ws/clientsinfo/deviceImageFile/' . $ProtoArticle;
        curl_setopt($ch_func, CURLOPT_URL, $CurlUrl);
        curl_setopt($ch_func, CURLOPT_USERPWD, $this->config->LOGIN.":".$this->config->PWS);
        $result_func = curl_exec($ch_func);
        curl_close($ch_func);

        ///////////////////////////chdir($CurlPICdir);
        $Curl_file_name = $ProtoArticle . '.jpg';
        $file = fopen($Curl_file_name, 'w');
        fwrite($file, $result_func);
        fclose($file);
        if (exif_imagetype($Curl_file_name)==3) 
        {
           $Curl_file_name_png = $ProtoArticle . '.png';
           rename ($Curl_file_name,$Curl_file_name_png);
           $Curl_file_name = $Curl_file_name_png;
        }
        return $Curl_file_name;
        
    }
}




?>

