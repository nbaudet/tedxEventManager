<?php

/**
 * Description of FSEvent
 *
 * @author Lauric Francelet
 */
require_once(APP_DIR . '/core/model/Event.class.php');
require_once(APP_DIR . '/core/model/Speaker.class.php');
require_once(APP_DIR . '/core/model/Message.class.php');
require_once(APP_DIR . '/core/model/Slot.class.php');

class FSEvent {

    /**
     * Returns a Event with the given No as Id.
     * @param int $no The Id of the Event
     * @return a Message containing an existant Event
     */
    public static function getEvent($no) {
        $event = NULL;

        global $crud;

        $sql = "SELECT * FROM Event WHERE No = $no";
        $data = $crud->getRow($sql);

        if ($data) {
            $argsEvent = array(
                'no' => $data['No'],
                'mainTopic' => $data['MainTopic'],
                'locationName' => $data['LocationName'],
                'description' => $data['Description'],
                'startingDate' => $data['StartingDate'],
                'endingDate' => $data['EndingDate'],
                'startingTime' => $data['StartingTime'],
                'endingTime' => $data['EndingTime'],
                'isArchived' => $data['IsArchived']
            );

            $event = new Event($argsEvent);

            $argsMessage = array(
                'messageNumber' => 211,
                'message' => 'Existant Event',
                'status' => true,
                'content' => $event
            );
            $message = new Message($argsMessage);
            return $message;
        } else {
            $argsMessage = array(
                'messageNumber' => 212,
                'message' => 'Inexistant Event',
                'status' => false,
                'content' => NULL
            );
            $message = new Message($argsMessage);
            return $message;
        } // else
    }

// function

    /**
     * Returns all the Events of the database
     * @return A Message containing an array of Events
     */
    public static function getEvents() {
        global $crud;

        $sql = "SELECT * FROM Event WHERE IsArchived = 0;";
        $data = $crud->getRows($sql);

        if ($data) {
            $events = array();

            foreach ($data as $row) {
                $argsEvent = array(
                    'no' => $row['No'],
                    'mainTopic' => $row['MainTopic'],
                    'locationName' => $row['LocationName'],
                    'description' => $row['Description'],
                    'startingDate' => $row['StartingDate'],
                    'endingDate' => $row['EndingDate'],
                    'startingTime' => $row['StartingTime'],
                    'endingTime' => $row['EndingTime'],
                    'isArchived' => $row['IsArchived']
                );

                $events[] = new Event($argsEvent);
            } //foreach

            $argsMessage = array(
                'messageNumber' => 213,
                'message' => 'All Events selected',
                'status' => true,
                'content' => $events
            );
            $return = new Message($argsMessage);
        } else {
            $argsMessage = array(
                'messageNumber' => 214,
                'message' => 'Error while SELECT * FROM event WHERE IsArchived = 0',
                'status' => false,
                'content' => NULL
            );
            $return = new Message($argsMessage);
        }// else

        return $return;
    }

// function

    /**
     * Add a new Event in Database
     * @param $args Parameters of a Event
     * @return a Message containing the new Event and its Slots
     */
    public static function addEvent($args) {
        $eventArgs = $args['event'];
        $slotsArgs = $args['slots'];
        $slots = array();

        $messageCreateEvent = FSEvent::createEvent($eventArgs);

        if ($messageCreateEvent->getStatus()) {
            $aCreatedEvent = $messageCreateEvent->getContent();

            foreach ($slotsArgs as $slot) {
                $argsSlot = array(
                    'event' => $aCreatedEvent,
                    'happeningDate' => $slot['happeningDate'],
                    'startingTime' => $slot['startingTime'],
                    'endingTime' => $slot['endingTime'],
                );

                $messageCreateSlot = FSSlot::addSlot($argsSlot);

                if ($messageCreateSlot->getStatus()) {
                    $slots[] = $messageCreateSlot->getContent();
                } else {
                    $return = $messageCreateSlot;
                }
            } //foreach

            $contentArray = array($aCreatedEvent, $slots);

            $argsMessage = array(
                'messageNumber' => 161,
                'message' => 'New Event created !',
                'status' => true,
                'content' => $contentArray
            );
            $return = new Message($argsMessage);
        } else {
            $argsMessage = array(
                'messageNumber' => 216,
                'message' => 'Error while inserting new Event',
                'status' => false,
                'content' => NULL
            );
            $return = new Message($argsMessage);
        }
        return $return;
    }

// END addEvent

    /**
     * Adds a new Event in Database
     * @param array $args
     * @return a Message containing the created Event
     */
    public static function createEvent($args) {
        global $crud;

        if (isset($args['locationName'])) {
            $sql = "INSERT INTO Event (MainTopic, Description, StartingDate, EndingDate,
            StartingTime, EndingTime, LocationName) VALUES (
                '" . addslashes($args['mainTopic']) . "',
                '" . addslashes($args['description']) . "', 
                '" . $args['startingDate'] . "',
                '" . $args['endingDate'] . "', 
                '" . $args['startingTime'] . "', 
                '" . $args['endingTime'] . "',
                '" . $args['locationName'] . "'
        );";
        } else {
            $sql = "INSERT INTO Event (MainTopic, Description, StartingDate, EndingDate,
                StartingTime, EndingTime) VALUES (
                '" . addslashes($args['mainTopic']) . "',
                '" . addslashes($args['description']) . "', 
                '" . $args['startingDate'] . "',
                '" . $args['endingDate'] . "', 
                '" . $args['startingTime'] . "', 
                '" . $args['endingTime'] . "'
            );";
        }

        $createdEventId = $crud->insertReturnLastId($sql);

        if ($createdEventId) {

            $sql = "SELECT * FROM Event WHERE No = $createdEventId";

            $data = $crud->getRow($sql);

            $argsEvent = array(
                'no' => $data['No'],
                'mainTopic' => $data['MainTopic'],
                'locationName' => $data['LocationName'],
                'description' => $data['Description'],
                'startingDate' => $data['StartingDate'],
                'endingDate' => $data['EndingDate'],
                'startingTime' => $data['StartingTime'],
                'endingTime' => $data['EndingTime'],
                'locationName' => $data['LocationName'],
                'isArchived' => $data['IsArchived']
            );

            $event = new Event($argsEvent);

            $argsMessage = array(
                'messageNumber' => 215,
                'message' => 'New Event added !',
                'status' => true,
                'content' => $event
            );
            $return = new Message($argsMessage);
        } else {
            $argsMessage = array(
                'messageNumber' => 216,
                'message' => 'Error while inserting new Event',
                'status' => false,
                'content' => NULL
            );
            $return = new Message($argsMessage);
        }// else
        return $return;
    }

// END createEvent

    /**
     * Search events with args
     * @param type $args
     * @return type message 
     */
    public static function searchEvents($args) {
        global $crud;

        // return value
        $message;

        // if args are supplied
        if (isset($args['where'])) {
            $where = $args['where'];

            // optional args
            if (isset($args['orderBy'])) {
                $orderBy = 'ORDER BY ' . $args['orderBy'];
                if (isset($args['orderByType']))
                    $orderBy .= ' ' . $args['orderByType'];
            }else {
                $orderBy = '';
            };
            // SQL statement
            $sql = "SELECT * From Event WHERE $where AND isArchived = 0 $orderBy";

            // exec query
            $data = $crud->getRows($sql);

            // if query returned results
            if ($data) {

                $events = array();

                // make object for each row
                foreach ($data as $row) {
                    $argsEvent = array(
                        'no' => $row['No'],
                        'mainTopic' => $row['MainTopic'],
                        'locationName' => $row['LocationName'],
                        'description' => $row['Description'],
                        'startingDate' => $row['StartingDate'],
                        'endingDate' => $row['EndingDate'],
                        'startingTime' => $row['StartingTime'],
                        'endingTime' => $row['EndingTime'],
                        'isArchived' => $row['IsArchived']
                    );

                    $events[] = new Event($argsEvent);
                } //foreach


                $argsMessage = array(
                    'messageNumber' => 500,
                    'message' => 'Events Founds',
                    'status' => true,
                    'content' => $events
                );
                $message = new Message($argsMessage);
            } else {
                $argsMessage = array(
                    'messageNumber' => 501,
                    'message' => 'Event not found',
                    'status' => false,
                    'content' => NULL
                );
                $message = new Message($argsMessage);
            }// else
        }// if
        else {
            // By default, search all events
            $messageEvents = self::getEvents();
            // if events founds
            if ($messageEvents->getStatus()) {
                $argsMessage = array(
                    'messageNumber' => 500,
                    'message' => 'Events Founds',
                    'status' => true,
                    'content' => $messageEvents->getContent()
                );
                $message = new Message($argsMessage);
            }// if
            else {
                // events not found
                $message = $messageEvents;
            }// else
        }// else
        // return message
        return $message;
    }

// function

    /**
     * Set new parameters to a Motivation
     * @param Motivation $aMotivationToSet
     * @return Message containing the set Motivation */
    public static function setEvent($anEventToSet) {
        global $crud;

        $aValideEvent = FSEvent::getEvent($anEventToSet->getNo());
        $aValideLocation = FSLocation::getLocation($anEventToSet->getLocationName());
        //If Event valide
        if ($aValideEvent->getStatus()) {
            //If there is a Location Name given
            if (($anEventToSet->getLocationName())) {
                //If this Location is valide
                if ($aValideLocation->getStatus()) {
                    $sql = "UPDATE  Event SET  
                     MainTopic = '" . addslashes($anEventToSet->getMainTopic()) . "',
                     Description = '" . addslashes($anEventToSet->getDescription()) . "',
                     StartingDate = '" . $anEventToSet->getStartingDate() . "',
                     EndingDate = '" . $anEventToSet->getEndingDate() . "',
                     StartingTime = '" . $anEventToSet->getStartingTime() . "',
                     EndingTime = '" . $anEventToSet->getEndingTime() . "',
                     IsArchived = '" . $anEventToSet->getIsArchived() . "',
                     LocationName = '" . addslashes($anEventToSet->getLocationName()) . "'
                     WHERE  Event.No = " . $anEventToSet->getNo();
                } else {
                    $argsMessage = array(
                        'messageNumber' => 234,
                        'message' => 'Inexistant Location',
                        'status' => false,
                        'content' => NULL
                    );
                    $message = new Message($argsMessage);
                    return $message;
                };
            } else {
                $sql = "UPDATE  Event SET  
                 MainTopic = '" . $anEventToSet->getMainTopic() . "',
                 Description = '" . $anEventToSet->getDescription() . "',
                 StartingDate = '" . $anEventToSet->getStartingDate() . "',
                 EndingDate = '" . $anEventToSet->getEndingDate() . "',
                 StartingTime = '" . $anEventToSet->getStartingTime() . "',
                 EndingTime = '" . $anEventToSet->getEndingTime() . "',
                 IsArchived = '" . $anEventToSet->getIsArchived() . "'
                 WHERE  Event.No = " . $anEventToSet->getNo();
            }

            //If query OK
            if ($crud->exec($sql) == 1) {
                $sql = "SELECT * FROM Event 
                         WHERE No = " . $anEventToSet->getNo();

                $data = $crud->getRow($sql);

                if ($anEventToSet->getLocationName()) {
                    $argsMotivation = array(
                        'no' => $anEventToSet->getNo(),
                        'mainTopic' => $anEventToSet->getMainTopic(),
                        'locationName' => $anEventToSet->getLocationName(),
                        'description' => $anEventToSet->getDescription(),
                        'startingDate' => $anEventToSet->getStartingDate(),
                        'endingDate' => $anEventToSet->getEndingDate(),
                        'startingTime' => $anEventToSet->getStartingTime(),
                        'endingTime' => $anEventToSet->getEndingTime(),
                        'isArchived' => $anEventToSet->getIsArchived()
                    );
                } else {
                    $argsMotivation = array(
                        'no' => $anEventToSet->getNo(),
                        'mainTopic' => $anEventToSet->getMainTopic(),
                        'description' => $anEventToSet->getDescription(),
                        'startingDate' => $anEventToSet->getStartingDate(),
                        'endingDate' => $anEventToSet->getEndingDate(),
                        'startingTime' => $anEventToSet->getStartingTime(),
                        'endingTime' => $anEventToSet->getEndingTime(),
                        'isArchived' => $anEventToSet->getIsArchived()
                    );
                };

                $aSetEvent = new Event($argsMotivation);

                $argsMessage = array(
                    'messageNumber' => 232,
                    'message' => 'Event set !',
                    'status' => true,
                    'content' => $aSetEvent
                );
                $message = new Message($argsMessage);
            } else {
                $argsMessage = array(
                    'messageNumber' => 233,
                    'message' => 'Error while setting new Event',
                    'status' => false,
                    'content' => NULL
                );
                $message = new Message($argsMessage);
            }//End query ok  
        } else {
            $argsMessage = array(
                'messageNumber' => 235,
                'message' => 'Inexistant Event',
                'status' => false,
                'content' => NULL
            );
            $message = new Message($argsMessage);
        }//End Event valide
        return $message;
    }

}

// class
?>