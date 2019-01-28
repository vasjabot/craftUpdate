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
//$_SERVER["DOCUMENT_ROOT"] = '/home/bitrix/www';
//require("/home/bitrix/www/bitrix/modules/main/include/prolog_before.php");
//include "/home/bitrix/www/bitrix/modules/main/include/prolog_before.php";
//CModule::IncludeModule("main");
//CModule::IncludeModule("iblock");
//use Bitrix\Main\Loader;

//Loader::includeModule("iblock");
//Loader::includeModule("CModule");

//CModule::IncludeModule('main');
//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
$_SERVER["DOCUMENT_ROOT"] = '/home/bitrix/www';
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use Bitrix;
use Bitrix\Main\Loader;
Loader::includeModule("iblock");
//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");


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

    public function __construct($Config)
    {
         $this->config = $Config;      
    }
}

class ProtoGetterSite extends AbstractProtoGetterSite
{

    public function getProtoByName($Name)
    {   
        $OneProtoArray = array();

        $arSelect = Array("ID", "NAME", "ACTIVE", "SORT", "CODE");
        $arFilter = Array("IBLOCK_ID"=>IntVal($this->config->IBLOCK_ID), "DEPTH_LEVEL"=>1);

        //$bs = new CIBlockSection;

        $resSection = \CIBlockSection::GetList(Array(), $arFilter, false, $arSelect);

        $i = 0;
        while($ob = $resSection->GetNextElement())
        {        
            $arFields = $ob->GetFields();
            if($arFields["NAME"] == $Name)
            //if(1)
            {
                $arFields_res = array();
                $arFields_res["ID"] = $arFields["ID"]; 
                $arFields_res["NAME"] = $arFields["NAME"];
                $arFields_res["ACTIVE"] = $arFields["ACTIVE"];
                $arFields_res["SORT"] = $arFields["SORT"];
                $arFields_res["CODE"] = $arFields["CODE"];
                //print_php($arFields_res);
                //print_php($arFields);
                $i++;
                //$allProtoArFields_result_array[] = $arFields;
                $OneProtoArray[] = $arFields_res;
            }
        }
        //print_php($allProtoArFields_result_array);
        //print_php($res);
        //print_php($i);
        return $OneProtoArray;


  

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