<?php


/**
 * Location.class.php
 * 
 * Author : Guillaume Lehmann
 * Date : 05.06.2013
 * 
 * Description : define the class Location as definited in the model
 * 
 */
class Location {
    
    
    /**
     * Location's name
     * @var type string
     */
    private $name; 
    
    
    /**
     * Location's address
     * @var type string
     */
    private $address; 
    
    
    /**
     * Location's city
     * @var type string
     */
    private $city; 
    
    
    /**
     * Location's country
     * @var type string
     */
    private $country; 
    
    
    /**
     * Location's direction
     * @var type string
     */
    private $direction; 
    
    
    /**
     * Location's isArchived
     * @var type boolean
     */
    private $isArchived; 
    
    
    
    /**
     * Constructs object Location
     * 
     * @param type $array of parameters that correspond to the classes properties
     */
    public function __construct($array = null){
        
        if(!is_array($array)) {
            throw new Exception('No parameters');
                       
        }//if
        $this->name = $array['name']; 
        $this->address = $array['address']; 
        $this->city = $array['city']; 
        $this->country = $array['country']; 
        $this->direction = $array['direction'];
        $this->isArchived = $array['isArchived']; 
        
 
        
    }//construct
    
    
    
    
    
    /**
     * get name
     * @return type string name
     */
    public function getName() {
        return $this->name; 
    }//function
    
    
    /**
     * get address
     * @return type string address
     */
    public function getAddress() {
        return $this->address; 
    }//function
    
    
    /**
     * set address
     * @param type $address 
     */
    public function setAddress($address) {
        $this->address = $address; 
    }//function
    
    
    /**
     * get city
     * @return type string city
     */
    public function getCity() {
        return $this->city; 
    }//function
    
    
    /**
     * set city
     * @param type $city 
     */
    public function setCity($city) {
        $this->city = $city; 
    }//function
    
    /**
     * get city
     * @return type string city
     */
    public function getlocationName() {
        return $this->locationName; 
    }//function
    
    
    /**
     * set city
     * @param type $city 
     */
    public function setLocationName($locationName) {
        $this->locationName = $locationName; 
    }//function
    
    
    /**
     * get country
     * @return type string country
     */
    public function getCountry() {
        return $this->country; 
    }//function
    
    
    /**
     * set country
     * @param type $country 
     */
    public function setCountry($country) {
        $this->country = $country; 
    }//function
    
    
    /**
     * get direction
     * @return type string direction 
     */
    public function getDirection() {
        return $this->direction; 
    }//function
   
    
    /**
     * set direction
     * @param type $direction 
     */
    public function setDirection($direction) {
        $this->direction = $direction; 
    }//function
    
    
    /**
     * get isArchived
     * @return type boolean isArchived
     */
    public function getIsArchived() {
        return $this->isArchived; 
    }
    
    
    /**
     * set IsArchived
     * @param type $isArchived 
     */
    public function setIsArchived($isArchived) {
        $this->isArchived = $isArchived; 
    }
    
    
    
    
}//class
?>
