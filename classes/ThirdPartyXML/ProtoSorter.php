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



            $result_allSection = array();

            foreach ($allSection as $key => $value)
            {
                // print_r($key);
                // echo nl2br("\r\n");
                // print_r($value);
                // echo nl2br("\r\n");

                foreach ($value as $key_in => $value_in)
                {
                    // print_r($key_in);
                    // echo nl2br("\r\n");
                    // print_r($value_in);
                    // echo nl2br("\r\n");
                    //break;


                    if($key_in == "CODE") 
                    {
                        $value_in = str_replace('_', ' ', $value_in);
                        $value_in = str_replace('_', '.', $value_in);
                        $result_allSection[] = $value_in;
                        // print_r($key);
                        // echo nl2br("\r\n");
                        // print_r($value);
                        // echo nl2br("\r\n");
                        if ($value_in == "acer liquid z530s")
                        {
                            //print_r("acer liquid z530s WAS FOUND!!!!!!!!!");
                        }
                    }

                }

                

            }


            foreach ($result_allSection as $item)
            {
                //print_r($item);
                //echo nl2br("\r\n");
            }





            //$i=0;
            //foreach ($allSection as $secItem)
            // foreach ($allSection as $key => $value)
            // {
            //     //$i++;
            //     //$secItemCode = mb_strtolower($secItem["CODE"]);
            //     //$secItemCode = str_replace('_', ' ', $secItemCode);
            //     //$secItemCode = str_replace('_', '.', $secItemCode);

            //     //$allSection[$i-1] = $secItemCode;

            //     if ($key == "CODE")
            //     {
            //         //$value = str_replace('_', ' ', $value);
            //         //$value = str_replace('_', '.', $value);


                    
            //         //unset($allSection[$i-1]);
            //         //continue;

            //     }

            // }

            // foreach ($allSection as $secItem)
            // {
            //     //print_r($secItem);
            //     //print_r($secItem["NAME"]);
            //     print_r($secItem["CODE"]);
            //     echo nl2br("\r\n");
            //     //break;

            // }   




            $i=0;
            if(1)
            {    
                foreach ($rows as $key => $value)
                {
                    //break;
                    //// $rows[$key] = iconv("UTF-8", "CP1251",$value);
                    //// $rows[$key] = iconv("windows-1251", "utf-8",$value);




                    // print_r($key);
                    // echo nl2br("\r\n");
                    // print_r($value);
                    // echo nl2br("\r\n");

                    foreach ($result_allSection as $secItemCode)
                    {
                        ////print_r($secItem);
                        // print_r($secItem["NAME"]);
                        // echo nl2br("\r\n");

                        //$secItem["NAME"];

                        //$secItemName = mb_strtolower($secItem["NAME"]);

                        //if ($secItem["CODE"] == "")
                        //{
                        //    continue;

                        //}
                        //$secItemName = mb_strtolower($secItem["NAME"]);
                        //$secItemCode = mb_strtolower($secItem["CODE"]);
                        //$secItemCode = str_replace('_', ' ', $secItemCode);
                        //$secItemCode = str_replace('_', '.', $secItemCode);


                        //$secItemCode = iconv("utf-8", "windows-1251", $secItemCode);

                        $pos = strpos($secItemCode, $value[0]);

                        if ($pos === false) 
                        {
                            //echo "String NOT found";
                            // echo nl2br("\r\n");
                            // print_r($secItemCode);
                            // echo nl2br("\r\n");
                            // print_r($value[0]);
                            // echo nl2br("\r\n");
                        } else 
                        {
                            if ($prev_value_1== $value[1])
                            {
                                continue;
                            }
                            else
                            {
                                echo "String WAS found";
                                print_r($value[0]);
                                echo nl2br("\r\n");
                                print_r($value[1]);
                                echo nl2br("\r\n");

                                $prev_value_1 = $value[1];

                            }
                            



                            // $new_value = array();
                            // $new_value[0] = "WAS found";
                            // $new_value[1] = 0;

                            // $rows[$key] = $new_value;

                            //break;

                        }

                    } 

                    $i++;
                    if ($i>100)
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


                foreach ($rows as $key => $value)
                {
                    print_r($key);
                    echo nl2br("\r\n");
                    print_r($value);
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