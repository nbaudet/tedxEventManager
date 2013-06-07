<?php


/**
 * Registration.class.php
 * 
 * Author : Guillaume Lehmann
 * Date : 05.06.2013
 * 
 * Description : define the class Registration as definited in the model
 * 
 */
class Registration {
    
    
    /**
     * Registration's status
     * @var type string 
     */
    private $status; 
    
    
    /**
     * Registration's eventNo
     * @var type int
     */
    private $eventNo; 
    
    
    /**
     * Participant's person no
     * @var type int
     */
    private $participantPersonNo; 
    
    
    /**
     * Participant's date
     * @var type date
     */
    private $registrationDate; 
    
    
    /**
     * Participant's type
     * @var type string
     */
    private $type; 
    
    
    /**
     * Participant's isArchived
     * @var type boolean
     */
    private $isArchived; 
    
    
    
    
    /**
     * Constructs object Registration
     * 
     * @param type $array of parameters that correspond to the classes properties
     */
    public function __construct($array = null){
        
        if(!is_array($array)) {
            throw new Exception('No parameters');
            
        }//if
        $this->status = $array['status']; 
        $this->eventNo = $array['eventNo']; 
        $this->participantPersonNo = $array['participantPersonNo']; 
        $this->registrationDate = $array['registrationDate']; 
        $this->type = $array['type']; 
        $this->isArchived = $array['isArchived']; 
        
        
        

    
        
    }//construct
    
    
    
    
    /**
     * get status
     * @return type status
     */
    public function getStatus() {
        return $this->status; 
    }//function
    
    
    /**
     * get eventNo
     * @return type int eventNo
     */
    public function getEventNo() {
        return $this->eventNo; 
    }//function
    
    
    /**
     * get participantPersonNo
     * @return type int participantPersonNo
     */
    public function getParticipantPersonNo() {
        return $this->participantPersonNo; 
    }//function
    
    
    /**
     * get registrationDate
     * @return type date registrationDate
     */
    public function getRegistrationDate() {
        return $this->registrationDate; 
    }//function
    
    
    /**
     * set registrationDate
     * @param type $registrationDate 
     */
    public function setRegistrationDate($registrationDate) {
        $this->registrationDate = $registrationDate; 
    }//function
    
    
    /**
     * get type
     * @return type string type
     */
    public function getType() {
        return $this->type; 
    }//function
    
    
    /**
     * set type
     * @param type $type 
     */
    public function setType($type) {
        $this->type = $type; 
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
