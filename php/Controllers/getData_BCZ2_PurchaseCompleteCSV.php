<?php

include '../DB_Managers/BCZ_Manager.php';

/**
 * The core function called by Ajax to run the scripts
 * @param $db Loyalty or Customer or Netcard ...
 */
function get_BCZ($db){

    /**
     * Construct the object for the Data Request
     */
    $LoyaltyManager = new BCZ_Manager($db->host,$db->user,$db->password,$db->port);

    if(isset($_GET['numbercardcompletepurchase'])){
        if(isset($_GET['from'])){
            if(isset($_GET['to'])){

                $LoyaltyManager->setBdd("purchase");

                /**
                 * the sql for finding all the purchase history of a customer
                 */

                $card_nb = $_GET['numbercardcompletepurchase'];
                $from = $_GET['from'];
                $to = $_GET['to'];


                $sql = "select c.TET_ID, c.TIR_NUM_TIERS, e.TET_NUM_CAISSE, e.TET_NUM_HOTESSE, e.TET_NUM_TRANS, d.ELG_NUM_ELT_GESTION,
d.TDE_QUANTITE, d.TDE_MONTANT, d.TDE_QUANTITE*d.TDE_MONTANT as Total_Price, e.TET_DATE_HEURE
from
ticket_carte_central c
inner join ticket_detail_central d
on c.tir_num_tiers = d.tir_num_tiers and c.tet_id = d.tet_id and c.tti_num_type_tiers = d.tti_num_type_tiers and c.tir_sous_num_tiers = d.tir_sous_num_tiers
inner join ticket_en_tete_central e
on c.tir_num_tiers = e.tir_num_tiers and c.tet_id = e.tet_id and c.tti_num_type_tiers = e.tti_num_type_tiers and c.tir_sous_num_tiers = e.tir_sous_num_tiers
where c.car_numero_carte = '".$card_nb."' and e.tet_date_heure > '".$from."' and e.tet_date_heure < '".$to."'
order by e.TET_DATE_HEURE desc, e.TET_ID, d.ELG_NUM_ELT_GESTION;";

                $header = array('tet_id','store_number','till','num_cashier','num_transaction','item_id','quantity','price','total_amount','transaction_time');
                $file_name = "purchase_".date('Y-m-d')."_".$card_nb.".csv";
                $output = fopen("php://output",'w') or die("Can't open php://output");

                header("Content-Type:application/csv");
                header("Content-Disposition:attachment;filename=".$file_name);

                // pre-write the headers as the first line
                fputcsv($output, $header);

                $LoyaltyManager->queryMultipleCSV($output,$sql,$file_name,$header);
                fclose($output) or die("Can't close php://output");

                return;
            }
        }
    }
}

/**
 * Set up the LoyaltyDB basic information for the connection
 */
$LoyaltyDB = new stdClass();
$LoyaltyDB->host =  '10.8.64.25';
$LoyaltyDB->user = 'szhao30';
$LoyaltyDB->password = 'decathlon';
$LoyaltyDB->port = 1433;

get_BCZ($LoyaltyDB);
