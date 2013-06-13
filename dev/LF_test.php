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
require_once(APP_DIR .'/core/services/functionnals/FSEvent.class.php');
require_once(APP_DIR .'/core/services/functionnals/FSSlot.class.php');
require_once(APP_DIR .'/core/services/functionnals/FSSpeaker.class.php');
require_once(APP_DIR .'/core/model/Member.class.php');
require_once(APP_DIR .'/core/model/Unit.class.php');


//var_dump(FSPerson::getPerson(1));
//var_dump(FSMembership::getMembership("admin",1));
//var_dump(FSPerson::getPersons());



//$member = FSMember::getMember('admin')->getContent();
//var_dump($member);

//$unit = FSUnit::getUnit(2)->getContent();
//var_dump($unit);

//$argsMembership = array ('member' => $member, 'unit' => $unit);

//var_dump(FSMembership::getMembership($argsMembership));
//var_dump(FSMembership::addMembership($argsMembership));

//$event = FSEvent::getEvent(1)->getContent();
//var_dump($event);

/*$argsSlot = array (
    'no'    => '1',
    'event' => $event
);*/

//$slot = FSSlot::getSlot($argsSlot)->getContent();
//var_dump($slot);

//var_dump(FSSlot::getSlotsByEvent($event));

//var_dump(FSSlot::getSlots());


var_dump(FSSpeaker::getSpeaker(6));
var_dump(FSSpeaker::getSpeakers());


?>
