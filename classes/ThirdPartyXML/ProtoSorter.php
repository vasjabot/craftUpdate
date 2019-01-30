<?php 
/**
*-------------------------------------------------------------------------------
* ProtoSorter Class
*-------------------------------------------------------------------------------
* This is a class for curl requests execution.
* @package  ThirdPartyXMLNS 
* @author   mixxxxx 
* @link     top-secret
*/

namespace ThirdPartyXMLNS;

require_once(__DIR__.'/../Prototypes/ProtoGetterSite.php');
//require_once(__DIR__.'/SimpleXLSX.php');
include (__DIR__.'/SimpleXLSX.php');
//require_once  __DIR__.'./SimpleXLSX.php';

require_once __DIR__.'/SimpleXLSX.php';


interface ProtoSorterInterface
{
    public function getProtoSortedString($PathToXlsx);
}

abstract class AbstractProtoSorter implements ProtoSorterInterface
{
    protected $xml_prototypes;
    protected $config;

    public function __construct()
    {
         $this->config = $Config;
         $this->xml_prototypes = $xml_prototypes;
         
    }
}

class ProtoSorter extends AbstractProtoSorter
{
    public function getProtoSortedString($PathToXlsx)
    {   
        $ProtoArray = array(); 

        if ($xlsx = SimpleXLSX::parse($PathToXlsx)) 
        {
            print_r($xlsx->rows());
        } else
        {
            echo SimpleXLSX::parseError();
        }



        // $out = array();
        // $xml = simplexml_load_file($PathToXlsx);
        // $row = 0;
        // foreach ($xml->sheetData->row as $item) 
        // {
        //     $out[$file][$row] = array();
        //     $cell = 0;
        //     foreach ($item as $child) 
        //     {
        //         $attr = $child->attributes();
        //         $value = isset($child->v)? (string)$child->v:false;
        //         $out[$file][$row][$cell] = isset($attr['t']) ? $sharedStringsArr[$value] : $value;
        //         $cell++;
        //     }
        //     $row++;
        // }
     
        // var_dump($out);
        // $ProtoArray = $out; 
        // return $ProtoArray;     
    }
}




?>