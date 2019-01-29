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
    public function setNewFirstDepthLevelSection($OneProtoArrayFromDiffMass);
    public function updateOldFirstDepthLevelSection($OneProtoArrayFromSite, $OneProtoArrayFromDiffMass);
}

abstract class AbstractProtoUpdaterProducers implements ProtoUpdaterProducersInterface
{
    protected $config;
    protected $diff_array_prototypes;

    public function __construct($Config, $diff_array_prototypes)
    {
         $this->config = $Config;
         $this->diff_array_prototypes = $diff_array_prototypes;
    }
}

class ProtoUpdaterProducers extends AbstractProtoUpdaterProducers
{

    public function updateAllFirstDepthLevelSectionDiffArray()
    {   
        
        foreach($this->diff_array_prototypes as $key => $value)
        {
            print_r($key);
            print_r($value);
           
            if ($key == "NAME")
            {
                print_r($key);
                echo nl2br("\r\n");
                print_r($value);
                echo nl2br("\r\n");

                $protoGetterSite = new ProtoGetterSite($this->config);
                $OneProtoArrayFromSite = $protoGetterSite->getProtoFirstDepthLevelByName($value);

                print_r("mass from site:");
                echo nl2br("\r\n");
                print_r($OneProtoArrayFromSite);
                echo nl2br("\r\n");
                //print_php("mass from diff:");
                //print_php($value);
                
                if ($OneProtoArrayFromSite!==NULL)
                {
                    //res is TRUE or FALSE
                    $res = $this->updateOldFirstDepthLevelSection($OneProtoArrayFromSite, $this->diff_array_prototypes);
                }
                else
                {           
                    $res = $this->setNewFirstDepthLevelSection($this->diff_array_prototypes);   
                }
            }
            
            //break;
        }
    }

    public function updateOldFirstDepthLevelSection($OneProtoArrayFromSite, $OneProtoArrayFromDiffMass)
    {
        //$OneProtoArrayFromDiffMass mast be first arg in this func array_diff(arr1, arr2)
        $diff_arr= array_diff ($OneProtoArrayFromDiffMass, $OneProtoArrayFromSite);
        foreach($diff_arr as $key => $value)
        {
            //Need add this string to Message!!!
            print_r("In FirstDepthLevelSection " . $OneProtoArrayFromSite["NAME"] . " was changed property: " . $key . " from " . $OneProtoArrayFromSite[$key] ." to " . $value);

        }

        $bs = new \CIBlockSection;

        $arFields = Array(
          "ACTIVE" => "Y",
          "IBLOCK_SECTION_ID" => "",
          "IBLOCK_ID" => $this->config->IBLOCK_ID,
          "NAME" => $diff_arr["NAME"],
          "SORT" => $diff_arr["SORT"],
          "CODE" => $diff_arr["CODE"]
          );

        if($diff_arr["ID"] > 0)
        {
            //this method return TRUE or FALSE if Error
            $res = $bs->Update($diff_arr["ID"], $arFields);
            //NEED add this string to Message
            print_r("old FirstDepthLevelSection with ID = " . $diff_arr["ID"]. " was modifyed with NAME = " . $diff_arr["NAME"]  . " SORT = " . $diff_arr["SORT"] . " CODE = " . $diff_arr["CODE"] . " ACTIVE = " . "Y");
        }
        else
        {
            $res = FALSE;
        }
        
        return $res;
    }

    public function setNewFirstDepthLevelSection($OneProtoArrayFromDiffMass)
    {
        foreach($OneProtoArrayFromDiffMass as $key => $value)
        {
            //Need add this string to Message!!!
            print_r("FirstDepthLevelSection " . $OneProtoArrayFromDiffMass["NAME"] . " was added  with property: " . $key  . " with value " . $value);

        }

        $bs = new \CIBlockSection;

        $arFields = Array(
          "ACTIVE" => "Y",
          //First DEPTH_LEVEL is empty
          "IBLOCK_SECTION_ID" => "",
          "IBLOCK_ID" => $this->config->IBLOCK_ID,
          "NAME" => $OneProtoArrayFromDiffMass["NAME"],
          "SORT" => 500,
          "CODE" => $OneProtoArrayFromDiffMass["CODE"]
          );

       
        $ID = $bs->Add($arFields);
        $res = ($ID>0);
        //NEED add this string to Message
        print_r("new FirstDepthLevelSection " .$OneProtoArrayFromDiffMass["NAME"]. " was added with ID = " . $ID);          
        return $res;
    }



}




?>