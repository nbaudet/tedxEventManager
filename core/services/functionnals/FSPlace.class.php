<?php

/*
 * Description of FSPlace
 * 
 * Author Lauric F
 */
require_once(APP_DIR . '/core/model/Place.class.php');


class FSPlace {
    
    /**
     * Returns a Place with the given parameters as id
     * @param array $args all the params
     * @return a Message containing the Existant Place
     */
    public static function getPlace($args){
        $place = NULL;
        global $crud;
        
        $no = $args['no'];
        $slot = $args['slot'];
        $speaker = $args['speaker'];
        
        $sql = "SELECT * FROM Place WHERE No = $no AND SlotNo = ".$slot->getNo()." AND 
        SlotEventNo = ".$slot->getEventNo()." AND SpeakerPersonNo = ".$speaker->getNo()." AND IsArchived = 0";
        
        $data = $crud->getRow($sql);
        
        if ($data){
            $argsPlace = array (
                'no'                => $data['No'],
                'slotNo'            => $data['SlotNo'],
                'slotEventNo'       => $data['SlotEventNo'],
                'speakerPersonNo'   => $data['SpeakerPersonNo'],
                'isArchived'        => $data['IsArchived']
            );
            
            $place = new Place($argsPlace);
            
            $argsMessage = array(
                'messageNumber'     => 155,
                'message'           => 'Existant Place',
                'status'            => true,
                'content'           => $place
            );
            $return = new Message($argsMessage);
            
        }else{
            $argsMessage = array(
                'messageNumber'     => 156,
                'message'           => 'Inexistant Place',
                'status'            => FALSE,
                'content'           => null
            );
            $return = new Message($argsMessage);
        }
        return $return;
    } // END getPlace
    
    
    /**
     * Returns all the Places in Database
     * @return a Message containing all the Places
     */
    public static function getPlaces(){
        global $crud;
        
        $sql = "SELECT * FROM Place WHERE IsArchived = 0";
        
        $data = $crud->getRows($sql);
        
        if ($data){
            $places = array();
            
            foreach ($data as $row){
                $argsPlace = array (
                    'no'                => $row['No'],
                    'slotNo'            => $row['SlotNo'],
                    'slotEventNo'       => $row['SlotEventNo'],
                    'speakerPersonNo'   => $row['SpeakerPersonNo'],
                    'isArchived'        => $row['IsArchived']
                );

                $places[] = new Place($argsPlace);
            } // foreach
            
            $argsMessage = array(
                'messageNumber'     => 157,
                'message'           => 'All Places selected',
                'status'            => true,
                'content'           => $places
            );
            $return = new Message($argsMessage);
            
        } else {
            $argsMessage = array(
                'messageNumber'     => 158,
                'message'           => 'Error while SELECT * FROM Place',
                'status'            => false,
                'content'           => NULL
            );
            $return = new Message($argsMessage);
        }
        return $return;
    } // END getPlaces
    
    /**
     * Returns all the Places concerned by a Slot
     * @param array $args
     * @return a Message containing the Places
     */
    public static function getPlacesBySlot($slot){
        global $crud;
        
        $sql = "SELECT * FROM Place WHERE IsArchived = 0 AND SlotNo = ".$slot->getNo();
        
        $data = $crud->getRows($sql);
        
        if ($data){
            $places = array();
            
            foreach ($data as $row){
                $argsPlace = array (
                    'no'                => $row['No'],
                    'slotNo'            => $row['SlotNo'],
                    'slotEventNo'       => $row['SlotEventNo'],
                    'speakerPersonNo'   => $row['SpeakerPersonNo'],
                    'isArchived'        => $row['IsArchived']
                );

                $places[] = new Place($argsPlace);
            } // End foreach
            
            $argsMessage = array(
                'messageNumber'     => 159,
                'message'           => 'All Places by Slot selected',
                'status'            => true,
                'content'           => $places
            );
            $return = new Message($argsMessage);
            
        } else {
            $argsMessage = array(
                'messageNumber'     => 160,
                'message'           => 'Error while SELECT * FROM Place',
                'status'            => false,
                'content'           => NULL
            );
            $return = new Message($argsMessage);
        }
        return $return;
    } // END     
    
    
    /**
     * Adds a new Place in database
     * @param array of args
     * @return a Message containing the created Place
     */
    public static function addPlace($args){
        $slot = $args['slot'];
        $speaker = $args['speaker'];
        $no = $args['no'];
        
        // Validate Speaker
        $messageValidateSpeaker = FSSpeaker::getSpeaker($speaker->getNo());
        
        if($messageValidateSpeaker->getStatus()){

            // Validate Slot
            $event = FSEvent::getEvent($slot->getEventNo())->getContent();

            $argsGetSlot = array (
                'no'    => $no,
                'event' => $event
            );
            $messageValidateSlot = FSSlot::getSlot($argsGetSlot);
            
            if($messageValidateSlot->getStatus()){
                // Validate non existing Place
                $messageValidatePlace = FSPlace::getPlace($args);
                
                if(!$messageValidatePlace->getStatus()){
                    // Create new Place
                    $messageCreatePlace = FSPlace::createPlace($args);
                    
                    $return = $messageCreatePlace;
                } else {
                    $argsMessage = array(
                        'messageNumber'     => 173,
                        'message'           => 'Existant Place !',
                        'status'            => false,
                        'content'           => null
                    );
                    $return = new Message($argsMessage);
                }
            } else {
                $return = $messageValidateSlot;
            }
        } else {
            $return = $messageValidateSpeaker;
        }
        
        return $return;
        
    }
    
    /**
     * Adds a new Place in database
     * @param array of args
     * @return a Message containing the created Place
     */
    public static function createPlace($args){
        global $crud;
        $slot = $args['slot'];
        $speaker = $args['speaker'];
        $no = $args['no'];
        
        $sql = "INSERT INTO Place (No, SlotNo, SlotEventNo, SpeakerPersonNo) VALUES (
            $no,
            ".$slot->getNo().",
            ".$slot->getEventNo().",
            ".$speaker->getNo()."            
        );";
        
        $createdPlaceId = $crud->insertReturnLastId($sql);
        
        if($createdPlaceId){
            $messageCreatedPlace = FSPlace::getPlace($args);
            
            if($messageCreatedPlace->getStatus()){
                $createdPlace = $messageCreatedPlace->getContent();
                $argsMessage = array(
                    'messageNumber'     => 171,
                    'message'           => 'New Place created !',
                    'status'            => true,
                    'content'           => $createdPlace
                );
                $return = new Message($argsMessage);
            
            } 
            
        } else {
                $argsMessage = array(
                    'messageNumber'     => 172,
                    'message'           => 'Error while inserting new Place',
                    'status'            => false,
                    'content'           => null
                );
                $return = new Message($argsMessage);
        }
        return $return;        
    }
    
    /**
     * Set Place
     * @param array of args
     * @return a Message containing the created Place
     */
    public static function setPlace($aPlaceToSet){
        global $crud;
            $sql = "UPDATE  Place SET  
                IsArchived = " . $aPlaceToSet->getIsArchived() . "
                WHERE  Place.No = " . $aPlaceToSet->getNo() . "
                 AND Place.SlotNo = " . $aPlaceToSet->getSlotNo() . "
                 AND Place.SlotEventNo = " . $aPlaceToSet->getSlotEventNo() . "
                 AND Place.SpeakerPersonNo = " . $aPlaceToSet->getSpeakerPersonNo();
 
            if ($crud->exec($sql) == 1) {
                $sql = "SELECT * FROM Place 
                    WHERE  Place.No = " . $aPlaceToSet->getNo() . "
                 AND Place.SlotNo = " . $aPlaceToSet->getSlotNo() . "
                 AND Place.SlotEventNo = " . $aPlaceToSet->getSlotEventNo() . "
                 AND Place.SpeakerPersonNo = " . $aPlaceToSet->getSpeakerPersonNo(). "
                 AND Place.IsArchived = " . $aPlaceToSet->getIsArchived();
                $data = $crud->getRow($sql);

                $argsPlace = array(
                    'text' => $aPlaceToSet->getText(),
                    'eventNo' => $aPlaceToSet->getEventNo(),
                    'participantPersonNo' => $aPlaceToSet->getParticipantPersonNo(),
                    'isArchived' => $aPlaceToSet->getIsArchived()
                );
 
                $aSetPlace = new Place($argsPlace);

                $argsMessage = array(
                    'messageNumber' => 000,
                    'message' => 'Place set !',
                    'status' => true,
                    'content' => $aSetPlace
                );
                $message = new Message($argsMessage);
            } else {
                $argsMessage = array(
                    'messageNumber' => 000,
                    'message' => 'Error while setting new Place',
                    'status' => false,
                    'content' => NULL
                );
                $message = new Message($argsMessage);
            }
        return $message;
    }
}
?>
