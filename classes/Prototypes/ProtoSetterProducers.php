<?php 
/**
*-------------------------------------------------------------------------------
* ProtoSetterProducers Class
*-------------------------------------------------------------------------------
* This is a class for curl requests execution.
* @package  PrototypesNS 
* @author   mixxxxx 
* @link     top-secret
*/

namespace PrototypesNS;


interface ProtoSetterProducersInterface
{
    public function setAllDiffArray();
    public function setNewFirstDepthLevelSection();
    public function updateOldFirstDepthLevelSection();
}

abstract class AbstractProtoSetterProducers implements ProtoSetterProducersInterface
{
    protected $config;
    protected $protoGetter;
    protected $diff_array_prototypes;

    public function __construct($Config, $ProtoGetter, $diff_array_prototypes)
    {
         $this->config = $Config;
         $this->protoGetter = $ProtoGetter;
         $this->diff_array_prototypes = $diff_array_prototypes;
    }
}

class ProtoComparatorProducers extends AbstractProtoComparatorProducers
{

    public function setAllDiffArray()
    {   
        
        foreach($this->diff_array_prototypes as $key => $value)
        {
            //print_php($key);
            //print_php($value);
            foreach($value as $key_in => $value_in)
            {
                if ($key_in == "UF_ARTICLE")
                {
                    //print_php($key_in);
                    //print_php($value_in);
                    $OneProtoArrayFromXml = $this->protoGetter->getProtoByArticle($value_in);
                    print_php("mass from xml:");
                    print_php($OneProtoArrayFromXml);
                    print_php("mass from site:");
                    print_php($value);
                    if ($OneProtoArrayFromXml!==NULL)
                    {
                        //$this->updateOldFirstDepthLevelSection();
                    }
                    else
                    {
                        throw new Exception("ProtoGetter Error", 1); 
                        //$this->setNewFirstDepthLevelSection();   
                    }
                }
            }
            //break;
        }
    }
}




?>