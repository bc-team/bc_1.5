<?php
require_once(realpath(dirname(__FILE__)) . '/../../../../include/view/widgets/FormWidget.php');

/**
 * @access public
 * @author Di Pompeo Sacco
 * @package include.view.widgets.forms
 */
class File2FolderField extends FormWidget {

	/**
	 * @access public
	 * @param v
	 * @param preload
	 * @ParamType v 
	 * @ParamType preload 
	 */
	public function build($preload) {
		/**
		 * retrieving the field that has the same name of the graphic element that we're creating
		 */
		$field_to_modify=$this->form->entity->getField($v['name']);
		/**
		 * Observation, this time the field is a file so four fields are involved in the operation, 
		 * for this reason four variables must be initialized
		 */
		$field_to_modify_type=$this->form->entity->getField($v['name']."_type");
		$field_to_modify_filename=$this->form->entity->getField($v['name']."_filename");
		$field_to_modify_reference=$this->form->entity->getField($v['name']."_reference");
		
		if ($preload) {
			if (isset($this->form->helpers[$v['name']])) {
				$content .= "    <td>{$v["label"]} <a href=# title=\"{$this->form->helpers[$v['name']]}\"><img src=\"img/form/help.gif\" class=\"helper\"></a> </td>\n";
			} else {
				$content .= "<label class=\"cells\"{$v["label"]}</label>\n";
			}
			$content .= "<input class=\"cells mb20 ilne-item\" type=\"file\" name=\"{$v['name']}\"> <input type=\"hidden\" name=\"{$v['name']}_hidden\" value=\"{$field_to_modify_reference}\" /> <input type=\"hidden\" name=\"{$v['name']}_reference\" value=\"{$field_to_modify_reference}\" />\n";
			if ($field_to_modify_reference) {
				switch ($field_to_modify_type) {
					case "image/jpeg":
					case "image/gif":
						$content .= " <div class=\"image-show\" id=\"{$v['name']}\" >\n<input type=\"text\" class=\"file\" value=\"".$field_to_modify_filename."\" disabled /><img src=\"img/beContent/show-gray.jpg\" onClick=\"image_show('{$v['name']}')\"><div id=\"{$v['name']}_img\">";
						$content .= "<span>".$field_to_modify_type."</span><br />\n<img class=\"left\" src=\"show.php?token=".md5($this->form->entity->name.$v['name'])."&id={$_REQUEST['value']}&width=188\">\n</div>\n</div>";
						$content .= "<input class=\"clear\" type=\"checkbox\" name=\"{$v['name']}_delete\" value=\"*\"> ".Message::getInstance()->getMessage(MSG_FILE_DELETE);
						break;
					case "video/x-flv":
					case "application/octet-stream":
						/*
						06.01.2008
						FLASH VIDEO FLV
						It may be suitable to check for the .flv extension since
						the MIME may include anything.
						*/
						$content .= " <div class=\"image-show\" id=\"{$v['name']}\" >\n<input type=\"text\" class=\"file\" value=\"".$field_to_modify_filename."\" disabled /><img src=\"img/beContent/show-gray.jpg\" onClick=\"image_show('{$v['name']}')\">";
						$content .= "<input class=\"file_delete\" type=\"checkbox\" name=\"{$v['name']}_delete\" value=\"*\"><span class=\"delete\">".Message::getInstance()->getMessage(MSG_FILE_DELETE)."</span>\n";
						$content .= "<div id=\"{$v['name']}_img\">";
						$src = "{Config::getInstance()->getConfigurations()['upload_folder']}/{$field_to_modify_reference}";
						$width = 186;
						$height = 149;
						$content .= "\n\n<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0\" width=\"{$width}\" height=\"{$height}\" id=\"FLVPlayer\">\n<param name=\"movie\" value=\"FLVPlayer_Progressive.swf\" />\n<param name=\"salign\" value=\"lt\" />\n<param name=\"quality\" value=\"high\" />\n<param name=\"scale\" value=\"scale\" />\n<param name=\"FlashVars\" value=\"&skinName=includes/flv/players/player-unov&streamName={$src}&autoPlay=false&autoRewind=false\" />\n<embed src=\"FLVPlayer_Progressive.swf\" flashvars=\"&skinName=includes/flv/players/player-unov&streamName={$src}&autoPlay=false&autoRewind=false\" quality=\"high\" scale=\"noscale\" width=\"{$width}\" height=\"{$height}\" name=\"FLVPlayer\" salign=\"LT\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" />\n</object>\n\n";
						$content .= "</div>\n";
						break;
					default:
						/* UNKNOWN MIME TYPE */
						$content .= " <div class=\"image-show\" id=\"{$v['name']}\" ><input type=\"text\" class=\"file\" value=\"".$field_to_modify_filename."\" disabled /><a target=\"_blank\" title=\"{$field_to_modify_filename}\" href=\"show.php?token=".md5($this->form->entity->name.$v['name'])."&id={$_REQUEST['value']}\"><img src=\"img/beContent/show-gray-link.jpg\"></a></div>";
						$content .= "<input class=\"clear\" type=\"checkbox\" name=\"{$v['name']}_delete\" value=\"*\"> ".Message::getInstance()->getMessage(MSG_FILE_DELETE);
						break;
				}
				$content .= " </td>\n";
			} else {
				/* Empty */
				$content .= " <div class=\"image-show\" ><input type=\"text\" class=\"file\" value=\"".Message::getInstance()->getMessage(MSG_FILE_NONE)."\" disabled /><img src=\"img/beContent/show-gray-disabled.jpg\"></div> </td>\n";
			}
		} else {
			if (isset($this->form->helpers[$v['name']])) {
				$content .= "    <td>{$v["label"]} <a href=# title=\"{$this->form->helpers[$v['name']]}\"><img src=\"img/form/help.gif\" class=\"helper\"></a> </td>\n";
			} else {
				$content .= "<label class=\"cells\">{$v["label"]}</label>\n";
			}
			$content .= "<input class=\inl_blk cells mb20\" type=\"file\" name=\"{$v['name']}\"/>\n";
		}	
		return $content;
	}
}

/**
 * Factory for the checkbox widget
 * @author nicola
 *
 */

class File2FolderFieldFactory implements FormWidgetFactory
{
	public function create($form)
	{
		return new File2FolderField($form);
	}
}
?>