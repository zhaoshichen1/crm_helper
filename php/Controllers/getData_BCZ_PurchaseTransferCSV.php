<?php

include '../DB_Managers/BCZ_Manager.php';
include_once  '../Util/Tool.php';


/**
 * The core function called by Ajax to run the scripts
 * @param $db Loyalty or Customer or Netcard ...
 */
function get_BCZ($db){

    /**
     * Construct the object for the Data Request
     */
    $LoyaltyManager = new BCZ_Manager($db->host,$db->user,$db->password,$db->port);

    if(isset($_GET['cardTransfer'])){
        if(!empty($_GET['cardTransfer'])){

            $card_nb = $_GET['cardTransfer'];

            $LoyaltyManager->setBdd("purchase");
            $sql = "select convert(varchar(100),pt.TET_DATE_HEURE,23) as purcahse_date,
pt.TIR_NUM_TIERS, ttc.TET_NUM_CAISSE, ttc.TET_NUM_TRANS, sum(tdc.TDE_QUANTITE*tdc.TDE_MONTANT) as amount,
pt.CAR_NUMERO_CARTE_NEW
 from purchase_transfer pt
inner join ticket_en_tete_central ttc
on ttc.TET_ID = pt.TET_ID and ttc.TIR_NUM_TIERS = pt.TIR_NUM_TIERS
 and ttc.TTI_NUM_TYPE_TIERS = pt.TTI_NUM_TYPE_TIERS and ttc.TIR_SOUS_NUM_TIERS = pt.TIR_SOUS_NUM_TIERS
inner join ticket_detail_central tdc
on pt.TIR_NUM_TIERS = tdc.TIR_NUM_TIERS and pt.TET_ID = tdc.TET_ID
 and tdc.TTI_NUM_TYPE_TIERS = pt.TTI_NUM_TYPE_TIERS and tdc.TIR_SOUS_NUM_TIERS = pt.TIR_SOUS_NUM_TIERS
where pt.CAR_NUMERO_CARTE_OLD = '".$_GET['cardTransfer']."'
group by convert(varchar(100),pt.TET_DATE_HEURE,23), pt.TIR_NUM_TIERS,
ttc.TET_NUM_CAISSE, ttc.TET_NUM_TRANS,pt.CAR_NUMERO_CARTE_NEW, pt.TET_ID;";

            $header = array('Date','Store','Till','Transaction No.','Amount','Destination Card');
            $file_name = "purchase_transfer_from_".date('Y-m-d')."_".$card_nb.".csv";
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

/**
 * Set up the LoyaltyDB basic information for the connection
 */
$LoyaltyDB = new stdClass();
$LoyaltyDB->host =  '10.8.64.25';
$LoyaltyDB->user = 'szhao30';
$LoyaltyDB->password = 'decathlon';
$LoyaltyDB->port = 1433;

get_BCZ($LoyaltyDB);
