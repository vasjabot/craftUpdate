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
require_once(__DIR__.'/../SimpleXML/CompatibilityGetterXML.php');
use SimpleXMLNS\CompatibilityGetterXML as CompatibilityGetterXML;
use Bitrix;
use Bitrix\Main\Loader;
Loader::includeModule("iblock");




interface ProtoUpdaterInterface
{
    public function updateAllPrototypesByArticlesDiff();
    public function updateOldPrototype($OneProtoArrayFromSite, $curProtoArticle, $curProtoSort);
    public function updateOldPrototypeFastForUpdatingSort($OneProtoArrayFromSite, $curProtoSort);
    public function setNewPrototype($curProtoArticle);    
}

abstract class AbstractProtoUpdater implements ProtoUpdaterInterface
{
    protected $config;
    protected $diff_array_of_articles;
    protected $xml_prototypes;
    protected $xml_compatibility;

    public function __construct($Config, $allPrototypesByArticlesDiff, $xml_prototypes, $xml_compatibility)
    {
         $this->config = $Config;
         $this->diff_array_of_articles = $allPrototypesByArticlesDiff;
         $this->xml_prototypes = $xml_prototypes;
         $this->xml_compatibility = $xml_compatibility;
    }
}

class ProtoUpdater extends AbstractProtoUpdater
{

    public function updateAllPrototypesByArticlesDiff()
    {   
        $protoGetterSite = new ProtoGetterSite($this->config);        
        foreach($this->diff_array_of_articles as $curProtoArticle)
        {  
            if (($curProtoArticle !== NULL) || $curProtoArticle !== '')
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
                  //print_r("setNewPrototype");
                  //echo nl2br("\r\n");         
                  $res = $this->setNewPrototype($curProtoArticle);   
              }
            }
        }
    }

    public function updateOldPrototype($OneProtoArrayFromSite, $curProtoArticle, $curProtoSort=1)
    {

        $protoGetterXML = new ProtoGetterXML($this->config, $this->xml_prototypes);
        $OneProtoArrayFromXML= $protoGetterXML->getProtoByArticle($curProtoArticle);

        $bitrix_code =  $OneProtoArrayFromXML["UF_MODEL"];
        $bitrix_code = mb_strtolower($bitrix_code);
        $bitrix_code = str_replace(' ', '_', $bitrix_code);
        $bitrix_code = str_replace('.', '_', $bitrix_code); 

        $model = 'Аккумулятор для '.$OneProtoArrayFromXML["UF_MODEL"].'';
        $model_win1251 = iconv("utf-8", "windows-1251", $model);



        $compatibilityGetterXML = new CompatibilityGetterXML($this->config, $this->xml_compatibility);
        $CompatibilityStringFromXML = $compatibilityGetterXML->getCompatibilityByArticle($curProtoArticle);

        if (empty($CompatibilityStringFromXML) || ($CompatibilityStringFromXML==NULL)) 
        {
            $ACTIVE = "N";
            //print_r("CompatibilityStringFromXML is empty" . $CompatibilityStringFromXML);
            //echo nl2br("\r\n");
            
        }else
        {
            $ACTIVE = "Y";
            //print_r("CompatibilityStringFromXML is NOT empty" . $CompatibilityStringFromXML);
            //echo nl2br("\r\n");            
        }

        $bs = new \CIBlockSection;

        $arFields = Array(
          //not XML, let't get it from Site
          "UF_ARTICLE" => $OneProtoArrayFromSite[0]["UF_ARTICLE"],
          //Define in this method 
          "ACTIVE" => $ACTIVE,
          //Site
          "IBLOCK_SECTION_ID" => $OneProtoArrayFromSite[0]["IBLOCK_SECTION_ID"],
          //Config
          "IBLOCK_ID" => $this->config->IBLOCK_ID,
          //XML
          "NAME" => $OneProtoArrayFromXML["NAME"],
          //Just temp phrase
          "UF_DESCRIPTION" => "test description",
          //Defaul 500
          "SORT" => IntVal($curProtoSort),
          //Define in this method
          "CODE" => $bitrix_code,
          //Site In this field store id of PICTURE
          "PICTURE" => $OneProtoArrayFromSite[0]["PICTURE"],
          //XML
          "UF_DEVTYPE" => $OneProtoArrayFromXML["UF_DEVTYPE"],
          //XML
          "UF_PRDDATE" => $OneProtoArrayFromXML["UF_PRDDATE"],
          //XML
          "UF_BATTERYTYPE" => $OneProtoArrayFromXML["UF_BATTERYTYPE"],
          //Define in this method         
          "UF_MODEL" => $model_win1251,     
          //XML
          "UF_PRODUCER" => $OneProtoArrayFromXML["UF_PRODUCER"],
          //XML
          "UF_COMPATIBILITYLIST" => $CompatibilityStringFromXML
          );

        if($OneProtoArrayFromSite[0]["ID"] > 0)
        {
            //this method return TRUE or FALSE if Error
            $res = $bs->Update($OneProtoArrayFromSite[0]["ID"], $arFields);
            //NEED add this string to Message
            // print_r("old ProtoSection with Name = " . $OneProtoArrayFromXML["NAME"] . " was modifyed with arFields = "  .  $arFields);
            // foreach($arFields as $arFieldsItem)
            // {
            //     print_r($arFieldsItem);
            //     echo nl2br("\r\n");

            // }
        }
        else
        {
            $res = FALSE;
        }
        
        return $res;

        
    }


    public function updateOldPrototypeFastForUpdatingSort($OneProtoArrayFromSite, $curProtoSort=1)
    {
        $bs = new \CIBlockSection;
        $arFields = Array(
          "SORT" => IntVal($curProtoSort)
          );

        if($OneProtoArrayFromSite[0]["ID"] > 0)
        {
            //this method return TRUE or FALSE if Error
            $res = $bs->Update($OneProtoArrayFromSite[0]["ID"], $arFields);
        }
        else
        {
            $res = FALSE;
        }
        
        return $res;       
    }


    public function setNewPrototype($curProtoArticle)
    {
        $protoGetterXML = new ProtoGetterXML($this->config, $this->xml_prototypes);
        $OneProtoArrayFromXML= $protoGetterXML->getProtoByArticle($curProtoArticle);


        $bitrix_code =  $OneProtoArrayFromXML["UF_MODEL"];
        $bitrix_code = mb_strtolower($bitrix_code);
        $bitrix_code = str_replace(' ', '_', $bitrix_code);
        $bitrix_code = str_replace('.', '_', $bitrix_code); 

        $model = 'Аккумулятор для '.$OneProtoArrayFromXML["UF_MODEL"].'';
        $model_win1251 = iconv("utf-8", "windows-1251", $model);


        $compatibilityGetterXML = new CompatibilityGetterXML($this->config, $this->xml_compatibility);
        $CompatibilityStringFromXML = $compatibilityGetterXML->getCompatibilityByArticle($curProtoArticle);


        if (empty($CompatibilityStringFromXML) || ($CompatibilityStringFromXML==NULL)) 
        {
            $ACTIVE = "N";
            //print_r("CompatibilityStringFromXML is empty" . $CompatibilityStringFromXML);
            //echo nl2br("\r\n");
            
        }else
        {
            $ACTIVE = "Y";
            //print_r("CompatibilityStringFromXML is NOT empty" . $CompatibilityStringFromXML);
            //echo nl2br("\r\n");            
        }


        $IBLOCK_SECTION_ID = NULL;
        $protoGetterSite = new ProtoGetterSite($this->config);
        //In this case NAME in FirstDepthLevel == UF_PRODUCER from OneProtoArrayFromXML
        $OneProtoArrayFirstDepthLevel = $protoGetterSite->getProtoFirstDepthLevelByName($OneProtoArrayFromXML["UF_PRODUCER"]);

        if ($OneProtoArrayFirstDepthLevel[0]["ID"] > 0 )
        {
 
            $IBLOCK_SECTION_ID = $OneProtoArrayFirstDepthLevel[0]["ID"];
        }
        else
        {
            //There are not existed FirstDepthLevelProto, which equal with OneProtoArrayFromXML["UF_PRODUCER"]
            //In this case we just go away this func and return NULL
            //print_r("In this case we just go away from this func and return NULL" . $IBLOCK_SECTION_ID);
            //echo nl2br("\r\n");
            $IBLOCK_SECTION_ID = NULL;
            return NULL;
        }

     
        $bs = new \CIBlockSection;

        $arFields = Array(
          //XML
          "UF_ARTICLE" => $OneProtoArrayFromXML["UF_ARTICLE"],
          //Define in this method 
          "ACTIVE" => $ACTIVE,
          //In this place we set OneProtoArrayFirstDepthLevel[0]["ID"]
          "IBLOCK_SECTION_ID" => $OneProtoArrayFirstDepthLevel[0]["ID"],////////!!!!!!!!!!!!!
          //Config
          "IBLOCK_ID" => $this->config->IBLOCK_ID,
          //XML
          "NAME" => $OneProtoArrayFromXML["NAME"],
          //Just temp phrase
          "UF_DESCRIPTION" => "test description",
          //Defaul 500
          "SORT" => 500,
          //Define in this method
          "CODE" => $bitrix_code,
          //EMPTY FIELD when new
          "PICTURE" => "",
          //XML
          "UF_DEVTYPE" => $OneProtoArrayFromXML["UF_DEVTYPE"],
          //XML
          "UF_PRDDATE" => $OneProtoArrayFromXML["UF_PRDDATE"],
          //XML
          "UF_BATTERYTYPE" => $OneProtoArrayFromXML["UF_BATTERYTYPE"],
          //Define in this method         
          "UF_MODEL" => $model_win1251,     
          //XML
          "UF_PRODUCER" => $OneProtoArrayFromXML["UF_PRODUCER"],
          //XML
          "UF_COMPATIBILITYLIST" => $CompatibilityStringFromXML
          );

       
        $ID = $bs->Add($arFields);
        $res = ($ID>0);
        if($res)
        {
            //NEED add this string to Message
            print_r("new ProtoSection " .$OneProtoArrayFromXML["NAME"]. " was added with ID = " . $ID);  
            //return TRUE or FALSE  

        }
              
        return $res;



       
    }




     public function updateAllSectionSorting()
     {

        $protoGetterSite = new ProtoGetterSite($this->config);    
        $allSection = $protoGetterSite->getArrayAllSection();


        $allSectionArticles = array();
        foreach ($allSection as $Item)
        {
          foreach ($Item as $key => $value)
          {
            if($key == "UF_ARTICLE")
            {
              $allSectionArticles[] = $value;
            }

          }
          
        }

  
        foreach ($allSectionArticles as $Item)
        { 
          if ($Item !== '')
          {
              $OneProtoArrayFromSite = $protoGetterSite->getProtoByArticle($Item);
              if (($OneProtoArrayFromSite[0]["SORT"] == 500) || ($OneProtoArrayFromSite[0]["SORT"] == 550))
              {
                $this->updateOldPrototypeFastForUpdatingSort($OneProtoArrayFromSite, 1);
              }
          }

        }

     }






}




?>