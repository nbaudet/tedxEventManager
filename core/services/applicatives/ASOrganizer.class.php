<?php

require_once(APP_DIR . '/core/services/functionnals/FSAccess.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSEvent.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSKeyword.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSLocation.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSMember.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSMembership.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSOrganizer.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSParticipant.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSParticipation.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSRegistration.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSRole.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSSlot.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSSpeaker.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSTeamRole.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSUnit.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSPerson.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSPlace.class.php');
require_once(APP_DIR . '/core/model/Place.class.php');

/**
 * Description of ASOrganizer
 *
 * @author rapou
 */
class ASOrganizer {

    /**
     * Constructor of applicative service Organizer
     */
    public function __construct() {
        // do nothing;
    }//construct

    /**
     * Add a Location
     * @param type $args
     * @return type a Location
     */
    public static function addLocation($args) {
        $aLocation = FSLocation::addLocation($args);
        return $aLocation;
    }//function

    /**
     * Method registerSpeaker from SA Organizer
     * @param type $args 
     * @return type a registered Speaker
     */
    public static function registerSpeaker($args) {
        /*
          $argsPerson = array(
          'name'         => '',
          'firstname'    => '',
          'dateOfBirth'  => '',
          'address'      => '',
          'city'         => '',
          'country'      => '',
          'phoneNumber'  => '',
          'email'        => '',
          'description'  => '',
          'idmember'     => '',
          'password'     => '',
          );
         */
        // Arguments for adding a Person
        $argsPerson = array(
            'name' => $args['name'],
            'firstname' => $args['firstname'],
            'dateOfBirth' => $args['dateOfBirth'],
            'address' => $args['address'],
            'city' => $args['city'],
            'country' => $args['country'],
            'phoneNumber' => $args['phoneNumber'],
            'email' => $args['email'],
            'description' => $args['description']
        );

        // Add a Person
        $messageAddedPerson = FSPerson::addPerson($argsPerson);
        // If the Person is added, continue. 
        if ($messageAddedPerson->getStatus()) {
            $anAddedPerson = $messageAddedPerson->getContent();
            $messageAddedSpeaker = FSSpeaker::addSpeaker($anAddedPerson);
            if ($messageAddedSpeaker->getStatus()) {
                // Arguments for adding a Member
                $argsMember = array(
                    'id' => $args['idmember'],
                    'password' => $args['password'],
                    'person' => $anAddedPerson
                );
                // Add a Member
                $messageAddedMember = FSMember::addMember($argsMember);
                // If the Member is added, continue.
                if ($messageAddedMember->getStatus()) {
                    $anAddedMember = $messageAddedMember->getContent();
                    // Get the Unit with the name 'Visitor' 
                    $messageUnit = FSUnit::getUnitByName('Organizer');
                    $participantUnit = $messageUnit->getContent();
                    // Arguments for adding a Membership
                    $argsMembership = array(
                        'member' => $anAddedMember,
                        'unit' => $participantUnit
                    );
                    // Add a Membership
                    $messageAddedMembership = FSMembership::addMembership($argsMembership);
                    // If the Membership is added, generate the message OK
                    if ($messageAddedMembership->getStatus()) {
                        $anAddedMembership = $messageAddedMembership->getContent();
                        $argsMessage = array(
                            'messageNumber' => 428,
                            'message' => 'Speaker registered',
                            'status' => true,
                            'content' => array('anAddedPerson' => $anAddedPerson, 'anAddedMember' => $anAddedMember, 'anAddedMembership' => $anAddedMembership)
                        );
                        $aRegisteredSpeaker = new Message($argsMessage);
                    } else {
                        // Else give the error message about non-adding Membership
                        $aRegisteredSpeaker = $messageAddedMembership;
                    }
                } else {
                    // Else give the error message about non-adding Member
                    $aRegisteredSpeaker = $messageAddedMember;
                }
            } else {
                // Else give the error message about non-adding Member
                $aRegisteredSpeaker = $messageAddedSpeaker;
            }
        } else {
            // Else give the error message about non-adding Person
            $aRegisteredSpeaker = $messageAddedPerson;
        }

        // Return the message Visitor Registed or not Registred
        return $aRegisteredSpeaker;
    }//function

    /**
     * Method change the Location of a Event
     * @param type $args 
     * @return type 
     */
    public static function changeEventLocation($args) {
        $anEventToUpdate = ($args['event']);
        $anEventToUpdate->setLocationName($args['locationName']);
        $aChangedEventLocation = FSEvent::setEvent($anEventToUpdate);
        return $aChangedEventLocation;
    }//function

    /**
     * Applicative service to add a slot to an event
     * @param type $args, the event and the slot parameter.
     * @return type message
     */
    public static function addSlotToEvent($args) {
        return FSSlot::addSlot($args);
    }//function

    /**
     * Applicative service to add a Speaker to a Slot (Place and Talk).
     * Give the units Visitor, Participant and Organizer to the Speaker.
     * @param type $args, the speaker, the slot, and the parameter of the Place
     * and the Talk of speaker in event.
     * @return type message
     */
    public static function addSpeakerToPlace($args) {
        $aNo = $args['no'];
        $aSlot = $args['slot'];
        $aSpeaker = $args['speaker'];
        $videoTitle = $args['videoTitle'];
        $videoDescription = $args['videoDescription'];
        $videoURL = $args['videoURL'];

        // Validate existence of Event
        $messageValidEvent = FSEvent::getEvent($aSlot->getEventNo());
        if ($messageValidEvent->getStatus()) {
            $aValidEvent = $messageValidEvent->getContent();
            $argsSlot = array(
                'event' => $aValidEvent,
                'no' => $aSlot->getNo()
            );
            
            // Validate existence of Slot
            $messageValidSlot = FSSlot::getSlot($argsSlot);
            if ($messageValidSlot->getStatus()) {
                $aValidSlot = $messageValidSlot->getContent();
                
                // Validate existence of Speaker
                $messageValidSpeaker = FSSpeaker::getSpeaker($aSpeaker->getNo());
                if ($messageValidSpeaker->getStatus()) {
                    $aValidSpeaker = $messageValidSpeaker->getContent();
                    $argsPlace = array(
                        'speaker' => $aValidSpeaker,
                        'slot' => $aValidSlot,
                        'no' => $aNo
                    );
                    
                    // Validate inexistence of Place
                    $messageValidPlace = FSPlace::getPlace($argsPlace);
                    if (!$messageValidPlace->getStatus()) {
                        
                        // Add new Place
                        $messageAddedPlace = FSPlace::addPlace($argsPlace);
                        if ($messageAddedPlace->getStatus()) {
                            $argsTalk = array(
                                'event' => $aValidEvent,
                                'speaker' => $aValidSpeaker,
                                'videoTitle' => $videoTitle,
                                'videoDescription' => $videoDescription,
                                'videoURL' => $videoURL
                            );
                            $messageAddedTalk = FSTalk::addTalk($argsTalk);

                            $argsMessage = array(
                                'messageNumber' => 175,
                                'message' => 'Speaker added to Place',
                                'status' => true,
                                'content' => array($messageAddedPlace, $messageAddedTalk)
                            );

                            $message = new Message($argsMessage);
                        }
                        // Else: Place not added
                        else {
                            $message = $messageAddedPlace;
                        }
                    }
                    // Else: Already existing place
                    else {
                        $message = $messageValidPlace;
                    }
                }
                // Else: nonexistent Speaker
                else {
                    $message = $messageValidSpeaker;
                }
            }
            // Else: nonexistent Slot
            else {
                $message = $messageValidSlot;
            }
        }
        // Else: nonexistent Event
        else {
            $message = $messageValidEvent;
        }
        return $message;
    }

    /**
     * Applicative service to change a place of a Speaker to an Event
     * @param type $args.
     * @return type message
     */
    public static function changePositionOfSpeaker($args) {

        $newPlace = $args['newNo'];
        $oldPlace = $args['oldNo'];
        $slot = $args['slot'];
        $event = $args['event'];
        $speaker = $args['speaker'];

        //An array of the new place existance
        $argsNewPlace = array(
            'no' => $newPlace,
            'slot' => $slot,
            'event' => $event,
            'speaker' => $speaker
        );
        //An array of the old place existance
        $argsOldPlace = array(
            'no' => $oldPlace,
            'slot' => $slot,
            'event' => $event,
            'speaker' => $speaker
        );

        //If a non empty speaker
        if (isset($speaker)) {
            $aValidSpeaker = FSSpeaker::getSpeaker($speaker->getNo());
            if ($aValidSpeaker->getStatus()) {
                //If a non empty event
                if (isset($event)) {
                    $aValidEvent = FSEvent::getEvent($event->getNo());
                    //If a valid Event
                    if ($aValidEvent->getStatus()) {
                        //If a non empty slot
                        if (isset($slot)) {
                            $argsSlot = array(
                                'no' => $slot->getNo(),
                                'event' => $event
                            );
                            $aValidSlot = FSSlot::getSlot($argsSlot);

                            //If a valid speaker
                            if ($aValidSlot->getStatus()) {

                                $messageExistantPlace = FSPlace::getPlace($argsNewPlace);
                                if (empty($newPlace)) {
                                    $argsMessage = array(
                                        'messageNumber' => 242,
                                        'message' => 'A not valid Place no',
                                        'status' => false,
                                        'content' => null
                                    );
                                    $return = new Message($argsMessage);
                                } else {
                                    //If a empty position or a non existant position
                                    if (!($messageExistantPlace->getStatus())) {
                                        //Not existing Place
                                        $newPlace = array(
                                            'slot' => $slot,
                                            'speaker' => $speaker,
                                            'no' => $newPlace
                                        );
                                        //Not valid place
                                        $aPlaceAdded = FSPlace::addPlace($newPlace);
                                        //Archived la précédente
                                        $anOldPlaceToArchive = FSPlace::getPlace($argsOldPlace)->getContent();
                                        $anOldPlaceToArchive->setIsArchived(1);
                                        FSPlace::setPlace($anOldPlaceToArchive);
                                        $argsMessage = array(
                                            'messageNumber' => 243,
                                            'message' => 'A place changed and old one archived',
                                            'status' => true,
                                            'content' => $aPlaceAdded
                                        );
                                        $return = new Message($argsMessage);
                                    } else {
                                        //Existing Place
                                        $aPlace = FSPlace::getPlace($argsNewPlace)->getContent();
                                        //If place is not archived (0)
                                        if (!($aPlace->getIsArchived())) {

                                            //$aPlaceArchived = FSPlace::setPlace($args);
                                            $argsMessage = array(
                                                'messageNumber' => 244,
                                                'message' => 'A place already existing',
                                                'status' => false,
                                                'content' => null
                                            );
                                            $return = new Message($argsMessage);
                                        } else {
                                            $aPlace = FSPlace::getPlace($argsNewPlace)->getContent();
                                            //Place is archived (1)
                                            $aPlaceToArchived = $aPlace->setIsArchived(0);
                                            $aDearchivedPlace = FSPlace::setPlace($aPlaceToArchived);
                                            $argsMessage = array(
                                                'messageNumber' => 245,
                                                'message' => 'A place changed',
                                                'status' => true,
                                                'content' => $aDearchivedPlace
                                            );
                                            $return = new Message($argsMessage);
                                        }
                                    }
                                }
                            } else {

                                $argsMessage = array(
                                    'messageNumber' => 246,
                                    'message' => 'Inexistant slot',
                                    'status' => false,
                                    'content' => null
                                );
                                $return = new Message($argsMessage);
                            }
                        } else {
                            $argsMessage = array(
                                'messageNumber' => 247,
                                'message' => 'Empty slot for this event',
                                'status' => false,
                                'content' => null
                            );
                            $return = new Message($argsMessage);
                        }
                    } else {
                        $argsMessage = array(
                            'messageNumber' => 248,
                            'message' => 'Inexistant event',
                            'status' => false,
                            'content' => null
                        );
                        $return = new Message($argsMessage);
                    }
                } else {
                    $argsMessage = array(
                        'messageNumber' => 249,
                        'message' => 'Empty event',
                        'status' => false,
                        'content' => null
                    );
                    $return = new Message($argsMessage);
                }
            } else {
                $argsMessage = array(
                    'messageNumber' => 250,
                    'message' => 'Inexistant speaker',
                    'status' => false,
                    'content' => null
                );
                $return = new Message($argsMessage);
            }
        } else {
            $argsMessage = array(
                'messageNumber' => 251,
                'message' => 'Empty speaker',
                'status' => false,
                'content' => null
            );
            $return = new Message($argsMessage);
        }
        return $return;
    }

    /**
     * Edit the parameter of the event.
     * @param array $args the news arguments 
     * @return type message
     */
    public static function changeEvent($args) {
        /*
          $argsEvent = array(
            'no' => $row['No'],
            'mainTopic' => $row['MainTopic'],
            'description' => $row['Description'],
            'startingDate' => $row['StartingDate'],
            'endingDate' => $row['EndingDate'],
            'startingTime' => $row['StartingTime'],
            'endingTime' => $row['EndingTime'],
          );
        */
        $messageValidEvent = FSEvent::getEvent($args['no']);
        if ($messageValidEvent->getStatus()) {
            $aValidEvent = $messageValidEvent->getContent();
            $anEventToSet = self::setEvent($aValidEvent, $args);
            $messageSetEvent = FSEvent::setEvent($anEventToSet);
            $finalMessage = $messageSetEvent;
        } else {
            $finalMessage = $messageValidEvent;
        }
        return $finalMessage;
    }//function
    
    /**
     * Edit the parameter of a Location.
     * @param array $args the news arguments and the ID of the Person
     * @return type message
     */
    public static function changeLocation($args) {
        /*
            $argsLocation = array(
                'name'          => $data['Name'],
                'address'       => $data['Address'],
                'city'          => $data['City'],
                'country'       => $data['Country'],
                'direction'     => $data['Direction'],
            );
        */
        $messageValidLocation = FSLocation::getLocation($args['name']);
        if ($messageValidLocation->getStatus()) {
            $aValidLocation = $messageValidLocation->getContent();
            $anLocationToSet = self::setLocation($aValidLocation, $args);
            $messageSetLocation = FSLocation::setLocation($anLocationToSet);
            $finalMessage = $messageSetLocation;
        } else {
            $finalMessage = $messageValidLocation;
        }
        return $finalMessage;
    }//function
    
    
    /**
     * Edit the parameters of a Slot.
     * @param array $args the news arguments and the ID
     * @return Message
     */
    public static function changeSlot($args) {
        /*
            $argsSlot = array(
                'no'          => $data['No'],
                'event'       => $anEvent,
                'happeningDate' => $data['HappeningDate'],
                'startingTime'  => $data['StartingTime'],
                'endingTime'    => $data['EndingTime'],
            );
        */
        $messageValidSlot = FSSlot::getSlot($args);
        if ($messageValidSlot->getStatus()) {
            $aValidSlot = $messageValidSlot->getContent();
            $aSlotToSet = self::setSlot($aValidSlot, $args);
            $messageSetSlot = FSSlot::setSlot($aSlotToSet);
            $finalMessage = $messageSetSlot;
        } else {
            $finalMessage = $messageValidSlot;
        }
        return $finalMessage;
    }//function
    
    /**
     * Set Event
     * @param Event $aValidPerson
     * @param array $argsToSet
     * @return Event a valid Event
     */
    private static function setEvent($aValidEvent, $argsToSet) {
        /*
          $argsEvent = array(
            'mainTopic' => $row['MainTopic'],
            'description' => $row['Description'],
            'startingDate' => $row['StartingDate'],
            'endingDate' => $row['EndingDate'],
            'startingTime' => $row['StartingTime'],
            'endingTime' => $row['EndingTime'],
          );
         */
        foreach($argsToSet as $key => $arg){
            switch ($key) {
                case 'mainTopic':
                    $aValidEvent->setMainTopic($arg);
                    break; 
                case 'description':
                    $aValidEvent->setDescription($arg);
                    break;
                case 'startingDate':
                    $aValidEvent->setStartingDate($arg);
                    break;
                case 'endingDate':
                    $aValidEvent->setEndingDate($arg);
                    break; 
                case 'startingTime':
                    $aValidEvent->setStartingTime($arg);
                    break;
                case 'endingTime':
                    $aValidEvent->setEndingTime($arg);
                    break;
            } // Switch
        } // Foreach
        return $aValidEvent;
    }// function
    
    private static function setLocation($aValidLocation, $argsToSet) {
        /*
          $argsLocation = array(
                'address'       => $data['Address'],
                'city'          => $data['City'],
                'country'       => $data['Country'],
                'direction'     => $data['Direction'],
            );
         */
        foreach($argsToSet as $key => $arg){
            switch ($key) {
                case 'address':
                    $aValidLocation->setAddress($arg);
                    break; 
                case 'city':
                    $aValidLocation->setCity($arg);
                    break; 
                case 'country':
                    $aValidLocation->setCountry($arg);
                    break; 
                case 'direction':
                    $aValidLocation->setDirection($arg);
                    break;
            } // Switch
        } // Foreach
        return $aValidLocation;
    }// function
    
    private static function setSlot($aValidSlot, $argsToSet) {
        /*
           $argsSlot = array(
                'happeningDate' => $data['HappeningDate'],
                'startingTime'  => $data['StartingTime'],
                'endingTime'    => $data['EndingTime'],
            );
         */
        foreach($argsToSet as $key => $arg){
            switch ($key) {
                case 'happeningDate':
                    $aValidSlot->setHappeningDate($arg);
                    break; 
               case 'startingTime':
                    $aValidSlot->setStartingTime($arg);
                    break;
               case 'endingTime':
                    $aValidSlot->setEndingTime($arg);
                    break;
            } // Switch
        } // Foreach
        return $aValidSlot;
    }// function
    
    /**
     * Sets a Person as Organizer (if not already Organizer)
     * @param Person $person
     * @return a Message containing the created Organizer
     */
    public static function setPersonAsOrganizer($person){
        return FSOrganizer::setPersonAsOrganizer($person);
    }
    
}//class
?>