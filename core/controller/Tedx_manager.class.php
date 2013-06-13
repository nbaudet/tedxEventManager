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
     * An Auth
     */
    private $asAuth;
    
    private $stub; 
    

    
    public function __construct(){
        $this->asAuth = new ASAuth();
        $this->stub = new Stub();  //new object Stub 

    } // construct
    
   
    
    /**
     * Enable an anonym user to login
     * @param $login    The user's login
     * @param $password The user's password
     * @return Message "User logged" or "Login failure"
     */
    public function login($login, $password){
        if( $this->checkType( "string",  $login ) && $this->checkType( "string", $password ) ){
            $loginArgs = array (
                'id' => $login,
                'password' => $password
            );
            $messageLogin = $this->asAuth->login($loginArgs);
        } else {
            $messageArgs = array (
                'messageNumber' => 004,
                'message' => "Login or password is not a string",
                'status' => FALSE
            );
            $messageLogin = new Message($messageArgs);
        } // else
        return $messageLogin;
    } // function
    
    /**
     * 
     */
    public function logout() {
        return $this->asAuth->logout();
    }
    
    
    
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
    
    
    
    
    //---------Appel des fonctions qui se trouvent dans la classe Stub.class.php----------
    
    

    public function registerVisitor($args) {
        return $this->stub->registerVisitor($args); 
    }//function
    
    
    public function registerToAnEvent($args) {
        return $this->stub->registerToAnEvent($args); 
    }//function
    
    
    public function changeProfil($args) {
        return $this->stub->changePassword($args); 
    }//function
    
    
    public function addKeywordsToAnEvent($args) {
        return $this->stub->addKeywordsToAnEvent($args); 
    }//function
    
    
    public function archiveKeyword($args) {
        return $this->stub->archiveKeyword($args); 
    }//function
    
    
    public function addMotivationToAnEvent($args) {
        return $this->stub->addMovtivationToAnEvent($args); 
    }//function
    
    
    public function archiveMotivationToAnEvent($args) {
        return $this->stub->archiveMotivationToAnEvent($args); 
    }//function
    
    
    public function registerSpeaker($args) {
        return $this->stub->registerSpeaker($args); 
    }//function
    
    
    public function addSpeakerToSlot($args) {
        return $this->stub->addSpeakerToSlot($args); 
    }//function
    
    
    public function changePositionOfSpeakerToEvent($args) {
        return $this->stub->changePositionOfSpeakerToEvent($args); 
    }//function
    
    
    public function addSlotToEvent($args) {
        return $this->stub->addSlotToEvent($args); 
    }//function
    
    
    public function addLocation($args) {
        return $this->stub->addLocation($args); 
    }//function
    
    
    public function changeRegistrationStatus($args) {
        return $this->stub->changeRegistrationStatus($args); 
    }//function
    
    
    public function registerOrganizer($args) {
        return $this->stub->registerOrganizer($args); 
    }//function
    
    
    public function addTeamRole($args) {
        return $this->stub->addTeamRole($args); 
    }//function
    
    
    public function linkTeamRole($args) {
        return $this->stub->linkTeamRole($args); 
    }//function
    
    public function changeRoleLevel($args) {
        return $this->stub->changeRoleLevel($args); 
    }//function
    
    
    public function addRole($args) {
        return $this->stub->addRole($args); 
    }//function
    
    
    public function addEvent($args) {
        return $this->stub->addEvent($args); 
    }//function

    
}//class




?>