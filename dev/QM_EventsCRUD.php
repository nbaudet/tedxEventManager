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

$searchArgs = array(
    'where'      => "StartingDate >= '2014-01-01'",
    'orderBy'    => 'StartingDate',
    'orderByType' => 'ASC'
);
var_dump($tedx_manager->searchEvents($searchArgs));
?>
