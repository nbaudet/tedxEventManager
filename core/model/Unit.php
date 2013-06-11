<?php


/**
 * Unit.class.php
 * 
 * Author : Guillaume Lehmann
 * Date : 05.06.2013
 * 
 * Description : define the class Unit as definited in the model
 * 
 */
class Unit {
    
    
    /**
     * Unit's numero
     * @var type int 
     */
    private $no; 
    
    
    /**
     * Unit's name
     * @var type string
     */
    private $name; 
    
    
    /**
     * Unit's isArchived
     * @var type boolean
     */
    private $isArchived; 
    
    
    /**
     * Constructs object Unit
     * 
     * @param type $array of parameters that correspond to the classes properties
     */
    protected function __construct($array = null){
        
        if(!is_array($array)) {
            throw new Exception('No parameters');
                       
        }//if
        $this->no = $array['no']; 
        $this->name = $array['name']; 
        $this->isArchived = $array['isArchived']; 

        
 
        
    }//construct
    
    
    
    /**
     * get no
     * @return type int no
     */
    protected function getNo() {
        return $this->no; 
    }//function
    
    
    /**
     * get name
     * @return type string name
     */
    protected function getName() {
        return $this->name; 
    }//function
    
    
    /**
     * set name
     * @param type $name 
     */
    protected function setName($name) {
        $this->name = $name; 
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
