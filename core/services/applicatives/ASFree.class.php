<?php

require_once(APP_DIR . '/core/services/functionnals/FSAffectation.class.php');
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
require_once(APP_DIR . '/core/services/functionnals/FSTalk.class.php');


/**
 * ASFree.class.php
 * 
 * Author : Raphael Schmutz
 * Date : 25.06.2013
 * 
 * Description : define the class ASFree as definited in the model
 * 
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
        
        $emptyField = null;
        
        /**
         * Arguments for adding a Person
         */
        if(!isset($args['description']) || $args['description'] == ''){
            $description = '';
        } else {
            $description = $args['description'];
        }
        //Check all fields filled
        if(!isset($args['name']) || $args['name'] == ''){
            $argsMessage = array(
                        'messageNumber' => 666,
                        'message' => 'Empty field. Please, fill all field asked (Description optional) (1).',
                        'status' => false,
                        'content' => null
                    );
            $emptyField = new Message($argsMessage);
        } else {
            $name = $args['name'];
        }
        /*--------------------------------------------------------------------*/
        if(!isset($args['firstname']) || $args['firstname'] == ''){
            $argsMessage = array(
                        'messageNumber' => 666,
                        'message' => 'Empty field. Please, fill all field asked (Description optional) (2).',
                        'status' => false,
                        'content' => null
                    );
            $emptyField = new Message($argsMessage);
        } else {
            $name = $args['firstname'];
        }
        /*--------------------------------------------------------------------*/
        if(!isset($args['dateOfBirth']) || $args['dateOfBirth'] == ''){
            $argsMessage = array(
                        'messageNumber' => 666,
                        'message' => 'Empty field. Please, fill all field asked (Description optional) (3).',
                        'status' => false,
                        'content' => null
                    );
            $emptyField = new Message($argsMessage);
        } else {
            $name = $args['dateOfBirth'];
        }
        /*--------------------------------------------------------------------*/
        if(!isset($args['address']) || $args['address'] == ''){
            $argsMessage = array(
                        'messageNumber' => 666,
                        'message' => 'Empty field. Please, fill all field asked (Description optional) (4).',
                        'status' => false,
                        'content' => null
                    );
            $emptyField = new Message($argsMessage);
        } else {
            $name = $args['address'];
        }
        /*--------------------------------------------------------------------*/
        if(!isset($args['city']) || $args['city'] == ''){
            $argsMessage = array(
                        'messageNumber' => 666,
                        'message' => 'Empty field. Please, fill all field asked (Description optional)  (5).',
                        'status' => false,
                        'content' => null
                    );
            $emptyField = new Message($argsMessage);
        } else {
            $name = $args['city'];
        }
        /*--------------------------------------------------------------------*/
         if(!isset($args['country']) || $args['country'] == ''){
            $argsMessage = array(
                        'messageNumber' => 666,
                        'message' => 'Empty field. Please, fill all field asked (Description optional) (6).',
                        'status' => false,
                        'content' => null
                    );
            $emptyField = new Message($argsMessage);
        } else {
            $name = $args['country'];
        }
        /*--------------------------------------------------------------------*/
        if(!isset($args['phoneNumber']) || $args['phoneNumber'] == ''){
            $argsMessage = array(
                        'messageNumber' => 666,
                        'message' => 'Empty field. Please, fill all field asked (Description optional) (7).',
                        'status' => false,
                        'content' => null
                    );
            $emptyField = new Message($argsMessage);
        } else {
            $name = $args['phoneNumber'];
        }
        /*--------------------------------------------------------------------*/
        if(!isset($args['email']) || $args['email'] == ''){
            $argsMessage = array(
                        'messageNumber' => 666,
                        'message' => 'Empty field. Please, fill all field asked (Description optional) (8).',
                        'status' => false,
                        'content' => null
                    );
            $emptyField = new Message($argsMessage);
        } else {
            $name = $args['email'];
        }
        /*--------------------------------------------------------------------*/
        
        if($emptyField == null){
            $argsPerson = array(
                'name' => $args['name'],
                'firstname' => $args['firstname'],
                'dateOfBirth' => $args['dateOfBirth'],
                'address' => $args['address'],
                'city' => $args['city'],
                'country' => $args['country'],
                'phoneNumber' => $args['phoneNumber'],
                'email' => $args['email'],
                'description' => $description
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
        }else{
            return $emptyField;
        };
    }//function


    /**
     * Find an Event from its ID (no)
     * @param type $no
     * @return type anEvent
     */
    public static function getEvent($no) {
        $anEvent = FSEvent::getEvent($no);
        return $anEvent;
    }// function

    
    /**
     * Show all Events
     * @return type Events
     */
    public static function getEvents() {
        $events = FSEvent::getEvents();
        return $events;
    }// function
    
    
   /**
    * Find a Participant with his status
    * @param type $args
    * @return type a Participant
    */
    public static function getParticipant($args) {
        $aParticipant = FSParticipant::getParticipant($args);
        return $aParticipant;
    }// function

    
    /**
     * Show all Participants from an Event
     * @return type Participants
     */
    public static function getParticipants(){
        $participants = FSParticipant::getParticipants();
        return $participants;
    }// function
    

    /**
     * Find a Registration from the status, the Participant, and the Event
     * @param type $args
     * @return type a Registration
     */
    public static function getRegistration($args) {
        $aRegistration = FSRegistration::getRegistration($args);
        return $aRegistration;
    }// function

    
    /**
     * Show all Registrations 
     * @return type Regitrations
     */
    public static function getRegistrations(){
        $registrations = FSRegistration::getRegistrations();
        return $registrations;
    }// function
    
    /**
     * Show all Registrations of an Event
     * @param type $anEvent
     * @return type registrations
     */
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
    
    
    /**
     * Find a Location from the Status
     * @param type $args
     * @return type a Location
     */
    public static function getLocation($args) {
        $aLocation = FSLocation::getLocation($args);
        return $aLocation;
    }// function

    
    /**
     * Show all Locations from an Event
     * @return type Locations
     */
    public static function getLocations(){
        $locations = FSLocation::getLocations();  
        return $locations;
    }// function
    
        //Find a Role from the status
    public static function getRole($args) {
        $aRole = FSRole::getRole($args);
        return $aRole;
    }// function

    
    /**
     * Show all Roles of an Event
     * @return type Roles
     */
    public static function getRoles(){
        $roles = FSRole::getRoles(); 
        return $roles;
    }// function
    
    
    /**
     * Find the TeamRole from a Status
     * @param type $args
     * @return type a TeamRole
     */
    public static function getTeamRole($args) {
        $aTeamRole = FSTeamRole::getTeamRole($args);
        return $aTeamRole;
    }// function

    
    /**
     * Show all TeamRoles of an Event
     * @return type TeamRoles 
     */
    public static function getTeamRoles(){
        $teamRoles = FSTeamRole::getTeamRoles();
        return $teamRoles;
    }// function
    
    

    /**
     * Returs all TeamRoles of an Organizer
     * @param type $organizer
     * @return type message
     */
    public static function getTeamRolesByOrganizer($organizer){
        $messageGetTeamRolesByOrganizer = FSAffectation::getTeamRolesByOrganizer($organizer);
        return $messageGetTeamRolesByOrganizer;
    }
       
    
    /**
     * Show a Person
     * @param type $no
     * @return type a Person
     */
    public static function getPerson($no) {
        $aPerson = FSPerson::getPerson($no); 
        return $aPerson; 
    }//function 
    
    
    /**
     * Show all Persons
     * @return type Persons
     */
    public static function getPersons() {
        $persons = FSPerson::getPersons();  
        return $persons; 
    }//function 
    
    
    /**
     * Show a Unit
     * @param type $aNo
     * @return type a Unit
     */
    public static function getUnit($aNo) {
        $aUnit = FSUnit::getUnit($aNo);
        return $aUnit;    
    }//function 
    
    
    /**
     * Show all Units
     * @return type Units
     */
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
        $speakers = FSTalk::getSpeakersByEvent($event);
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
    
    /**
     * Returns all the Participants of a Slot
     * @param type $slot
     * @return a Message containing an array of Participants
     */
    public static function getParticipantsBySlot($slot){
        $messageGetParticipantsBySlot = FSParticipation::getParticipantsBySlot($slot);
        return $messageGetParticipantsBySlot;
    }
    
    
    /**
     * Returns all the Talks
     * @param type
     * @return a Message containing an array of Talks
     */
    public static function getTalks(){
        $messageTalks = FSTalk::getTalks();
        return $messageTalks;
    }
    
    
    /**
     * Returns a talk with its Id
     * @param type
     * @return a Message containing an array of Talks
     */
    public static function getTalk($args){
        $messageTalk = FSTalk::getTalk($args);
        return $messageTalk;
    }
    
    
    /**
     * Show a Speaker
     * @param type $no
     * @return type a Speaker
     */
    public static function getSpeaker($no) {
        $aSpeaker = FSSpeaker::getSpeaker($no); 
        return $aSpeaker; 
    }//function 
    
    
    /**
     * Show all Speakers
     * @return type Speakers
     */
    public static function getSpeakers() {
        $speakers = FSSpeaker::getSpeakers();  
        return $speakers; 
    }//function 
    
    
   /**
    * Show all Talks of a Speaker
    * @param type $aSpeaker
    * @return type
    */
    public static function getTalksBySpeaker($aSpeaker) {
        return FSTalk::getTalksBySpeaker($aSpeaker);  
    }//function 
    
    // Show all organizer of an Event
    public static function getOrganizersByEvent($anEvent){
        $content = Null;
        $messageValidRoles = FSRole::getRolesByEvent($anEvent);
        if($messageValidRoles->getStatus()){
            $listOfValidRoles = $messageValidRoles->getContent();
            $flagValidOrganizer = true;
            foreach($listOfValidRoles as $aValidRole){
                $messageValidOrganizer = FSOrganizer::getOrganizer($aValidRole->getOrganizerPersonNo());
                if($messageValidOrganizer->getStatus()){
                    $aValidOrganizer = $messageValidOrganizer->getContent();
                    $content[$aValidOrganizer->getNo()]['roles'][] = $aValidRole;
                    $content[$aValidOrganizer->getNo()]['organizer'] = $aValidOrganizer;
                }else{
                    $message[] = $messageValidOrganizer;
                    $flagValidOrganizer = false;
                }
            }
            if($flagValidOrganizer){
                $argsMessage = array(
                    'messageNumber' => 450,
                    'message' => 'All Organizers for the Event',
                    'status' => true,
                    'content' => $content
                );
                $message = new Message($argsMessage);
            }
        }else{
            $message = $messageValidRoles;
        }
        return $message;
    }
}// class

?>
