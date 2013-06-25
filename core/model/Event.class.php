<?php


/**
 * Event.class.php
 * 
 * Author : Guillaume Lehmann
 * Date : 05.06.2013
 * 
 * Description : define the class Event as definited in the model
 * 
 */
class Event {
    
     
    /**
     * Event's numero
     * @var type int
     */
    private $no; 
    
    
    /**
     * Event's mainTopic
     * @var type string
     */
    private $mainTopic; 
    
    /**
     * Event's description
     * @var type String
     */
    private $description; 
    
    /**
     * Event's starting date
     * @var type date
     */
    private $startingDate; 
    
    
    /**
     * Event's ending date
     * @var type date
     */
    private $endingDate; 
    
    
    /**
     * Event's starting time
     * @var type time
     */
    private $startingTime; 
    
    
    /**
     * Event's ending time
     * @var type time
     */
    private $endingTime; 
    
    
    /**
     * Event's location Reference
     * @var type String
     */
    private $locationName; 
    
    /**
     * Event's isArchived 
     * @var type boolean
     */
    private $isArchived; 
    
    

   
    
    /**
     * Constructs object Event
     * 
     * @param type $array of parameters that correspond to the classes properties
     */
    public function __construct($array = null){
        
        if(!is_array($array)) {
            throw new Exception('No parameters');
        }//if
        $this->no = $array['no']; 
        $this->mainTopic = $array['mainTopic']; 
        $this->description = $array['description']; 
        $this->startingDate = $array['startingDate']; 
        $this->endingDate = $array['endingDate'];
        $this->startingTime = $array['startingTime']; 
        $this->endingTime = $array['endingTime']; 
        
        // optionnel location name
        if(isset($array['locationName']))
             $this->locationName = $array['locationName']; 
        else
             $this->locationName = ''; 
        
        $this->isArchived = $array['isArchived']; 

    

        
    }//construct
    
    
    
       
    
    /**
     * get numero
     * @return type int numero
     */
    public function getNo() {
        return $this->no; 
    }//function
    
    
    /**
     * get mainTopic
     * @return type string mainTopic
     */
    public function getMainTopic() {
        return $this->mainTopic; 
    }//function
    
    /**
     * get description
     * @return type string mainTopic
     */
    public function getDescription() {
        return $this->description; 
    }//function
    
    /**
     * set mainTopic 
     * @param type $mainTopic 
     */
    public function setMainTopic($mainTopic) {
        $this->mainTopic = $mainTopic; 
    }//function
    
    /**
     * set mainTopic 
     * @param type $mainTopic 
     */
    public function setDescription($description) {
        $this->description = $description; 
    }//function
    
    
    /**
     * get startingDate
     * @return type date startingDate
     */
    public function getStartingDate() {
        return $this->startingDate; 
    }//function
    
    
    /**
     * set startingDate
     * @param type $startingDate 
     */
    public function setStartingDate($startingDate) {
        $this->startingDate = $startingDate; 
    }//function
    
    
    /**
     * get endingDate
     * @return type date endingDate
     */
    public function getEndingDate() {
        return $this->endingDate; 
    }//function
    
    
    /**
     * set endingDate
     * @param type $endingDate 
     */
    public function setEndingDate($endingDate) {
        $this->endingDate = $endingDate; 
    }//function
    
    
    /**
     * get startingTime
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
     * get EndingTime
     * @return type endingTime
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
     * get locationName
     * @return type $locationName
     */
    public function getLocationName() {
        return $this->locationName;
    }// function
    
    /**
     * set locationName
     * @param type $newLocationName
     */
    public function setLocationName($newLocationName){
        $this->locationName = $newLocationName;
    }// function
    
    
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
