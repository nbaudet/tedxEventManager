<?php



/**
 * Access.class.php
 * 
 * Author : Guillaume Lehmann
 * Date : 05.06.2013
 * 
 * Description : define the class Access as definited in the model
 * 
 */
class Access {
    
    
    
    /**
     * Accesses numero
     * @var type int
     */
    private $no; 
    
    
    /**
     * Accesses service
     * @var type string
     */
    private $service; 
    
    
    /**
     * Accesses type
     * @var type string
     */
    private $type;
    
    
    /**
     * Accesses isArchived
     * @var type boolean
     */
    private $isArchived; 
    
    
    
    /**
     * Constructs object Access
     * 
     * @param type $array of parameters that correspond to the classes properties
     */
    public function __construct($array = null){
        
        if(!is_array($array)) {
            throw new Exception('No parameters');
                       
        }//if
        $this->no = $array['no']; 
        $this->service = $array['service']; 
        $this->type = $array['type']; 
        $this->isArchived = $array['isArchived']; 

        
 
        
    }//construct
    
    
    
    /**
     * get numero
     * @return type int no
     */
    public function getNo() {
        return $this->no; 
    }
    
    
    /**
     * get service
     * @return type string service
     */
    public function getService() {
        return $this->service; 
    }
    
    
    /**
     * set service
     * @param type $service 
     */
    public function setService($service) {
        $this->service = $service; 
    }
    
    
    /**
     * get type
     * @return type string type
     */
    public function getType() {
        return $this->type; 
    }
    
    
    /**
     * set type
     * @param type $type 
     */
    public function setType($type) {
        $this->type = $type; 
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
