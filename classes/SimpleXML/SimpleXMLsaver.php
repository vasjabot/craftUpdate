<?php 
/**
*-------------------------------------------------------------------------------
* SimpleXMLsaver Class
*-------------------------------------------------------------------------------
* This is a class for curl requests execution.
* @package  SimpleXMLNS 
* @author   mixxxxx 
* @link     top-secret
*/

namespace SimpleXMLNS;

interface SimpleXMLsaverInterface
{
    ///return $saved_xml///
    public function saveFileXML($FileName, $ResultToWrite);
}

abstract class AbstractSimpleXMLsaver implements SimpleXMLsaverInterface
{
    protected $file_name;
    protected $result_to_write;
    protected $config;

    public function __construct($Config)
    {
        $this->config = $Config;
    }
}

class SimpleXMLsaver extends AbstractSimpleXMLsaver
{
    public function saveFileXML($FileName, $ResultToWrite)
    {
        chdir($this->config->componentDIR);
        $this->file_name = $FileName;
        $this->result_to_write = $ResultToWrite;

        $file_xml = fopen($this->file_name, 'w');
        fwrite($file_xml, $this->result_to_write);
        fclose($file_xml);
        $file_xml = mb_convert_encoding($file_xml, 'UTF-8', 'OLD-ENCODING');
        $xml_saved = simplexml_load_file($this->file_name);
        $xml_saved->asXML($this->file_name);
        return $xml_saved;
    }
}




?>