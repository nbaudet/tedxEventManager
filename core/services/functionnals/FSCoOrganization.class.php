<?php

/**
 * Description of FSCoOrganization
 *
 * @author L'eau Rik
 */

require_once(APP_DIR . '/core/model/CoOrganization.class.php');
require_once(APP_DIR . '/core/model/Speaker.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSSpeaker.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSEvent.class.php');
require_once(APP_DIR . '/core/model/Message.class.php');
require_once(APP_DIR . '/core/model/Event.class.php');

class FSCoOrganization{
    /**
     *Returns a CoOrganization with the given EventNo and SpeakerNo as Id
     *@param int $personNo the id of the Speaker
     *@param int $eventNo the id of the Event
     *@return a Message with an existant CoOrganization
     */
    public static function getCoOrganization($args){
        $coOrganization = NULL;
        global $crud;
        
        $event = $args['event'];
        $speaker = $args['speaker'];

        $sql = "SELECT * FROM CoOrganization 
                WHERE EventNo = " . $event->getNo(). " AND
                SpeakerPersonNo = " . $speaker->getNo(). " AND
                IsArchived = 0";

        $data = $crud->getRow($sql);
        
        if($data){
            $argsCoOrganization = array(
                'eventNo'            => $data['EventNo'],
                'speakerPersonNo'    => $data['SpeakerPersonNo'],
                'isArchived'    => $data['IsArchived']
            );
        
            $coOrganization = new CoOrganization($argsCoOrganization);

            $argsMessage = array(
                'messageNumber'     => 133,
                'message'           => 'Existant CoOrganization',
                'status'            => true,
                'content'           => $coOrganization
            );
            $return = new Message($argsMessage);
        }else{
            
            $argsMessage = array(
                'messageNumber'     => 134,
                'message'           => 'Inexistant CoOrganization',
                'status'            => false,
                'content'           => NULL    
            );
            $return = new Message($argsMessage);
        }
        return $return;
    }

    /**
     * Returns all the CoOrganizations of the database
     * @return A Message containing an array of CoOrganizations
     */
    public static function getCoOrganizations(){
        global $crud;

        $sql = "SELECT * FROM CoOrganization as CoOrg
            INNER JOIN Event as E ON E.No = CoOrg.EventNo
            INNER JOIN Speaker as Sp ON Sp.PersonNo = CoOrg.SpeakerPersonNo WHERE CoOrg.IsArchived = 0;";
        $data = $crud->getRows($sql);
        
        if ($data){
            $coOrganizations = array();

            foreach($data as $row){
                $argsCoOrganizations = array(
                    'eventNo'           => $row['EventNo'],
                    'speakerPersonNo'   => $row['SpeakerPersonNo'],
                    'isArchived'        => $row['IsArchived']
                  );
            
                $coOrganizations[] = new CoOrganization($argsCoOrganizations);
            } //foreach

            $argsMessage = array(
                'messageNumber' => 135,
                'message'       => 'All CoOrganzations selected',
                'status'        => true,
                'content'       => $coOrganizations
            );
            $return = new Message($argsMessage);
        } else {
            $argsMessage = array(
                'messageNumber' => 136,
                'message'       => 'Error while SELECT * FROM CoOrganizations',
                'status'        => false,
                'content'       => NULL
            );
            $return = new Message($argsMessage);
        }
        return $return;
    }
    
    /**
     * Add a new CoOrganization in Database
     * @param $args Parameters of a CoOrganization
     * @return a Message containing the new CoOrganization
     */
    public static function addCoOrganization($args){
        
        $event = $args['event'];
        $speaker = $args['speaker'];
        
        // Validate Existant Speaker
        $messageValidSpeaker = FSSpeaker::getSpeaker($speaker->getNo());
        
        if($messageValidSpeaker->getStatus()){
            $aValidSpeaker = $messageValidSpeaker->getContent();
            
            // Validate Event
            $messageValidEvent = FSEvent::getEvent($event->getNo());
            
            if($messageValidEvent->getStatus()){
                $aValidEvent = $messageValidEvent->getContent();

                // Validate Inexistant CoOrganization
                $argsCoOrganization = array(
                    'event' => $aValidEvent,
                    'speaker' => $aValidSpeaker
                );
                    
                $messageValidCoOrganization = FSCoOrganization::getCoOrganization($argsCoOrganization);
                if($messageValidCoOrganization->getStatus() == false){
                     $messageCreateCoOrganization = self::createCoOrganization($argsCoOrganization);
                        // Create final message - Message CoOrganization added or not added.
                        $return = $messageCreateCoOrganization;
                    }else{
                        // Generate Message - Valid CoOrganization
                        $return = $messageValidCoOrganization;
                    }
 
            }else{
                // Generate Message - Invalid Event
                $return = $messageValidEvent;
            }
        }else{
            // Generate Message - Invalid Participant
            $return = $messageValidSpeaker;
        }
        return $return;
    }
    
    
    /**
     * Create a new CoOrganization in Database
     * @param type $args
     * @return a Message containing the created CoOrganization
     */
    private static function createCoOrganization($args){
        global $crud;
        $event = $args['event'];
        $speaker = $args['speaker'];
        
        $sql = "INSERT INTO CoOrganization (
            EventNo, SpeakerPersonNo) VALUES (
            '".$event->getNo()."',
            '".$speaker->getNo()."'
        )";
        $crud->exec($sql);
        
        // Validate Existant CoOrganization
        $argsCoOrganization = array(
            'event' => $args['event'],
            'speaker' => $args['speaker']
        );
        $messageValidCoOrganization = self::getCoOrganization($argsCoOrganization);
        if($messageValidCoOrganization->getStatus()){
            $aValidCoOrganization = $messageValidCoOrganization->getContent();
            // Generate message - Message CoOrganization added.
            $argsMessage = array(
                'messageNumber' => 137,
                'message'       => 'New CoOrganization added !',
                'status'        => true,
                'content'       => $aValidCoOrganization
            );
            $return = new Message($argsMessage);
        }else{
            // Generate Message - Participation not Added            
            $argsMessage = array(
                    'messageNumber' => 138,
                    'message'       => 'Error while inserting new CoOrganization',
                    'status'        => false,
                    'content'       => NULL
                );
            $return = new Message($argsMessage);
        }
        return $return;
    } // END createCoOrganization
    
    
    /** Returns All Event by Speaker
     * @param a Speaker
     * @return a Message conainting an array of Event
     */
    public static function getEventsBySpeaker($speaker){   
        global $crud;
        
        $sql = "SELECT EventNo FROM CoOrganization 
            WHERE SpeakerPersonNo = ".$speaker->getNo()." AND IsArchived = 0";
        
        $data = $crud->getRows($sql);
        
        if($data){
            $events = array();
            
            foreach($data as $row){
                $events[] = FSEvent::getEvent($row['EventNo'])->getContent();
            }//foreach
            
            $argsMessage = array(
                'messageNumber' => 139,
                'message'       => 'All Events for a Speaker selected',
                'status'        => true,
                'content'       => $events
            );
            
            $return = new Message($argsMessage);
            
        }else{
            echo "argh";
            $argsMessage = array(
                'messageNumber' => 140,
                'message'       => 'Error while SELECT * FROM Events WHERE ...',
                'status'        => false,
                'content'       => NULL
            );
            
            $return = new Message($argsMessage);
        }
        
        return $return;
    } // END getEventBySpeaker
     
     /** Returns All Speakers for an Event
     * @param an Event
     * @return a Message conainting an array of Speakers
     */
    public static function getSpeakersByEvent($event){   
        global $crud;
        
        $sql = "SELECT SpeakerPersonNo FROM CoOrganization 
            WHERE EventNo = ".$event->getNo()." AND IsArchived = 0";
        
        $data = $crud->getRows($sql);
        
        if($data){
            $speakers = array();
            var_dump($data);
            foreach($data as $row){
                $speakers[] = FSSpeaker::getSpeaker($row['SpeakerPersonNo'])->getContent();
            }//foreach
            
            $argsMessage = array(
                'messageNumber' => 141,
                'message'       => 'All Speakers for an Event selected',
                'status'        => true,
                'content'       => $speakers
            );
            
            $return = new Message($argsMessage);
            
        }else{
            echo "argh";
            $argsMessage = array(
                'messageNumber' => 142,
                'message'       => 'Error while SELECT * FROM Events WHERE ...',
                'status'        => false,
                'content'       => NULL
            );
            
            $return = new Message($argsMessage); 
        }
        
        return $return;
    } // END getSpeakersByEvent
    
 }
    
?>
