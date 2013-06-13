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
     * Affectation's organizerPersonNo
     * @var type int
     */
    private $organizerPersonNo; 
    
    
    /**
     * Affectation's teamRoleName
     * @var type string
     */
    private $teamRoleName; 
    
    
    /**
     * Affectation's isArchived
     * @var type boolean
     */
    private $isArchived; 
    
    
    
    
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
        $this->isArchived = $array['isArchived']; 
        
        
        
    }//construct
    
    
    /**
     * get organizerPersonNo
     * @return type organizer person no 
     */
    public function getOrganizerPersonNo() {
        return $this->organizerPersonNo; 
    }//function
    
    
    /**
     * get team role name
     * @return type teamRoleName
     */
    public function getTeamRoleName() {
        return $this->teamRoleName; 
    }//function
    
    
    /**
     * get isArchived
     * @return type boolean isArchived
     */
    public function getIsArchived() {
        return $this->isArchived; 
    }//function
    
    
    /**
     * set isArchived
     * @param type $isArchived 
     */
    public function setIsArchived($isArchived) {
        $this->isArchived = $isArchived; 
    }//function
    
    
}//class


?>
