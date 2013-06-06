<?php




/**
 * Role.class.php
 * 
 * Author : Guillaume Lehmann
 * Date : 05.06.2013
 * 
 * Description : define the class Registration as definited in the model
 * 
 */
class Role {
    
    
    /**
     * Role's name
     * @var type string
     */
    private $name; 
    
    
    /**
     * Role's numero
     * @var type int
     */
    private $eventNo; 
    
    
    /**
     * Role's organizerPersonNo
     * @var type int
     */
    private $organizerPersonNo; 
    
    
    /**
     * Role's level
     * @var type int; 
     */
    private $level; 
    
    
    /**
     * Role's isArchived
     * @var type boolean
     */
    private $isArchived; 
    
    
    
    /**
     * Constructs object Keyword
     * 
     * @param type $array of parameters that correspond to the classes properties
     */
    public function __construct($array = null){
        
        if(!is_array($array)) {
            throw new Exception('No parameters');
                       
        }//if
        $this->name = $array['name']; 
        $this->eventNo = $array['eventNo']; 
        $this->organizerPersonNo = $array['organizerPersonNo']; 
        $this->level = $array['level']; 
        $this->isArchived = $array['isArchived']; 
        
 
        
    }//construct
    
    
    
    /**
     * get name
     * @return type string name
     */
    public function getName() {
        return $this->name; 
    }//function
    
    
    /**
     * get eventNo
     * @return type int eventNo
     */
    public function getEventNo() {
        return $this->eventNo; 
    }//function
    
    
    /**
     * get organizerPersonNo
     * @return type int organizerPersonNo
     */
    public function getorganizerPersonNo() {
        return $this->organizerPersonNo; 
    }//function
    
    
    /**
     * get level
     * @return type int level
     */
    public function getLevel() {
        return $this->level; 
    }//function
  
    
    /**
     * set level
     * @param type $level 
     */
    public function setlevel($level) {
        $this->level = $level; 
    }//function
    
    
    /**
     * get isArchived
     * @return type boolean is Archived
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
