<?php
/**
 * Created by PhpStorm.
 * User: SZHAO
 * Date: 4/6/2016
 * Time: 6:41 PM
 */

include "../DB_Managers/MySQL_Manager.php";
include "../Models/Page.php";
include "../Models/Functionality_record.php";
include_once  '../Util/Tool.php';

$MySqlDB = new stdClass();
$MySqlDB->host = 'localhost';
$MySqlDB->user = 'root';
$MySqlDB->password = '19900930';
$MySqlDB->port = 3306;
$MySqlDB->dbname = 'testDB';

/**
 * Chinese Time - UTF+8
 */
date_default_timezone_set("Asia/Hong_Kong");

/**
 * Display all the errors on the interface to help troubleshooting
 */
error_reporting(-1);
ini_set('display_errors', 'On');

/**
 * @param $db
 */
function get_page($db){

    if(isset($_GET['key_page'])){
        $test = new Page(1,"Loyalty");
        $mysqlDB = new MySQL_Manager($db->host,$db->user,$db->password,$db->port,$db->dbname);
        $test->list_all_inside_DB($mysqlDB);
    }

    if((isset($_POST['page_id']))&&(isset($_POST['page_name']))){
        $pid = $_POST['page_id'];
        $pname = $_POST['page_name'];

        $testPage = new Page($pid,"empty");
        $mysqlDB = new MySQL_Manager($db->host,$db->user,$db->password,$db->port,$db->dbname);

        // check if the id exists, otherwise the operation will be failed
        if($testPage->is_this_id_existing_in_DB($mysqlDB)){
            $testPage->change_my_name($mysqlDB,$pname);
        }
        else{
            echo "update failed because of PID not existing";
        }

    }
}

/**
 * @param $db
 */
function get_functionality($db){

    if(isset($_GET['key_func'])){
        $test = new Functionality_reocrd(500001,1,"loyalty_subscription_check");
        $mysqlDB = new MySQL_Manager($db->host,$db->user,$db->password,$db->port,$db->dbname);
        $test->list_all_inside_DB($mysqlDB);
    }

    if((isset($_POST['func_id']))&&(isset($_POST['func_name']))){
        $fid = $_POST['func_id'];
        $fname = $_POST['func_name'];

        // just create a fake as the change name just verifies the func_id
        $testFunc = new Functionality_reocrd($fid,0,"empty");
        $mysqlDB = new MySQL_Manager($db->host,$db->user,$db->password,$db->port,$db->dbname);

        // check if the id exists, otherwise the operation will be failed
        if($testFunc->is_this_id_existing_in_DB($mysqlDB)){
            $testFunc->change_my_name($mysqlDB,$fname);
        }
        else{
            echo "update failed because of Func_id not existing";
        }

    }

}

///**
// * @param $db
// */
//function get_records($db){
//
//    /**
//     * display all the records of execution
//     */
//    if(isset($_GET['key_record'])){
//        $mysqlDB = new MySQL_Manager($db->host,$db->user,$db->password,$db->port,$db->dbname);
//        $result = $mysqlDB->queryMultiple("select * from nb_execution;");
//
//        /**
//         * output the result in JSON format
//         */
//        print json_encode($result);
//
//    }
//
//}

// list all the page to the front office
get_page($MySqlDB);

// list all the functionalities
get_functionality($MySqlDB);
