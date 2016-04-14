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
class Customer03_Manager{

    /**
     * @var the bdd schema like "Customer03", "Custcent", etc
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
    private $session;

    /**
     * @var the script
     */
    private $query;

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
        $this->host = "host=".$host;
        $this->user = "user=".$user;
        $this->password = "password=".$pass;
        $this->port = "port=".$port;
        $this->dbname = "dbname=".$dbname;
        $this->session = $this->connexion();
    }

    /**
     * Remove "," from the given string
     * @param $string
     * @return string treated character chain
     */
    private function delCommat($string){
        return rtrim($string, ",");
    }

    /**
     * Set up the content of the query and run the query
     * @param $query
     */
    private function setQuery($query){
        $this->query = pg_query($this->session,$query);
    }

    /**
     * To get the result of the executed script
     * @param $data the query to run
     * @return object the response of the query
     */
    private function fetch($data)
    {
        return pg_fetch_object($data);
    }

    /**
     * Connect do the DB server
     * @return resource|the
     */
    private function connexion(){
        if($this->session === null) {
            return pg_connect($this->host.' '.$this->port.' '.$this->dbname.' '.$this->user.' '.$this->password);
        }
        return $this->session;
    }

    /**
     * Run the query
     * @param $query
     * @return object the response
     */
    public function query($query){

        /**
         * Note the time before the execution
         */
        $msc = microtime(true);

        $this->setQuery($query);
        $data = $this->fetch($this->query);

        /**
         * Note the time after the execution
         */
        $diff = microtime(true)-$msc;
        $date = date("D M d, Y G:i");
        openAndWriteALine("../../log/Log.txt","Date: ".$date."\n\rQuery: ".$query."\n\rExecution Duration is ".$diff." ms\n\r");

        return $data;
    }

    public function queryMultiple($query){

        /**
         * Note the time before the execution
         */
        $msc = microtime(true);

        $this->setQuery($query);
        $result = array();
        while($response = pg_fetch_row($this->session,$this->query)) {
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

    /**
     * Run the query without fetch the result
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
        $this->setQuery($query);

        /**
         * Note the time after the execution
         */
        $diff = microtime(true)-$msc;
        $date = date("D M d, Y G:i");
        openAndWriteALine("../../log/Log.txt","Date: ".$date."\n\rQuery: ".$query."\n\rExecution Duration is ".$diff." ms\n\r");

    }
}