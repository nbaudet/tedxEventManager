<?php


/**
 * Participation.class.php
 * 
 * Author : Guillaume Lehmann
 * Date : 05.06.2013
 * 
 * Description : define the class Participation as definited in the model
 * 
 */
class Participation {
    
    
    /**
     * Participation's slotNo
     * @var type int 
     */
    private $slotNo; 
    
    
    /**
     * Participation's slotEventNo
     * @var type int 
     */
    private $slotEventNo; 
    
    
    /**
     * Participation's participantPersonNo
     * @var type int 
     */
    private $participantPersonNo; 
    
    
    /**
     * Participation's isArchived
     * @var type boolean
     */
    private $isArchived; 
    
    
    
    /**
     * Constructs object Participation
     * 
     * @param type $array of parameters that correspond to the classes properties
     */
    public function __construct($array = null){
        
        if(!is_array($array)) {
            throw new Exception('No parameters');
            
        }//if
        $this->slotNo = $array['slotNo']; 
        $this->slotEventNo = $array['slotEventNo']; 
        $this->participantPersonNo = $array['participantPersonNo']; 
        $this->isArchived = $array['isArchived']; 
        

    

        
    }//construct
    
    
    
    
    
    /**
     * get slotNo
     * @return type int slotNo
     */
    public function getSlotNo() {
        return $this->slotNo; 
    }//function
    
    
    /**
     * get slotEventNo
     * @return type int slotEventNo
     */
    public function getSlotEventNo() {
        return $this->slotEventNo; 
    }//function
    
    
    /**
     * get participantPersonNo
     * @return type int participantPersonNo
     */
    public function getParticipantPersonNo() {
        return $this->participantPersonNo; 
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
