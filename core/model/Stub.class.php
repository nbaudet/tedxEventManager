<?php

require_once 'Message.class.php';

/**
 * Stub.class.php
 * 
 * Author : Guillaume Lehmann
 * Date : 11.06.2013
 * 
 * Description : define the class Stub as definited in the model
 * 
 */
class Stub {
    
    
    public function __construct() {
        
    }
    
    /**
     * Stub getAnEvent
     * @param type $args
     * @return type object $message
     */
    public function getEvent() {
        
      $args = array(
          'messageNumber' => 001,
          'message'       => 'aGottenEvent',
          'status'        => true,
      );
           return $messageOK = new Message($args) ;       
    }//function
    /**
     * Stub getSomeEvents
     * @param type $args
     * @return type object $message
     */
    public function getEvents() {
        
      $args = array(
          'messageNumber' => 001,
          'message'       => 'someGottenEvents',
          'status'        => true
      );
           return $messageOK = new Message($args) ;       
    }//function
    
    /**
     * Stub registerVisitor
     * @param type $args
     * @return type object Message
     */
    public function registerVisitor($args){
        
        $args = array(
            'messageNumber' => 001,
            'message'       => 'aRegisteredVisitor',
            'status'        => true
        
        );
        return $messageOK = new Message($args); 
    }//function
    
 
    /**
     * Stub registerToAnEvent
     * @param type $args
     * @return type object $message
     */
    public function registerToAnEvent($args) {
        
      $args = array(
          'messageNumber' => 001,
          'message'       => 'aRegisteredParticipant',
          'status'        => true
      );
           return $messageOK = new Message($args) ;       
    }//function
    
    
    /**
     * Stub changeProfil
     * @param type $args
     * @return type object $message
     */
    public function changeProfil($args) { 
    
        $args = array(
            'messageNumber' => 001, 
            'message'       => 'aChangedProfil',
            'status'        => true
        ); 
        return $messageOK = new Message($args);
    }//function
    
    
    /**
     * Stub changePassword
     * @param type $args
     * @return type object $message
     */
    public function changePassword($args) {
    
        $args = array(
            'messageNumber' => 001,
            'message'       => 'aPasswordChanged',
            'status'        => true
        ); 
        return $messageOK = new Message($args);       
    }//function
    
    
    /**
     * Stub addKeywordsToAnEvent
     * @param type $args
     * @return type object $message
     */
    public function addKeywordsToAnEvent($args) {
        $args = array(
            'messageNumber' => 001, 
            'message'       => 'aKeywordsToAnEventAdded', 
            'status'        => true
        ); 
        return $messageOK = new Message($args); 
    }//function
    
    
    /**
     * Stub archiveKeyword
     * @param type $args
     * @return type object Message
     */
    public function archiveKeyword($args) {
        $args = array(
            'messageNumber' => 001,
            'message'       => 'aKeywordArchived',
            'status'        => true
        ); 
        return $messageOK = new Message($args); 
    }//function
    
    
    /**
     * Stub addMotivationToAnEvent
     * @param type $args
     * @return type object Message
     */
    public function addMotivationToAnEvent($args) {
        $args = array(
            'messageNumber' => 001,
            'message'       => 'aMotivationToAnEventAdded',
            'status'        => true
        ); 
        return $messageOK = new Message($args); 
    }//function
    
    
    /**
     * Stub archiveMotivationToAnEvent
     * @param type $args
     * @return type object Message
     */
    public function archiveMotivationToAnEvent($args) {
        $args = array(
            'messageNumber' => 001,
            'message'       => 'aMotivationToAnEventAdded', 
            'status'        => true
        
        ); 
        return $messageOK = new Message($args); 
    }//function
    
    
    /**
     * Stub registerSpeaker
     * @param type $args
     * @return type object Message
     */
    public function registerSpeaker($args) {
        $args = array(
            'messageNumber' => 001,
            'message'       => 'aSpeakerRegistered',
            'status'        => true
        ); 
        return $messageOK = new Message($args);
    }//function
    
    
    /**
     * Stub addSpeakerToSlot
     * @param type $args
     * @return type object Message
     */
    public function addSpeakerToSlot($args) {
        $args = array(
            'messageNumber' => 001,
            'message'       => 'aSpeakerToSlotAdded',
            'status'        => true
        );
        return $messageOK = new Message($args); 
    }//function 
    
        
    /**
     * Stub changePositionOfSpeakerToEvent
     * @param type $args
     * @return type object Message
     */
    public function changePositionOfSpeakerToEvent($args) {
        $args = array(
            'messageNumber' => 001,
            'message'       => 'aPositionOfSpeakerToEventChanged', 
            'status'        => true
        ); 
        return $messageOK = new Message($args); 
    }//function
    
       
    /**
     * Stub addSlotToEvent
     * @param type $args
     * @return type object addSlotToEvent
     */
    public function addSlotToEvent($args) {
        
        $args = array(
            'messageNumber' => 001, 
            'message'       => 'aSlotToEventAdded', 
            'status'        => true
        ); 
        return $messageOK = new Message($args); 
    }//function
    
    
    
    /**
     * Stub addLocation
     * @param type $args
     * @return type object addLocation
     */
    public function addLocation($args) {
        $args = array(
            'messageNumber' => 001, 
            'message'       => 'aLocationAdded',
            'status'        => true
        
        ); 
        return $messageOK = new Message($args); 
    }//function
    
    
    /**
     * Stub changLocationEvent
     * @param type $args
     * @return type object Message
     */
    public function changeLocationEvent($args) {
        $args = array(
            'messageNumber' => 001,
            'message'       => 'aLocationEventChanged',
            'status'        => true
        );
        return $messageOK = new Message($args); 
    }//function
    
    
    
    /**
     * Stub changeRegistrationStatus
     * @param type $args
     * @return type object Message
     */
    public function changeRegistrationStatus($args) {
        $args = array(
            'messageNumber' => 001, 
            'message'       => 'aRegistrationStatusChanged',
            'status'        => true
        ); 
        return $messageOK = new Message($args); 
    }//function
    
    
    /**
     * Stub registerOrganizer
     * @param type $args
     * @return type object Message
     */
    public function registerOrganizer($args) {
        $args = array(
            'messageNumber' => 001, 
            'message'       => 'aSpeakerRegistered',
            'status'        => true
        );
        return $messageOK = new Message($args); 
    }//function
    
    
    /**
     * Stub addTeamRole
     * @param type $args
     * @return type object Message
     */
    public function addTeamRole($args) {
        $args = array(
            'messageNumber' => 001, 
            'message'       => 'aTeamRoleAdded',
            'status'        => true
        ); 
        return $messageOK = new Message($args);        
    }//function
    
    
    /**
     * Stub affectTeamRole
     * @param type $args
     * @return type object Message
     */
    public function affectTeamRole($args) {
        $args = array(
            'messageNumber' => 001, 
            'message'       => 'aTeamRoleAffected',
            'status'        => true     
        );
        return $messageOK = new Message($args); 
    }//function
    
    
    /**
     * Stub linkTeamRole
     * @param type $args
     * @return type object Message
     */
    public function linkTeamRole($args) {
        $args = array(
            'messageNumber' => 001, 
            'message'       => 'aTeamRoleLinked',
            'status'        => true
        ); 
        return $messageOK = new Message($args); 
    }//function
    
    
    /**
     * Stub changeRoleEvent
     * @param type $args
     * @return type object Message
     */
    public function changeRoleLevel($args) {
        
        $args = array(
            'messageNumber' => 001,
            'message'       => 'aRoleAdded', 
            'status'        => true
        ); 
        return $messageOK = new Message($args); 
    }//function
    
    
    /**
     * Stub addRole
     * @param type $args
     * @return type object Message
     */
    public function addRole($args) {
        $args = array(
            'messageNumber' => 001, 
            'message'       => 'aRoleAdded', 
            'status'        => true
        );
        return $messageOK = new Message($args); 
    }//function
    
    
    /**
     * Stub addEvent
     * @param type $args
     * @return type object Message
     */
    public function addEvent($args) {
        $args = array(
            'messageNumber' => 001,
            'message'       => 'anEventAdded', 
            'status'        => true
        ); 
        return $messageOK = new Message($args); 
    }//function 
   
    
    
}
?>
