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

class show_Message
{
    private $url_host = "http://114.141.157.26/index.php";
    private $params="decathlon";
    private $admin = "180.169.58.154";
    private $password;
    private $message_Array = array("check_inorder", "inventory_apply", "syn_barcode", "check_order_buffer", "check_order_processed");
    private $check_Item_Array = array("Inorder generate status", "After Sales confirmation status", "Synchronization barcode", "Order buffer count", "Order processed count");
    private $str;
    private $message;
    private $test;
    public function table_Head(){
        $this->str = "<table border='1' align='center' cellspacing='0' width='875px'><caption><b>Daily Check Report<b></b></caption>" .
            "<tr><td colspan='3' align='center'>Date:".date('m/d/Y')."</td></tr>" .
            "<tr><th class='content'>content</th><th class='result'>result</th><th class='comment'>comment</th></tr>";
    }

    public function show_call_result($order_msg,$parameters_for_API)
    {
        // $this->table_Head();

            $message = $order_msg;

            $this->admin=$_SERVER['SERVER_ADMIN'];

            $this->password=$this->get_Password($this->params,$this->admin);

            $output = $this->callback_Data($this->url_host, $message, $this->password,$parameters_for_API);

        return $output;
        //          $output=rtrim(ltrim($output,'['),']');
//            $output_Arr = explode(',',$output);//String to Array
//            $checkItem = $this->check_Item_Array[$i];
//
//            if ($output_Arr[0]==NULL) {
//                $passStatus = "pass";
//                $output=implode(',',$output_Arr);
//            } else {
//                $passStatus = "nopass";
//                $output='['.implode(',',$output_Arr).']';
//            }
//            $this->str .= $this->get_Str($output, $checkItem, $passStatus);
//
//        $this->str .= "</table>";
//        echo $this->str;
    }

    private function get_Str($output, $checkItem, $passStatus)
    {
        return "<tr><th>" . $checkItem . "</th><td>" . $passStatus . "</td><td>" . $output . "</td></tr>";
    }

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
    private function get_Password($params,$ip){
        return $str= strtoupper(md5(strtoupper(md5(self::encryption($params))).$ip));
    }
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

