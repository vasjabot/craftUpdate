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

    public function __construct($Config, $diff_array_prototypes)
    {
         $this->config = $Config;
         $this->diff_array_prototypes = $diff_array_prototypes;
    }
}

class ProtoUpdater extends AbstractProtoUpdater
{

    public function updateAllPrototypesByArticlesDiff()
    {           
        foreach($this->diff_array_prototypes as $diff_article)
        {
            $protoGetterSite = new ProtoGetterSite($this->config);
            $OneProtoArrayFromSite = $protoGetterSite->getProtoByArticle($diff_article);
            foreach($OneProtoArrayFromSite as $key => $value)
            {
                print_r("$key: " . $value);
                echo nl2br("\r\n");
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