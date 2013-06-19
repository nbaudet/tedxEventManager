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
        $slotNo = $args['slotNo'];
        $slotEventNo = $args['slotEventNo'];
        $speakerPersonNo = $args['speakerPersonNo'];
        
        $sql = "SELECT * FROM Place WHERE No = $no AND SlotNo = $slotNo AND 
        SlotEventNo = $slotEventNo AND SpeakerPersonNo = $speakerPersonNo AND IsArchived = 0";
        
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
}
?>
