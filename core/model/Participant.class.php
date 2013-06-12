<?php


/**
 * Participant.class.php
 * 
 * Author : Guillaume Lehmann
 * Date : 05.06.2013
 * 
 * Description : define the class Participant as definited in the model
 * 
 */
class Participant extends Person {
    
    
    /**
     * Participant's person numero
     * @var type int
     */
    protected $personNo; 
    
    
    /**
     * Participant's isArchived
     * @var type boolean
     */
    protected $isArchived; 
    
    
    
    /**
     * Constructs object Participant
     * 
     * @param type $array of parameters that correspond to the classes properties
     */
    protected function __construct($array = null){
        
        if(!is_array($array)) {
            throw new Exception('No parameters');
            
        }//if
        parent::__construct($array);
        
        $this->personNo = $array['personNo']; 
        $this->isArchived = $array['isArchived']; 
        
        
        
    }//construct
    

    /**
     * get person numero
     * @return type int personNo
     */
    protected function getPersonNo() {
        return $this->personNo; 
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