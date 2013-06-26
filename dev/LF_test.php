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
require_once(APP_DIR .'/core/services/functionnals/FSParticipant.class.php');
require_once(APP_DIR .'/core/services/functionnals/FSOrganizer.class.php');
require_once(APP_DIR .'/core/services/functionnals/FSTalk.class.php');
require_once(APP_DIR .'/core/services/functionnals/FSAffectation.class.php');
require_once(APP_DIR .'/core/services/functionnals/FSTeamRole.class.php');
require_once(APP_DIR .'/core/services/functionnals/FSPlace.class.php');
require_once(APP_DIR .'/core/services/functionnals/FSRole.class.php');
require_once(APP_DIR .'/core/services/applicatives/ASFree.class.php');

require_once(APP_DIR .'/core/model/Member.class.php');
require_once(APP_DIR .'/core/model/Unit.class.php');

$speaker = $tedx_manager->getSpeaker(6)->getContent();
$event = $tedx_manager->getEvent(15)->getContent();

$arrayTalkToSet = array(
    'eventNo'            => 15,
    'speakerPersonNo'    => 6,
    'videoTitle'         => 'Video title of the year',
    'videoDescription'   => "This video is about a crazy cat fighting with an orange",
    'videoURL'           => "www.youtube.com",
    'isArchived'         => 0
);

$aTalkToSet = new Talk($arrayTalkToSet);
var_dump($aTalkToSet);

var_dump(FSTalk::setTalk($aTalkToSet));
/*------------------------
$speaker = $tedx_manager->getSpeaker(24)->getContent();
var_dump($speaker);

$event = $tedx_manager->getEvent(15)->getContent();
var_dump($event);

$argsSlot = array (
    'no'    => 10,
    'event' => $event
);

$slot = $tedx_manager->getSlot($argsSlot)->getContent();

var_dump($slot);

$argsAddSpeakerToPlace = array(
    'no' => 4, // integer
    'event' => $event, // object Event
    'slot' => $slot, // object Slot
    'speaker' => $speaker, // object Speaker
    'videoTitle'    => "Super Video Title",
    'videoDescription'  => "Super video Description",
    'videoURL'      => "www.youtube.com"
);

var_dump(ASOrganizer::addSpeakerToPlace($argsAddSpeakerToPlace));
*/
//$organizer = $tedx_manager->getOrganizer(4)->getContent();
//var_dump($tedx_manager->getTeamRolesByOrganizer($organizer));




/*$event = FSEvent::getEvent(2)->getContent();

$argsSlot = array (
    'no'    => '2',
    'event' => $event
);*/

//$slot = FSSlot::getSlot($argsSlot)->getContent();

//var_dump(FSParticipation::getParticipantsBySlot($slot));

//var_dump($b = $tedx_manager->getParticipantsBySlot($slot));




/*$speaker = FSSpeaker::getSpeaker(6)->getContent();
var_dump($speaker);

$event = FSEvent::getEvent(2)->getContent();

$argsSlot = array (
    'no'    => '2',
    'event' => $event
);

$slot = FSSlot::getSlot($argsSlot)->getContent();

var_dump($slot);

$argsPlace = array (
    'no'    => 2,
    'slot'  => $slot,
    'speaker' => $speaker
);

$aPlace = FSPlace::getPlace($argsPlace)->getContent();

var_dump($aPlace);*/




/*$slot = FSSlot::getSlot($argsSlot)->getContent();
$speaker = FSSpeaker::getSpeaker(24)->getContent();

$argsPlaceToCreate = array (
    'no'    => 4,
    'slot'  => $slot,
    'speaker' => $speaker
);*/

//var_dump($messageCreatedPlace = FSPlace::addPlace($argsPlaceToCreate));


//$event = FSEvent::getEvent(2)->getContent();

//$organizer = FSOrganizer::getOrganizer(4)->getContent();
//var_dump(FSRole::getRolesByOrganizer($organizer));

//var_dump(FSRole::getRoles());

/*$event = FSEvent::getEvent(2)->getContent();
$organizer = FSOrganizer::getOrganizer(4)->getContent();

$argsGetRole = array (
    'event'     => $event,
    'organizer' => $organizer,
    'name'      => 'Responsable sandwich',
    'level'     => 5
);*/


//var_dump(FSRole::addRole($argsGetRole));
//var_dump(FSPlace::getPlaces());

/*$argsPlace = array (
    'no'    => 2,
    'slotNo' => 2,
    'slotEventNo'   => 2,
    'speakerPersonNo' => 6
);*/

//var_dump($place = FSPlace::getPlace($argsPlace)->getContent());

/** -------------- TEST addEvent
$argsCreateEvent = array(
    'mainTopic'     => 'Les chaussettes à Baudet',
    'startingDate'  => '2013-01-01',
    'endingDate'    => '2013-01-02',
    'startingTime'  => '09:00:00',
    'endingTime'    => '18:00:00',
    'description'   => 'Parce qu il le vaut bien',
);

$slot1 = array (
    'happeningDate'          => '2013-01-01',
    'startingTime'           => '09:00:00',
    'endingTime'             => '18:00:0',
);

$slot2 = array (
    'happeningDate'          => '2013-01-02',
    'startingTime'           => '09:00:00',
    'endingTime'             => '18:00:0',
);


$argsSlots = array( $slot1, $slot2);

$megaArgsAddEvent = array (
    'event'   => $argsCreateEvent,
    'slots'   => $argsSlots // Liste de Slot sans référence à l'Event
);

$messageAddEvent = ASAdmin::addEvent($megaArgsAddEvent);
var_dump($messageAddEvent);
var_dump($messageAddEvent->getContent());
----------------END TEST addEvent*/

/*$event = FSEvent::getEvent(1)->getContent();

$argsSlot = array (
    'no'    => '1',
    'event' => $event
);

$slot = FSSlot::getSlot($argsSlot)->getContent();*/

//var_dump(FSPlace::getPlacesBySlot($slot));



//var_dump(FSSpeaker::getSpeakerByPlace($place));

//var_dump(FSPlace::getPlacesBySlot($slot));


/*$argsAffec = array (
    'teamRole'  => $teamRole,
    'organizer' => $organizer
);*/

//var_dump(FSAffectation::getAffectation($argsAffec));






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


//var_dump(FSSpeaker::getSpeaker(6));
//var_dump(FSSpeaker::getSpeakers());
//var_dump(FSParticipant::getParticipant(8));
//var_dump(FSParticipant::getParticipants());


//var_dump(FSOrganizer::getOrganizer(2));
//var_dump(FSOrganizer::getOrganizers());

//$aPerson = FSPerson::getPerson(5)->getContent();
//var_dump(FSOrganizer::addOrganizer($aPerson));
//var_dump(FSOrganizer::getOrganizers());

/*var_dump($aPerson = FSPerson::getPerson(8)->getContent());

$argsPerson = array (
    'no'           => 8,
    'name'         => 'Jubin',
    'firstname'    => 'Alberto',
    'dateOfBirth'  => '1961-03-11',
    'address'      => 'Rue des Alpes, 22',
    'city'         => 'Lausanne',
    'country'      => 'Switzerland',
    'phoneNumber'  => '0798867275',
    'email'        => 'rsz@tedx.com',
    'description'  => 'Petit Jubin aime PAS les frittes',
    'isArchived'   => 0,
);
 
$aPersonToSet = new Person( $argsPerson ) ;

var_dump($messageSettedPerson = FSPerson::setPerson($aPersonToSet));*/

//$event = FSEvent::getEvent(1)->getContent();

/*$argsSlot = array (
    'event'         => $event,
    'happeningDate' => '2000-02-02',
    'startingTime'  => '07:00:00',
    'endingTime'    => '08:00:00'
);*/

//var_dump(FSSlot::addSlot($argsSlot));

//$speaker = FSSpeaker::getSpeaker(1)->getContent();
//$event = FSEvent::getEvent(1)->getContent();

/*$argsCoOrg = array (
    'event'  => $event,
    'speaker' => $speaker
);*/

//var_dump($speaker);

//var_dump(FSTalk::getTalk($argsCoOrg));
//var_dump(FSTalk::getTalks());



//$speaker2 =  FSSpeaker::getSpeaker(6)->getContent();

/*$argsNew = array (
    'event' => $event,
    'speaker' => $speaker2
);*/

//var_dump(FSTalk::addTalk($argsNew));

//var_dump(FSTalk::getEventsBySpeaker($speaker2));
//var_dump(FSTalk::getSpeakersByEvent($event));

?>


