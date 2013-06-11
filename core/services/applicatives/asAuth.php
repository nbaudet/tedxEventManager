<?php
/**
 * Description of asAuth
 *
 * @author Nicolas Baudet <nicolas.baudet@heig-vd.ch>
 */
require_once('../../model/Member.php');
require_once('../../model/Message.php');

class ASAuth {
    
    /**
     * Enables members to login
     * @param mixed $args Array of values for login
     *  id : the member ID
     *  password : the member's password
     * @return aLoggedMember or NULL
     */
    protected function login( $args ) {
        // Get the member with the given arguments
        $member = getMember($args['id']);
        
        // If the member was found in the database
        if ( $member != NULL ) {
            // If the passwords values are the same
            if ( $member->getPassword() == $args['password'] ) {
                // Sets the session variables
                $_SESSION['usr'] = $member->getId();
                $_SESSION['logged'] = true;
                //$units = $member->getAllUnits();
                $units = array(
                    'participant' => 'participant',
                    'validator'   => 'validator'
                );
                $_SESSION['units'] = $units;
                
                // Sets the OK message
                $args = array(
                    'messageNumber' => 001,
                    'message'       => 'User logged',
                    'status'        => true
                    );
                $messageOK = new Message($args);
                return $messageOK;
            }
            // Else wrong password
            else {
                // Sets the NOK message
                $args = array(
                    'messageNumber' => 003,
                    'message'       => 'Wrong password',
                    'status'        => false
                );
                $messageNOK = new Message($args);
                return $messageNOK;
            }
            
            
        }
        
        // If the given member id was not found in the database
        else {
            $args = array(
                'messageNumber' => 002,
                'message'       => 'Login failure',
                'status'        => false
            );
            $messageNOK = new Message($args);
            return $messageNOK;
        }
    }
    
    /**
     * Enables users to logout
     */
    protected function logout() {
        unset($_SESSION);
        session_destroy();
    }
}

?>
