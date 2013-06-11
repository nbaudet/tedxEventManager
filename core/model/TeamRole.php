<?php



/**
 * TeamRole.class.php
 * 
 * Author : Guillaume Lehmann
 * Date : 06.06.2013
 * 
 * Description : define the class TeamRole as definited in the model
 * 
 */
class TeamRole {
    
    
    
    /** 
     * TeamRole's name
     * @var type string
     */
    private $name;
    
    
    /**
     * TeamRole's isMemberOf
     * @var type string 
     */
    private $isMemberOf; 
    
    
    /**
     * TeamRole's isArchived
     * @var type boolean isArchived
     */
    private $isArchived; 
    
    
    
    /**
     * Constructs object TeamRole
     * 
     * @param type $array of parameters that correspond to the classes properties
     */
    protected function __construct($array = null){
        
        if(!is_array($array)) {
            throw new Exception('No parameters');
                       
        }//if
        $this->name = $array['name']; 
        $this->isMemberOf = $array['isMemberOf']; 
        $this->isArchived = $array['isArchived']; 

        
 
        
    }//construct
    
    
    
    /**
     * get name
     * @return type string name
     */
    protected function getName() {
        return $this->name; 
    }//function
    
    
    /**
     * get isMemberOf
     * @return type string isMemberOf
     */
    protected function getIsMemberOf() {
        return $this->isMemberOf; 
    }//function
    
    
    /**
     * set isMemberOf
     * @param type $isMemberOf 
     */
    protected function setIsMemberOf($isMemberOf) {
        $this->isMemberOf = $isMemberOf; 
    }//function
    
    
    /**
     * get isArchived
     * @return type boolean isArchived
     */
    protected function getIsArchived() {
        return $this->isArchived; 
    }//function
    
    
    /**
     * set isArchived
     * @param type $isArchived 
     */
    protected function setIsArchived($isArchived) {
        $this->isArchived = $isArchived; 
    }//function
    
    
    
    
    
}//class
?>
