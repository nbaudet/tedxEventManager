<?php
/**
 * Person.class.php
 * 
 * Author : Guillaume Lehmann
 * Date : 05.06.2013
 * 
 * Description : define the class Person as described in the model
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
   protected $firstname; 
   
   
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
    * Person's description
    * @var type string
    */
   protected $description; 
   
   
   /**
    * Person's isArchived
    * @var type boolean
    */
   protected $isArchived; 
    
   
   
   /**
    * Constructs object Person
    * @param type $array of parameters that correspond to the classes properties
    */
    public function __construct($array = null) {
        
        if(!is_array($array)) {
           throw new Exception('No parameters');
        }//if      
        
        if(!isset($array['description']) || $array['description'] == ''){
            $description = NULL;
        } else {
            $description = $array['description'];
        }
        
        $this->no = $array['no'];
        $this->name = $array['name']; 
        $this->firstname = $array['firstname']; 
        $this->dateOfBirth = $array['dateOfBirth']; 
        $this->address = $array['address']; 
        $this->country = $array['country']; 
        $this->city = $array['city']; 
        $this->phoneNumber = $array['phoneNumber']; 
        $this->email = $array['email']; 
        $this->description = $description;
        $this->isArchived = $array['isArchived']; 
                
        
    }//construct


    /**
     * get numero
     * @return type numero
     */
    public function getNo() {
       return $this->no; 
    }// function


    /**
     * get name
     * @return name
     */
    public function getName() {
        return $this->name; 
    }// function


    /**
     * set no
     * @param type $name 
     */
    public function setName($name) {
        $this->name = $name; 
    }// function


    /**
     * get first name
     * @return type firstName
     */
    public function getFirstname() {
        return $this->firstname; 
    }// function


    /**
     * set first name
     * @param type $first name 
     */
    public function setFirstname($firstname) {   
        $this->firstname = $firstname; 
    }// function


    /**
     * get date of birth
     * @return type dateOfBirth
     */
    public function getDateOfBirth() {
        return $this->dateOfBirth; 
    }// function


    /**
     * set date of birth
     * @param type $dateOfBirth 
     */
    public function setDateOfBirth($dateOfBirth) {  
        $this->dateOfBirth = $dateOfBirth; 
    }// function


    /**
     * get address
     * @return type address
     */
    public function getAddress() {
        return $this->address; 
    }// function


    /**
     * set address
     * @param type $address 
     */
    public function setAddress($address) {
        $this->address = $address; 
    }// function

    /**
     * get city
     * @return String city
     */
    public function getCity() {
        return $this->city; 
    }// function


    /**
     * set country
     * @param type $country 
     */
    public function setCity($city) {
        $this->city = $city; 
    }// function
    
    /**
     * get country
     * @return type country
     */
    public function getCountry() {
        return $this->country; 
    }// function


    /**
     * set country
     * @param type $country 
     */
    public function setCountry($country) {
        $this->country = $country; 
    }// function


    /**
     * get email
     * @return type email
     */
    public function getEmail() {
        return $this->email; 
    }// function


    /**
     * set email
     * @param type $email 
     */
    public function setEmail($email) {
        $this->email = $email; 
    }// function
    
    /**
     * get phoneNumber
     * @return type phoneNumber
     */
    public function getPhoneNumber() {
        return $this->phoneNumber; 
    }// function

    /**
     * set phoneNumber
     * @param type $phoneNumber
     */
    public function setPhoneNumber($phoneNumber) {
        $this->phoneNumber = $phoneNumber; 
    }// function
    
    /**
     * get description
     * @return String description
     */
    public function getDescription() {
        return $this->description; 
    }// function

    /**
     * set description
     * @param type $description
     */
    public function setDescription($description) {
        $this->description = $description; 
    }// function
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
