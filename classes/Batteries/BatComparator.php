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
                        print_r("Equal articles");
                        echo nl2br("\r\n");
                        print_r($item_article_in_xml);
                        echo nl2br("\r\n");
                        print_r($item_article_in_array);
                        echo nl2br("\r\n");

                        $barcode_in_xml = $item_offers_xml->barcode;
                        $barcode_in_xml = (array)$barcode_in_xml;
                        $barcode_in_xml = $barcode_in_xml[0];
                        if($barcode_in_xml !== $value["EAN_13"])
                        {
                            continue;
                        }
                        print_r("Equal barcode");


                        /////////////////////<<batteryDescription>>///////////////////////////
                        $batteryDescription_in_xml = $item_offers_xml->batteryDescription;
                        $batteryDescription_in_xml = (array)$batteryDescription_in_xml;
                        $batteryDescription_in_xml = $batteryDescription_in_xml[0];
                        //if (isset($item_offers_xml->batteryDescription))

                        print_r("batteryDescription_in_xml: " . $batteryDescription_in_xml);
                        echo nl2br("\r\n");
                        //if(1)
                        if($batteryDescription_in_xml !== '')
                        {
                            print_r("batteryDescription_in_xml: " .$batteryDescription_in_xml);
                            echo nl2br("\r\n");
                            print_r("DETAIL_TEXT: " .$value["DETAIL_TEXT"]);
                            echo nl2br("\r\n");

                            if(empty($batteryDescription_in_xml))
                            {
                                print_r("batteryDescription_in_xml is empty ");
                                echo nl2br("\r\n");
                                $batteryDescription_in_xml = '';
                            }
                            if(empty($value["DETAIL_TEXT"]))
                            {
                                print_r("value['DETAIL_TEXT'] is empty ");
                                echo nl2br("\r\n");
                                $value["DETAIL_TEXT"] = '';
                            }
                            if($batteryDescription_in_xml !== $value["DETAIL_TEXT"])
                            {
                                continue;
                            }
                        }
                        print_r("Equal batteryDescription");
                       
                        /////////////////////<<capacity>>///////////////////////////
                        $capacity_in_xml = $item_offers_xml->prdDate;
                        $capacity_in_xml = (array)$capacity_in_xml;
                        $capacity_in_xml = $capacity_in_xml[0];
                        if($capacity_in_xml !== $value["CAPACITY"])
                        {
                            continue;
                        }
                        print_r("Equal capacity");

                        /////////////////////<<complect>>///////////////////////////
                        $complect_in_xml = $item_offers_xml->complect;
                        $complect_in_xml = (array)$complect_in_xml;
                        $complect_in_xml = $complect_in_xml[0];
                        if($complect_in_xml !== $value["COMPLECT"])
                        {
                            continue;
                        }
                        print_r("Equal complect");



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
                            $devicesStrXML = implode("; ", $devices_array);

                            $devicesStrSite = implode("; ", $value["GROUPS_ARTICLE"]);

                            if($devicesStrXML !== $devicesStrSite)
                            {
                                continue;
                            }
                            print_r("Equal devices");
                        } 
                        else
                        {
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

                        if($group_var_production_status !== $value["DISCONTINUED"])
                        {
                            continue;
                        }
                        print_r("Equal DISCONTINUED");


                        /////////////////////<<instock>>///////////////////////////
                        if ($this->xml_instock->xpath('//dataWs'))
                        {
                            foreach ($this->xml_instock->xpath('//dataWs') as $item_instock)
                            {
                                $item_instock_article = $item_instock->article;
                                $item_instock_article = (array)$item_instock_article;
                                $item_instock_article = $item_instock_article[0];
      
                                if ($item_article_in_xml == $item_instock_article)
                                {
                                    $instock_var = $item_instock->status;
                                    $instock_var = (array)$instock_var;
                                    $instock_var = $instock_var[0];
                                    //AddMessage2Log("Товар с артикулом " . $article_var[0] . " поменЯл наличие на " . $instock_var[0], "FirstUpload");
                                    //local break
                                    break;
                                }
                            }
                        }


                        if($instock_var !== $value["STORE"])
                        {
                            continue;
                        }
                        print_r("Equal instock");


                        /////////////////////<<name>>///////////////////////////
                        $name_in_xml = $item_offers_xml->name;
                        $name_in_xml = (array)$name_in_xml;
                        $name_in_xml = $name_in_xml[0];
                        if($name_in_xml !== $value["COMPATIBLE_MODEL"])
                        {
                            continue;
                        }
                        print_r("Equal name of battery not article. COMPATIBLE_MODEL");



                        /////////////////////<<originalCode>>///////////////////////////
                        $originalCode_0 = $item_offers->originalCode;
                        $originalCode_0 = (array)$originalCode_0;
                        $originalCode_0 = $originalCode_0[0];
                        $index_temp = 1;
                        if ( !empty($item_offers_xml->{"originalCode" . (string)$index_temp}) )
                        {
                            $originalCode_array = array();
                            while ( !empty($item_offers_xml->{"originalCode" . (string)$index_temp}) ) 
                            {
                               $originalCode_array[$index_temp] = $item_offers->{"originalCode" . (string)$index_temp};
                               $index_temp++;
                            }

                            $originalCodeStr = implode("; ", $originalCode_array);

                            if($originalCodeStr !== $value["ORIGINAL_CODE"])
                            {
                                continue;
                            }
                            print_r("Equal originalCode");
                        }
                        else
                        {
                            if($originalCode_0 !== $value["ORIGINAL_CODE"])
                            {
                                continue;
                            }
                            print_r("Equal originalCode");

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
                            continue;
                        }
                        print_r("Equal power");


                        /////////////////////<<price>>///////////////////////////
                        if ($this->xml_prices->xpath('//dataWs'))
                        {
                            foreach ($this->xml_prices->xpath('//dataWs') as $item_prices)
                            {
                                $item_prices_article = $item_prices->article;
                                $item_prices_article = (array)$item_prices_article;
                                $item_prices_article = $item_prices_article[0];
                                //print_r($item_instock_article[0]);
                                //echo nl2br("\r\n");
                                //print_r($article_var[0]);
                                //echo nl2br("\r\n");
                                if ($item_article_in_xml == $item_prices_article)
                                {
                                    $price_var = $item_prices->price;
                                    $price_var = (array)$price_var;
                                    $price_var = $price_var[0];
                                    //local break                                  
                                    break;
                                }
                            }
                        }

                        if($price_var !== $value["PRICE"])
                        {
                            continue;
                        }
                        print_r("Equal price");


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

                        if($type_in_xml !== $value["TYPE"])
                        {
                            continue;
                        }
                        print_r("Equal type");


                        /////////////////////<<voltage>>///////////////////////////
                        $voltage_in_xml = $item_offers_xml->voltage;
                        $voltage_in_xml = (array)$voltage_in_xml;
                        $voltage_in_xml = $voltage_in_xml[0];
                        if($voltage_in_xml !== $value["VOLTAGE"])
                        {
                            continue;
                        }
                        print_r("Equal voltage");
        






                        $WasFound = TRUE;
                        print_r("WasFound is TRUE");
                    }                     
                }

                if(!$WasFound)
                {
                    $DiffArrayOfArticles[] = $item_search_prototypes_article_in_xml;
                }
                $index_dataWs++;

                print_r($index_dataWs);   

                if ($index_dataWs > 100)
                {
                    break;                 
                }         
            }
        }
        return $DiffArrayOfArticles;

    }






}




?>