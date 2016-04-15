<?php

include '../DB_Managers/BCZ_Manager.php';
include_once  '../Util/Tool.php';


/**
 * The objective is to show the information of the problem
 * @param $response the response got from "select * from reservoir_avantage"
 */
function treat_rti($response){
    print("Code Error is: ".$response->rti_code_erreur."\r\n ----> ");
    switch($response->rti_code_erreur){
        case "0 ":
            print "Ready to treat by the batch";
            break;
        case "1 ":
            print "Label of Tiers, Country, Language Invalid";
            break;
        case "3 ":
            print "Loyalty Account's Tiers is different from his usual store!";
            break;
        case "4 ":
            print "Retrive Card Information Failure";
            break;
        case "5 ":
            print "Retrive Person Information Failure";
            break;
        case "6 ":
            print "Customer's Usual Store invalid";
            break;
        case "9 ":
            print "Unknown error, need to check the log";
            break;
        case "10":
            print "Error used in old version. Cancelled from Octobre 2015";
            break;
        case "11":
            print "Error for paper voucher.";
            break;
        case "12":
            print "Error for paper voucher.";
            break;
        case "13":
            print "Error for paper voucher.";
            break;
        case "14":
            print "Customer's Language is empty";
            break;
        case "15":
            print "Customer's Country is empty";
            break;
        case "16":
            print "Evoucher Owner doesn\'t have a valid email address ";
            break;
        case "17":
            print "Error for SMS voucher.";;
            break;
        case "18":
            print "Duplicated Cards problem";
            break;
        case "19":
            print "Customer's country doesn't have loyalty service";
            break;
        case "20":
            print "Customer is not linked to the loyalty program";
            break;
        case "21":
            print "The total of the voucher is less than 1 ( negative maybe )";
            break;
        default:
            print "Unknown error, please contact CS-CRM-Decathlon";
            break;
    }
}

/**
 * The core function called by Ajax to run the scripts
 * @param $db Loyalty or Customer or Netcard ...
 */
function get_loyalty($db){

    /**
     * Construct the object for the Data Request
     */
    $LoyaltyManager = new BCZ_Manager($db->host,$db->user,$db->password,$db->port);

    if(isset($_GET['loyalty_reset'])){
        $LoyaltyManager->setBdd("loyalty");
        $response = $LoyaltyManager->query("update reservoir_avantage set rti_code_erreur = 0 where car_numero_carte = ".$_GET['loyalty_reset']);
        var_dump($response);
    }

    /**
     * called by AJAX with Loyalty_echeckko_cardnumber
     * script: select * from reservoir_avantage where car_numero_carte = $_GET['loyalty_echeckko_cardnumber']
     */
    if(isset($_GET['loyalty_echeckko_cardnumber'])){
        if(!empty($_GET['loyalty_echeckko_cardnumber'])){
            $LoyaltyManager->setBdd("loyalty");
            $response = $LoyaltyManager->select(
                "reservoir_avantage",
                array("rti_code_erreur"),
                array(0 => array("car_numero_carte", "=", $_GET['loyalty_echeckko_cardnumber'])),false);
            if($response){
                treat_rti($response);
            }
            else{
                print 'No problem found for '.$_GET['loyalty_echeckko_cardnumber'];
            }
        }
    }

    /**
     * run the script to find out which card has been used for indicated purchase
     */
    if(isset($_GET['storenumberfindcard'])){
        if(isset($_GET['tillnumberfindcard'])){
            if(isset($_GET['tillnumberfindcard'])){
                if(isset($_GET['transnumberfindcard'])) {
                    if (isset($_GET['from']) && isset($_GET['to'])) {
                        if (!empty($_GET['storenumberfindcard']) && !empty($_GET['tillnumberfindcard'])
                            && !empty($_GET['transnumberfindcard']) && !empty($_GET['from']) && !empty($_GET['to'])
                        ) {

                            /**
                             * connect to Purchase DB
                             */
                            $LoyaltyManager->setBdd("purchase");

                            /**
                             * just to find the card used for the indicated purchase
                             */
                            $response = $LoyaltyManager->query('
select tcc.car_numero_carte from
purchase..ticket_carte_central tcc (nolock)
inner join purchase..ticket_en_tete_central tet(nolock)
on tet.TTI_NUM_TYPE_TIERS = tcc.TTI_NUM_TYPE_TIERS
and tet.TIR_NUM_TIERS = tcc.TIR_NUM_TIERS and tet.TET_ID = tcc.TET_ID
where tcc.TIR_NUM_TIERS = ' . $_GET['storenumberfindcard'] . '
and tcc.TTI_NUM_TYPE_TIERS = 7
and tet.TET_NUM_CAISSE = ' . $_GET['tillnumberfindcard'] . '
and tet.TET_NUM_TRANS = ' . $_GET['transnumberfindcard'] . '
and tet.TET_DATE_HEURE between \'' . $_GET['from'] . ' 00:00:00' . '\' and \'' . $_GET['to'] . ' 23:59:00\'');
                        }

                        if ($response) {
                            echo $response->car_numero_carte;
                        } else {
                            echo 'No Data Found';
                        }
                    }
                }
            }
        }
    }

    /**
     * run the script
     * select count(*) from compte_fid where car_numero_carte = xxx
     * check customer's loyalty subscription
     */
    if(isset($_GET['numbercardfidelity'])){
        if(!empty($_GET['numbercardfidelity'])){
            $LoyaltyManager->setBdd("loyalty");
            $response = $LoyaltyManager->query("select count(*) from compte_fid where car_numero_carte = '".$_GET['numbercardfidelity']."'");
            print($response->computed);
        }
    }

    /**
     * called by AJAX with cardTransfer
     * script: select * from reservoir_avantage where car_numero_carte = $_GET['loyalty_echeckko_cardnumber']
     */
    if(isset($_GET['cardTransfer'])){
        if(!empty($_GET['cardTransfer'])){
            $LoyaltyManager->setBdd("purchase");
            $response = $LoyaltyManager->queryMultiple("select convert(varchar(100),pt.TET_DATE_HEURE,23) as purcahse_date,
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
ttc.TET_NUM_CAISSE, ttc.TET_NUM_TRANS,pt.CAR_NUMERO_CARTE_NEW, pt.TET_ID;");
        }
        print json_encode($response);
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

get_loyalty($LoyaltyDB);

