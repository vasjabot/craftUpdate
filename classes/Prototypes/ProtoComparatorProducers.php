<?php 
/**
*-------------------------------------------------------------------------------
* ProtoComparatorProducers Class
*-------------------------------------------------------------------------------
* This is a class for curl requests execution.
* @package  PrototypesNS 
* @author   mixxxxx 
* @link     top-secret
*/

namespace PrototypesNS;
//use CommonNS\AppConfig as AppConfig;
//require_once(__DIR__.'/../Common/AppConfig.php');

interface ProtoComparatorProducersInterface
{
    public function getDiffArray();
}

abstract class AbstractProtoComparatorProducers implements ProtoComparatorProducersInterface
{
    protected $xml_prototypes;
    protected $config;
    protected $array_prototypes;

    public function __construct($Config, $xml_prototypes, $array_prototypes)
    {
         $this->config = $Config;
         $this->xml_prototypes = $xml_prototypes;
         $this->array_prototypes = $array_prototypes;
    }
}

class ProtoComparatorProducers extends AbstractProtoComparatorProducers
{

    public function getDiffArray()
    {   
        $DiffArrayOfProducers = array();

        if ($this->xml_prototypes->xpath('//dataWs'))
        {
            $index_dataWs = 0;
            foreach ($this->xml_prototypes->xpath('//dataWs') as $itemXMLObj)
            {
                $producer_var = $itemXMLObj->producer;
                $producer_var = (array)$producer_var;
                $producer_var[0] = trim($producer_var[0]);
                $producer_var[0] = str_replace('+', 'plus', $producer_var[0]);
                $producer = $producer_var[0];
                //print_r($producer);
                //echo nl2br("\r\n");


                $WasFound = FALSE;

                foreach ($this->array_prototypes as $value )
                { 
                    $item_search_prototypes_name_in_array = $value["NAME"];

                    //print_r($item_search_prototypes_name_in_array);
                    //echo nl2br("\r\n");

                    if ($item_search_prototypes_name_in_array == $producer)
                    {
                        // print_r("Equal producer");
                        // echo nl2br("\r\n");
                        // print_r($producer);
                        // echo nl2br("\r\n");
                        // print_r($item_search_prototypes_name_in_array);
                        // echo nl2br("\r\n");

                        
                        $bitrix_code = $producer;
                        $bitrix_code = mb_strtolower($bitrix_code);
                        $bitrix_code = str_replace(' ', '_', $bitrix_code);
                        $bitrix_code = str_replace('.', '_', $bitrix_code);
                        if($bitrix_code !== $value["CODE"])
                        {
                            continue;
                        }
                        //print_r("Equal bitrix_code");
                        

                        $WasFound = TRUE;
                        //print_r("WasFound is TRUE");
                    }                     
                }

                if(!$WasFound)
                {
                    $DiffArrayOfProducers[] = $producer;
                }
                $index_dataWs++;            
            }
        }
        return $DiffArrayOfProducers;

    }






}




?>