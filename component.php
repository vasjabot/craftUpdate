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




print_php($xml_prototypes);

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
