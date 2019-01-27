<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
CModule::IncludeModule("iblock");
require_once(__DIR__.'/include.php');

$DEBUG = TRUE;

$config = new CommonNS\AppConfig();
print_php($config->auth_path_file);
//$url = $config->getURLbyFileName("prototypes_work.xml");
//print_php($url);
//print_php($config->LOGIN);
//print_php($config->PWS);




$simpleXMLprovider = new SimpleXMLNS\SimpleXMLprovider('prototypes_work.xml', $config, $DEBUG);
$xml_prototypes = $simpleXMLprovider->getFileXML('prototypes_work.xml');

$simpleXMLprovider = new SimpleXMLNS\SimpleXMLprovider('offers_work.xml', $config, $DEBUG);
$xml_offers = $simpleXMLprovider->getFileXML('offers_work.xml');


$simpleXMLprovider = new SimpleXMLNS\SimpleXMLprovider('prices_work.xml', $config, $DEBUG);
$xml_prices = $simpleXMLprovider->getFileXML('prices_work.xml');


$simpleXMLprovider = new SimpleXMLNS\SimpleXMLprovider('instock_work.xml', $config, $DEBUG);
$xml_instock = $simpleXMLprovider->getFileXML('instock_work.xml');


$simpleXMLprovider = new SimpleXMLNS\SimpleXMLprovider('compatibility_work.xml', $config, $DEBUG);
$xml_compatibility = $simpleXMLprovider->getFileXML('compatibility_work.xml');


$XML_arr_names = array  (	"prototypes" => 'prototypes_work.xml',
		               		"offers" => 'offers_work.xml',
		               		"prices" => 'prices_work.xml',
		               		"instock" => 'instock_work.xml',
		               		"compatibility" => 'compatibility_work.xml');


$simpleXMLvalidator = new SimpleXMLNS\SimpleXMLvalidator($config);



$Is_All_Good = $simpleXMLvalidator->checkAllXML($XML_arr_names);

if ($Is_All_Good == FALSE)
{
   return;
}







print_php($xml_prototypes);
print_php($xml_offers);
print_php($xml_prices);
print_php($xml_instock);
print_php($xml_compatibility);







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
