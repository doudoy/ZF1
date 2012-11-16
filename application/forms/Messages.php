<?php
class Application_Forms_Messages extends Zend_Form
{
    public function init()
    {
        $this->setName('messages');
        $this->setAttribs(array(
        'id'=>'formajout'));
        $id = new Zend_Form_Element_Hidden('idmessage');
        $id->addFilter('Int');

        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Votre Email')
               ->setRequired(true)
               ->addFilter('StripTags')//Enlève les caractères HTML
               ->addFilter('StringTrim')// Enlève les espaces dans la chaîne de caractère.
               ->addValidator('NotEmpty')
                ->addValidator('EmailAddress');

        $comment = new Zend_Form_Element_Textarea('comment');
        $comment->setLabel('Votre Message')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');
        $comment->setAttribs(array(
        'rows'=>5,
        'cols'=>40));

        $created = new Zend_Form_element_Hidden('created');
        $created->setValue(date('Y-m-d'));
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');

        
        $this->addElements(array($id, $email, $comment, $created, $submit));
    }
}

?>
