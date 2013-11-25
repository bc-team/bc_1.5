<?php
require_once(realpath(dirname(__FILE__)) . '/../../../../include/view/widgets/FormWidget.php');

/**
 * @access public
 * @author Di Pompeo Sacco
 * @package include.view.widgets.forms
*/
class RelationManager2Field extends FormWidget {

	/**
	 * @access public
	 * @param v
	 * @param preload
	 * @ParamType v
	 * @ParamType preload
	 */
	public function build($preload) {
		// RELATION MANAGER
		#$content .= "    <label class=\"cells\">{$v["label"]}</label>\\n";
		if (isset($this->form->helpers[$v['name']])) {
			$content .= "    <td valign=\"TOP\">{$v["label"]} <a href=# title=\"{$this->form->helpers[$v['name']]}\"><img src=\"img/form/help.gif\" class=\"helper\"></a> </td>\n";
		} else {
			$content .= "<label class=\"cells\">{$v["label"]}</label>\n";
		}
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
		
		
		/* this fetches all the item which should be put into checkboxes */
		
		$data = $secondaryEntity->getReference();
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
		$content .= "<td style=\"padding-top: 10px;\">\n";
		#print_r($_REQUEST);
		#echo "<hr>";
		if ($preload) {
			$content .= "<div class=\"table\">\n";
			if ((count($data) > 0) and ($data != "")) {
				$first=true;
				$c=0;
				foreach($data as $key => $value) {
					$content .= "<div class=\"row\">\n";
					if (isset($_REQUEST['rss_mod2'])||(isset($_REQUEST["{$v['name']}_{$value['value']}"])))
					{
						if($this->form->mainFormEntity->rss)
						{
							if (in_array($value['text'],$listChannel))
							{
								switch ($rssMod[0])
								{
									case MOD3:
										$content .= "<td><input class=\"clear\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\" CHECKED></td><td>{$value['text']}</td>\n";
										break;
									case MOD2:
										$c++;
										if($first)
										{
											$first=false;
											$content .= "<td><input id=\"0\"class=\"clear\" type=\"checkbox\" name=\"rss_mod2\" value=\"0\" onClick=\"reload({$cont});\" CHECKED></td><td>Rss</td>\n</div>\n<div class=\"row\">";
										}
										$content .= "<td><input id=\"{$c}\" style=\"display : none\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\" CHECKED></td><td></td>\n";
										break;
									case MOD1:
										$content .= "<td><input style=\"display : none\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\" CHECKED></td><td></td>\n";
										break;
								}
							}
						}
						else
						{
							$content .= "<input class=\"inl_blks\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\" CHECKED></td><td>{$value['text']}</td>\n";
						}
					} else
					{
						if($this->form->mainFormEntity->rss)
						{
							if (in_array($value['text'],$listChannel))
							{
								switch ($rssMod[0])
								{
									case MOD3:
										$content .= "<td><input class=\"clear\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\"></td><td>{$value['text']}</td>\n";
										break;
									case MOD2:
										$c++;
										if($first)
										{
											$first=false;
											$content .= "<td><input id=\"0\"class=\"clear\" type=\"checkbox\" name=\"rss_mod2\" value=\"0\" onClick=\"reload({$cont});\"></td><td>Rss</td>\n";
										}
										$content .= "<td><input id=\"{$c}\" style=\"display : none\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\"></td><td></td>\n";
										break;
									case MOD1:
										$content .= "<td><input style=\"display : none\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\" CHECKED></td><td></td>\n";
										break;
								}
							}
						}
						else
						{
							$content .= "<input class=\"inl_blks\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\"></td><td>{$value['text']}</td>\n";
						}
					}
					$content .= "</div>\n";
				}
			}
			$content .= "</div>\n";
		} else {
			$content .= "<div class=\"row\">\n";
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
								case MOD3:	$content .= "<div class=\"row\">\n";
								$content .= "<input class=\"\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\"></td><td>{$value['text']}</td>\n";
								$content .= "</row>\n";
								break;
								case MOD2:	if($first)
								{
									$first=false;
									$content .= "<div class=\"row\">\n";
									$content .= "<td><input id=\"0\" class=\"clear\" type=\"checkbox\" name=\"rss_mod2\" value=\"0\" onClick=\"reload({$cont});\"></td><td>Rss</td>\n";
									$content .= "</div>\n";
								}
								$c++;
								$content .= "<div class=\"row\">\n";
								$content .= "<input class=\"inl_blks cells mb20\" id=\"{$c}\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\"></td><td></td>\n";
								$content .= "</div>\n";
								break;
								case MOD1:  $content .= "<div class=\"row\">\n";
								$content .= "<input class=\"inl_blks cells mb20\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\" CHECKED />\n";
								$content .= "</div>\n";
								break;
							}
						}
					}
					else
					{
						$content .= "<div class=\"row\">\n";
						$content .= "<input class=\"inl_blks cells mb20\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\"><label class=\"cells\">{$value['text']}</label>\n";
						$content .= "</div>\n";
					}
				}
			}
			$content .= "</div>\n";
		}
		$content .= "</div>\n";
		return $content;
	}
}
?>