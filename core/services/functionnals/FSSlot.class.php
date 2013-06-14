<?php
require_once(APP_DIR . '/core/model/Slot.class.php');
require_once(APP_DIR . '/core/model/Event.class.php');
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
        
        $sql = "SELECT * FROM Slot WHERE No = ".$args['no']." AND EventNo = ". $event;
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
    
    /*
    public static function addSlot($args){
        global $crud;
        $return = null;
        $event = $args['event'];
        

        // Validate Member
        $aValidMember = FSMember::getMember($member->getId());
        
        $messageValidEvent = 
        
        if($aValidMember->getStatus()){
            
            // Validate Unit
            $aValidUnit = FSUnit::getUnit($unit->getNo());
            
            if ($aValidUnit->getStatus()){
                
                // Validate Membership
                $anInexistantMembership = FSMembership::getMembership($args);
                
                if(!$anInexistantMembership->getStatus()){
                    
                    // Create new Membership
                    $sql = "INSERT INTO `Membership` (`MemberID` ,`UnitNo`) VALUES (
                        '".$member->getId()."', 
                        '".$unit->getNo()."'
                    );";
                    
                    if($crud->exec($sql) != 0){
                        echo "New Membership created !";
                        
                        // Get created Membership
                        $aCreatedMembership = FSMembership::getMembership($args);

                        $argsMessage = array(
                            'messageNumber' => 111,
                            'message'       => 'New Membership added !',
                            'status'        => true,
                            'content'       => $aCreatedMembership
                        );
                        $return = new Message($argsMessage);
                        
                        
                    } else {
                        $argsMessage = array(
                            'messageNumber' => 112,
                            'message'       => 'Error while inserting new Membership',
                            'status'        => false,
                            'content'       => NULL
                        );
                        $return = new Message($argsMessage);
                    }
                    
                } // End Create new Membership
                else {
                    $argsMessage = array(
                        'messageNumber' => 114,
                        'message'       => 'Membership already existant !',
                        'status'        => FALSE,
                        'content'       => null
                    );

                $return = new Message($argsMessage);
                }
                
            } else {
                $argsMessage = array(
                    'messageNumber' => 114,
                    'message'       => 'No matching Unit found',
                    'status'        => FALSE,
                    'content'       => null
                );
            
            $return = new Message($argsMessage);
            }
            
        } else {
            $argsMessage = array(
                'messageNumber' => 113,
                'message'       => 'No matching Member found',
                'status'        => FALSE,
                'content'       => null
            );
            
            $return = new Message($argsMessage);
            
        }
        
        return $return;
        
    }*/
    
}

?>
