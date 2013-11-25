<?php 

class Settings
{
	private static $template_name="theme";
	private static $system_template_name="system";
	private static $config_path="contents";

	//Enhanches performances if disabled, disable after debugging
    /*set to true to create new tables in db*/
	private static  $modmode=true;

    /*set to debug to show html error*/
	private static $operative_mode="release";
	
	public static function getOperativeMode()
	{
		return self::$operative_mode;
	}
	
	public static function setOperativeMode($mode)
	{
		self::$operative_mode=$mode;
		if(Settings::getOperativeMode()=="release")
			error_reporting(E_ERROR);
		else
			error_reporting(E_ALL);
	}
	
	public static function getConfigPath()
	{
		return self::$config_path;
	}
	
	public static function getSkin()
	{
        $config = Config::getInstance()->getConfigurations();
		return "skins/".self::$template_name."/dtml/".$config['currentlanguage'];
	}
    public static function getSystemSkin()
	{
        $config = Config::getInstance()->getConfigurations();
		return "skins/".self::$system_template_name."/dtml/".$config['currentlanguage'];
	}
	
	public static function setSkinName($template_name)
	{
		self::$template_name = $template_name;
	}
	
	public static function getSkinName()
	{
		return self::$template_name;
	}

    public static function setSystemSkinName($template_name)
	{
		self::$system_template_name = $template_name;
	}

	public static function getSystemSkinName()
	{
		return self::$system_template_name;
	}
	
	public static function getModMode()
	{
		return self::$modmode;
	}
	
	public static function setModMode($modMode)
	{
		self::$modmode=$modMode;
	}
}