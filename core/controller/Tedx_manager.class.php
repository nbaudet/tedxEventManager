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
    

    
    public function __construct(){
        $this->asAuth = new ASAuth();
    } // function
    
    
    /**
     * Enable an anonym user to login
     * @param $login    The user's login
     * @param $password The user's password
     * @return Message "User logged" or "Login failure"
     */
    public function login($login, $password){
        if (checkType("string",  $login) && checkType("string", $password)){
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
    }

}




?>