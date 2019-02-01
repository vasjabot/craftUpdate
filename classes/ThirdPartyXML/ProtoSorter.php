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

            foreach ($return_array as $key => $value)
            {
                print_r($key);
                echo nl2br("\r\n");
                print_r($value);
                echo nl2br("\r\n");
            }

            

        } else
        {
            echo SimpleXLSX::parseError();
        }



    }
}




?>