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
class Config 
{   
    public $auth_path_file;
    public $LOGIN;
    public $PWS;

    public function __construct()
    {
        $this->auth_path_file = $_SERVER["DOCUMENT_ROOT"] . '/bitrix/components/esfull/crafrUpdateFull/AUTH.txt';
        $this->extract_credentials();
        
    }


    public  function extract_credentials()
    {   
        $file_auth = fopen($this->auth_path_file, 'r');
        $fread_result_auth = fread($file_auth, filesize($this->auth_path_file));
        fclose($file_auth);
        $pieces = explode(";", $fread_result_auth);
        $this->LOGIN = $pieces[0];
        $this->PWS = $pieces[1];
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