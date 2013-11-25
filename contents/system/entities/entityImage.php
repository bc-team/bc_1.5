<?php


class EntityImage extends EntityFile
{
    public function __construct($database, $name)
    {
        parent::__construct($database, $name, WITH_OWNER);
        $this->addField('title', VARCHAR, 255, MANDATORY);
        $this->addField('caption', VARCHAR, 255, MANDATORY);
        $this->addField('alt', VARCHAR, 255, MANDATORY);
        $this->setPresentation("title");
    }

    /**
     * @param $values_condition
     * @return resource
     */
    public function save($values_condition)
    {
        $values_condition["owner"] = $_SESSION["user"]["username"];

        if (Settings::getOperativeMode() == 'debug') {
            echo '<br/> method save in EntityImage ';
            echo '<br /> var_dump $values_condition ';
            var_dump($values_condition['file']);
        }

        if (isset($values_condition['file'])) {
            $values_condition['filename'] = $values_condition['file']['name'];
            $values_condition['filetype'] = $values_condition['file']['type'];
            $values_condition['size'] = $values_condition['file']['size'];
            $values_condition['data'] = mysql_real_escape_string(
                base64_encode(
                    file_get_contents($values_condition['file']['tmp_name'])
                ));
        }
        return parent::save($values_condition);
    }

    public function update($where_conditions, $set_parameters)
    {
        if (Settings::getOperativeMode() == 'release') {
            echo '<br /><br><br>method update EntityImage<br><br> ';
            var_dump($set_parameters);
        }

        if (isset($set_parameters['file'])) {
            $set_parameters['filename'] = $set_parameters['file']['name'];
            $set_parameters['filetype'] = $set_parameters['file']['type'];
            $set_parameters['size'] = $set_parameters['file']['size'];
            $set_parameters['data'] = mysql_real_escape_string(
                base64_encode(
                    file_get_contents($set_parameters['file']['tmp_name'])
                ));
        }

        parent::update($where_conditions, $set_parameters);
    }
}

$imageEntity = new EntityImage($database, "sys_image");