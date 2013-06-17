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
require_once APP_DIR.'/core/services/functionnals/FSEvent.class.php';


echo '<h1>SEARCH WITHOUT ARGS</h1>';

$args = array();

var_dump(FSEvent::searchEvents($args));

echo '<h1>SEARCH WITH ARGS</h1>';
$args = array(
    'where' => "StartingDate >= '2014-01-01'",
);
var_dump(FSEvent::searchEvents($args))
?>
