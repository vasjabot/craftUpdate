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
////////////////<<protoGetterSite>>//////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
if(1)
{
	$testProtoName = "A1";
	$bs = new CIBlockSection;
	$protoGetterSite = new PrototypesNS\ProtoGetterSite($config, $bs);
	$seachedProto = $protoGetterSite->getProtoByName($testProtoName);
	print_php("seachedProto is:");
	print_php($seachedProto);
}
/////////////////////////////////////////////////////////////////////////////
////////////////<<protoGetterSite>>//////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////





/////////////////////////////////////////////////////////////////////////////
//////////////<<protoSetterProducersFielsFromXml>>///////////////////////////
/////////////////////////////////////////////////////////////////////////////
if(0)
{
	//$firstDepthLevelSectionByNamesDiff = array('ABER'); 
	//$protoGetterXML = new SimpleXMLNS\ProtoGetterXML($config, $XML_arr["prototypes"]);
	//$protoSettersProducersSite = new PrototypesNS\ProtoSettersProducersSite($config, $protoGetterXML, $firstDepthLevelSectionByNamesDiff);
	//$protoSettersProducersSite->setAllDiffArray();
}
/////////////////////////////////////////////////////////////////////////////
//////////////<<protoSetterProducersFielsFromXml>>///////////////////////////
/////////////////////////////////////////////////////////////////////////////



/////////////////////////////////////////////////////////////////////////////
//////////////////<<protoSetterFielsFromXml>>////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
//$allPrototypesByArticlesDiff = array('A0.00.000');



/////////////////////////////////////////////////////////////////////////////
//////////////////<<protoSetterFielsFromXml>>////////////////////////////////
/////////////////////////////////////////////////////////////////////////////










show_result_profiler($t0, $mem0);


die();
?>
