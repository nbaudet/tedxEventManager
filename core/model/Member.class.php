<?php




/**
 * Member.class.php
 * 
 * Author : Guillaume Lehmann
 * Date : 05.06.2013
 * 
 * Description : define the class Member as definited in the model
 * 
 */
class Member {
    
    
    
    /**
     * Member's id
     * @var type string
     */
    private $id;
    
    
    /**
     * Member's password
     * @var type string password
     */
    private $password; 
    
    
    /**
     * Member's personNo
     * @var type int personNo
     */
    private $personNo; 
    
    
    /**
     * Member's isArchived
     * @var type boolean isArchived
     */
    private $isArchived; 
    
    
    
    /**
     * Constructs object Member
     * 
     * @param type $array of parameters that correspond to the classes properties
     */
    protected function __construct($array = null){
        
        if(!is_array($array)) {
            throw new Exception('No parameters');
                       
        }//if
        $this->id = $array['id']; 
        $this->password = $array['password']; 
        $this->personNo = $array['personNo']; 
        $this->isArchived = $array['isArchived']; 

        
 
        
    }//construct
    
    
    /**
     * get id
     * @return type string id
     */
    protected function getId() {
        return $this->id; 
    }//function
    
    
    /**
     * get password
     * @return type string password
     */
    protected function getPassword() {
        return $this->password; 
    }//function
    
    
    /**
     * set password
     * @param type $password 
     */
    protected function setPassword($password) {
        $this->password = $password; 
    }//function
    
    
    /**
     * get PersonNo
     * @return type int personNo
     */
    protected function getPersonNo() {
        return $this->personNo; 
    }//function
    
    
    /**
     * set personNo
     * @param type $personNo 
     */
    protected function setPersonNo($personNo) {
        $this->personNo = $personNo; 
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
