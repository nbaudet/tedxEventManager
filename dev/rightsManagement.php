<?php
/**
 * rightsManagement.php enables admin users to set the units and their privile-
 * ges, and assign members to units.
 *
 * @author Nicolas Baudet <nicolas.baudet@heig-vd.ch>
 */
require_once( '../tedx-config.php' );

// Verify if the user is logged
if(!$tedx_manager->isLogged()) {
    header('Location: index.php');
    exit;
}

// Verify the right to access this page
$message = $tedx_manager->isGranted( "manageRights" );
if( !$message->getStatus() ) {
    echo "You don't have sufficient privileges to access this page.";
    exit;
}

// Gets and executes the action
if( isset( $_REQUEST['action'] ) ) {
    
    switch ( $_REQUEST['action'] ) {
    case 'showMember':
        echo 'Show a member';
        break;
    
    case 'registerMember':
        echo 'Register the changes for a member';
        break;

    default:
        echo 'Bad action selected';
        break;
    }
}
else {
    $action = 'showMenu';
}

?>
