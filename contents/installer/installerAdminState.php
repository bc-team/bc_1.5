<?php
require_once(realpath(dirname(__FILE__)) . '/installerState.php');
//require_once(realpath(dirname(__FILE__)) . '/installerTemplateState.php');
require_once(realpath(dirname(__FILE__)) . '/installerFinishState.php');

/**
 * @access public
*/
class InstallerAdminState extends InstallerState {

	private $admin_config, $install_config;
	private $usernameAdmin,$passwordAdmin, $emailAdmin, $nameAdmin, $surnameAdmin, $seo, $webApp;

	function __construct(){
		$this->nextState = new InstallerFinishState();
		$this->stateName = 'dbmsInstalled';
	}

	/**
	 * @access public
	 */
	public function updateState() {

		if(! $this->validData ){
			$this->nextState = $this;
		}

		$next_state = array('actualState' => $this->getNextState()->getStateName());

		//next stage of install workflow
		$this->request_config['actual_state'] = $next_state;

		$this->request_config['admin_config'] = $this->admin_config;

		$this->install_config = array ('installComplete' => 'install_complete');

		$this->request_config['install_config'] = $this->install_config;


		$file_return = file_put_contents(
				realpath(dirname(__FILE__)).'/../../contents/config.cfg',
				json_encode($this->request_config)
		);
	}

	public function updateOutput() {

        if ($this->validData) {
            header('location: install_complete.php');
        }else{
			$main = new Skin("system");

			$head = new Skinlet("frame-private-head");

			$main->setContent("head", $head->get());
			$header = new Skinlet("header");
            $header->setContent("webApp", 'Installing');
			$main->setContent("header", $header->get());
			$body = new Skinlet("installer_admin");
			$main->setContent("body", $body->get());
			$menu = new Skinlet("menu_installer");
            $footer = new Skinlet("footer");
            $menu->setContent('footer', $footer->get());
			$main->setContent("menu", $menu->get());
			$main->close();
        }
	}

	public function getNextState(){
		return $this->nextState;
	}

	public function setInput($arrayInput){
		$this->validData = false;
		if( file_exists(realpath(dirname(__FILE__)).'/../../contents/config.cfg')){

			/*
			 * retrieve a data from file config.cfg
			*/
			$this->request_config = json_decode(
					file_get_contents(
							realpath(dirname(__FILE__)).'/../../contents/config.cfg'), true);

			if( isset($arrayInput["usernameAdmin"])
				&& isset($arrayInput["passwordAdmin"])
					&& isset($arrayInput["emailAdmin"])
						&& isset($arrayInput["nameAdmin"])
							&& isset($arrayInput["surnameAdmin"]))
			{
				$this->usernameAdmin = $arrayInput["usernameAdmin"];
				$this->passwordAdmin = $arrayInput["passwordAdmin"];
				$this->emailAdmin = $arrayInput["emailAdmin"];
				$this->nameAdmin = $arrayInput["nameAdmin"];
				$this->surnameAdmin = $arrayInput["surnameAdmin"];
				$this->webApp = $arrayInput['webApp'];

				if($arrayInput['seo']==1)
					$this->seo = 'yes';
				else
					$this->seo = 'no';

				$this->admin_config = array (
						'username'=>$this->usernameAdmin,
						'password'=>$this->passwordAdmin,
						'email'=>$this->emailAdmin,
						'name'=>$this->nameAdmin,
						'surname'=>$this->surnameAdmin,
						'webApp'=>$this->webApp,
						'seo'=>$this->seo
				);

				$this->validData = true;

			}
		}
	}
}