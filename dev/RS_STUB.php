<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../tedx-config.php');

require_once('../core/model/Person.class.php ');
require_once('../core/services/functionnals/FSUnit.class.php');
require_once('../core/services/functionnals/FSMember.class.php');



$person = FSPerson::getPerson(8);

$argsMember = array(
            'id'         => 'RapouSchmutz1234',
            'password'   => md5('test'),
            'person'   => $person->getContent(),
        );

$message2 = FSMember::addMember($argsMember);

//$moi = FSPerson::getPerson(7);
//$message3 = FSMember::checkFreePerson($moi->getContent());
//$args = array();

// $message = $tedx_manager->registerVisitor($args);
var_dump($message2);
//var_dump($message3);

?>
