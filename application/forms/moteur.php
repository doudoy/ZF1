<?php
class Application_Forms_Moteur extends Zend_Form
{
    public function init()
    {
        $this->setName('moteur')->setAttribs(array(
        'id'=>'formmoteur'));
        $mots = new Zend_Form_Element_Text('mots');
        $mots->setRequired(true)
               ->addFilter('StripTags')//Enlève les caractères HTML
               ->addFilter('StringTrim')// Enlève les espaces dans la chaîne de caractère.
               ->addValidator('NotEmpty')
               ->removeDecorator('label')
               ->removeDecorator('HtmlTag');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Ok')
                ->removeDecorator('DtDdWrapper');
        
        $this->addElements(array($mots, $submit));
    }
}

?>
