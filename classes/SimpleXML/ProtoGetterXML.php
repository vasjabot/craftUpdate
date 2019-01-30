<?php 
/**
*-------------------------------------------------------------------------------
* ProtoGetter Class
*-------------------------------------------------------------------------------
* This is a class for curl requests execution.
* @package  PrototypesNS 
* @author   mixxxxx 
* @link     top-secret
*/

namespace SimpleXMLNS;


interface ProtoGetterXMLInterface
{
    public function getProtoByArticle($Article);
}

abstract class AbstractProtoGetterXML implements ProtoGetterXMLInterface
{
    protected $xml_prototypes;
    protected $config;

    public function __construct($Config, $xml_prototypes)
    {
         $this->config = $Config;
         $this->xml_prototypes = $xml_prototypes;
         
    }
}

class ProtoGetterXML extends AbstractProtoGetterXML
{

    public function getProtoByArticle($Article)
    {   
        $OneProtoArray = array();

        if ($this->xml_prototypes->xpath('//dataWs'))
        {
            $index_dataWs = 0;
            $WasFound = FALSE;
            foreach ($this->xml_prototypes->xpath('//dataWs') as $item_search_prototypes_in_xml)
            {
                $item_search_prototypes_article_in_xml = $item_search_prototypes_in_xml->article; 
                //print_r($item_search_prototypes_article_in_xml);     
                $item_search_prototypes_article_in_xml = (array)$item_search_prototypes_article_in_xml;
                //print_r($item_search_prototypes_article_in_xml);
                $item_search_prototypes_article_in_xml = $item_search_prototypes_article_in_xml[0];
                //print_r($item_search_prototypes_article_in_xml);
                //echo nl2br("\r\n");
                

                if ($item_search_prototypes_article_in_xml == $Article)
                {
                    $OneProtoArray["UF_ARTICLE"] = $item_search_prototypes_article_in_xml;

                    $batteryType_var = $item_search_prototypes_in_xml->batteryType;
                    $batteryType_var = (array)$batteryType_var;
                    $uf_batteryType = $batteryType_var[0];
                    $OneProtoArray["UF_BATTERYTYPE"] = $uf_batteryType;

                    $devType_var = $item_search_prototypes_in_xml->devType;
                    $devType_var = (array)$devType_var;
                    $uf_devType = $devType_var[0];
                    $OneProtoArray["UF_DEVTYPE"] = $uf_devType;

                    $prdDate_var = $item_search_prototypes_in_xml->prdDate;
                    $prdDate_var = (array)$prdDate_var;
                    $uf_prdDate = $prdDate_var[0];
                    $OneProtoArray["UF_PRDDATE"] = $uf_prdDate;

                    $producer_var = $item_search_prototypes_in_xml->producer;
                    $producer_var = (array)$producer_var;
                    $producer_var[0] = trim($producer_var[0]);
                    $producer_var[0] = str_replace('+', 'plus', $producer_var[0]);
                    $uf_producer = $producer_var[0];
                    $OneProtoArray["UF_PRODUCER"] = $uf_producer;

                    $str_len_producer = strlen($uf_producer);
                    $model_var = $item_search_prototypes_in_xml->model;
                    $model_var = (array)$model_var;
                    $model_var[0] = trim($model_var[0]);
                    $model_var[0] = str_replace('+', 'plus', $model_var[0]);
                    $uf_model = $model_var[0];
                    $OneProtoArray["UF_MODEL"] = $uf_model;
                    $str_len_model = strlen($uf_model);
                    $modified_model_var = substr($uf_model, $str_len_producer, $str_len_model);
                    $modified_model_var = trim($modified_model_var);
                    $modified_model_var = str_replace('plus', '+', $modified_model_var);//very important features from old update.php
                    $uf_name = $modified_model_var;
                    $OneProtoArray["NAME"] = $uf_name;

                    $WasFound = TRUE;
                    break;

                }

            }

            if($WasFound)
            {
                return $OneProtoArray;
            }
            else
            {
                return NULL;
            }

                
        }
    }

}




?>