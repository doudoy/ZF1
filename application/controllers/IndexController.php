<?php

class IndexController extends Zend_Controller_Action {

    public function indexAction() {
        $this->view->title = "Présentation";
        //POUR L'AFFICHAGE DES MESSAGES
        //require_once 'application/models/DbTable/Messages.php';
        $messages = new Application_Models_DbTable_Messages();
        $this->view->messages = $messages->fetchAll(null, 'idmessage DESC');

        //require_once 'application/forms/moteur.php';
        $form = new Application_Forms_Moteur();
        $this->view->formmoteur = $form;
        $query = isset($_POST['mots']) ? $_POST['mots'] : '';
        $query = trim($query);
        $this->view->query = $query;
    }

    /* ************************************************************
     * ******************* MESSAGES DE L'ACCUEIL *******************
     * ************************************************************ */

    /*
     * AJOUT D'UN MESSAGE A L'ACCUEIL
     */

    public function newmessageAction() {
        $this->view->title = "Laissez moi un message";
        //require_once 'application/forms/Messages.php';
        $form = new Application_Forms_Messages();
        $form->submit->setLabel('Envoyer');
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();

            if ($form->isValid($formData)) {
                $email = $form->getValue('email');
                $comment = $form->getValue('comment');
                $created = $form->getValue('created');
                //require_once 'application/models/DbTable/Messages.php';
                $messages = new Application_Models_DbTable_Messages();
                $messages->addMessage($email, $comment, $created);

                $this->_redirect('index');
            } else {
                $form->populate($formData);
            }
        }
    }

    /*
     * MODIFICATION D'UN MESSAGE DE L'ACCUEIL
     */

    public function editmessageAction() {
        $this->view->title = "Modifier un message";
        //require_once 'application/forms/Messages.php';
        $form = new Application_Forms_Messages();
        $form->submit->setLabel('Save');
        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $id = (int) $form->getValue('idmessage');
                $email = $form->getValue('email');
                $comment = $form->getValue('comment');
                //require_once 'application/models/DbTable/Messages.php';
                $message = new Application_Models_DbTable_Messages();
                //$message->editMessage($id, $email, $comment);
                $this->_redirect('index');
            } else {
                $form->populate($formData);
            }
        } else {
            $id = $this->_getParam('id', 0);
            if ($id > 0) {
                //require_once 'application/models/DbTable/Messages.php';
                $message = new Application_Models_DbTable_Messages();
                $form->populate($message->getMessages($id));
            }
        }
    }

    /*
     * SUPPRESSION D'UN MESSAGE DE L'ACCUEIL
     */

    public function deletemessageAction() {
        $this->view->title = "Suppression d'un message";

        if ($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del');
            if ($del == 'Yes') {
                $id = $this->getRequest()->getPost('id');
                require_once 'application/models/DbTable/Messages.php';
                $message = new Application_Models_DbTable_Messages();
                //$message->deleteMessage($id);
            }
            $this->_redirect('index');
        } else {
            $id = $this->_getParam('id', 0);
            require_once 'application/models/DbTable/Messages.php';
            $message = new Application_Models_DbTable_Messages();
            $this->view->message = $message->getMessages($id);
        }
    }


}
?>