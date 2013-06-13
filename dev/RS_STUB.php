<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../core/model/Unit.class.php');
require_once('../core/model/message.class.php');
require_once('../core/services/functionnals/FSUnit.class.php');
require_once('../tedx-config.php');

$message = FSUnit::getUnitByName('Visitors');
//$args = array();

// $message = $tedx_manager->registerVisitor($args);
print_r($message);
?>
