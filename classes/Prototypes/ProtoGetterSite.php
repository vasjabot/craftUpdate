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
    public function getProtoFirstDepthLevelByName($Name);
    public function getProtoByArticle($Article); 
    public function getProtoByBitrixCode($BitrixCode); 
    public function getArrayAllFirstDepthLevelSection();
    public function getArrayAllSection();
}

abstract class AbstractProtoGetterSite implements ProtoGetterSiteInterface
{
    protected $config;

    public function __construct($Config)
    {
         $this->config = $Config;      
    }
}

class ProtoGetterSite extends AbstractProtoGetterSite
{
    public function getProtoFirstDepthLevelByName($Name)
    {   
        $OneProtoArray = array();

        $arSelect = Array("ID", "NAME", "ACTIVE", "SORT", "CODE");
        $arFilter = Array("IBLOCK_ID"=>IntVal($this->config->IBLOCK_ID), "DEPTH_LEVEL"=>IntVal("1"), "NAME"=>$Name);
        $resSection = \CIBlockSection::GetList(Array(), $arFilter, false, $arSelect);

        $i = 0;
        $WasFound = FALSE;
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


    public function getProtoByArticle($Article)
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



    public function getProtoByBitrixCode($BitrixCode)
    {
        $OneProtoArray = array();
        $arSelect = Array("ID",  "NAME", "UF_ARTICLE", "ACTIVE", "SORT", "CODE", "PICTURE", "UF_DEVTYPE", "UF_PRDDATE", "UF_DESCRIPTION", "UF_BATTERYTYPE", "UF_MODEL", "UF_PRODUCER", "UF_COMPATIBILITYLIST", "IBLOCK_SECTION_ID");
        $arFilter = Array("IBLOCK_ID"=>IntVal($this->config->IBLOCK_ID), "CODE"=>$BitrixCode);
        $resSection = \CIBlockSection::GetList(Array(), $arFilter, false, $arSelect);

        $i = 0;
        $WasFound = FALSE;
        while($ob = $resSection->GetNextElement())
        {
            $arFields = $ob->GetFields();
            if($arFields["CODE"] == $BitrixCode)
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







    public function getArrayAllFirstDepthLevelSection()
    {
        $arSelect = Array("ID", "NAME", "ACTIVE", "SORT", "CODE");
        $arFilter = Array("IBLOCK_ID"=>IntVal($this->config->IBLOCK_ID), "DEPTH_LEVEL"=>1);//razdel prototypes 98 with CRAFTMANN

        $resSection = \CIBlockSection::GetList(Array(), $arFilter, false, $arSelect);
        $i = 0;
        $allProtoArFields_result_array = array();
        while($ob = $resSection->GetNextElement())
        {
             $arFields = $ob->GetFields();
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
             $allProtoArFields_result_array[] = $arFields_res;
        }
        //print_php($allProtoArFields_result_array);
        //print_php($res);
        //print_php($i);
        return $allProtoArFields_result_array;

    }

    public function getArrayAllSection()
    {
        $arSelect = Array("ID", "UF_ARTICLE", "UF_BATTERYTYPE", "UF_DEVTYPE", "NAME", "UF_PRDDATE", "UF_PRODUCER", "IBLOCK_SECTION_ID", "CODE", "SORT");
        $arFilter = Array("IBLOCK_ID"=>IntVal($this->config->IBLOCK_ID));//5031 prototypes

        $resSection = \CIBlockSection::GetList(Array(), $arFilter, false, $arSelect);
        $i = 0;
        $allProtoArFields_result_array = array();
        while($ob = $resSection->GetNextElement())
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
        }
        //print_php($allProtoArFields_result_array);
        //print_php($res);
        //print_php($i);
        return $allProtoArFields_result_array;
    }




}




?>