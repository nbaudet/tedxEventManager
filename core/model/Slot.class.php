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
    public function __construct($array = null){
        
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
    public function getNo() {
        return $this->no; 
    }//function
    
    
    /**
     * get eventNo
     * @return type int eventNo
     */
    public function getEventNo() {
        return $this->eventNo; 
    }//function
    
    
    /**
     * get happeningDate
     * @return type date happeningDate
     */
    public function getHappeningDate() {
        return $this->happeningDate; 
    }//function
    
    
    /**
     * set happeningDate
     * @param type $happeningDate 
     */
    public function setHappeningDate($happeningDate) {
        $this->happeningDate = $happeningDate; 
    }//function
    
      
    /**
     * getStartingTime
     * @return type time startingTime
     */
    public function getStartingTime() {
        return $this->startingTime; 
    }//function
    
    
    /**
     * set startingTime 
     * @param type $startingTime 
     */
    public function setStartingTime($startingTime) {
        $this->startingTime = $startingTime; 
    }//function
    
    
    /**
     * get endingTime
     * @return type time endingTime
     */
    public function getEndingTime() {
        return $this->endingTime; 
    }//function
    
    
    /**
     * set endingTime
     * @param type $endingTime 
     */
    public function setEndingTime($endingTime) {
        $this->endingTime = $endingTime; 
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
