<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

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
    }
    
    // Add a Location
    public static function addLocation($args) {
        $aLocation = FSLocation::addLocation($args);
        return $aLocation;
    }
    
    /**
     * Method registerSpeaker from SA Organizer
     * @param type $args 
     * @return type 
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
            if ($messageAddedSpeaker->getStatus()){
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
                    $messageUnit = FSUnit::getUnitByName('Participant');
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
            }else{
                // Else give the error message about non-adding Member
                $aRegisteredSpeaker = $messageAddedSpeaker;
            }
        } else {
            // Else give the error message about non-adding Person
            $aRegisteredSpeaker = $messageAddedPerson;
        }
        
        // Return the message Visitor Registed or not Registred
        return $aRegisteredSpeaker;
    }
    
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
    }
    
    public static function setEvent( $args ) {
        /*$anEventToUpdate = ($args['event']);
        $anEventToUpdate->setLocationName($args['locationName']);
        $aChangedEventLocation = FSEvent::setEvent($anEventToUpdate);
        return $aChangedEventLocation;*/
    }
    
    public static function changeSlot( $args ) {
        
    }
    
    /**
     * Applicative service to add a slot to an event
     * @param type $args, the event and the slot parameter.
     * @return type message
     */
    public static function addSlotToEvent($args){
        return FSSlot::addSlot($args);
    }
    
    /**
     * Applicative service to add a Speaker to a Slot (Place and Talk)
     * @param type $args, the speaker, the slot, and the parameter of the Place
     * and the Talk of speaker in event.
     * @return type message
     */
    public static function addSpeakerToSlot($args){
       // Argument No is optionnal
       if( isset($args['no'] ) ) {
           $aNo = $args['no'];
       }
       else {
           $aNo = NULL;
       }
       $aSlot = $args['slot'];
       $aSpeaker = $args['speaker'];
       $videoTitle = $args['videoTitle'];
       $videoDescription = $args['videoDescription'];
       $videoURL = $args['videoURL'];
       
       $messageValidEvent = FSEvent::getEvent($aSlot->getEventNo());
       if($messageValidEvent->getStatus()){
           $aValidEvent = $messageValidEvent->getContent();
           $argsSlot = array(
               'event' => $aValidEvent,
               'no' => $aSlot->getNo()
           );
           $messageValidSlot = FSSlot::getSlot($argsSlot);
           if($messageValidSlot->getStatus()){
               $aValidSlot = $messageValidSlot->getContent();
               $messageValidSpeaker = FSSpeaker::getSpeaker($aSpeaker->getNo());
               if($messageValidSpeaker->getStatus()){
                   $aValidSpeaker = $messageValidSpeaker->getContent();
                   $argsPlace = array(
                       'speaker' => $aValidSpeaker,
                       'slot' => $aValidSlot,
                       'no' => $aNo
                   );
                   $messageValidPlace = FSPlace::getPlace($argsPlace);
                   if(!$messageValidPlace->getStatus()){
                       $messageAddedPlace = FSPlace::addPlace($argsPlace);
                       if($messageAddedPlace->getStatus()){
                           $argsTalk = array(
                               'event' => $aValidEvent,
                               'speaker' => $aValidSpeaker,
                               'videoTitle' => $videoTitle,
                               'videoDescription' => $videoDescription,
                               'videoURL' => $videoURL
                           );
                           $messageAddedTalk = FSTalk::addTalk($argsTalk);
                           $message = $messageAddedTalk;
                       }else{
                           $message = $messageAddedPlace;
                       }
                   }else{
                       $message = $messageValidPlace;
                   }
               }else{
                   $message = $messageValidSpeaker;
               }
           }else{
               $message = $messageValidSlot;
           }
       }else{
           $message = $messageValidEvent;
       }
       return $message;
    }
    
    /**
     * Applicative service to change a place of a Speaker to an Event
     * @param type $args.
     * @return type message
     */
    public static function changePositionOfSpeakerToEvent($args){
        
        $place = $args['no'];
        $slot = $args['slot'];
        $event = $args['event'];
        $speaker = $args['speaker'];
        $aPlace = FSPlace::getPlace($args)->getContent();
        var_dump($aPlace->getIsArchived());
        
        //If a non empty speaker
        if(isset($speaker)){
            $aValidSpeaker = FSSpeaker::getSpeaker($speaker->getNo());
                if($aValidSpeaker->getStatus()){
                    //If a non empty event
                    if(isset($event)){
                        $aValidEvent = FSEvent::getEvent($event->getNo());
                            if($aValidEvent->getStatus()){
                                //If a non empty slot
                                if(isset($slot)){
                                    $argsSlot = array(
                                        'event' => $event,
                                        'no'    => $slot->getNo()
                                    );
                                    $aValidSlot = FSSlot::getSlot($argsSlot);
                                    
                                        //If a valid speaker
                                        if($aValidSlot->getStatus()){
                                            //If a empty position or a non existant position
                                            if((empty($place))||((FSPlace::getPlace($args)->getStatus()) == FALSE)){   
                                                $newPlace = array(
                                                    'slot'  =>  $aValidSlot->getContent(),
                                                    'speaker'   =>  $aValidSpeaker->getContent(),
                                                    'no'    =>  $place
                                                );
                                                $aPlaceAdded = FSPlace::addPlace($newPlace)->getContent();
                                                $argsMessage = array(
                                                    'messageNumber'     => 000,
                                                    'message'           => 'A place changed',
                                                    'status'            => true,
                                                    'content'           => $aPlaceAdded
                                                );
                                                $return = new Message($argsMessage);
                                            }else{
                                                //If position is not archived
                                                if(($aPlace->getIsArchived()) == '0'){
                                                    $aPlaceArchived = FSPlace::setPlace($args);
                                                    $argsMessage = array(
                                                        'messageNumber'     => 000,
                                                        'message'           => 'A place archived',
                                                        'status'            => true,
                                                        'content'           => $aPlaceArchived
                                                    );
                                                    $return = new Message($argsMessage);
                                                }
                                            }
                                        }else{
                                            echo 'oooooooooooooo';
                                            $argsMessage = array(
                                                'messageNumber'     => 000,
                                                'message'           => 'Inexistant slot',
                                                'status'            => false,
                                                'content'           => null
                                            );
                                            $return = new Message($argsMessage);
                                        }
                                }else{
                                    $argsMessage = array(
                                        'messageNumber'     => 000,
                                        'message'           => 'Empty slot',
                                        'status'            => false,
                                        'content'           => null
                                    );
                        $return = new Message($argsMessage);
                                }
                            }else{
                                $argsMessage = array(
                                    'messageNumber'     => 000,
                                    'message'           => 'Inexistant event',
                                    'status'            => false,
                                    'content'           => null
                                );
                                $return = new Message($argsMessage);
                            }
                    }else{
                        $argsMessage = array(
                            'messageNumber'     => 000,
                            'message'           => 'Empty event',
                            'status'            => false,
                            'content'           => null
                        );
                        $return = new Message($argsMessage);
                    } 
                }else{
                    $argsMessage = array(
                        'messageNumber'     => 000,
                        'message'           => 'Inexistant speaker',
                        'status'            => false,
                        'content'           => null
                    );
                    $return = new Message($argsMessage);
                }
        }else{
            $argsMessage = array(
                'messageNumber'     => 000,
                'message'           => 'Empty speaker',
                'status'            => false,
                'content'           => null
            );
            $return = new Message($argsMessage);
        }
        return $return;
    }
    
}

?>
