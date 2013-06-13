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



$member = FSMember::getMember('admin')->getContent();
var_dump($member);

$unit = FSUnit::getUnit(2)->getContent();
var_dump($unit);

$argsMembership = array ('member' => $member, 'unit' => $unit);

//var_dump(FSMembership::getMembership($argsMembership));
var_dump(FSMembership::addMembership($argsMembership));



?>
