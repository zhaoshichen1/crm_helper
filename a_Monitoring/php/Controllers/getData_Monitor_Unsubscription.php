<?php
/**
 * Created by PhpStorm.
 * User: RuohongFAN
 * Date: 4/21/2016
 * Time: 11:27 AM
 */

error_reporting(-1);
ini_set('display_errors', 'On');

include '../../../php/DB_Managers/BCZ_Manager.php';
include '../../../php/DB_Managers/Customer03_Manager.php';
include "../../../php/DB_Managers/MySQL_Manager.php";
include_once  '../../../php/Util/Tool.php';

/**
 * Set up the MySQL DB basic information for the connection
 **/
$MySqlDB = new stdClass();
$MySqlDB->host = 'localhost';
$MySqlDB->user = 'root';
$MySqlDB->password = '19900930';
$MySqlDB->port = 3306;
$MySqlDB->dbname = 'testDB';

/**
 * Set up the LoyaltyDB basic information for the connection
 **/
$LoyaltyDB = new stdClass();
$LoyaltyDB->host =  '10.8.64.25';
$LoyaltyDB->user = 'szhao30';
$LoyaltyDB->password = 'decathlon';
$LoyaltyDB->port = 1433;

/**
 * Set up the CustomerDB basic information for the connection
 */
$CustomerDB = new stdClass();
$CustomerDB->host = '10.8.64.89';
$CustomerDB->user = 'crm_helper';
$CustomerDB->password = 'decathlon1';
$CustomerDB->port = 60904;
$CustomerDB->dbname = 'customer03';

if (isset($_GET['unsubscribed_all'])){

    insert_Customer03_subscription($CustomerDB,$MySqlDB);
    insert_BCZ_subscription($LoyaltyDB,$MySqlDB);

    if ($_GET['unsubscribed_all'] == 'true'){
        $total_Gap = get_Total_gap($MySqlDB);
        echo "$total_Gap";
        return $total_Gap;
    }
    elseif ($_GET['unsubscribed_all'] == 'false'){
        if ($_GET['DataType'] == 'Customer03'){
            $customer03_Subscription = get_Customer03_subscription($MySqlDB);
        }
        elseif ($_GET['DataType'] == 'BCZ'){
            $BCZ_Subscription = get_BCZ_subscription($MySqlDB);
            var_dump($BCZ_Subscription);
            return $BCZ_Subscription;
        }
        else return 'Invalid input';
    }
    else return 'Invalid input';
}


/**
 * The objective is to receive requests from ajax,
 * Then return data and arrays in format of array.
 */

function insert_Customer03_subscription($db_c, $db_m)
{

    /**
     * Construct the object for the Data Request
     */

    $Customer03Manager = new Customer03_Manager($db_c->host, $db_c->user, $db_c->password, $db_c->port, $db_c->dbname);
    $MySqlManager = new MySQL_Manager($db_m->host,$db_m->user,$db_m->password,$db_m->port,$db_m->dbname);

    $msc = microtime(true);
    $MySqlManager->queryUpdate("delete from testDB.Customer03_subscription;");// or die('Cannot drop table Customer03_subscription'.mysql_error());
    /*$sql_create = "create table testDB.Customer03_subscription (
            date_creation CHARACTER(8) NOT NULL,
            numero_carte CHARACTER(13) NOT NULL,
            id CHARACTER(11) NOT NULL,
            CONSTRAINT Customer03_subscription_pk PRIMARY KEY (id)
            );";
    $MySqlManager->queryUpdate($sql_create);// or die('Cannot create table'.mysql_error());*/
    $sql_select = "select to_char(date_creation, 'YYYYMMDD') as date_creation, numero_carte, id from personne 
            where date_creation >= current_date-30 and date_creation <= current_date-1
            and code_pays_tiers_habituel = 'CN'
            and (est_supprime is false or est_supprime is null)
            and type_personne = 1
            and type_member IN (2, 3, 6) --type_member 6 = client_light
            and numero_carte is not null
            order by to_char(date_creation, 'YYYYMMDD');";
    $results = $Customer03Manager->setquery($sql_select);// or die('Cannot select Customer03'.pg_result_error());
    while ($result = pg_fetch_row($results)){
        $MySqlManager->queryUpdate('insert into testDB.Customer03_subscription values ('.$result[0].','.$result[1].','.$result[2].');');
        //or die('Cannot insert'.mysql_error());
    }
    unset($results);
    $diff = microtime(true)-$msc;
    $date = date("D M d, Y G:i");
    openAndWriteALine("../../../log/Log.txt","Date: ".$date."\n\r".$sql_select."\n\rQuery: insert Customer03_subscription\n\rExecution Duration is ".$diff." ms\n\r");
}

function insert_BCZ_subscription($db_b, $db_m)
{

    /**
     * Construct the object for the Data Request
     */

    $BCZManager = new BCZ_Manager($db_b->host, $db_b->user, $db_b->password, $db_b->port);
    $MySqlManager = new MySQL_Manager($db_m->host,$db_m->user,$db_m->password,$db_m->port,$db_m->dbname);

    $msc = microtime(true);
    $MySqlManager->queryUpdate("delete from testDB.BCZ_subscription;");// or die('Cannot drop table'.mysql_error());
    /*$sql_create = "create table testDB.BCZ_subscription (
            date_creation CHARACTER(8) NOT NULL,
            numero_carte CHARACTER(13) NOT NULL,
            id CHARACTER(11) NOT NULL,
            CONSTRAINT BCZ_subscription_pk PRIMARY KEY (id)
            );";
    $MySqlManager->queryUpdate($sql_create);// or die('Cannot create table'.mysql_error());*/
    $sql_select = "select distinct max(convert(char(8),h.date_insertion,112)) as date_creation, 
            c.CAR_NUMERO_CARTE, h.PER_IDENTIFIANT_PER
            from compte_fid c inner join histo_adhesion_fid h
            on c.PER_IDENTIFIANT_PER = h.PER_IDENTIFIANT_PER
            where convert(char(8),h.date_insertion,112) 
            between convert(char(8),getdate()-30,112) and convert(char(8),getdate()-1,112)
            group by c.CAR_NUMERO_CARTE, h.PER_IDENTIFIANT_PER;";
    $BCZManager->setBdd("loyalty");
    $results = $BCZManager->setquery($sql_select);// or die('Cannot select BCZ'.sqlsrv_errors());
    while ($result = mssql_fetch_row($results)){
        $MySqlManager->queryUpdate('insert into testDB.BCZ_subscription values ('.$result[0].','.$result[1].','.$result[2].');');
        // or die('Cannot insert'.mysql_error());
    }
    unset($results);
    $diff = microtime(true)-$msc;
    $date = date("D M d, Y G:i");
    openAndWriteALine("../../../log/Log.txt","Date: ".$date."\n\r".$sql_select."\n\rQuery: insert BCZ_subscription\n\rExecution Duration is ".$diff." ms\n\r");
}

function get_Customer03_subscription($db_m)
{
    $MySqlManager = new MySQL_Manager($db_m->host,$db_m->user,$db_m->password,$db_m->port,$db_m->dbname);
    $msc = microtime(true);
    $sql_Customer03_count_7 = "select date_creation, count(*) 
            from testDB.Customer03_subscription 
            where date_creation <= curdate()-1
            and date_creation >= curdate()-7
            group by date_creation;";
    $Customer03_subscription_count_7 = $MySqlManager->queryMultiple($sql_Customer03_count_7);// or die('Cannot select Customer03_subscription'.mysql_error());
    $diff = microtime(true)-$msc;
    $date = date("D M d, Y G:i");
    openAndWriteALine("../../../log/Log.txt","Date: ".$date."\n\r".$sql_Customer03_count_7."\n\rExecution Duration is ".$diff." ms\n\r");
    print json_encode($Customer03_subscription_count_7);
}

function get_BCZ_subscription($db_m)
{
    $msc = microtime(true);
    $MySqlManager = new MySQL_Manager($db_m->host,$db_m->user,$db_m->password,$db_m->port,$db_m->dbname);
    $sql_BCZ_count_7 = "select c.date_creation, count(*)
            from testDB.Customer03_subscription c
            inner join testDB.BCZ_subscription b
            on c.id = b.id and c.numero_carte = b.numero_carte
            where c.date_creation <= curdate()-1
            and c.date_creation >= curdate()-7
            group by c.date_creation;";
    $BCZ_subscription_count_7 = $MySqlManager->queryMultiple($sql_BCZ_count_7);// or die('Cannot select BCZ_subscription'.mysql_error());
    $diff = microtime(true)-$msc;
    $date = date("D M d, Y G:i");
    openAndWriteALine("../../../log/Log.txt","Date: ".$date."\n\r".$sql_BCZ_count_7."\n\rExecution Duration is ".$diff." ms\n\r");
    print json_encode($BCZ_subscription_count_7);
}

function get_Total_gap($db_m){
    $MySqlManager = new MySQL_Manager($db_m->host,$db_m->user,$db_m->password,$db_m->port,$db_m->dbname);
    $msc = microtime(true);
    $sql_Customer03_count_30 = "select count(*) 
                from testDB.Customer03_subscription 
                where date_creation <= curdate()-1
                and date_creation >= curdate()-30;";
    $Customer03_subscription_count_30 = $MySqlManager->queryUpdate($sql_Customer03_count_30);// or die('Cannot select Customer03_subscription total'.mysql_error());
    $sql_BCZ_count_30 = "select count(*)
                from testDB.Customer03_subscription c
                inner join testDB.BCZ_subscription b
                on c.id = b.id and c.numero_carte = b.numero_carte
                where c.date_creation <= curdate()-1
                and c.date_creation >= curdate()-30;";
    $BCZ_subscription_count_30 = $MySqlManager->queryUpdate($sql_BCZ_count_30);// or die('Cannot select BCZ_subscription total'.mysql_error());
    $Customer03_subscription_count_total = mysql_fetch_row($Customer03_subscription_count_30);
    $BCZ_subscription_count_total = mysql_fetch_row($BCZ_subscription_count_30);
    $Gap_total = $Customer03_subscription_count_total[0]-$BCZ_subscription_count_total[0];
    $diff = microtime(true)-$msc;
    $date = date("D M d, Y G:i");
    openAndWriteALine("../../../log/Log.txt","Date: ".$date."\n\r".$sql_Customer03_count_30."\n\r".$sql_BCZ_count_30."\n\rExecution Duration is ".$diff." ms\n\r");
    return $Gap_total;
}