<?php 
/**
*-------------------------------------------------------------------------------
* CompatibilityGetterXML Class
*-------------------------------------------------------------------------------
* This is a class for curl requests execution.
* @package  PrototypesNS 
* @author   mixxxxx 
* @link     top-secret
*/

namespace SimpleXMLNS;


interface CompatibilityGetterXMLInterface
{
    public function getCompatibilityByArticle($Article);
}

abstract class AbstractCompatibilityGetterXML implements CompatibilityGetterXMLInterface
{
    protected $xml_compatibility;
    protected $config;

    public function __construct($Config, $xml_compatibility)
    {
         $this->config = $Config;
         $this->xml_compatibility = $xml_compatibility;        
    }
}

class CompatibilityGetterXML extends AbstractCompatibilityGetterXML
{

    public function getCompatibilityByArticle($Article)
    {   
        $compatibilityListString = '';

        if ($this->xml_compatibility->xpath('//dataWs'))
        {
            $index_dataWs = 0;
            $WasFound = FALSE;
            foreach ($this->xml_compatibility->xpath('//dataWs') as $item_comp_dataWs)
            {
                $item_comp_dataWs_article = $item_comp_dataWs->article;
                $item_comp_dataWs_article = (array)$item_comp_dataWs_article;

                if ($Article == $item_comp_dataWs_article[0])
                {
                    $item_comp_dataWs_compatibilityList = $item_comp_dataWs->compatibilityList;
                    $item_comp_dataWs_compatibilityList = (array)$item_comp_dataWs_compatibilityList;

                    foreach ($item_comp_dataWs->xpath('.//compatibilityList') as $compatibilityList_elems)
                    {
                        $compatibilityList_elems = (array)$compatibilityList_elems;

                        $compatibilityListString = $compatibilityListString . $compatibilityList_elems[0] . ' ';

                    }
                    $WasFound = TRUE;
                    break;
                }               
            }

            if($WasFound)
            {
                return $compatibilityListString;
            }
            else
            {
                return NULL;
            }

                
        }
    }

}




?>