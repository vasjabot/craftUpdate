<?php 
/**
*-------------------------------------------------------------------------------
* ProtoUpdater Class
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
require_once(__DIR__.'/../SimpleXML/ProtoGetterXML.php');
use SimpleXMLNS\ProtoGetterXML as ProtoGetterXML;
use Bitrix;
use Bitrix\Main\Loader;
Loader::includeModule("iblock");

$_SERVER["DOCUMENT_ROOT"] = '/home/bitrix/www';
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use Bitrix;
use Bitrix\Main\Loader;
Loader::includeModule("iblock");


interface ProtoUpdaterInterface
{
    public function updateAllPrototypesByArticlesDiff();
    public function updateOldPrototype($OneProtoArrayFromSite, $curProtoArticle);
    public function setNewPrototype($curProtoArticle);    
}

abstract class AbstractProtoUpdater implements ProtoUpdaterInterface
{
    protected $config;
    protected $diff_array_prototypes;
    protected $xml_prototypes;

    public function __construct($Config, $allPrototypesByArticlesDiff, $xml_prototypes)
    {
         $this->config = $Config;
         $this->diff_array_of_articles = $allPrototypesByArticlesDiff;
         $this->xml_prototypes = $xml_prototypes;
    }
}

class ProtoUpdater extends AbstractProtoUpdater
{

    public function updateAllPrototypesByArticlesDiff()
    {   
        $protoGetterSite = new ProtoGetterSite($this->config);        
        foreach($this->diff_array_of_names_prototypes as $curProtoArticle)
        {        
            $OneProtoArrayFromSite = $protoGetterSite->getProtoByArticle($curProtoArticle);
            // print_r("OneProtoArrayFromSite is: ");
            // echo nl2br("\r\n");
            // print_r($OneProtoArrayFromSite);
            // echo nl2br("\r\n");
            // foreach($OneProtoArrayFromSite[0] as $key => $value)
            // {
            //     print_r("$key: " . $value);
            //     echo nl2br("\r\n");
            // }
            if ($OneProtoArrayFromSite!==NULL)
            {
                //res is TRUE or FALSE
                $res = $this->updateOldPrototype($OneProtoArrayFromSite, $curProtoArticle);
            }
            else
            {           
                $res = $this->setNewFirstDepthLevelSection($curProtoArticle);   
            }
            
        }
    }

    public function updateOldPrototype($OneProtoArrayFromSite, $curProtoArticle)
    {

        $protoGetterSite = new ProtoGetterSite($this->config);
        $OneProtoArrayFromSite = $protoGetterSite->getProtoByArticle($curProtoArticle);

        $protoGetterXML = new ProtoGetterXML($this->config, $this->xml_prototypes);
        $OneProtoArrayFromXML= $protoGetterXML->getProtoByArticle($curProtoArticle);

        $bitrix_code =  $OneProtoArrayFromXML["UF_MODEL"];
        $bitrix_code = mb_strtolower($bitrix_code);
        $bitrix_code = str_replace(' ', '_', $bitrix_code);
        $bitrix_code = str_replace('.', '_', $bitrix_code); 

        if (empty($OneProtoArrayFromXML["UF_COMPATIBILITYLIST"])) 
        {
            $ACTIVE = "N";
        }else
        {
            $ACTIVE = "Y";
        }


        $bs = new \CIBlockSection;

        $arFields = Array(
          "ACTIVE" => $ACTIVE,
          //Site
          "IBLOCK_SECTION_ID" => $OneProtoArrayFromSite[0]["IBLOCK_SECTION_ID"],
          "IBLOCK_ID" => $this->config->IBLOCK_ID,
          //XML
          "NAME" => $OneProtoArrayFromXML["NAME"],
          "UF_DESCRIPTION" => "",
          "SORT" => 500,
          "CODE" => $bitrix_code,
          //Site In this field store id of PICTURE
          "PICTURE" => $OneProtoArrayFromSite["PICTURE"],
          //not XML, let't get it from Site
          "UF_ARTICLE" => $OneProtoArrayFromSite["UF_ARTICLE"],
          //XML
          "UF_DEVTYPE" => $OneProtoArrayFromXML["UF_DEVTYPE"],
          //XML
          "UF_PRDDATE" => $OneProtoArrayFromXML["UF_PRDDATE"],
          //XML
          "UF_BATTERYTYPE" => $OneProtoArrayFromXML["UF_BATTERYTYPE"],
          //XML
          "UF_MODEL" => 'Аккумулятор для '.$OneProtoArrayFromXML["UF_MODEL"].'',
          //XML
          "UF_PRODUCER" => $OneProtoArrayFromXML["UF_PRODUCER"],
          //XML
          "UF_COMPATIBILITYLIST" => $OneProtoArrayFromXML["UF_PRODUCER"]
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

    public function setNewPrototype($curProtoArticle)
    {
       
    }



}




?>