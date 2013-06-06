<?php



/**
 * Position.class.php
 * 
 * Author : Guillaume Lehmann
 * Date : 05.06.2013
 * 
 * Description : define the class Position as definited in the model
 * 
 */
class Position {
    
    
    /**
     * Position's numero
     * @var type int 
     */
    private $no; 
    
    
    /**
     * Position's slotNo
     * @var type int
     */
    private $slotNo; 
    
    
    /**
     * Position's slotEventNo
     * @var type int
     */
    private $slotEventNo; 
    
    
    /**
     * Position's speakerPersonNo
     * @var type int
     */
    private $speakerPersonNo; 
    
    
    /**
     * Position's isArchived
     * @var type boolean
     */
    private $isArchived; 
    
    
    
    /**
     * Constructs object Position
     * 
     * @param type $array of parameters that correspond to the classes properties
     */
    public function __construct($array = null){
        
        if(!is_array($array)) {
            throw new Exception('No parameters');
                       
        }//if
        $this->no = $array['no']; 
        $this->slotNo = $array['slotNo']; 
        $this->slotEventNo = $array['slotEventNo']; 
        $this->speakerPersonNo = $array['speakerPersonNo']; 
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
     * set isArchived
     * @param type $isArchived 
     */
    public function setIsArchived($isArchived) {
        $this->isArchived = $isArchived; 
    }//function
    
    
    
}
?>
