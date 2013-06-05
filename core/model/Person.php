<?php



/**
 * Person.class.php
 * 
 * Author : Guillaume Lehmann
 * Date : 05.06.2013
 * 
 * Description : define the class Person as definited in the model
 * 
 */
class Person {
    
      
    /**
     * Person's id number
     * @var int
     */
   protected $no; 
   
   
   /**
    * Person's name 
    * @var string
    */
   protected $name; 
   
   
   /**
    * Person's first name
    * @var string
    */
   protected $firstName; 
   
   
   /**
    * Person's date of birth
    * @var date
    */
   protected $dateOfBirth; 
   
   
   /**
    * Person's address
    * @var string
    */
   protected $address; 
   
   
   /**
    * Person's city
    * @var string
    */
   protected $city; 
   
   
   /**
    * Person's country
    * @var country
    */
   protected $country; 
   
   
   /**
    * Person's phone number
    * @var int
    */
   protected $phoneNumber; 
   
   
   /**
    * Person's email
    * @var type string
    */
   protected $email; 
    
   
   
   /**
    * Constructs object Person
    * @param type $array of parameters that correspond to the classes properties
    */
    public function __construct($array = null) {
        
        if(!is_array($array)) {
           throw new Exception('No parameters');
            

        }//if      
        $this->no = $array['no'];
        $this->name = $array['name']; 
        $this->firstName = $array['firstName']; 
        $this->dateOfBirth = $array['dateOfBirth']; 
        $this->address = $array['address']; 
        $this->country = $array['country']; 
        $this->phoneNumber = $array['phoneNumber']; 
        $this->email = $array['email']; 
                
        
}//construct


/**
 * get numero
 * @return type numero
 */
public function getNo() {
   return $this->no; 
}


/**
 * get name
 * @return name
 */
public function getName() {
    return $this->name; 
}


/**
 * set no
 * @param type $name 
 */
public function setName($name) {
    $this->name = $name; 
}


/**
 * get first name
 * @return type firstName
 */
public function getFirstName() {
    return $this->firstName; 
}


/**
 * set first name
 * @param type $first name 
 */
public function setFirstName($firstName) {   
    $this->firstName = $firstName; 
}


/**
 * get date of birth
 * @return type dateOfBirth
 */
public function getDateOfBirth() {
    return $this->dateOfBirth; 
}


/**
 * set date of birth
 * @param type $dateOfBirth 
 */
public function setDateOfBirth($dateOfBirth) {  
    $this->dateOfBirth = $dateOfBirth; 
}


/**
 * get address
 * @return type address
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
 * get country
 * @return type country
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
 * get email
 * @return type email
 */
public function getEmail() {
    return $this->email; 
}


/**
 * set email
 * @param type $email 
 */
public function setEmail($email) {
    $this->email = email; 
}



}//class


?>
