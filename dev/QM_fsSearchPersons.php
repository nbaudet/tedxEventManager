<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of QM_EventsCRUD
 *
 * @author Quentin
 */
require_once('../tedx-config.php');
require_once(APP_DIR.'/core/services/functionnals/FSPerson.class.php');

echo '<hr /><br /><h1>Recherche sans args</h1>';
$searchArgs = array();
var_dump(FSPerson::searchPersons($searchArgs));

echo '<hr /><br /><h1>Recherche des participants</h1>';
$searchArgs = array(
    'personType' => 'participant'
);
var_dump(FSPerson::searchPersons($searchArgs));

echo '<hr /><br /><h1>Recherche des speakers</h1>';
$searchArgs = array(
    'personType' => 'speaker'
);
var_dump(FSPerson::searchPersons($searchArgs));

echo '<hr /><br /><h1>Recherche des organizers</h1>';
$searchArgs = array(
    'personType' => 'participant'
);
var_dump(FSPerson::searchPersons($searchArgs));

echo '<hr /><br /><h1>Recherche des speaker et Name = \'K%\'</h1>';
$searchArgs = array(
    'personType' => 'speaker',
    'where' => "Name LIKE 'K%'"
);
var_dump(FSPerson::searchPersons($searchArgs));
?>
