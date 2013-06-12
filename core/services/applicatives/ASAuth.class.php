<?php
/**
 * Description of asAuth
 *
 * @author Nicolas Baudet <nicolas.baudet@heig-vd.ch>
 */
require_once('../../model/Member.php');
require_once('../../model/Message.php');
require_once('../functionnals/FSMember.php');

class ASAuth {
    
    /**
     * The constructor that does nothing
     */
    public function __construct() {
        // Nothing
    }
    
    /**
     * Enables members to login
     * Sets the session variables in order to get the accesses and units
     * for the logged member.
     * @param mixed $args Array of values for login
     *  id : the member ID
     *  password : the member's password
     * @return aLoggedMember or NULL
     */
    public function login( $args ) {
        // Get the member with the given arguments
        $message = FSMember::getMember( $args['id'] );
        
        // If the member was found in the database
        if ( $message->getStatus() ) {
            
            $member = $message->getContent();
            
            // If the passwords values are the same
            if ( $member->getPassword() == $args['password'] ) {
                // Sets the session variables
                $_SESSION['usr']    = $member->getId();
                $_SESSION['units']  = getAllUnits();
                $_SESSION['access'] = getAllAccess();
                
                // Sets the OK message
                $args = array(
                    'messageNumber' => 001,
                    'message'       => 'User logged',
                    'status'        => true
                    );
                $messageOK = new Message( $args );
                return $messageOK;
            }
            // Else : wrong password
            else {
                // Sets the NOK message
                $args = array(
                    'messageNumber' => 003,
                    'message'       => 'Wrong password',
                    'status'        => false
                );
                $messageNOK = new Message( $args );
                return $messageNOK;
            } // else
        } // if

        // Else : the given member id was not found in the database
        else {
            $args = array(
                'messageNumber' => 002,
                'message'       => 'Login failure',
                'status'        => false
            );
            $messageNOK = new Message( $args );
            return $messageNOK;
        }
    }
    
    /**
     * Enables users to logout
     * Clears the Session variables and destroys the session
     */
    public function logout() {
        unset( $_SESSION );
        session_destroy();
        $args = array(
                'messageNumber' => 008,
                'message'       => 'User logged out',
                'status'        => true
            );
        $messageOK = new Message( $args );
        return $messageOK;
    }
    
    /**
     * Checks if the current member is allowed to do the $action.
     * Returns 
     * @param String $action The action we want to check the access for
     * @return boolean
     */
    public function isGranted( $action ) {
        // If $action is not set, returns false
        if(!isset($action) || $action == '') {
            $args = array(
                'messageNumber' => 005,
                'message'       => 'Missing action argument',
                'status'        => false
            );
            $messageNOK = new Message( $args );
            return $messageNOK;
        }
        // If the action is present in the member's session, returns true
        if( array_search( $_SESSION['access'] != false ) ) {
            $args = array(
                'messageNumber' => 006,
                'message'       => 'Access granted',
                'status'        => true
            );
            $messageOK = new Message( $args );
            return $messageOK;
        }
        // Else : the member doesn't have the right
        else {
            $args = array(
                'messageNumber' => 007,
                'message'       => 'Access restricted',
                'status'        => false
            );
            $messageNOK = new Message( $args );
            return $messageNOK;
        }
    }
    
    /**
     * Returns an array with all the units of a member
     * @return Mixed Array of Units for a member
     */
    private function getAllUnits() {
        ///////////////////////////////////////////////////////STUB
        $units = array(
            'participant' => 'participant',
            'validator'   => 'validator'
        );
        return $units;
    }
    
    /**
     * Returns an array of accesses for a member, depending on his/her units
     * @return Mixed 
     */
    private function getAllAccess() {
        ////////////////////////////////////////////////STUB
        $access = array( 
            'readMember', 'getMember', 'getEvent', 'registerToAnEvent'
        );
        return $access;
    }
}

?>
