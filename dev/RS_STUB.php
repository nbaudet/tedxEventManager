<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../core/model/message.class.php');
require_once('../tedx-config.php');


$args = array();
$message = $tedx_manager->registerVisitor($args);
print_r($message);
?>
