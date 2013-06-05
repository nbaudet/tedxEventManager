<?php


/**
 * Organizer.class.php
 * 
 * Author : Guillaume Lehmann
 * Date : 05.06.2013
 * 
 * Description : define the class Organizer as definited in the model
 * 
 */
class Organizer extends Person{
    
    
    /**
     * Organizer's person numero
     * @var type int
     */
    protected $personNo; 
    
    
    
    /**
     * Constructs object Organizer
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
    
    

}//class
?>
