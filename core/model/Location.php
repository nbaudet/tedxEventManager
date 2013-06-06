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
        
 
        
    }//construct
    
    
    
    
    
    /**
     * get name
     * @return type string name
     */
    public function getName() {
        return $this->name; 
    }
    
    
    /**
     * get address
     * @return type string address
     */
    public function getAddress() {
        return $this->address; 
    }
    
    
    /**
     * set address
     * @param type $address 
     */
    public function setAddress($address) {
        $this->address = $address; 
    }
    
    
    /**
     * get city
     * @return type string city
     */
    public function getCity() {
        return $this->city; 
    }
    
    
    /**
     * set city
     * @param type $city 
     */
    public function setCity($city) {
        $this->city = $city; 
    }
    
    
    /**
     * get country
     * @return type string country
     */
    public function getCountry() {
        return $this->country; 
    }
    
    
    /**
     * set country
     * @param type $country 
     */
    public function setCountry($country) {
        $this->country = $country; 
    }
    
    
    /**
     * get direction
     * @return type string direction 
     */
    public function getDirection() {
        return $this->direction; 
    }
   
    
    /**
     * set direction
     * @param type $direction 
     */
    public function setDirection($direction) {
        $this->direction = $direction; 
    }
}
?>
