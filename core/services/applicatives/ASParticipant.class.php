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
require_once(APP_DIR . '/core/services/functionnals/FSMotivation.class.php');

/**
 * Description of ASParticipant
 *
 * @author rapou
 */
class ASParticipant {
    //Show a Keyword
    public static function getKeyword($args) {
        $aKeyword = FSKeyword::getKeyword($args);
        return $aKeyword;    
    }//function 
    
    //Show all Keywords of a Person
    public static function getKeywordsByPerson($aPerson) {
        $keywords = FSKeyword::getKeywordsByPerson($aPerson); 
        return $keywords; 
    }//function
    
    //Show all Keywords of a Person for an Event
    public static function getKeywordsByPersonForEvent($args) {
        $keywords = FSKeyword::getKeywordsByPersonForEvent($args); 
        return $keywords; 
    }//function
    
    // Add Keyword To An Event For A Person
    public static function addKeywordsToAnEvent($args) {
    /*  -----------------------------------------------
        $args = array(
           'listOfValues' => array('values'),
           'event'        => $anEvent,
           'person'       => $aPerson
        );
        ----------------------------------------------- */
        $listOfValues = $args['listOfValues'];
        $anEvent = $args['event'];
        $aPerson = $args['person'];
        $i = 0; 
        foreach($listOfValues as $value){
            $messageNbKeywords = FSKeyword::countKeywordsByPersonForEvent(array('event' => $anEvent, 'person' => $aPerson));
            if($messageNbKeywords->getStatus()){
                $messageValidKeyword = FSKeyword::getKeyword(array('value'=> $value, 'event'=> $anEvent, 'person' => $aPerson));
                if(!$messageValidKeyword->getStatus()){
                    $messageAddKeyword = FSKeyword::addKeyword(array('value'=> $value, 'event'=> $anEvent, 'person' => $aPerson));
                    $messages[$i] = $messageAddKeyword;
                }else{
                    $aValidKeyword = $messageValidKeyword->getContent();
                    if($aValidKeyword->getIsArchived() == 1){
                        $aValidKeyword->setIsArchived(0);
                        $messageSetKeyword = FSKeyword::setKeyword($aValidKeyword);
                        $messages[$i] = $messageSetKeyword;
                    }else{
                        $messages[$i] = $messageValidKeyword;
                    }
                }
            }else{
                $messages[$i] = $messageNbKeywords;
            }
            $i++;
        }
        return $messages; 
    }//function
    
    //Show all Keywords of a Person for an Event
    public static function archiveKeyword($args) {
        $value = $args['value'];
        $anEvent = $args['event'];
        $aPerson = $args['person'];
        $messageValidKeyword = FSKeyword::getKeyword(array('value'=> $value, 'event'=> $anEvent, 'person' => $aPerson));
        if($messageValidKeyword->getStatus()){
            $aValidKeyword = $messageValidKeyword->getContent();
            if(!$aValidKeyword->getIsArchived()){
                $aValidKeyword->setIsArchived(1);
                $messageSetKeyword = FSKeyword::setKeyword($aValidKeyword);
                $message = $messageSetKeyword;
            }else{
                $message = $messageValidKeyword;
            }
        }else{
            $message = $messageValidKeyword;
        }
        return $message; 
    }//function
    
    //Show a Motivation
    public static function getMotivation($args) {
        $aMotivation = FSMotivation::getMotivation($args);
        return $aMotivation;    
    }//function 
    
    //Show all Motivations of a Person
    public static function getMotivationsByParticipant($aPerson) {
        $motivations = FSMotivation::getMotivationsByPerson($aPerson); 
        return $motivations; 
    }//function
    
    //Show all Motivations of a Person for an Event
    public static function getMotivationsByParticipantForEvent($args) {
        return FSMotivation::getMotivationsByParticipantForEvent($args); 
    }//function
    
    
    /**
     * Method addMotivationToAnEvent from SA Participant
     * @param type $args 
     * @return type 
     */
    public static function addMotivationToAnEvent($args){
        $aMotivationForAnEvent = FSMotivation::addMotivation($args);
        return $aMotivationForAnEvent;
    }
    
    /**
     * Method archiveMotivationToAnEvent from SA Participant
     * @param type $args 
     * @return type 
     */
    public static function archiveMotivationToAnEvent($args){
        $aText = $args['text'];
        $anEvent = $args['event'];
        $aParticipant = $args['participant'];
        $messageValidMotivation = FSMotivation::getMotivation(array('text'=> $aText, 'event'=> $anEvent, 'participant' => $aParticipant));
        if($messageValidMotivation->getStatus()){
            $aValidMotivation = $messageValidMotivation->getContent();
            if(!$aValidMotivation->getIsArchived()){
                $aValidMotivation->setIsArchived(1);
                $messageSetMotivation = FSKeyword::setKeyword($aValidMotivation);
                $message = $messageSetMotivation;
            }else{
                $message = $messageValidMotivation;
            }
        }else{
            $message = $messageValidMotivation;
        }
        return $message;
    }
    
    // A participant send the registration to a Validator
    public static function sendRegistration($currentRegistration) {
        $newStatus = 'Sent';
        $messageValidEvent = FSEvent::getEvent($currentRegistration->getEventNo());
        if($messageValidEvent->getStatus()){
            $aValidEvent = $messageValidEvent->getContent();
            $messageValidParticipant = FSParticipant::getParticipant($currentRegistration->getParticipantPersonNo());
            if($messageValidParticipant->getStatus()){
                $aValidParticipant = $messageValidParticipant->getContent();
                $currentRegistration->setIsArchived(1);
                $messageArchiveRegistration = FSRegistration::archiveRegistration($currentRegistration);
                if($messageArchiveRegistration->getStatus()){
                     $argsRegistration = array(
                        'status'          => $newStatus, // String
                        'type'            => $currentRegistration->getType(), // String
                        'typeDescription' => $currentRegistration->getTypeDescription(), // Optionel - String
                        'event'           => $aValidEvent, // object Event
                        'participant'     => $aValidParticipant  // object Participant
                    );
                    $message = FSRegistration::addRegistration($argsRegistration);
                }else{
                    $message = $messageArchiveRegistration;
                }
            }else{
                $message = $messageValidParticipant;
            }
        }else{
            $message = $messageValidEvent;
        }
        return $message; 
    }//function
    
    // For getting the history of the registration of a Participant.
    public static function getRegistrationHistory($args) {
        return FSRegistration::getRegistrationHistory($args);
    }
}

?>
