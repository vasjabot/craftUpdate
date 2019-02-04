<?php 
/**
*-------------------------------------------------------------------------------
* BatGetterSite Class
*-------------------------------------------------------------------------------
* This is a class for getting batteries from Site.
* @package  BatteriesNS 
* @author   mixxxxx 
* @link     top-secret
*/

namespace BatteriesNS;

$_SERVER["DOCUMENT_ROOT"] = '/home/bitrix/www';
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use Bitrix;
use Bitrix\Main\Loader;
Loader::includeModule("iblock");



interface BatGetterSiteInterface
{
    public function getBatByArticle($Article); 
    public function getArrayAllBatteries();
}

abstract class AbstractBatGetterSite implements BatGetterSiteInterface
{
    protected $config;

    public function __construct($Config)
    {
         $this->config = $Config;      
    }
}

class BatGetterSite extends AbstractBatGetterSite
{
    

    public function getBatByArticle($Article)
    {
        $OneProtoArray = array();
        $arSelect = Array("ID",  "NAME", "UF_ARTICLE", "ACTIVE", "SORT", "CODE", "PICTURE", "UF_DEVTYPE", "UF_PRDDATE", "UF_DESCRIPTION", "UF_BATTERYTYPE", "UF_MODEL", "UF_PRODUCER", "UF_COMPATIBILITYLIST", "IBLOCK_SECTION_ID");
        $arFilter = Array("IBLOCK_ID"=>IntVal($this->config->IBLOCK_ID), "UF_ARTICLE"=>$Article);
        $resSection = \CIBlockSection::GetList(Array(), $arFilter, false, $arSelect);

        $i = 0;
        $WasFound = FALSE;
        while($ob = $resSection->GetNextElement())
        {
            $arFields = $ob->GetFields();
            if($arFields["UF_ARTICLE"] == $Article)
            {
                $arFields = $ob->GetFields();
                $arFields_res = array();
                $arFields_res["ID"] = $arFields["ID"]; 
                $arFields_res["NAME"] = $arFields["NAME"];
                $arFields_res["UF_ARTICLE"] = $arFields["UF_ARTICLE"];
                $arFields_res["ACTIVE"] = $arFields["ACTIVE"];
                $arFields_res["SORT"] = $arFields["SORT"];
                $arFields_res["CODE"] = $arFields["CODE"];
                $arFields_res["PICTURE"] = $arFields["PICTURE"];
                $arFields_res["UF_DEVTYPE"] = $arFields["UF_DEVTYPE"];
                $arFields_res["UF_PRDDATE"] = $arFields["UF_PRDDATE"];
                $arFields_res["UF_DESCRIPTION"] = $arFields["UF_DESCRIPTION"];
                $arFields_res["UF_BATTERYTYPE"] = $arFields["UF_BATTERYTYPE"];
                $arFields_res["UF_MODEL"] = $arFields["UF_MODEL"];
                $arFields_res["UF_PRODUCER"] = $arFields["UF_PRODUCER"];
                $arFields_res["UF_COMPATIBILITYLIST"] = $arFields["UF_COMPATIBILITYLIST"];
                $arFields_res["IBLOCK_SECTION_ID"] = $arFields["IBLOCK_SECTION_ID"];
                $i++;
                $OneProtoArray[] = $arFields_res;
                $WasFound = TRUE;
            }

        }
        if($WasFound)
        {
            return $OneProtoArray;
        }
        else
        {
            return NULL;
        }

    }



    







    public function getArrayAllBatteries()
    {
        //$arSelect = Array("ID", "UF_ARTICLE", "UF_BATTERYTYPE", "UF_DEVTYPE", "NAME", "UF_PRDDATE", "UF_PRODUCER", "IBLOCK_SECTION_ID", "CODE", "SORT");
        $arFilter = Array("IBLOCK_ID"=>IntVal($this->config->IBLOCK_ID));//5031 prototypes

        //$arSelect = Array("ID", "UF_ARTICLE", "NAME", "UF_BATTERYTYPE", "UF_DEVTYPE", "UF_PRDDATE", "UF_PRODUCER", "IBLOCK_SECTION_ID", "CODE", "SORT");
        $arSelect = Array();
    //     "ID",
    //     "NAME",
    //     "CODE",
    //     "DATE_CREATE",
    //     "ACTIVE_FROM",
    //     "CREATED_BY",
    //     "IBLOCK_ID",
    //     "IBLOCK_SECTION_ID",
    //     "DETAIL_PAGE_URL",
    //     "DETAIL_TEXT",
    //     "DETAIL_TEXT_TYPE",
    //     "DETAIL_PICTURE",
    //     "PREVIEW_TEXT",
    //     "PREVIEW_TEXT_TYPE",
    //     "PREVIEW_PICTURE",
    //     "PROPERTY_*",
    // );

        $arFilter = Array("IBLOCK_ID"=>IntVal($this->config->IBLOCK_ID));//all batteries

        // $arFilter = array(
        //     "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        //     "IBLOCK_LID" => SITE_ID,
        //     "IBLOCK_ACTIVE" => "Y",
        //     "ACTIVE_DATE" => "Y",
        //     "ACTIVE" => "Y",
        //     "CHECK_PERMISSIONS" => "Y",
        //     "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
        // );




        $rsElements = \CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);


        //$resSection = \CIBlockSection::GetList(Array(), $arFilter, false, $arSelect);
        
        $allBatteriesArFields_result_array = array();
        while($ob = $rsElements->GetNextElement())
        {
             $arFields = $ob->GetFields();
             $arFields_res = array();
             $arFields_res["ID"] = $arFields["ID"]; 
             $arFields_res["UF_ARTICLE"] = $arFields["UF_ARTICLE"];
             $arFields_res["UF_BATTERYTYPE"] = $arFields["UF_BATTERYTYPE"];
             $arFields_res["UF_DEVTYPE"] = $arFields["UF_DEVTYPE"];
             $arFields_res["NAME"] = $arFields["NAME"];
             $arFields_res["UF_PRDDATE"] = $arFields["UF_PRDDATE"];
             $arFields_res["UF_PRODUCER"] = $arFields["UF_PRODUCER"];
             $arFields_res["IBLOCK_SECTION_ID"] = $arFields["IBLOCK_SECTION_ID"];
             $arFields_res["CODE"] = $arFields["CODE"];
             $arFields_res["SORT"] = $arFields["SORT"];
             //print_php($arFields_res);
             //print_php($arFields);
             $i++;
             $allProtoArFields_result_array[] = $arFields_res;
             $allProtoArFields_result_array[] = $arFields;
        }
        //print_php($allProtoArFields_result_array);
        //print_php($res);
        //print_php($i);
        return $allProtoArFields_result_array;
    }




}




?>