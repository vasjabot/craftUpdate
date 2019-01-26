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

    public function __construct()
    {
        
    }
}

class SimpleXMLloader extends AbstractSimpleXMLloader
{
    public function loadFileXML($FileName)
    {
        $this->file_name = $FileName;
        if (file_exists($this->file_name))
        {
            $xml_loaded = simplexml_load_file($this->file_name);
            return $xml_loaded;
        }
        else 
            return NULL;
        
    }
}


?>