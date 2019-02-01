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
                    //print_r($value[1]);
                    //echo nl2br("\r\n");

                    foreach ($result_allSection as $secItemCode)
                    {
                        // print_r($value[0]);
                        // echo nl2br("\r\n");


                        if ($value[0] == "acer betouch e130 цена")
                        {
                            // print_r("WAS  FOUND!!!!");
                            // echo nl2br("\r\n");

                            //print_r($secItemCode);
                            //echo nl2br("\r\n");

                            ///////!!!!!!!!!!!$pos = strpos($secItemCode, $value[0]);

                            //$pos = strpos("acer betouch e130", "acer betouch e130 цена");

                            $pos = strpos("acer betouch e130 цена", "acer betouch e130");


                            //$pos = stristr("acer betouch e130 цена", "acer betouch e130");

        

                            //if(stristr("acer betouch e130 цена", "acer betouch e130") === FALSE) 
                            if($pos === FALSE) 
                            {
                                //echo '"acer betouch e130" не найдена в строке';
                            }
                            else
                            {
                                echo '"acer betouch e130" WAS FOUNDED IN';
                            }


                            // print_r("FUCKING pos =");
                            // echo nl2br("\r\n");

                            // print_r($pos);
                            // echo nl2br("\r\n");

                            if ($pos === false)
                            {
                                

                            }
                            else
                            {
                                // print_r("FOUNDED pos =");
                                // echo nl2br("\r\n");

                                // print_r($pos);
                                // echo nl2br("\r\n");

                            }

                        }

                       // break;


                       

                        $pos = strpos($secItemCode, $value[0]);

                        if ($pos === false) 
                        {
                            //continue;
                           

                        } else 
                        {
                            if ($prev_value_1 == $value[1])
                            {
                                //continue;
                            }
                            else
                            {
                                // echo "String WAS found";
                                // print_r($value[0]);
                                // echo nl2br("\r\n");
                                // print_r($value[1]);
                                // echo nl2br("\r\n");

                                // $prev_value_1 = $value[1];

                                //break;

                            }
                            



                          
                        }

                    } 

                    $i++;
                    if ($i>100)
                    {
                        break;
                    }


                   


                        

                    
                }


                foreach ($rows as $key => $value)
                {
                    // print_r($key);
                    // echo nl2br("\r\n");
                    // print_r($value);
                    // echo nl2br("\r\n");


                }


            }

            //print_r($rows);
        } else
        {
            echo SimpleXLSX::parseError();
        }



    }
}




?>