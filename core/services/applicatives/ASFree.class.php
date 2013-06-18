<?php

require_once(APP_DIR . '/core/model/Membership.class.php');
require_once(APP_DIR . '/core/model/Person.class.php');
require_once(APP_DIR . '/core/model/Member.class.php');
require_once(APP_DIR . '/core/model/Message.class.php');
require_once(APP_DIR . '/core/model/Unit.class.php');
require_once(APP_DIR . '/core/model/Event.class.php');
require_once (APP_DIR . '/core/services/functionnals/FSEvent.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSUnit.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSMember.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSMembership.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSPerson.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSOrganizer.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSlot.class.php');

/**
 * Description of ASFree
 *
 * @author rapou
 */
class ASFree {

    /**
     * The constructor that does nothing
     */
    public function __construct() {
        // Nothing
    }

    /**
     * Method registerVisitor from SA Free
     * @param type $args 
     * @return type 
     */
    public static function registerVisitor($args) {
        /*
          $argsPerson = array(
          'name'         => '',
          'firstname'    => '',
          'dateOfBirth'  => '',
          'address'      => '',
          'city'         => '',
          'country'      => '',
          'phoneNumber'  => '',
          'email'        => '',
          'description'  => '',
          'idmember'     => '',
          'password'     => '',
          );
         */
        /**
         * Arguments for adding a Person
         */
        $argsPerson = array(
            'name' => $args['name'],
            'firstname' => $args['firstname'],
            'dateOfBirth' => $args['dateOfBirth'],
            'address' => $args['address'],
            'city' => $args['city'],
            'country' => $args['country'],
            'phoneNumber' => $args['phoneNumber'],
            'email' => $args['email'],
            'description' => $args['description']
        );

        /**
         * Add a Person
         */
        $messageAddedPerson = FSPerson::addPerson($argsPerson);
        /**
         * If the Person is added, continue. 
         */
        if ($messageAddedPerson->getStatus()) {
            $anAddedPerson = $messageAddedPerson->getContent();
            /**
             * Arguments for adding a Member
             */
            $argsMember = array(
                'id' => $args['idmember'],
                'password' => $args['password'],
                'person' => $anAddedPerson
            );
            /**
             * Add a Member
             */
            $messageAddedMember = FSMember::addMember($argsMember);
            /**
             * If the Member is added, continue.
             */
            if ($messageAddedMember->getStatus()) {
                $anAddedMember = $messageAddedMember->getContent();
                /**
                 * Get the Unit with the name 'Visitor' 
                 */
                $messageUnit = FSUnit::getUnitByName('Visitor');
                $visitorUnit = $messageUnit->getContent();
                /**
                 * Arguments for adding a Membership
                 */
                $argsMembership = array(
                    'member' => $anAddedMember,
                    'unit' => $visitorUnit
                );
                /**
                 * Add a Membership
                 */
                $messageAddedMembership = FSMembership::addMembership($argsMembership);
                /**
                 * If the Membership is added, generate the message OK
                 */
                if ($messageAddedMembership->getStatus()) {
                    $anAddedMembership = $messageAddedMembership->getContent();
                    $argsMessage = array(
                        'messageNumber' => 402,
                        'message' => 'Visitor registered',
                        'status' => true,
                        'content' => array('anAddedPerson' => $anAddedPerson, 'anAddedMember' => $anAddedMember, 'anAddedMembership' => $anAddedMembership)
                    );
                    $aRegisteredVisitor = new Message($argsMessage);
                } else {
                    /**
                     * Else give the error message about non-adding Membership
                     */
                    $aRegisteredVisitor = $messageAddedMembership;
                }
            } else {
                /**
                 * Else give the error message about non-adding Member
                 */
                $aRegisteredVisitor = $messageAddedMember;
            }
        } else {
            /**
             * Else give the error message about non-adding Person
             */
            $aRegisteredVisitor = $messageAddedPerson;
        }
        /**
         * Return the message Visitor Registed or not Registred
         */
        return $aRegisteredVisitor;
    }

    // function
    //Find an Event from its ID (no)
    public static function getEvent($no) {
        $anEvent = FSEvent::getEvent($no);
        return $anEvent;
    }// function

    //Show all event
    public static function getEvents() {
        $events = FSEvent::getEvents();
        return $events;
    }// function
    
   //Find a Participant from the status
    public static function getParticipant($args) {
        $aParticipant = FSParticipant::getParticipant($args);
        return $aParticipant;
    }// function

    // Show all Participants of an event
    public static function getParticipants(){
        $participants = FSParticipant::getParticipants();
        return $participants;
    }// function
    
    //Find a Registration from the status, the participant, and the event
    public static function getRegistration($args) {
        $aRegistration = FSRegistration::getRegistration($args);
        return $aRegistration;
    }// function

    // Show all Registration of an event
    public static function getRegistrations(){
        $registrations = FSRegistration::getRegistrations();
        return $registrations;
    }// function
    //
    // Show all Registration of an event
    public static function getRegistrationsByEvent($anEvent){
        $registrations = FSRegistration::getRegistrationsByEvent($anEvent);
        return $registrations;
    }// function
    
    /**
     * Search events with args
     * @param type $args
     * @return type message
     */
    public static function searchEvent($args) {
        $messageEvents = FSEvent::searchEvents($args);
        return $messageEvents;
    }// public 
    
    /**
     * Get an Organizer with its Id
     * @param type $args
     * @return type message
     */
    public static function getOrganizer($no) {
        $anOrganizer = FSOrganizer::getOrganizer($no);
        return $anOrganizer;
    }// function
    
    /**
     * Get Organizers
     * @param type $args
     * @return type message
     */
    public static function getOrganizers() {
        $organizers = FSOrganizer::getOrganizers();
        return $organizers;
    }// function
    
    /**
     * Get a Slot with its Id
     * @param type $args
     * @return type message
     */
    public static function getSlot($args) {
        $aSlot = FSSlot::getSlot($args);
        return $aSlot;
    }// function
    
    /**
     * Get Slots
     * @param type $args
     * @return type message
     */
    public static function getSlots() {
        $slots = FSSlot::getSlots();
        return $slots;
    }// function
    
    /**
     * Get SlotsByEvent
     * @param type $event
     * @return type message
     */
    public static function getSlotsByEvent($event) {
        $slots = FSSlot::getSlotsByEvent($event);
        return $slots;
    }// function
    
}// class

?>
