<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once(APP_DIR . '/core/model/Message.class.php');
require_once(APP_DIR . '/core/model/Registration.class.php');
require_once(APP_DIR . '/core/model/Participant.class.php');
require_once(APP_DIR . '/core/model/Event.class.php');


/**
 * Description of FSRegistration
 *
 * @author Rapou, el Nachos
 */
class FSRegistration {
    //put your code here
    
    public static function getRegistration($args){
        $registration = NULL;

        global $crud;
        
        // SQL request for getting a Registration
        $sql = "SELECT * FROM Registration WHERE Status LIKE '". $args['status'] ."' AND EventNo = " . $args['event']->getNo() . " AND ParticipantPersonNo = " . $args['participant']->getNo();
        $data = $crud->getRow($sql);
        
        echo "<hr> SQL";
        var_dump($sql);
        // If a Registration is Valid
        if($data){
            $argsRegistration = array(
                'status'              => $data['Status'],
                'eventNo'             => $data['EventNo'],
                'participantPersonNo' => $data['ParticipantPersonNo'],
                'registrationDate'    => $data['RegistrationDate'],
                'type'                => $data['Type'],
                'typeDescription'     => $data['TypeDescription'],
                'isArchived'          => $data['IsArchived']
            );
            
            // Get the message Existant Registration with the object Registration
            $registration = new Registration($argsRegistration);
            $argsMessage = array(
                'messageNumber'     => 410,
                'message'           => 'Existant Registration',
                'status'            => true,
                'content'           => $registration
            );
            $message = new Message($argsMessage);
        }else{
            // Get the message Inexistant Registration
            $argsMessage = array(
                'messageNumber'     => 411,
                'message'           => 'Inexistant Registration',
                'status'            => false,
                'content'           => NULL    
            );
            $message = new Message($argsMessage);
        }
        return $message;
    }
}

?>
