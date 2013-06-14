<?php

/**
 * Description of FSOrganizer
 *
 * @author Lauric Francelet
 */

require_once(APP_DIR . '/core/model/Organizer.class.php');
require_once(APP_DIR . '/core/model/Message.class.php');
require_once(APP_DIR . '/core/model/Person.class.php');

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
Pe.City, Pe.Country, Pe.PhoneNumber, Pe.Email, Pe.Description, Or.IsArchived FROM
Organizer AS Or INNER JOIN Person AS Pe ON Or.PersonNo = Pe.No WHERE Pe.No = $personNo";
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
    }

    /**
     * Returns all the Organizers of the database
     * @return A Message containing an array of Organizers
     */
    public static function getOrganizers(){
        global $crud;

        $sql = "SELECT Pe.No, Pe.Name, Pe.FirstName, Pe.DateOfBirth, Pe.Address,
            Pe.City, Pe.Country, Pe.PhoneNumber, Pe.Email, Pe.Description, Or.IsArchived
            FROM Organizer AS Or INNER JOIN Person AS Pe ON Or.PersonNo = Pe.No";
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
    }
    
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
    }
    
 }
    
?>
