<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once(APP_DIR . '/core/model/Message.class.php');
require_once(APP_DIR . '/core/model/Registration.class.php');
require_once(APP_DIR . '/core/model/Participant.class.php');
require_once(APP_DIR . '/core/model/Person.class.php');
require_once(APP_DIR . '/core/model/Event.class.php');


/**
 * Description of FSRegistration
 *
 * @author Rapou
 */
class FSRegistration {
    /**
     * Returns the Register of the database with the 
     * @param type $args the ID of Registration
     * @return A Message containing the Registration getted
     */
    public static function getRegistration($args){
        $registration = NULL;
        
        // Get database manipulator
        global $crud;
        
        // SQL request for getting a Registration
        $sql = "SELECT * FROM Registration WHERE Status LIKE '". $args['status'] ."' AND EventNo = " . $args['event']->getNo() . " AND ParticipantPersonNo = " . $args['participant']->getNo();
        $data = $crud->getRow($sql);

        // If a Registration is Valid
        if($data){
            $argsRegistration = array(
                'status'              => $data['Status'],
                'eventNo'             => $data['EventNo'],
                'participantPersonNo' => $data['ParticipantPersonNo'],
                'registrationDate'    => $data['RegistrationDate'],
                'type'                => $data['Type'],
                'typeDescription'     => $data['TypeDescription'],
                'isArchived'          => $data['IsArchived']
            );
            
            // Get the message Existant Registration with the object Registration
            $registration = new Registration($argsRegistration);
            $argsMessage = array(
                'messageNumber'     => 410,
                'message'           => 'Existant Registration',
                'status'            => true,
                'content'           => $registration
            );
        }else{
            // Get the message Inexistant Registration
            $argsMessage = array(
                'messageNumber'     => 411,
                'message'           => 'Inexistant Registration',
                'status'            => false,
                'content'           => NULL    
            );
        }
        return new Message($argsMessage);
    }
    
    /**
     * Returns all the Register of the database
     * @return A Message containing an array of Registration
     */
    public static function getRegistrations(){
        // Get database manipulator
        global $crud;
        
        // SQL Request for getting all Persistants Registrations
        $sql = "SELECT * FROM Registration WHERE IsArchived = 0";
        $data = $crud->getRows($sql);
        
        // If there is persistants Registrations
        if($data){
            $participants = array();
            
            // For each Persistant Registration, create an Object
            foreach($data as $row){
                $argsRegistration = array(
                    'status'              => $row['Status'],
                    'eventNo'             => $row['EventNo'],
                    'participantPersonNo' => $row['ParticipantPersonNo'],
                    'registrationDate'    => $row['RegistrationDate'],
                    'type'                => $row['Type'],
                    'typeDescription'     => $row['TypeDescription'],
                    'isArchived'          => $row['IsArchived']
                );
            
                $participants[] = new Registration($argsRegistration);
            } //foreach

            // Create a message with all objects returned
            $argsMessage = array(
                'messageNumber' => 412,
                'message'       => 'All Registration getted',
                'status'        => true,
                'content'       => $participants
            );
        } else {
            // Create a message with no persistant object 
            $argsMessage = array(
                'messageNumber' => 413,
                'message'       => 'No persistant Registration',
                'status'        => false,
                'content'       => NULL
            );
        }
        return new Message($argsMessage);
    }
    
    /**
     * Returns all the Register of an Event
     * @param type $anEvent the event of the registrations
     * @return \Message the registrations
     */
    public static function getRegistrationsByEvent($anEvent){
        // Get database manipulator
        global $crud;
        
        // SQL Request for getting all Persistants Registrations
        $sql = "SELECT * FROM Registration WHERE EventNo = ". $anEvent->getNo() ." AND IsArchived = 0";
        $data = $crud->getRows($sql);
        
        // If there is persistants Registrations
        if($data){
            $participants = array();
            
            // For each Persistant Registration, create an Object
            foreach($data as $row){
                $argsRegistration = array(
                    'status'              => $row['Status'],
                    'eventNo'             => $row['EventNo'],
                    'participantPersonNo' => $row['ParticipantPersonNo'],
                    'registrationDate'    => $row['RegistrationDate'],
                    'type'                => $row['Type'],
                    'typeDescription'     => $row['TypeDescription'],
                    'isArchived'          => $row['IsArchived']
                );
            
                $participants[] = new Registration($argsRegistration);
            } //foreach

            // Create a message with all objects returned
            $argsMessage = array(
                'messageNumber' => 412,
                'message'       => 'All Registration getted',
                'status'        => true,
                'content'       => $participants
            );
        } else {
            // Create a message with no persistant object 
            $argsMessage = array(
                'messageNumber' => 413,
                'message'       => 'No persistant Registration',
                'status'        => false,
                'content'       => NULL
            );
        }
        return new Message($argsMessage);
    }
    
    
    /**
     * Add a new Registration in Database
     * @param $args Parameters of a Registration
     * @return a Message containing the new Registration
     */
    public static function addRegistration($args){
        // Get database manipulator
        
        /*
        $args = array(
            'status'          => '', // String
            'type'            => '', // String
            'typeDescription' => '', // Optionel - String
            'event'           => '', // object Event
            'participant'     => ''  // object Participant
        );
         */
        // Validate If Participant is Existant
        $messageValidParticipant = FSParticipant::getParticipant($args['participant']->getNo());
        if($messageValidParticipant->getStatus()){
            // Validate If Event is Existant
            $messageValidEvent = FSEvent::getEvent($args['event']->getNo());
            if($messageValidEvent->getStatus()){
                // Validate If Registration is not existant
                $argsRegistration = array('status' => $args['status'], 'event'=> $args['event'], 'participant' => $args['participant']);
                $messageValidRegistration = self::getRegistration($argsRegistration);
                if($messageValidRegistration->getStatus()== false){
                    // Insert the registration in persistants objects
                    $messageCreateRegistration = self::createRegistration($args);
                    $finalMessage = $messageCreateRegistration;
                }else{
                    
                    $finalMessage = $messageValidRegistration; 
                }
            }else{
                $finalMessage = $messageValidEvent;
            }
        }else{
            $finalMessage = $messageValidParticipant;
        }
        return $finalMessage;
    }
    
    private static function createRegistration($args){
        global $crud;
        
        if(!isset($args['typeDescription']) || $args['typeDescription'] == ''){
            $description = NULL;
        }else{
            $description = $args['typeDescription'];
        }
        
        // Execute the INSERT sql
        $date = date('Y-m-d');
        $sql = "INSERT INTO `Registration` (`Status`, `EventNo`, `ParticipantPersonNo`, `RegistrationDate`, `Type`, `TypeDescription`) 
               VALUES ('".$args['status']."', '".$args['event']->getNo()."', '".$args['participant']->getNo()."', '" . $date . "', '".$args['type']."', '".$description."')";
        $crud->exec($sql);
        
        // Check if the Registration is added.
        $messageValidRegistration = self::getRegistration($args);
        if($messageValidRegistration->getStatus()){
            $aRegistration = $messageValidRegistration->getContent();
            $argsMessage = array(
                'messageNumber' => 414,
                'message'       => 'Registration inserted',
                'status'        => true,
                'content'       => $aRegistration
            );
        }else{
            $argsMessage = array(
                'messageNumber' => 415,
                'message'       => 'Error while inserting new Registration',
                'status'        => false,
                'content'       => NULL
            ); 
        }
        $finalMessage = new Message($argsMessage);
        return $finalMessage;
    }
    
    
     /**
     * Set new parameters to a Registration
     * @param Registration $aRegistrationToSet
     * @return Message containing the setted Registration
     */
    public static function setRegistration($aRegistrationToSet) {
        global $crud;
        $messageValidEvent = FSEvent::getEvent($aRegistrationToSet->getEventNo());
        if ($messageValidEvent->getStatus()) {
            $aValidEvent = $messageValidEvent->getContent();
            $messageValidParticipant = FSParticipant::getParticipant($aRegistrationToSet->getParticipantPersonNo());
            if ($messageValidParticipant->getStatus()){
                $aValidParticipant = $messageValidParticipant->getContent();
                $argsRegistration = array('event' => $aValidEvent, 'participant' => $aValidParticipant, 'status' => $aRegistrationToSet->getStatus());
                $messageValidRegistration = self::getRegistration($argsRegistration);
                if($messageValidRegistration->getStatus()){
                    $aValidRegistration = $messageValidRegistration->getContent();
                    $sql = "UPDATE  Registration SET  
                        Type = '" . $aRegistrationToSet->getType() . "',
                        TypeDescription = '" . $aRegistrationToSet->getTypeDescription() . "',
                        IsArchived = '" . $aRegistrationToSet->getIsArchived() . "'
                        WHERE Registration.Status = '" . $aValidRegistration->getStatus() . "'
                        AND Registration.ParticipantPersonNo = " . $aValidParticipant->getNo() . "
                        AND Registration.EventNo = " . $aValidEvent->getNo();

                    if ($crud->exec($sql) == 1) {
                        $sql = "SELECT * FROM Registration
                        WHERE Registration.Status = '" . $aValidRegistration->getStatus() . "'
                        AND Registration.ParticipantPersonNo = " . $aValidParticipant->getNo() . "
                        AND Registration.EventNo = " . $aValidEvent->getNo();
                        
                        $data = $crud->getRow($sql);

                        $argsRegistration = array(
                            'status'              => $data['Status'],
                            'eventNo'             => $data['EventNo'],
                            'participantPersonNo' => $data['ParticipantPersonNo'],
                            'registrationDate'    => $data['RegistrationDate'],
                            'type'                => $data['Type'],
                            'typeDescription'     => $data['TypeDescription'],
                            'isArchived'          => $data['IsArchived']
                        );

                        $aSettedRegistration = new Registration($argsRegistration);

                        $argsMessage = array(
                            'messageNumber' => 430,
                            'message' => 'Registration setted !',
                            'status' => true,
                            'content' => $aSettedRegistration
                        );
                        $message = new Message($argsMessage);
                    } else {
                        $argsMessage = array(
                            'messageNumber' => 431,
                            'message' => 'Error while setting Registration',
                            'status' => false,
                            'content' => NULL
                        );
                        $message = new Message($argsMessage);
                    }
                }else{
                    // Inexistant registration
                    $message = $messageValidRegistration;
                }
            }else{
                // Inexistant Participant
                $message = $messageValidParticipant;
            }
        } else {
            // Inexistant Event
            $message = $messageValidEvent;
        }
        return $message;
    }
    
    public static function archiveRegistration($aRegistrationToArchive) {
        return self::setRegistration($aRegistrationToArchive);
    }
    
}

?>
