<?php 
/**
*-------------------------------------------------------------------------------
* CurlRequestor Class
*-------------------------------------------------------------------------------
* This is a class for curl requests execution.
* @package  CurlNS 
* @author   mixxxxx 
* @link     top-secret
*/

namespace CurlNS;

interface CurlRequestorInterface
{
    ///return $result_xml///
    public function getData($CurlUrl);
}

abstract class AbstractCurlRequestor implements CurlRequestorInterface
{
    protected $login;
    protected $password;

    public function __construct($Login, $Password)
    {
        $this->login = $Login;
        $this->password = $Password;
    }
}

class CurlRequestor extends AbstractCurlRequestor
{
    public function getData($CurlUrl)
    {
        $ch_func = curl_init();
        curl_setopt($ch_func, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch_func, CURLOPT_URL, $CurlUrl);
        curl_setopt($ch_func, CURLOPT_USERPWD, "$this->login:$this->password");
        $result_func = curl_exec($ch_func);
        curl_close($ch_func);
        if (!$result_func) exit(1);
        return $result_func;
    }
}




?>

