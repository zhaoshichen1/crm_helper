<?php
/**
 * Created by PhpStorm.
 * User: SZHAO
 * Date: 4/6/2016
 * Time: 6:41 PM
 */

include "../DB_Managers/MySQL_Manager.php";

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

function new_records_or_increment($db){

    if((isset($_GET['func_id']))&&(isset($_GET['current_date']))){

        $fid = $_GET['func_id'];
        $c_date = $_GET['current_date'];

        $mysqlDB = new MySQL_Manager($db->host,$db->user,$db->password,$db->port,$db->dbname);

        $result = $mysqlDB->queryMultiple("select * from nb_execution where func_id = ".$fid." and date_exec = '".$c_date."'");

        /**
         * no record, need to insert a new one with the number of execution = 1
         */
        if(sizeof($result)==0){
            $result = $mysqlDB->queryUpdate("insert into nb_execution (func_id,date_exec,nb) values (".
                $fid.
                ",'".
                $c_date.
                "',1".
                ");");

            echo "new record generated";
        }
        else{

            /**
             * there is a record, so we just increment it
             */
            if(sizeof($result)==1){
                $result = $mysqlDB->queryUpdate("update nb_execution set nb = nb+1 where func_id = ".
                $fid.
                " and date_exec = '".
                $c_date.
                "';");

                echo "increment existing record";
            }

            /**
             * more than one line, error??
             */
            else{
                echo "error when doing the record";
            }
        }

    }


}

new_records_or_increment($MySqlDB);