<?php
require_once("FormWidget.php");
class FormWidgetBuilder
{
	/**
	 * this array includes an instance for all the factories of supported widgets for a form
	 * @var unknown
	 */
	private $supported_widgets_factories;
	private static $instance;
	
	private function __construct()
	{
	}
	
	public static function getInstance()
	{
		if(!isset(FormWidgetsBuilder::$instance))
		{
			FormWidgetsBuilder::$instance =new FormWidgetsBuilder();
		}
		return FormWidgetsBuilder::$instance;
	}
	
	public function build($form,$widget_type){
		
		
		return $this->supported_widgets_factories[$widget_type]->create($form);
	}
	
}
?>