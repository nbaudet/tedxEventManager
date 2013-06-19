<?php
/**
 * The Auth applicative service enables registered members to login to the site.
 * The class also computes the rights and privileges to the application.
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
    } // function
    
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
        // message to return
        $messageReturn;

        // If the member was found in the database
        if ( $message->getStatus() ) {
            
            $member = $message->getContent();
            
            // If the passwords values are the same
            if ( $member->getPassword() == md5( $args['password'] ) ) {
                // Sets the session variables
                $_SESSION['usr']    = $member->getId();
                // get alls units from member
                $messageUnits = $this->getUnitsFromMember( $member );
                
                // if message units 
                if($messageUnits->getStatus()){
                    $_SESSION['units']  = $messageUnits->getContent();
                }// if
                else { // error send message untis
                    return $messageUnits;
                }// else
                $_SESSION['access'] = $this->getAccessesFromUnits( $_SESSION['units'] );
                
                // Sets the OK message
                $args = array(
                    'messageNumber' => 001,
                    'message'       => 'User logged',
                    'status'        => true,
                    'content'       => $member
                    );
                
                $messageReturn = new Message( $args );
                
                // Easter Egg : Spécialement  pour toi, Gabor ! :)
                if($member->getId() == 'gabor' ){
                    echo '<img src="../common/gabor.jpg" title="Les jolies courbes des IT pour Gabor" height="200px" />';
                }// if
                
            }// if
            // Else : wrong password
            else {
                // Sets the NOK message
                $args = array(
                    'messageNumber' => 003,
                    'message'       => 'Wrong password',
                    'status'        => false
                );
                $messageReturn = new Message( $args );
            } // else
        } // if

        // Else : the given member id was not found in the database
        else {
            $args = array(
                'messageNumber' => 002,
                'message'       => 'Login failure',
                'status'        => false
            );
            $messageReturn = new Message( $args );
        } // else
        return $messageReturn;
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
        }// if
        else {
            $args = array(
                    'messageNumber' => 9,
                    'message'       => 'User already logged out',
                    'status'        => false
                );
            $messageNOK = new Message( $args );
            return $messageNOK;
        }// else
        
    }// function
    
    /**
     * Checks if the current member is allowed to do the $action.
     * Returns
     * @param String $action The action we want to check the access for
     * @return boolean
     */
    public function isGranted( $action ) {
        // return var
        $message ; 
        
        // If action is set & action different than nothing
        if( isset( $action ) && $action != '' ) {
            // user specified
            if( isset( $_SESSION['usr'] ) ){
                // if access founds in array access
                if( array_search( $action, $_SESSION['access'] ) !== false ){
                    $args = array(
                        'messageNumber' => 006,
                        'message'       => 'Access granted',
                        'status'        => true
                    );
                    $message = new Message( $args );
                }// if
                else {
                    $args = array(
                        'messageNumber' => 007,
                        'message'       => 'Access restricted',
                        'status'        => false
                    );
                    $message = new Message( $args );
                }// else
            }// if
            else{ // user is not logged, returns false
                 $args = array(
                'messageNumber' => 010,
                'message'       => 'Need to login first',
                'status'        => false
                 );
                $message = new Message( $args );
            }// else
        }// if
        else { // $action is not set, returns false
            $args = array(
                'messageNumber' => 005,
                'message'       => 'Missing action argument',
                'status'        => false
            );
            $message = new Message( $args );
        }// else
        // return message
        return $message;
    }// function
    
    /**
     * Let you know if the current visitor of the page is logged or not
     * @return boolean Returns if the current user is logged or not 
     */
    public function isLogged() {
        if( isset( $_SESSION['usr'] ) )
            return true;
        else
            return false;
    }// function
    
    /**
     * Returns the member's username. Exists only if the user is logged
     * @return string The member's username
     */
    public function getUsername() {
        if( isset( $_SESSION['usr'] ) )
            return $_SESSION['usr'];
        else
            return FALSE;
    }// function
    
    /**
     * Returns an array with all the units of a member
     * @return Mixed Array of Units for a member
     */
    private function getUnitsFromMember( $member ) {
        $units = FSUnit::getUnitsFromMember( $member );
        return $units;
    }// function
    
    /**
     * Returns an array with all the units of a member
     * @return Mixed Array of Units for a member
     */
    private function getAllUnitsNumbers( $member ) {
        $units = FSUnit::getAllUnitsNumbersForMember( $member );
        return $units;
    }// function
    
    /**
     * Returns an array of accesses for a member, depending on his/her units
     * @param $units Mixed of objects units
     * @return Mixed of 
     */
    private function getAccessesFromUnits( $units ) {
        $tabAccesses = array();
        
        foreach( $units as $unit ) {
            $messageAccess = FSAccess::getAccessesFromUnit( $unit );
            $tabAccesses[] = $messageAccess->getContent();
        }// foreach
        
        // Merge the two arrays
        $accesses = array();
        //var_dump($tabAccesses);
        foreach( $tabAccesses as $extAccesses ) {
            foreach( $extAccesses as $intAccess ) {
                $accesses[] = $intAccess;
            } // foreach
        }// foreach
        // Remove the redundancies in accesses
        $accesses = array_unique( $accesses );

        return $accesses;
    }// function
}// class

?>
