<?php

include '../../../php/DB_Managers/Customer03_Manager.php';
include_once  '../../../php/Util/Tool.php';


/**
 * Set up the CustomerDB basic information for the connection
 */
$CustomerDB = new stdClass();
$CustomerDB->host = '10.8.64.89';
//$CustomerDB->host = 'localhost';
$CustomerDB->user = 'crm_helper';
//$CustomerDB->user = 'postgres';
$CustomerDB->password = 'decathlon1';
//$CustomerDB->password = '19900930';
$CustomerDB->port = 60904;
//$CustomerDB->port = 5432;
//$CustomerDB->dbname = 'postgres';
$CustomerDB->dbname = 'customer03';


/**
 * The core function called by Ajax to run the scripts
 * @param $db Loyalty or Customer or Netcard ...
 */
function get_customer($db){

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
     * Construct the object for the Data Request
     */
    $CustomerManager = new Customer03_Manager($db->host,$db->user,$db->password,$db->port,$db->dbname);

    if(isset($_GET['tel_dup'])){

        $tel_query = "select count(*) from (select tel_portable, count(*)
from personne
where tel_portable is not null
and tel_portable <> ''
and code_pays_tiers_habituel in ('CN')
group by tel_portable
having count(*) >1) as result";

        $response = $CustomerManager->query($tel_query);
        print $response->count;
    }

    if(isset($_GET['account_dup'])){

        $account_query = "select sum(result.c) from (select tel_portable, count(*) as c
from personne
where tel_portable is not null
and tel_portable <> ''
and code_pays_tiers_habituel in ('CN')
group by tel_portable
having count(*) >1) as result";;

        $response = $CustomerManager->query($account_query);
        print $response->sum;
    }

    /**
     * if the user provides an email to search
     */
    if(isset($_GET['email_key'])){
        $search_query = "select type_member,numero_carte from personne where searchpersonfct(email) = LOWER('".$_GET['email_key']."')";
        $response = $CustomerManager->queryMultiple($search_query);
        print json_encode($response);
    }

    /**
     * if the customer provideds the tel number to search
     */
    if(isset($_GET['tel_key'])){
        $search_query = "select type_member,numero_carte from Customer03.personne where tel_portable = '".$_GET['tel_key']. "'";

        $response = $CustomerManager->queryMultiple($search_query);
        print json_encode($response);
    }

}

get_customer($CustomerDB);
