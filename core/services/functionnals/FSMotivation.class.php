<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once(APP_DIR . '/core/model/Message.class.php');
require_once(APP_DIR . '/core/model/Motivation.class.php');
require_once(APP_DIR . '/core/model/Participant.class.php');
require_once(APP_DIR . '/core/model/Person.class.php');
require_once(APP_DIR . '/core/model/Event.class.php');

/**
 * Description of FSMotivation
 *
 * @author Robin de la forêt
 */

class FSMotivation{
    /**
     * Returns the Motivation of the database with the 
     * @param type $args the IDs of Motviation
     * @return A Message containing the Motivaation getted
     */
    public static function getMotivation($args){
        $motivation = NULL;
        
        // Get database manipulator
        global $crud;
        
        // SQL request for getting a Motivation
        $sql = "SELECT * FROM Motivation WHERE IsArchived = 0 AND Text = '". $args['Text'] ."' AND EventNo = " . $args['EventNo'] . " AND ParticipantPersonNo = " . $args['ParticipantPersonNo'];
        $data = $crud->getRow($sql);
        
        // If a Motivation is Valid
        if($data){
            $argsMotivation = array(
                'text'              => $data['Text'],
                'eventNo'             => $data['EventNo'],
                'participantPersonNo' => $data['ParticipantPersonNo'],
                'isArchived'          => $data['IsArchived']
            );
            
            // Get the message Existant Motivation with the object Motivation
            $motivation = new Motivation($argsMotivation);
            $argsMessage = array(
                'messageNumber'     => 223,
                'message'           => 'Existant Motivation',
                'status'            => true,
                'content'           => $motivation
            );
        }else{
                // Get the message Inexistant Motivation
            $argsMessage = array(
                'messageNumber'     => 224,
                'message'           => 'Inexistant Motivation',
                'status'            => false,
                'content'           => NULL    
            );
        }
        
        return new Message($argsMessage);
        
    }
    
    /**
     * Returns all the Register of the database
     * @return A Message containing an array of Motivation
     */
    public static function getMotivations(){
        // Get database manipulator
        global $crud;
        
        // SQL Request for getting all Persistants Motivations
        $sql = "SELECT * FROM Motivation WHERE IsArchived = 0";
        $data = $crud->getRows($sql);
        
        // If there is persistants Motivations
        if($data){
            $motivations = array();
            
            // For each Persistant Motivation, create an Object
            foreach($data as $row){
                $argsMotivation = array(
                    'text'              => $data['Text'],
                    'eventNo'             => $data['EventNo'],
                    'participantPersonNo' => $data['ParticipantPersonNo'],
                    'isArchived'          => $data['IsArchived']
                );
            
                $motivations[] = new Motivation($argsMotivation);
            } //foreach

            // Create a message with all objects returned
            $argsMessage = array(
                'messageNumber' => 225,
                'message'       => 'All Motivation getted',
                'status'        => true,
                'content'       => $motivations
            );
        } else {
            // Create a message with no persistant object 
            $argsMessage = array(
                'messageNumber' => 226,
                'message'       => 'No persistant Motivation',
                'status'        => false,
                'content'       => NULL
            );
        }
        return new Message($argsMessage);
    }
}
?>
