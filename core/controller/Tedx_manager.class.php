<?php




/**
 * Require all Applicative Services
 */
require_once(APP_DIR.'core/services/applicatives/ASAuth.class.php');


/**
 * Require all Fonctional Services
 */
//require_once('MemberManager.php');

/**
 * Principal controller of the Events Manager.
 */
class Tedx_manager{
    
    private $asAuth;
    
    public function __construct(){
        $this->asAuth = new AsAuth();
    }
    
    /**
     * Enable an anonym user to login
     * @param $login    The user's login
     * @param $password The user's password
     * @return Message "User logged" or "Login failure"
     */
    public function login($login, $password){
        if (checkType("string",$login) && checkType("string", $password)){
            $loginArgs = array (
                'id' => $login,
                'password' => $password
            );
            $this->asAuth->login($loginArgs);
        } else {
            $messageArgs = array (
                'messageNumber' => 004,
                'message' => "Login or password is not a string",
                'status' => FALSE
            );
            $errorMessage = new Message($messageArgs);
            return $errorMessage;
        }
        
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
    }

}




?>