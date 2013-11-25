<?php
require_once(realpath(dirname(__FILE__)).'/libs/smarty/Smarty.class.php');
require_once(realpath(dirname(__FILE__)).'/skin.inc.php');

Class Skinlet{
	public $smarty, $template_name;

    function Skinlet($template) {

		if (!strpos($template, ".")) {
			$this->template_name=$template.".html";
		} else {
			$this->template_name=$template;
		}

        $this->smarty = new Smarty();
		
		$this->smarty->setTemplateDir(Settings::getSkin());
		$this->smarty->setCompileDir('include/libs/smarty/templates_c');
		$this->smarty->setCacheDir('include/libs/smarty/cache');
		$this->smarty->setConfigDir('include/libs/smarty/configs');
	}
	
	
	function setContent($name,$value,$pars="")
	{
		$this->smarty->assign($name,$value);
	}

	function get()
	{
		//$this->smarty->assign("sys",TagLibrariesFactory::getInstance());
		return $this->smarty->fetch(Settings::getSkin()."/{$this->template_name}");
	}
}
