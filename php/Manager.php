<?php

/**
 * Class Manager
 * Used to manage all the information of one connection to the DB
 */
class Manager{

	/**
	 * @var the bdd schema like "loyalty", "purchase" in BCZ
	 */
	private $bdd;

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
	public function __construct($host, $user, $pass,$port){
		$this->host = $host;
		$this->user = $user;
		$this->password = $pass;
		$this->port = $port;
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
	 * Set up the content of the query
	 * @param $query
	 */
	private function setQuery($query){
		$this->query = mssql_query($query);
	}

	/**
	 * To get the result of the executed script
	 * @param $data the query to run
	 * @return object the response of the query
	 */
	private function fetch($data)
	{
		return mssql_fetch_object($data);
	}

	/**
	 * Choose the DB schema
	 * @param $bdd
	 */
	public function setBdd($bdd){
		$this->session = $this->connexion();
		mssql_select_db($bdd, $this->session);
		$this->bdd = $bdd;
	}

	/**
	 * Connect do the DB server
	 * @return resource|the
	 */
	private function connexion(){
		if($this->session === null) {
			return mssql_connect($this->host . ':' . $this->port, $this->user, $this->password);
		}
		return $this->session;
	}

	/**
	 * Compose the script of select
	 *
	 * select $headers from $table where $optionsArray
	 *
	 * @param $table
	 * @param $headers
	 * @param $optionsArray
	 * @param $isSingle
	 * @return object
	 */
	public function select($table, $headers, $optionsArray, $isSingle){
		$option = "";
		$header = "*";

		// select $headers from $table where $optionsArray
		if($headers != null && count($header) >= 1) {
			$header = "";
			foreach ($headers as $field) {
				$header .= "$field ,";
			}
		}else{
			$header = $headers;
		}
		if($isSingle){
			foreach($optionsArray as $colum => $value) {
				if (is_numeric($value)) {
					$option .= "$colum = $value,";
				} else {
					$option .= "$colum = '$value',";
				}
			}
		}else{
			foreach($optionsArray as $params)
			{

				if (is_numeric($params[2])) {
					$option .= $params[0] . " " . $params[1] . " " . $params[2];
				} else {
					$option .= $params[0] . " " . $params[1] . " " . "'" . $params[2] . "'";
				}

			}
		}

		$dataQuery = "SELECT " . $this->delCommat($header) . " FROM $table WHERE " . $this->delCommat($option);

		$data = $this->query($dataQuery);

		if($isSingle) {
			return $data[0];
		}else {
			return $data;
		}

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
		
		log_execution_duration($msc,$query);

		return $data;
	}

	public function queryMultiple($query){

		/**
		 * Note the time before the execution
		 */
		$msc = microtime(true);

		$this->setQuery($query);
		$result = array();
		while($response = mssql_fetch_row($this->query)) {
			array_push($result,$response);
		}

		log_execution_duration($msc,$query);
		return $result;
	}
}