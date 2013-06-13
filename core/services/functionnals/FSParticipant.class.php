<?php

/**
 * Description of FSParticipant
 *
 * @author Robin Jet-Pierre
 */

require_once(APP_DIR . '/core/model/Participant.class.php');
require_once(APP_DIR . '/core/model/Message.class.php');

class FSParticipant{
    /**
     *Returns a Participantwith the given No as Id
     *@param string $name the id of the Participant
     *@return a Message with an existant Participant
     */
    public function getParticipant($personNo){
        $participant = NULL;
        
        global $crud;
        $personNo = addslashes($personNo);
        $sql = "SELECT Pe.No, Pe.Name, Pe.FirstName, Pe.DateOfBirth, Pe.Address, Pe.City, Pe.Country, Pe.PhoneNumber, Pe.Email, Pe.Description, Pa.IsArchived FROM Participant AS Pa INNER JOIN Person AS Pe ON Pa.PersonNo = Pe.No WHERE Pe.No = $personNo";
        $data = $crud->getRow($sql);
        
        if($data){
            $argsParticipant = array(
                'no'            => $data['No'],
                'name'          => $data['Name'],
                'firstname'     => $data['Firstname'],
                'dateOfBirth'   => $data['DateOfBirth'],
                'address'       => $data['Address'],
                'city'          => $data['City'],
                'country'       => $data['Country'],
                'phoneNumber'   => $data['PhoneNumber'],
                'email'         => $data['Email'],
                'description'   => $data['Description'],
                'isArchived'    => $data['IsArchived']
            );
        
            $participant = new Participant($argsParticipant);

            $argsMessage = array(
                'messageNumber'     => 207,
                'message'           => 'Existant Participant',
                'status'            => true,
                'content'           => $participant
            );
            $message = new Message($argsMessage);
            return $message;
        }else{
            $argsMessage = array(
                'messageNumber'     => 208,
                'message'           => 'Inexistant Participant',
                'status'            => false,
                'content'           => NULL    
            );
            $message = new Message($argsMessage);
            return $message;
        }
    }

    /**
     * Returns all the Participants of the database
     * @return A Message containing an array of Participants
     */
    public function getParticipants(){
        global $crud;

        $sql = "SELECT * FROM Participant";
        $data = $crud->getRows($sql);
        
        if ($data){
            $participants = array();

            
            foreach($data as $row){
                $argsParticipant = array(
                    'personNo'          => $data['PersonNo'],
                    'isArchived'    => $data['IsArchived']
                );
            
                $participants[] = new Participant($argsParticipant);
            } //foreach

            $argsMessage = array(
                'messageNumber' => 209,
                'message'       => 'All Participants selected',
                'status'        => true,
                'content'       => $participants
            );
            $message = new Message($argsMessage);

            return $message;
        } else {
            $argsMessage = array(
                'messageNumber' => 210,
                'message'       => 'Error while SELECT * FROM Participant',
                'status'        => false,
                'content'       => NULL
            );
            $message = new Message($argsMessage);

            return $message;
        }
    }
    
       /**
     * Add a new Participant in Database
     * @param $args Parameters of a Participant
     * @return a Message containing the new Participant
     */
    public function addParticipant($args){
        global $crud;
        
        /*0..1 Direction*/
        if($args['Direction']){
            $sql = "INSERT INTO Participant (
                Name, Address, City, Country, Direction) VALUES (
                    NULL, 
                    '".$args['Name']."', 
                    '".$args['Address']."', 
                    '".$args['City']."', 
                    '".$args['Country']."',
                    '".$args['Direction']."'
            );";
        }else{
            $sql = "INSERT INTO Participant (
                Name, Address, City, Country) VALUES (
                    NULL, 
                    '".$args['Name']."', 
                    '".$args['Address']."', 
                    '".$args['City']."', 
                    '".$args['Country']."'
            );";
        }
        
        if($crud->exec($sql)){       
            $argsMessage = array(
                'messageNumber' => 205,
                'message'       => 'New Participant added !',
                'status'        => true,
                'content'       => 1
            );
            $message = new Message($argsMessage);
            return $message;
        } else {
            $argsMessage = array(
                'messageNumber' => 206,
                'message'       => 'Error while inserting new Participant',
                'status'        => false,
                'content'       => NULL
            );
            $message = new Message($argsMessage);

            return $message;
        }   
    }
    
 }
    
?>
