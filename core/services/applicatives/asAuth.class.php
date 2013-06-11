<?php
/**
 * Description of asAuth
 *
 * @author Nicolas Baudet <nicolas.baudet@heig-vd.ch>
 */
class asAuth {
    
    /**
     * Enables users to login
     * @param mixed $args Array of values for login
     * @return aLoggedMember or NULL
     */
    public function login( $args ) {
        // Get the member with the given arguments
        $member = getMember($args['id'], $args['password']);
        
        // If the member was 
        if ( $member != NULL ) {
            $args = array(
                'messageNumber' => 001,
                'message'       => 'User logged',
                'status'        => true
            );
            $messageOK = new Message($args);
            return $messageOK;
        }
    }
}

?>
