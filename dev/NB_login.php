<?php
require_once('../tedx-config.php');
require_once(APP_DIR.'/core/services/applicatives/ASAuth.class.php');

echo '<h2>Test de login</h2>';
$message = $tedx_manager->login( 'Penelope', 'anitakevinlove' );
var_dump($message);

echo '<h2>Session apr&egrave;s login</h2>';
var_dump($_SESSION);

echo '<hr /><h2>Test de logout</h2>';
$messageLogout = $tedx_manager->logout();
var_dump($messageLogout);

echo '<h2>Session apr&egrave;s logout</h2>';
$_SESSION['poney'] = 'Ma petite pouliche';
var_dump($_SESSION);
?>
