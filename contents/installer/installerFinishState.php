<?php
require_once(realpath(dirname(__FILE__)) . '/installerState.php');

/**
 * @access public
*/
class InstallerFinishState extends InstallerState {

	private $install_config;

	function __construct(){
		$this->nextState = null;
		$this->stateName = 'becontentInstalled';
	}

	/**
	 * @access public
	 */
	public function updateState() {

		$this->nextState = $this;

		$next_state = array('actualState' => $this->getNextState()->getStateName());

		//next stage of install workflow
		$this->request_config['actual_state'] = $next_state;
			
		//$this->request_config['install_config'] = $this->install_config;

		$file_return = file_put_contents(
				realpath(dirname(__FILE__)).'/../../contents/config.cfg',
				json_encode($this->request_config)
		);
	}

	public function updateOutput() {

		if ($this->validData) {
			header('Location: admin.php');
		}
		else{
			
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

            $body = new Skinlet("installer_init");
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

			$this->install_config = '';

			if( isset($arrayInput['installComplete']) ){
				header('location: install_complete.php');
			}
		}
	}


	/**
	 * Formats a JSON string for pretty printing
	 *
	 * @param string $json The JSON to make pretty
	 * @param bool $html Insert nonbreaking spaces and <br />s for tabs and linebreaks
	 * @return string The prettified output
	 * @author Jay Roberts
	 */
	function _format_json($json, $html = false) {
		$tabcount = 0;
		$result = '';
		$inquote = false;
		$ignorenext = false;

		if ($html) {
			$tab = "&nbsp;&nbsp;&nbsp;";
			$newline = "<br/>";
		} else {
			$tab = "\t";
			$newline = "\n";
		}

		for($i = 0; $i < strlen($json); $i++) {
			$char = $json[$i];

			if ($ignorenext) {
				$result .= $char;
				$ignorenext = false;
			} else {
				switch($char) {
					case '{':
						$tabcount++;
						$result .= $char . $newline . str_repeat($tab, $tabcount);
						break;
					case '}':
						$tabcount--;
						$result = trim($result) . $newline . str_repeat($tab, $tabcount) . $char;
						break;
					case ',':
						$result .= $char . $newline . str_repeat($tab, $tabcount);
						break;
					case '"':
						$inquote = !$inquote;
						$result .= $char;
						break;
					case '\\':
						if ($inquote) $ignorenext = true;
						$result .= $char;
						break;
					default:
						$result .= $char;
				}
			}
		}

		return $result;
	}
}
?>
