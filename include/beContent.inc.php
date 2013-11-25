<?php



/**
 * Configurations inclusion
 */
require_once(realpath(dirname(__FILE__))."/settings.inc.php");

if(Settings::getOperativeMode()=="release")
	error_reporting(E_ERROR);

require_once(realpath(dirname(__FILE__))."/config.inc.php");
require_once realpath(dirname(__FILE__))."/message.inc.php";
require_once realpath(dirname(__FILE__))."/parser.inc.php";
require_once realpath(dirname(__FILE__))."/db.inc.php";
//$RESERVEDWORDS = Array('page');



Class beContent {
	var
	$files,
	$selfrefs,
	$entities,
	$currentform,
	$comments;

	private static $instance=null;

	public static function getInstance()
	{
		if(!isset(self::$instance))
		{
			self::$instance=new beContent();
		}
		return self::$instance;
	}

	function beContent() {

	}
}

$config = Config::getInstance()->getConfigurations();

/** SQL INJECTION PREVENTION PROCEDURE
 *
 */
if (basename($_SERVER['SCRIPT_FILENAME']) != "error.php")
{
	$mysql = new mysqli(
        $config['database']['host'],
        $config['database']['username'],
        $config['database']['password'],
        $config['database']['database']
    );
	$mysql->set_charset('unicode');
	foreach ($_REQUEST as $k => $v) {
		$_REQUEST[$k] = $mysql->real_escape_string($v);
	}
}

/**
 * Instantiates the database
 * @var unknown
 */
$database = new DB(
        $config['database']['host'],
		$config['database']['database'],
		$config['database']['username'],
		$config['database']['password']
);

require_once realpath(dirname(__FILE__))."/entity.inc.php";
require_once realpath(dirname(__FILE__))."/skin.inc.php";
require_once realpath(dirname(__FILE__)).'/skinlet.inc.php';
require_once realpath(dirname(__FILE__))."/form.inc.php";


if($config['installed']==true)
	require_once(realpath(dirname(__FILE__))."/entities.inc.php");