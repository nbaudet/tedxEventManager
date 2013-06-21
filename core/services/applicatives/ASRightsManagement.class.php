<?php
/**
 * Enables superAdmins to change the rights and privileges of the members.
 * Be carefull to check (in the calling document) if the logged member is
 * granted the access to the functions hereunder, using
 * ->  ASAuth::isGranted( "manageRights" );
 *
 * @author Nicolas Baudet <nicolas.baudet@heig-vd.ch>
 */

require_once( APP_DIR.'/core/services/functionnals/FSMember.class.php' );
require_once( APP_DIR.'/core/services/functionnals/FSUnit.class.php' );
require_once( APP_DIR.'/core/services/functionnals/FSPermission.class.php' );

class ASRightsManagement {
    
    
    public static function addAccess( $accessToAdd ) {
        $accessToAdd['Type'] = 'Full';
        return FSAccess::addAccess( $accessToAdd );
    }
}

?>
