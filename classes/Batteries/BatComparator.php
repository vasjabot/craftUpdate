<?php 
/**
*-------------------------------------------------------------------------------
* BatComparator Class
*-------------------------------------------------------------------------------
* This is a class for compare properties of batteries from Site and Craftmiddle.
* @package  BatteriesNS 
* @author   mixxxxx 
* @link     top-secret
*/

namespace BatteriesNS;


interface BatComparatorInterface
{
    public function getDiffArray();
}

abstract class AbstractBatComparator implements BatComparatorInterface
{  
    protected $config;
    protected $xml_offers;
    protected $array_batteries;

    public function __construct($Config, $xml_offers, $xml_instock, $xml_prices, $array_batteries)
    {
        $this->config = $Config;
        $this->xml_offers = $xml_offers;
        $this->xml_instock = $xml_instock;
        $this->xml_prices = $xml_prices;      
        $this->array_batteries = $array_batteries;
    }
}

class BatComparator extends AbstractBatComparator
{
    public function getDiffArray()
    {   
        $DiffArrayOfArticles = array();

        if ($this->xml_offers->xpath('//dataWs'))
        {
            $index_dataWs = 0;
            foreach ($this->xml_offers->xpath('//dataWs') as $item_offers_xml)
            {
                $item_article_in_xml = $item_offers_xml->article; 
                //print_r($item_article);     
                $item_article_in_xml = (array)$item_article_in_xml;
                //print_r($item_article);
                $item_article_in_xml = $item_article_in_xml[0];
                //print_r($item_article);
                //echo nl2br("\r\n");

                $WasFound = FALSE;

                foreach ($this->array_batteries as $value )
                { 
                    $item_article_in_array = $value["ARTICLE"];

                    //print_r($item_search_prototypes_article_in_array);
                    //echo nl2br("\r\n");

                    if ($item_article_in_array == $item_article_in_xml)
                    {
                        /////////////////////<<barcode>>///////////////////////////
                        // print_r("Equal articles");
                        // echo nl2br("\r\n");
                        // print_r($item_article_in_xml);
                        // echo nl2br("\r\n");
                        // print_r($item_article_in_array);
                        // echo nl2br("\r\n");

                        $barcode_in_xml = $item_offers_xml->barcode;
                        $barcode_in_xml = (array)$barcode_in_xml;
                        $barcode_in_xml = $barcode_in_xml[0];
                        if($barcode_in_xml !== $value["EAN_13"])
                        {
                            print_r("Wrong EAN_13 in : " . $item_article_in_xml );
                            echo nl2br("\r\n");
                            continue;
                        }
                        // print_r("Equal barcode");


                        /////////////////////<<batteryDescription>>///////////////////////////
                        $batteryDescription_in_xml = $item_offers_xml->batteryDescription;
                        $batteryDescription_in_xml = (array)$batteryDescription_in_xml;
                        $batteryDescription_in_xml = $batteryDescription_in_xml[0];
                        //if (isset($item_offers_xml->batteryDescription))

                        $batteryDescription_in_xml = iconv("utf-8", "windows-1251", $batteryDescription_in_xml);
                        //$value_DETAIL_TEXT = iconv("utf-8", "windows-1251", $value["DETAIL_TEXT"]);  //wrong string
                        $value_DETAIL_TEXT = $value["DETAIL_TEXT"];

                        // print_r("batteryDescription_in_xml: " . $batteryDescription_in_xml);
                        // echo nl2br("\r\n");
                        // print_r("value['DETAIL_TEXT']: " . $value_DETAIL_TEXT);
                        // echo nl2br("\r\n");

                        // $batteryDescription_in_xml_temp = mb_strtolower($batteryDescription_in_xml, "windows-1251");
                        // $batteryDescription_in_xml_temp = str_replace(' ', '_', $batteryDescription_in_xml_temp);
                        // $batteryDescription_in_xml_temp = trim($batteryDescription_in_xml_temp);
                        // $value_DETAIL_TEXT_temp = mb_strtolower($value_DETAIL_TEXT, "windows-1251");
                        // $value_DETAIL_TEXT_temp = str_replace(' ', '_', $value_DETAIL_TEXT_temp);
                        // $value_DETAIL_TEXT_temp = trim($value_DETAIL_TEXT_temp);

                        // //$strcmp_result = strcmp($batteryDescription_in_xml_temp, $value_DETAIL_TEXT_temp);
                        // //$strcmp_result = $batteryDescription_in_xml_temp === $value_DETAIL_TEXT_temp;
                        // if ($batteryDescription_in_xml_temp === $batteryDescription_in_xml_temp)
                        // {
                        //     $strcmp_result = "TRUE";
                        // }
                        // else
                        // {
                        //     $strcmp_result = "FALSE";
                        // }

                        // print_r("strcmp result: " . $strcmp_result);
                        // echo nl2br("\r\n");

                        if($batteryDescription_in_xml !== '')
                        {
                            // print_r("batteryDescription_in_xml: " .$batteryDescription_in_xml);
                            // echo nl2br("\r\n");
                            // print_r("DETAIL_TEXT: " .$value["DETAIL_TEXT"]);
                            // echo nl2br("\r\n");

                            if(empty($batteryDescription_in_xml))
                            {
                                // print_r("batteryDescription_in_xml is empty ");
                                // echo nl2br("\r\n");
                                $batteryDescription_in_xml = '';
                            }
                            if(empty($value["DETAIL_TEXT"]))
                            {
                                // print_r("value['DETAIL_TEXT'] is empty ");
                                // echo nl2br("\r\n");
                                $value["DETAIL_TEXT"] = '';
                            }

                            if(trim($batteryDescription_in_xml) !== trim($value_DETAIL_TEXT))
                            {
                                print_r("Wrong DETAIL_TEXT in : " . $item_article_in_xml );
                                echo nl2br("\r\n");
                                continue;
                            }
                        }
                        // print_r("Equal batteryDescription");
                       
                        /////////////////////<<capacity>>///////////////////////////
                        $capacity_in_xml = $item_offers_xml->capacity;
                        $capacity_in_xml = (array)$capacity_in_xml;
                        $capacity_in_xml = $capacity_in_xml[0];

                        // print_r("capacity_in_xml: " .$capacity_in_xml);
                        // echo nl2br("\r\n");

                        // print_r("CAPACITY: " .$value["CAPACITY"]);
                        // echo nl2br("\r\n");

                        if($capacity_in_xml !== $value["CAPACITY"])
                        {
                            print_r("Wrong CAPACITY in : " . $item_article_in_xml );
                            echo nl2br("\r\n");
                            continue;
                        }
                        // print_r("Equal capacity");

                        /////////////////////<<complect>>///////////////////////////
                        $complect_in_xml = $item_offers_xml->complect;
                        $complect_in_xml = (array)$complect_in_xml;
                        $complect_in_xml = $complect_in_xml[0];

                        $complect_in_xml = iconv("utf-8", "windows-1251", $complect_in_xml);

                        // print_r("complect_in_xml: " .$complect_in_xml);
                        // echo nl2br("\r\n");

                        // print_r("COMPLECT: " .$value["COMPLECT"]);
                        // echo nl2br("\r\n");

                        if($complect_in_xml !== $value["COMPLECT"])
                        {
                            print_r("Wrong COMPLECT in : " . $item_article_in_xml );
                            echo nl2br("\r\n");
                            continue;
                        }
                        // print_r("Equal complect");



                        /////////////////////<<devices>>///////////////////////////   
                        if ($item_offers_xml->devices)
                        {
                            $count_item_offers_devices = count($item_offers_xml->devices);
                            //print_r($count_item_offers_devices);
                            //echo nl2br("\r\n");
                            $devices_array = array();
                            // print_r($count_item_offers_devices);
                            // echo nl2br("\r\n");
                            for ($count_dev = 0; $count_dev < $count_item_offers_devices; $count_dev++)
                            {
                                $temp_item_offers_devices = $item_offers_xml->devices[$count_dev];
                                $temp_item_offers_devices = (array)$temp_item_offers_devices;
                                $temp_item_offers_devices = $temp_item_offers_devices[0];

                                $devices_array[$count_dev] = $temp_item_offers_devices;
                                //print_r($devices_array[$count_dev]);
                                //echo nl2br("\r\n");
                            }
                            asort($devices_array);
                            asort($value["GROUPS_ARTICLE"]);
                            $devicesStrXML = implode("; ", $devices_array);

                            $devicesStrSite = implode("; ", $value["GROUPS_ARTICLE"]);

                            // print_r("devicesStrXML: " .$devicesStrXML);
                            // echo nl2br("\r\n");

                            // print_r("devicesStrSite: " .$devicesStrSite);
                            // echo nl2br("\r\n");


                            if($devicesStrXML !== $devicesStrSite)
                            {
                                print_r("Wrong devices in : " . $item_article_in_xml );
                                echo nl2br("\r\n");
                                continue;
                            }
                            // print_r("Equal devices");
                        } 
                        else
                        {
                            print_r("Wrong devices in : " . $item_article_in_xml );
                            echo nl2br("\r\n");
                            continue;
                        }



                        /////////////////////<<group>>///////////////////////////
                        $group_in_xml = $item_offers_xml->group;
                        $group_in_xml = (array)$group_in_xml;
                        $group_in_xml = $group_in_xml[0];

                        if (trim($group_in_xml) == "СНЯТЫЕ С ПРОИЗВОДСТВА")
                        {
                            $group_var_production_status = "не производится"; //==94 in $arFields_res["DISCONTINUED"]
                            $group_var_production_status = IntVal(94);
                        } else
                        {
                            $group_var_production_status = "производится"; //==95 in $arFields_res["DISCONTINUED"]
                            $group_var_production_status = IntVal(95);
                        }

                        // print_r("group_var_production_status: " .$group_var_production_status);
                        // echo nl2br("\r\n");

                        // print_r("value['DISCONTINUED']: " .$value["DISCONTINUED"]);
                        // echo nl2br("\r\n");

                        if(IntVal($group_var_production_status) !== IntVal($value["DISCONTINUED"]))
                        {
                            print_r("Wrong DISCONTINUED in : " . $item_article_in_xml );
                            echo nl2br("\r\n");
                            continue;
                        }
                        // print_r("Equal DISCONTINUED");


                        /////////////////////<<instock>>///////////////////////////
                        // if ($this->xml_instock->xpath('//dataWs'))
                        // {
                        //     foreach ($this->xml_instock->xpath('//dataWs') as $item_instock)
                        //     {
                        //         $item_instock_article = $item_instock->article;
                        //         $item_instock_article = (array)$item_instock_article;
                        //         $item_instock_article = $item_instock_article[0];
      
                        //         if ($item_article_in_xml == $item_instock_article)
                        //         {
                        //             $instock_var = $item_instock->status;
                        //             $instock_var = (array)$instock_var;
                        //             $instock_var = $instock_var[0];
                        //             //AddMessage2Log("Товар с артикулом " . $article_var[0] . " поменЯл наличие на " . $instock_var[0], "FirstUpload");
                        //             //local break
                        //             break;
                        //         }
                        //     }
                        // }

                        // $instock_var = iconv("utf-8", "windows-1251", $instock_var);

                        // // print_r("instock_var: " . $instock_var);
                        // // echo nl2br("\r\n");

                        // // print_r("value['STORE']: " . $value["STORE"]);
                        // // echo nl2br("\r\n");

                        // if($instock_var !== $value["STORE"])
                        // {
                        //     print_r("Wrong STORE in : " . $item_article_in_xml );
                        //     echo nl2br("\r\n");
                        //     continue;
                        // }
                        // print_r("Equal instock");


                        /////////////////////<<name>>///////////////////////////
                        $name_in_xml = $item_offers_xml->name;
                        $name_in_xml = (array)$name_in_xml;
                        $name_in_xml = $name_in_xml[0];
                        if($name_in_xml !== $value["COMPATIBLE_MODEL"])
                        {
                            print_r("Wrong COMPATIBLE_MODEL in : " . $item_article_in_xml );
                            echo nl2br("\r\n");
                            continue;
                        }
                        // print_r("Equal name of battery");



                        /////////////////////<<originalCode>>///////////////////////////
                        $originalCode_0 = $item_offers_xml->originalCode;
                        $originalCode_0 = (array)$originalCode_0;
                        $originalCode_0 = $originalCode_0[0];
                 
                        if ($item_offers_xml->originalCode)
                        {
                            $originalCode_array = array();

                            $originalCode_var_0 = $item_offers_xml->originalCode;
                            $originalCode_var_0 = (array)$originalCode_var_0;
                            $originalCode_var_0 = $originalCode_var_0[0];
                            $originalCode_array[] = $originalCode_var_0;

                            $index_temp = 1;

                            while ( !empty($item_offers_xml->{"originalCode" . (string)$index_temp}) ) 
                            {
                               $originalCode_array[] = $item_offers_xml->{"originalCode" . (string)$index_temp};
                               $index_temp++;
                            }

                            $count_item_orig_code = $index_temp;


                            // print_r("count_item_orig_code: " . $count_item_orig_code);
                            // echo nl2br("\r\n");

                            // print_r("originalCode_array: " . $originalCode_array);
                            // echo nl2br("\r\n");
              
                            


                            // print_r("value['ORIGINAL_CODE']: " . $value["ORIGINAL_CODE"]);
                            // echo nl2br("\r\n");

                            $ORIGINAL_CODE_ARRAY = array();

                            $pieces = explode("; ", $value["ORIGINAL_CODE"]);

                            foreach($pieces as $piece)
                            {
                                $ORIGINAL_CODE_ARRAY[] = $piece;
                            }

                            asort($ORIGINAL_CODE_ARRAY);
                            $value["ORIGINAL_CODE"] = implode("; ", $ORIGINAL_CODE_ARRAY);

                            //asort($originalCode_array);//Doesn't work
                            //asort($originalCode_array);
                            $originalCodeStr_temp = implode("; ", $originalCode_array);

                            $ORIGINAL_CODE_ARRAY_FROM_originalCode_array  = array();

                            $pieces = explode("; ", $originalCodeStr_temp);

                            foreach($pieces as $piece)
                            {
                                $ORIGINAL_CODE_ARRAY_FROM_originalCode_array[] = $piece;
                            }
                            asort($ORIGINAL_CODE_ARRAY_FROM_originalCode_array);

                            $originalCodeStr = implode("; ", $ORIGINAL_CODE_ARRAY_FROM_originalCode_array);

                            

                            // print_r("originalCodeStr: " . $originalCodeStr);
                            // echo nl2br("\r\n");

                            // print_r("value['ORIGINAL_CODE']: " . $value["ORIGINAL_CODE"]);
                            // echo nl2br("\r\n");



                            if($originalCodeStr !== $value["ORIGINAL_CODE"])
                            {
                                print_r("Wrong ORIGINAL_CODE in : " . $item_article_in_xml );
                                echo nl2br("\r\n");
                                continue;
                            }
                            // print_r("Equal originalCode");
                        }
                        else
                        {
                            if($originalCode_0 !== $value["ORIGINAL_CODE"])
                            {
                                print_r("Wrong ORIGINAL_CODE in : " . $item_article_in_xml );
                                echo nl2br("\r\n");
                                continue;
                            }
                            // print_r("Equal originalCode");

                        }

                        /////////////////////<<packType>>///////////////////////////
                        //////////////<<NO THIS PROP ON SITE>>//////////////////////
                        /////////////////////<<packType>>///////////////////////////

                        /////////////////////<<power>>///////////////////////////
                        $power_in_xml = $item_offers_xml->power;
                        $power_in_xml = (array)$power_in_xml;
                        $power_in_xml = $power_in_xml[0];
                        if($power_in_xml !== $value["POWER"])
                        {
                            print_r("Wrong POWER in : " . $item_article_in_xml );
                            echo nl2br("\r\n");
                            continue;
                        }
                        // print_r("Equal power");


                        /////////////////////<<price>>///////////////////////////
                        // if ($this->xml_prices->xpath('//dataWs'))
                        // {
                        //     foreach ($this->xml_prices->xpath('//dataWs') as $item_prices)
                        //     {
                        //         $item_prices_article = $item_prices->article;
                        //         $item_prices_article = (array)$item_prices_article;
                        //         $item_prices_article = $item_prices_article[0];
                        //         //print_r($item_instock_article[0]);
                        //         //echo nl2br("\r\n");
                        //         //print_r($article_var[0]);
                        //         //echo nl2br("\r\n");
                        //         if ($item_article_in_xml == $item_prices_article)
                        //         {
                        //             $price_var = $item_prices->price;
                        //             $price_var = (array)$price_var;
                        //             $price_var = $price_var[0];
                        //             //local break                                  
                        //             break;
                        //         }
                        //     }
                        // }

                        // if($price_var !== $value["PRICE"])
                        // {
                        //     print_r("Wrong PRICE in : " . $item_article_in_xml );
                        //     echo nl2br("\r\n");
                        //     continue;
                        // }
                        // print_r("Equal price");


                        /////////////////////<<type>>///////////////////////////
                        $type_in_xml = $item_offers_xml->type;
                        $type_in_xml = (array)$type_in_xml;
                        $type_in_xml = $type_in_xml[0];

                        if ($type_in_xml == "Li-ion")
                        {
                            $type_in_xml = IntVal(90);
                        }
                        else if ($type_in_xml == "Li-Polymer")
                        {
                            $type_in_xml = IntVal(93); 
                        }
                        else if ($type_in_xml == "Ni-MH")
                        {
                            $type_in_xml = IntVal(91); 
                        }
                        else if ($type_in_xml == "Li-Polimer")
                        {
                            $type_in_xml = IntVal(92); 
                        }

                        // print_r("type_in_xml: " . $type_in_xml);
                        // echo nl2br("\r\n");

                        // print_r("value['TYPE']: " . $value["TYPE"]);
                        // echo nl2br("\r\n");

                        if(IntVal($type_in_xml) !== IntVal($value["TYPE"]))
                        {
                            print_r("Wrong type in : " . $item_article_in_xml );
                            echo nl2br("\r\n");
                            continue;
                        }
                        //print_r("Equal type");

                        

                        /////////////////////<<voltage>>///////////////////////////
                        $voltage_in_xml = $item_offers_xml->voltage;
                        $voltage_in_xml = (array)$voltage_in_xml;
                        $voltage_in_xml = $voltage_in_xml[0];
                        if($voltage_in_xml !== $value["VOLTAGE"])
                        {
                            print_r("Wrong voltage in : " . $item_article_in_xml );
                            echo nl2br("\r\n");
                            continue;
                        }
                        // print_r("Equal voltage");
        

                        $WasFound = TRUE;
                        // print_r("WasFound is TRUE");
                    }
                                      
                }

                if(!$WasFound)
                {
                    $DiffArrayOfArticles[] = $item_article_in_xml;
                }
                $index_dataWs++;
                // print_r("break");
                // echo nl2br("\r\n");
                // foreach($DiffArrayOfArticles as $key => $value)
                // {
                //     print_r("$key: " . $value);
                //     echo nl2br("\r\n");

                // }

                // break;  

                // print_r($index_dataWs);   

                // if ($index_dataWs > 1000)
                // {
                //     break;                 
                // }         
            }
        }
        return $DiffArrayOfArticles;

    }






}




?>