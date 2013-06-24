<?php

/**
 * Description of FSParticipant
 *
 * @author Robin Jet-Pierre
 */

require_once(APP_DIR . '/core/model/Participant.class.php');
require_once(APP_DIR . '/core/model/Message.class.php');
require_once(APP_DIR . '/core/model/Person.class.php');
require_once(APP_DIR . '/core/model/Registration.class.php');
require_once(APP_DIR . '/core/model/Participation.class.php');
require_once('../core/services/functionnals/FSEvent.class.php');
require_once('../core/services/functionnals/FSSlot.class.php');
require_once('../core/services/functionnals/FSRegistration.class.php');
require_once('../core/services/functionnals/FSParticipation.class.php');


class FSParticipant{
   
    
    /**
     *Returns a Participant with the given No as Id
     *@param string $personNo the id of the Participant
     *@return a Message with an existant Participant
     */
    public static function getParticipant($personNo){
        $participant = NULL;
        
        global $crud;

        $sql = "SELECT Pe.No, Pe.Name, Pe.FirstName, Pe.DateOfBirth, Pe.Address, 
            Pe.City, Pe.Country, Pe.PhoneNumber, Pe.Email, Pe.Description, 
            Pa.IsArchived FROM Participant AS Pa INNER JOIN Person AS Pe ON 
            Pa.PersonNo = Pe.No WHERE Pe.No = $personNo AND Pe.IsArchived = 0";
        $data = $crud->getRow($sql);
        
        if($data){
            $argsParticipant = array(
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
        
            $participant = new Participant($argsParticipant);

            $argsMessage = array(
                'messageNumber'     => 207,
                'message'           => 'Existant Participant',
                'status'            => true,
                'content'           => $participant
            );
            $return = new Message($argsMessage);
        }else{
            $argsMessage = array(
                'messageNumber'     => 208,
                'message'           => 'Inexistant Participant',
                'status'            => false,
                'content'           => NULL    
            );
            $return = new Message($argsMessage);
        }
        return $return;
    }

    /**
     * Returns all the Participants of the database
     * @return A Message containing an array of Participants
     */
    public static function getParticipants(){
        global $crud;

        $sql = "SELECT Pe.No, Pe.Name, Pe.FirstName, Pe.DateOfBirth, Pe.Address, 
            Pe.City, Pe.Country, Pe.PhoneNumber, Pe.Email, Pe.Description, 
            Pa.IsArchived FROM Participant AS Pa INNER JOIN Person AS Pe ON 
            Pa.PersonNo = Pe.No WHERE Pe.IsArchived = 0;";
        $data = $crud->getRows($sql);
        
        if ($data){
            $participants = array();

            
            foreach($data as $row){
                $argsParticipant = array(
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
            
                $participants[] = new Participant($argsParticipant);
            } //foreach

            $argsMessage = array(
                'messageNumber' => 209,
                'message'       => 'All Participants selected',
                'status'        => true,
                'content'       => $participants
            );
            $return = new Message($argsMessage);
        } else {
            $argsMessage = array(
                'messageNumber' => 210,
                'message'       => 'Error while SELECT * FROM Participant',
                'status'        => false,
                'content'       => NULL
            );
            $return = new Message($argsMessage);
        }
        return $return;
    }
    
       /**
     * Add a new Participant in Database
     * @param $args Parameters of a Participant
     * @return a Message containing the new Participant
     */
    public static function addParticipant($args){
        /* --------------------------------------------------------------------    
            $args = array(
                'person' => $aPerson,
                'event'  => $anEvent,
                'slots'  => $aListOfSlots,
                'registrationType'           => 'business',
                'registrationTypeDescription' => 'The business description',
            );
        ----------------------------------------------------------------------- */
        // Validate Existant Person
        $messageValidPerson = FSPerson::getPerson($args['person']->getNo());
        if($messageValidPerson->getStatus()){
            // Generate the Person aValidPerson
            $aValidPerson = $messageValidPerson->getContent();
            // Validate Existant Event
            $messageValidEvent = FSEvent::getEvent($args['event']->getNo());
            if($messageValidEvent->getStatus()){
                // Generate the Event aValidEvent
                $aValidEvent = $messageValidEvent->getContent();
                // For each slot, validate the slot existence.
                $i = 0;
                $flagValidSlots = true;
                foreach($args['slots'] as $slot){
                    $argsSlot = array('no' =>$slot->getNo(), 'event' => $args['event']);
                    $messagesValidSlot[$i] = FSSlot::getSlot($argsSlot);
                    if($messagesValidSlot[$i]->getStatus()== false){
                        $flagValidSlots = false;
                    }
                    $i++;
                }
                // If all slots are valid, continue 
                if($flagValidSlots){
                    // Generate the list of aValidSlot
                    foreach($messagesValidSlot as $messageValidSlot){
                        $listOfValidSlot[] = $messageValidSlot->getContent();
                    }
                    // Validate Inexistant Participant
                    $messageValidParticipant = self::getParticipant($aValidPerson->getNo());
                    if($messageValidParticipant->getStatus() == false){
                        // Create the args for create a Participant
                        $argsParticipant = array(
                            'person' => $aValidPerson,
                            'event'  => $aValidEvent,
                            'slots'  => $listOfValidSlot,
                            'registrationType' => $args['registrationType'],
                            'registrationTypeDescription' => $args['registrationTypeDescription']
                        );
                        
                        $messageCreateParticipant = self::createParticipant($argsParticipant);
                        // Create final message - Message Participant added or not added.
                        $finalMessage = $messageCreateParticipant;
                    }else{
                        // Create final message - Message Participant existe.
                        $finalMessage = $messageValidParticipant;
                    }
                }else{
                    // Create final message - List of message Slot inexistant.
                    $finalMessage = $messagesValidSlot;
                }
            }else{
                // Create final message - Message Inexistant Event.
                $finalMessage = $messageValidEvent;
            }
        }else{
            // Create final message - Message Inexistant Person.
            $finalMessage = $messageValidPerson;
        }
        return $finalMessage;
    }
  
    private static function createParticipant($args){
        global $crud;
        /* ---------------------------------------------------------------------
        $args = array(
            'person' => $aValidPerson,
            'event'  => $aValidEvent,
            'slots'  => $listOfValidSlot,
            'registrationType' => $args['registrationType'],
            'registrationTypeDescription' => $args['registrationTypeDescription']
        );
        ------------------------------------------------------------------------ */
        // Insert Participant in database
        $aPerson = $args['person'];
        $anEvent = $args['event'];
        $listOfValidSlot = $args['slots'];
        $sql = "INSERT INTO Participant (PersonNo) VALUES ('".$aPerson->getNo()."')";
        $crud->exec($sql);
        // Validate Existant Participant
        $messageAddedParticipant = self::getParticipant($aPerson->getNo());
        if($messageAddedParticipant->getStatus()){
            $aValidParticipant = $messageAddedParticipant->getContent();
            // Foreach Slot insert Participation
            $i=0;
            $flagParticipationAdded = true;
            foreach($listOfValidSlot as $slot){
                $argsParticipation = array('slot' => $slot, 'event' => $anEvent, 'participant' => $aValidParticipant);
                $messagesAddedParticipation[$i] = FSParticipation::addParticipation($argsParticipation);
                if($messagesAddedParticipation[$i]->getStatus() == false){$flagParticipationAdded = false;}
                $i++;
            }
            if($flagParticipationAdded){
                // Insert the first registration.
                foreach($messagesAddedParticipation as $message){
                    $listOfValidParticipations[] = $message->getContent();
                }
                // Insert the first registration.
                $argsRegistration = array(
                    'status'          => 'Waiting', // String
                    'type'            => $args['registrationType'], // String
                    'typeDescription' => $args['registrationTypeDescription'], // Optionel - String
                    'event'           => $args['event'], // object Event
                    'participant'     => $aValidParticipant  // object Participant
                );
                $messageAddedRegistration = FSRegistration::addRegistration($argsRegistration);
                if($messageAddedRegistration->getStatus()){
                    $aValidRegistration = $messageAddedRegistration->getContent();
                    // Create final message - Message Participant added.
                    $argsMessage = array(
                        'messageNumber' => 205,
                        'message'       => 'New Participant added, with his first Registration, and participations !',
                        'status'        => true,
                        'content'       => array('aValidParticipant' => $aValidParticipant, 'listOfValidParticipations' => $listOfValidParticipations, 'aValidRegistration'=>$aValidRegistration)
                    );
                    $finalMessage = new Message($argsMessage);
                }else{
                    
                }
            }else{
                // Create final message - Some Slots not added.
                $finalMessage = $messagesAddedParticipation;
            }
        }else{
            // Create final message - Message Participant unadded.
            $argsMessage = array(
                'messageNumber' => 206,
                'message'       => 'Error while inserting new Participant',
                'status'        => false,
                'content'       => NULL
            );
            $finalMessage = $messageAddedParticipant;
        }
        return $finalMessage;
    }
 }
    
?>
