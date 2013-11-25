<?php
/**
 * Class EntityFile
 * @author dipompeodaniele@gmail.com, n.sacco.dev@gmail.com
 */

class EntityFileToFolder extends Entity
{
	public function __construct($database, $name, $owner="")
	{
		parent::__construct($database,$name,WITH_OWNER);
		$this->addField("filename",VARCHAR,255, MANDATORY);
		$this->addField("size",INT,5);
		$this->addField("filetype",VARCHAR,255,MANDATORY);
	}

    public function save($values_condition)
    {

        if (Settings::getOperativeMode() == 'debug'){
            echo '<br /> save File to folder';
            var_dump($values_condition);
        }

        $values_condition["owner"] = $_SESSION["user"]["username"];

        if(isset($values_condition['file'])){
            $values_condition['filetype'] = $values_condition['file']['type'];
            $values_condition['size'] = $values_condition['file']['size'];
            $values_condition['filename'] = 'upload/'.$values_condition['file']['name'];
            if (file_exists("upload/" . $values_condition["file"]["name"]))
            {
                echo Message::getInstance()->getMessage(MSG_ERROR_FILE_EXIST)." (".basename(__FILE__).":".__LINE__.")";
            }
            else
            {
                move_uploaded_file($values_condition["file"]["tmp_name"],
                    $values_condition["filename"]);
            }
        }
        unset($values_condition['file']);
        return parent::save($values_condition);
    }

    public function update($where_conditions, $set_parameters)
    {
        if(Settings::getOperativeMode() == 'debug'){
            echo '<br />method update EntityImage ';
            var_dump($set_parameters);
        }
        if(isset($set_parameters['file'])){
            $set_parameters['filename'] = 'upload/'.$set_parameters['file']['name'];
            $set_parameters['filetype'] = $set_parameters['file']['type'];
            $set_parameters['size'] = $set_parameters['file']['size'];
        }
        return parent::update($where_conditions, $set_parameters);
    }
}

$fileToFolderEntity=new EntityFileToFolder($database,"sys_file_folder");