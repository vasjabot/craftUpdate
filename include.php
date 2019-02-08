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
require_once(__DIR__.'/classes/SimpleXML/BatGetterXML.php');
require_once(__DIR__.'/classes/Prototypes/ProtoGetterSite.php');
require_once(__DIR__.'/classes/Prototypes/ProtoUpdaterProducers.php');
require_once(__DIR__.'/classes/Prototypes/ProtoUpdater.php');
require_once(__DIR__.'/classes/ThirdPartyXML/ProtoSorter.php');
require_once(__DIR__.'/classes/Batteries/BatGetterSite.php');
require_once(__DIR__.'/classes/Batteries/BatComparator.php');
require_once(__DIR__.'/classes/Batteries/BatUpdater.php');
require_once(__DIR__.'/classes/Pictures/ProtoPicUpdater.php');




function printAllXML($XML_arr) 
{	
	foreach($XML_arr as $key => $value)
	{
		print_php($value);
	}

}



set_time_limit(60);
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