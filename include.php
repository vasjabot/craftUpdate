<?
require_once(__DIR__.'/classes/Config.php');

ini_set("display_errors",1);
error_reporting(E_ALL);


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