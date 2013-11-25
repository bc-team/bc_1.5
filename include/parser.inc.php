<?php



Class Parser {
	///////////////////////////////////////////////////////////////
	//Per l'encode dei caratteri xml
	//////////////////////////////////////////////////////////////

	function encrypt_decrypt($Str_Message) {

		$Len_Str_Message=STRLEN($Str_Message);
		$Str_Encrypted_Message="";
			
		for ($Position = 0;$Position<$Len_Str_Message;$Position++){

			$Key_To_Use = (($Len_Str_Message+$Position)+1); // (+5 or *3 or ^2)

			$Key_To_Use = (255+$Key_To_Use) % 255;
			$Byte_To_Be_Encrypted = SUBSTR($Str_Message, $Position, 1);
			$Ascii_Num_Byte_To_Encrypt = ORD($Byte_To_Be_Encrypted);
			$Xored_Byte = $Ascii_Num_Byte_To_Encrypt ^ $Key_To_Use;  //xor operation
			$Encrypted_Byte = CHR($Xored_Byte);
			$Str_Encrypted_Message .= $Encrypted_Byte;


		}
		return $Str_Encrypted_Message;
	}

	function encrypt($message) {
		return urlencode(Parser::encrypt_decrypt($message));
	}

	function decrypt($message) {
		return Parser::encrypt_decrypt(urldecode($message));
	}

	function escape_string($string) {

		return mysql_escape_string($string);

	}

	function email($email, $pars) {

		#$email =  ereg_replace("@", "<span class=\"email\">[at]</span>", $email);
		#$email =  ereg_replace("\.", "<span class=\"email\">[dot]</span>", $email);

		if (!isset($pars['mode'])) {
			$email =  ereg_replace("@", "<img style=\"margin-bottom: -2px;\"src=\"img/beContent/chiocciola.gif\" alt=\"@\">", $email);
		} else {
			$email =  ereg_replace("@", "<img style=\"margin-bottom: -2px;\"src=\"img/beContent/chiocciola-{$pars['mode']}.gif\" alt=\"@\">", $email);
		}

		return "{$email}";
	}

	function encode_name($name) {
		return md5($name);
	}

	function decode_name($name) {
		return $name;
	}

	function phone($phone) {

		$phone = ereg_replace("^0039[[:space:]]*0862[[:space:]]*", "+39 0862 ", $phone);

		return $phone;
	}

	function xmlchars($str, $mode = MODE1) {
		switch($mode) {
			case MODE1:
				$str=str_replace('&','&amp;',$str);
				$str=str_replace('<','&lt;',$str);
				$str=str_replace('>','&gt;',$str);
				$str=str_replace('"','&quot;',$str);
				$str=str_replace("'",'&#39;',$str);
				/**
				 * 
				 * Daniele Di Pompeo
				 * fix lettere accentate
				 * 
				 */
				$str=str_replace("�",'&egrave;',$str);
				$str=str_replace("�",'&eacute;',$str);
				$str=str_replace("�",'&ograve;',$str);
				$str=str_replace("�",'&agrave;',$str);
				$str=str_replace("�",'&ugrave;',$str);
				$str=str_replace("�",'&egrave;',$str);
				break;
			case MODE2:
				$str = htmlentities($str);
				break;
			case MODE3:
				$trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
				$trans = array_flip($trans);
				$str = strtr($str, $trans);

				$str = preg_replace('/&#(d+);/me',"chr(\1)", $str);
				$str = preg_replace('/&#x([a-f0-9]+);/mei',"chr(0x\1)", $str);

				$trans = get_html_translation_table(HTML_ENTITIES, ENT_NOQUOTES);
				 
				foreach ($trans as $key => $value) {
					$trans[$key] = '&#'.ord($key).';';
				}

				$str = strtr($str, $trans);
				break;
		}
		return $str;
	}


	///////////////////////////////////////////////////////////////
	//funsione per il riconoscimento dei parametri nei template
	//////////////////////////////////////////////////////////////
	function parsePars($parameters) {

		$buffer = $parameters;
		do {
			$result = ereg("^([[:alnum:] \_]+)",$buffer,$token);
			if ($result) {
				$buffer = ereg_replace("^$token[1]","",$buffer);
				$result2 = ereg("^=\"([[:alnum:]\.\_\% \-]*)\"",$buffer,$token2);
				if ($result2) {
					$buffer = ereg_replace("^=\"$token2[1]\"[[:space:] ]*","",$buffer);
					$par[$token[1]] = $token2[1];
				}
			}

	 } while ($result);

	 return $par;
	}
	 
	function getResultArray($query,$field){
		$data=Parser::getResult($query);
		$i=0;
		while ($data[$i]) {
			$result[]=$data[$i][$field];
			$i++;
		}
		return $result;

	}

	static function first_comma($arg, $separator) {
		global
		$comma;

		//	if ((isset($comma[$arg])) && (!$comma[$arg])) {
		if (!isset($comma[$arg])) {
			$comma[$arg] = true;
			return "";
		} else {
			return $separator;
		}

	}
	
	static function commaExists($arg)
	{
		global
		$comma;
		
		return isset($comma[$arg]);
	}
	
	static function unsetComma($arg)
	{
		global
		$comma;
		
		unset($comma[$arg]);
	}

	function mail($to, $subject, $message, $from) {

		$signature = new Template(Settings::getSkin()."/signature.mail");
		$message .= $signature->get();

		$mail = new zMailer();

		$mail->From		= $from;
		$mail->FromName = $from;
		$mail->AddAddress($to);

		$mail->Subject 	= $subject;
		$mail->Body		= eregi_replace("[\]",'',$message);

		$mail->Send();
	}

	static function getResult($query, $mode = "NORMAL") {

		switch ($mode) {
			case ADVANCED:
			case PARSE:

				$finito = false;
				do {
					if (ereg("\[([[:alnum:]]*)\]", $query, $token)) {

						$query = ereg_replace("\[{$token[1]}\]", $_REQUEST[$token[1]], $query);

					} else {
						$finito = true;
					}
				} while (!$finito);

				break;

			default:
				break;
		}

		if ($mode == PARSE) {

			return $query;
				
		} else {

			$oid = mysql_query($query);
			if (!$oid) {
				echo mysql_error();

				echo "<hr>",$query; exit;
				echo Message::getInstance()->getMessage(MSG_ERROR_DATABASE_GENERIC);
				exit;
			}

			do {
				$data = mysql_fetch_assoc($oid);
				if ($data) {
					foreach ($data as $k=>$v) {
						if (is_string($data[$k])) {
							$data[$k] = stripslashes($v);
						}
					}

					$content[] = $data;
				}
			} while ($data);

			
			if (!isset($content)) {
				$content = "";
			}
			return $content;
		}
	}

	function yesterday() {

		$day = time() - (24 * 60 * 60);
		$strtime = strtotime(date('m/d/Y', $day));
		return strftime("%Y%m%d", $strtime);

	}

	function formatDate($date, $format = "") {

		$result = "";
		switch ($format) {
			case RSS:
				ereg("([0-9][0-9][0-9][0-9])([0-9][0-9])([0-9][0-9])", $date, $token);
				$result = date("D, j M Y 06:00:00 +0100",mktime(0, 0, 0, $token[2], $token[3], $token[1]));
				break;
			case LETTERS:

				ereg("([0-9][0-9][0-9][0-9])([0-9][0-9])([0-9][0-9])", $date, $token);
				$result = date("F jS Y",mktime(0, 0, 0, $token[2], $token[3], $token[1]));
				break;
			case SHORT_LETTERS:

				ereg("^([0-9][0-9][0-9][0-9])([0-9][0-9])([0-9][0-9])", $date, $token);
				$result = date("M j, Y",mktime(0, 0, 0, $token[2], $token[3], $token[1]));
				break;
			case STANDARD:

				if ($date != "") {

					if (ereg("^([0-9][0-9][0-9][0-9])([0-9][0-9])([0-9][0-9])([0-9][0-9])([0-9][0-9])$", $date, $token)) {
						$result = "{$token[3]}/{$token[2]}/{$token[1]}";
					} elseif (ereg("^([0-9][0-9][0-9][0-9])([0-9][0-9])([0-9][0-9])$", $date, $token)) {
						$result = "{$token[3]}/{$token[2]}/{$token[1]}";
					}
				} else {
					$result = "";
				}
				break;
			case STANDARD_PLUS:

				if ($date != "") {

					ereg("([0-9][0-9][0-9][0-9])([0-9][0-9])([0-9][0-9])([0-9][0-9])([0-9][0-9])", $date, $token);

					if (date("Ymd") == "{$token[1]}{$token[2]}{$token[3]}") {
						$result = Parser::lingual("Oggi", "Today", "Oy");
					} else {
						$result = "{$token[3]}/{$token[2]}/{$token[1]}";
					}
					if ($token[4] != "") {
						$result .= " {$token[4]}:{$token[5]}";
					}
				} else {
					$result = "";
				}
				break;
			case BLOG:

				if ($date != "") {

					ereg("([0-9][0-9][0-9][0-9])([0-9][0-9])([0-9][0-9])", $date, $token);
					$date = date("jS M",mktime(0, 0, 0, $token[2], $token[3], $token[1]));

					$result = "<div title=\"Oggi\" style=\"float: left; line-height: 13px; font-size: 9px;padding-top: 4px; margin: 2px 20px 0px 10px; width: 29px; height: 32px; text-align:center; background: url(img/date.jpg) no-repeat;\">{$date}</div>";
				} else {
					$result = "";
				}
				break;
			case EXTENDED:

				setlocale(LC_ALL, Parser::getLocale($_SESSION['language']));
				if (ereg("^([0-9][0-9][0-9][0-9])([0-9][0-9])([0-9][0-9])([0-9][0-9])([0-9][0-9])$", $date, $token)) {
					$day = "{$token[2]}/{$token[3]}/{$token[1]} {$token[4]}:{$token[5]}";

					$strtime = strtotime($day);
						
					$result = strftime("%A %d %B, %H:%M", $strtime);
				} else if (ereg("^([0-9][0-9][0-9][0-9])([0-9][0-9])([0-9][0-9])$", $date, $token)) {
					$day = "{$token[2]}/{$token[3]}/{$token[1]} 00:01";

					$strtime = strtotime($day);

					$result = strftime("%A %d %B", $strtime);
				}
				break;
			case EXTENDED_PLUS:

				setlocale(LC_ALL, Parser::getLocale($_SESSION['language']));

				if (ereg("^([0-9][0-9][0-9][0-9])([0-9][0-9])([0-9][0-9])([0-9][0-9])([0-9][0-9])$", $date, $token)) {

					if ("{$token[2]}{$token[3]}{$token[1]}" == date("mdY")) {

						$result = "Oggi {$token[4]}:{$token[5]}";

					} else {
							
						$day = "{$token[2]}/{$token[3]}/{$token[1]} {$token[4]}:{$token[5]}";
						$strtime = strtotime($day);
						$result = strftime("%A %d %B, %H:%M", $strtime);
					}
				} else if (ereg("^([0-9][0-9][0-9][0-9])([0-9][0-9])([0-9][0-9])$", $date, $token)) {
						
					if ("{$token[2]}{$token[3]}{$token[1]}" == date("mdY")) {
						$result = "Oggi";

					} else {
						$day = "{$token[2]}/{$token[3]}/{$token[1]} 00:01";
						$strtime = strtotime($day);
						$result = strftime("%A %d %B", $strtime);
					}
						
				}
				break;
			case TIME:

				$h = substr($date,8,2);
				$m = substr($date,10,2);

				return "{$h}:{$m}";
				break;
			case YEAR:
				$y = substr($date,0,4);

				return $y;
				break;
			default:
				ereg("([0-9][0-9][0-9][0-9])([0-9][0-9])([0-9][0-9])", $date, $token);
				$result = "{$token[3]}.{$token[2]}.{$token[1]}";
				break;

		}
		return $result;
	}

	function subtext($text, $length = 100) {

		if (strlen(strip_tags(html_entity_decode($text))) < $length) {
				
			$result =  strip_tags(html_entity_decode($text));

		} else {

			$newtext = wordwrap(strip_tags(html_entity_decode($text)), $length, "<interrupt>");

			$pos = strpos($newtext, "<interrupt>");

			$result = substr($newtext, 0, $pos).' ...';

		}
			
		return $result;
	}

	function quote_smart($value) {

		// Stripslashes
		if (get_magic_quotes_gpc()) {
			#echo "stripslashes";
			$value = stripslashes($value);
		}
		// Quote if not integer
		if (!is_numeric($value)) {
			#echo "real_escape";
			$value = "'" . mysql_real_escape_string($value) . "'";
			#$value = mysql_real_escape_string($value) ;
		}
		return $value;
	}

	function mkIndent($level) {

		#echo "** {$level}<br>";

		$result = "";

		for($i=0; $i<$level;$i++) {

			$result .= "&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		return $result;
	}

	function FindChildren ($parent, $level) {
		global
		$flag, $data,
		$tree_text,
		$tree_value,
		$tree_level,

		$undef_flag;

		for ($i=0;$i<count($data);$i++) {
			if (($data[$i]['reference'] == $parent) and (!isset($flag[$i]))) {

				$tree_value[] = $data[$i]['value'];
				$tree_text[] = Parser::mkIndent($level).$data[$i]['text'];
				$tree_level[] = $level;
					
				$flag[$i]=true;

				Parser::FindChildren($data[$i]['value'],$level+1);
			}
		}
	}

	function array_merge($arrays) {

		$result = array();

		foreach($arrays as $array) {
			$result = array_merge(array_diff($result,$array), array_diff($array,$result), array_intersect($result,$array));
		}
		return $result;
	}

	function add_distinct($array, $element) {

		if (!is_array($array)) {
			$array = array();
		}
		if (!in_array($element, $array)) {
			$array[] = $element;
		}
		return $array;
	}


	function AjaxEncode($object) {
			
		$str = serialize($object);

		#$str = str_replace(array('\\', "'"), array("\\\\", "\\'"), $str);
		$str = preg_replace('#([\x00-\x08])#e', '"\x" . sprintf("%02x", ord("\1"))', $str);
		$str = preg_replace('#([\x0A-\x1F])#e', '"\x" . sprintf("%02x", ord("\1"))', $str);

		#$str = ereg_replace("\\x0d","",$str);
		#$str = ereg_replace("\\x02","",$str);
		#$str = ereg_replace("\\x01","",$str);
		#$str = ereg_replace("\\x12","",$str);
		#$str = ereg_replace("\\x0e","",$str);
		$str = ereg_replace("\\x0[0-9a-f]","", $str);
		$str = ereg_replace("\\x1[0-9a-f]","", $str);

		#Header("Content-type: text/plain");
		#echo stripslashes($str);exit;

		return $str;
	}


	function lingual($item_it, $item_en, $item_es = "") {
		 
		$item = "item_{$_SESSION['language']}";
		return $$item;
		 
	}

	function getLocale($language) {

		$locale = array(WINDOWS => array("it" => "ita_ita", "en" => "eng_eng","es" => "esp_esp"),
				LINUX => array("it" => "it_IT", "en" => "en_UK","es" => "es_ES")
		);
			
		return $locale[Config::getInstance()->getConfigurations()['os']][$language];
	}

	function refineQuery($query, $condition) {
		 
		$queryToken['body'] = $query;
		 
		if (ereg("(.*)(".sql_regcase("order by").".*)$", $queryToken['body'], $token)) {
			$queryToken['order_by'] = $token[2];
			$queryToken['body'] = $token[1];
		}
			
		if (ereg("(.*)(".sql_regcase("where").".*)$", $queryToken['body'], $token)) {
			$queryToken['where'] = $token[2];
			$queryToken['body'] = $token[1];
		}
		$query = $queryToken['body'];
			
		if ($queryToken['where'] == "") {

			if ($condition != "") {
				$query .= " WHERE {$condition} ";
			}

		} else {
			$query .= $queryToken['where']." AND {$condition} ";
		}
			
		$query .= $queryToken['order_by'];
			
		return $query;
	}

	function evaluate($str, $array) {

		do {
			$result = ereg("^.*\[(.*)\]", $str, $token);
			if ($result) {
				$buffer = $str;
				$str = ereg_replace("\[{$token[1]}\]", $array[$token[1]], $buffer);
			}
		} while ($result);

		#echo "**", $str;exit;
		return $str;
	}

	function seo_url($str) {

		$str = str_replace("?", "", $str);
		$str = str_replace(":", "", $str);
		$str = str_replace("/", "", $str);
		$str = str_replace("\\", "", $str);
		$str = str_replace("!", "", $str);
		$str = str_replace(".", "", $str);

		return str_replace(" ", "-", $str);

	}

}