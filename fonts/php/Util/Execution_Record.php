<?php


include '../DB_Managers/MySQL_Manager.php';
/**
 * Created by PhpStorm.
 * User: zhaoshichen
 * Date: 3/29/16
 * Time: 1:15 AM
 */

@ini_set('display_errors', 'on');

/**
 * Chinese Time - UTF+8
 */
date_default_timezone_set("Asia/Hong_Kong");

$MySqlDB = new stdClass();
$MySqlDB->host = 'localhost';
$MySqlDB->user = 'root';
$MySqlDB->password = '19900930';
$MySqlDB->port = 3306;
$MySqlDB->dbname = 'testDB';


/**
 * record one execution in the DB to help the statistic
 * @param $function_name
// */
//function record_this_execution( $function_name ){
//
//    /**
//     * get the func_id
//     */
//    $func_id = functionality_id[$function_name];
//
//    /**
//     * get the current date - CN TimeZone
//     */
//
//    /**
//     * insert into the table
//     */
//
//}

//$mysqlDB = new MySQL_Manager($MySqlDB->host,$MySqlDB->user,$MySqlDB->password,$MySqlDB->port,$MySqlDB->dbname);
//var_dump($mysqlDB->queryMultiple("select * from pages"));


