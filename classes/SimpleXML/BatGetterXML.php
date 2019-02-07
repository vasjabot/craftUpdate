<?php 
/**
*-------------------------------------------------------------------------------
* BatGetterXML Class
*-------------------------------------------------------------------------------
* This is a class for curl requests execution.
* @package  SimpleXMLNS 
* @author   mixxxxx 
* @link     top-secret
*/

namespace SimpleXMLNS;


interface BatGetterXMLInterface
{
    public function getBatByArticle($Article);
}

abstract class AbstractBatGetterXML implements BatGetterXMLInterface
{
    protected $xml_offers;
    protected $config;

    public function __construct($Config, $xml_offers, $xml_prices, $xml_instock)
    {
         $this->config = $Config;
         $this->xml_offers = $xml_offers;
         $this->xml_prices = $xml_prices;
         $this->xml_instock = $xml_instock;
         
    }
}

class BatGetterXML extends AbstractBatGetterXML
{

    public function getBatByArticle($Article)
    {   
        $OneBatArray = array();

        if ($this->xml_offers->xpath('//dataWs'))
        {
            $index_dataWs = 0;
            $WasFound = FALSE;
            foreach ($this->xml_offers->xpath('//dataWs') as $item_bat_in_xml)
            {
                $item_bat_in_xml_article = $item_bat_in_xml->article; 
                //print_r($item_bat_in_xml_article);     
                $item_bat_in_xml_article = (array)$item_bat_in_xml_article;
                //print_r($item_bat_in_xml_article);
                $item_bat_in_xml_article = $item_bat_in_xml_article[0];
                //print_r($item_bat_in_xml_article);
                //echo nl2br("\r\n");
                

                if ($item_bat_in_xml_article == $Article)
                {
                    /////////////////////<<article>>///////////////////////////
                    $OneBatArray["ARTICLE"] = $item_bat_in_xml_article;

                    /////////////////////<<barcode>>///////////////////////////
                    $barcode_var = $item_bat_in_xml->barcode;
                    $barcode_var = (array)$barcode_var;
                    $barcode_var = $barcode_var[0];
                    $OneBatArray["EAN_13"] = $barcode_var;

                    ////////////////////<<batteryDescription>>///////////////////////////
                    $batteryDescription_var = $item_bat_in_xml->batteryDescription;
                    $batteryDescription_var = (array)$batteryDescription_var;
                    $batteryDescription_var = $batteryDescription_var[0];
                    $batteryDescription_var = iconv("utf-8", "windows-1251", $batteryDescription_var);
                    $OneBatArray["DETAIL_TEXT"] = $batteryDescription_var;

                    /////////////////////<<capacity>>///////////////////////////
                    $capacity_var = $item_bat_in_xml->capacity;
                    $capacity_var = (array)$capacity_var;
                    $capacity_var = $capacity_var[0];
                    $OneBatArray["CAPACITY"] = $capacity_var;

                    /////////////////////<<complect>>///////////////////////////
                    $complect_var = $item_bat_in_xml->complect;
                    $complect_var = (array)$complect_var;
                    $complect_var = trim($complect_var[0]);
                    $complect_var = iconv("utf-8", "windows-1251", $complect_var);
                    $OneBatArray["COMPLECT"] = $complect_var;

                    /////////////////////<<devices>>///////////////////////////
                    if ($item_bat_in_xml->devices)
                    {
                        $count_item_offers_devices = count($item_bat_in_xml->devices);
                        $devices_array = array();
                        for ($count_dev = 0; $count_dev < $count_item_offers_devices; $count_dev++)
                        {
                            $one_device = $item_bat_in_xml->devices[$count_dev];
                            $one_device = (array)$one_device;
                            $one_device = $one_device[0];

                            $devices_array[$count_dev] = $one_device;
                            //print_r($devices_array[$count_dev]);
                            //echo nl2br("\r\n");
                        }
                        asort($devices_array);
                        $devicesStrXML = implode("; ", $devices_array);
                        $OneBatArray["GROUPS_ARTICLE"] = $devicesStrXML;
                    } 
                    else
                    {
                        $OneBatArray["GROUPS_ARTICLE"] = '';
                    }

                    /////////////////////<<group>>///////////////////////////
                    $group_var = $item_bat_in_xml->group;
                    $group_var = (array)$group_var;
                    $group_var = $group_var[0];
                    if (trim($group_var) == "СНЯТЫЕ С ПРОИЗВОДСТВА")
                    {
                        $group_var = "не производится"; //==94 in $arFields_res["DISCONTINUED"]
                        $group_var = IntVal(94);
                    } else
                    {
                        $group_var = "производится"; //==95 in $arFields_res["DISCONTINUED"]
                        $group_var = IntVal(95);
                    }
                    $OneBatArray["DISCONTINUED"] = $group_var;


                    /////////////////////<<name>>///////////////////////////
                    $name_var = $item_bat_in_xml->name;
                    $name_var = (array)$name_var;
                    $name_var = $name_var[0];
                    $OneBatArray["COMPATIBLE_MODEL"] = $name_var;




                    /////////////////////<<originalCode>>///////////////////////////
                    $originalCode_0 = $item_bat_in_xml->originalCode;
                    $originalCode_0 = (array)$originalCode_0;
                    $originalCode_0 = $originalCode_0[0];


                    $originalCode_array = array();
                    $originalCode_array[] = $originalCode_0;

                    if ($item_bat_in_xml->originalCode)
                    {
                        $index_temp = 1;

                        while ( !empty($item_bat_in_xml->{"originalCode" . (string)$index_temp}) ) 
                        {
                           $originalCode_array[] = $item_bat_in_xml->{"originalCode" . (string)$index_temp};
                           $index_temp++;
                        }

                        $count_item_orig_code = $index_temp;


                        // print_r("count_item_orig_code: " . $count_item_orig_code);
                        // echo nl2br("\r\n");

                        // print_r("originalCode_array: " . $originalCode_array);
                        // echo nl2br("\r\n");

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

                        $OneBatArray["ORIGINAL_CODE"] = $originalCodeStr;
                    }
                    else
                    {
                        $originalCodeStr_temp = implode("; ", $originalCode_array);
                        $OneBatArray["ORIGINAL_CODE"] = $originalCodeStr_temp;

                    }


                    /////////////////////<<packType>>///////////////////////////
                    //////////////<<NO THIS PROP ON SITE>>//////////////////////
                    /////////////////////<<packType>>///////////////////////////



                    /////////////////////<<power>>///////////////////////////
                    $power_var = $item_bat_in_xml->power;
                    $power_var = (array)$power_var;
                    $power_var = $power_var[0];
                    $OneBatArray["POWER"] = $power_var;       




                    /////////////////////<<type>>///////////////////////////
                    $type_var = $item_bat_in_xml->type;
                    $type_var = (array)$type_var;
                    $type_var = $type_var[0];

                    if ($type_var == "Li-ion")
                    {
                        $type_var = IntVal(90);
                    }
                    else if ($type_var == "Li-Polymer")
                    {
                        $type_var = IntVal(93); 
                    }
                    else if ($type_var == "Ni-MH")
                    {
                        $type_var = IntVal(91); 
                    }
                    else if ($type_var == "Li-Polimer")
                    {
                        $type_var = IntVal(92); 
                    }
                    $OneBatArray["TYPE"] = $type_var;



                    /////////////////////<<voltage>>///////////////////////////
                    $voltage_var = $item_bat_in_xml->voltage;
                    $voltage_var = (array)$voltage_var;
                    $voltage_var = $voltage_var[0];
                    $OneBatArray["VOLTAGE"] = $voltage_var;


                    /////////////////////<<price>>///////////////////////////
                    print_r("from outside price dataWs");
                    echo nl2br("\r\n");
                    if ($this->xml_prices->xpath('//dataWs'))
                    {
                        print_r("from price dataWs");
                        echo nl2br("\r\n");
                        foreach ($this->xml_prices->xpath('//dataWs') as $item_prices)
                        {
                            $item_prices_article = $this->xml_prices->article;
                            $item_prices_article = (array)$item_prices_article;
                            $item_prices_article = $item_prices_article[0];
                            //print_r($item_instock_article[0]);
                            //echo nl2br("\r\n");
                            //print_r($article_var[0]);
                            //echo nl2br("\r\n");
                            if ($item_article_in_xml == $item_prices_article)
                            {
                                print_r("from price equal two articles");
                                echo nl2br("\r\n");
                                $price_var = $item_prices->price;
                                $price_var = (array)$price_var;
                                $price_var = $price_var[0];
                                $OneBatArray["PRICE"] = $price_var;
                                //local break                                  
                                break;
                            }
                            else
                            {
                                $OneBatArray["PRICE"] = NULL;
                            }
                        }
                        
                    }

                    /////////////////////<<instock>>///////////////////////////
                    if ($this->xml_instock->xpath('//dataWs'))
                    {
                        foreach ($this->xml_instock->xpath('//dataWs') as $item_instock)
                        {
                            $item_instock_article = $this->xml_instock->article;
                            $item_instock_article = (array)$item_instock_article;
                            $item_instock_article = $item_instock_article[0];
  
                            if ($item_article_in_xml == $item_instock_article)
                            {
                                $instock_var = $item_instock->status;
                                $instock_var = (array)$instock_var;
                                $instock_var = $instock_var[0];
                                $instock_var = iconv("utf-8", "windows-1251", $instock_var);
                                $OneBatArray["STORE"] = $instock_var;

                                if ($instock_var != "в наличии")
                                {
                                    $OneBatArray["SORT"] = (string)11000;
                                }
                                else
                                {
                                    $OneBatArray["SORT"] = (string)500;
                                }
                                

                                //local break
                                break;
                            }
                            else
                            {
                                $OneBatArray["STORE"] = NULL;
                            }
                        }
                    }



                    $WasFound = TRUE;
                    break;

                }

            }

            if($WasFound)
            {
                // print_r("returned array from getBatByArticle: " . $OneBatArray);
                // echo nl2br("\r\n");
                // foreach($OneBatArray as $key => $value)
                // {
                //     print_r("$key: " . $value);
                //     echo nl2br("\r\n");
                // }
                return $OneBatArray;
            }
            else
            {
                return NULL;
            }

                
        }
    }

}




?>