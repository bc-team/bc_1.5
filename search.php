<?php
require_once "include/skin.inc.php";
require_once 'include/skinlet.inc.php';
require_once "include/beContent.inc.php";
require_once "include/entities.inc.php";
require_once "include/content.inc.php";
require_once "include/control/search/searchEngine.php";
require_once(realpath(dirname(__FILE__)).'/include/view/template/InitGraphic.php');



$main = new Skin();

InitGraphic::getInstance()->createGraphic($main);

$homeTemplate = new Skinlet("search");
$engine=new SearchEngine();

if(isset($_POST["search"])&& $_POST["search"]!="")
{
	$sintax=explode(":",$_POST["search"]);
	if(isset($sintax[1]))
	{
		$entityName=$sintax[0];
		$search= explode(" ",$sintax[1]);
	}
	else
	{
		$entityName=null;
		$search= explode(" ",$_POST["search"]);
	}
}
$homeTemplate->setContent("results", $engine->search($entityName,$search));
$homeTemplate->setContent("search_keywords", $_POST["search"]);
$homeTemplate->setContent("results_number", $engine->resultsNumber);

$main->setContent("body", $homeTemplate->get());
$main->close();
?>