<?php

/**
 * ASVisitor.class.php
 * 
 * Author : Raphael Schmutz
 * Date   : 13.06.2013
 * 
 * Description : Application Service for Vistiors
 * 
 */

require_once (APP_DIR.'/core/services/functionnals/FSRegistration.class.php');
require_once (APP_DIR.'/core/services/functionnals/FSParticipant.class.php');
require_once (APP_DIR.'/core/services/functionnals/FSParticipation.class.php');
require_once (APP_DIR.'/core/services/functionnals/FSSlot.class.php');
require_once (APP_DIR.'/core/model/Message.class.php');

class ASVisitor {
    
    /**
     * Constructor of applicative service Visitor
     */
    public function __construct() {
        // do nothing;
    } // function
    
    public function registerToAnEvent($args){
        $return;
        
        // gets params
        $aPerson            = $args['person'];
        $anEvent            = $args['event'];
        $typeRegistration   = $args['typeRegistration'];
        
        // optionals args
        if(isset ($args['typeDescription']) ) // optionals
            $typeDescription = $args['typeDescription'];
        else
            $typeDescription = null;
        
        if(isset ($args['slots']) ) // optionals
            $slots = $args['slots'];
        else
            $slots = null;
        
        /**
         * Validate Participant
         */
        $aValidParticipant = FSParticipant::getParticipant($aPerson);
        $messageRegistration = null;
        if($aValidParticipant->getStatus()){
            
            // add registration
            $argsRegistration = array(
                'event'         => $anEvent,
                'participant'   => $aValidParticipant->getContent(),
                'type'          => $typeRegistration,
                'description'   => $typeDescription,
                'date'          => date('Y-m-d')
            );
            
            // do Registration 
            $messageRegistration = $FSRegistration::addRegistration($aValidParticipant);
            
        }// if
        else {
            // an invalidParticipant so register as Participant
            $aValidParticipant; // Participant Innexistant
            // add registration
            $argsPatricipant = array(
                'event'         => $anEvent,
                'person'        => $aPerson,
                'type'          => $typeRegistration,
                'description'   => $typeDescription,
                'date'          => date('Y-m-d')
            );
            $messageRegistration = FSParticipant::addParticipant($argsPatricipant);
        }// else
        
        // If registration sucessfull
        if($messageRegistration->getStatus()){
             /**
            * Get list of slots
            */
           /* if slots are undefined, by defaults participant register to 
           all slots */
           if($slots == null ){
               $slots = FSSlot::getSlotsByEvent($anEvent)->getContent();
           }// if
           /**
            * Register to all slots (by default)
            */
           $arrayMessages = array();
           foreach ($slots as $slot) {
               $argsParticipation = array(
                    'participant' => $messageRegistration->getContent(),
                    'slot' => $slot
               );
               $arrayMessages[] = FSParticipation::addParticipation($argsParticipation);
           }// foreach
           
           $return = $arrayMessages;
        }// if
        else {
            $return = $messageRegistration; // Registration failed
        }// else
       
        return $return;
    }// function
    
}// class

?>
