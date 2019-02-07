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
    public function getArrayAllBatteries($Article_for_filter=NULL);
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
        return $this->getArrayAllBatteries($Article);
    }




    public function getArrayAllBatteries($Article_for_filter = NULL)
    {
        if($Article_for_filter == NULL)
        {
            $arFilter = Array("IBLOCK_ID"=>IntVal($this->config->IBLOCK_ID));//all batteries
        }
        else
        {
            // print_r("Article_for_filter is not NULL: " . $Article_for_filter);
            // echo nl2br("\r\n");

            $arFilter = Array("IBLOCK_ID"=>IntVal($this->config->IBLOCK_ID), "PROPERTY_ARTICLE"=>$Article_for_filter);//one battery
        }
        
        $arSelect = Array("ID", "IBLOCK_SECTION_ID", "NAME", "ACTIVE", "SORT", "DETAIL_PICTURE", "DETAIL_TEXT", "SEARCHABLE_CONTENT", "IN_SECTIONS", "CODE", "SORT", "ARTICLE");

        $rsElements = \CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    
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
            $arFields_res["DETAIL_TEXT"] = $arFields["DETAIL_TEXT"];
            $arFields_res["IN_SECTIONS"] = $arFields["IN_SECTIONS"];
            $arFields_res["CODE"] = $arFields["CODE"];

            $element_props = \CIBlockElement::GetProperty($this->config->IBLOCK_ID, $arFields["ID"], "sort", "asc", array());
            $PROPS = array();
            while ($ar_props = $element_props->Fetch())
            {
                $PROPS[$ar_props['CODE']] = $ar_props['VALUE'];
            }

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

            $element_groups = \CIBlockElement::GetElementGroups($arFields["ID"], true);
            $GROUPS = array();
            $GROUPS_ID = array();
            $GROUPS_ARTICLE = array();
            while($ar_group = $element_groups->Fetch()) 
            {             
                $GROUPS[] = $ar_group["NAME"];
                $GROUPS_ID[] = $ar_group["ID"];
                // print($ar_group["ID"]);
                // echo nl2br("\r\n");                        
            }

            foreach($GROUPS_ID as $group_id)
            {
                $OneProtoArray = array();
                $arSelect = Array("UF_ARTICLE",  "NAME");
                $arFilter = Array("IBLOCK_ID"=>IntVal($this->config->IBLOCK_ID), "ID"=>$group_id);
                $resSection = \CIBlockSection::GetList(Array(), $arFilter, false, $arSelect);
   
                while($proto_element = $resSection->GetNextElement())
                {
                    $proto_element_arFields = $proto_element->GetFields();
                    $GROUPS_ARTICLE[] = $proto_element_arFields["UF_ARTICLE"];
                    // print_r($proto_element_arFields["UF_ARTICLE"]);
                    // echo nl2br("\r\n");
                    //print_r($proto_element_arFields);
                    //echo nl2br("\r\n");
                }
            }
            
            $arFields_res["GROUPS_ARRAY"] = $GROUPS;
            $arFields_res["GROUPS_ID_ARRAY"] = $GROUPS_ID;
            $arFields_res["GROUPS_ARTICLE"] = $GROUPS_ARTICLE;
    
            $allProtoArFields_result_array[] = $arFields_res;
            
        }
        return $allProtoArFields_result_array;
    }


   

}




?>