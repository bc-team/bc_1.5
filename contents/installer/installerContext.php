<?php

//require_once realpath(dirname(__FILE__))."/../../include/settings.inc.php";
//require_once realpath(dirname(__FILE__))."/../../include/skin.inc.php";
//require_once realpath(dirname(__FILE__))."/../../include/skinlet.inc.php";
//require_once realpath(dirname(__FILE__))."/../../include/beContent.inc.php";

require_once realpath(dirname(__FILE__)).'/installerInitState.php';

/**
 * @access public
 */
class InstallerContext {

	private $state, $states;

	function __construct(){

		$initState = new InstallerInitState();
		$databaseState = new InstallerDatabaseState();
		$dbmsInstalled = new InstallerAdminState();
		//$adminInstalled = new InstallerTemplateState();
		$becontentInstalled = new InstallerFinishState();

		$this->states[$initState->getStateName()] = $initState;
		$this->states[$databaseState->getStateName()] = $databaseState;
		$this->states[$dbmsInstalled->getStateName()] = $dbmsInstalled;
		//$this->states[$adminInstalled->getStateName()] = $adminInstalled; 
		$this->states[$becontentInstalled->getStateName()] = $becontentInstalled;

		$actualState = null;
		if( file_exists(realpath(dirname(__FILE__)).'/../../contents/config.cfg')){

			$request_config = json_decode(file_get_contents(realpath(dirname(__FILE__)).'/../../contents/config.cfg'));

			if ( isset($request_config->actual_state) && isset($this->states[$request_config->actual_state->actualState]) ){

					$actualState= $this->states[$request_config->actual_state->actualState];
				}
				else{
					$actualState = $this->states[$initState->getStateName()];
				}
		}
		else{
			$actualState= $this->states[$initState->getStateName()];
		}
		$actualState->setInput($_POST);
		$actualState->updateState();
		$actualState->updateOutput();
	}
}
$install = new InstallerContext();

