<?php
require_once('Person.class.php');

/**
 * Participant.class.php
 * 
 * Author : Guillaume Lehmann
 * Date : 05.06.2013
 * 
 * Description : define the class Participant as definited in the model
 * 
 */
class Participant extends Person {
        
    /**
     * Constructs object Participant
     * 
     * @param type $array of parameters that correspond to the classes properties
     */
    public function __construct($array = null){
        
        if(!is_array($array)) {
            throw new Exception('No parameters');
            
        }//if
        
        parent::__construct($array);      
    }//construct
    

   /**
     * get numero
     * @return type numero
     */
    public function getNo() {
       return parent::getNo(); 
    }// function


    /**
     * get name
     * @return name
     */
    public function getName() {
        return parent::getName(); 
    }// function


    /**
     * set no
     * @param type $name 
     */
    public function setName($name) {
        parent::setName($name); 
    }// function


    /**
     * get first name
     * @return type firstName
     */
    public function getFirstName() {
         return parent::getFirstName(); 
    }// function


    /**
     * set first name
     * @param type $first name 
     */
    public function setFirstName($firstName) {   
        parent::setFirstName($firstName); 
    }// function


    /**
     * get date of birth
     * @return type dateOfBirth
     */
    public function getDateOfBirth() {
        return parent::getDateOfBirth(); 
    }// function


    /**
     * set date of birth
     * @param type $dateOfBirth 
     */
    public function setDateOfBirth($dateOfBirth) {  
        parent::setDateOfBirth($dateOfBirth); 
    }// function


    /**
     * get address
     * @return type address
     */
    public function getAddress() {
        return parent::getAddress(); 
    }// function


    /**
     * set address
     * @param type $address 
     */
    public function setAddress($address) {
        parent::setAddress($address); 
    }// function


    /**
     * get country
     * @return type country
     */
    public function getCountry() {
        return parent::getCountry(); 
    }// function


    /**
     * set country
     * @param type $country 
     */
    public function setCountry($country) {
        parent::setCountry($country); 
    }// function


    /**
     * get email
     * @return type email
     */
    public function getEmail() {
        return parent::getEmail(); 
    }// function


    /**
     * set email
     * @param type $email 
     */
    public function setEmail($email) {
        parent::setEmail($email); 
    }// function
    
    
    /**
     * get isArchived
     * @return type boolean isArchived
     */
    public function getIsArchived() {
        return parent::getIsArchived(); 
    }//function
    
    
    /**
     * set isArchived
     * @param type $isArchived 
     */
    public function setIsArchived($isArchived) {
        parent::setIsArchived($isArchived);   
    }//function
    
    

}//class
?>
