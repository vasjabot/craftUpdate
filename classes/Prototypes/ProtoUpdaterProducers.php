<?php 
/**
*-------------------------------------------------------------------------------
* ProtoUpdaterProducers Class
*-------------------------------------------------------------------------------
* This is a class for curl requests execution.
* @package  PrototypesNS 
* @author   mixxxxx 
* @link     top-secret
*/

namespace PrototypesNS;

$_SERVER["DOCUMENT_ROOT"] = '/home/bitrix/www';
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
require_once(__DIR__.'/ProtoGetterSite.php');
use Bitrix;
use Bitrix\Main\Loader;
Loader::includeModule("iblock");


interface ProtoUpdaterProducersInterface
{
    public function updateAllFirstDepthLevelSectionDiffArray();
    public function setNewFirstDepthLevelSection($curProtoName);
    public function updateOldFirstDepthLevelSection($OneProtoArrayFromSite, $curProtoName);
}

abstract class AbstractProtoUpdaterProducers implements ProtoUpdaterProducersInterface
{
    protected $config;
    protected $diff_array_of_names_prototypes;

    public function __construct($Config, $diff_array_of_names_prototypes)
    {
         $this->config = $Config;
         $this->diff_array_of_names_prototypes = $diff_array_of_names_prototypes;
    }
}

class ProtoUpdaterProducers extends AbstractProtoUpdaterProducers
{

    public function updateAllFirstDepthLevelSectionDiffArray()
    {   
        
        $protoGetterSite = new ProtoGetterSite($this->config);
        foreach($this->diff_array_of_names_prototypes as $curProtoName)
        {
            //print_r($curProtoName);         
            $OneProtoArrayFromSite = $protoGetterSite->getProtoFirstDepthLevelByName($curProtoName);

            //print_r("mass from site:");
            //echo nl2br("\r\n");
            //print_r($OneProtoArrayFromSite);
            //echo nl2br("\r\n");
            
            if ($OneProtoArrayFromSite!==NULL)
            {
                //res is TRUE or FALSE
                $res = $this->updateOldFirstDepthLevelSection($OneProtoArrayFromSite, $curProtoName);
            }
            else
            {           
                $res = $this->setNewFirstDepthLevelSection($curProtoName);   
            }
            
            
            //break;
        }
    }

    public function updateOldFirstDepthLevelSection($OneProtoArrayFromSite, $curProtoName)
    {

        $bitrix_code =  $curProtoName;
        $bitrix_code = mb_strtolower($bitrix_code);
        $bitrix_code = str_replace(' ', '_', $bitrix_code);
        $bitrix_code = str_replace('.', '_', $bitrix_code); 

        $protoGetterSite = new ProtoGetterSite($this->config);
        $OneProtoArrayFromSite = $protoGetterSite->getProtoFirstDepthLevelByName($curProtoName);

        //print_r($OneProtoArrayFromSite);
        //echo nl2br("\r\n");

        $bs = new \CIBlockSection;

        $arFields = Array(
          "ACTIVE" => "Y",
          //First DEPTH_LEVEL is empty
          "IBLOCK_SECTION_ID" => "",
          "IBLOCK_ID" => $this->config->IBLOCK_ID,
          "NAME" => $curProtoName,
          "SORT" => 1,
          "CODE" => $bitrix_code
          );

        if($OneProtoArrayFromSite[0]["ID"] > 0)
        {
            //this method return TRUE or FALSE if Error
            $res = $bs->Update($OneProtoArrayFromSite[0]["ID"], $arFields);
            //NEED add this string to Message
            print_r("old FirstDepthLevelSection with Name = " . $curProtoName. " was modifyed with SORT = "  . "500". " CODE = " . $bitrix_code . " ACTIVE = " . "Y");
        }
        else
        {
            $res = FALSE;
        }
        
        return $res;
    }

    public function setNewFirstDepthLevelSection($curProtoName)
    {
        $bitrix_code =  $curProtoName;
        $bitrix_code = mb_strtolower($bitrix_code);
        $bitrix_code = str_replace(' ', '_', $bitrix_code);
        $bitrix_code = str_replace('.', '_', $bitrix_code);
     
        $bs = new \CIBlockSection;

        $arFields = Array(
          "ACTIVE" => "Y",
          //First DEPTH_LEVEL is empty
          "IBLOCK_SECTION_ID" => "",
          "IBLOCK_ID" => $this->config->IBLOCK_ID,
          "NAME" => $curProtoName,
          "SORT" => 500,
          "CODE" => $bitrix_code
          );

       
        $ID = $bs->Add($arFields);
        $res = ($ID>0);
        //NEED add this string to Message
        print_r("new FirstDepthLevelSection " .$curProtoName. " was added with ID = " . $ID);          
        return $res;
    }



}




?>