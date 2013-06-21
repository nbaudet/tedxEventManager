<?php

/**
 * Description of FSTalk
 *
 * @author L'eau Rik
 */

require_once(APP_DIR . '/core/model/Talk.class.php');
require_once(APP_DIR . '/core/model/Speaker.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSSpeaker.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSEvent.class.php');
require_once(APP_DIR . '/core/model/Message.class.php');
require_once(APP_DIR . '/core/model/Event.class.php');

class FSTalk{
    /**
     *Returns a Talk with the given EventNo and SpeakerNo as Id
     *@param int $personNo the id of the Speaker
     *@param int $eventNo the id of the Event
     *@return a Message with an existant Talk
     */
    public static function getTalk($args){
        $talk = NULL;
        global $crud;
        
        $event = $args['event'];
        $speaker = $args['speaker'];

        $sql = "SELECT * FROM Talk 
                WHERE EventNo = " . $event->getNo(). " AND
                SpeakerPersonNo = " . $speaker->getNo(). " AND
                IsArchived = 0";

        $data = $crud->getRow($sql);
        
        if($data){
            $argsTalk = array(
                'eventNo'            => $data['EventNo'],
                'speakerPersonNo'    => $data['SpeakerPersonNo'],
                'videoTitle'    => $data['VideoTitle'],
                'videoDescription'    => $data['VideoDescription'],
                'videoURL'    => $data['VideoURL'],
                'isArchived'    => $data['IsArchived']
            );
        
            $talk = new Talk($argsTalk);

            $argsMessage = array(
                'messageNumber'     => 133,
                'message'           => 'Existant Talk',
                'status'            => true,
                'content'           => $talk
            );
            $return = new Message($argsMessage);
        }else{
            
            $argsMessage = array(
                'messageNumber'     => 134,
                'message'           => 'Inexistant Talk',
                'status'            => false,
                'content'           => NULL    
            );
            $return = new Message($argsMessage);
        }
        return $return;
    }

    /**
     * Returns all the Talks of the database
     * @return A Message containing an array of Talks
     */
    public static function getTalks(){
        global $crud;

        $sql = "SELECT * FROM Talk as CoOrg
            INNER JOIN Event as E ON E.No = CoOrg.EventNo
            INNER JOIN Speaker as Sp ON Sp.PersonNo = CoOrg.SpeakerPersonNo WHERE CoOrg.IsArchived = 0;";
        $data = $crud->getRows($sql);
        
        if ($data){
            $talks = array();

            foreach($data as $row){
                $argsTalks = array(
                    'eventNo'            => $row['EventNo'],
                    'speakerPersonNo'    => $row['SpeakerPersonNo'],
                    'videoTitle'    => $row['VideoTitle'],
                    'videoDescription'    => $row['VideoDescription'],
                    'videoURL'    => $row['VideoURL'],
                    'isArchived'    => $row['IsArchived']
                  );
            
                $talks[] = new Talk($argsTalks);
            } //foreach

            $argsMessage = array(
                'messageNumber' => 135,
                'message'       => 'All Talks selected',
                'status'        => true,
                'content'       => $talks
            );
            $return = new Message($argsMessage);
        } else {
            $argsMessage = array(
                'messageNumber' => 136,
                'message'       => 'Error while SELECT * FROM Talk',
                'status'        => false,
                'content'       => NULL
            );
            $return = new Message($argsMessage);
        }
        return $return;
    }
    
    /**
     * Add a new Talk in Database
     * @param $args Parameters of a Talk
     * @return a Message containing the new Talk
     */
    public static function addTalk($args){
        
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

                // Validate Inexistant Talk
                $argsTalk = array(
                    'event' => $aValidEvent,
                    'speaker' => $aValidSpeaker
                );
                    
                $messageValidTalk = FSTalk::getTalk($argsTalk);
                if($messageValidTalk->getStatus() == false){
                     $messageCreateTalk = self::createTalk($argsTalk);
                        // Create final message - Message Talk added or not added.
                        $return = $messageCreateTalk;
                    }else{
                        // Generate Message - Valid Talk
                        $return = $messageValidTalk;
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
     * Create a new Talk in Database
     * @param type $args
     * @return a Message containing the created Talk
     */
    private static function createTalk($args){
        global $crud;
        $event = $args['event'];
        $speaker = $args['speaker'];
        
        $sql = "INSERT INTO Talk (
            EventNo, SpeakerPersonNo) VALUES (
            '".$event->getNo()."',
            '".$speaker->getNo()."'
        )";
        $crud->exec($sql);
        
        // Validate Existant Talk
        $argsTalk = array(
            'event' => $args['event'],
            'speaker' => $args['speaker']
        );
        $messageValidTalk = self::getTalk($argsTalk);
        if($messageValidTalk->getStatus()){
            $aValidTalk = $messageValidTalk->getContent();
            // Generate message - Message Talk added.
            $argsMessage = array(
                'messageNumber' => 137,
                'message'       => 'New Talk added !',
                'status'        => true,
                'content'       => $aValidTalk
            );
            $return = new Message($argsMessage);
        }else{
            // Generate Message - Participation not Added            
            $argsMessage = array(
                    'messageNumber' => 138,
                    'message'       => 'Error while inserting new Talk',
                    'status'        => false,
                    'content'       => NULL
                );
            $return = new Message($argsMessage);
        }
        return $return;
    } // END createTalk
    
    
    /** Returns All Event by Speaker
     * @param a Speaker
     * @return a Message conainting an array of Event
     */
    public static function getEventsBySpeaker($speaker){   
        global $crud;
        
        $sql = "SELECT EventNo FROM Talk 
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
        
        $sql = "SELECT SpeakerPersonNo FROM Talk 
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
