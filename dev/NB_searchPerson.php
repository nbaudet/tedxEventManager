<?php
require_once('../tedx-config.php');

/*echo '<h2>Toutes les personnes</h2>';
$message = FSPerson::getPersons();
var_dump($message);*/

echo '<h2>Test de recherche de personnes pour "bert"</h2>';
$message = FSPerson::searchPersonByName('bert');
//var_dump($message);

// Si la recherche a été fructueuse, on récupère les membres
if( $message->getStatus()){
    $membersFound = $message->getContent();
    var_dump($membersFound);
}
// Sinon on affiche l'erreur
else {
    echo $message->getMessage();
}

echo '<hr /><h2>Test de recherche de personnes pour "z"</h2>';
$message = FSPerson::searchPersonByName('z');
//var_dump($message);

// Si la recherche a été fructueuse, on récupère les membres
if( $message->getStatus()){
    $membersFound = $message->getContent();
    var_dump($membersFound);
}
// Sinon on affiche l'erreur
else {
    echo $message->getMessage();
}

echo '<hr /><h2>Test de recherche de personnes pour "a"</h2>';
$message = FSPerson::searchPersonByName('a');
//var_dump($message);

// Si la recherche a été fructueuse, on récupère les membres
if( $message->getStatus()){
    $membersFound = $message->getContent();
    var_dump($membersFound);
}
// Sinon on affiche l'erreur
else {
    echo $message->getMessage();
}


echo '<br />fin de la recherche';

?>
