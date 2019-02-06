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

$simpleXMLprovider = new SimpleXMLNS\SimpleXMLprovider($config, $DEBUG);
$XML_arr = $simpleXMLprovider->getAllXML($XML_arr_names);
//printAllXML($XML_arr);
/////////////////////////////////////////////////////////////////////////////
//////////////////////////////<<XML>>////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////



/////////////////////////////////////////////////////////////////////////////
/////////////////////<<protoUpdaterProducers>>///////////////////////////////
/////////////////////////////////////////////////////////////////////////////
//firstDepthLevelSectionByNamesDiff
if(0)
{
	$protoGetterSite = new PrototypesNS\ProtoGetterSite($config);    
	$allFirstDepthLevelSection = $protoGetterSite->getArrayAllFirstDepthLevelSection();

	$protoComparatorProducers = new PrototypesNS\ProtoComparatorProducers($config, $XML_arr["prototypes"], $allFirstDepthLevelSection);
	$firstDepthLevelSectionByNamesDiff = $protoComparatorProducers->getDiffArray();
}
//protoUpdaterProducers
if(0)
{	
	//$firstDepthLevelSectionByNamesDiff = array("ABER");	//test for new add
	//$firstDepthLevelSectionByNamesDiff = array("ACER");  	//test for update old
	$protoUpdaterProducers = new PrototypesNS\ProtoUpdaterProducers($config, $firstDepthLevelSectionByNamesDiff);
	$protoUpdaterProducers->updateAllFirstDepthLevelSectionDiffArray();
}
/////////////////////////////////////////////////////////////////////////////
/////////////////////<<protoUpdaterProducers>>///////////////////////////////
/////////////////////////////////////////////////////////////////////////////



/////////////////////////////////////////////////////////////////////////////
////////////////////////<<ProtoUpdater>>/////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
//allPrototypesByArticlesDiff
if(0)
{
	$protoGetterSite = new PrototypesNS\ProtoGetterSite($config);    
	$allSectionFromSite = $protoGetterSite->getArrayAllSection();

	$protoComparator = new PrototypesNS\ProtoComparator($config, $XML_arr["prototypes"], $allSectionFromSite);
	$allPrototypesByArticlesDiff = $protoComparator->getDiffArray();
}
//ProtoUpdater
if(0)
{
	// $allPrototypesByArticlesDiff = array('A0.00.000'); 	//test for new add
	// $allPrototypesByArticlesDiff = array('A1.13.010');	//test for update old
	$protoUpdater = new PrototypesNS\ProtoUpdater($config, $allPrototypesByArticlesDiff, $XML_arr["prototypes"], $XML_arr["compatibility"]);
	$protoUpdater->updateAllPrototypesByArticlesDiff();
}
//ProtoSorter
//No needed every time
if(0)
{
	$protoUpdater = new PrototypesNS\ProtoUpdater($config, $allSectionArticles, $XML_arr["prototypes"], $XML_arr["compatibility"]);
	$protoUpdater->updateAllSectionSorting();

	$protoSorter = new ThirdPartyXMLNS\ProtoSorter($config, $XML_arr);
	$protoSorter->setAllSectionSorting(__DIR__.'/classes/ThirdPartyXML/4proto.xlsx');
}	

/////////////////////////////////////////////////////////////////////////////
////////////////////////<<ProtoUpdater>>/////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////






/////////////////////////////////////////////////////////////////////////////
///////////////////////////<<BatteryUpdater>>////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
//allBatteriesByArticlesDiff
if (1)
{
	$batGetterSite = new BatteriesNS\BatGetterSite($config);    
	$allBatteriesFromSite = $batGetterSite->getArrayAllBatteries();

	// foreach ($allBatteriesFromSite as $Bat)
	// {
	// 	if((trim($Bat["TYPE"]) !== "90") && (trim($Bat["TYPE"]) !== "93"))
	// 	//if(trim($Bat["TYPE"]) == "90")
	// 	{
	// 		// print_php($Bat["GROUPS_ARRAY"]);
	// 		// echo nl2br("\r\n");
	// 		// print_php($Bat["GROUPS_ID_ARRAY"]);
	// 		// echo nl2br("\r\n");
	// 		//print_php($Bat["GROUPS_ARTICLE"]);

	// 		print_php($Bat);
	// 		echo nl2br("\r\n");

	// 		//break;

	// 	}
		
	// }


	$batComparator = new BatteriesNS\BatComparator($config, $XML_arr["offers"], $XML_arr["instock"], $XML_arr["prices"], $allBatteriesFromSite);
	$allBatteriestypesByArticlesDiff = $batComparator->getDiffArray();

	$new_allBatteriestypesByArticlesDiff =  array();

	foreach($allBatteriestypesByArticlesDiff as $key => $value)
	{
 		print_php($key);
	 	echo nl2br("\r\n");
	 	print_php($value);
	 	echo nl2br("\r\n");
	 	//$new_allBatteriestypesByArticlesDiff[] = $value;
	 	break;
	}


	// $batGetterXML = new SimpleXMLNS\BatGetterXML($config, $XML_arr["offers"]);
	// $Bat = $batGetterXML->getBatByArticle('C1.01.001'); 
	// print_php($Bat);

	$new_allBatteriestypesByArticlesDiff = array('C1.01.001'); 	//test for new add
	$batUpdater = new BatteriesNS\BatUpdater($config, $new_allBatteriestypesByArticlesDiff, $XML_arr["offers"]);
	$batUpdater->updateAllBatteriesByArticlesDiff();



}


/////////////////////////////////////////////////////////////////////////////
///////////////////////////<<BatteryUpdater>>////////////////////////////////
/////////////////////////////////////////////////////////////////////////////





show_result_profiler($t0, $mem0);


die();
?>
