<?
ini_set("display_errors",1);
error_reporting(E_ALL);


require_once(__DIR__.'/classes/Common/AppConfig.php');
require_once(__DIR__.'/classes/SimpleXML/SimpleXMLloader.php');
require_once(__DIR__.'/classes/Curl/CurlRequestor.php');
require_once(__DIR__.'/classes/SimpleXML/SimpleXMLsaver.php');
require_once(__DIR__.'/classes/SimpleXML/SimpleXMLprovider.php');
require_once(__DIR__.'/classes/SimpleXML/SimpleXMLvalidator.php');
require_once(__DIR__.'/classes/Prototypes/ProtoComparator.php');
require_once(__DIR__.'/classes/Prototypes/ProtoComparatorProducers.php');
require_once(__DIR__.'/classes/SimpleXML/ProtoGetterXML.php');
require_once(__DIR__.'/classes/Prototypes/ProtoGetterSite.php');
require_once(__DIR__.'/classes/Prototypes/ProtoUpdaterProducers.php');
require_once(__DIR__.'/classes/Prototypes/ProtoUpdater.php');





function getAllXML($XML_arr_names, $config, $DEBUG) 
{
	$XML_arr = array  (	"prototypes" => $xml_prototypes,
		               	"offers" => $xml_offers,
		               	"prices" => $xml_prices,
		               	"instock" => $xml_instock,
		               	"compatibility" => $xml_compatibility);


	foreach($XML_arr_names as $key => $value)
    {
       	$simpleXMLprovider = new SimpleXMLNS\SimpleXMLprovider($value, $config, $DEBUG);
		$xml_temp_result = $simpleXMLprovider->getFileXML($value);
		$XML_arr[$key] = $xml_temp_result;
    } 
    
    $simpleXMLvalidator = new SimpleXMLNS\SimpleXMLvalidator($config);

	$Is_All_Good = $simpleXMLvalidator->checkAllXML($XML_arr_names);

	if ($Is_All_Good == FALSE)
	{
	   return NULL;
	}
	else
	{
		return $XML_arr;
	}
}

function printAllXML($XML_arr) 
{	
	foreach($XML_arr as $key => $value)
	{
		print_php($value);
	}

}



set_time_limit(0);
$t0 = microtime(true);
$mem0 = memory_get_usage(true);


function print_php($printedString) 
{
	print_r($printedString);
	echo nl2br("\r\n");
}


function show_result_profiler($t0, $mem0) 
{
	$t1 = microtime(true);
	$mem1 = memory_get_usage(true);

	printf("exec time %d microsec\r\n", ($t1-$t0) * 1e6);
	echo nl2br("\r\n");
	printf("exec memory %d bytes\r\n", ($mem1-$mem0));
}

?>