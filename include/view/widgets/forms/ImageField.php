<?php
require_once(realpath(dirname(__FILE__)) . '/../../../../include/view/widgets/FormWidget.php');

/**
 * @access public
 * @author dipompeodaniele@gmail.com, n.sacco.dev@gmail.com
 * @package include.view.widgets.forms
 */
class ImageField extends FormWidget {

	/**
	 * @access public
	 * @param preload
	 * @ParamType string
	 */
	public function build($preload) {

		$value="";
		$preloadedId=0;
		
		if($this->form->entity->loaded && $preload==PRELOAD)
		{
			$entityInstance=$this->form->entity->instances[0];
			$preloadedId = $entityInstance->getFieldValue($this->name);

            if(Settings::getOperativeMode() == 'debug'){
                echo '<br />ImageField debugmode';
                var_dump($preloadedId);
            }
		}
		$key = $this->form->formHash;
		$widget = new Skinlet("widget/ImageField");
		$widget->setContent("label", $this->label);
		$widget->setContent("name",$key.'_'.$this->name);
		$widget->setContent("formHash",$key);
		$widget->setContent("loggedUsername",$_SESSION["user"]["username"]);
		$widget->setContent("preloadedImageId",$preloadedId);
		return $widget->get();
	}
}

/**
 * Factory for the checkbox widget
 * @author nicola, daniele
 *
 */
class ImageFieldFactory implements FormWidgetFactory
{
	public function create($form)
	{
		return new ImageField($form);
	}
}