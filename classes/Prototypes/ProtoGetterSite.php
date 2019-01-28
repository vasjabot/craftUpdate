<?php 
/**
*-------------------------------------------------------------------------------
* ProtoGetterSite Class
*-------------------------------------------------------------------------------
* This is a class for curl requests execution.
* @package  PrototypesNS 
* @author   mixxxxx 
* @link     top-secret
*/

namespace PrototypesNS;


interface ProtoGetterSiteInterface
{
    public function getProtoByName($Name);
    //public function getProtoByArticle($Article);  
}

abstract class AbstractProtoGetterSite implements ProtoGetterSiteInterface
{
    protected $xml_prototypes;
    protected $config;
    protected $CIBlockSection;

    public function __construct($Config, CIBlockSection $CIBlockSection)
    {
         $this->config = $Config;
         $this->CIBlockSection = $CIBlockSection;         
    }
}

class ProtoGetterSite extends AbstractProtoGetterSite
{

    public function getProtoByName($Name)
    {   
        $OneProtoArray = array();

        $arSelect = Array("ID", "NAME", "ACTIVE", "SORT", "CODE");
        $arFilter = Array("IBLOCK_ID"=>IntVal($config->IBLOCK_ID), "DEPTH_LEVEL"=>1);

        //$bs = new CIBlockSection;

        //$resSection = CIBlockSection::GetList(Array(), $arFilter, false, $arSelect);

        return $resSection;


        // if ($this->xml_prototypes->xpath('//dataWs'))
        // {
        //     $index_dataWs = 0;
        //     $WasFound = FALSE;
        //     foreach ($this->xml_prototypes->xpath('//dataWs') as $item_search_prototypes_in_xml)
        //     {
                

        //     }

        //     if($WasFound)
        //     {
        //         return $OneProtoArray;
        //     }
        //     else
        //     {
        //         return NULL;
        //     }

                
        // }
    }

}




?>