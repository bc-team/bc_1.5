<?php
/**
 * @access public
 * @author Di Pompeo Sacco
 * @package include.view.widgets
 */
class FormWidget {
	public $form;
	public $name;
	public $value;
	public $label;
	public $description;
	public $type;
	public $size;
	public $mandatory;
	public $maxlength;
	public $controlledField;
	public $referenceField;
	public $referenceIndex;
	public $preset;
	public $values;
	public $thumbSize;
	public $entity;
	public $positionField;
	public $rows;
	public $cols;
	public $orientation;
	public $text;
	public $mainEntry;
	
	/**
	 * @access public
	 * @param form
	 * @ParamType form 
	 */
	public function __construct($form) {
		$this->form=$form;
	}

	/**
	 * @access public
	 * @param v
	 * @param preload
	 * @ParamType v 
	 * @ParamType preload 
	 */
	public function build($preload) {
		return "";
	}

	/**
	 * @access public
	 * @param v
	 * @param preload
	 * @ParamType v 
	 * @ParamType preload 
	 */
	public function emit($v, $preload) {
		// Not yet implemented
	}
}
/**
 * Abstract factory for this widget tipe 
 * @author nicola
 *
 */
interface FormWidgetFactory
{
	public function create($form);
}

/**
 * requires all supported widgets for form
 * @var unknown_type
 */
$files=glob("include/view/widgets/forms". '/*.php');
foreach ( $files as $file )
	require_once( $file );

require_once("FormWidgetBuilder.php");