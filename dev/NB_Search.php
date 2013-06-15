<?php
require_once('../tedx-config.php');

echo '<h2>Test de recherche pour "a"</h2>';
$message = FSMember::searchMemberByID('a');
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
