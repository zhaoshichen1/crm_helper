<?php
/**
 * Created by PhpStorm.
 * User: SZHAO
 * Date: 4/6/2016
 * Time: 6:41 PM
 */

include "../DB_Managers/MySQL_Manager.php";
include "../Models/Page.php";

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

function get_page($db){

    if(isset($_GET['key_page'])){
        $test = new Page(1,"Loyalty");
        $mysqlDB = new MySQL_Manager($db->host,$db->user,$db->password,$db->port,$db->dbname);
        $test->list_all_inside_DB($mysqlDB);
    }


}

// list all the page to the front office
get_page($MySqlDB);