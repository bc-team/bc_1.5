<?php

require_once(realpath(dirname(__FILE__)) . '/installerState.php');
require_once(realpath(dirname(__FILE__)) . '/installerAdminState.php');

/**
 * @access public
*/
class InstallerDatabaseState extends InstallerState {

	private $database_config;
	private $username, $host, $password, $database, $prefix;

	function __construct(){
		$this->nextState = new InstallerAdminState();
		$this->stateName = 'nothingInstalled';
	}
	/**
	 * @access public
	 */
	public function updateState() {

		if(! $this->validData ){
			$this->nextState = $this;
		}

		$next_state = array('actualState' => $this->getNextState()->getStateName());

		$this->request_config['actual_state'] = $next_state;

		$this->request_config['database_config'] = $this->database_config;
		
		$file_return = file_put_contents(realpath(dirname(__FILE__)).'/../../contents/config.cfg',
				json_encode($this->request_config)
		);

		if(! $file_return)
			echo 'error to create file or to write file';
	}

	public function updateOutput() {

        $main = new Skin("system");
        $head = new Skinlet("frame-private-head");
        $main->setContent("head", $head->get());

        $header = new Skinlet("header");
        $header->setContent('webApp', 'Installing');
        $main->setContent("header", $header->get());

        $menu = new Skinlet('menu_installer');

        $footer = new Skinlet("footer");
        $menu->setContent("footer", $footer->get());
        $main->setContent('menu', $menu->get());

		if($this->validData)
			$body = new Skinlet("installer_admin");
		else
			$body = new Skinlet("installer_databaseform");

		$main->setContent("body", $body->get());

		$footer = new Skinlet("footer");
		$main->setContent("footer", $footer->get());
		$main->close();
	}

	public function getNextState(){
		return $this->nextState;
	}

	public function setInput($arrayInput){
		var_dump($arrayInput);
		$this->validData = false;
		if( file_exists(realpath(dirname(__FILE__)).'/../../contents/config.cfg')){
			$this->request_config = json_decode(
					file_get_contents(realpath(dirname(__FILE__)).'/../../contents/config.cfg'), true);
			
			if( ( isset($arrayInput["usernameMysql"]) && $arrayInput["usernameMysql"] != '')
				&& isset($arrayInput["host"]) 
					&& ( isset($arrayInput["database"]) && $arrayInput["usernameMysql"] != ''))
			{
				$this->username = $arrayInput["usernameMysql"];
				$this->password = $arrayInput["passwordMysql"];
				$this->host = $arrayInput["host"];
				$this->database = $arrayInput["database"];
				$this->prefix = $arrayInput['prefix'];

				if( DB::testConnection($this->host, $this->database, $this->username, $this->password) )
				{
					$this->validData = true;
					$this->database_config = array (
							'username'=>$this->username,
							'password'=>$this->password,
							'host'=>$this->host,
							'database'=>$this->database,
							'prefix'=>$this->prefix
					);
				}
			}
		}
	}
}
