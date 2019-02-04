<?php 
/**
*-------------------------------------------------------------------------------
* ProtoComparator Class
*-------------------------------------------------------------------------------
* This is a class for curl requests execution.
* @package  PrototypesNS 
* @author   mixxxxx 
* @link     top-secret
*/

namespace PrototypesNS;
use CommonNS\AppConfig as AppConfig;
require_once(__DIR__.'/../Common/AppConfig.php');

interface ProtoComparatorInterface
{
    public function getDiffArray();
}

abstract class AbstractProtoComparator implements ProtoComparatorInterface
{
    protected $config;
    protected $xml_prototypes;    
    protected $array_prototypes;

    public function __construct($Config, $xml_prototypes, $array_prototypes)
    {
         $this->config = $Config;
         $this->xml_prototypes = $xml_prototypes;
         $this->array_prototypes = $array_prototypes;
    }
}

class ProtoComparator extends AbstractProtoComparator
{

    public function getDiffArray()
    {   
        $DiffArrayOfArticles = array();

        if ($this->xml_prototypes->xpath('//dataWs'))
        {
            $index_dataWs = 0;
            foreach ($this->xml_prototypes->xpath('//dataWs') as $item_search_prototypes_in_xml)
            {
                $item_search_prototypes_article_in_xml = $item_search_prototypes_in_xml->article; 
                //print_r($item_search_prototypes_article_in_xml);     
                $item_search_prototypes_article_in_xml = (array)$item_search_prototypes_article_in_xml;
                //print_r($item_search_prototypes_article_in_xml);
                $item_search_prototypes_article_in_xml = $item_search_prototypes_article_in_xml[0];
                //print_r($item_search_prototypes_article_in_xml);
                //echo nl2br("\r\n");


                $WasFound = FALSE;

                foreach ($this->array_prototypes as $value )
                { 
                    $item_search_prototypes_article_in_array = $value["UF_ARTICLE"];

                    //print_r($item_search_prototypes_article_in_array);
                    //echo nl2br("\r\n");

                    if ($item_search_prototypes_article_in_array == $item_search_prototypes_article_in_xml)
                    {
                        // print_r("Equal articles");
                        // echo nl2br("\r\n");
                        // print_r($item_search_prototypes_article_in_xml);
                        // echo nl2br("\r\n");
                        // print_r($item_search_prototypes_article_in_array);
                        // echo nl2br("\r\n");

                        $batteryType_var = $item_search_prototypes_in_xml->batteryType;
                        $batteryType_var = (array)$batteryType_var;
                        $uf_batteryType = $batteryType_var[0];
                        if($uf_batteryType !== $value["UF_BATTERYTYPE"])
                        {
                            continue;
                        }
                        //print_r("Equal batteryType");

                        $devType_var = $item_search_prototypes_in_xml->devType;
                        $devType_var = (array)$devType_var;
                        $uf_devType = $devType_var[0];
                        if($uf_devType !== $value["UF_DEVTYPE"])
                        {
                            continue;
                        }
                        //print_r("Equal devType");
                       
                        // "Аккумулятор для NOKIA 3310" on site now, but NOKIA 3310 from CrafrMiddle
                        // $model_var = $item_search_prototypes_in_xml->model;
                        // $model_var = (array)$model_var;
                        // $model_var[0] = trim($model_var[0]);
                        // $model_var[0] = str_replace('+', 'plus', $model_var[0]);
                        // $uf_model = $model_var[0];
                        // if($uf_model !== $value["UF_MODEL"])
                        // {
                        //     continue;
                        // }


                        $prdDate_var = $item_search_prototypes_in_xml->prdDate;
                        $prdDate_var = (array)$prdDate_var;
                        $uf_prdDate = $prdDate_var[0];
                        if($uf_prdDate !== $value["UF_PRDDATE"])
                        {
                            continue;
                        }
                        //print_r("Equal prdDate");


                        $producer_var = $item_search_prototypes_in_xml->producer;
                        $producer_var = (array)$producer_var;
                        $producer_var[0] = trim($producer_var[0]);
                        $producer_var[0] = str_replace('+', 'plus', $producer_var[0]);
                        $uf_producer = $producer_var[0];
                        if($uf_producer !== $value["UF_PRODUCER"])
                        {
                            continue;
                        }
                        //print_r("Equal producer");

                        $str_len_producer = strlen($uf_producer);
                        $model_var = $item_search_prototypes_in_xml->model;
                        $model_var = (array)$model_var;
                        $model_var[0] = trim($model_var[0]);
                        $model_var[0] = str_replace('+', 'plus', $model_var[0]);
                        $uf_model = $model_var[0];
                        $str_len_model = strlen($uf_model);
                        $modified_model_var = substr($uf_model, $str_len_producer, $str_len_model);
                        $modified_model_var = trim($modified_model_var);
                        $modified_model_var = str_replace('plus', '+', $modified_model_var);//very important features from old update.php
                        $uf_name = $modified_model_var;
                        if($uf_name !== $value["NAME"])
                        {
                            continue;
                        }
                        //print_r("Equal name");

                        $WasFound = TRUE;
                        //print_r("WasFound is TRUE");
                    }                     
                }

                if(!$WasFound)
                {
                    $DiffArrayOfArticles[] = $item_search_prototypes_article_in_xml;
                }
                $index_dataWs++;            
            }
        }
        return $DiffArrayOfArticles;

    }






}




?>