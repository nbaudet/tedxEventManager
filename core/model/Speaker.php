<?php



/**
 * Speaker.class.php
 * 
 * Author : Guillaume Lehmann
 * Date : 05.06.2013
 * 
 * Description : define the class Speaker as definited in the model
 * 
 */
class Speaker extends Person {
    
    
    /**
     * Speaker's person numero
     * @var type int
     */
    protected $personNo; 
    
    
    
    /**
     * Constructs object Speaker
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
