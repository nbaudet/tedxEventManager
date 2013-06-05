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
     * Constructs object Participant
     * 
     * @param type $array of parameters that correspond to the classes properties
     */
    public function __construct($array = null){
        
        if(!is_array($array)) {
            throw new Exception('No parameters');
            
        }//if
        parent::__construct($array);
        
        $this->personNo = $array['personNo']; 
        
        
        
    }//construct
    
    
    
    
    
    
    /**
     * get person numero
     * @return type personNo
     */
    public function getPersonNo() {
        return $this->personNo; 
    }
    
    
    /**
     * set person numero
     * @param type $personNo 
     */
    public function setPersonNo($personNo) {
        $this->personNo = $personNo; 
    }
}//class
?>
