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
    
    
    
    public function addKeywordsToAnEvent($args); 
    
    public function archiveKeyword($args); 
    
    public function addMovtivationToAnEvent($args); 
    
    public function archiveMotivationToAnEvent($args); 
    
    
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
    
    public function changeLocationEvent($args); 
    
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
    
    public function affectTeamRole($args); 
    
    public function linkTeamRole($args); 
    
    public function changeRoleLevel($args); 
    
    public function addRole($args); 
    
    public function addEvent($args); 
   
}
?>
