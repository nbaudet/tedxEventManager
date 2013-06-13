<?php
require_once('../tedx-config.php');
require_once(APP_DIR.'/core/services/applicatives/ASAuth.class.php');

echo '<h2>Test de login</h2>';
//$message = $tedx_manager->login( 'gabor', 'gabor' );
$message = $tedx_manager->login( 'Penelope', 'anitakevinlove' ); // Visitor
//$message = $tedx_manager->login( 'Penelope', '1' ); // Wrong UserName
//$message = $tedx_manager->login( 'admin', 'admin' ); // Admin

echo $tedx_manager->getUsername();

echo 'Message : ';
var_dump($message);

echo '<h2>Session apr&egrave;s login</h2>';
var_dump($_SESSION);

echo '<hr /><h2>Test d\'acc&egrave;s &agrave; la fonction : VIDE</h2>';
$message0 = $tedx_manager->isGranted( '' );
var_dump($message0);

echo '<hr /><h2>Test d\'acc&egrave;s &agrave; la fonction : registerVisitor</h2>';
$bli = $tedx_manager->isGranted( 'registerVisitor' );
var_dump($bli);

echo '<hr /><h2>Test d\'acc&egrave;s &agrave; la fonction : registerOrganizer</h2>';
$message2 = $tedx_manager->isGranted( 'registerOrganizer' );
var_dump($message2);

echo '<hr /><h2>Test de logout</h2>';
$messageLogout = $tedx_manager->logout();
var_dump($messageLogout);

echo '<h2>Session apr&egrave;s logout</h2>';
$_SESSION['poney'] = 'Ma petite pouliche';
var_dump($_SESSION);
?>
