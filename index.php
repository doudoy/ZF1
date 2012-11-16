<?php

// Définition du répertoire de l'application
define('APPLICATION_PATH',  'application');

// Définition du répertoire de l'environnement
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath('include'),
    get_include_path(),
)
));


/** Zend_Application */
require_once 'include/Zend/Application.php';
// Creation de l'application, bootstrap, et run !!
$app = new Zend_Application('dev', array('bootstrap' => 'application/Bootstrap.php'));
$app->bootstrap()->run();
