<?php
require_once(APP_DIR . '/core/model/Slot.class.php');
require_once(APP_DIR . '/core/model/Message.class.php');

/**
 * Description of FSSlot
 *
 * @author Lauric Francelet
 */
class FSSlot {
    /**
     * The constructor that does nothing
     */
    public function __construct() {
        // Nothing
    }
    
    /**
     * Returns a Message containing a Slot 
     * @param type $args A Slot No and an Event
     * @return Message containing the Slot
     */
    public static function getSlot($args){
        global $crud;
        $slot = NULL;
        $event = $args['event'];
        $return = NULL;
        
        $sql = "SELECT * FROM Slot WHERE No = ".$args['no']." AND EventNo = ". $event->getNo();
        $data = $crud->getRow($sql);
        
        
        if($data){
            $argsSlot = array(
                'no'            => $data['No'],
                'eventNo'       => $data['EventNo'],
                'happeningDate' => $data['HappeningDate'],
                'startingTime'  => $data['StartingTime'],
                'endingTime'    => $data['EndingTime'],
                'isArchived'    => $data['IsArchived'],
            );
            
            $slot = new Slot($argsSlot);
            
            $argsMessage = array(
                'messageNumber' => 115,
                'message'       => 'Existant Slot',
                'status'        => true,
                'content'       => $slot
            );
            $return = new Message($argsMessage);
        } else {
            $argsMessage = array(
                'messageNumber' => 116,
                'message'       => 'Inexistant Slot',
                'status'        => false,
                'content'       => NULL
            );
            $return = new Message($argsMessage);
        }
        
        return $return;
    }
    
    /**
     * Returns all the Slots of a given Event
     * @param an Event
     * @return a Message conainting an array of Slots
     */
    public static function getSlotsByEvent($event){
        global $crud;
        
        $sql = "SELECT * FROM Slot WHERE EventNo = ".$event->getNo();
        $data = $crud->getRows($sql);
        
        if ($data){
            $slots = array();

            foreach($data as $row){
                $argsSlot = array(
                    'no'            => $row['No'],
                    'eventNo'       => $row['EventNo'],
                    'happeningDate' => $row['HappeningDate'],
                    'startingTime'  => $row['StartingTime'],
                    'endingTime'    => $row['EndingTime'],
                    'isArchived'    => $row['IsArchived'],
                );
            
                $slots[] = new Slot($argsSlot);
            } //foreach

            $argsMessage = array(
                'messageNumber' => 117,
                'message'       => 'All Slots for an Event selected',
                'status'        => true,
                'content'       => $slots
            );
            
            $return = new Message($argsMessage);

        } else {
            $argsMessage = array(
                'messageNumber' => 118,
                'message'       => 'Error while SELECT * FROM Slots WHERE ...',
                'status'        => false,
                'content'       => NULL
            );
            
            $return = new Message($argsMessage);

        }
        
        return $return;
    }
    
    /**
     * Returns all the Slots
     * @return a Message conainting an array of Slots
     */
    public static function getSlots(){
        global $crud;
        
        $sql = "SELECT * FROM Slot";
        $data = $crud->getRows($sql);
        
        if ($data){
            $slots = array();

            foreach($data as $row){
                $argsSlot = array(
                    'no'            => $row['No'],
                    'eventNo'       => $row['EventNo'],
                    'happeningDate' => $row['HappeningDate'],
                    'startingTime'  => $row['StartingTime'],
                    'endingTime'    => $row['EndingTime'],
                    'isArchived'    => $row['IsArchived'],
                );
            
                $slots[] = new Slot($argsSlot);
            } //foreach

            $argsMessage = array(
                'messageNumber' => 119,
                'message'       => 'All Slots selected',
                'status'        => true,
                'content'       => $slots
            );
            
            $return = new Message($argsMessage);

        } else {
            $argsMessage = array(
                'messageNumber' => 120,
                'message'       => 'Error while SELECT * FROM Slots',
                'status'        => false,
                'content'       => NULL
            );
            
            $return = new Message($argsMessage);

        }
        
        return $return;
    } 
    

    public static function addSlot($args){
        global $crud;
        $return = null;
        $event = $args['event'];
        
        // Validate Event
        $aValidEvent = FSEvent::getEvent($event->getNo());
                
        if($aValidEvent->getStatus()){
            
            // Validate Slot
            $messageInexistantSlot = FSSlot::getSlot($args);
            
            if (!$messageInexistantSlot->getStatus()){
                    
                    // Create new Slot
                    $sql = "INSERT INTO `Slot` (`EventNo`, `HappeningDate`, `StartingTime`, `EndingTime`) VALUES (
                        ".$event->getNo().", 
                        '".$args['happeningDate']."',
                        '".$args['startingTime']."',
                        '".$args['endingTime']."',  
                    );";
                    
                    if($crud->exec($sql) != 0){
                        echo "New Slot created !";
                        
                        // Get created Membership
                        $messageCreatedSlot = FSSlot::getSlot($args);

                        $argsMessage = array(
                            'messageNumber' => 134,
                            'message'       => 'New Slot added !',
                            'status'        => true,
                            'content'       => $messageCreatedSlot->getContent()
                        );
                        $return = new Message($argsMessage);
                        
                    } else {
                        $argsMessage = array(
                            'messageNumber' => 135,
                            'message'       => 'Error while inserting new Slot',
                            'status'        => false,
                            'content'       => NULL
                        );
                        $return = new Message($argsMessage);
                    }
                } // End Create new Membership
                
        } else {
            $argsMessage = array(
                'messageNumber' => 133,
                'message'       => 'No valid Event found',
                'status'        => FALSE,
                'content'       => null
            );
            
            $return = new Message($argsMessage);            
        }
        
        return $return;
    } // END addSlot()
    
}

?>
