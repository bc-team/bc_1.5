<?php
require_once(realpath(dirname(__FILE__)) . '/installerState.php');

/**
 * @access public
*/
class InstallerTemplateState extends InstallerState {

	private $template_config, $install_config;

	function __construct(){
		$this->nextState = null;
		$this->stateName = 'adminInstalled';
	}

	/**
	 * @access public
	 */
	public function updateState() {

		$this->nextState = $this;

		$next_state = array('actualState' => $this->getNextState()->getStateName());

		//next stage of install workflow
		$this->request_config['actual_state'] = $next_state;
			
		$this->request_config['template_config'] = $this->template_config;
		$this->request_config['install_config'] = $this->install_config;

		$file_return = file_put_contents(
				realpath(dirname(__FILE__)).'/../../contents/config.cfg',
				json_encode($this->request_config,JSON_PRETTY_PRINT)
		);
	}

	public function updateOutput() {

		if ($this->validData) {
			header('Location: install_complete.php');
		}
		else{

			$main = new Skin("installer");

			$head = new Skinlet("frame-public-head");

			$main->setContent("head", $head->get());
			$header = new Skinlet("header");
			$main->setContent("header", $header->get());

			$body = new Skinlet("installer_template");
			$main->setContent("body", $body->get());

			$footer = new Skinlet("footer");
			$main->setContent("footer", $footer->get());
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

			$this->template_config = '';
			$this->install_config = '';
			if( isset($arrayInput["userTemplate"]) && $arrayInput['userTemplate'] !=''  ){

				$this->userTemplate = $arrayInput['userTemplate'];

				$this->template_config = array ('userTemplate'=>$this->userTemplate);

				$this->install_config = array ('installComplete' => 'install_complete');

				$this->validData = true;
			}
		}
	}
}
?>