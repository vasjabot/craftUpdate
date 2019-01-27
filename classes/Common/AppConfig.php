<?php 
/**
*-------------------------------------------------------------------------------
* Config Class
*-------------------------------------------------------------------------------
* This is a simple class for config.
* @package  CommonNS 
* @author   mixxxxx 
* @link     top-secret
*/

namespace CommonNS;


interface ConfigInterface
{
    ///return $result_xml///
    public function extractCredentials();
    public function getURLbyFileName($FileName);
}

abstract class AbstractConfig implements ConfigInterface
{   
    public $auth_path_file;
    public $LOGIN;
    public $PWS;
    public $componentDIR;
    public $IBLOCK_ID;

    public $url_prototypes;
    public $url_offers;
    public $url_prices;
    public $url_instock;
    public $url_compatibility;

    public $TimeLastSync_prototypes;
    public $TimeLastSync_offers;
    public $TimeLastSync_prices;
    public $TimeLastSync_instock;

    public function __construct($TimeLastSync_prototypes=0, $TimeLastSync_offers=0, $TimeLastSync_prices=0, $TimeLastSync_instock=0)
    {
        $this->TimeLastSync_prototypes =$TimeLastSync_prototypes;
        $this->TimeLastSync_offers =$TimeLastSync_offers;
        $this->TimeLastSync_prices =$TimeLastSync_prices;
        $this->TimeLastSync_instock =$TimeLastSync_instock;


        $this->IBLOCK_ID = 12;
        $this->componentDIR = $_SERVER["DOCUMENT_ROOT"] . '/bitrix/components/esfull/craftUpdateFull/';
        $this->auth_path_file = $_SERVER["DOCUMENT_ROOT"] . '/bitrix/components/esfull/craftUpdateFull/AUTH.txt';
        $this->extractCredentials();
        $this->url_prototypes = "http://middle.craftmann.ru:8080/craftmiddle/ws/bitrixinfo/allDevices/" . $this->TimeLastSync_prototypes;
        $this->url_offers = "http://middle.craftmann.ru:8080/craftmiddle/ws/bitrixinfo/allBatteries/" . $this->TimeLastSync_offers;
        $this->url_prices = "http://middle.craftmann.ru:8080/craftmiddle/ws/bitrixinfo/allPrice/" . $this->TimeLastSync_prices;
        $this->url_instock = "http://middle.craftmann.ru:8080/craftmiddle/ws/bitrixinfo/allInStockInfo/" . $this->TimeLastSync_instock;
        $this->url_compatibility = "http://middle.craftmann.ru:8080/craftmiddle/ws/bitrixinfo/allCompatibilityByDevice/0";       
    }

}

class AppConfig extends AbstractConfig
{
    public function extractCredentials()
    {   
        $file_auth = fopen($this->auth_path_file, 'r');
        $fread_result_auth = fread($file_auth, filesize($this->auth_path_file));
        fclose($file_auth);
        $pieces = explode(";", $fread_result_auth);
        $this->LOGIN = $pieces[0];
        $this->PWS = $pieces[1];
    }

    public function getURLbyFileName($FileName)
    {
        if ($FileName == 'prototypes_work.xml')
        {
            return $this->url_prototypes;
        }
        elseif ($FileName == 'offers_work.xml')
        {
            return $this->url_offers;
        }
        elseif ($FileName == 'prices_work.xml')
        {
            return $this->url_prices;
        }
        elseif ($FileName == 'instock_work.xml')
        {
            return $this->url_instock;
        }
        elseif ($FileName == 'compatibility_work.xml')
        {
            return $this->url_compatibility;
        }
        else
        {
            return NULL;
        }

    }


}
/* @end config.php */
?>