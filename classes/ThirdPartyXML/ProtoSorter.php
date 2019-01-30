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
            //$xlsx = mb_convert_encoding($xlsx, "utf-8", "windows-1251");
            $rows = $xlsx->rows();
            foreach ($rows as $key => $value)
            {
                //$rows[$key] = iconv("UTF-8", "CP1251",$value);
                //$rows[$key] = iconv("windows-1251", "utf-8",$value);
                // print_r($key);
                // echo nl2br("\r\n");
                // print_r($value);
                // echo nl2br("\r\n");
                foreach ($value as $key_in => $value_in)
                {
                    $value_in = iconv("utf-8", "windows-1251",$value_in);
                    print_r($key_in);
                    echo nl2br("\r\n");
                    print_r($value_in);
                    echo nl2br("\r\n");
                }
            }

            //print_r($rows);
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