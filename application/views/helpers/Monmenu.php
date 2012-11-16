<?php
class Zend_View_Helper_Monmenu extends Zend_View_Helper_Abstract {

    public function Monmenu() {
        $config = new Zend_Config_Xml('application/configs/navigation.xml', 'nav');
        $navig = new Zend_Navigation($config);
        return $this->view->navigation($navig);
    }
}
?>
