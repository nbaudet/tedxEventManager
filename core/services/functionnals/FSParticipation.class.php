<?php

/**
 * Description of FSParticipation
 *
 * @author Robin Jet-Pierre
 */

require_once(APP_DIR . '/core/model/Participation.class.php');
require_once(APP_DIR . '/core/model/Participant.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSParticipant.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSEvent.class.php');
require_once(APP_DIR . '/core/model/Slot.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSSlot.class.php');
require_once(APP_DIR . '/core/model/Message.class.php');
require_once(APP_DIR . '/core/model/Event.class.php');

class FSParticipation{
    /**
     *Returns a Participation with the given No as Id
     *@param string $personNo the id of the Participation
     *@return a Message with an existant Participation
     */
    public static function getParticipation($argsParticipation){
        $participation = NULL;
        
        global $crud;

        $sql = "SELECT * FROM Participation as PAON
            INNER JOIN Slot as S ON S.No = PAON.SlotNo and S.EventNo = PAON.SlotEventNo 
            INNER JOIN Participant as PAT ON PAT.PersonNo = PAON.ParticipantPersonNo
            WHERE PAON.SlotNo = " . $argsParticipation['slotNo']. " and
                PAON.SlotEventNo = " . $argsParticipation['slotEventNo']. " and
                PAON.ParticipantPersonNo = " . $argsParticipation['participantPersonNo']. ";";

        $data = $crud->getRow($sql);
        
        if($data){
            $argsParticipation = array(
                'slotNo'            => $data['SlotNo'],
                'slotEventNo'          => $data['SlotEventNo'],
                'participantPersonNo'     => $data['ParticipantPersonNo'],
                'isArchived'    => $data['IsArchived']
            );
        
            $participation = new Participation($argsParticipation);

            $argsMessage = array(
                'messageNumber'     => 217,
                'message'           => 'Existant Participation',
                'status'            => true,
                'content'           => $participation
            );
            $return = new Message($argsMessage);
        }else{
            
            $argsMessage = array(
                'messageNumber'     => 218,
                'message'           => 'Inexistant Participation',
                'status'            => false,
                'content'           => NULL    
            );
            $return = new Message($argsMessage);
        }
        return $return;
    }

    /**
     * Returns all the Participations of the database
     * @return A Message containing an array of Participations
     */
    public static function getParticipations(){
        global $crud;

        $sql = "SELECT * FROM Participation as PAON
            INNER JOIN Slot as S ON S.No = PAON.SlotNo and S.EventNo = PAON.SlotEventNo 
            INNER JOIN Participant as PAT ON PAT.PersonNo = PAON.ParticipantPersonNo";
        $data = $crud->getRows($sql);
        
        if ($data){
            $participations = array();

            
            foreach($data as $row){
                $argsParticipation = array(
                    'slotNo'            => $row['SlotNo'],
                    'slotEventNo'          => $row['SlotEventNo'],
                    'participantPersonNo'     => $row['ParticipantPersonNo'],
                    'isArchived'    => $row['IsArchived']
                );
            
                $participations[] = new Participation($argsParticipation);
            } //foreach

            $argsMessage = array(
                'messageNumber' => 219,
                'message'       => 'All Participations selected',
                'status'        => true,
                'content'       => $participations
            );
            $return = new Message($argsMessage);
        } else {
            $argsMessage = array(
                'messageNumber' => 220,
                'message'       => 'Error while SELECT * FROM Participation',
                'status'        => false,
                'content'       => NULL
            );
            $return = new Message($argsMessage);
        }
        return $return;
    }
    
       /**
     * Add a new Participation in Database
     * @param $args Parameters of a Participation
     * @return a Message containing the new Participation
     */
    public static function addParticipation($args){
        global $crud;
        /* ------------------------------------
         * $args(
         *  'slot'        => $slot, 
         *  'event'       => $event,
         *  'participant' => $aValidParticipant
         * )
         * ------------------------------------ */
                
        // Validate Existant Participant
        $messageValidParticipant = FSParticipant::getParticipant($args['partipant']->getNo());
        if($messageValidParticipant->getStatus()){
            $aValidPaticipant = $messageValidParticipant->getContent();
            $messageValidEvent = FSEvent::getEvent($args['event']->getNo);
            if($messageValidEvent){
                $aValidEvent = $messageValidEvent->getContent();
                // Validate Slot No Existant
                $argsSlot = array(
                    'no' => $args['slot']->getNo(),
                    'event' => $aValidEvent
                );
                $messageValidSlot = FSSlot::getSlot($argsSlot);
                if($messageValidSlot->getStatus()){
                    $aValidSlot = $messageValidSlot->getContent();
                    // Validate Inexistant Participation
                    $argsParticipation = array(
                        'slotNo' => $aValidSlot->getNo(),
                        'slotEventNo' => $aValidEvent->getNo(),
                        'participantNo' => $aValidPaticipant->getNo()
                    );
                    $messageValidParticipation = FSParticipation::getParticipation($argsParticipation);
                    if($messageValidParticipation == false){
                        $argsCreateParticipation = array(
                            'slot' => $aValidSlot,
                            'event' => $aValidEvent,
                            'participant' => $aValidPaticipant
                        );
                        $messageCreateParticipation = self::createParticipation($argsCreateParticipation);
                        // Create final message - Message Participant added or not added.
                        $finalMessage = $messageCreateParticipation;
                    }else{
                        // Generate Message - Valid Participation
                        $finalMessage = $messageValidParticipation;
                    }
                }else{
                    // Generate Message - Invalid Slot
                    $finalMessage = $messageValidSlot;
                }
            }else{
                // Generate Message - Invalid Event
                $finalMessage = $messageValidEvent;
            }
        }else{
            // Generate Message - Invalid Participant
            $finalMessage = $messageValidParticipant;
        }
        return $finalMessage;
    }
    
    private static function createParticipation($args){
        /* --------------------------------------------
         *  $argsCreateParticipation = array(
         *      'slot' => $aValidSlot,
         *      'event' => $aValidEvent,
         *      'participant' => $aValidPaticipant
         *   );
         * -------------------------------------------- */
        global $crud;
        $sql = "INSERT INTO Participation (
            slotNo, slotEventNo, participantPersonNo) VALUES (
            '".$args['slot']->getNo()."',
            '".$args['event']->getNo()."',
            '".$args['participant']->getNo()."'
        )";
        $crud->exec($sql);
        // Validate Existant Participation
        $argsParticipation = array(
            'slotNo' => $args['slot']->getNo(),
            'slotEventNo' => $args['event']->getNo(),
            'participantNo' => $args['participant']->getNo()
        );
        $messageValidParticipation = self::getParticipation($argsParticipation);
        if($messageValidParticipation->getStatus()){
            $aValidParticipation = $messageValidParticipation->getContent();
            // Generate message - Message Participation added.
            $argsMessage = array(
                'messageNumber' => 221,
                'message'       => 'New Participation added !',
                'status'        => true,
                'content'       => $aValidParticipation
            );
            $finalMessage = new Message($argsMessage);
        }else{
            // Generate Message - Participation not Added            
            $argsMessage = array(
                    'messageNumber' => 222,
                    'message'       => 'Error while inserting new Participation',
                    'status'        => false,
                    'content'       => NULL
                );
            $finalMessage = new Message($argsMessage);
        }
        return $finalMessage;
    }
    
 }
    
?>
