<?php




/**
 * Motivation.class.php
 * 
 * Author : Guillaume Lehmann
 * Date : 05.06.2013
 * 
 * Description : define the class Motivation as definited in the model
 * 
 */
class Motivation {
    
    
    
    /**
     * Motivation's text
     * @var type string
     */
    private $text; 
    
    
    /**
     * Motivation's eventNo
     * @var type int
     */
    private $eventNo;
    
    
    /**
     * Motivation's participantPersonneNo
     * @var type int
     */
    private $participantPersonNo; 
    
    
    /**
     * Motivation's isArchived 
     * @var type boolean
     */
    private $isArchived; 
    
    
    /**
     * Constructs object Motivation
     * 
     * @param type $array of parameters that correspond to the classes properties
     */
    protected function __construct($array = null){
        
        if(!is_array($array)) {
            throw new Exception('No parameters');
            
        }//if
        $this->text = $array['text']; 
        $this->eventNo = $array['eventNo']; 
        $this->participantPersonNo = $array['participantPersonNo']; 
        $this->isArchived = $array['isArchived']; 
        
        

    
        
    }//construct
    
    
    
    
    /**
     * get text
     * @return type string text
     */
    protected function getText() {
        return $this->text; 
    }//function
    
    
    /**
     * get EventNo
     * @return type int eventNo
     */
    protected function getEventNo() {
        return $this->eventNo; 
    }//function
   
    
    /**
     * get participantPersonNo
     * @param type $participantPersonNo 
     */
    protected function getParticipantPersonNo($participantPersonNo) {
        $this->participantPersonNo = $participantPersonNo; 
    }//function
    
    
    /**
     * get isArchived
     * @return type boolean is Archived
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
