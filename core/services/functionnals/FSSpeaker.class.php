<?php

/**
 * Description of FSSpeaker
 *
 * @author Lauric Francelet
 */

require_once(APP_DIR . '/core/model/Speaker.class.php');
require_once(APP_DIR . '/core/model/Message.class.php');
require_once(APP_DIR . '/core/model/Person.class.php');

class FSSpeaker{
    /**
     *Returns a Speaker with the given No as Id
     *@param string $name the id of the Speaker
     *@return a Message with an existant Speaker
     */
    public static function getSpeaker($personNo){
        $speaker = NULL;
        global $crud;
        
        $sql = "SELECT Pe.No, Pe.Name, Pe.FirstName, Pe.DateOfBirth, Pe.Address,
Pe.City, Pe.Country, Pe.PhoneNumber, Pe.Email, Pe.Description, Sp.PersonNo ,Sp.IsArchived 
FROM Speaker AS Sp INNER JOIN Person AS Pe ON Sp.PersonNo = Pe.No WHERE Pe.No = $personNo";
        
        $data = $crud->getRow($sql);
        
        if($data){
            $argsSpeaker = array(
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
                'personNo'      => $data['PersonNo'],
                'isArchived'    => $data['IsArchived']
            );
        
            $speaker = new Speaker($argsSpeaker);

            $argsMessage = array(
                'messageNumber'     => 121,
                'message'           => 'Existant Speaker',
                'status'            => true,
                'content'           => $speaker
            );
            $return = new Message($argsMessage);

        }else{
            $argsMessage = array(
                'messageNumber'     => 122,
                'message'           => 'Inexistant Speaker',
                'status'            => false,
                'content'           => NULL    
            );
            $return = new Message($argsMessage);

        }
        return $return;
    }

    /**
     * Returns all the Speaers of the database
     * @return A Message containing an array of Speakers
     */
    public static function getSpeakers(){
        global $crud;

        $sql = "SELECT Pe.No, Pe.Name, Pe.FirstName, Pe.DateOfBirth, Pe.Address,
            Pe.City, Pe.Country, Pe.PhoneNumber, Pe.Email, Pe.Description, Sp.PersonNo , 
            Sp.IsArchived FROM Speaker AS Sp INNER JOIN Person AS Pe ON Sp.PersonNo = Pe.No WHERE IsArchived = 0;";
        $data = $crud->getRows($sql);
        
        if ($data){
            $speakers = array();

            foreach($data as $row){
                $argsSpeaker = array(
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
                    'personNo'      => $row['PersonNo'],
                    'isArchived'    => $row['IsArchived']
                );
            
                $speakers[] = new Speaker($argsSpeaker);
            } //foreach

            $argsMessage = array(
                'messageNumber' => 123,
                'message'       => 'All Speakers selected',
                'status'        => true,
                'content'       => $speakers
            );
            $return = new Message($argsMessage);

        } else {
            $argsMessage = array(
                'messageNumber' => 124,
                'message'       => 'Error while SELECT * FROM Speaker',
                'status'        => false,
                'content'       => NULL
            );
            $return = new Message($argsMessage);
        }
        
        return $return;
    }// End getSpeakers
    
    
    
       /**
     * Add a new Speaker in Database
     * @param $args Parameters of a Speaker
     * @return a Message containing the new Speaker
     */
    
    public static function addSpeaker($aPerson){
        global $crud;
        
        /*
         * Validate non-existing Person 
         */
        $aValidPerson = FSPerson::getPerson($aPerson->getNo());
        
        /*
         * Validate non-existant Speaker
         */
        $aValidParticipant = FSParticipant::getParticipant($aPerson->getNo());
        
        /*
         * If already existant Person and Inexistant Participant
         */ 
        if(($aValidPerson->getStatus())&&(!($aValidParticipant->getStatus()))){  
            $sql = "INSERT INTO Speaker (
                PersonNo) VALUES (
                    '".$aPerson->getNo()."'
            );";
        }else{
            $sql="";
        };
        
        if($crud->exec($sql) == 1){   
            $aCreatedSpeaker = FSSpeaker::getSpeaker($aPerson->getNo());
            
            $argsMessage = array(
                'messageNumber' => 131,
                'message'       => 'New Speaker added !',
                'status'        => true,
                'content'       => $aCreatedSpeaker
            );
            $message = new Message($argsMessage);
            return $message;
        } else {
            $argsMessage = array(
                'messageNumber' => 132,
                'message'       => 'Error while inserting new Speaker',
                'status'        => false,
                'content'       => NULL
            );
            $message = new Message($argsMessage);

            return $message;
        }   
    }
    
 }
    
?>
