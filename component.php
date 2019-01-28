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
$arFilter = Array("IBLOCK_ID"=>IntVal($config->IBLOCK_ID), "DEPTH_LEVEL"=>1);//razdel prototypes 98 with CRAFTMANN
$allProtoArFields_result_array = getArraySection($arFilter);
//$protoComparator = new PrototypesNS\ProtoComparator($config, $XML_arr["prototypes"], $allProtoArFields_result_array);
//$protoDiff = $protoComparator->getDiffArray();

//print_php($allProtoArFields_result_array);
foreach($allProtoArFields_result_array as $key => $value)
{
	//if ($key == "NAME")
	//{
	print_php($key);
	print_php($value);
	//}
	
}

/////////////////////////////////////////////////////////////////////////////





/////////////////////////////////////////////////////////////////////////////
if(0)
{
	$arFilter = Array("IBLOCK_ID"=>IntVal($config->IBLOCK_ID));//5031 prototypes
	$allProtoArFields_result_array = getArraySection($arFilter);
	$protoComparator = new PrototypesNS\ProtoComparator($config, $XML_arr["prototypes"], $allProtoArFields_result_array);
	$protoDiff = $protoComparator->getDiffArray();
	print_php($protoDiff);
}
/////////////////////////////////////////////////////////////////////////////




/////////////////////////////////////////////////////////////////////////////
if (0)
{
	$arFilter = array('IBLOCK_ID' => IntVal($config->IBLOCK_ID), "UF_ARTICLE"=>$protoDiff);//5031 prototypes
	$temp_result_array = getArraySection($arFilter);

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
