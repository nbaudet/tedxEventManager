<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../tedx-config.php');
require_once(APP_DIR .'/core/services/functionnals/FSPerson.class.php');
require_once(APP_DIR .'/core/services/functionnals/FSMembership.class.php');
require_once(APP_DIR .'/core/services/functionnals/FSUnit.class.php');
require_once(APP_DIR .'/core/services/functionnals/FSMember.class.php');
require_once(APP_DIR .'/core/model/Member.class.php');
require_once(APP_DIR .'/core/model/Unit.class.php');


//var_dump(FSPerson::getPerson(1));
//var_dump(FSMembership::getMembership("admin",1));
//var_dump(FSPerson::getPersons());


$argsMember = array (
    'id'   => 'admin',
    'password'   => '21232f297a57a5a743894a0e4a801fc3',
    'personNo'   => '1',
    'isArchived' => false
);

$member = new Member($argsMember);




$argsUnit = array (
    'no'                 => 2,
    'name'               => 'Validator',
    'isArchived'         => false
);
 
// instance Unit
$unit = new Unit($argsUnit);

$argsMembership = array ('member' => $member, 'unit' => $unit);

var_dump(FSMembership::getMembership($argsMembership));


//var_dump(FSMembership::addMembership($argsMembership));



?>
