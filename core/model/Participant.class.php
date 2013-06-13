<?php
require_once('Person.class.php');

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
     * Constructs object Participant
     * 
     * @param type $array of parameters that correspond to the classes properties
     */
    public function __construct($array = null){
        
        if(!is_array($array)) {
            throw new Exception('No parameters');
            
        }//if
        
        parent::__construct($array);      
    }//construct
    

    /**
     * get person numero
     * @return type int personNo
     */
    public function getPersonNo() {
        return $this->personNo; 
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
