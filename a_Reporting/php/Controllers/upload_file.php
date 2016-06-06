<?php
/**
 * Created by PhpStorm.
 * User: zhaoshichen
 * Date: 6/2/16
 * Time: 12:19 AM
 */

require_once "../../test_connect_oms.php";

/**
 * Receive the CSV file and validate its format & size
 * @return bool|string whether the validation succeed or not
 */
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
            return treat_upload_csv_file();
        }

    } else {
        echo "Invalid file";
        return false;
    }
    
    return false;
}

/**
 * display the information of file in case of needs
 */
function show_file_info(){
    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    echo "Stored in: " . $_FILES["file"]["tmp_name"];
}

/**
 * @return bool
 */
function treat_upload_csv_file(){

    /**
     * a new array for item codes
     */
    $items = array();

    /**
     * open the file uploaded
     */
    if(!$fp = fopen($_FILES['file']['tmp_name'], 'r')) {
        return false;
    }
    else{

        /**
         * add the items line by line into the array
         */
        while($line = fgets($fp)){
            $string2 = preg_replace('/\s+/', '', $line);
            $string3 = trim($string2);

            // if it's valid string
            if(strlen($string3)>2)
                array_push($items,$string3);
        }

        // parse the result to array
        // and call the OMS API for the result given back
        $m = new show_Message();
        $result = $m->show_call_result("treat_item_codes_for_price_name",json_encode($items,TRUE));

        // decode the result
        $result = json_decode($result);

        // write the CSV file and provide it to user to download
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

        return true;
    }
}

receive_and_validate_file();

?>