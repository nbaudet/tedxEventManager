<?php
/**
 * Description of asAuth
 *
 * @author Nicolas Baudet <nicolas.baudet@heig-vd.ch>
 */
require_once('../../model/Member.php');
require_once('../../model/Message.php');
require_once('../functionnals/fsMember.php');

class ASAuth {
    
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
        $member = getMember( $args['id'] );
        
        // If the member was found in the database
        if ( $member != NULL ) {
            // If the passwords values are the same
            if ( $member->getPassword() == $args['password'] ) {
                // Sets the session variables
                $_SESSION['usr']    = $member->getId();
                $_SESSION['units']  = $member->getAllUnits();
                $_SESSION['access'] = $member->getAllAccess();
                
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
            }
        }
        
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
    }
    
    /**
     * Checks if the current member is allowed to do the $action.
     * Returns 
     * @param String $action The action we want to check the access for
     * @return boolean
     */
    public function isGranted( $action ) {
        
        // If $action is not set, returns false
        if(!isset($action) || $action == '')
            die("Error with function isGranted(): no parameter set as action");
        
        // If the action is present in the member's session, returns true
        if( array_search($_SESSION['access'] != false))
            return true;
        else
            die("Error : You don't have access to this function.");
    }
}

?>
