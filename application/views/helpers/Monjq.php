<?php
class Zend_View_Helper_Monjq extends Zend_View_Helper_Abstract {

    public function Monjq() {
        $accordion = new ZendX_JQuery_View_Helper_AccordionContainer();
        $accordion->setView($this->view);
        $accordion->addPane("accordion", "h3a", "div", array());
        $this->view->assign($accordion->accordionContainer("accordion", array(
                'animated' => "bounceslide"), array( 'opacity' => "show")));
    }
}
?>