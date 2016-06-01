<?php
/**
 * Created by PhpStorm.
 * User: zhaoshichen
 * Date: 6/2/16
 * Time: 12:19 AM
 */

require_once "../../test_connect_oms.php";

function receive_and_validate_file(){
    

    /**
     * the file format must be csv and we limit the file size to 2M
     */

    $mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
    if(in_array($_FILES['file']['type'],$mimes) && ($_FILES["file"]["size"] < 2000000)){
        if ($_FILES["file"]["error"] > 0)
        {
            echo "Error: " . $_FILES["file"]["error"] . "<br />";
        }
        else
        {
            // show_file_info();

            $contents= file_get_contents($_FILES['file']['tmp_name']);
            $items = treat_csv_content($contents);

            $m = new show_Message();

            // parse the result to array
            $result = $m->show_call_result("treat_item_codes_for_price_name",json_encode($items,TRUE));
            $result = json_decode($result);

            $header = array('item_code','name','cost');
            $file_name = "item_price_name".date('Y-m-d').".csv";

            header("Content-Type:application/csv");
            header("Content-Disposition:attachment;filename=".$file_name);
            $output = fopen("php://output",'w') or die("Can't open php://output");


            // pre-write the headers as the first line
            fputcsv($output, $header);

            foreach($result as $r){
                fputcsv($output, $r);
            }

            fclose($output) or die("Can't close php://output");
        }

    } else {
        echo "Invalid file";
    }
    
    return "";

    // var_dump($_FILES["file"]);
}

/**
 *
 */
function show_file_info(){
    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    echo "Stored in: " . $_FILES["file"]["tmp_name"];
}

/**
 * remove all the white space
 * @param $contentr
 */
function treat_csv_content($content){

    $string = str_replace(' ', '', $content);
    $string2 = preg_replace('/\s+/', '', $string);
    $string3 = trim($string2);

    /**
     * get all the item codes
     */
    $item_codes = explode(";",$string3);

        /**
         * pick only the valid item codes whose length > 3
         */
    $new_item_codes = array();
    foreach ( $item_codes as $item ){
        if(strlen($item) >= 1){
            array_push($new_item_codes,$item);
        }
    }

    return $new_item_codes;
}

receive_and_validate_file();

?>