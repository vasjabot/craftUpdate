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

require_once(__DIR__.'/ProtoGetterSite.php');
require_once(__DIR__.'/../SimpleXML/ProtoGetterXML.php');
use SimpleXMLNS\ProtoGetterXML as ProtoGetterXML;

$_SERVER["DOCUMENT_ROOT"] = '/home/bitrix/www';
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use Bitrix;
use Bitrix\Main\Loader;
Loader::includeModule("iblock");


interface ProtoUpdaterInterface
{
    public function updateAllPrototypesByArticlesDiff();
    public function updateOldPrototype($OneProtoArrayFromSite, $OneProtoArrayFromDiffMass);
    public function setNewPrototype($OneProtoArrayFromDiffMass);    
}

abstract class AbstractProtoUpdater implements ProtoUpdaterInterface
{
    protected $config;
    protected $diff_array_prototypes;

    public function __construct($Config, $allPrototypesByArticlesDiff)
    {
         $this->config = $Config;
         $this->diff_array_of_articles = $allPrototypesByArticlesDiff;
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

    public function updateOldPrototype($OneProtoArrayFromSite, $OneProtoArrayFromDiffMass)
    {
        
    }

    public function setNewPrototype($OneProtoArrayFromDiffMass)
    {
       
    }



}




?>