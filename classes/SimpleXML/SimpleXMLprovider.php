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
use CurlNS\CurlRequestor as CurlRequestor;
use CommonNS\AppConfig as AppConfig;

require_once(__DIR__.'/../Common/AppConfig.php');
require_once(__DIR__.'/../Curl/CurlRequestor.php');
require_once(__DIR__.'/SimpleXMLsaver.php');
require_once(__DIR__.'/SimpleXMLloader.php');



interface SimpleXMLproviderInterface
{
    ///return $result_xml///
    public function getFileXML();
    public function requestNewXML();
}

abstract class AbstractSimpleXMLprovider implements SimpleXMLproviderInterface
{
    protected $file_name;
    protected $config;
    protected $DEBUG;

    public function __construct($FileName, $Config, $DEBUG=FALSE)
    {
        $this->file_name = $FileName;
        $this->config = $Config;
        $this->DEBUG = $DEBUG;      
    }
}

class SimpleXMLprovider extends AbstractSimpleXMLprovider
{
    public function getFileXML()
    {
        if ($this->DEBUG == TRUE) 
        {
            $simpleXMLloader = new SimpleXMLloader();
            $xml_return = $simpleXMLloader->loadFileXML($this->file_name);
            if ($xml_return == NULL)
            {
                $xml_return = $this->requestNewXML();    
            }
            return $xml_return;
        }
        else
        {
            return $xml_return = $this->requestNewXML();
        }      
    }


    public function requestNewXML()
    {
        $curlRequestor = new CurlRequestor($this->config->LOGIN, $this->config->PWS);
        $url = $this->config->getURLbyFileName($this->file_name);
        $result_request = $curlRequestor->getData($url);

        $simpleXMLsaver = new SimpleXMLsaver();
        $xml_request = $simpleXMLsaver->saveFileXML($this->file_name, $result_request);
        return $xml_request;
    }


}


?>