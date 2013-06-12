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
    
    public function login($args); 
    
    public function logout($args); 
    
    public function isMemberOf($args); 
    
    
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
    public function addMovtivationToAnEvent($args) {
        $args = array(
            'messageNumber' => 001,
            'message'       => 'aMotivationToAnEventAdded',
            'status'        => true
        ); 
        return $messageOK = new Message($args); 
    }//function
    
    
    
    public function archiveMotivationToAnEvent($args) {
        $args = array(
            'messageNumber' => 001,
            'message'       => 'aMotivationToAnEventAdded', 
            'status'        => true
        
        ); 
        return $messageOK = new Message($args); 
    }
    
    
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
    
    
    
    public function addSpeakerToSlot($args); 
    
    public function changePositionOfSpeakerToEvent($args); 
    
    public function addSlotToEvent($args); 
    
    public function addLocation($args); 
    
    
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
    }   
    
    
    public function changeRegistrationStatus($args); 
    
    
    
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
    
    public function addTeamRole($args); 
    
    
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
    
    
    
    public function linkTeamRole($args); 
    
    public function changeRoleLevel($args); 
    
    public function addRole($args); 
    
    public function addEvent($args); 
   
}
?>
