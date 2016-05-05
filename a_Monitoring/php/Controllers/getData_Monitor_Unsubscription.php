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
$CustomerDB->user = 'szhao30';
$CustomerDB->password = 'decathlon';
$CustomerDB->port = 60904;
$CustomerDB->dbname = 'customer03';

/**
 * for test
 */
if(isset($_GET['shichen_test'])){
    recover_last_thirty_days($CustomerDB,$MySqlDB,$LoyaltyDB);
}

if (isset($_GET['unsubscribed_all'])){

    /**
     * if we get the value force_update, we will force the refresh of the Data in our MySQL DB
     */
    if(isset($_GET['force_update'])){
        insert_Customer03_subscription($CustomerDB,$MySqlDB,true);
        insert_BCZ_subscription($LoyaltyDB,$MySqlDB,true);

    }
    else{
        insert_Customer03_subscription($CustomerDB,$MySqlDB,false);
        insert_BCZ_subscription($LoyaltyDB,$MySqlDB,false);
    }

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
            return $BCZ_Subscription;
        }
        else return 'Invalid input';
    }
    else return 'Invalid input';
}


/**
 * one method - will be called by a button from front-end
 * to compare the data retrieved from Customer 03 & BCZ
 * and then generate correction scripts to run in BCZ database
 * - NB: need password to do this operation
 *
 */
function recover_last_thirty_days($db_c,$db_m,$db_l){

    /**
     * first update our data in MySQL Database, not force them to update if data already exists
     */
    insert_Customer03_subscription($db_c,$db_m,false);
    insert_BCZ_subscription($db_l,$db_m,false);

    /**
     * note the time before the execution
     */
    $msc = microtime(true);

    /**
     * init the object to manage the connection with MySQL
     */
    $MySqlManager = new MySQL_Manager($db_m->host,$db_m->user,$db_m->password,$db_m->port,$db_m->dbname);

    var_dump($MySqlManager);

    /**
     * the request to find out the customers existing in Customer 03 not in BCZ during last 30 days from MySQL DB
     */
    $sql_Diff = "select cs.numero_carte,id from Customer03_subscription cs
left join BCZ_subscription bs
on cs.id = bs.id
where bs.id is null;";

    $data = mysql_query($sql_Diff,$MySqlManager->session);
    var_dump(mysql_fetch_row($data));
//
//    /**
//     * the array that contains the Diff
//     */
//    $Result_real = $MySqlManager->queryMultiple($sql_Diff);// or die('Cannot select BCZ_subscription'.mysql_error());
//    $diff = microtime(true)-$msc;
//
//    /**
//     * write in the log
//     */
//    $date = date("D M d, Y G:i");
//    openAndWriteALine("../../../log/Log.txt","Date: ".$date."\n\r".$sql_Diff."\n\rExecution Duration is ".$diff." ms\n\r");
//
//    /**
//     * print the result
//     */
//    print json_encode($Result_real);
}

/**
 * The objective is to receive requests from ajax,
 * Then return data and arrays in format of array.
 */

function insert_Customer03_subscription($db_c, $db_m,$force_update)
{

    /**
     * Construct the object for the Data Request
     */

    $Customer03Manager = new Customer03_Manager($db_c->host, $db_c->user, $db_c->password, $db_c->port, $db_c->dbname);
    $MySqlManager = new MySQL_Manager($db_m->host,$db_m->user,$db_m->password,$db_m->port,$db_m->dbname);

    $msc = microtime(true);

    /**
     * if we are not asked to refresh the data, we will check the Flag
     */
    if($force_update == false){
        /**
         * check the flag
         */
        $result = $MySqlManager->query("select * from Customer03_subscription where id = \"update_time\" and date_creation = DATE_FORMAT(NOW(),'%Y%m%d');");

        // if the result is empty
        if(!$result){

            // we will continue to insert new data
            // so delete this flag to have a new one after
            $MySqlManager->queryUpdate("delete from Customer03_subscription where id = \"update_time\"");
        }
        else{
            // we do nothing and quit
            // will not update
            return;
        }
    }
    /**
     * else means we are forced to update
     */
    else{
        $MySqlManager->queryUpdate("delete from Customer03_subscription where id = \"update_time\"");
    }


    /**
     * clean old data
     */
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

    /**
     * insert new data
     */
    while ($result = pg_fetch_row($results)){
        $MySqlManager->queryUpdate('insert into testDB.Customer03_subscription values ('.$result[0].','.$result[1].','.$result[2].');');
        //or die('Cannot insert'.mysql_error());
    }

    /**
     * insert the flag bit into the table
     */
    $MySqlManager->queryUpdate('insert into Customer03_subscription values (DATE_FORMAT(NOW(),\'%Y%m%d\'),"update_time","update_time")');

    /**
     * write the results
     */
    unset($results);
    $diff = microtime(true)-$msc;
    $date = date("D M d, Y G:i");
    openAndWriteALine("../../../log/Log.txt","Date: ".$date."\n\r".$sql_select."\n\rQuery: insert Customer03_subscription\n\rExecution Duration is ".$diff." ms\n\r");
}

function insert_BCZ_subscription($db_b, $db_m,$force_update)
{

    /**
     * Construct the object for the Data Request
     */

    $BCZManager = new BCZ_Manager($db_b->host, $db_b->user, $db_b->password, $db_b->port);
    $MySqlManager = new MySQL_Manager($db_m->host,$db_m->user,$db_m->password,$db_m->port,$db_m->dbname);

    $msc = microtime(true);

    /**
     * same meaning as the Customer 03 one
     */
    if($force_update == false){
        /**
         * check the flag
         */
        $result = $MySqlManager->query("select * from BCZ_subscription where id = \"update_time\" and date_creation = DATE_FORMAT(NOW(),'%Y%m%d');");

        // if the result is empty
        if(!$result){
            // we will continue to insert new data
            // so delete this flag to have a new one after
            $MySqlManager->queryUpdate("delete from BCZ_subscription where id = \"update_time\"");
        }
        else{
            // we do nothing and quit
            // will not update
            return;
        }
    }
    else{
        $MySqlManager->queryUpdate("delete from BCZ_subscription where id = \"update_time\"");
    }


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

    /**
     * insert the flag bit into the table
     */
    $MySqlManager->queryUpdate('insert into BCZ_subscription values (DATE_FORMAT(NOW(),\'%Y%m%d\'),"update_time","update_time")');

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
            where date_creation <= date_sub(curdate(), interval 1 day)
            and date_creation >= date_sub(curdate(), interval 7 day)
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
            where c.date_creation <= date_sub(curdate(), interval 1 day)
            and c.date_creation >= date_sub(curdate(), interval 7 day)
            group by c.date_creation;";
    $BCZ_subscription_count_7 = $MySqlManager->queryMultiple($sql_BCZ_count_7);// or die('Cannot select BCZ_subscription'.mysql_error());
    $diff = microtime(true)-$msc;
    $date = date("D M d, Y G:i");
    openAndWriteALine("../../../log/Log.txt","Date: ".$date."\n\r".$sql_BCZ_count_7."\n\rExecution Duration is ".$diff." ms\n\r");
    print json_encode($BCZ_subscription_count_7);
}

/**
 *
 * get the data of 30 days --> the gap
 *
 * @param $db_m
 * @return mixed
 */
function get_Total_gap($db_m){
    $MySqlManager = new MySQL_Manager($db_m->host,$db_m->user,$db_m->password,$db_m->port,$db_m->dbname);
    $msc = microtime(true);

    // count how many person in Customer 03 created last 30 days
    $sql_Customer03_count_30 = "select count(*)
                from testDB.Customer03_subscription 
                where date_creation <= date_sub(curdate(), interval 1 day)
                and date_creation >= date_sub(curdate(), interval 30 day);";
    $Customer03_subscription_count_30 = $MySqlManager->queryUpdate($sql_Customer03_count_30);// or die('Cannot select Customer03_subscription total'.mysql_error());
    $Customer03_subscription_count_total = mysql_fetch_row($Customer03_subscription_count_30);

    // count how many person in BCZ created last 30 days
    $sql_BCZ_count_30 = "select count(*)
                from testDB.Customer03_subscription c
                inner join testDB.BCZ_subscription b
                on c.id = b.id and c.numero_carte = b.numero_carte
                where c.date_creation <= date_sub(curdate(), interval 1 day)
                and c.date_creation >= date_sub(curdate(), interval 30 day);";
    $BCZ_subscription_count_30 = $MySqlManager->queryUpdate($sql_BCZ_count_30);// or die('Cannot select BCZ_subscription total'.mysql_error());
    $BCZ_subscription_count_total = mysql_fetch_row($BCZ_subscription_count_30);

    // calculate the gap
    $Gap_total = $Customer03_subscription_count_total[0]-$BCZ_subscription_count_total[0];

    $diff = microtime(true)-$msc;
    $date = date("D M d, Y G:i");
    openAndWriteALine("../../../log/Log.txt","Date: ".$date."\n\r".$sql_Customer03_count_30."\n\r".$sql_BCZ_count_30."\n\rExecution Duration is ".$diff." ms\n\r");
    return $Gap_total;
}