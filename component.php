<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
CModule::IncludeModule("iblock");
require_once(__DIR__.'/include.php');

$DEBUG = TRUE;

$config = new CommonNS\AppConfig();


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
$allFirstDepthLevelSection = getArrayFirstDepthLevelSection($config);

foreach($allFirstDepthLevelSection as $key => $value)
{
	print_php($key);
	print_php($value);
}

//$protoComparatorProducers = new PrototypesNS\ProtoComparatorProducers($config, $XML_arr["prototypes"], $allFirstDepthLevelSection);
//$protoDiffFirstDepthLevel = $protoComparatorProducers->getDiffArray();
//print_php($protoDiffFirstDepthLevel);

/////////////////////////////////////////////////////////////////////////////








/////////////////////////////////////////////////////////////////////////////
if(0)
{
	$allProtoArFields_result_array = getArrayAllSection($config);
	$protoComparator = new PrototypesNS\ProtoComparator($config, $XML_arr["prototypes"], $allProtoArFields_result_array);
	$protoDiff = $protoComparator->getDiffArray();
	print_php($protoDiff);
}
/////////////////////////////////////////////////////////////////////////////






/////////////////////////////////////////////////////////////////////////////
if (0)
{
	$temp_result_array = getArrayAllSection($config);

	foreach($temp_result_array as $key => $value)
	{
		//print_php($key);
		//print_php($value);
		foreach($value as $key_in => $value_in)
		{
			if ($key_in == "UF_ARTICLE")
			{
				//print_php($key_in);
				//print_php($value_in);
				$protoGetter = new PrototypesNS\ProtoGetter($config, $XML_arr["prototypes"]);
				$OneProtoArray = $protoGetter->getProtoByArticle($value_in);
				print_php("mass from xml:");
				print_php($OneProtoArray);
				print_php("mass from site:");
				print_php($value);


			}

		}
	}
}
/////////////////////////////////////////////////////////////////////////////







show_result_profiler($t0, $mem0);


die();
?>
