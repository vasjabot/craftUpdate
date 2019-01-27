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


$allProtoArFields_result_array = getArraySection($config);

$protoComparator = new PrototypesNS\ProtoComparator($config, $XML_arr["prototypes"], $allProtoArFields_result_array);

$protoDiff = $protoComparator->getDiffArray();

print_php($protoDiff);




// $arSelect = Array("ID", "UF_ARTICLE");
// $arFilter = Array("IBLOCK_ID"=>IntVal(12));//5031 prototypes

// $resSection = CIBlockSection::GetList(Array(), $arFilter, false, $arSelect);
// $i = 0;
// while($ob = $resSection->GetNextElement())
// {
// 	 $arFields = $ob->GetFields();
// 	 print_php($arFields);
// 	 $i++;
// }
// print_php($res);
// print_php($i);









// $arSelect = Array("ID", "NAME");
// $arFilter = Array("IBLOCK_ID"=>IntVal(12));//1671 batteries

// $resElement = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
//  $i = 0;
// while($ob = $resElement->GetNextElement())
// {
// 	 $arFields = $ob->GetFields();
// 	 print_php($arFields);
// 	 $i++;
// }

// print_php($res);
// print_php($i);
// try 
// {
//     throw new Exception("Error Processing Request", 1);    
// } 
// catch (Exception $e) 
// {
//     echo 'throw new Exception: ',  $e->getMessage(), "\n";
//     echo nl2br("\r\n");
// }



show_result_profiler($t0, $mem0);


die();
?>
