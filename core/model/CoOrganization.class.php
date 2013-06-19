<?php



/**
 * Talk.class.php
 * 
 * Author : Guillaume Lehmann
 * Date : 05.06.2013
 * 
 * Description : define the class Talk as definited in the model
 * 
 */
class Talk {
    
    
    /**
     * Talk's no
     * @var type int
     */
    private $eventNo; 
    
    
    /**
     * Talk's speakerPersonNo
     * @var type int 
     */
    private $speakerPersonNo;
    
    /**
     * Talk's videoTalk
     * @var type int 
     */
    private $videoTitle;
    
    /**
     * Talk's videoDescription
     * @var type int 
     */
    private $videoDescription;
    
    /**
     * Talk's videoURL
     * @var type int 
     */
    private $videoURL;    
    
    /**
     * Talk's isArchived 
     * @var type boolean
     */
    private $isArchived; 
    
    
    /**
     * Constructs object Talk
     * 
     * @param type $array of parameters that correspond to the classes properties
     */
    public function __construct($array = null){
        
        if(!is_array($array)) {
            throw new Exception('No parameters');
                       
        }//if
        $this->eventNo = $array['eventNo']; 
        $this->speakerPersonNo = $array['speakerPersonNo']; 
        $this->videoTitle = $array['videoTitle']; 
        $this->videoDescription = $array['videoDescription']; 
        $this->videoURL = $array['videoURL']; 
        $this->isArchived = $array['isArchived']; 
        
    }//construct
    
    
    
    /**
     * get eventNo
     * @return type int eventNo
     */
    public function getEventNo() {
        return $this->eventNo; 
    }//function
    
    
    /**
     * get speakerPersonNo
     * @return type int speakerPersonNo
     */
    public function getSpeakerPersonNo() {
        return $this->speakerPersonNo; 
    }//function
    
    
    /**
     * get isArchived
     * @return type boolean is Archived
     */
    public function getIsArchived() {
        return $this->isArchived; 
    }//function
    
    /**
     * get videoTitle
     * @return String videoTitle
     */
    public function getVideoTitle() {
        return $this->videoTitle; 
    }//function
    
    /**
     * get videoDescription
     * @return string videoDescription
     */
    public function getVideoDescription() {
        return $this->videoDescription; 
    }//function
    
    /**
     * get videoURL
     * @return string videoURL
     */
    public function getVideoURL() {
        return $this->videoURL; 
    }//function
    
    /**
     * set isArchived
     * @param type $isArchived 
     */
    public function setIsArchived($isArchived) {
        $this->isArchived = $isArchived; 
    }//function
    
    /**
     * set videoTitle
     * @param string $videoTitle
     */
    public function setVideoTitle($videoTitle) {
        $this->videoTitle = $videoTitle; 
    }//function    
    
    /**
     * set videoDesritpion
     * @param string $videoDescription
     */
    public function setVideoDescription($videoDescription) {
        $this->videoDescription = $videoDescription; 
    }//function   
    
    /**
     * set videoURL
     * @param string $videoURL
     */
    public function setVideoURL($videoURL) {
        $this->videoURL = $videoURL; 
    }//function   
    
}//class
?>
