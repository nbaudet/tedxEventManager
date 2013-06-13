<?php
require_once('../tedx-config.php');
require_once(APP_DIR.'/core/services/applicatives/ASAuth.class.php');

echo 'test de login';
$message = $tedx_manager->login('admin', md5( 'admin' ));
var_dump($message);

// Envoi du paramètre dans login


// Récupération du résultat


var_dump($_SESSION);
?>
