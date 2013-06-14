<html>
    <body>
<?php
require_once('../tedx-config.php');
require_once(APP_DIR .'/core/services/functionnals/FSLocation.class.php');
require_once(APP_DIR .'/core/services/functionnals/FSParticipant.class.php');
require_once(APP_DIR .'/core/services/functionnals/FSEvent.class.php');

echo '<h1>Location</h1>';
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
echo '<h1>Participant</h1>';
var_dump(FSParticipant::getParticipant(5));
var_dump(FSParticipant::getParticipants());
var_dump(FSParticipant::addParticipant(8));
echo '<h1>Event</h1>';
var_dump(FSEvent::getEvent(1));
var_dump(FSEvent::getEvents());
$argsEvent = array(
            "mainTopic"         => "Tom Pouce nétait pas si petit",
            "description"   => "Petit mais pas vert!",
            "startingDate"   => "2014-10-05",
            'endingDate'   => "2014-10-05",
            "startingTime"   => "13:00:00",
            "endingTime"   => "18:00:00"
            /*'Direction'*/
        );
var_dump(FSEvent::addEvent($argsEvent));
?>
    </body>
</html>