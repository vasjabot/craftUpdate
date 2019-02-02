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
require_once(__DIR__.'/SimpleXMLvalidator.php');



interface SimpleXMLproviderInterface
{
    ///return $result_xml///
    public function getFileXML($XML_name);
    public function requestNewXML($XML_name);
    public function getAllXML($XML_arr_names);
}

abstract class AbstractSimpleXMLprovider implements SimpleXMLproviderInterface
{
    protected $config;
    protected $DEBUG;

    public function __construct($Config, $DEBUG=FALSE)
    {
        $this->config = $Config;
        $this->DEBUG = $DEBUG;      
    }
}

class SimpleXMLprovider extends AbstractSimpleXMLprovider
{
    public function getFileXML($XML_name)
    {
        if ($this->DEBUG == TRUE) 
        {
            $simpleXMLloader = new SimpleXMLloader($this->config);
            $xml_return = $simpleXMLloader->loadFileXML($XML_name);
            if ($xml_return == NULL)
            {
                $xml_return = $this->requestNewXML($XML_name);    
            }
            return $xml_return;
        }
        else
        {
            return $xml_return = $this->requestNewXML($XML_name);
        }      
    }


    public function requestNewXML($XML_name)
    {
        $curlRequestor = new CurlRequestor($this->config->LOGIN, $this->config->PWS);
        $url = $this->config->getURLbyFileName($XML_name);
        $result_request = $curlRequestor->getData($url);

        $simpleXMLsaver = new SimpleXMLsaver($this->config);
        $xml_request = $simpleXMLsaver->saveFileXML($XML_name, $result_request);
        return $xml_request;
    }




    public function getAllXML($XML_arr_names)
    {
        $XML_arr = array  ( "prototypes" => $xml_prototypes,
                            "offers" => $xml_offers,
                            "prices" => $xml_prices,
                            "instock" => $xml_instock,
                            "compatibility" => $xml_compatibility);


        foreach($XML_arr_names as $key => $value)
        {
            $xml_temp_result = $this->getFileXML($value);
            $XML_arr[$key] = $xml_temp_result;
        } 
        
        $simpleXMLvalidator = new SimpleXMLvalidator($this->config);

        $Is_All_Good = $simpleXMLvalidator->checkAllXML($XML_arr_names);

        if ($Is_All_Good == FALSE)
        {
           return NULL;
        }
        else
        {
            return $XML_arr;
        }


    }



}


?>