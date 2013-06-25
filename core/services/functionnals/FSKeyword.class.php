<?php

require_once(APP_DIR . '/core/model/Keyword.class.php');
require_once(APP_DIR . '/core/model/Event.class.php');
require_once(APP_DIR . '/core/model/Person.class.php');
require_once(APP_DIR . '/core/model/Message.class.php');


/**
 * FSKeyword.class.php
 * 
 * Author : Raphael Schmutz
 * Date : 25.06.2013
 * 
 * Description : define the class FSKeyword as definited in the model
 * 
 */
class FSKeyword {
     /**
     * Returns a Event with the given No as Id.
     * @param int $no The Id of the Event
     * @return a Message containing an existant Event
     */
    public static function getKeyword($args) {
        $keyword = NULL;
        
        global $crud;
        
        $sql = "SELECT * FROM Keyword WHERE Value = '" . $args['value'] . "' AND EventNo = " . $args['event']->getNo() . " AND PersonNo = " . $args['person']->getNo();
        $data = $crud->getRow($sql);
        
        if($data){
            $argsKeyword = array(
                'value'            => $data['Value'],
                'personNo'         => $data['PersonNo'],
                'eventNo'          => $data['EventNo'],
                'isArchived'       => $data['IsArchived']
            );
            
            $keyword = new Keyword($argsKeyword);
            
            $argsMessage = array(
                'messageNumber' => 418,
                'message'       => 'Existant Keyword',
                'status'        => true,
                'content'       => $keyword
            );
            $message = new Message($argsMessage);
        } else {
            $argsMessage = array(
                'messageNumber' => 419,
                'message'       => 'Inexistant Keyword',
                'status'        => false,
                'content'       => NULL
            );
            $message = new Message($argsMessage);
        } // else
        return $message;
    }// function
    
    /**
     * Returns all the Events of the database
     * @return A Message containing an array of Events
     */
    public static function getKeywordsByPerson($aPerson){
        global $crud;
        
        $sql = "SELECT * FROM Keyword WHERE PersonNo = ". $aPerson->getNo() ." AND IsArchived = 0";
        $data = $crud->getRows($sql);
        
        if ($data){
            $keywords = array();

            foreach($data as $row){
                $argsKeyword = array(
                    'value'            => $row['Value'],
                    'personNo'         => $row['PersonNo'],
                    'eventNo'          => $row['EventNo'],
                    'isArchived'          => $row['IsArchived']
                );
            
                $keywords[] = new Keyword($argsKeyword);
            } //foreach

            $argsMessage = array(
                'messageNumber' => 420,
                'message'       => 'All Keywords of Person selected',
                'status'        => true,
                'content'       => $keywords
            );
            $message = new Message($argsMessage);

            return $message;
        } else {
            $argsMessage = array(
                'messageNumber' => 421,
                'message'       => 'Error while SELECT * FROM Keyword WHERE IsArchived = 0',
                'status'        => false,
                'content'       => NULL
            );
            $message = new Message($argsMessage);

            return $message;
        }// else
    }// function
    
    
    /**
     * get Keywords by person for an Event
     * @global type $crud
     * @param type $args
     * @return \Message
     */
    public static function getKeywordsByPersonForEvent($args){
        global $crud;
        $aPerson = $args['person'];
        $anEvent = $args['event'];
        $sql = "SELECT * FROM Keyword WHERE PersonNo = ". $aPerson->getNo() ." AND EventNo = " . $anEvent->getNo() . " AND IsArchived = 0";
        $data = $crud->getRows($sql);
        
        if ($data){
            $keywords = array();

            foreach($data as $row){
                $argsKeyword = array(
                    'value'            => $row['Value'],
                    'personNo'         => $row['PersonNo'],
                    'eventNo'          => $row['EventNo'],
                    'isArchived'          => $row['IsArchived']
                );
            
                $keywords[] = new Keyword($argsKeyword);
            } //foreach

            $argsMessage = array(
                'messageNumber' => 420,
                'message'       => 'All Keywords of Person for Event selected',
                'status'        => true,
                'content'       => $keywords
            );
            $message = new Message($argsMessage);

            return $message;
        } else {
            $argsMessage = array(
                'messageNumber' => 421,
                'message'       => 'Error while SELECT * FROM Keyword WHERE IsArchived = 0',
                'status'        => false,
                'content'       => NULL
            );
            $message = new Message($argsMessage);

            return $message;
        }// else
    }// function
    
     /**
     * Set new parameters to a Keyword
     * @param Keyword $aKeywordToSet
     * @return Message containing the setted Keyword
     */
    public static function setKeyword($aKeywordToSet) {
        global $crud;
            $sql = "UPDATE  Keyword SET  
                IsArchived =    " . $aKeywordToSet->getIsArchived() . "
                WHERE  Keyword.Value = '" . $aKeywordToSet->getValue() . "'
                AND Keyword.EventNo = " . $aKeywordToSet->getEventNo() . "
                AND Keyword.PersonNo = " . $aKeywordToSet->getPersonNo();

                            var_dump($sql);

            if ($crud->exec($sql) == 1) {
                $sql = "SELECT * FROM Keyword WHERE Value = '" . $aKeywordToSet->getValue() . "' AND EventNo = " . $aKeywordToSet->getEventNo() . " AND PersonNo = " . $aKeywordToSet->getPersonNo();
                $data = $crud->getRow($sql);
                var_dump($data);
                $argsKeyword = array(
                    'value' => $data['Value'],
                    'eventNo' => $data['EventNo'],
                    'personNo' => $data['PersonNo'],
                    'isArchived' => $data['IsArchived'],
                );
 
                $aSettedKeyword = new Keyword($argsKeyword);

                $argsMessage = array(
                    'messageNumber' => 422,
                    'message' => 'Keyword setted !',
                    'status' => true,
                    'content' => $aSettedKeyword
                );
                $message = new Message($argsMessage);
            } else {
                $argsMessage = array(
                    'messageNumber' => 423,
                    'message' => 'Error while setting new Keyword',
                    'status' => false,
                    'content' => NULL
                );
                $message = new Message($argsMessage);
            }
        return $message;
    }//function
    
    /**
     * Archive a Keyword
     * @param Keyword $aKeywordToSet
     * @return Message containing the archived Keyword
     */
    public static function archiveKeyword($aKeywordToArchive) {
        return self::setKeyword($aKeywordToArchive);
        
    }
    
     /**
     * Functionnal Service addKeyword
     * @param type $args the properties of a Keyword
     * @return type $message anAddedKeyword
     */
    public static function addKeyword($args) {
        $aValue = $args['value'];
        $anEvent = $args['event'];
        $aPerson = $args['person'];
        $messageValidEvent = FSEvent::getEvent($anEvent->getNo());
        if($messageValidEvent->getStatus()){
            $aValidEvent = $messageValidEvent->getContent();
            $messageValidPerson = FSPerson::getPerson($aPerson->getNo());
            if($messageValidPerson->getStatus()){
                $aValidPerson = $messageValidPerson->getContent();
                $argsKeyword = array('value' => $aValue, 'event' => $aValidEvent, 'person' => $aValidPerson);
                $messageValidKeyword = self::getKeyword($argsKeyword);
                if(!$messageValidKeyword->getStatus()){
                    $message = self::createKeyword($argsKeyword);
                }else{
                    $message = $messageValidKeyword;
                }
            }else{
                $message = $messageValidPerson;
            }
        }else{
            $message = $messageValidEvent;
        }   
        return $message;
    }
    
    /**
     * Creat Keyword 
     * @global type $crud
     * @param type $args
     * @return \Message
     */
    private static function createKeyword($args){
        // get database manipulator
        global $crud;
        $aValue = $args['value'];
        $anEvent = $args['event'];
        $aPerson = $args['person'];
        $sql = "INSERT INTO Keyword (Value, EventNo, PersonNo) VALUES ('" . $aValue . "', " . $anEvent->getNo() . ", ". $aPerson->getNo() .")";
        $crud->exec($sql);
        $messageValidKeyword = self::getKeyword($args);
        if($messageValidKeyword->getStatus()){
            $aValidKeyword = $messageValidKeyword->getContent();
             $argsMessage = array(
                'messageNumber' => 424,
                'message'       => 'The keyword is added',
                'status'        => true,
                'content'       => $aValidKeyword
            );
        }else{
            $argsMessage = array(
                'messageNumber' => 425,
                'message'       => 'The keyword is not added',
                'status'        => false,
                'content'       => null
            );
        }
        return new Message($argsMessage);

    }
    
    /**
     * Returns all the Events of the database
     * @return A Message containing an array of Events
     */
    public static function countKeywordsByPersonForEvent($args){
        global $crud;
        $aPerson = $args['person'];
        $anEvent = $args['event'];
        $sql = "SELECT count(*) AS nbKeywords FROM Keyword WHERE IsArchived = 0 AND EventNo = " . $anEvent->getNo() . " AND PersonNo = " . $aPerson->getNo();
        $data = $crud->getRow($sql);
        
        $nbKeywords = $data['nbKeywords'];
        if ($nbKeywords < 3){
            $argsMessage = array(
                'messageNumber' => 426,
                'message'       => 'Number of Keywords < 3',
                'status'        => true,
                'content'       => $nbKeywords
            );
            $message = new Message($argsMessage);
        } else {
            $argsMessage = array(
                'messageNumber' => 427,
                'message'       => 'Number of Keywords > 3',
                'status'        => false,
                'content'       => $nbKeywords
            );
            $message = new Message($argsMessage);
        }// else
        return $message;
    }// function
    
    
}//class

?>
