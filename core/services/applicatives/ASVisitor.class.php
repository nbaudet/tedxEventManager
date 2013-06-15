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
require_once (APP_DIR . '/core/services/functionnals/FSRegistration.class.php');
require_once (APP_DIR . '/core/services/functionnals/FSParticipant.class.php');
require_once (APP_DIR . '/core/services/functionnals/FSParticipation.class.php');
require_once (APP_DIR . '/core/services/functionnals/FSSlot.class.php');
require_once (APP_DIR . '/core/model/Message.class.php');

class ASVisitor {

    /**
     * Constructor of applicative service Visitor
     */
    public function __construct() {
        // do nothing;
    }

// function

    public static function registerToAnEvent($args) {
        /*
         * $args = array(
         *      'person' => $aPerson, // object Person
         *      'event' => $anEvent, // object Event
         *      'slots' => $aListOfSlots, // List of objects Slot
         *      'type' => 'Presse', // String
         *      'typedescription' => 'Redacteur chez Edipresse SA' // String
         *  ); 
         */

        // gets params
        $aPerson = $args['person'];
        $anEvent = $args['event'];
        $aType = $args['type'];

        // optionals args
        if (isset($args['typeDescription'])) { // optionals
            $aTypeDescription = $args['typeDescription'];
        } else {
            $aTypeDescription = null;
        }
        if (isset($args['slots'])) { // optionals 
            $listOfSlots = $args['slots'];
        } else {
            $listOfSlots = FSSlot::getSlotsByEvent($anEvent)->getContent();
        }

        /**
         * Validate Participant
         */
        $messageValidParticipant = FSParticipant::getParticipant($aPerson->getNo());
        if ($messageValidParticipant->getStatus()) {
            $aValidParticipant = $messageValidParticipant->getContent();
            // add registration
            $argsRegistration = array(
                'status' => 'Waiting', // String
                'type' => $aType, // String
                'typeDescription' => $aTypeDescription, // Optionel - String
                'event' => $anEvent, // object Event
                'participant' => $aValidParticipant  // object Participant
            );
            // do Registration 
            $messageAddedRegistration = FSRegistration::addRegistration($argsRegistration);
            // If registration sucessfull
            if ($messageAddedRegistration->getStatus()) {
                $aValidRegistration = $messageAddedRegistration->getContent();
                // Register to all slots (by default)
                $i = 0;
                $flagParticipationAdded = true;
                foreach ($listOfSlots as $aSlot) {
                    $argsParticipation = array(
                        'slot' => $aSlot,
                        'event' => $anEvent,
                        'participant' => $aValidParticipant
                    );
                    $messagesAddedParticipation[$i] = FSParticipation::addParticipation($argsParticipation);
                    if ($messagesAddedParticipation[$i]->getStatus() == false) {
                        $flagParticipationAdded = false;
                    }
                    $i++;
                }// foreach
                if ($flagParticipationAdded) {
                    foreach ($messagesAddedParticipation as $message) {
                        $listOfValidParticipations[] = $message->getContent();
                    }
                    $argsMessage = array(
                        'messageNumber' => 420,
                        'message' => 'Participant registered to an Event',
                        'status' => true,
                        'content' => array('aValidRegistration' => $aValidRegistration, 'listOfValidParticipations' => $listOfValidParticipations)
                    );
                    $finalMessage = new Message($argsMessage);
                } else {
                    $finalMessage = $messagesAddedParticipations;
                }
            } else {
                $finalMessage = $messageAddedRegistration; // Registration failed
            } // else
        } else {
            $argsParticipant = array(
                'person' => $aPerson,
                'event' => $anEvent,
                'slots' => $listOfSlots,
                'registrationType' => $aType,
                'registrationTypeDescription' => $aTypeDescription,
            );
            // add registration
            $finalMessage = FSParticipant::addParticipant($argsParticipant);
        }// else
        return $finalMessage;
    }

// function
}

// class
?>
