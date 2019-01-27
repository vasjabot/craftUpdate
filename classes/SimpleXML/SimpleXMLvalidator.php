<?php 
/**
*-------------------------------------------------------------------------------
* SimpleXMLvalidator Class
*-------------------------------------------------------------------------------
* This is a class for curl requests execution.
* @package  SimpleXMLNS 
* @author   mixxxxx 
* @link     top-secret
*/

namespace SimpleXMLNS;
use CommonNS\AppConfig as AppConfig;
require_once(__DIR__.'/../Common/AppConfig.php');

interface SimpleXMLvalidatorInterface
{
    ///check $saved_xml for CRAFTMIDDLE_IS_DEAD///
    public function checkFileXML($FileName);
    ///check all xmls for checkFileXML method///
    public function checkAllXML($XML_arr_names);
}

abstract class AbstractSimpleXMLvalidator implements SimpleXMLvalidatorInterface
{
    protected $file_name;
    protected $config;
    protected $CRAFTMIDDLE_IS_DEAD;

    public function __construct($Config)
    {
         $this->config = $Config;
         $this->CRAFTMIDDLE_IS_DEAD = FALSE;
    }
}

class SimpleXMLvalidator extends AbstractSimpleXMLvalidator
{
    public function checkFileXML($FileName)
    {
        $this->file_name = $FileName;

        chdir($this->config->componentDIR);

        if (file_exists($FileName))
        {  
            $xml_to_validate = simplexml_load_file($this->file_name);
            $xml_to_validate_node_title = $xml_to_validate->xpath('//title');
            $xml_to_validate_node_title_arr = (array)$xml_to_validate_node_title[0];

            if ($xml_to_validate_node_title_arr[0] == 'Error')
            {
                $this->CRAFTMIDDLE_IS_DEAD = TRUE;
                return FALSE;
            }
            else
            {
                return TRUE;
            }

        }
        else
        {
            return FALSE;
        }

    }

    public function checkAllXML($XML_arr_names)
    {
        foreach($XML_arr_names as $key => $value)
        {
            //echo "$key = $value <br />";
            $Is_OK = $this->checkFileXML($value);
            if ($Is_OK == FALSE)
            {
                return FALSE;
            }
        } 
        return TRUE;

    }


}




?>