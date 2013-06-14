<?php

/**
 * Description of FSParticipation
 *
 * @author Robin Jet-Pierre
 */

require_once(APP_DIR . '/core/model/Participation.class.php');
require_once(APP_DIR . '/core/model/Participant.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSParticipant.class.php');
require_once(APP_DIR . '/core/model/Slot.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSSlot.class.php');
require_once(APP_DIR . '/core/model/Message.class.php');

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
    public static function addParticipation($aParticipation){
        global $crud;
        
        $aSlot= array(
          'no' =>   $aParticipation['slotNo'],
          'event' =>   $aParticipation['slotEventNo']  
        );
                
        /*
         * Validate Participant No Existant
         */
        $messageValidParticipant = FSParticipant::getParticipant($aParticipation['participantPersonNo']);
        
        /*
         * Validate Slot No Existant
         */
        $messageValidSlot = FSSlot::getSlot($aSlot);
        
        /*
         * Validate Participation PersonNo Inexistant
         */
        $messageValidParticipation = FSParticipation::getParticipation($aParticipation);
        
        /*
         * If already existant Person and Inexistant Participation
         */
        if(($messageValidParticipant->getStatus())&&($messageValidSlot->getStatus())&&(!($messageValidParticipation->getStatus()))){  
            $sql = "INSERT INTO Participation (
                slotNo, slotEventNo, participantPersonNo) VALUES (
                    '".$aParticipation['slotNo']."',
                    '".$aParticipation['slotEventNo']."',
                    '".$aParticipation['participantPersonNo']."'
            );";
        }else{
            $sql="";
        };
        
        if($crud->exec($sql) == 1){   
            $aCreatedParticipation = FSParticipation::getParticipation($aParticipation);
            
            $argsMessage = array(
                'messageNumber' => 221,
                'message'       => 'New Participation added !',
                'status'        => true,
                'content'       => $aCreatedParticipation
            );
            $return = new Message($argsMessage);
        } else {
            $argsMessage = array(
                'messageNumber' => 222,
                'message'       => 'Error while inserting new Participation',
                'status'        => false,
                'content'       => NULL
            );
            $return = new Message($argsMessage);
        }   
        return $return;
    }
    
 }
    
?>
