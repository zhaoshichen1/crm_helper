<?php
/**
 * Created by PhpStorm.
 * User: SZHAO
 * Date: 4/1/2016
 * Time: 1:34 PM
 */

$MySqlDB = new stdClass();
$MySqlDB->host = 'localhost';
$MySqlDB->user = 'root';
$MySqlDB->password = '19900930';
$MySqlDB->port = 3306;
$MySqlDB->dbname = 'testDB';
$mysqlDB = new MySQL_Manager($MySqlDB->host,$MySqlDB->user,$MySqlDB->password,$MySqlDB->port,$MySqlDB->dbname);
