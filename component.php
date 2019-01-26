<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
CModule::IncludeModule("iblock");
require_once(__DIR__.'/include.php');


$config = new Config();
print_php($config->auth_path_file);
//print_php($config->LOGIN);
//print_php($config->PWS);


$curlRequestor = new CurlRequestor($config->LOGIN, $config->PWS);


//$curlRequestor->getData($CurlUrl);




//show_result_profiler($t0, $mem0);


die();
?>
