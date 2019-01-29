<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
CModule::IncludeModule("iblock");
require_once(__DIR__.'/include.php');

$DEBUG = TRUE;

$config = new CommonNS\AppConfig();


/////////////////////////////////////////////////////////////////////////////
//////////////////////////////<<XML>>////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
$XML_arr = array  (	"prototypes" => $xml_prototypes,
	             	"offers" => $xml_offers,
	               	"prices" => $xml_prices,
	               	"instock" => $xml_instock,
	               	"compatibility" => $xml_compatibility);


$XML_arr_names = array(	"prototypes" => 'prototypes_work.xml',
	               		"offers" => 'offers_work.xml',
	               		"prices" => 'prices_work.xml',
	               		"instock" => 'instock_work.xml',
	               		"compatibility" => 'compatibility_work.xml');

$XML_arr = getAllXML($XML_arr_names, $config, $DEBUG);
//printAllXML($XML_arr);
/////////////////////////////////////////////////////////////////////////////
//////////////////////////////<<XML>>////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////



/////////////////////////////////////////////////////////////////////////////
////////////////<<firstDepthLevelSectionByNamesDiff>>////////////////////////
/////////////////////////////////////////////////////////////////////////////
if(0)
{
	$allFirstDepthLevelSection = getArrayFirstDepthLevelSection($config);
	$protoComparatorProducers = new PrototypesNS\ProtoComparatorProducers($config, $XML_arr["prototypes"], $allFirstDepthLevelSection);
	$firstDepthLevelSectionByNamesDiff = $protoComparatorProducers->getDiffArray();
}
/////////////////////////////////////////////////////////////////////////////
////////////////<<firstDepthLevelSectionByNamesDiff>>////////////////////////
/////////////////////////////////////////////////////////////////////////////



/////////////////////////////////////////////////////////////////////////////
////////////////<<allPrototypesByArticlesDiff>>//////////////////////////////
/////////////////////////////////////////////////////////////////////////////
if(0)
{
	$allProtoArFields_result_array = getArrayAllSection($config);
	$protoComparator = new PrototypesNS\ProtoComparator($config, $XML_arr["prototypes"], $allProtoArFields_result_array);
	$allPrototypesByArticlesDiff = $protoComparator->getDiffArray();
}
/////////////////////////////////////////////////////////////////////////////
////////////////<<allPrototypesByArticlesDiff>>//////////////////////////////
/////////////////////////////////////////////////////////////////////////////





/////////////////////////////////////////////////////////////////////////////
//////////////////////<<protoUpdaterProducers>>///////////////////////////////
/////////////////////////////////////////////////////////////////////////////
if(1)
{	

	//$firstDepthLevelSectionByNamesDiff = array("ABER");
	$firstDepthLevelSectionByNamesDiff = array("ACER");  

	$protoUpdaterProducers = new PrototypesNS\ProtoUpdaterProducers($config, $XML_arr["prototypes"], $firstDepthLevelSectionByNamesDiff);
	$protoUpdaterProducers->updateAllFirstDepthLevelSectionDiffArray();
}
/////////////////////////////////////////////////////////////////////////////
//////////////////////<<protoUpdaterProducers>>///////////////////////////////
/////////////////////////////////////////////////////////////////////////////



/////////////////////////////////////////////////////////////////////////////
///////////////////////////<<allProtoUpdater>>///////////////////////////////
/////////////////////////////////////////////////////////////////////////////
if(0)
{
	//$allPrototypesByArticlesDiff = array('A0.00.000');
	$allPrototypesByArticlesDiff = array('A1.13.010');
	$protoUpdater = new PrototypesNS\ProtoUpdater($config, $allPrototypesByArticlesDiff);
	$protoUpdater->updateAllPrototypesByArticlesDiff();


}
/////////////////////////////////////////////////////////////////////////////
///////////////////////////<<allProtoUpdater>>///////////////////////////////
/////////////////////////////////////////////////////////////////////////////



show_result_profiler($t0, $mem0);


die();
?>
