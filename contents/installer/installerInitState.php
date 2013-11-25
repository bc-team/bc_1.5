<?php

require_once(realpath(dirname(__FILE__)) . '/installerState.php');
require_once(realpath(dirname(__FILE__)) . '/installerDatabaseState.php');
require_once(realpath(dirname(__FILE__)).'/../../include/view/template/InitGraphic.php');

/**
 * @access public
*/
class InstallerInitState extends InstallerState {

	/**
	 * @access public
	 */

	function __construct(){
		$this->nextState = new InstallerDatabaseState();
		$this->stateName = 'start';
	}

	public function updateState() {

		if(! $this->validData ){
			$this->nextState = $this;
			$file_return = file_put_contents(realpath(dirname(__FILE__)).'/../../contents/config.cfg',"");
		}
		else{
			$next_state = array('actualState' => $this->getNextState()->getStateName());

			//next stage of install workflow
			$this->request_config ['actual_state'] = $next_state;

			$file_return = file_put_contents(
					realpath(dirname(__FILE__)).'/../../contents/config.cfg',
					json_encode($this->request_config)
			);
		}
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
			$body = new Skinlet("installer_databaseform");
		else
			$body = new Skinlet("installer_init");

		$main->setContent("body", $body->get());

		$main->close();
	}

	public function getNextState(){
		return $this->nextState;
	}

	public function setInput($arrayInput){
		
		if( !file_exists(realpath(dirname(__FILE__)).'/../../contents/config.cfg') && !isset($arrayInput['stateComplete']) )		
			$this->validData = false;
		else 
			$this->validData = true;

	}
}
