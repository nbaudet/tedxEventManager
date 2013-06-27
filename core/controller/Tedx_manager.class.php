<?php
/**
 * Tedx_manager.class.php
 * 
 * Author : MIT40
 * Date : 05.06.2013
 * 
 * Description: This class is the entry point of Tedx Events Manager.
 * Every method hereunder is described in the online codex at:
 *    www.pingouin1.heig-vd.ch/tedx-codex/
 * 
 * This class has the following responsibilities:
 *  - offer all needed methods to manage Tedx events
 *  - check the privileges of the method's user
 *  - check the parameter's contents
 * 
 * For all additionnal information, please visit the codex at:
 *    www.pingouin1.heig-vd.ch/tedx-codex/
 * 
 * For bug reports, please leave a precise message on the codex, and we'll con-
 * tact you.
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
require_once(APP_DIR.'/core/services/applicatives/ASDataValidator.class.php');


/**
 * Main controller for the Events Manager.
 */
class Tedx_manager{
    
    /*
     * An ASAuth object. Manages user loging and privileges
     */
    private $asAuth;
    
    /**
     * Constructor of Tedx Manager. Initialise Authentication Object
     */
    public function __construct(){
        $this->asAuth = new ASAuth();
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
        return ASDataValidator::checkType($type, $variableToCheck); 
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
        // Check Data
        $messageCheckData = ASDataValidator::checkData($action);
        
        if ($messageCheckData->getStatus()){
            $return = $this->asAuth->isGranted( $action );
        } else {
            $return = $messageCheckData;            
        }
        return $return;
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
        // Check Data
        $messageCheckData = ASDataValidator::stubCheckData2($login, $password);
        
        if ($messageCheckData->getStatus()){
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
            $return = $messageLogin;
        } else {
            $return = $messageCheckData;
        }
        return $return;        
    } // END login
    
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
        // Check Data
        $messageCheckData = ASDataValidator::stubCheckData($args);
        
        if($messageCheckData->getStatus()){
            $return = ASFree::registerVisitor( $args );
        } else {
            $return = $messageCheckData;
        }
        return $return;
    }//function
    
    /**
     * Applicatives services to get a Registration
     * @param type $args a Status, an Event, a Participant
     * @return type Message The registration.
     */
    public function getRegistration( $args ) {
        // Check Data
        $messageCheckData = ASDataValidator::stubCheckData($args);
        
        if($messageCheckData->getStatus()){
            $return = ASFree::getRegistration( $args );
        } else {
            $return = $messageCheckData;
        }
        return $return;
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
        // Check Data
        $messageCheckData = ASDataValidator::stubCheckData($anEvent);
        
        if($messageCheckData->getStatus()){
            $return = ASFree::getRegistrationsByEvent( $anEvent );
        } else {
            $return = $messageCheckData;
        }
        return $return;
    }//function
    
    /**
     * Returns all the Register of a Participant
     * @param $aParticipant 
     * @return a Message containing the registrations
     */
    public function getRegistrationsByParticipant($participant){
        // Check Data
        $messageCheckData = ASDataValidator::stubCheckData($participant);
        
        if($messageCheckData->getStatus()){
            $return = ASFree::getRegistrationsByParticipant( $participant );
        } else {
            $return = $messageCheckData;
        }
        return $return;
    }
    
    /**
     * Applicatives services to get the Location from an Event
     * @param type $event
     * @return type message
     */
    public function getLocationFromEvent( $anEvent ){
        // Check Data
        $messageCheckData = ASDataValidator::stubCheckData($anEvent);
        
        if($messageCheckData->getStatus()){
            $return = ASFree::getLocationFromEvent( $anEvent );
        } else {
            $return = $messageCheckData;
        }
        return $return;
    }// function
    
    public function getEvent( $args ) {
        // Check Data
        $messageCheckData = ASDataValidator::stubCheckData($args);
        
        if($messageCheckData->getStatus()){
            $return = ASFree::getEvent( $args );
        } else {
            $return = $messageCheckData;
        }
        return $return;
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
        // Check Data
        $messageCheckData = ASDataValidator::stubCheckData($args);
        
        if($messageCheckData->getStatus()){
            $return = ASFree::searchEvent( $args );
        } else {
            $return = $messageCheckData;
        }
        return $return;
    }// function
    
    /**
     * Get an Organizer with its Id
     * @param type $no
     * @return type message
     */
    public function getOrganizer($no){
        // Check Data
        $messageCheckData = ASDataValidator::stubCheckData($no);
        
        if($messageCheckData->getStatus()){
            $return = ASFree::getOrganizer( $no );
        } else {
            $return = $messageCheckData;
        }
        return $return;
    }// function
    
    /**
     * Get Organizers
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
        // Check Data
        $messageCheckData = ASDataValidator::stubCheckData($args);
        
        if($messageCheckData->getStatus()){
            $return = ASFree::getSlot( $args );
        } else {
            $return = $messageCheckData;
        }
        return $return;
    }// function
    
    
    /**
     * Get a Slot(s) in an Event with the Event's Id
     * @param type $args
     * @return type message
     */
    public function getSlotsFromEvent($event){
        // Check Data
        $messageCheckData = ASDataValidator::stubCheckData($event);
        
        if($messageCheckData->getStatus()){
            $return = ASFree::getSlotsByEvent( $event );
        } else {
            $return = $messageCheckData;
        }
        return $return;
    }// function
    
    
    /**
     * get a Participant
     * @param type $args
     * @return type message
     */
    public function getParticipant($args) {
        // Check Data
        $messageCheckData = ASDataValidator::stubCheckData($args);
        
        if($messageCheckData->getStatus()){
            $return = ASFree::getParticipant( $args );
        } else {
            $return = $messageCheckData;
        }
        return $return;
    }//function
    
    
    /**
     * get Participants
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
        // Check Data
        $messageCheckData = ASDataValidator::stubCheckData($slot);
        
        if($messageCheckData->getStatus()){
            $return = ASFree::registerVisitor( $slot );
        } else {
            $return = $messageCheckData;
        }
        return $return;
    }
    
    /**
     * get a Location
     * @param type $args
     * @return type message
     */
    public function getLocation($args) {
        // Check Data
        $messageCheckData = ASDataValidator::stubCheckData($args);
        
        if($messageCheckData->getStatus()){
            $return = ASFree::getLocation( $args );
        } else {
            $return = $messageCheckData;
        }
        return $return;
    }//function 
    
    
    /**
     * get Locations
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
        // Check Data
        $messageCheckData = ASDataValidator::stubCheckData($args);
        
        if($messageCheckData->getStatus()){
            $return = ASFree::getRole( $args );
        } else {
            $return = $messageCheckData;
        }
        return $return; 
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
        // Check Data
        $messageCheckData = ASDataValidator::stubCheckData($event);
        
        if($messageCheckData->getStatus()){
            $return = ASFree::getRolesByEvent( $event );
        } else {
            $return = $messageCheckData;
        }
        return $return;
    }
    
    /**
     * Returns all the Roles of an Organizer
     * @param Event $event
     * @return a Message containing an array of Roles
     */
    public function getRolesByOrganizer($organizer){
        // Check Data
        $messageCheckData = ASDataValidator::stubCheckData($organizer);
        
        if($messageCheckData->getStatus()){
            $return = ASFree::getRolesByOrganizer( $organizer );
        } else {
            $return = $messageCheckData;
        }
        return $return;
    }
    
    
    /**
     * get a TeamRole
     * @param type $args
     * @return type message
     */
    public function getTeamRole($args) {
        // Check Data
        $messageCheckData = ASDataValidator::stubCheckData($args);
        
        if($messageCheckData->getStatus()){
            $return = ASFree::getTeamRole( $args );
        } else {
            $return = $messageCheckData;
        }
        return $return;
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
        // Check Data
        $messageCheckData = ASDataValidator::stubCheckData($organizer);
        
        if($messageCheckData->getStatus()){
            $return = ASFree::getTeamRolesByOrganizer( $organizer );
        } else {
            $return = $messageCheckData;
        }
        return $return;
    }
    
    
    /**
     * get a Person 
     * @param type $no
     * @return type message
     */
    public function getPerson($no) {
        // Check Data
        $messageCheckData = ASDataValidator::stubCheckData($no);
        
        if($messageCheckData->getStatus()){
            $return = ASFree::getPerson( $no );
        } else {
            $return = $messageCheckData;
        }
        return $return;
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
        // Check Data
        $messageCheckData = ASDataValidator::stubCheckData($aNo);
        
        if($messageCheckData->getStatus()){
            $return = ASFree::getUnit( $aNo );
        } else {
            $return = $messageCheckData;
        }
        return $return;   
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
        // Check Data
        $messageCheckData = ASDataValidator::stubCheckData($args);
        
        if($messageCheckData->getStatus()){
            $return = ASFree::getEventsBySpeaker( $args );
        } else {
            $return = $messageCheckData;
        }
        return $return;
    }//function 
    
    /**
     * get Units 
     * @return type message
     */
    public function getSpeakersByEvent($args) {
        // Check Data
        $messageCheckData = ASDataValidator::stubCheckData($args);
        
        if($messageCheckData->getStatus()){
            $return = ASFree::getSpeakersByEvent( $args );
        } else {
            $return = $messageCheckData;
        }
        return $return;
    }//function 
    
    /**
     * get Places by Slots given in args 
     * @return type message
     */
    public function getPlacesBySlot($slot) {
        // Check Data
        $messageCheckData = ASDataValidator::stubCheckData($slot);
        
        if($messageCheckData->getStatus()){
            $return = ASFree::getPlacesBySlot( $slot );
        } else {
            $return = $messageCheckData;
        }
        return $return;
    }//function 
    
    /**
     * get Speakers by Place given in args 
     * @return type message
     */
    public function getSpeakerByPlace($place) {
        // Check Data
        $messageCheckData = ASDataValidator::stubCheckData($place);
        
        if($messageCheckData->getStatus()){
            $return = ASFree::getSpeakerByPlace( $place );
        } else {
            $return = $messageCheckData;
        }
        return $return;
    }//function 
    
    /**
     * get a Speaker with its Id
     * @return type message
     */
    public function getSpeaker($args) {
        // Check Data
        $messageCheckData = ASDataValidator::stubCheckData($args);
        
        if($messageCheckData->getStatus()){
            $return = ASFree::getSpeaker( $args );
        } else {
            $return = $messageCheckData;
        }
        return $return;
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
        // Check Data
        $messageCheckData = ASDataValidator::stubCheckData($args);
        
        if($messageCheckData->getStatus()){
            $return = ASFree::getTalk( $args );
        } else {
            $return = $messageCheckData;
        }
        return $return;
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
        // Check Data
        $messageCheckData = ASDataValidator::stubCheckData($aSpeaker);
        
        if($messageCheckData->getStatus()){
            $return = ASFree::getTalksBySpeaker( $aSpeaker );
        } else {
            $return = $messageCheckData;
        }
        return $return;
    }//function 
    
    /**
     * get All Organizers for an event with all his roles
     * @return type message
     */
    public function getOrganizersByEvent($anEvent) {
        // Check Data
        $messageCheckData = ASDataValidator::stubCheckData($anEvent);
        
        if($messageCheckData->getStatus()){
            $return = ASFree::getOrganizersByEvent( $anEvent );
        } else {
            $return = $messageCheckData;
        }
        return $return;
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
    
   
   /**
    * Add Keywords to an Event
    * @param type $args
    * @return type message
    */
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
     * get a Keyword 
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
    
    
    /**
     * Show all Keywords of a person
     * @param type $aPerson
     * @return type message
     */
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
    
    
    /**
     * Show all Keywords of a Person for an Event
     * @param type $args
     * @return type message
     */
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
    
    
    /**
     * Add a Motivation to an Event
     * @param type $args
     * @return type message
     */
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
    
    
    /**
     * Archive Motivation to an Event
     * @param type $args
     * @return type message
     */
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
    
    /**
     * Show a Motivation
     * @param type $args
     * @return type message
     */
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
    
    /**
     * Show Motivation by Participant
     * @param type $aParticipant
     * @return type message
     */
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
    

    /**
     * Show all Motivations of a Person for an Event
     * @param type $args
     * @return type message
     */
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
    
    
    /**
     * Send a Registration 
     * @param type $args
     * @return type message
     */
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
    
 
    /**
     * Show the Registration history of a Person for an Event
     * @param type $args
     * @return type message
     */
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
    

    /**
     * Add a Speaker with a Member and his Membership
     * @param type $args
     * @return type message
     */
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
     
    /**
     * Add a Location
     * @param type $args
     * @return type message
     */
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
    
    /**
     * Set an Event Location
     * @param type $args
     * @return type message
     */
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
    
    /**
     * Add a Slot to an Event
     * @param type $args
     * @return type message
     */
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
    

    
    /**
     * Change the Position of a Speaker to an Event
     * @param type $args
     * @return type message
     */
    public function addSpeakerToPlace( $args ) {
        $messageAccess = $this->isGranted( "addSpeakerToPlace" );
        if( $messageAccess->getStatus() ) {
            $message = ASOrganizer::addSpeakerToPlace( $args ); 
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }//function
    
    
    public function changePositionOfSpeaker( $args ) {
        $messageAccess = $this->isGranted( "changePositionOfSpeaker" );
        if( $messageAccess->getStatus() ) {
            $message = ASOrganizer::changePositionOfSpeaker( $args ); 
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }//function
    
    /**
     * Set an Event but let it non archived
     * @param type $args
     * @return type message
     */
    public function setEventAndLetArchive( $args ) {    
        $messageAccess = $this->isGranted( "setEventAndLetArchive" );
        if( $messageAccess->getStatus() ) {
            $message = ASOrganizer::setEventAndLetArchive( $args ); 
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }
     
    /**
     * Change the parameters of an Event
     * @param array $args
     * @return Message with the changed Event
     */
    public function changeEvent( $args ) {    
        $messageAccess = $this->isGranted( "changeEvent" );
        if( $messageAccess->getStatus() ) {
            $message = ASOrganizer::changeEvent( $args ); 
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }    
    
    /**
     * Change the parameters of a Location
     * @param array $args
     * @return Message with the changed Location
     */
    public function changeLocation( $args ) {    
        $messageAccess = $this->isGranted( "changeLocation" );
        if( $messageAccess->getStatus() ) {
            $message = ASOrganizer::changeLocation( $args ); 
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }
    
    /**
     * Change the parameters of a Slot
     * @param array $args
     * @return Message with the changed Slot
     */
    public function changeSlot( $args ) {    
        $messageAccess = $this->isGranted( "changeSlot" );
        if( $messageAccess->getStatus() ) {
            $message = ASOrganizer::changeSlot( $args ); 
        }
        else {
            $message = $messageAccess;
        }
        return $message;
    }
    
    /*==========================================================================
     * 
     * VALIDATOR FUNCTIONS
     * 
     *========================================================================*/
    
    /**
     * Accept a Registration
     * @param type $args
     * @return type message
     */
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
    
    
    /**
     * Reject a Registration
     * @param type $args
     * @return type message
     */
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
     * Cancel the status of a registration, and put 
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
    

    /**
     * Add a Speaker with a Member and his Membership
     * @param type $args
     * @return type message
     */
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
    

    /**
     * Sets an existing Person as Organizer
     * @param type $person
     * @return type message
     */
    public function setPersonAsOrganizer($person){
        $messageSetPersonAsOrganizer = FSOrganizer::setPersonAsOrganizer($person);
        return $messageSetPersonAsOrganizer;
    }
    
    /**
     * Add a TeamRole
     * @param type $aName
     * @return type message
     */
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
    
  
    /**
     * Affect a TeamRole with an Organizer
     * @param type $args
     * @return type message
     */
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
    
    
    /**
     * Add an Event
     * @param type $args
     * @return type message
     */
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
    
    /**
     * Add a Role
     * @param type $args
     * @return type message
     */
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
    
    
    /**
     * Change the Level of a Role
     * @param type $args
     * @return type message
     */
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
    
    
    /**
     * Link a TeamRole
     * @param type $args
     * @return type message
     */
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
    
        
}//class

