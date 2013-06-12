<?php



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
    
    
    public function registerVisitor($args){
        
    } 
    
    public function login($args); 
    
    public function logout($args); 
    
    public function isMemberOf($args); 
    
    public function registerToAnEvent($args) {
        
        if(isset($args['person'])) {
            
        }
        if(isset($args['event'])) {
            
        }
        if(isset($args['slots'])) {
            
        }
        if(isset($args['registrationdate'])) {
            
        }
        if(isset($args['type'])) {
            
        }
        if(isset($args['typedescription'])) {
            
        }
            
    }
    
    public function changeProfil($args); 
    
    public function changePassword($args); 
    
    public function addKeywordsToAnEvent($args); 
    
    public function archiveKeyword($args); 
    
    public function addMovtivationToAnEvent($args); 
    
    public function archiveMotivationToAnEvent($args); 
    
    public function registerSpeaker($args); 
    
    public function addSpeakerToSlot($args); 
    
    public function changePositionOfSpeakerToEvent($args); 
    
    public function addSlotToEvent($args); 
    
    public function addLocation($args); 
    
    public function changeLocationEvent($args); 
    
    public function changeRegistrationStatus($args); 
    
    public function registerOrganizer($args); 
    
    public function addTeamRole($args); 
    
    public function affectTeamRole($args); 
    
    public function linkTeamRole($args); 
    
    public function changeRoleLevel($args); 
    
    public function addRole($args); 
    
    public function addEvent($args); 
   
}
?>
