<?php
class db {

	// DB connection parametrs
	protected $_server = 'localhost';
	protected $_username = 'root';
	protected $_password = 'hiQkBHoZDzy5';
	protected $_database = 'transberry';
	
	protected $_connection;

	public function __construct(){
		$this->init();
	}
	
	public function init(){
		$this->_connection = mysql_connect($this->_server,$this->_username,$this->_password);
		mysql_select_db($this->_database, $this->_connection);
		mysql_set_charset('utf8', $this->_connection);
	}
	
	public function query($sql){
		$results = mysql_query($sql, $this->_connection);
		if (!$results) {
			return (mysql_error());
		}
		return $results;
	}
	
	public function fetchRow($sql){
		$results = mysql_query($sql, $this->_connection);
		if (!$results) {
			return (mysql_error());
		}
		while ($array = mysql_fetch_assoc($results)){
			return $array;
		}
	}
	
	public function fetchAll($sql){
		$results = mysql_query($sql, $this->_connection);
		$result = array();
		if (!$results) {
			return (mysql_error());
		}
		while ($array = mysql_fetch_assoc($results)){
			$result[] = $array;
		}
		return $result;
	}

	public function insert($table, $data){
		$query = "INSERT INTO `".$table."` (";
		$i = 1;
		$count = count($data);
		foreach ($data as $key => $value){
			if ($i==$count){
				$query .= "`".$key."`";
			}else{
				$query .= "`".$key."`, ";
			}
			$i++;
		}
		$i = 1;
		$query .= ') VALUES (';
		foreach ($data as $key => $value){
			if ($i==$count){
				$query .= "'".$value."'";
			}else{
				$query .= "'".$value."', ";
			}
			$i++;
		}
		$query .= ');';
		$this->query($query);
		return mysql_insert_id();
	}

	public function update($table, $data, $condition){
		$query = "UPDATE `".$table."` SET ";
		$i = 1;
		$count = count($data);
		foreach ($data as $key => $value){
			if ($i==$count){
				$query .= $key."='".$value."'";
			}else{
				$query .= $key."='".$value."', ";
			}
			$i++;
		}
		$query .= ' WHERE '.$condition['key']."='".$condition['value']."'";
		return $this->query($query);
	}

}
