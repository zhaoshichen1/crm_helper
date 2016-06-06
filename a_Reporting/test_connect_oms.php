<?php

/**
 * Chinese Time - UTF+8
 */
date_default_timezone_set("Asia/Shanghai");
/**
 * Display all the errors on the interface to help troubleshooting
 */
error_reporting(-1);
ini_set('display_errors','On');

/**
 * Class show_Message
 * used to call OMS API for information
 */
class show_Message
{
    private $url_host = "http://114.141.157.26/index.php";
    private $params="decathlon";
    private $admin = "180.169.58.154";
    private $password;

    public function show_call_result($order_msg,$parameters_for_API)
    {
        $message = $order_msg;

        $this->admin=$_SERVER['SERVER_ADMIN'];
        $this->password=$this->get_Password($this->params,$this->admin);

        $output = $this->callback_Data($this->url_host, $message, $this->password,$parameters_for_API);

        return $output;
    }

    /**
     * use CURL to call OMS API
     * @param $url_host API's url
     * @param $message my message
     * @param $password the password
     * @param $parameters_for_API
     * @return mixed
     */
    private function callback_Data($url_host, $message, $password, $parameters_for_API)
    {
        $url = $url_host;
        $post_data = array("message" => $message, "password" => $password, "parameters" => $parameters_for_API);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    /**
     * the password
     * @param $params the params
     * @param $ip my ip
     * @return string
     */
    private function get_Password($params,$ip){
        return $str= strtoupper(md5(strtoupper(md5(self::encryption($params))).$ip));
    }

    /**
     * encryption function
     * @param $params
     * @return null|string
     */
    private function encryption($params){
        if(!is_array($params))  return null;
        ksort($params, SORT_STRING);
        $sign = '';
        foreach($params AS $key=>$val){
            if(is_null($val))   continue;
            if(is_bool($val))   $val = ($val) ? 1 : 0;
            $sign .= $key . (is_array($val) ? self::encryption($val) : $val);
        }
        return $sign;
    }
}

