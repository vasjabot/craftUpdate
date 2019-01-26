<?php 
/**
*-------------------------------------------------------------------------------
* SimpleXMLprovider Class
*-------------------------------------------------------------------------------
* This is a class for curl requests execution.
* @package  SimpleXMLNS 
* @author   mixxxxx 
* @link     top-secret
*/

namespace SimpleXMLNS;

require_once(__DIR__.'/../Common/Config.php');
require_once(__DIR__.'/SimpleXMLsaver.php');
require_once(__DIR__.'/SimpleXMLloader.php');



interface SimpleXMLproviderInterface
{
    ///return $result_xml///
    public function loadFileXML($FileName);
}

abstract class AbstractSimpleXMLprovider implements SimpleXMLproviderInterface
{
    protected $file_name;
    protected $config;

    public function __construct($FileName, $Config)
    {
        $this->file_name = $FileName;
        $this->config = $Config;       
    }
}

class SimpleXMLprovider extends AbstractSimpleXMLprovider
{
    public function getFileXML()
    {
        if (file_exists($this->file_name))
        {
            $xml_loaded = simplexml_load_file($this->file_name);
            return $xml_loaded;
        }
        else 
            return NULL;       
    }


    public function requestNewXML()
    {
        $curlRequestor = new CurlRequestor($this->config->LOGIN, $this->config->PWS);
        $url = $this->config->getURLbyFileName($this->file_name);
        $result_request = $curlRequestor->getData($url);

        $simpleXMLsaver = new SimpleXMLsaver();
        $xml_prototypes = $simpleXMLsaver->saveFileXML($this->file_name, $result_request);
    }


}


?>