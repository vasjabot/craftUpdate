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
require_once(__DIR__.'/../Prototypes/ProtoUpdater.php');
require_once __DIR__.'/SimpleXLSX.php';
use PrototypesNS\ProtoGetterSite as ProtoGetterSite;
use PrototypesNS\ProtoUpdater as ProtoUpdater;



interface ProtoSorterInterface
{
    public function getProtoSortedArray($PathToXlsx);
    public function setAllSectionSorting($PathToXlsx);
}

abstract class AbstractProtoSorter implements ProtoSorterInterface
{
    protected $config;
    protected $protoUpdater;
    protected $XML_arr;

    public function __construct($Config, $XML_arr)
    {
        $this->config = $Config;
        $this->XML_arr = $XML_arr;
    }
}

class ProtoSorter extends AbstractProtoSorter
{
    public function getProtoSortedArray($PathToXlsx)
    {   
        $ProtoArray = array(); 

        if ($xlsx = SimpleXLSX::parse($PathToXlsx)) 
        {
            $rows = $xlsx->rows(3);
            $protoGetterSite = new ProtoGetterSite($this->config); 
            $allSection = $protoGetterSite->getArrayAllSection();



            $result_allSection = array();

            foreach ($allSection as $key => $value)
            {
                foreach ($value as $key_in => $value_in)
                {

                    if($key_in == "CODE") 
                    {
                        $value_in = str_replace('_', ' ', $value_in);
                        $value_in = str_replace('_', '.', $value_in);
                        $value_in = str_replace('_', '/', $value_in);

                        $result_allSection[] = $value_in;
                    }

                }         

            }  
                
            $return_array = array();

            foreach ($rows as $key => $value)
            {
                foreach ($result_allSection as $secItemCode)
                {

                    $pos = strpos($value[0], $secItemCode);

                    if ($pos === false) 
                    {
                        continue;
                       
                    } else 
                    {
                        if ($prev_value_1 == $value[1])
                        {
                            continue;
                        }
                        else
                        {
                            $return_array[$secItemCode] += $value[1];
                            $prev_value_1 = $value[1];
                            break;
                        }                                                  
                    }
                }               
            }

            if(1)
            {
                $return_array_m = array();
                foreach ($return_array as $key => $value)
                {
                    $key = str_replace(' ', '_', $key);
                    $key = str_replace('.', '_', $key);
                    $key = str_replace('/', '_', $key);

                    $return_array_m[$key] = $value;

                    // print_r($key);
                    // echo nl2br("\r\n");
                    // print_r($value);
                    // echo nl2br("\r\n");
                }

                //foreach ($return_array_m as $key => $value)
                //{                

                    //print_r($key);
                    //echo nl2br("\r\n");
                    //print_r($value);
                    //echo nl2br("\r\n");
                //}

            }    
            

            

        } else
        {
            echo SimpleXLSX::parseError();
        }

        if (0)
        {
            $results = print_r($return_array_m, true);
            $date  = date('Y-m-d H:i:s');
            $fileName = 'ProtoSort';
            $fileName = $fileName.'_'.$date;
            $path = $fileName.'.txt';
            $ret = file_put_contents($path, $results);
        }
       
        return $return_array;

    }


    public function setAllSectionSorting($PathToXlsx)
    {   
        $SortedArray = $this->getProtoSortedArray($PathToXlsx);

        $protoGetterSite = new ProtoGetterSite($this->config);

        foreach ($SortedArray as $key => $value)
        {       
            $key = str_replace(' ', '_', $key);
            $key = str_replace('.', '_', $key);
            $key = str_replace('/', '_', $key);

            $OneProtoArrayFromSite = $protoGetterSite->getProtoByBitrixCode($key);
            $protoUpdater = new ProtoUpdater($this->config, array(), $this->XML_arr["prototypes"], $this->XML_arr["compatibility"]); 
            $res = $this->protoUpdater->updateOldPrototypeFastForUpdatingSort($OneProtoArrayFromSite, $value);          
        }


    }

}




?>