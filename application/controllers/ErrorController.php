<?php
class ErrorController extends Zend_Controller_Action
{
    private $_exception;
    private static $errorMessage;
    private static $httpCode;

    public function preDispatch()
    {
    	$this->_helper->viewRenderer->setNoRender(true); // ne rend aucune vue automatiquement
    	$this->_exception = $this->_getParam('error_handler');
        $this->_response->clearBody(); // on vide le contenu de la réponse
    	$this->_response->append('error',null); // on ajoute un segment 'error' dans la réponse

    	switch ($this->_exception->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                self::$httpCode = 404;
                self::$errorMessage = 'Page introuvable';
            break;
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_OTHER:
            	switch (get_class($this->_exception->exception)) {
            		case 'Zend_View_Exception' :
            			self::$httpCode = 500;
            			self::$errorMessage = 'Erreur de traitement d\'une vue';
            		break;
            		case 'Zend_Db_Exception' :
            			self::$httpCode = 503;
            			self::$errorMessage = 'Erreur de traitement dans la base de données';
            		break;
            		case 'Metier_Exception' :
            			self::$httpCode = 200;
            			self::$errorMessage = $this->_exception->exception->getMessage();
            		break;
            		case 'Autre_Exception' :
            			self::$httpCode = 500;
            			self::$errorMessage = 'Exemple avec une "autre exception"';
            		break;
            		default:
            			self::$httpCode = 500;
            			self::$errorMessage = 'Erreur inconnue';
            		break;
            	}
            break;
    	}

    }

    public function errorAction()
    {
    	$this->getResponse()->setHttpResponseCode(self::$httpCode);
    	$this->_errorMessage .= sprintf("<p>%s</p>",self::$errorMessage);
    }

    public function postDispatch()
    {
    	$this->getResponse()->appendbody($this->_errorMessage,'error');
    	$this->getResponse()->appendbody('<a href="javascript:history.back()">retour</a>','error');
    	if (Zend_Registry::get('config')->debug == 'true') {
    		$message = sprintf('<hr>DEBUG INFOS :<br /><strong>Exception de type <em>%s</em> <u>%s</u> envoyée dans %s à la ligne %d </strong> <p>Stack Trace : %s </p><hr>',
    							get_class($this->_exception->exception),
    							$this->_exception->exception->getMessage(),
    							$this->_exception->exception->getFile(),
    							$this->_exception->exception->getLine(),
    							Zend_Debug::dump($this->_exception->exception,null,false)
    						   );
    		$this->getResponse()->append('debug',$message);
    	}
    }
}

