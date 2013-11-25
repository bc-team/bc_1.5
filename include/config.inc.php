<?php


DEFINE("NONE", "NONE");

define('HTML', "HTML");
define('IMG', "IMG");
define('HTML_IMG', "HTML_IMG");

define('AJAX', 'ajax');

#XMLCHARS
//Used in parser
define('MODE1','MODE1');
define('MODE2','MODE2');
define('MODE3','MODE3');


# OPERATING SYSTEMS

define('WINDOWS', "WINDOWS");
define('LINUX', "LINUX");
define('MACOS', "MACOS");


define('ADD',"add");
define('EDIT',"edit");
define('DELETE', "delete");

define('NO_DELETE', true);
define('ALL',"ALL");


/* Relation orientation */

define('LEFT', "LEFT");
define('RIGHT', "RIGHT");

#define(MSG_SURE, "sure");

define('AUTO', "AUTO");

define('ITALIANO',"it");
define('ENGLISH',"en");

define('PRESENT', "PRESENT");
define('ABSENT', "ABSENT");


define('PRELOAD',"preload");
define('MANDATORY',"yes");
define('OPTIONAL', 'OPTIONAL');
define('EQUAL',"equal");
define('IMPLIES', "implies");

define('LIMIT', "limit");
define('NORMAL', 'NORMAL');
define('COUNT', 'COUNT');
define('ADVANCED', 'ADVANCED');
define('PARSE', 'PARSE');


/* DATE FORMATS */

define('RSS', 'RSS');
define('BLOG', 'BLOG');
define('LETTERS', "LETTERS");
define('SHORT_LETTERS', "SHORT_LETTERS");
define('STANDARD', "STANDARD");
define('STANDARD_PLUS', "STANDARD_PLUS");
define('EXTENDED', "EXTENDED");
define('EXTENDED_PLUS', "EXTENDED_PLUS");
define('TIME', 'TIME');
define('YEAR', 'YEAR');

/* BASIC DATATYPES */

define('VARCHAR',"VARCHAR");
define('HIDDEN', 'HIDDEN');
define('TEXT',"TEXT");
define('FILE',"FILE");
define('FILE2FOLDER', "FILE2FOLDER");
define('IMAGE', "IMAGE");
define('INT',"INT");
define('BLOB',"BLOB");
define('STANDARD_PRIMARY_KEY_TYPE', "STANDARD_PRIMARY_KEY");
define('ID', "ID");
define('DATE',"DATE");
define('LONGDATE', "LONGDATE");
define('POSITION',"POSITION");
define('PASSWORD',"PASSWORD");
define('COLOR', "COLOR");
define('CHECKBOX', "CHECKBOX");
define('RELATION_MANAGER', "RELATION MANAGER");

/* WIDGET TYPES */

define('SELECT_FROM_REFERENCE', "selectFromReference");
define('RADIO_FROM_REFERENCE', "radioFromReference");

/* to be completed */


define('WITH_OWNER',"WITH_OWNER");
define('BY_POSITION',"BY_POSITION");
define('MD5', "MD5");

define('POST',"POST");
define('GET',"GET");

/* NOTIFY MESSAGES */

define('NOTIFY_ITEM_ADDED',"801");
define('NOTIFY_ITEM_UPDATED',"802");
define('NOTIFY_ITEM_DELETED',"803");
define('NOTIFY_ITEM_INTEGRITY_VIOLATION',"804");

/* FILE UPLOAD MESSAGES */

define('MSG_REPORT_EMPTY', "501");

define('MSG_FILE_NONE', "601");
define('MSG_FILE_DELETE', "602");

/* ERROR MESSAGES */

define('MSG_ERROR_DATABASE_GENERIC',"900");
define('MSG_ERROR_DATABASE_OPEN',"901");
define('MSG_ERROR_DATABASE_CONNECTION',"902");
define('MSG_ERROR_DATABASE_TABLE',"903");
define('MSG_ERROR_DATABASE_QUERY',"904");
define('MSG_ERROR_DATABASE_DUPLICATE_KEY',"905");
define('MSG_ERROR_DATABASE_RELOAD',"906");


define('MSG_ERROR_DATABASE_PRESENTATION',"907");
define('MSG_ERROR_UNKNOWN_ENTITY',"908");

define('MSG_ERROR_TRIGGERS',"909");
define('MSG_ERROR_RELATION_MANAGER',"910");
define('MSG_ERROR_DATABASE_RELATION_INSERT',"911");
define('MSG_ERROR_SESSION',"912");
define('MSG_ERROR_DATABASE_DELETION',"913");
define('MSG_ERROR_DATABASE_BOOTSTRAP',"914");
define('MSG_ERROR_DATABASE_INIT', "915");
define('MSG_ERROR_FILE_EXIST', "916");


/* JAVASCRIPT MESSAGES */

define('WARNING', "000");

define('MSG_JS_INSERT',"701");
define('MSG_JS_SURE',"702");
define('MSG_JS_SELECT',"703");
define('MSG_JS_MODERATION',"704");
define('MSG_JS_RADIO', "705");
define('MSG_JS_RELATIONMANAGER', "706");
define('MSG_JS_IMPLIES', "707");
define('MSG_JS_EXTENSION', "708");
define('MSG_JS_INSERT_TIME', "709");

/* BUTTON LABELS */

define('BUTTON_ACCEPT',"1001");
define('BUTTON_REFUSE',"1002");
define('BUTTON_ADD', "1003");
define('BUTTON_EDIT', "1004");
define('BUTTON_DELETE', "1005");

define('FIELDSET', "1006");

define('MODERATION_ACCEPT',"1011");
define('MODERATION_REFUSE',"1012");
define('MODERATION_EXPIRED',"1013");

/* RSS MODALITY */
define('MODALITY1',"1101");
define('MODALITY2',"1102");
define('MODALITY3',"1103");
define('RSS_MODALITY1_MSG', "1104");
define('RSS_MODALITY2_MSG', "1105");

/* SYSTEM USER GROUPS */
define('ADMIN', 1);
define('OMIT_LOGGED_USER', "OMIT_LOGGED_USER");

DEFINE("NEWS", "news");



class Config{

	private $configurations=array();

	public function getConfigurations()
	{
		return $this->configurations;
	}

	private static $instance;

	public static function getInstance()
	{
		if(!isset(self::$instance))
		{
			self::$instance = new Config();
		}
		return self::$instance;
	}

	public function __construct()
	{

		/**
		 * Installation check
		 */
		if(!file_exists ( realpath(dirname(__FILE__))."/../contents/config.cfg") && basename($_SERVER["SCRIPT_NAME"])!= "installer.php")
		{
			Header("Location: installer.php");
		}
		else
		{
			$file_data = json_decode(file_get_contents(realpath(dirname(__FILE__))."/../contents/config.cfg"),true);

			$this->configurations['database'] =$file_data["database_config"];
			$this->configurations['defaultuser'] = $file_data["admin_config"];
		}
		if(!file_exists ( realpath(dirname(__FILE__))."/../contents/installation_info.cfg") && basename($_SERVER["SCRIPT_NAME"])!= "install_complete.php")
		{
			$this->configurations["installed"]=false;
		}
		else
		{
			$this->configurations["installed"]=true;
		}

		$this->configurations['language'] = ITALIANO;
		$this->configurations['website'] = Array(
				"name" 		=> "Disim",
				"payoff"	=> "",
				"email"		=> "info@nbecontent.org",
				"domain" 	=> "disim.univaq.it",
				"fulldomain" => "http://ricerca.disim.univaq.it",
				"keywords"	=> "Disim",
				"description" => "Dipartimento di Ingegneria e Scienze dell'Informazione e Matematica"

		);

		$this->configurations['upload_folder'] = "upload";		// Upload directory to be used by the FILE2FOLDER types, it must

		$this->configurations['registered_usergroup'] = 20000;	// The registered user group id, 20000 is it does not exists
		$this->configurations['admin_usergroup'] = 1;				// Default administration usergroup, do not change


		switch ($_SERVER['SERVER_NAME']) {			// Base value depending on the $_SERVER['SERVER_NAME'] value
			case "localhost":
				$this->configurations['base'] = "researchware";
				break;
			case "www.terraemotus.it":
				$this->configurations['base'] = "";
				break;
		}

		$this->configurations['languages']['it'] = true;			// Enabled languages
		$this->configurations['languages']['en'] = true;


		if (!isset($_SESSION['language'])) {

			switch (substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2)) {
				case "it":
				case "en":
					$_SESSION['language'] = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
					break;
				default:
					$_SESSION['language'] = "en";
					break;
			}
		} else {

			if (isset($_REQUEST['lan'])) {
				$_SESSION['language'] = $_REQUEST['lan'];
			}
		}

		$this->configurations['currentlanguage'] = $_SESSION['language'];
	}
}

$config=Config::getInstance()->getConfigurations();