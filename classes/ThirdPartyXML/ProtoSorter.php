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
require_once __DIR__.'/SimpleXLSX.php';
use PrototypesNS\ProtoGetterSite as ProtoGetterSite;


interface ProtoSorterInterface
{
    public function getProtoSortedString($PathToXlsx);
}

abstract class AbstractProtoSorter implements ProtoSorterInterface
{
    protected $xml_prototypes;
    protected $config;

    public function __construct($Config)
    {
         $this->config = $Config;
         //$this->xml_prototypes = $xml_prototypes;
         
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
            $rows = $xlsx->rows(3);
            $protoGetterSite = new ProtoGetterSite($this->config); 
            $allSection = $protoGetterSite->getArrayAllSection();


            // foreach ($allSection as $secItem)
            // {
            //     //print_r($secItem);
            //     print_r($secItem["NAME"]);
            //     echo nl2br("\r\n");
            //     break;


            // }   

            $i=0;
            foreach ($rows as $key => $value)
            {
                //// $rows[$key] = iconv("UTF-8", "CP1251",$value);
                //// $rows[$key] = iconv("windows-1251", "utf-8",$value);




                // print_r($key);
                // echo nl2br("\r\n");
                // print_r($value);
                // echo nl2br("\r\n");

                foreach ($allSection as $secItem)
                {
                    ////print_r($secItem);
                    // print_r($secItem["NAME"]);
                    // echo nl2br("\r\n");

                    //$secItem["NAME"];

                    //$secItemName = mb_strtolower($secItem["NAME"]);
                    $secItemName = mb_strtolower($secItem["NAME"]);

                    $pos = strpos($secItem["NAME"], $value[0]);

                    if ($pos === false) 
                    {
                        echo "String NOT found";
                        echo nl2br("\r\n");
                        print_r($secItemName);
                        echo nl2br("\r\n");
                        print_r($value[0]);
                        echo nl2br("\r\n");
                    } else 
                    {
                        echo "String WAS found";
                    }

                } 

                $i++;
                if ($i>10)
                {
                    break;
                }


                //foreach ($value as $key_in => $value_in)
                //{
                    //$value_in = iconv("utf-8", "windows-1251",$value_in);
                    // print_r($key_in);
                    // echo nl2br("\r\n");
                    // print_r($value_in);
                    // echo nl2br("\r\n");

                    // foreach ($allSection as $secItem)
                    // {
                    //     print_r($secItem);
                    //     echo nl2br("\r\n");
                    //     break;


                    // }   


                    

                //}
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