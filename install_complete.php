<?php
require_once "include/settings.inc.php";
Settings::setModMode(true);
require_once "include/beContent.inc.php";
require_once(realpath(dirname(__FILE__)) . '/include/view/template/InitGraphic.php');


/**
 * Formats a JSON string for pretty printing
 *
 * @param string $json The JSON to make pretty
 * @param bool $html Insert nonbreaking spaces and <br />s for tabs and linebreaks
 * @return string The prettified output
 * @author Jay Roberts
 */

function _format_json($json, $html = false)
{
    $tabcount = 0;
    $result = '';
    $inquote = false;
    $ignorenext = false;

    if ($html) {
        $tab = "&nbsp;&nbsp;&nbsp;";
        $newline = "<br/>";
    } else {
        $tab = "\t";
        $newline = "\n";
    }

    for ($i = 0; $i < strlen($json); $i++) {
        $char = $json[$i];

        if ($ignorenext) {
            $result .= $char;
            $ignorenext = false;
        } else {
            switch ($char) {
                case '{':
                    $tabcount++;
                    $result .= $char . $newline . str_repeat($tab, $tabcount);
                    break;
                case '}':
                    $tabcount--;
                    $result = trim($result) . $newline . str_repeat($tab, $tabcount) . $char;
                    break;
                case ',':
                    $result .= $char . $newline . str_repeat($tab, $tabcount);
                    break;
                case '"':
                    $inquote = !$inquote;
                    $result .= $char;
                    break;
                case '\\':
                    if ($inquote) $ignorenext = true;
                    $result .= $char;
                    break;
                default:
                    $result .= $char;
            }
        }
    }

    return $result;
}


foreach (beContent::getInstance()->entities as $k => $v) {
    $installation_info["installed_entities"][$v->entityName] = $v->entityName;
}

$installation_info["installation_date"] = new DateTime();

file_put_contents(realpath(dirname(__FILE__)) . '/contents/installation_info.cfg', json_encode($installation_info));

$main = new Skin("system");

InitGraphic::getInstance()->createSystemGraphic($main);

$body = new Skinlet("admin");
//$body->setContent("installation_report", _format_json(json_encode($installation_info), true));
$main->setContent("body", $body->get());

$main->close();
