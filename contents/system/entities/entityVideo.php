<?php


class EntityVideo extends EntityFileToFolder
{
    public function __construct($database, $name)
    {
        parent::__construct($database, $name, WITH_OWNER);
        $this->addField('title', VARCHAR, 255, MANDATORY);
        $this->addField('date', LONGDATE);
        $this->setPresentation("title");
    }

    /**
     * @param $values_condition
     * @return resource
     */
    public function save($values_condition)
    {
        $values_condition["owner"] = $_SESSION["user"]["username"];
        return parent::save($values_condition);
    }
}

$videoEntity = new EntityVideo($database, "sys_video");
$videoEntity->addReference($imageEntity, "foto");