<?php

/**
 * Tedx_manager.class.php
 * 
 * Author : MIT40
 * Date : 05.06.2013
 * 
 * Description : 
 * 
 */

/**
 * Require all Applicative Services
 */
require_once(APP_DIR.'/core/services/applicatives/ASAuth.class.php');
require_once(APP_DIR.'/core/services/applicatives/ASRightsManagement.class.php');
require_once(APP_DIR.'/core/services/applicatives/ASFree.class.php');
require_once(APP_DIR.'/core/services/applicatives/ASVisitor.class.php');
require_once(APP_DIR.'/core/services/applicatives/ASParticipant.class.php');
require_once(APP_DIR.'/core/services/applicatives/ASOrganizer.class.php');
require_once(APP_DIR.'/core/services/applicatives/ASValidator.class.php');
require_once(APP_DIR.'/core/services/applicatives/ASAdmin.class.php');



/**
 * Require all Stub functions
 */
require_once (APP_DIR.'/core/model/Stub.class.php');


/**
 * Require all Fonctional Services
 */
//require_once('MemberManager.php');

/**
 * Principal controller of the Events Manager.
 */
class Tedx_manager{
    
    /*
     * An ASAuth object. Manages user loging and privileges
     */
    private $asAuth;
    
    /*
     * Object enabling to receive all the stubs
     */
    private $stub; 
    

    
    public function __construct(){
        $this->asAuth = new ASAuth();
        $this->stub   = new Stub();  //new object Stub 
    } // construct
    
    
    /*==========================================================================
     * 
     * CHECK FUNCTIONS
     * 
     *========================================================================*/
    /**
     * Check the type of a variable
     * @param type $type
     * @param type $variableToCheck
     */
    public function checkType($type, $variableToCheck){
        switch ($type){
            case "string" :
                return is_string($variableToCheck);
                break;
            case "int" :
                return is_int($variableToCheck);
                break;
            case "email" :
                if (preg_match('/^[\S]+@[\S]+\.\D{2,4}$/', $variableToCheck)== 1){
                    return true;
                } else {
                    return false;
                }
                break;
        }
    }//function
    
    
    /*==========================================================================
     * 
     * AUTHENTICATION FUNCTIONS
     * 
     *========================================================================*/
    /**
     * Checks if the user is granted to do an action or not
     * @param String $action the action to execute
     * @return Message "Missing action", "Access granted", or "Access restricted"
     */
    public function isGranted( $action ) {
        return $this->asAuth->isGranted( $action );
    } // function
    
    /**
     * Returns if a user is logged or not.
     * @return Boolean
     */
    public function isLogged() {
        return $this->asAuth->isLogged();
    } // function
    
    /**
     * Enable an anonym user to login
     * @param String $login The user's login OR the person's email address
     * @param String $password The user's password
     * @return Message "User logged" or "Login failure"
     */
    public function login( $login, $password ){
        if( $this->checkType( "string",  $login ) && $this->checkType( "string", $password ) ){
            $loginArgs = array (
                'id' => $login,
                'password' => $password
            );
            $messageLogin = $this->asAuth->login( $loginArgs );
        } else {
            $messageArgs = array (
                'messageNumber' => 004,
                'message' => "Login or password is not a string",
                'status' => FALSE
            );
            $messageLogin = new Message( $messageArgs );
        } // else
        return $messageLogin;
    } // function
    
    /**
     * Logs the current member out
     * @return Message "User logged out" or "User already logged out"
     */
    public function logout() {
        return $this->asAuth->logout();
    } // function
    
    /**
     * Returns the value of the currently logged user, or NULL
     * @return String The current username
     */
    public function getUsername() {
        return $this->asAuth->getUsername();
    } // function
    
    /**
     * Gets basic Units from a logged member
     * @return Boolean TRUE or FALSE
     */
    public function isAdministrator() {
        return ($this->isLogged() && $this->asAuth->isAdministrator());
    }
    public function isValidator() {
        return ($this->isLogged() && $this->asAuth->isValidator());
    }
    public function isOrganizer() {
        return ($this->isLogged() && $this->asAuth->isOrganizer());
    }
    public function isParticipant() {
        return ($this->isLogged() && $this->asAuth->isParticipant());
    }
    public function isVisitor() {
        return ($this->isLogged() && $this->asAuth->isVisitor());
    }
    public function isSuperadmin() {
        return ($this->isLogged() && $this->asAuth->isSuperadmin());
    }
    
    /*==========================================================================
     * 
     * FREE ACCESS FUNCTIONS
     * 
     *========================================================================*/
    /**
     * Applicatives services to register a Visitor
     * @param type $args all the arguments of Person and Member
     * @return type Message Registered Visitor or Specifics messages about a problem.
     */
    public function registerVisitor( $args ) {
        return  ASFree::registerVisitor( $args );
    }//function
    
    /**
     * Applicatives services to get a Registration
     * @param type $args a Status, an Event, a Participant
     * @return type Message The registration.
     */
    public function getRegistration( $args ) {
        return  ASFree::getRegistration( $args );
    }//function
    
     /**
     * Applicatives services to get all the Registration
     * @return type Message A tab of the registrations.
     */
    public function getRegistrations() {
        return  ASFree::getRegistrations();
    }//function
    
    /**
     * Applicatives services to get the Registrations of an Event
     * @param type $anEvent an Event
     * @return type Message The registrations of an Event.
     */
    public function getRegistrationsByEvent( $anEvent ) {
        return  ASFree::getRegistrationsByEvent( $anEvent );
    }//function
    
    /**
     * Returns all the Register of a Participant
     * @param $aParticipant 
     * @return a Message containing the registrations
     */
    public function getRegistrationsByParticipant($participant){
        return ASFree::getRegistrationsByParticipant($participant);
    }
    
    /**
     * Applicatives services to get the Location from an Event
     * @param type $event
     * @return type message
     */
    public function getLocationFromEvent( $anEvent ){
        return ASFree::getLocationFromEvent($anEvent);
    }// function
    
    public function getEvent( $args ) {
        //No check needed ->Free
        $anEvent = ASFree::getEvent($args); 
        return $anEvent; 
    }//function

    public function getEvents() {
        //No check needed ->Free
        $someEvents = ASFree::getEvents(); 
        return $someEvents; 
    }//function
    
    /**
     * Search events with args (where, orderBy, orderByType)
     * @param type $args
     * @return type message
     */
    public function searchEvents($args){
        $messageSearchEvents = ASFree::searchEvent($args);
        return $messageSearchEvents;
    }// function
    
    /**
     * Get an Organizer with its Id
     * @param type $no
     * @return type message
     */
    public function getOrganizer($no){
        $messageGetOrganizer = ASFree::getOrganizer($no);
        return $messageGetOrganizer;
    }// function
    
    /**
     * Get Organizers
     * 
     * @return type message
     */
    public function getOrganizers(){
        $messageGetOrganizers = ASFree::getOrganizers();
        return $messageGetOrganizers;
    }// function
    
    /**
     * Get Slots
     * 
     * @return type message
     */
    public function getSlots(){
        $messageGetSlots = ASFree::getSlots();
        return $messageGetSlots;
    }// function
    
    /**
     * Get a Slot
     * @param type $args
     * @return type message
     */
    public function getSlot($args){
        $messageGetSlot = ASFree::getSlot($args);
        return $messageGetSlot;
    }// function
    
    
    /**
     * Get a Slot(s) in an Event with the Event's Id
     * @param type $args
     * @return type message
     */
    public function getSlotsFromEvent($event){
        $messageGetSlotsByEvent = ASFree::getSlotsByEvent($event);
        return $messageGetSlotsByEvent;
    }// function
    
    
    /**
     * get a Participant
     * @param type $args
     * @return type message
     */
    public function getParticipant($args) {
        $messageGetParticipant = ASFree::getParticipant($args); 
        return $messageGetParticipant; 
    }//function
    
    
    /**
     * Get Participants
     * @return type message
     */
    public function getParticipants() {
        $messageGetParticipants = ASFree::getParticipants(); 
        return $messageGetParticipants; 
    }//function
    
        /**
     * Returns all the Participants of a Slot
     * @param type $slot
     * @return a Message containing an array of Participants
     */
    public function getParticipantsBySlot($slot){
        return ASFree::getParticipantsBySlot($slot);
    }
    
    /**
     * get a Location
     * @param type $args
     * @return type message
     */
    public function getLocation($args) {
        $messageGetLocation = ASFree::getLocation($args); 
        return $messageGetLocation; 
    }//function 
    
    
    /**
     * Get Locations
     * @return type message
     */
    public function getLocations() {
        $messageGetLocations = ASFree::getLocations(); 
        return $messageGetLocations; 
    }//function 
    
    
    /**
     * get a Role
     * @param type $args
     * @return type message
     */
    public function getRole($args) {
        $messageGetRole = ASFree::getRole($args); 
        return $messageGetRole; 
    }//function 
    
    
    /**
     * get Roles
     * @return type message
     */
    public function getRoles() {
        $messageGetRoles = ASFree::getRoles(); 
        return $messageGetRoles; 
    }//function 
    
    /**
     * Returns all the Roles of an Event
     * @param Event $event
     * @return a Message containing an array of Roles
     */
    public function getRolesByEvent($event){
        $messageGetRolesByEvent = ASFree::getRolesByEvent($event);
        return $messageGetRolesByEvent;
    }
    
    /**
     * Returns all the Roles of an Organizer
     * @param Event $event
     * @return a Message containing an array of Roles
     */
    public function getRolesByOrganizer($organizer){
        $messageGetRolesByOrganizer = ASFree::getRolesByOrganizer($organizer);
        return $messageGetRolesByOrganizer;
    }
    
    
    /**
     * get a TeamRole
     * @param type $args
     * @return type message
     */
    public function getTeamRole($args) {
        $messageGetTeamRole = ASFree::getTeamRole($args); 
        return $messageGetTeamRole; 
    }//function 
    
    
    /**
     * get TeamRoles
     * @return type message
     */
    public function getTeamRoles() {
        $messageGetTeamRoles = ASFree::getTeamRoles(); 
        return $messageGetTeamRoles; 
    }//function 
    
    /**
     * Returns all the TeamRoles of an Organizer
     * @param Organizer $organizer
     * @return a Message containing an array of TeamRoles
     */
    public function getTeamRolesByOrganizer($organizer){
        $messageGetTeamRolesByOrganizer = ASFree::getTeamRolesByOrganizer($organizer);
        return $messageGetTeamRolesByOrganizer;
    }
    
    
    /**
     * get a Person 
     * @param type $no
     * @return type message
     */
    public function getPerson($no) {
        $messageGetPerson = ASFree::getPerson($no); 
        return $messageGetPerson; 
    }//function 
    
    
    /**
     * get Persons 
     * @return type message
     */
    public function getPersons() {
        $messageGetPersons = ASFree::getPersons(); 
        return $messageGetPersons; 
    }//function 
    
    
    /**
     * get Unit
     * @return type message
     */
    public function getUnit($aNo) {
        $messageGetUnit = ASFree::getUnit($aNo); 
        return $messageGetUnit;    
    }//function 
    
    
    /**
     * get Units 
     * @return type message
     */
    public function getUnits() {
        $messageGetUnits = ASFree::getUnits();
        return $messageGetUnits; 
    }//function 
    
    /**
     * get Units 
     * @return type message
     */
    public function getEventsBySpeaker($args) {
        $messageGetEventsBySpeaker = ASFree::getEventsBySpeaker($args);
        return $messageGetEventsBySpeaker; 
    }//function 
    
    /**
     * get Units 
     * @return type message
     */
    public function getSpeakersByEvent($args) {
        $messageGetSpeakersByEvent = ASFree::getSpeakersByEvent($args);
        return $messageGetSpeakersByEvent; 
    }//function 
    
    /**
     * get Places by Slots given in args 
     * @return type message
     */
    public function getPlacesBySlot($slot) {
        $messageGetPlacesBySlot = ASFree::getPlacesBySlot($slot);
        return $messageGetPlacesBySlot; 
    }//function 
    
    /**
     * get Speakers by Place given in args 
     * @return type message
     */
    public function getSpeakerByPlace($place) {
        $messageGetSpeakerByPlace = ASFree::getSpeakerByPlace($place);
        return $messageGetSpeakerByPlace; 
    }//function 
    
    /**
     * get a Speaker with its Id
     * @return type message
     */
    public function getSpeaker($args) {
        $messageSpeaker = ASFree::getSpeaker($args);
        return $messageSpeaker; 
    }//function 
    
    /**
     * get all Talks
     * @return type message
     */
    public function getSpeakers() {
        $messageSpeakers = ASFree::getSpeakers();
        return $messageSpeakers; 
    }//function 
    
    /**
     * get a Talk with its Id
     * @return type message
     */
    public function getTalk($args) {
        $messageTalk = ASFree::getTalk($args);
        return $messageTalk; 
    }//function 
    
    /**
     * get all Talks
     * @return type message
     */
    public function getTalks() {
        $messageTalks = ASFree::getTalks();
        return $messageTalks; 
    }//function 
    
    /**
     * get all Talks of a Speaker
     * @return type message
     */
    public function getTalksBySpeaker($aSpeaker) {
        $messageTalks = ASFree::getTalksBySpeaker($aSpeaker);
        return $messageTalks; 
    }//function 
    
    /*==========================================================================
     * 
     * VISITOR FUNCTIONS
     * 
     *========================================================================*/
    /**
     * Applicatives services to register a Visitor to an Event
     * @param type $args the arguments needs about Slot, and Registration
     * @return type Message registeredToAnEvent or Specifics messages about a problem.
     */
    public function registerToAnEvent($args) {
        $messageAccess = $this->isGranted( "registerToAnEvent" );
        if( $messageAccess->getStatus() ) {
            $message = ASVisitor::registerToAnEvent($args); //ASVisitor::registerToAnEvent($args);
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }//function
    
    /**
     * Applicative service to change the Profil of a Person
     * @param type $args the aruments and the ID of a Person
     * @return type message
     */
    public function changeProfil( $args ) {
        $messageAccess = $this->isGranted( "changeProfil" );
        if( $messageAccess->getStatus() ) {
            $message = ASVisitor::changeProfil( $args );
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }//function
    
    /**
     * Applicative service to change the Password of a Member
     * @param type $args the Password and the ID of a Member
     * @return type message
     */
    public function changePassword( $args ) {
        $messageAccess = $this->isGranted( "changePassword" );
        if( $messageAccess->getStatus() ) {
            $message = ASVisitor::changePassword( $args );
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }//function
    
    /**
     * Search persons with Args
     * @param type $args
     * @return type message
     */
    public function searchPersons($args) {
        $messageAccess = $this->isGranted( "searchPersons" );
        if( $messageAccess->getStatus() ) {
            $message = ASVisitor::searchPersons( $args );
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }// function
    
    /*==========================================================================
     * 
     * MEMBER FUNCTIONS
     * 
     *========================================================================*/
    /**
     * Returns the logged person as an object or NULL
     * @return Message
     */
    public function getLoggedPerson() {
        if( $this->isLogged() ) {
            // Message with logged person
            $messageMember = FSMember::getMember( $this->getUsername() );
            $member        = $messageMember->getContent();
            $personNo      = $member->getPersonNo();
            $messagePerson = FSPerson::getPerson($personNo);
            $person = $messagePerson->getContent();
            $messageArgs = array (
                'messageNumber' => 021,
                'message'       => "The logged person",
                'status'        => TRUE,
                'content'       => $person
            );
            $messagePersonLogged = new Message( $messageArgs );
        }
        else {
            // Message not a logged person
            $messageArgs = array (
                'messageNumber' => 022,
                'message'       => "No logged member",
                'status'        => FALSE
            );
            $messagePersonLogged = new Message( $messageArgs );
        }
        return $messagePersonLogged;
    }// function
    
    /*==========================================================================
     * 
     * PARTICIPANT FUNCTIONS
     * 
     *========================================================================*/
    
    /**
     *Returns the last Registration For a Participant To An event
     *@param array $args The participant and the event
     *@return a Message with an existant Registration
     */
    public function getLastRegistration($args){
       return ASParticipant::getLastRegistration($args);
   }
    
    public function addKeywordsToAnEvent( $args ) {
        $messageAccess = $this->isGranted( "addKeywordsToAnEvent" );
        if( $messageAccess->getStatus() ) {
            $message = ASParticipant::addKeywordsToAnEvent( $args );
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }//function
    
    public function archiveKeyword( $args ) {
        $messageAccess = $this->isGranted( "archiveKeyword" );
        if( $messageAccess->getStatus() ) {
            $message = ASParticipant::archiveKeyword( $args ); 
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }//function

    /**
     * get Keyword 
     * @return type message
     */
    public function getKeyword($args) {
        $messageAccess = $this->isGranted( "getKeyword" );
        if( $messageAccess->getStatus() ) {
            $message = ASParticipant::getKeyword($args);
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }//function 
    
    //Show all Keywords of a Person
    public function getKeywordsByPerson($aPerson) {
        $messageAccess = $this->isGranted( "getKeywordsByPerson" );
        if( $messageAccess->getStatus() ) {
            $message = ASParticipant::getKeywordsByPerson($aPerson); 
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }//function
    
    //Show all Keywords of a Person for an Event
    public function getKeywordsByPersonForEvent($args) {
        $messageAccess = $this->isGranted( "getKeywordsByPersonForEvent" );
        if( $messageAccess->getStatus() ) {
            $message = ASParticipant::getKeywordsByPersonForEvent($args); 
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }//function
    
    //Add a Motivation To An Event
    public function addMotivationToAnEvent($args) {
        $messageAccess = $this->isGranted( "addMotivationToAnEvent" );
        if( $messageAccess->getStatus() ) {
            $message = ASParticipant::addMotivationToAnEvent($args); 
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }//function
    
    
    public function archiveMotivationToAnEvent($args) {
        $messageAccess = $this->isGranted( "archiveMotivationToAnEvent" );
        if( $messageAccess->getStatus() ) {
            $message = ASParticipant::archiveMotivationToAnEvent( $args ); 
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }//function
    
    //Show a Motivation
    public function getMotivation($args) {
        $messageAccess = $this->isGranted( "getMotivation" );
        if( $messageAccess->getStatus() ) {
            $message = ASParticipant::getMotivation($args);
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }//function 
    
    //Show all Motivations of a Person
    public function getMotivationsByParticipant($aParticipant) {
        $messageAccess = $this->isGranted( "getMotivationsByParticipant" );
        if( $messageAccess->getStatus() ) {
            $message = ASParticipant::getMotivationsByPerson($aParticipant); 
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }//function
    
    //Show all Motivations of a Person for an Event
    public function getMotivationsByParticipantForEvent( $args ) {
        $messageAccess = $this->isGranted( "getMotivationsByParticipantForEvent" );
        if( $messageAccess->getStatus() ) {
            $message = ASParticipant::getMotivationsByParticipantForEvent( $args ); 
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }//function
    
    // Send a registration
    public function sendRegistration( $args ) {
        $messageAccess = $this->isGranted( "sendRegistration" );
        if( $messageAccess->getStatus() ) {
            $message = ASParticipant::sendRegistration( $args );
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }//function
    
    //Show the Registration history of a Person for an Event
    public function getRegistrationHistory( $args ) {
        $messageAccess = $this->isGranted( "getRegistrationHistory" );
        if( $messageAccess->getStatus() ) {
            $message = ASParticipant::getRegistrationHistory( $args );
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }//function
    
    
    /*==========================================================================
     * 
     * ORGANIZER FUNCTIONS
     * 
     *========================================================================*/
    
    //Add a Speaker with a Member and his membership
    public function registerSpeaker( $args ) {
        $messageAccess = $this->isGranted( "registerSpeaker" );
        if( $messageAccess->getStatus() ) {
            $message = ASOrganizer::registerSpeaker( $args ); 
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }//function
     
    //Add a Location
    public function addLocation($args) {
        $messageAccess = $this->isGranted( "addLocation" );
        if( $messageAccess->getStatus() ) {
            $message = ASOrganizer::addLocation( $args );
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }//function
    
    //Set an Event Location
    public function changeEventLocation($args) {
        $messageAccess = $this->isGranted( "changeEventLocation" );
        if( $messageAccess->getStatus() ) {
            $message = ASOrganizer::changeEventLocation( $args );
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }
    
    public function addSlotToEvent( $args ) {
        $messageAccess = $this->isGranted( "addSlotToEvent" );
        if( $messageAccess->getStatus() ) {
            $message = ASOrganizer::addSlotToEvent( $args ); 
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }//function
    
    public function changePositionOfSpeakerToEvent( $args ) {
        $messageAccess = $this->isGranted( "changePositionOfSpeakerToEvent" );
        if( $messageAccess->getStatus() ) {
            $message = ASOrganizer::changePositionOfSpeakerToEvent( $args ); 
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }//function
    
    /*==========================================================================
     * 
     * VALIDATOR FUNCTIONS
     * 
     *========================================================================*/
    
    // Accept a registration
    public function acceptRegistration( $args ) {
        $messageAccess = $this->isGranted( "acceptRegistration" );
        if( $messageAccess->getStatus() ) {
            $message = ASValidator::acceptRegistration( $args );
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }//function
    
    // Reject a registration
    public function rejectRegistration( $args ) {
        $messageAccess = $this->isGranted( "rejectRegistration" );
        if( $messageAccess->getStatus() ) {
            $message = ASValidator::rejectRegistration( $args );
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }//function
    
    /**
     *  Cancel the status of a registration, and put 
     * @param Registration $args a Registration Object
     * @return Message a Message
     */
    public function cancelRegistration( $args ) {
        $messageAccess = $this->isGranted( "cancelRegistration" );
        if( $messageAccess->getStatus() ) {
            $message = ASValidator::cancelRegistration( $args );
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }//function
    
    /*==========================================================================
     * 
     * ADMIN FUNCTIONS
     * 
     *========================================================================*/
    
    //Add a Speaker with a Member and his membership
    public function registerOrganizer( $args ) {
        $messageAccess = $this->isGranted( "registerOrganizer" );
        if( $messageAccess->getStatus() ) {
            $message = ASAdmin::registerOrganizer( $args );
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }//function
    
    // Sets an existing Person as Organizer
    public function setPersonAsOrganizer($person){
        $messageSetPersonAsOrganizer = FSOrganizer::setPersonAsOrganizer($person);
        return $messageSetPersonAsOrganizer;
    }
    
    // Add a team role
    public function addTeamRole( $aName ) {
        $messageAccess = $this->isGranted( "addTeamRole" );
        if( $messageAccess->getStatus() ) {
            $message = ASAdmin::addTeamRole($aName);
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }//function
    
    // Affect a TeamRole with a Organizer
    public function affectTeamRole( $args ) {
        $messageAccess = $this->isGranted( "affectTeamRole" );
        if( $messageAccess->getStatus() ) {
            $message = ASAdmin::affectTeamRole( $args );
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }//function
    
    // Add an Event
    public function addEvent( $args ) {
        $messageAccess = $this->isGranted( "addEvent" );
        if( $messageAccess->getStatus() ) {
            $message = ASAdmin::addEvent( $args );
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }//function
    
    public function addRole( $args ) {
        $messageAccess = $this->isGranted( "addRole" );
        if( $messageAccess->getStatus() ) {
            $message = ASAdmin::addRole( $args );
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }//function
    
    // Change the level of a role
    public function changeRoleLevel( $args ) {
        $messageAccess = $this->isGranted( "changeRoleLevel" );
        if( $messageAccess->getStatus() ) {
            $message = ASAdmin::changeRoleLevel($args);
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }//function
    
    public function linkTeamRole( $args ) {
        $messageAccess = $this->isGranted( "linkTeamRole" );
        if( $messageAccess->getStatus() ) {
            $message = ASAdmin::linkTeamRole($args);
        }
        else {
            $message = $messageAccess;
        }
        return $message; 
    }//function
    
    
    /*==========================================================================
     * 
     * RIGHTS MANAGEMENT FUNCTIONS
     * 
     *========================================================================*/
    /**
     * Adds an access to the database
     * @param Mixed $args Array containing 'Service', the name of the service to
     *        add.
     * @return Message a Message
     */
    public function addAccess( $args ) {
        $messageAccess = $this->isGranted( "manageRights" );
        if( $messageAccess->getStatus() ) {
            $message = ASRightsManagement::addAccess( $args );
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }
    
    /**
     * Deletes completely an access and its Permission from the database
     * @param Mixed $args Array containing 'Service', the name of the service to
     *        delete.
     * @return Message a Message
     */
    public function deleteAccess( $args ) {
        $messageAccess = $this->isGranted( "manageRights" );
        if( $messageAccess->getStatus() ) {
            $message = ASRightsManagement::deleteAccess( $args );
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }
    
    
    
    //---------Appel des fonctions qui se trouvent dans la classe Stub.class.php----------
    
    
    
    public function addSpeakerToSlot( $args ) {
        return $this->stub->addSpeakerToSlot( $args ); 
    }//function
    
        
}//class




?>
