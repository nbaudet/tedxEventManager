<?php

require_once(APP_DIR . '/core/model/Organizer.class.php');
require_once(APP_DIR . '/core/model/Message.class.php');
require_once(APP_DIR . '/core/model/Person.class.php');


/**
 * FSOrganizer.class.php
 * 
 * Author : Lauric Francelet
 * Date : 25.06.2013
 * 
 * Description : define the class FSOrganizer as definited in the model
 * 
 */
class FSOrganizer{
    /**
     *Returns an Organizer twith the given No as Id
     *@param string $personNo the id of the Organizer
     *@return a Message with an existant Organizer
     */
    public static function getOrganizer($personNo){
        $organizer = NULL;

        global $crud;

        $sql = "SELECT Pe.No, Pe.Name, Pe.FirstName, Pe.DateOfBirth, Pe.Address,
Pe.City, Pe.Country, Pe.PhoneNumber, Pe.Email, Pe.Description, Org.PersonNo, Org.IsArchived 
FROM Organizer AS Org INNER JOIN Person AS Pe ON Org.PersonNo = Pe.No WHERE Pe.No = $personNo AND Org.IsArchived = 0";    


        $data = $crud->getRow($sql);

        if($data){
            $argsOrganizer = array(
                'no'            => $data['No'],
                'name'          => $data['Name'],
                'firstname'     => $data['FirstName'],
                'dateOfBirth'   => $data['DateOfBirth'],
                'address'       => $data['Address'],
                'city'          => $data['City'],
                'country'       => $data['Country'],
                'phoneNumber'   => $data['PhoneNumber'],
                'email'         => $data['Email'],
                'description'   => $data['Description'],
                'isArchived'    => $data['IsArchived']
            );

            $organizer = new Organizer($argsOrganizer);

            $argsMessage = array(
                'messageNumber'     => 125,
                'message'           => 'Existant Organizer',
                'status'            => true,
                'content'           => $organizer
            );
            $return = new Message($argsMessage);

        }else{
            $argsMessage = array(
                'messageNumber'     => 126,
                'message'           => 'Inexistant Organizer',
                'status'            => false,
                'content'           => NULL    
            );
            $return = new Message($argsMessage);
        }
        return $return;
    }//function

    
    /**
     * Returns all the Organizers of the database
     * @return A Message containing an array of Organizers
     */
    public static function getOrganizers(){
        global $crud;

        $sql = "SELECT Pe.No, Pe.Name, Pe.FirstName, Pe.DateOfBirth, Pe.Address,
            Pe.City, Pe.Country, Pe.PhoneNumber, Pe.Email, Pe.Description, Org.IsArchived
            FROM Organizer AS Org INNER JOIN Person AS Pe ON Org.PersonNo = Pe.No WHERE Org.IsArchived = 0;";
        $data = $crud->getRows($sql);
        
        if ($data){
            $organizers = array();

            foreach($data as $row){
                $argsOrganizer = array(
                    'no'            => $row['No'],
                    'name'          => $row['Name'],
                    'firstname'     => $row['FirstName'],
                    'dateOfBirth'   => $row['DateOfBirth'],
                    'address'       => $row['Address'],
                    'city'          => $row['City'],
                    'country'       => $row['Country'],
                    'phoneNumber'   => $row['PhoneNumber'],
                    'email'         => $row['Email'],
                    'description'   => $row['Description'],
                    'isArchived'    => $row['IsArchived']
                );
            
                $organizers[] = new Organizer($argsOrganizer);
            } //foreach

            $argsMessage = array(
                'messageNumber' => 127,
                'message'       => 'All Organizers selected',
                'status'        => true,
                'content'       => $organizers
            );
            $return = new Message($argsMessage);

        } else {
            $argsMessage = array(
                'messageNumber' => 128,
                'message'       => 'Error while SELECT * FROM Organizer',
                'status'        => false,
                'content'       => NULL
            );
            $return = new Message($argsMessage);
        }
        return $return;
    }//function
    
    
    /**
     * Add a new Organizer in Database
     * @param $args Parameters of a Organizer
     * @return a Message containing the new Organizer
     */
    public static function addOrganizer($aPerson){
        global $crud;
        
        /*
         * Validate Person No Existant
         */
        $aValidPerson = FSPerson::getPerson($aPerson->getNo());
        
        /*
         * Validate Organizer PersonNo Inexistant
         */
        $aValidOrganizer = FSOrganizer::getOrganizer($aPerson->getNo());
        
        /*
         * If already existant Person and Inexistant Organizer
         */
        if(($aValidPerson->getStatus())&&(!($aValidOrganizer->getStatus()))){  
            $sql = "INSERT INTO Organizer (
                PersonNo) VALUES (
                    '".$aPerson->getNo()."'
            );";
        }else{
            $sql="";
        };
        
        if($crud->exec($sql) == 1){   
            $aCreatedOrganizer = FSOrganizer::getOrganizer($aPerson->getNo())->getContent();
            
            $argsMessage = array(
                'messageNumber' => 129,
                'message'       => 'New Organizer added !',
                'status'        => true,
                'content'       => $aCreatedOrganizer
            );
            
            $return = new Message($argsMessage);
        } else {
            $argsMessage = array(
                'messageNumber' => 130,
                'message'       => 'Error while inserting new Organizer',
                'status'        => false,
                'content'       => NULL
            );
            $return = new Message($argsMessage);
        }   
        return $return;
    }//function
    
    
    /**
     * Sets a Person as Organizer (if not already Organizer)
     * @param Person $person
     * @return a Message containing the created Organizer
     */
    public static function setPersonAsOrganizer($person){
        global $crud;
        
        // Validate Person
        $messageValidatePerson = FSPerson::getPerson($person->getNo());
        // Validate non existing Organizer
        $messageValidateOrganizer = FSOrganizer::getOrganizer($person->getNo());
        
        // If validPerson
        if($messageValidatePerson->getStatus()){
            // If non existing Organizer
            if(!$messageValidateOrganizer->getStatus()){
                $sql = "INSERT INTO Organizer (
                    PersonNo) VALUES (
                        '".$person->getNo()."'
                );";
                
                if($crud->exec($sql) == 1){   
                    $aCreatedOrganizer = FSOrganizer::getOrganizer($person->getNo())->getContent();

                    $argsMessage = array(
                        'messageNumber' => 129,
                        'message'       => 'New Organizer added !',
                        'status'        => true,
                        'content'       => $aCreatedOrganizer
                    );

                    $return = new Message($argsMessage);
                } else {
                    $argsMessage = array(
                        'messageNumber' => 130,
                        'message'       => 'Error while inserting new Organizer',
                        'status'        => false,
                        'content'       => NULL
                    );
                    $return = new Message($argsMessage);
                }   
                
            } else {
                $return = $messageValidateOrganizer;
            }
        } else {
            $return = $messageValidatePerson;
        }
        return $return;
    }//function
    
 }//class
    
?>
