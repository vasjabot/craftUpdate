<?php 
/**
*-------------------------------------------------------------------------------
* Config Class
*-------------------------------------------------------------------------------
* This is a simple class for config.
* @package 	CommonNS 
* @author 	mixxxxx 
* @link 	top-secret
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
    public $url_prototypes;
    public $url_offers;

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


    public function getFuckingThisName($FileName)
    {
        return $FileName;
    }

    public function extractCredentials()
    {   
        $file_auth = fopen($this->auth_path_file, 'r');
        $fread_result_auth = fread($file_auth, filesize($this->auth_path_file));
        fclose($file_auth);
        $pieces = explode(";", $fread_result_auth);
        $this->LOGIN = $pieces[0];
        $this->PWS = $pieces[1];
    }

    public function getURLbyName($FileName)
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






    /**
     * Stack of items with options.
     * @var array
     */
    private static $_items = array();
    /**
     * Method to set a config item.
     * 
     * @param string $name  Name of item
     * @param mixed  $value Value of item
     */
    public static function setItem($name, $value){
        self::$_items[$name] = $value;
    }
    /**
     * Method to get an option item.
     * 
     * @param  string $name Name of item
     * @return mixed        Value of item
     */
    public static function getItem($name){
        return self::has($name) ? $self::$_items[$name] : null;
    }
    /**
     * Conditional method to confirm the existence of an item.
     * 
     * @param  string  $item Name of item
     * @return boolean       If exists or not
     */
    public static function has($item){
        return array_key_exists($item, self::$_items);
    }
    /**
     * Conditional method to check if stack is empty.
     * 
     * @return boolean
     */
    public static function isEmpty(){
        return empty(self::$_items);
    }
    /**
     * Reset a item from stack.
     * 
     * @param  string $name Name of option
     * @return void       
     */
    public static function reset($name){
        //self::has($name) ? unset(self::$_items[$name] : '';
    }
    /**
     * Reset stack;
     * 
     * @return void
     */
    public static function clean(){
       self::$_items = array();
    }
    /**
     * Is this explicity?
     * 
     * @param  string $name 
     * @return mixed       
     */
    public static function fetchItem($name){
    
    }
    /**
     * Same thing conditional no so explicity?
     * 
     * @param  string $name 
     * @return boolean      
     */
    public static function checkConfig($name){
    }
}
/* @end config.php */
?>