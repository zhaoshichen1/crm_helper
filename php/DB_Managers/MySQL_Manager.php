<?php

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
 * Created by PhpStorm.
 * User: SZHAO
 * Date: 3/29/2016
 * Time: 9:00 PM
 *
 * The class to manage the connection with Postgres DB Server - Customer 03 of CRM
 *
 */
class MySQL_Manager{

    /**
     * @var the bdd schema like "testDB"
     */
    private $dbname;

    /**
     * @var the IP of Db Server
     */
    private $host;

    private $user;
    private $password;

    /**
     * @var the object of the session
     */
    public $session;

    /**
     * @var the port to connect the DB server
     */
    private $port;

    /**
     * Manager constructor.
     * @param $host
     * @param $user
     * @param $pass
     * @param $port
     */
    public function __construct($host, $user, $pass,$port,$dbname){
        $this->host = $host;
        $this->user = $user;
        $this->password = $pass;
        $this->port = $port;
        $this->dbname = $dbname;

        //echo "nimabi";
        $this->session = $this->connexion();

        //echo "dsa";
    }

    /**
     * Connect do the DB server
     * @return resource|the
     */
    private function connexion(){
        if($this->session === null) {
            $this->session = mysql_connect($this->host.':'.$this->port,$this->user,$this->password);
            mysql_select_db($this->dbname);

            //echo "connection successful";
            return $this->session;
        }
        //echo "conncetion exists";
        return $this->session;
    }

    /**
     * Run the query
     * @param $query
     * @return object the response
     */
    public function query($query){

        //var_dump($this->session);

        /**
         * Note the time before the execution
         */
        $msc = microtime(true);

        //var_dump($query);
        $result = mysql_query($query,$this->session);
        $data = mysql_fetch_array($result);

        /**
         * Note the time after the execution
         */
        $diff = microtime(true)-$msc;
        $date = date("D M d, Y G:i");
        openAndWriteALine("../../log/Log.txt","Date: ".$date."\n\rQuery: ".$query."\n\rExecution Duration is ".$diff." ms\n\r");

        return $data;
    }

    /**
     * Run the query
     * @param $query
     * @return object the response
     */
    public function queryUpdate($query){

        //var_dump($this->session);

        /**
         * Note the time before the execution
         */
        $msc = microtime(true);

        //var_dump($query);
        $result = mysql_query($query,$this->session);

        /**
         * Note the time after the execution
         */
        $diff = microtime(true)-$msc;
        $date = date("D M d, Y G:i");
        openAndWriteALine("../../log/Log.txt","Date: ".$date."\n\rQuery: ".$query."\n\rExecution Duration is ".$diff." ms\n\r");

        return $result;
    }

    public function queryMultiple($query){

        /**
         * Note the time before the execution
         */
        $msc = microtime(true);

        $data = mysql_query($query,$this->session);
        var_dump($data);

        $result = array();
        while($response = mysql_fetch_row($data)) {
            array_push($result,$response);
        }

        /**
         * Note the time after the execution
         */
        $diff = microtime(true)-$msc;
        $date = date("D M d, Y G:i");
        openAndWriteALine("../../log/Log.txt","Date: ".$date."\n\rQuery: ".$query."\n\rExecution Duration is ".$diff." ms\n\r");

        return $result;
    }
}