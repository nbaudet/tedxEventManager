<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once(APP_DIR . '/core/model/Keyword.class.php');
require_once(APP_DIR . '/core/model/Event.class.php');
require_once(APP_DIR . '/core/model/Person.class.php');
require_once(APP_DIR . '/core/model/Message.class.php');

/**
 * Description of FSKeyword
 *
 * @author rapou
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
        
        $sql = "SELECT * FROM Keyword WHERE Value = " . $args['value'] . " AND EventNo = " . $args['event']->getNo() . " AND PersonNo = " . $args['person']->getNo();
        $data = $crud->getRow($sql);
        
        if($data){
            $argsKeyword = array(
                'value'            => $data['Value'],
                'personNo'         => $data['PersonNo'],
                'eventNo'          => $data['EventNo']
            );
            
            $keyword = new Keyword($argsKeyword);
            
            $argsMessage = array(
                'messageNumber' => 422,
                'message'       => 'Existant Keyword',
                'status'        => true,
                'content'       => $keyword
            );
            $message = new Message($argsMessage);
        } else {
            $argsMessage = array(
                'messageNumber' => 423,
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
                'messageNumber' => 424,
                'message'       => 'All Keywords of Person selected',
                'status'        => true,
                'content'       => $keywords
            );
            $message = new Message($argsMessage);

            return $message;
        } else {
            $argsMessage = array(
                'messageNumber' => 425,
                'message'       => 'Error while SELECT * FROM Keyword WHERE IsArchived = 0',
                'status'        => false,
                'content'       => NULL
            );
            $message = new Message($argsMessage);

            return $message;
        }// else
    }// function
    
    
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
                'messageNumber' => 424,
                'message'       => 'All Keywords of Person for Event selected',
                'status'        => true,
                'content'       => $keywords
            );
            $message = new Message($argsMessage);

            return $message;
        } else {
            $argsMessage = array(
                'messageNumber' => 425,
                'message'       => 'Error while SELECT * FROM Keyword WHERE IsArchived = 0',
                'status'        => false,
                'content'       => NULL
            );
            $message = new Message($argsMessage);

            return $message;
        }// else
    }// function
    
}

?>
