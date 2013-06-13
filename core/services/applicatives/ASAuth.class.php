<?php
/**
 * Description of asAuth
 *
 * @author Nicolas Baudet <nicolas.baudet@heig-vd.ch>
 */
require_once(APP_DIR.'/core/model/Member.class.php');
require_once(APP_DIR.'/core/model/Message.class.php');
require_once(APP_DIR.'/core/services/functionnals/FSMember.class.php');
require_once(APP_DIR.'/core/services/functionnals/FSUnit.class.php');
require_once(APP_DIR.'/core/services/functionnals/FSAccess.class.php');


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
            if ( $member->getPassword() == md5( $args['password'] ) ) {
                // Sets the session variables
                $_SESSION['usr']    = $member->getId();
                $_SESSION['units']  = $this->getAllUnits( $member );
                $unitNumbers = $this->getAllUnitsNumbers( $member );
                $_SESSION['access'] = $this->getAllAccesses( $unitNumbers );
                //var_dump($_SESSION['units']);
                
                // Sets the OK message
                $args = array(
                    'messageNumber' => 001,
                    'message'       => 'User logged',
                    'status'        => true,
                    'content'       => $member
                    );
                $messageOK = new Message( $args );
                
                // Easter Egg : Spécialement  pour toi, Gabor ! :)
                if($member->getId() == 'gabor' ){
                    echo '<img href="http://www.baudet.me/heig/gabor.jpg" title="Les jolies courbes des IT pour Gabor" height="100px" />';
                }
                
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
        } // else
    } // function
    
    /**
     * Enables users to logout
     * Clears the Session variables and destroys the session
     */
    public function logout() {
        if( isset( $_SESSION['usr'] ) ) {
            session_destroy();
            unset( $_SESSION );

            $args = array(
                    'messageNumber' => 8,
                    'message'       => 'User logged out',
                    'status'        => true
                );
            $messageOK = new Message( $args );
            return $messageOK;
        }
        else {
            $args = array(
                    'messageNumber' => 9,
                    'message'       => 'User already logged out',
                    'status'        => false
                );
            $messageNOK = new Message( $args );
            return $messageNOK;
        }
        
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
        
        // If the user is not logged, returns false
        if( !isset( $_SESSION['usr'] ) ) {
            $args = array(
                'messageNumber' => 010,
                'message'       => 'Need to login first',
                'status'        => false
            );
            $messageNOK = new Message( $args );
            return $messageNOK;
        }
        
        // If the action is present in the member's session, returns true
        //if( array_search( $action, $_SESSION['access'] ) === true ) {
        if( array_search( $action, $_SESSION['access'] ) === false ) {
            $args = array(
                'messageNumber' => 007,
                'message'       => 'Access restricted',
                'status'        => false
            );
            $messageNOK = new Message( $args );
            return $messageNOK;
        }
        // Else : the member doesn't have the right
        else {
            $args = array(
                'messageNumber' => 006,
                'message'       => 'Access granted',
                'status'        => true
            );
            $messageOK = new Message( $args );
            return $messageOK;
        }
    }
    
    /**
     * Let you know if the current visitor of the page is logged or not
     * @return boolean Returns if the current user is logged or not 
     */
    public function isLogged() {
        if( isset( $_SESSION['usr'] ) )
            return true;
        else
            return false;
    }
    
    /**
     * Returns the member's username. Exists only if the user is logged
     * @return string The member's username
     */
    public function getUsername() {
        return $_SESSION['usr'];
    }
    
    /**
     * Returns an array with all the units of a member
     * @return Mixed Array of Units for a member
     */
    private function getAllUnits( $member ) {
        $units = FSUnit::getAllUnitsForMember( $member );
        return $units;
    }
    
    /**
     * Returns an array with all the units of a member
     * @return Mixed Array of Units for a member
     */
    private function getAllUnitsNumbers( $member ) {
        $units = FSUnit::getAllUnitsNumbersForMember( $member );
        return $units;
    }
    
    /**
     * Returns an array of accesses for a member, depending on his/her units
     * @return Mixed 
     */
    private function getAllAccesses( $units ) {
        $tabAccesses = array();
        foreach( $units as $unit ) {
            $tabAccesses[] = FSAccess::getAllAccessesForUnit($unit);
        }
        
        // Merge the two arrays
        $accesses = array();
        foreach( $tabAccesses as $extAccesses ){
            foreach( $extAccesses as $intAccess ) {
                $accesses[] = $intAccess;
            }
        }
        // Remove the redundancies in accesses
        $accesses = array_unique($accesses);

        return $accesses;
    }
}

?>
