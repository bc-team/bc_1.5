<?php
require_once(realpath(dirname(__FILE__)) . '/../settings.inc.php');

Class DB {
	var
	$host,
	$name,
	$user,
	$pass,
	$tables,
	$fields,
	$files,
	$entities;

	private static $instance;
	
	public static function getInstance()
	{
		return self::$instance;
	}
	
	
	function __construct($host,$name,$user,$pass) {
		if(!self::testConnection($host, $name, $user, $pass))
		{
			$dbms_database_open = false;
		}
		else
		{
			$dbms_database_open = true;
			$this->host = $host;
			$this->name = $name;
			$this->user = $user;
			$this->pass = $pass;
		}
		
			
			$result = mysql_query("SHOW TABLES FROM {$this->name}");
			while ($row = mysql_fetch_row($result)) {
				$this->tables[] = strtolower($row[0]);
			}
			
			foreach($this->tables as $k=>$tableName)
			{
				$oid = mysql_query("SHOW COLUMNS
						FROM {$tableName}");
						if (!$oid){
						echo Message::getInstance()->getMessage(MSG_ERROR_DATABASE_GENERIC)." (".basename(__FILE__).":".__LINE__.")";
								exit;
						}
		
						do {
						$data = mysql_fetch_assoc($oid);
						if ($data) {
		
						$this->fields[$tableName][$data['Field']] = true;
						}
						} while ($data);
			}
		self::$instance=$this;
	}

	function getEntityByName($name) {
		
		$result = false;
		if(is_array($GLOBALS))
			foreach($GLOBALS as $k=>$v)
			{
				if ($v->entityName == $name) {
					$result = $v;
				}
			}
			
		return $result;

	}

	function existsTable($name) {
		$result = false;
		for($i=0;$i<count($this->tables);$i++) {
			if ($this->tables[$i] == $name) {
				$result = true;
			}
		}

		return $result;
	}

	function existsField($tableName, $fieldName) {
		$turnback=false;
		if(isset($this->fields[$tableName][$fieldName]))
			$turnback=$this->fields[$tableName][$fieldName];
		return $turnback;
	}

	function updateTables()
	{
		$result = mysql_query("SHOW TABLES FROM {$this->name}");
		while ($row = mysql_fetch_row($result)) {
			$this->tables[] = strtolower($row[0]);
		}
		
		if(Settings::getModMode())
			foreach($this->tables as $k=>$tableName)
			{
				$oid = mysql_query("SHOW COLUMNS
						FROM {$tableName}");
				if (!$oid){
					echo Message::getInstance()->getMessage(MSG_ERROR_DATABASE_GENERIC)." (".basename(__FILE__).":".__LINE__.")";
					exit;
				}

				do {
					$data = mysql_fetch_assoc($oid);
					if ($data) {

						$this->fields[$tableName][$data['Field']] = true;
					}
				} while ($data);
			}
	}

	function getTableFields($tableName)
	{
		return $this->fields[$tableName];
	}
	
	static function testConnection($host,$name,$user,$pass) {
		$turnback=true;
		$connection = mysql_pconnect($host,$user,$pass);
		//$connection = mysql_pconnect('localhost', 'root', 'noris19611965');
		if ($connection) {
			$database=$connection;
			if (mysql_select_db($name)) {
				$turnback = true;
			} else {

				$turnback=false;
			}
		} else {
			$turnback=false;
		}
		return $turnback;
	}
}