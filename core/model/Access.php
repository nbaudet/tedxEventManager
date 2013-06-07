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
    }//function
    
    
    /**
     * get service
     * @return type string service
     */
    public function getService() {
        return $this->service; 
    }//function
    
    
    /**
     * set service
     * @param type $service 
     */
    public function setService($service) {
        $this->service = $service; 
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
     * @param string $type 
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
