<?php

require_once realpath(dirname(__FILE__))."/../../include/settings.inc.php";
require_once realpath(dirname(__FILE__))."/../../include/skin.inc.php";
require_once realpath(dirname(__FILE__))."/../../include/skinlet.inc.php";
require_once realpath(dirname(__FILE__))."/../../include/beContent.inc.php";

/**
 * @access public
 */
class  InstallerState {
	
	protected $stateName, $arrayInput, $validData, $nextState, $request_config;

	/**
	 * @access public
	 */
	public function updateState(){}
	
	/**
	 * @access public
	 */
	public function updateOutput(){}
	
	/**
	 * 
	 */
	public function setInput($arrayInput){
		$this->arrayInput = $arrayInput;
	}
	
	public function getStateName(){
		return $this->stateName;
	}
}