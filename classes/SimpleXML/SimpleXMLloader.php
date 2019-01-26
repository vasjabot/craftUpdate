<?php 
/**
*-------------------------------------------------------------------------------
* SimpleXMLloader Class
*-------------------------------------------------------------------------------
* This is a class for curl requests execution.
* @package  SimpleXMLNS 
* @author   mixxxxx 
* @link     top-secret
*/

namespace SimpleXMLNS;

interface SimpleXMLloaderInterface
{
    ///return $result_xml///
    public function loadFileXML($FileName);
}

abstract class AbstractSimpleXMLloader implements SimpleXMLloaderInterface
{
    protected $file_name;
    protected $config;

    public function __construct($Config)
    {
        $this->config = $Config;
    }
}

class SimpleXMLloader extends AbstractSimpleXMLloader
{
    public function loadFileXML($FileName)
    {
        $this->file_name = $FileName;
        $absFileName = $this->config->componentDIR . $this->file_name;
        if (file_exists($absFileName))
        {
            $xml_loaded = simplexml_load_file($absFileName);
            return $xml_loaded;
        }
        else 
            return NULL;
        
    }
}


?>