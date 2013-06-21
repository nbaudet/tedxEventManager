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
require_once(APP_DIR . '/core/services/functionnals/FSPlace.class.php');


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
    
    //Find a Location from the status, 
    public static function getLocation($args) {
        $aLocation = FSLocation::getLocation($args);
        return $aLocation;
    }// function

    // Show all Locations of an event
    public static function getLocations(){
        $locations = FSLocation::getLocations();  
        return $locations;
    }// function
    
        //Find a Role from the status
    public static function getRole($args) {
        $aRole = FSRole::getRole($args);
        return $aRole;
    }// function

    // Show all Roles of an event
    public static function getRoles(){
        $roles = FSRole::getRoles(); 
        return $roles;
    }// function
    
    //Find a TeamRole from the status
    public static function getTeamRole($args) {
        $aTeamRole = FSTeamRole::getTeamRole($args);
        return $aTeamRole;
    }// function

    // Show all TeamRoles of an event
    public static function getTeamRoles(){
        $teamRoles = FSTeamRole::getTeamRoles();
        return $teamRoles;
    }// function
       
    //show a Person
    public static function getPerson($no) {
        $aPerson = FSPerson::getPerson($no); 
        return $aPerson; 
    }//function 
    
    //Show all Persons 
    public static function getPersons() {
        $persons = FSPerson::getPersons();  
        return $persons; 
    }//function 
    
    //Show a Unit
    public static function getUnit($aNo) {
        $aUnit = FSUnit::getUnit($aNo);
        return $aUnit;    
    }//function 
    
    //Show all Units
    public static function getUnits() {
        $units = FSUnit::getAllUnits(); 
        return $units; 
    }//function
    
    /**
     * Get Events By Speaker
     * @param type $speaker
     * @return type message
     */
    public static function getEventsBySpeaker($speaker) {
        $events = FSCoOrganizer::getEventsBySpeaker($speaker);
        return $events;
    }// function
    
    /**
     * Get Events By Speaker
     * @param type $speaker
     * @return type message
     */
    public static function getSpeakersByEvent($event) {
        $speakers = FSCoOrganizer::getSpeakersByEvent($event);
        return $speakers;
    }// function
    
    /**
     * get Location from an Event
     * @param type $event
     * @return type message
     */
    public static function getLocationFromEvent($event){
        $messageGetLocationFromEvent = FSLocation::getLocationFromEvent($event);
        return $messageGetLocationFromEvent;
    }// function
    
    /**
     * Returns the Speaker that talks at a given Place
     * @param Place $place
     * @return a Message containing the Speaker of a Place
     */
    public static function getSpeakerByPlace($place){
        $messageGetSpeakerByPlace = FSSpeaker::getSpeakerByPlace($place);
        return $messageGetSpeakerByPlace;
    } // END getSpeakerByPlace
    
    /**
     * Returns all the Places during a given Slot
     * @param Slot
     * @return a Message containing an array of Places
     */
    public static function getPlacesBySlot($slot){
        $messageGetPlacesBySlot = FSPlace::getPlacesBySlot($slot);
        return $messageGetPlacesBySlot;
    } // END getPlacesBySlot
    
    /**
     * Returns all the Roles of an Event
     * @param Event $event
     * @return a Message containing an array of Roles
     */
    public static function getRolesByEvent($event){
        $messageGetRolesByEvent = FSRole::getRolesByEvent($event);
        return $messageGetRolesByEvent;
    }
    
    /**
     * Returns all the Roles of an Organizer
     * @param Event $event
     * @return a Message containing an array of Roles
     */
    public static function getRolesByOrganizer($organizer){
        $messageGetRolesByOrganizer = FSRole::getRolesByOrganizer($organizer);
        return $messageGetRolesByOrganizer;
    }
    
    /**
     * Returns all the Register of a Participant
     * @param $aParticipant 
     * @return a Message containing the registrations
     */
    public static function getRegistrationsByParticipant($participant){
        $messageGetRegistrationByParticipant = FSRegistration::getRegistrationsByParticipant($participant);
        return $messageGetRegistrationByParticipant;
    }
    
}// class

?>
