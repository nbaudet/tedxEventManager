<?php


/**
 * Affectation.class.php
 * 
 * Author : Guillaume Lehmann
 * Date : 05.06.2013
 * 
 * Description : define the class Affectation as definited in the model
 * 
 */
class Affectation {
    
    /**
     * Organizer's Organizer person no 
     * @var type int
     */
    protected $organizerPersonNo; 
    
    
    /**
     * Organizer's team role name
     * @var type string
     */
    protected $teamRoleName; 
    
    
    
    /**
     * Constructs object Affectation
     * 
     * @param type $array of parameters that correspond to the classes properties
     */
    public function __construct($array = null){
        
        if(!is_array($array)) {
            throw new Exception('No parameters');
            
        }//if       
        $this->organizerPersonNo = $array['organizerPersonNo']; 
        $this->teamRoleName = $array['teamRoleName']; 
        
        
        
    }//construct
    
    
    /**
     * get organizerPersonNo
     * @return type organizer person no 
     */
    public function getOrganizerPersonNo() {
        return $this->organizerPersonNo; 
    }
    
    
    /**
     * set organizerPersonNo
     * @param type $organizerPersonNo 
     */
    public function setOrganizerPersonNo($organizerPersonNo) {
        $this->organizerPersonNo = $organizerPersonNo; 
    }
    
    
    /**
     * get team role name
     * @return type teamRoleName
     */
    public function getTeamRoleName() {
        return $this->teamRoleName; 
    }
    
    
    /**
     * set team role name
     * @param type $teamRoleName 
     */
    public function setTeamRoleName($teamRoleName) {
        $this->teamRoleName = $teamRoleName; 
    }
    
    
}//class


?>
