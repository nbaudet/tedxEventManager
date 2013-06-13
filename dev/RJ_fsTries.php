<?php
require_once('../tedx-config.php');
require_once(APP_DIR .'/core/services/functionnals/FSLocation.class.php');
require_once(APP_DIR .'/core/services/functionnals/FSParticipant.class.php');
require_once(APP_DIR .'/core/services/functionnals/FSEvent.class.php');

var_dump(FSLocation::getLocation("L'Usine"));

var_dump(FSLocation::getLocations());
$argsLocation= array(
            'Name'         => 'Zoooooooorooo',
            'Address'   => 'Une Adresse',
            'City'   => 'Une ville',
            'Country'   => 'Un pays'
            /*'Direction'*/
        );
var_dump(FSLocation::addLocation($argsLocation));

var_dump(FSParticipant::getParticipant(5));
var_dump(FSParticipant::getParticipants());
var_dump(FSParticipant::addParticipant(8));

var_dump(FSEvent::getEvent(1));
var_dump(FSEvent::getEvents());
$argsEvent= array(
            'mainTopic'         => 'Tom Pouce n\'était pas si petit',
            'description'   => '18:00:00',
            'startingDate'   => 'Petit mais pas vert!',
            'endingDate'   => '2014-10-05',
            'startingTime'   => '2014-10-05',
            'endingTime'   => '13:00:00'
            );
var_dump(FSEvent::addEvent($argsEvent));
?>