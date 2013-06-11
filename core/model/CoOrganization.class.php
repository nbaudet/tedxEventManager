<?php



/**
 * CoOrganization.class.php
 * 
 * Author : Guillaume Lehmann
 * Date : 05.06.2013
 * 
 * Description : define the class CoOrganization as definited in the model
 * 
 */
class CoOrganization {
    
    
    /**
     * CoOrganization's no
     * @var type int
     */
    private $eventNo; 
    
    
    /**
     * CoOrganization's speakerPersonNo
     * @var type int 
     */
    private $speakerPersonNo; 
    
    
    /**
     * CoOrganization's isArchived 
     * @var type boolean
     */
    private $isArchived; 
    
    
    /**
     * Constructs object CoOrganization
     * 
     * @param type $array of parameters that correspond to the classes properties
     */
    protected function __construct($array = null){
        
        if(!is_array($array)) {
            throw new Exception('No parameters');
                       
        }//if
        $this->eventNo = $array['eventNo']; 
        $this->speakerPersonNo = $array['speakerPersonNo']; 
        $this->isArchived = $array['isArchived']; 

        
 
        
    }//construct
    
    
    
    
    
    /**
     * get eventNo
     * @return type int eventNo
     */
    protected function getEventNo() {
        return $this->eventNo; 
    }//function
    
    
    /**
     * get speakerPersonNo
     * @return type int speakerPersonNo
     */
    protected function getSpeakerPersonNo() {
        return $this->speakerPersonNo; 
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
