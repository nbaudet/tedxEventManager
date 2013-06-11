<?php


/**
 * Slot.class.php
 * 
 * Author : Guillaume Lehmann
 * Date : 05.06.2013
 * 
 * Description : define the class Slot as definited in the model
 * 
 */
class Slot {
    
    
    /**
     * Slot's numero
     * @var type int
     */
    private $no; 
    
    
    /**
     * Slot's event numero
     * @var type int
     */
    private $eventNo; 
    
    
    /**
     * Slot's happing date 
     * @var type date
     */
    private $happeningDate; 
    
    
    /**
     * Slot's Starting time
     * @var type time
     */
    private $startingTime; 
    
    
    /**
     * Slot's ending time
     * @var type time
     */
    private $endingTime; 
    
    
    /**
     * Slot's is archived 
     * @var type boolean
     */
    private $isArchived; 
    
    
    
    /**
     * Constructs object Slot
     * 
     * @param type $array of parameters that correspond to the classes properties
     */
    protected function __construct($array = null){
        
        if(!is_array($array)) {
            throw new Exception('No parameters');
            
        }//if
        $this->no = $array['no']; 
        $this->eventNo = $array['eventNo']; 
        $this->happeningDate = $array['happeningDate']; 
        $this->startingTime = $array['startingTime']; 
        $this->endingTime = $array['endingTime']; 
        $this->isArchived = $array['isArchived']; 
        
       
        
        
        
    }//construct
    
    
    
    /**
     * get numero
     * @return type int no
     */
    protected function getNo() {
        return $this->no; 
    }//function
    
    
    /**
     * get eventNo
     * @return type int eventNo
     */
    protected function getEventNo() {
        return $this->eventNo; 
    }//function
    
    
    /**
     * get happeningDate
     * @return type date happeningDate
     */
    protected function getHappeningDate() {
        return $this->happeningDate; 
    }//function
    
    
    /**
     * set happeningDate
     * @param type $happeningDate 
     */
    protected function setHappeingDate($happeningDate) {
        return $this->happeningDate; 
    }//function
    
      
    /**
     * getStartingTime
     * @return type time startingTime
     */
    protected function getStartingTime() {
        return $this->startingTime; 
    }//function
    
    
    /**
     * set startingTime 
     * @param type $startingTime 
     */
    protected function setStartingTime($startingTime) {
        $this->startingTime = $startingTime; 
    }//function
    
    
    /**
     * get endingTime
     * @return type time endingTime
     */
    protected function getEndingTime() {
        return $this->endingTime; 
    }//function
    
    
    /**
     * set endingTime
     * @param type $endingTime 
     */
    protected function setEndingTime($endingTime) {
        $this->endingTime = $endingTime; 
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
