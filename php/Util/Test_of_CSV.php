<?php
/**
 * Created by PhpStorm.
 * User: SZHAO
 * Date: 4/9/2016
 * Time: 8:32 PM
 */

include '../DB_Managers/BCZ_Manager.php';

@ini_set('display_errors', 'on');

/**
 * Chinese Time - UTF+8
 */
date_default_timezone_set("Asia/Hong_Kong");

/**
 * Set up the LoyaltyDB basic information for the connection
 */
$LoyaltyDB = new stdClass();
$LoyaltyDB->host =  '10.8.64.25';
$LoyaltyDB->user = 'szhao30';
$LoyaltyDB->password = 'decathlon';
$LoyaltyDB->port = 1433;

get_test($LoyaltyDB);


/**
 * The core function called by Ajax to run the scripts
 * @param $db Loyalty or Customer or Netcard ...
 */
function get_test($db)
{

    /**
     * Construct the object for the Data Request
     */
    $LoyaltyManager = new BCZ_Manager($db->host, $db->user, $db->password, $db->port);

    $LoyaltyManager->setBdd("purchase");

    /**
     * the sql for finding all the purchase history of a customer
     */

        $card_nb = 2094022769647;

        $sql = "select cd.TET_ID, cd.TIR_NUM_TIERS, e.TET_NUM_CAISSE, e.TET_NUM_HOTESSE, e.TET_NUM_TRANS, cd.ELG_NUM_ELT_GESTION,
cd.TDE_QUANTITE, cd.TDE_MONTANT, cd.TDE_QUANTITE*cd.TDE_MONTANT as Total_Price, e.TET_DATE_HEURE from (
select d.*,c.CAR_NUMERO_CARTE,c.PER_IDENTIFIANT_PER, c.TCC_DATE_TRT from ticket_carte_central c
inner join ticket_detail_central d
on c.TET_ID = d.TET_ID and c.TIR_NUM_TIERS = d.TIR_NUM_TIERS and c.TTI_NUM_TYPE_TIERS = d.TTI_NUM_TYPE_TIERS)cd
inner join ticket_en_tete_central e
on cd.TTI_NUM_TYPE_TIERS = e.TTI_NUM_TYPE_TIERS and cd.TIR_NUM_TIERS = e.TIR_NUM_TIERS
and cd.TET_ID = e.TET_ID
where cd.CAR_NUMERO_CARTE = '".$card_nb."'
order by e.TET_DATE_HEURE desc, e.TET_ID, cd.ELG_NUM_ELT_GESTION";

    $response = $LoyaltyManager->queryMultiple($sql);

    $file_name = "purchase_".date('Y-m-d')."_".$card_nb;

    $output = fopen("php://output",'w') or die("Can't open php://output");
    header("Content-Type:application/csv");
    header("Content-Disposition:attachment;filename=".$file_name);
    fputcsv($output, array('id','name','description'));
    foreach($response as $row) {
        fputcsv($output, $row);
    }
    fclose($output) or die("Can't close php://output");

}