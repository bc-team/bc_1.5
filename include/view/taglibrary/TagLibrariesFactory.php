<?php

function recursiveFindClassFromDir($class,$dir)
{
	$elements_in_dir=scandir($dir);
	foreach($elements_in_dir as $k => $v)
	{
		if($v!="."&&$v!="..")
		{
			if(is_file($dir."/".$v) ){
				if($v==$class.".php"){
					require_once $dir . '/' . $class . '.php';
					
				}
			}
			else
			{
				recursiveFindClassFromDir($class, $dir."/".$v);
			}
		}
	}
}

spl_autoload_register(function ($class) {
	recursiveFindClassFromDir($class,realpath(dirname(__FILE__)));
});



	/**
	 * @access public
	*/
	class TagLibrariesFactory {

		public $supportedTaglibraries;
		private static $instance;

		public static function getInstance()
		{
			if(!isset(self::$instance))
			{
				self::$instance=new TagLibrariesFactory();
			}
			return self::$instance;
		}

		public function __construct()
		{
			if(!file_exists(Settings::getConfigPath()."/supportedtaglibraries.cfg"))
			{
				/**
				 $menu=new TagLibrary();
				 $menu->addTag("front", new TagMenu());
				 $menu->addTag("back",new TagMenuBack());

				 $this->supportedTaglibraries["menu"]=$menu;

				 $this->supportedTaglibraries["subtext"]=new TagSubText();
				 $this->supportedTaglibraries["formatdate"]=new TagFormatDate();
				 $this->supportedTaglibraries["strtolower"]=new TagStrToLower();
				 $this->supportedTaglibraries["seo_url"]=new TagSeoUrl();
				 $this->storeConfig();
				 */
				$this->loadFromFileSystem();
				$this->storeConfig();
			}
			else
				$this->loadFromConfig();
		}

		/**
		 * @access public
		 * @param aKey
		 * @ParamType aKey
		 */
		public function tag($tagKey,$parameters) {
			$pars=json_decode($parameters);
			$tagRoute= explode(":", $tagKey);
			$thisNodeKey=$tagRoute[0];
			unset($tagRoute[0]);
			$tagRoute = array_values($tagRoute);
			return $this->supportedTaglibraries[$thisNodeKey]->doIt($tagRoute,$pars);
		}

		public function storeConfig()
		{
			if(Settings::getOperativeMode()!="release")
			{
				echo "<br>".json_encode($this,JSON_PRETTY_PRINT);
			}
			else
			{
				file_put_contents (Settings::getConfigPath()."/supportedtaglibraries.cfg" ,json_encode($this,JSON_PRETTY_PRINT));
			}
		}

		public function loadFromConfig()
		{
			$structureAsJson=json_decode(file_get_contents (Settings::getConfigPath()."/supportedtaglibraries.cfg"));
			$tagLibrariesAsArray=get_object_vars($structureAsJson->supportedTaglibraries);
			foreach($tagLibrariesAsArray as $k=>$v)
			{
				if(isset($v->classname))
					$this->supportedTaglibraries[$k]=new $v->classname(get_object_vars($v));
			}
		}

		public function loadFromFileSystem()
		{
			$this->supportedTaglibraries=array();
			$folder_contents=scandir(realpath(dirname(__FILE__))."/catalog");
			$debug=Settings::getOperativeMode()!="release";
			if($debug)echo "<br><br>";

			foreach($folder_contents as $k=>$v)
			{
				if($v!="."&&$v!="..")
				{

					$tagLibraryIndex=explode(".",$v)[0];
					if($debug)var_dump ($tagLibraryIndex);

					if(is_dir(realpath(dirname(__FILE__)."/catalog/".$v)))
					{
						if($debug)echo "<br>**".$v." is dir<br>";
						$this->supportedTaglibraries[$tagLibraryIndex]=new TagLibrary(null,dirname(__FILE__)."/catalog/".$v,"as_file_system_element");
					}
					else
					{
						if($debug)echo "<br>**".$v." is not dir<br>";
						$this->supportedTaglibraries[$tagLibraryIndex]=new $tagLibraryIndex(null,dirname(__FILE__)."/catalog/".$v,"as_file_system_element");

					}
				}
			}
		}
	}
	?>