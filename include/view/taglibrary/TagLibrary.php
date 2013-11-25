<?php
class TagLibrary extends Tag{

	private $tags=array();



	public function __construct($structureAsArray=null,$fileSystemElement=null,$mode="as_array")
	{
		if($mode=="as_array")
		{
			if(isset($structureAsArray["classname"]) && isset($structureAsArray["tags"]))
			{
				$this->buildFromArray($structureAsArray);
			}
		}
		else
		{
			if(is_dir($fileSystemElement))
			{
				$this->buildFromFileSystem($fileSystemElement);
			}
		}
	}

	public function doIt($tagRoute,$parameters)
	{
		$turnback="";
		$thisNodeKey=$tagRoute[0];

		unset($tagRoute[0]);
		$tagRoute = array_values($tagRoute);

		if(isset($this->tags[$thisNodeKey]))
			$turnback=$this->tags[$thisNodeKey]->doIt($tagRoute,$parameters);

		return $turnback;
	}


	public function addTag($aKey, $tag)
	{
		$this->tags[$aKey]=$tag;
	}

	public function removeTag($aKey)
	{
		unset($this->tags[$aKey]);
	}

	public function jsonSerialize()
	{
		$turnback=array();
		$turnback["classname"]=get_class($this);
		$turnback["tags"]=$this->tags;
		return $turnback;
	}

	/**
	 * 
	 * @param unknown $fileSystemElement
	 */
	protected function buildFromFileSystem($fileSystemElement)
	{
		$this->tags=array();
		$folder_contents=scandir($fileSystemElement);
		$debug=Settings::getOperativeMode()!="release";
		if($debug)echo "<br><br>";
		
		foreach($folder_contents as $k=>$v)
		{
			if($v!="."&&$v!="..")
			{
		
				$tagLibraryIndex=explode(".",$v)[0];
				if($debug)var_dump ($tagLibraryIndex);
		
				if(is_dir($fileSystemElement."/".$v))
				{
					if($debug)echo "<br>**".$v." is dir<br>";
					$this->tags[$tagLibraryIndex]=new TagLibrary(null,$fileSystemElement."/".$v,"as_file_system_element");
				}
				else
				{
					if($debug)echo "<br>**".$v." is not dir<br>";
					$this->tags[$tagLibraryIndex]=new $tagLibraryIndex(null,$fileSystemElement."/".$v,"as_file_system_element");
		
				}
			}
		}
	}
	
	/**
	 * 
	 * @param unknown $structureAsArray
	 */
	protected function buildFromArray($structureAsArray)
	{
		$tagsStructureAsArray=get_object_vars($structureAsArray["tags"]);
		foreach($tagsStructureAsArray as $k=>$v)
		{
			$this->tags[$k]=new $v->classname(get_object_vars($v));
		}
	}
}
?>