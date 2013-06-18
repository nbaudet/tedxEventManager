<html>
    <body>
<?php
require_once('../tedx-config.php');
require_once(APP_DIR.'/core/controller/Tedx_manager.class.php');
require_once(APP_DIR.'/core/services/applicatives/ASFree.class.php');
require_once(APP_DIR .'/core/services/functionnals/FSEvent.class.php');
require_once(APP_DIR .'/core/services/functionnals/FSSpeaker.class.php');

echo '<h1>Get Event</h1>';

    
// Récupère un Event
$id=1;
$anEvent = $tedx_manager->getEvent($id);
// Message
if( $anEvent->getStatus())
    echo 'Congrats! ' . $anEvent->getMessage();
else
    echo 'Error! ' . $anEvent->getMessage();
    var_dump($anEvent);

   
    
    //Récupère tous les events
    echo '<h1>Get Events</h1>';
$someEvents = $tedx_manager->getEvents();
// Message
if( $someEvents->getStatus())
    echo 'Congrats! ' . $someEvents->getMessage();
else
    echo 'Error! ' . $someEvents->getMessage();
    var_dump($someEvents);
    
  /*//Récupère tous les events pour un speaker  
    echo '<h1>Get Events by Speaker - FS</h1>';
    $speaker = (FSSpeaker::getSpeaker(6)->getContent());
    var_dump(FSEvent::getEventsBySpeaker($speaker)->getContent());*/
    
    echo '<h1>Motivation</h1>';


/*require_once(APP_DIR .'/core/services/functionnals/FSLocation.class.php');
require_once(APP_DIR .'/core/services/functionnals/FSParticipant.class.php');
require_once(APP_DIR .'/core/services/functionnals/FSEvent.class.php');

/*
echo '<h1>Location</h1>';
var_dump(FSLocation::getLocation("L'Usine"));

var_dump(FSLocation::getLocations());
$argsLocation= array(
            'Name'         => 'Zoooooooorooo',
            'Address'   => 'Une Adresse',
            'City'   => 'Une ville',
            'Country'   => 'Un pays'
         
        );
var_dump(FSLocation::addLocation($argsLocation));
echo '<h1>Participant</h1>';
var_dump(FSParticipant::getParticipant(5));
var_dump(FSParticipant::getParticipants());
var_dump(FSParticipant::addParticipant(8));
<<<<<<< HEAD
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
           
        );
//var_dump(FSEvent::addEvent($argsEvent));

echo '<h1>Participation</h1>';
$aParticipation = array(
            'slotNo'         => 1,
            'slotEventNo'   => 1,
            'participantPersonNo'   => 6
        );
var_dump(FSParticipation::getParticipation($aParticipation));
var_dump(FSParticipation::getParticipations());
$argsParticipation = array(
            "slotNo"         => 2,
            "slotEventNo"   => 2,
            "participantPersonNo"   => 8
        );
var_dump(FSParticipation::addParticipation($argsParticipation));

        
        
echo '<h1>AS Event</h1>';
var_dump(ASEvent::getEvent(1));
var_dump(ASEvent::getEvents());*/
?>
    </body>
</html>