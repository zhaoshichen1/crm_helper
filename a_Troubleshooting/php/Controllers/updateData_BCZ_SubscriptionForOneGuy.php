<?php
/**
 * Created by PhpStorm.
 * User: SZHAO
 * Date: 4/14/2016
 * Time: 10:16 AM
 */

include '../../../php/DB_Managers/Customer03_Manager.php';
include '../../../php/DB_Managers/BCZ_Manager.php';
include_once  '../../../php/Util/Tool.php';
/**
 * Set up the CustomerDB basic information for the connection
 */
$CustomerDB = new stdClass();
$CustomerDB->host = '10.8.64.89';
$CustomerDB->user = 'szhao30';
$CustomerDB->password = 'decathlon';
$CustomerDB->port = 60904;
$CustomerDB->dbname = 'customer03';

/**
 * Set up the LoyaltyDB basic information for the connection
 */
$LoyaltyDB = new stdClass();
$LoyaltyDB->host =  '10.8.64.25';
$LoyaltyDB->user = 'szhao30';
$LoyaltyDB->password = 'decathlon';
$LoyaltyDB->port = 1433;

/**
 * The core function called by Ajax to run the scripts
 * @param $db Loyalty or Customer or Netcard ...
 */
function get_customer($db_customer03,$db_BCZ){

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
    $CustomerManager = new Customer03_Manager($db_customer03->host,$db_customer03->user,$db_customer03->password,$db_customer03->port,$db_customer03->dbname);

    if((isset($_GET['subscriptionOneGuy']))&&(isset($_GET['cardNumber']))){

        $card_nb = $_GET['cardNumber'];

        $select_id_query = "select id from customer03.personne where numero_carte = '".$card_nb."'";

        $response = $CustomerManager->query($select_id_query);
        var_dump($response);

        //.if the response is false ( no no result )
        if(!$response){
            print "No_Card_Found";
        }
        else{

            // get the id from customer 03
            $real_id =  $response->id;

            //var_dump($real_id);

            // then connect to the BCZ
            $LoyaltyManager = new BCZ_Manager($db_BCZ->host,$db_BCZ->user,$db_BCZ->password,$db_BCZ->port);

            // then run the first check in compte_fid and histo_adhesion_fid
            $LoyaltyManager->setBdd("loyalty");
            $response1 = $LoyaltyManager->query("select * from compte_fid where per_identifiant_per = '".$real_id."'");

            var_dump($response1);

            // if this customer doesn't exist in compte_fid
            if(!$response1){
                $LoyaltyManager->queryUpdate("insert into compte_fid values ('".$card_nb."','".$real_id."')");
            }
            // if this customer exist already, we do nothing
            else{}

            $response2 = $LoyaltyManager->query("select * from histo_adhesion_fid where per_identifiant_per = '".$real_id."' and adhesion = 1");

            if(!$response2){
                $LoyaltyManager->queryUpdate("insert into histo_adhesion_fid values ('".$real_id."',CONVERT(VARCHAR, GETDATE(), 23),1,'SYNCHRO')");
            }
            // if this customer exist already, we do nothing
            else{}
            var_dump($response2);

            print "Repair finished";
        }

    }

}

get_customer($CustomerDB,$LoyaltyDB);
