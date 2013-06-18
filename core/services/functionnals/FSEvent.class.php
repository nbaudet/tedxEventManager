<?php
/**
 * Description of FSEvent
 *
 * @author Lauric Francelet
 */

require_once(APP_DIR . '/core/model/Event.class.php');
require_once(APP_DIR . '/core/model/Message.class.php');


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
        
        if($data){
            $argsEvent = array(
                'no'            => $data['No'],
                'mainTopic'     => $data['MainTopic'],
                'startingDate'  => $data['StartingDate'],
                'endingDate'    => $data['EndingDate'],
                'startingTime'  => $data['StartingTime'],
                'endingTime'    => $data['EndingTime'],
                'description'   => $data['Description'],
                'isArchived'    => $data['IsArchived']
            );
            
            $event = new Event($argsEvent);
            
            $argsMessage = array(
                'messageNumber' => 211,
                'message'       => 'Existant Event',
                'status'        => true,
                'content'       => $event
            );
            $message = new Message($argsMessage);
            return $message;
        } else {
            $argsMessage = array(
                'messageNumber' => 212,
                'message'       => 'Inexistant Event',
                'status'        => false,
                'content'       => NULL
            );
            $message = new Message($argsMessage);
            return $message;
        } // else
    }// function
    
    /**
     * Returns all the Events of the database
     * @return A Message containing an array of Events
     */
    public static function getEvents(){
        global $crud;
        
        $sql = "SELECT * FROM Event WHERE IsArchived = 0;";
        $data = $crud->getRows($sql);
        
        if ($data){
            $events = array();

            foreach($data as $row){
                $argsEvent = array(
                    'no'           => $row['No'],
                    'mainTopic'    => $row['MainTopic'],
                    'startingDate' => $row['StartingDate'],
                    'endingDate'   => $row['EndingDate'],
                    'startingTime' => $row['StartingTime'],
                    'endingTime'   => $row['EndingTime'],
                    'description'  => $row['Description'],
                    'isArchived'   => $row['IsArchived']
                );
            
                $events[] = new Event($argsEvent);
            } //foreach

            $argsMessage = array(
                'messageNumber' => 213,
                'message'       => 'All Events selected',
                'status'        => true,
                'content'       => $events
            );
            $message = new Message($argsMessage);

            return $message;
        } else {
            $argsMessage = array(
                'messageNumber' => 214,
                'message'       => 'Error while SELECT * FROM event WHERE IsArchived = 0',
                'status'        => false,
                'content'       => NULL
            );
            $message = new Message($argsMessage);

            return $message;
        }// else
    }// function
    
    /**
     * Add a new Event in Database
     * @param $args Parameters of a Event
     * @return a Message containing the new Event
     */
    public static function addEvent($args){
        global $crud;
        

        $sql = "INSERT INTO Event (MainTopic, Description, StartingDate, EndingDate, StartingTime, EndingTime) VALUES ('".addslashes($args['mainTopic'])."', '".addslashes($args['description'])."', '".$args['startingDate']."', '".$args['endingDate']."', '".$args['startingTime']."', '".$args['endingTime']."');";

        
        if($crud->exec($sql) == 1){
            
            $sql = "SELECT * FROM Event ORDER BY No DESC LIMIT 0,1;";
            $data = $crud->exec($sql);
            
            $argsEvent = array(

                'no'           =>$data['No'],
                'mainTopic'    => $data['MainTopic'],
                'description'  => $data['Description'],
                'startingDate' => $data['StartingDate'],
                'endingDate'   => $data['EndingDate'],
                'startingTime' => $data['StartingTime'],
                'endingTime'   => $data['EndingTime'],
                'isArchived'   => $data['IsArchived']
            );
            
            $event = new Event($argsEvent);
            
            $argsMessage = array(
                'messageNumber' => 215,
                'message'       => 'New Event added !',
                'status'        => true,
                'content'       => $event
            );
            $message = new Message($argsMessage);
            return $message;
        } else {
            $argsMessage = array(
                'messageNumber' => 216,
                'message'       => 'Error while inserting new Event',
                'status'        => false,
                'content'       => NULL
            );
            $message = new Message($argsMessage);

            return $message;
        }// else
        
    }// function
    
    /**
     * Search events with args
     * @param type $args
     * @return type message 
     */
    public static function searchEvents($args){
        global $crud;
        
        // return value
        $message ;
        
        // if args are supplied
        if( isset ($args['where']) ) {
            $where  = $args['where'];
            // optional args
            if(isset($args['orderBy'])) {
                $orderBy  = 'ORDER BY '.$args['orderBy'];
                if( isset( $args['orderByType'] ) )
                    $orderBy .= ' '.$args['orderByType'];
            }// if
            else
                $orderBy = '';
            
            // SQL statement
            $sql = "SELECT * From Event WHERE $where AND isArchived = 0 $orderBy";
           
            // exec query
            $data = $crud->getRows($sql);
            
            // if query returned results
            if($data) {
                
                $events = array();
                
                // make object for each row
                foreach($data as $row){
                    $argsEvent = array(
                        'no'           => $row['No'],
                        'mainTopic'    => $row['MainTopic'],
                        'startingDate' => $row['StartingDate'],
                        'endingDate'   => $row['EndingDate'],
                        'startingTime' => $row['StartingTime'],
                        'endingTime'   => $row['EndingTime'],
                        'description'  => $row['Description'],
                        'isArchived'   => $row['IsArchived']
                    );

                    $events[] = new Event($argsEvent);
                } //foreach
                
                
                $argsMessage = array(
                    'messageNumber' => 500,
                    'message'       => 'Events Founds',
                    'status'        => true,
                    'content'       => $events
                );
                $message = new Message($argsMessage);
                
            }else {
                $argsMessage = array(
                    'messageNumber' => 501,
                    'message'       => 'Event not found',
                    'status'        => false,
                    'content'       => NULL
                );
                $message = new Message($argsMessage);
            }// else
        }// if
        else {
            // By default, search all events
            $messageEvents = self::getEvents();
            // if events founds
            if($messageEvents->getStatus()){
                $argsMessage = array(
                    'messageNumber' => 500,
                    'message'       => 'Events Founds',
                    'status'        => true,
                    'content'       => $messageEvents->getContent()
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
    }// function
    
}// class

?>


