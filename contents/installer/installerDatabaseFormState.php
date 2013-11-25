<?php
require_once(realpath(dirname(__FILE__)) . '/installerState.php');
require_once(realpath(dirname(__FILE__)) . '/installerDatabaseState.php');

/**
 * @access public
*/
class InstallerDatabaseFormState extends InstallerState {

	private $next_state;
	
	function __construct() {
		$this->next_state = new InstallerDatabaseState();
	}
	
	/**
	 * @access public
	 */
	public function install()
	{
		
		$request_config = json_decode(
				file_get_contents(
						realpath(dirname(__FILE__)).'/../../contents/config.cfg'), true);
		
		$next_state = array(
				'nextState' => 'installerDatabaseState',
				'lastState' => 'installerDatabaseState'
		);
		
		//next stage of install workflow
		$request_config ['next_state'] = $next_state; 
		
		$file_return = file_put_contents(
				realpath(dirname(__FILE__)).'/../../contents/config.cfg',
				json_encode($request_config ,JSON_PRETTY_PRINT)
		);
	}
	
	public function draw() {
		
		$main = new Skin("installer");
		
		$head = new Skinlet("frame-public-head");
		
		$main->setContent("head", $head->get());
		$header = new Skinlet("header");
		$main->setContent("header", $header->get());
		
		$body = new Skinlet("installer_databaseform");
		$main->setContent("body", $body->get());
		
		$footer = new Skinlet("footer");
		$main->setContent("footer", $footer->get());
		$main->close();
	}
	
	public function getNextState(){
		return $this->next_state;
	}
}
?>