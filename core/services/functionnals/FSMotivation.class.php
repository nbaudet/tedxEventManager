<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once(APP_DIR . '/core/model/Message.class.php');
require_once(APP_DIR . '/core/model/Motivation.class.php');
require_once(APP_DIR . '/core/model/Participant.class.php');
require_once(APP_DIR . '/core/model/Person.class.php');
require_once(APP_DIR . '/core/model/Event.class.php');
require_once(APP_DIR .'/core/services/functionnals/FSEvent.class.php');
require_once(APP_DIR .'/core/services/functionnals/FSParticipant.class.php');

/**
 * Description of FSMotivation
 *
 * @author Robin de la forêt
 */

class FSMotivation{
    /**
     * Returns the Motivation of the database with the 
     * @param type $args the IDs of Motviation
     * @return A Message containing the Motivaation getted
     */
    public static function getMotivation($args){
        $motivation = NULL;
        
        // Get database manipulator
        global $crud;
        
        // SQL request for getting a Motivation
        $sql = "SELECT * FROM Motivation WHERE Text LIKE '". $args['text'] ."' AND EventNo = " . $args['event']->getNo() . " AND ParticipantPersonNo = " . $args['participant']->getNo() . " AND IsArchived = 0;";
        $data = $crud->getRow($sql);

        // If a Motivation is Valid
        
        var_dump($args);
        if($data){
            $argsMotivation = array(
                'text'              => $data['Text'],
                'eventNo'             => $data['EventNo'],
                'participantPersonNo' => $data['ParticipantPersonNo'],
                'isArchived'            => $data['IsArchived']
            );
           
            // Get the message Existant Motivation with the object Motivation
            $motivation = new Motivation($argsMotivation);
            
            $argsMessage = array(
                'messageNumber'     => 223,
                'message'           => 'Existant Motivation',
                'status'            => true,
                'content'           => $motivation
            );
        }else{
                // Get the message Inexistant Motivation
            $argsMessage = array(
                'messageNumber'     => 224,
                'message'           => 'Inexistant Motivation',
                'status'            => false,
                'content'           => NULL    
            );
        }
        
        return new Message($argsMessage);
        
    }
    
    /**
     * Returns all the Events of the database
     * @return A Message containing an array of Events
     */
    public static function getMotivationsByPerson($aParticipant){
        global $crud;
        
        $sql = "SELECT * FROM Motivation WHERE ParticipantPersonNo = ". $aParticipant->getNo() ." AND IsArchived = 0";
        $data = $crud->getRows($sql);
        
        if ($data){
            $motivations = array();

            foreach($data as $row){
                $argsMotivation = array(
                    'text'            => $row['Text'],
                    'participantPersonNo' => $row['ParticipantPersonNo'],
                    'eventNo'          => $row['EventNo'],
                    'isArchived'       => $row['IsArchived']
                );
                
                $motivations[] = new Motivation($argsMotivation);
            } //foreach

            $argsMessage = array(
                'messageNumber' => 432,
                'message'       => 'All Motivation of Participant selected',
                'status'        => true,
                'content'       => $motivations
            );
            $message = new Message($argsMessage);
        } else {
            $argsMessage = array(
                'messageNumber' => 433,
                'message'       => 'Error while SELECT * FROM Motivation WHERE IsArchived = 0',
                'status'        => false,
                'content'       => NULL
            );
            $message = new Message($argsMessage);
        }// else
        return $message;
    }// function
    
    
    public static function getMotivationsByPersonForEvent($args){
        global $crud;
        $aParticipant = $args['participant'];
        $anEvent = $args['event'];
        $sql = "SELECT * FROM Motivation WHERE ParticipantPersonNo = ". $aParticipant->getNo() ." AND EventNo = " . $anEvent->getNo() . " AND IsArchived = 0";
        $data = $crud->getRows($sql);
        
        if ($data){
            $motivations = array();

            foreach($data as $row){
                $argsMotivation = array(
                    'text'            => $row['Text'],
                    'participantPersonNo' => $row['ParticipantPersonNo'],
                    'eventNo'          => $row['EventNo'],
                    'isArchived'       => $row['IsArchived']
                );
                
                $motivations[] = new Motivation($argsMotivation);
            } //foreach

            $argsMessage = array(
                'messageNumber' => 432,
                'message'       => 'All Motivation of Participant selected',
                'status'        => true,
                'content'       => $motivations
            );
            $message = new Message($argsMessage);
        } else {
            $argsMessage = array(
                'messageNumber' => 433,
                'message'       => 'Error while SELECT * FROM Motivation WHERE IsArchived = 0',
                'status'        => false,
                'content'       => NULL
            );
            $message = new Message($argsMessage);

        }// else
        return $message;
    }// function
    
    
    
    
    /**
     * Returns all the Register of the database
     * @return A Message containing an array of Motivation
     */
    public static function getMotivations(){
        // Get database manipulator
        global $crud;
        
        // SQL Request for getting all Persistants Motivations
        $sql = "SELECT * FROM Motivation WHERE IsArchived = 0";
        $data = $crud->getRows($sql);
        
        // If there is persistants Motivations
        if($data){
            $motivations = array();
            
            // For each Persistant Motivation, create an Object
            foreach($data as $row){
                $argsMotivation = array(
                    'text'              => $row['Text'],
                    'eventNo'             => $row['EventNo'],
                    'participantPersonNo' => $row['ParticipantPersonNo'],
                    'isArchived'          => $row['IsArchived']
                );
            
                $motivations[] = new Motivation($argsMotivation);
            } //foreach

            // Create a message with all objects returned
            $argsMessage = array(
                'messageNumber' => 225,
                'message'       => 'All Motivation gotten',
                'status'        => true,
                'content'       => $motivations
            );
        } else {
            // Create a message with no persistant object 
            $argsMessage = array(
                'messageNumber' => 226,
                'message'       => 'No persistant Motivation',
                'status'        => false,
                'content'       => NULL
            );
        }
        return new Message($argsMessage);
    }
    
    /**
     * Adds a new Motivation in Database
     * @param type $args
     * @return Message containing the created Slot
     */
    public static function addMotivation($args){
        global $crud;
        $return = null;
        $event = $args['Event'];
        $participant = $args['Participant'];
        
        // Validate Event
        $aValidEvent = FSEvent::getEvent($event->getNo());
        
        // Validate Participant
        $aValidParticipant = FSParticipant::getParticipant($participant->getNo());
        
        $aMotivation = array(
            'Text'  => $args['Text'],
            'EventNo'   =>  $event->getNo(),
            'ParticipantPersonNo'   =>  $participant->getNo()
        );
        // Validate Motivation
        $anInexistantMotivation = FSMotivation::getMotivation($aMotivation);
        
        if(($aValidEvent->getStatus()) && ($aValidParticipant->getStatus()) && !($anInexistantMotivation->getStatus())){
           
            // Create new Slot
            $sql = "INSERT INTO `Motivation` (`Text`, `EventNo`, `ParticipantPersonNo`) VALUES (
                '".$args['Text']."',
                ".$event->getNo().", 
                '".$participant->getNo()."'
            );";
            
            if($crud->exec($sql) == 1){
                      
                // Get created Membership
                $argsMotivation = array (
                    'Text'  => $args['Text'],
                    'EventNo'   =>  $event->getNo(),
                    'ParticipantPersonNo'   =>  $participant->getNo()
                );
                
                $messageCreatedMotivation = FSMotivation::getMotivation($argsMotivation);
                
                $argsMessage = array(
                    'messageNumber' => 227,
                    'message'       => 'New Motivation added !',
                    'status'        => true,
                    'content'       => $messageCreatedMotivation->getContent()
                );
                $return = new Message($argsMessage);
                      
            } else {
                $argsMessage = array(
                   'messageNumber' => 228,
                   'message'       => 'Error while inserting new Motivation',
                   'status'        => false,
                   'content'       => NULL
               );
               $return = new Message($argsMessage);
            } // END Create Motivation
                    
        } else {
            $argsMessage = array(
                'messageNumber' => 229,
                'message'       => 'No valid Event or Participant found',
                'status'        => FALSE,
                'content'       => null
            );
            
            $return = new Message($argsMessage);            
        }
        
        return $return;
    } // END addSlot()
    
    /**
     * Set new parameters to a Motivation
     * @param Motivation $aMotivationToSet
     * @return Message containing the set Motivation
     */
    public static function setMotivation($aMotivationToSet) {
        global $crud;
            $sql = "UPDATE  Motivation SET  
                IsArchived = '" . $aMotivationToSet->getIsArchived() . "'
                WHERE  Motivation.Text = '" . $aMotivationToSet->getText() . "'
                 AND Motivation.EventNo = " . $aMotivationToSet->getEventNo() . "
                 AND Motivation.ParticipantPersonNo = " . $aMotivationToSet->getParticipantPersonNo();
 
            if ($crud->exec($sql) == 1) {
                $sql = "SELECT * FROM Motivation 
                    WHERE Text = " . $aMotivationToSet->getText() . " 
                        AND EventNo = " . $aMotivationToSet->getEventNo() . " 
                            AND ParticipantPersonNo = " . $aMotivationToSet->getParticipantPersonNo() . "
                                AND IsArchived = " . $aMotivationToSet->getIsArchived(); 
                $data = $crud->getRow($sql);

                $argsMotivation = array(
                    'text' => $aMotivationToSet->getText(),
                    'eventNo' => $aMotivationToSet->getEventNo(),
                    'participantPersonNo' => $aMotivationToSet->getParticipantPersonNo(),
                    'isArchived' => $aMotivationToSet->getIsArchived()
                );
 
                $aSetMotivation = new Motivation($argsMotivation);

                $argsMessage = array(
                    'messageNumber' => 230,
                    'message' => 'Motivation set !',
                    'status' => true,
                    'content' => $aSetMotivation
                );
                $message = new Message($argsMessage);
            } else {
                $argsMessage = array(
                    'messageNumber' => 231,
                    'message' => 'Error while setting new Motivation',
                    'status' => false,
                    'content' => NULL
                );
                $message = new Message($argsMessage);
            }
        return $message;
    }
    
    /**
     * Archive a Motivation
     * @param Keyword $aKeywordToSet
     * @return Message containing the archived Keyword
     */
    public static function archiveMotivation($aMotivationToArchive) {
        return self::setMotivation($aMotivationToArchive);
    }
}
?>
