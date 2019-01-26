<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
CModule::IncludeModule("iblock");
require_once(__DIR__.'/include.php');

$DEBUG = TRUE;

$config = new Config();
print_php($config->auth_path_file);
//print_php($config->LOGIN);
//print_php($config->PWS);




$simpleXMLprovider = new SimpleXMLprovider('prototypes_work.xml', $config);


// if ($DEBUG == TRUE) 
// {
// 	$simpleXMLloader = new SimpleXMLloader();
// 	$xml_prototypes = $simpleXMLloader->loadFileXML('prototypes_work.xml');
// 	if ($xml_prototypes == NULL)
// 	{
// 		$curlRequestor = new CurlRequestor($config->LOGIN, $config->PWS);
// 		//228seconds
// 		$result_prototypes = $curlRequestor->getData($config->url_prototypes);

// 		$simpleXMLsaver = new SimpleXMLsaver();
// 		$xml_prototypes = $simpleXMLsaver->saveFileXML('prototypes_work.xml', $result_prototypes);

// 	}
// }
// else
// {
// 	$curlRequestor = new CurlRequestor($config->LOGIN, $config->PWS);
// 	//228seconds
// 	$result_prototypes = $curlRequestor->getData($config->url_prototypes);

// 	$simpleXMLsaver = new SimpleXMLsaver();
// 	$xml_prototypes = $simpleXMLsaver->saveFileXML('prototypes_work.xml', $result_prototypes);
// }






//print_php($result_prototypes);

try 
{
    throw new Exception("Error Processing Request", 1);    
} 
catch (Exception $e) 
{
    echo 'throw new Exception: ',  $e->getMessage(), "\n";
    echo nl2br("\r\n");
}



show_result_profiler($t0, $mem0);


die();
?>
