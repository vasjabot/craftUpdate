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
	$allSection = $protoGetterSite->getArrayAllSection();

	$protoComparator = new PrototypesNS\ProtoComparator($config, $XML_arr["prototypes"], $allSection);
	$allPrototypesByArticlesDiff = $protoComparator->getDiffArray();
}
//ProtoUpdater
if(0)
{
	//$allPrototypesByArticlesDiff = array('A0.00.000'); 	//test for new add
	//$allPrototypesByArticlesDiff = array('A1.13.010');	//test for update old
	$protoUpdater = new PrototypesNS\ProtoUpdater($config, $allPrototypesByArticlesDiff, $XML_arr["prototypes"], $XML_arr["compatibility"]);
	$protoUpdater->updateAllPrototypesByArticlesDiff();
}
/////////////////////////////////////////////////////////////////////////////
////////////////////////<<ProtoUpdater>>/////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////



/////////////////////////////////////////////////////////////////////////////
///////////////////////////<<BatteryUpdater>>////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
//allBatteriesByArticlesDiff
if (0)
{
	$batGetterSite = new BatteriesNS\BatGetterSite($config);    
	$allBatteriesFromSite = $protoGetterSite->getArrayAllSection();


	//$allProtoArFields_result_array = getArrayAllSection($config);
	//$protoComparator = new PrototypesNS\ProtoComparator($config, $XML_arr["prototypes"], $allProtoArFields_result_array);
	//$allPrototypesByArticlesDiff = $protoComparator->getDiffArray();
}


/////////////////////////////////////////////////////////////////////////////
///////////////////////////<<BatteryUpdater>>////////////////////////////////
/////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////////
///////////////////////////<<ProtoSorter>>///////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
if (1)
{
	$protoSorter = new ThirdPartyXMLNS\ProtoSorter($config);    
	$SortedArray = $protoSorter->getProtoSortedString(__DIR__.'/classes/ThirdPartyXML/4proto.xlsx');

	$protoGetterSite = new PrototypesNS\ProtoGetterSite($config);
	$protoUpdater = new PrototypesNS\ProtoUpdater($config, $allPrototypesByArticlesDiff, $XML_arr["prototypes"], $XML_arr["compatibility"]);

	foreach ($SortedArrayyyyyyy as $key => $value)
	{
	    $key = str_replace(' ', '_', $key);
        $key = str_replace('.', '_', $key);
        $key = str_replace('/', '_', $key);

        print_r($key);
	    echo nl2br("\r\n");

	    print_r($value);
	    echo nl2br("\r\n");

	    if($key === "acer_a1")
	    {
	    	$OneProtoArrayFromSite = $protoGetterSite->getProtoByBitrixCode($key);
        	$res = $protoUpdater->updateOldPrototype($OneProtoArrayFromSite, $curProtoArticle, $value);
        	print_r("Was updated" . $res);
	    	echo nl2br("\r\n");
	    }

        

        
	}

}
/////////////////////////////////////////////////////////////////////////////
///////////////////////////<<ProtoSorter>>///////////////////////////////////
/////////////////////////////////////////////////////////////////////////////


show_result_profiler($t0, $mem0);


die();
?>
