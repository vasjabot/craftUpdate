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
        
    }

    public function updateOldPrototype($OneProtoArrayFromSite, $OneProtoArrayFromDiffMass)
    {
        
    }

    public function setNewPrototype($OneProtoArrayFromDiffMass)
    {
       
    }



}




?>