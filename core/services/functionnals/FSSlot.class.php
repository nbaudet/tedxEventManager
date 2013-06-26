<?php

require_once(APP_DIR . '/core/model/Slot.class.php');
require_once(APP_DIR . '/core/model/Event.class.php');
require_once(APP_DIR . '/core/model/Message.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSEvent.class.php');

/**
 * FSSlot.class.php
 * 
 * Author : Lauric Francelet
 * Date : 25.06.2013
 * 
 * Description : define the class FSSlot as definited in the model
 * 
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
    public static function getSlot($args) {
        global $crud;
        $no = $args['no'];
        $slot = NULL;
        $event = $args['event'];
        $return = NULL;

        //If Event not empty
        if (isset($event)) {
            $eventNo = $event->getNo();
            $aValideEvent = FSEvent::getEvent($eventNo);
            //If Valid Event
            if ($aValideEvent->getStatus()) {
                if (isset($no)) {
                    $sql = "SELECT * FROM Slot WHERE No = $no AND EventNo = " . $event->getNo() . " AND IsArchived = 0";

                    $data = $crud->getRow($sql);

                    if ($data) {
                        $argsSlot = array(
                            'no' => $data['No'],
                            'eventNo' => $data['EventNo'],
                            'happeningDate' => $data['HappeningDate'],
                            'startingTime' => $data['StartingTime'],
                            'endingTime' => $data['EndingTime'],
                            'isArchived' => $data['IsArchived'],
                        );

                        $slot = new Slot($argsSlot);

                        $argsMessage = array(
                            'messageNumber' => 115,
                            'message' => 'Existant Slot',
                            'status' => true,
                            'content' => $slot
                        );
                        $return = new Message($argsMessage);
                    } else {
                        $argsMessage = array(
                            'messageNumber' => 116,
                            'message' => 'Inexistant Slot',
                            'status' => false,
                            'content' => NULL
                        );
                        $return = new Message($argsMessage);
                    }
                } else {
                    $argsMessage = array(
                        'messageNumber' => 134,
                        'message' => 'Empty slot no',
                        'status' => false,
                        'content' => NULL
                    );
                    $return = new Message($argsMessage);
                }
            } else {
                $argsMessage = array(
                    'messageNumber' => 134,
                    'message' => 'Not Valid Event',
                    'status' => false,
                    'content' => NULL
                );
                $return = new Message($argsMessage);
            }
        } else {
            $argsMessage = array(
                'messageNumber' => 134,
                'message' => 'Inexistant Event',
                'status' => false,
                'content' => NULL
            );
            $return = new Message($argsMessage);
        }

        return $return;
    }

//function

    /**
     * Returns all the Slots of a given Event
     * @param an Event
     * @return a Message conainting an array of Slots
     */
    public static function getSlotsByEvent($event) {
        global $crud;

        $sql = "SELECT * FROM Slot WHERE EventNo = " . $event->getNo() . " AND IsArchived = 0";
        $data = $crud->getRows($sql);

        if ($data) {
            $slots = array();

            foreach ($data as $row) {
                $argsSlot = array(
                    'no' => $row['No'],
                    'eventNo' => $row['EventNo'],
                    'happeningDate' => $row['HappeningDate'],
                    'startingTime' => $row['StartingTime'],
                    'endingTime' => $row['EndingTime'],
                    'isArchived' => $row['IsArchived'],
                );

                $slots[] = new Slot($argsSlot);
            } //foreach

            $argsMessage = array(
                'messageNumber' => 117,
                'message' => 'All Slots for an Event selected',
                'status' => true,
                'content' => $slots
            );

            $return = new Message($argsMessage);
        } else {
            $argsMessage = array(
                'messageNumber' => 118,
                'message' => 'Error while SELECT * FROM Slots WHERE ...',
                'status' => false,
                'content' => NULL
            );

            $return = new Message($argsMessage);
        }

        return $return;
    }

//function

    /**
     * Returns all the Slots
     * @return a Message conainting an array of Slots
     */
    public static function getSlots() {
        global $crud;

        $sql = "SELECT * FROM Slot WHERE IsArchived = 0;";

        $data = $crud->getRows($sql);

        if ($data) {
            $slots = array();

            foreach ($data as $row) {
                $argsSlot = array(
                    'no' => $row['No'],
                    'eventNo' => $row['EventNo'],
                    'happeningDate' => $row['HappeningDate'],
                    'startingTime' => $row['StartingTime'],
                    'endingTime' => $row['EndingTime'],
                    'isArchived' => $row['IsArchived'],
                );

                $slots[] = new Slot($argsSlot);
            } //foreach

            $argsMessage = array(
                'messageNumber' => 119,
                'message' => 'All Slots selected',
                'status' => true,
                'content' => $slots
            );

            $return = new Message($argsMessage);
        } else {
            $argsMessage = array(
                'messageNumber' => 120,
                'message' => 'Error while SELECT * FROM Slots',
                'status' => false,
                'content' => NULL
            );

            $return = new Message($argsMessage);
        }

        return $return;
    }

//function

    /**
     * Adds a new Slot in Database
     * @param type $args
     * @return Message containing the created Slot
     */
    public static function addSlot($args) {
        global $crud;
        $return = null;
        $event = $args['event'];

        // Validate Event
        $aValidEvent = FSEvent::getEvent($event->getNo());

        if ($aValidEvent->getStatus()) {

            // Create new Slot
            $sql = "INSERT INTO `Slot` (`EventNo`, `HappeningDate`, `StartingTime`, `EndingTime`) VALUES (
                " . $event->getNo() . ", 
                '" . $args['happeningDate'] . "',
                '" . $args['startingTime'] . "',
                '" . $args['endingTime'] . "' 
            );";

            $idSlot = $crud->insertReturnLastId($sql);

            if ($idSlot != FALSE) {

                // Get created Membership
                $argsSlot = array(
                    'no' => $idSlot,
                    'event' => $event
                );

                $messageCreatedSlot = FSSlot::getSlot($argsSlot);

                $argsMessage = array(
                    'messageNumber' => 134,
                    'message' => 'New Slot added !',
                    'status' => true,
                    'content' => $messageCreatedSlot->getContent()
                );
                $return = new Message($argsMessage);
            } else {
                $argsMessage = array(
                    'messageNumber' => 135,
                    'message' => 'Error while inserting new Slot',
                    'status' => false,
                    'content' => NULL
                );
                $return = new Message($argsMessage);
            } // END Create Slot
        } else {
            $argsMessage = array(
                'messageNumber' => 133,
                'message' => 'No valid Event found',
                'status' => FALSE,
                'content' => null
            );

            $return = new Message($argsMessage);
        }

        return $return;
    }

//function

    /**
     * Set new parameters to a Slot
     * @param Slot $aSlotToSet
     * @return Message containing the setted Slot
     */
    public static function setSlot($aSlotToSet) {
        global $crud;
        $messageValidEvent = FSEvent::getEvent($aSlotToSet->getEventNo());
        if ($messageValidEvent->getStatus()) {
            $aValidEvent = $messageValidEvent->getContent();
            $argsSlot = array('no' => $aSlotToSet->getNo(), 'event' => $aValidEvent);
            $messageValidSlot = self::getSlot($argsSlot);
            if ($messageValidSlot->getStatus()) {
                $aValidSlot = $messageValidSlot->getContent();
                $sql = "UPDATE  Slot SET  
                    HappeningDate =     '" . $aSlotToSet->getHappeningDate() . "',
                    StartingTime =   '" . $aSlotToSet->getStartingTime() . "',
                    EndingTime =       '" . $aSlotToSet->getEndingTime() . "',
                    IsArchived =    '" . $aSlotToSet->getIsArchived() . "'
                    WHERE  Slot.No = " . $aValidSlot->getNo() . "
                    AND Slot.EventNo = " . $aValidEvent->getNo();

                if ($crud->exec($sql) == 1) {

                    $aSettedSlot = FSSlot::getSlot($argsSlot)->getContent();

                    $argsMessage = array(
                        'messageNumber' => 453,
                        'message' => 'Slot setted !',
                        'status' => true,
                        'content' => $aSettedSlot
                    );
                    $message = new Message($argsMessage);
                } else {
                    $argsMessage = array(
                        'messageNumber' => 454,
                        'message' => 'Error while setting Slot',
                        'status' => false,
                        'content' => NULL
                    );
                    $message = new Message($argsMessage);
                }
            } else {
                $message = $messageValidSlot;
            }
        } else {
            $message = $messageValidEvent;
        }
        return $message;
    }

//function
}

//class
?>
