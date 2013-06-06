<?php



/**
 * MemberShip.class.php
 * 
 * Author : Guillaume Lehmann
 * Date : 05.06.2013
 * 
 * Description : define the class MemberShip as definited in the model
 * 
 */
class MemberShip {
    
    
    /**
     * MemberShip's memberId
     * @var type int
     */
    private $memberId; 
    
    
    /**
     * MemberShip unitNo
     * @var type int 
     */
    private $unitNo; 
    
    
    /**
     * MemberShip's isArchived
     * @var type boolean
     */
    private $isArchived; 
    
    
    
    
    /**
     * Constructs object MemberShip
     * 
     * @param type $array of parameters that correspond to the classes properties
     */
    public function __construct($array = null){
        
        if(!is_array($array)) {
            throw new Exception('No parameters');
                       
        }//if
        $this->memberId = $array['memberId']; 
        $this->unitNo = $array['unitNo']; 
        $this->isArchived = $array['isArchived']; 

        
 
        
    }//construct
    
    
    /**
     * get memberId
     * @return type int memberId
     */
    public function getMemberId() {
        return $this->memberId; 
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
