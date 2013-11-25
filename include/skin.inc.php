<?php
require_once(realpath(dirname(__FILE__)).'/libs/smarty/Smarty.class.php');
//require_once(realpath(dirname(__FILE__)).'/view/taglibrary/TagLibrariesFactory.php');
Class Skin  {

	var
	$name,
	$templates,
	$frame,
	$placeholders,
	$private,
	$cache,
	$cached,
	$cache_name,
	$timeout,
	
	$smarty;


	function Skin($skin = "") {
		if ($skin == "") {
			$skin=Settings::getSkinName();
		} else {
			Settings::setSkinName($skin);
		}
		$this->name = Settings::getSkin();

		$this->resolve();

		$this->smarty = new Smarty();
		
		$this->smarty->setTemplateDir(Settings::getSkin());
		$this->smarty->setCompileDir('include/libs/smarty/templates_c');
		$this->smarty->setCacheDir('include/libs/smarty/cache');
		$this->smarty->setConfigDir('include/libs/smarty/configs');
		
	}

		function resolve() {
		if (class_exists("Auth")) {
			if (isset($this->frame)) {
				$this->template_name=Settings::getSkin()."/{$this->frame}.html";
				
			} else {
				$this->template_name=Settings::getSkin()."/frame-private.html";
			}
			$this->private = true;
		} else {
			if (isset($this->frame)) {
				$this->template_name=Settings::getSkin()."/{$this->frame}.html";
			} else {
				$this->template_name=Settings::getSkin()."/frame-public.html";
			}
			$this->private = false;
		}
	}

	function setFrame($frame){
		$this->frame = $frame;
		$this->resolve();

	}

	function close(){
		//$this->smarty->assign("sys",TagLibrariesFactory::getInstance());
		$this->smarty->display($this->template_name);
	}
	
	function setContent($name,$value,$pars="")
	{
		$this->smarty->assign($name,$value);
	}
	
	function get()
	{
		return $this->smarty->fetch($this->template_name);
	}

}