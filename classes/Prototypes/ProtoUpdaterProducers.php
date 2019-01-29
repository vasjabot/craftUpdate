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

require_once(__DIR__.'/ProtoGetterSite.php');
require_once(__DIR__.'/../SimpleXML/ProtoGetterXML.php');
use SimpleXMLNS\ProtoGetterXML as ProtoGetterXML;

$_SERVER["DOCUMENT_ROOT"] = '/home/bitrix/www';
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
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
    protected $protoGetterXML;
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
            //print_php($key);
            //print_php($value);
            foreach($value as $key_in => $value_in)
            {
                if ($key_in == "NAME")
                {
                    //print_php($key_in);
                    //print_php($value_in);

                    $protoGetterSite = new ProtoGetterSite($this->config);
                    $DEPTH_LEVEL = 1;
                    $OneProtoArrayFromSite = $protoGetterSite->getProtoFirstDepthLevelByName($value_in, $DEPTH_LEVEL);

                    print_php("mass from site:");
                    print_php($OneProtoArrayFromSite);
                    //print_php("mass from diff:");
                    //print_php($value);
                    $OneProtoArrayFromDiffMass = $value;
                    if ($OneProtoArrayFromSite!==NULL)
                    {
                        //res is TRUE or FALSE
                        $res = $this->updateOldFirstDepthLevelSection($OneProtoArrayFromSite, $OneProtoArrayFromDiffMass);
                    }
                    else
                    {
                        
                        $this->setNewFirstDepthLevelSection($OneProtoArrayFromDiffMass);   
                    }
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
          "ACTIVE" => $diff_arr["ACTIVE"],
          "NAME" => $diff_arr["NAME"],
          "SORT" => $diff_arr["SORT"],
          "CODE" => $diff_arr["CODE"]
          );

        if($diff_arr["ID"] > 0)
        {
            //this method return TRUE or FALSE if Error
            $res = $bs->Update($diff_arr["ID"], $arFields);
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
          "IBLOCK_SECTION_ID" => $IBLOCK_SECTION_ID,
          "IBLOCK_ID" => $this->config->IBLOCK_ID,
          "NAME" => $OneProtoArrayFromDiffMass["NAME"],
          "SORT" => $OneProtoArrayFromDiffMass["SORT"],
          "CODE" => $OneProtoArrayFromDiffMass["CODE"]
          );

       
        $ID = $bs->Add($arFields);
        $res = ($ID>0);
        
        
        return $res;



    }








}




?>