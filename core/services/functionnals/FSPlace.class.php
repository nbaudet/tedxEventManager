<?php

/*
 * Description of FSPlace
 * 
 * Author Lauric F
 */
require_once(APP_DIR . '/core/model/Place.class.php');


class Place {
    
    /**
     * 
     * @param int $no a placeNo
     */
    public static function getPlace($args){
        $place = NULL;
        global $crud;
        
        $no = $args['placeNo'];
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
    }
}
?>
