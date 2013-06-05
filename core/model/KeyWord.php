<?php



/**
 * Keyword.class.php
 * 
 * Author : Guillaume Lehmann
 * Date : 05.06.2013
 * 
 * Description : define the class Registration as definited in the model
 * 
 */
class Keyword {
    
    
    
    /**
     * Keyword's value
     * @var type int
     */
    private $value; 
    
    
    /**
     * Keyword's eventNo
     * @var type int
     */
    private $eventNo; 
    
    
    /**
     * Keyword's participantPersonNo
     * @var type int participantPersonNo
     */
    private $participantPersonNo; 
    
    
    /**
     * Keyword's isArchived
     * @var type boolean
     */
    private $isArtichved; 
    
    
    
    
    /**
     * Constructs object Keyword
     * 
     * @param type $array of parameters that correspond to the classes properties
     */
    public function __construct($array = null){
        
        if(!is_array($array)) {
            throw new Exception('No parameters');
            
        }//if
        $this->value = $array['value']; 
        $this->evenNo = $array['eventNo']; 
        $this->participantPersonNo = $array['participantPersonNo']; 
        $this->isArchived = $array['isArchived']; 
        
 
        
    }//construct
    
    
    
    
    /**
     * get value
     * @return type value
     */
    public function getValue() {
        return $this->value; 
    }
    
    
    /**
     * get eventNo
     * @return type int eventNo
     */
    public function getEventNo() {
        return $this->eventNo; 
    }
    
    
    /**
     * get participantPersonNo
     * @return type int participantPersonNo
     */
    public function getParticipantPersonNo() {
        return $this->participantPersonNo; 
    }
    
    
    /**
     * get isArchived
     * @return type boolean is Archived
     */
    public function getIsArchived() {
        return $this->isArchived; 
    }
    
    
    /**
     * set isArchived
     * @param type $isArchived 
     */
    public function setIsArchived($isArchived) {
        $this->isArchived = $isArchived; 
    }
    
    
    
    
}//class
?>
