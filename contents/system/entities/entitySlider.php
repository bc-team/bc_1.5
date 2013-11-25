<?php
/**
 * Created by IntelliJ IDEA.
 * User: daniele
 */

class EntitySlider extends Entity
{
    public function __construct($database,$name)
    {
        parent::__construct($database,$name);
        $this->addField("titolo", VARCHAR,50);
        $this->addField('descrizione',TEXT);
        $this->addField('effetto',TEXT);
        $this->addField('width',INT);
        $this->addField('height',INT);
        $this->setPresentation("%titolo");
        //$this->setTextSearchFields("nome");
        //$this->setTextSearchScript("area.php?area_id=");
    }

}
$sliderEntity = new EntitySlider($database, "sys_slider");

$sliderEntity->addReference($sys_page,'pagina');