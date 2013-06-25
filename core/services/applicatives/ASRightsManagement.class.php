<?php

require_once( APP_DIR.'/core/services/functionnals/FSMember.class.php' );
require_once( APP_DIR.'/core/services/functionnals/FSUnit.class.php' );
require_once( APP_DIR.'/core/services/functionnals/FSPermission.class.php' );


/**
 * ASRightsManagement.class.php
 * 
 * Author : Nicolas Baudet <nicolas.baudet@heig-vd.ch>
 * Date : 25.06.2013
 * 
 * Description : define the class ASRightsManagement as definited in the model
 * Enables superAdmins to change the rigths and privileges of the members. 
 * Be careful to check (in the calling document) if the logged member is 
 * granded the access to the functions herunder, using
 * -> ASAuth::isGranded("manageRights); 
 * 
 */
class ASRightsManagement {
    
    /**
     * Adds an access to the existant accesses
     * @param Mixed $accessToAdd An array with the line "Service".
     * @return Message a Message
     */
    public static function addAccess( $accessToAdd ) {
        $accessToAdd['Type'] = 'Full';
        return FSAccess::addAccess( $accessToAdd );
    }//function
    
    /**
     * 
     * @param Mixed $accessToDelete
     * @return Message a Message
     */
    public static function deleteAccess( $accessToDelete ) {
        $messageAccess = FSAccess::getAccessByService( $accessToDelete );
        // If the accessToDelete exists, we delete it
        if( $messageAccess->getStatus() ) {
            $accessToDelete = $messageAccess->getContent();
            $message = FSAccess::deleteAccess( $accessToDelete );
        }
        // Else: returns an error message
        else {
            $args = array(
                'messageNumber' => 038,
                'message' => 'No matching Access found',
                'status' => false
            );
            $message = new Message( $args );
        }
        return $message;
    }//function
    
    //public static function getAccess
}//class

?>