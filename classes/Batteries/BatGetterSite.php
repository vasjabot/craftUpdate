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

        $arSelect = Array("ID", "IBLOCK_SECTION_ID", "NAME", "ACTIVE", "SORT", "DETAIL_PICTURE", "SEARCHABLE_CONTENT", "IN_SECTIONS", "CODE", "SORT", "ARTICLE");
        //$arSelect = Array();
 

        $arFilter = Array("IBLOCK_ID"=>IntVal($this->config->IBLOCK_ID));//all batteries

 

        $rsElements = \CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);


        //$resSection = \CIBlockSection::GetList(Array(), $arFilter, false, $arSelect);
        
        $allBatteriesArFields_result_array = array();
        while($arElement = $rsElements->GetNextElement())
        {
            $arFields = $arElement->GetFields();
            $arFields_res = array();
            $arFields_res["ID"] = $arFields["ID"];
            $arFields_res["IBLOCK_SECTION_ID"] = $arFields["IBLOCK_SECTION_ID"];
            $arFields_res["NAME"] = $arFields["NAME"]; 
            $arFields_res["ACTIVE"] = $arFields["ACTIVE"];
            $arFields_res["SORT"] = $arFields["SORT"];
             
            $arFields_res["DETAIL_PICTURE"] = $arFields["DETAIL_PICTURE"];
            $arFields_res["SEARCHABLE_CONTENT"] = $arFields["SEARCHABLE_CONTENT"];
            $arFields_res["IN_SECTIONS"] = $arFields["IN_SECTIONS"];
            $arFields_res["CODE"] = $arFields["CODE"];

            $element_props = \CIBlockElement::GetProperty($this->config->IBLOCK_ID, $arFields["ID"], "sort", "asc", array());
            $PROPS = array();
            while ($ar_props = $element_props->Fetch())
            {
                $PROPS[$ar_props['CODE']] = $ar_props['VALUE'];
                //print_r($PROPS);
                //echo nl2br("\r\n");
                // if ($ar_props['CODE'] == 'PICTURES')
                // {
                //     //print_r("PICTURES");
                //     //echo nl2br("\r\n");
                // }
            }

            //$arFields_res["PROPS"] = $PROPS;
            $arFields_res["ARTICLE"] = $PROPS["ARTICLE"];
            $arFields_res["ORIGINAL_CODE"] = $PROPS["ORIGINAL_CODE"];
            $arFields_res["COMPATIBLE_MODEL"] = $PROPS["COMPATIBLE_MODEL"];
            $arFields_res["COMPLECT"] = $PROPS["COMPLECT"];
            $arFields_res["CURRENT"] = $PROPS["CURRENT"];
            $arFields_res["COLOR"] = $PROPS["COLOR"];
            $arFields_res["WEIGHT"] = $PROPS["WEIGHT"];
            $arFields_res["CERTIFICATION"] = $PROPS["CERTIFICATION"];
            $arFields_res["WARRANTY"] = $PROPS["WARRANTY"];
            $arFields_res["TYPE"] = $PROPS["TYPE"];
            $arFields_res["VOLTAGE"] = $PROPS["VOLTAGE"];
            $arFields_res["POWER"] = $PROPS["POWER"];
            $arFields_res["CAPACITY"] = $PROPS["CAPACITY"];
            $arFields_res["SERIES"] = $PROPS["SERIES"];
            $arFields_res["EAN_13"] = $PROPS["EAN_13"];
            $arFields_res["DISCONTINUED"] = $PROPS["DISCONTINUED"];
            $arFields_res["PICTURES"] = $PROPS["PICTURES"];
            $arFields_res["PREVIEW_PICTURES_1"] = $PROPS["PREVIEW_PICTURES_1"];
            $arFields_res["PREVIEW_PICTURES_2"] = $PROPS["PREVIEW_PICTURES_2"];
            $arFields_res["PRICE"] = $PROPS["PRICE"];
            $arFields_res["STATUS"] = $PROPS["STATUS"];
            $arFields_res["STORE"] = $PROPS["STORE"];
            $arFields_res["COLOR_UNIVERSAL"] = $PROPS["COLOR_UNIVERSAL"];
            $arFields_res["CAPACITY_COEFF"] = $PROPS["CAPACITY_COEFF"];
            $arFields_res["SIZE"] = $PROPS["SIZE"];
            $arFields_res["MATERIAL"] = $PROPS["MATERIAL"];
            $arFields_res["UNI_TOP_BLOCK"] = $PROPS["UNI_TOP_BLOCK"];
            $arFields_res["UNI_BOTTOM_BLOCK"] = $PROPS["UNI_BOTTOM_BLOCK"];
    
            $i++;
            $allProtoArFields_result_array[] = $arFields_res;
            //$allProtoArFields_result_array[] = $arFields;
        }
        //print_php($allProtoArFields_result_array);
        //print_php($res);
        //print_php($i);
        return $allProtoArFields_result_array;
    }




}




?>