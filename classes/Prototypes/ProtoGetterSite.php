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
$_SERVER["DOCUMENT_ROOT"] = '/home/bitrix/www';
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use Bitrix;
use Bitrix\Main\Loader;
Loader::includeModule("iblock");



interface ProtoGetterSiteInterface
{
    public function getProtoByName($Name, $DEPTH_LEVEL);
    //public function getProtoByArticle($Article);  
}

abstract class AbstractProtoGetterSite implements ProtoGetterSiteInterface
{
    protected $xml_prototypes;
    protected $config;
    protected $CIBlockSection;

    public function __construct($Config)
    {
         $this->config = $Config;      
    }
}

class ProtoGetterSite extends AbstractProtoGetterSite
{
    public function getProtoByName($Name, $DEPTH_LEVEL)
    {   
        $OneProtoArray = array();

        $arSelect = Array("ID", "NAME", "ACTIVE", "SORT", "CODE");
        $arFilter = Array("IBLOCK_ID"=>IntVal($this->config->IBLOCK_ID), "DEPTH_LEVEL"=>IntVal($DEPTH_LEVEL));
        $resSection = \CIBlockSection::GetList(Array(), $arFilter, false, $arSelect);

        $i = 0;
        while($ob = $resSection->GetNextElement())
        {        
            $arFields = $ob->GetFields();
            if($arFields["NAME"] == $Name)
            {
                $arFields_res = array();
                $arFields_res["ID"] = $arFields["ID"]; 
                $arFields_res["NAME"] = $arFields["NAME"];
                $arFields_res["ACTIVE"] = $arFields["ACTIVE"];
                $arFields_res["SORT"] = $arFields["SORT"];
                $arFields_res["CODE"] = $arFields["CODE"];
                $i++;
                $OneProtoArray[] = $arFields_res;
            }
        }

        return $OneProtoArray;
    }

}




?>