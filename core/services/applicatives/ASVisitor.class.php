<?php

require_once(APP_DIR . '/core/services/functionnals/FSAccess.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSEvent.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSKeyword.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSLocation.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSMember.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSMembership.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSOrganizer.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSParticipant.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSParticipation.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSRegistration.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSRole.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSSlot.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSSpeaker.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSTeamRole.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSUnit.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSPerson.class.php');
require_once (APP_DIR . '/core/model/Message.class.php');


/**
 * ASVisitor.class.php
 * 
 * Author : Raphael Schmutz
 * Date : 25.06.2013
 * 
 * Description : define the class ASVisitor as definited in the model
 * 
 */
class ASVisitor {

    /**
     * Constructor of applicative service Visitor
     */
    public function __construct() {
        // do nothing;
    }//construct

    /**
     * Register to an Event
     * @param type $args
     * @return type message
     */
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
                'status' => 'Pending', // String
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
                    $finalMessage = $messagesAddedParticipation;
                }
            } else {
                $finalMessage = $messageAddedRegistration; // Registration failed
            } // else
        } else {
            echo "asclksna";
            $messageUnit = FSUnit::getUnitByName('Participant');
            $participantUnit = $messageUnit->getContent();
            $aMember = FSMember::getMemberByPerson($aPerson)->getContent();
            $argsMembership = array(
                'member' => $aMember,
                'unit' => $participantUnit
            );
            $messageAddedMembership = FSMembership::addMembership($argsMembership);
            if($messageAddedMembership->getStatus()){
                $argsParticipant = array(
                    'person' => $aPerson,
                    'event' => $anEvent,
                    'slots' => $listOfSlots,
                    'registrationType' => $aType,
                    'registrationTypeDescription' => $aTypeDescription,
                );
                // add registration
                $finalMessage = FSParticipant::addParticipant($argsParticipant);
            }else{
                 $finalMessage = $messageAddedMembership;
            }
        } // else
        return $finalMessage;
    }// function
    
    
    
    /**
     * Edit the profil of a Person.
     * @param type $args the news arguments and the ID of the Person
     * @return type message
     */
    public static function changeProfil($args) {
        /*
          $argsPerson = array(
          'no' => '', // int
          'name' => '', // String
          'firstName' => '', // String
          'dateOfBirth' => '', // String
          'address' => '', // String
          'city' => '', // String
          'country' => '', // String
          'phoneNumber' => '', // String
          'email' => '', // String
          'description' => '', // String
          );
         */
        $messageValidPerson = FSPerson::getPerson($args['no']);
        if ($messageValidPerson->getStatus()) {
            $aValidPerson = $messageValidPerson->getContent();
            $aPersonToSet = self::setProfil($aValidPerson, $args);
            $messageSetPerson = FSPerson::setPerson($aPersonToSet);
            $finalMessage = $messageSetPerson;
        } else {
            $finalMessage = $messageValidPerson;
        }
        return $finalMessage;
    }//function
    
    
    /**
     * Edit the password of a Member
     * @param type $args the password and the ID of a Member
     * @return type message
     */
    public static function changePassword($args) {
        /*
          $args = array(
          'ID' => '', // int
          'password' => '', // String
          );
         */
        $messageValidMember = FSMember::getMember($args['ID']);
        if ($messageValidMember->getStatus()) {
            $aValidMember = $messageValidMember->getContent();
            $aMemberToSet = self::setPassword($aValidMember, $args);
            $messageSetMember = FSMember::setMember($aMemberToSet);
            $finalMessage = $messageSetMember;
        } else {
            $finalMessage = $messageValidMember;
        }
        return $finalMessage;
    }//function

    
    /**
     * Static function setPassword
     * @param type $aValidMember
     * @param type $argsToSet
     * @return type a valid Member
     */
    private static function setPassword($aValidMember, $argsToSet) {
        /*
          $args = array(
          'password' => '', // String
          );
         */
        if (($argsToSet['password'] != '') and (md5($argsToSet['password']) != md5($aValidMember->getPassword()))) {
            $aValidMember->setPassword($argsToSet['password']);
        }

        return $aValidMember;
    }//function

    
    /**
     * Set profil
     * @param type $aValidPerson
     * @param type $argsToSet
     * @return type a valid Person
     */
    private static function setProfil($aValidPerson, $argsToSet) {
        /*
          $argsToSet = array(
          'name' => '', // String
          'firstName' => '', // String
          'dateOfBirth' => '', // String
          'address' => '', // String
          'city' => '', // String
          'country' => '', // String
          'phoneNumber' => '', // String
          'email' => '', // String
          'description' => '', // String
          );
         */

        if (($argsToSet['name'] != '') and ($argsToSet['name'] != $aValidPerson->getName())) {
            $aValidPerson->setName($argsToSet['name']);
        }

        if (($argsToSet['firstName'] != '') and ($argsToSet['firstName'] != $aValidPerson->getFirstName())) {
            $aValidPerson->setFirstName($argsToSet['firstName']);
        }

        if (($argsToSet['dateOfBirth'] != '') and ($argsToSet['dateOfBirth'] != $aValidPerson->getDateOfBirth())) {
            $aValidPerson->setDateOfBirth($argsToSet['dateOfBirth']);
        }

        if (($argsToSet['address'] != '') and ($argsToSet['address'] != $aValidPerson->getAddress())) {
            $aValidPerson->setAddress($argsToSet['address']);
        }

        if (($argsToSet['city'] != '') and ($argsToSet['city'] != $aValidPerson->getCity())) {
            $aValidPerson->setCity($argsToSet['city']);
        }

        if (($argsToSet['country'] != '') and ($argsToSet['country'] != $aValidPerson->getCountry())) {
            $aValidPerson->setCountry($argsToSet['country']);
        }

        if (($argsToSet['phoneNumber'] != '') and ($argsToSet['phoneNumber'] != $aValidPerson->getPhoneNumber())) {
            $aValidPerson->setPhoneNumber($argsToSet['phoneNumber']);
        }

        if (($argsToSet['email'] != '') and ($argsToSet['email'] != $aValidPerson->getEmail())) {
            $aValidPerson->setEmail($argsToSet['email']);
        }

        if( !isset($argsToSet['description']) or $argsToSet['description'] == '' ){
            $aValidPerson->setDescription(NULL);
        }else{
            $aValidPerson->setDescription($argsToSet['description']);
        }
        return $aValidPerson;
    }// function
    
    
    /**
     * Search person with args
     * @param type $args
     * @return type message
     */
    public static function searchPersons($args){
        
        $messageSearchPerson = FSPerson::searchPersons($args);
        return $messageSearchPerson;
        
    }// function

}// class

?>
