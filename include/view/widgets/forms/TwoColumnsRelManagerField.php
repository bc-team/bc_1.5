<?php
require_once(realpath(dirname(__FILE__)) . '/../../../../include/view/widgets/FormWidget.php');

/**
 * @access public
 * @author Di Pompeo Sacco
 * @package include.view.widgets.forms
 */
class TwoColumnsRelManagerField extends FormWidget {

	/**
	 * 
	 * (non-PHPdoc)
	 * @see FormWidget::build()
	 * @access public
	 * @param v
	 * @param preload
	 * @ParamType v 
	 * @ParamType preload 
	 */
	public function build($preload) {
		$content .= "    <td valign=\"TOP\"></td>\n";
				switch ($v['orientation']) {
					case RIGHT:
		$mainEntity = $this->form->entity->entity_1;
		$secondaryEntity = $this->form->entity->entity_2;
		break;
					case LEFT:
		$mainEntity = &$this->form->entity->entity_2;
		$secondaryEntity = &$this->form->entity->entity_1;
		break;
				}
				//setto i valori necessari in caso di gestione degli Rss
				if($this->form->mainFormEntity->rss)
				{
					$query1="SELECT bc_channel.title FROM bc_channel
					LEFT JOIN channel_entity
					ON bc_channel.id=channel_entity.id_bc_channel
					WHERE entity=\"{$this->form->mainFormEntity->name}\"";
					$listChannel=Parser::getResultArray($query1,'title');
					if(!is_array($listChannel))$listChannel=array();
					$cont=count($listChannel);
					$query1="SELECT modality FROM bc_rss_mod WHERE entity=\"{$this->form->mainFormEntity->name}\"";
					$rssMod=Parser::getResultArray($query1,'modality');
				}
				/* this fetches all the item which should be put into checkboxes */
				$data = $secondaryEntity->getReferenceWithCondition($v['condition']);
				$content .= "<td>\n";
				#print_r($_REQUEST);
				#echo "<hr>";
				if ((($this->form->entity->entity_2->owner) and ($v['orientation'] == RIGHT)) or
		(($this->form->entity->entity_1->owner) and ($v['orientation'] == LEFT))) {
					$your = Message::getInstance()->getMessage(FIELDSET);
				} else {
					$your = "";
				}
				$id = uniqid(time());
				if ($preload) {
					$content .= "<fieldset><legend>{$your} {$v["label"]}</legend>\n";
					if ($this->form->description != "") {
		$content .= "{$this->form->description}<br/><br/>\n";
					}
					$content .= "<table width=\"90%\">";
					$counter = 0;
					if ((count($data) > 0) and ($data != "")) {
		$first=true;
		$c=0;
		foreach($data as $key => $value) {
			$counter++;
			if (isset($_REQUEST["{$v['name']}_{$value['value']}"])) {
				if($this->form->mainFormEntity->rss) {
					if (in_array($value['text'],$listChannel)) {
						switch ($rssMod[0]) {
							case MOD3:
								$content .= " <input class=\"clear\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\" CHECKED> {$value['text']}<br>\n";
								break;
							case MOD2:
								$c++;
								if($first) {
									$first=false;
									$content .= " <input id=\"0\"class=\"clear\" type=\"checkbox\" name=\"rss_mod2\" value=\"0\" onClick=\"reload({$cont});\" CHECKED> ".Message::getInstance()->getMessage(RSS_MODALITY2_MSG)."\n";
								}
								$content .= " <input id=\"{$c}\" style=\"display : none\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\" CHECKED>\n";
								break;
							case MOD1:
								$content .= " <input style=\"display : none\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\" CHECKED>\n";
								if ($first) {
									$content .=  Message::getInstance()->getMessage(RSS_MODALITY1_MSG);
									$first = false;
								}
								break;
						}
					}
				} else {
					if (($counter % 2) == 1) {
						$content .= Parser::first_comma($id, "</td></tr>");
						$content .= "<tr><td>";
					} else {
						$content .= "</td><td>";
					}
					$name = "{$v['name']}_".Parser::encode_name($value['value']);
					$content .= " <input class=\"\" type=\"checkbox\" name=\"{$name}\" value=\"{$value['value']}\" CHECKED> {$value['text']}\n";
				}
			} else {
				if($this->form->mainFormEntity->rss)
				{
					if (in_array($value['text'],$listChannel))
					{
						switch ($rssMod[0])
						{
							case MOD3:
								$content .= " <input class=\"clear\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\"> {$value['text']}<br>\n";
								break;
							case MOD2:
								$c++;
								if($first)
								{
									$first=false;
									$content .= " <input id=\"0\"class=\"clear\" type=\"checkbox\" name=\"rss_mod2\" value=\"0\" onClick=\"reload({$cont});\" CHECKED> ".Message::getInstance()->getMessage(RSS_MODALITY2_MSG)."\n";
								}
								$content .= " <input id=\"{$c}\" style=\"display : none\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\">\n";
								break;
							case MOD1:
								$content .= " <input style=\"display : none\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\" CHECKED>\n";
								if ($first) {
									$content .=  Message::getInstance()->getMessage(RSS_MODALITY1_MSG);																$first = false;
								}
								break;
						}
					}
				}else{
					if (($counter % 2) == 1) {
						$content .= Parser::first_comma($id, "</td></tr>");
						$content .= "<tr><td>";
					} else {
						$content .= "</td><td>";
					}
					$name = "{$v['name']}_".Parser::encode_name($value['value']);
					$content .= " <input class=\"clear\" type=\"checkbox\" name=\"{$name}\" value=\"{$value['value']}\"> {$value['text']}\n";
				}
			}
		}
					}
					$content .= "</td></tr></table>";
					$content .= "</fieldset>\n";
				} else {
					$content .= "<fieldset><legend>{$your}{$v["label"]}</legend>\n";
					if ($this->form->description != "") {
		$content .= "{$this->form->description}<br/><br/>\n";
					}
					$content .= "<table width=\"90%\">\n";
					$content .= "<tr>";
					if ((count($data)>0) && ($data != "")) {
		$first=true;
		$c=0;
		foreach($data as $key => $value) {
			if($this->form->mainFormEntity->rss)
			{
				if (in_array($value['text'],$listChannel))
				{
					switch ($rssMod[0])
					{
						case MOD3:
							$content .= " <input class=\"clear\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\"> {$value['text']}<br>\n";
							break;
						case MOD2:	if($first)
						{
							$first=false;
							$content .= " <input id=\"0\"class=\"clear\" type=\"checkbox\" name=\"rss_mod2\" value=\"0\" onClick=\"reload({$cont});\" CHECKED> ".Message::getInstance()->getMessage(RSS_MODALITY2_MSG)."\n";
						}
						$c++;
						$content .= " <input id=\"{$c}\" style=\"display : none\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\">\n";
						break;
						case MOD1:
							$content .= " <input style=\"display : none;\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\" CHECKED>\n";
							if ($first) {
								$content .=  Message::getInstance()->getMessage(RSS_MODALITY1_MSG);																$first = false;
							}
							break;
					}
				}
			}
			else
			{
				if (($counter % 2) == 1) {
					$content .= Parser::first_comma($id, "</td></tr>");
					$content .= "<tr><td>";
				} else {
					$content .= "</td><td>";
				}
				$name = "{$v['name']}_".Parser::encode_name($value['value']);
				$content .= "<input class=\"clear\" type=\"checkbox\" name=\"{$name}\" value=\"{$value['value']}\"> {$value['text']}\n";
			}
		}
					}
					$content .= "</tr></table>";
					$content .= "</fieldset>\n";
				}
				$content .= "</td>\n";
				return $content;
	}
}

/**
 * Factory for the checkbox widget
 * @author nicola
 *
 */

class TwoColumnsRelManagerFieldFactory implements FormWidgetFactory
{
	public function create($form)
	{
		return new TwoColumnsRelManagerField($form);
	}
}
?>