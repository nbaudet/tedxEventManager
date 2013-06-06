<?php


/**
 * Permission.class.php
 * 
 * Author : Guillaume Lehmann
 * Date : 05.06.2013
 * 
 * Description : define the class Permission as definited in the model
 * 
 */
class Permission {
    
    /**
     * Permission's accessNo
     * @var type int
     */
    private $accessNo; 
    
    /**
     * Permission's unitNo
     * @var type int
     */
    private $unitNo; 
    
    
    /** 
     * Permission's isArchived
     * @var type boolean
     */
    private $isArchived; 
    
    
    
    /**
     * Constructs object Permission
     * 
     * @param type $array of parameters that correspond to the classes properties
     */
    public function __construct($array = null){
        
        if(!is_array($array)) {
            throw new Exception('No parameters');
                       
        }//if
        $this->accessNo = $array['accessNo']; 
        $this->unitNo = $array['unitNo']; 
        $this->isArchived = $array['isArchived']; 

        
 
        
    }//construct
    
    
    
    /**
     * get accessNo
     * @return type int accessNo
     */
    public function getAccessNo() {
        return $this->accessNo; 
    }
    
    
    /**
     * get unitNo
     * @return type int unitNo
     */
    public function getUnitNo() {
        return $this->unitNo; 
    }
    
    
    /**
     * get isArchived
     * @return type boolean isArchived
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
