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
     * @param String $login The user's login
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
    public function getUnit($no) {
        $messageGetUnit = ASFree::getUnit($aNo); 
        return $messageGetUnit;    
    }//function 
    
    
    /**
     * get Units 
     * @return type message
     */
    public function getUnits() {
        $messageGetUnits = ASFree::getUnits();
        return $messageGetUnit; 
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
        $messageAccess = $tedx_manager->auth->isGranted( "registerToAnEvent" );
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
        $messageAccess = $tedx_manager->auth->isGranted( "changeProfile" );
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
        $messageAccess = $tedx_manager->auth->isGranted( "changePassword" );
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
        $messageAccess = $tedx_manager->auth->isGranted( "searchPersons" );
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
        if( $this->asAuth->isLogged() ) {
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
    public function addKeywordsToAnEvent( $args ) {
        $messageAccess = $tedx_manager->auth->isGranted( "addKeywordsToAnEvent" );
        if( $messageAccess->getStatus() ) {
            $message = ASParticipant::addKeywordsToAnEvent( $args );
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }//function
    
    public function archiveKeyword( $args ) {
        $messageAccess = $tedx_manager->auth->isGranted( "archiveKeyword" );
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
        return ASParticipant::getKeyword($args);
    }//function 
    
    //Show all Keywords of a Person
    public function getKeywordsByPerson($aPerson) {
        return ASParticipant::getKeywordsByPerson($aPerson); 
    }//function
    
    //Show all Keywords of a Person for an Event
    public function getKeywordsByPersonForEvent($args) {
        return ASParticipant::getKeywordsByPersonForEvent($args); 
    }//function
    
    //Add a Motivation To An Event
    public function addMotivationToAnEvent($args) {
        $message = ASParticipant::addMotivationToAnEvent($args); 
        return $message;
    }//function
    
    
    public function archiveMotivationToAnEvent($args) {
        $message = ASParticipant::archiveMotivationToAnEvent( $args ); 
        return $message;
    }//function
    
    //Show a Motivation
    public function getMotivation($args) {
        $aMotivation = ASParticipant::getMotivation($args);
        return $aMotivation;    
    }//function 
    
    //Show all Motivations of a Person
    public function getMotivationsByParticipant($aParticipant) {
        $motivations = ASParticipant::getMotivationsByPerson($aParticipant); 
        return $motivations; 
    }//function
    
    //Show all Motivations of a Person for an Event
    public function getMotivationsByParticipantForEvent($args) {
        $motivations = ASParticipant::getMotivationsByPersonForEvent($args); 
        return $motivations; 
    }//function
    
    // Send a registration
    public function sendRegistration( $args ) {
        return ASParticipant::sendRegistration( $args ); 
    }//function
    
    
     /*==========================================================================
     * 
     * ORGANIZER FUNCTIONS
     * 
     *========================================================================*/
    
    //Add a Speaker with a Member and his membership
    public function registerSpeaker( $args ) {
        return ASOrganizer::registerSpeaker($args); 
    }//function
     
    //Add a Location
    public function addLocation($args) {
        $message = ASOrganizer::addLocation( $args ); 
        return $message;
    }//function
    

    //Set an Event Location
    public function changeEventLocation($args) {
        $message = ASOrganizer::changeEventLocation($args); 
        return $message;
    }
    
    public function addSlotToEvent( $args ) {
        return ASOrganizer::addSlotToEvent( $args ); 
        
    }//function
    
    /*==========================================================================
     * 
     * VALIDATOR FUNCTIONS
     * 
     *========================================================================*/
    
    // Accept a registration
    public function acceptRegistration( $args ) {
        return ASValidator::acceptRegistration( $args ); 
    }//function
    
    // Reject a registration
    public function rejectRegistration( $args ) {
        return ASValidator::rejectRegistration( $args ); 
    }//function
    
     /*==========================================================================
     * 
     * ADMIN FUNCTIONS
     * 
     *========================================================================*/
    
    //Add a Speaker with a Member and his membership
    public function registerOrganizer( $args ) {
        return ASAdmin::registerOrganizer( $args ); 
    }//function
    
    // Add a team role
    public function addTeamRole( $aName ) {
        return ASAdmin::addTeamRole($aName); 
    }//function
    
    // Affect a TeamRole with a Organizer
    public function affectTeamRole( $args ) {
        return ASAdmin::affectTeamRole( $args ); 
    }//function
    
    // Add an Event
    public function addEvent( $args ) {
        return ASAdmin::addEvent( $args ); 
    }//function
    
    public function addRole( $args ) {
        return ASAdmin::addRole( $args ); 
    }//function
    
    //---------Appel des fonctions qui se trouvent dans la classe Stub.class.php----------
    
    
    
    public function addSpeakerToSlot( $args ) {
        return $this->stub->addSpeakerToSlot( $args ); 
    }//function
    
    public function changePositionOfSpeakerToEvent( $args ) {
        return $this->stub->changePositionOfSpeakerToEvent( $args ); 
    }//function
        
    public function linkTeamRole( $args ) {
        return $this->stub->linkTeamRole( $args ); 
    }//function
    
    public function changeRoleLevel( $args ) {
        return $this->stub->changeRoleLevel( $args ); 
    }//function
    
}//class




?>
