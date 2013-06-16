<?php
/**
 * rightsManagement.php enables admin users to set the units and their privile-
 * ges, and assign members to units.
 *
 * @author Nicolas Baudet <nicolas.baudet@heig-vd.ch>
 */
require_once( '../tedx-config.php' );

/*echo '<h2>Session</h2>';
var_dump($_SESSION);
echo '<h2>Request</h2>';
var_dump($_REQUEST);*/


// Is the user logged ?
// yes -> Does he have sufficient rights ?
//        yes -> show the menu / do the action
//        no  -> show him error message
// no  -> Is he trying to login ?
//        yes -> try to login
//        no  -> show him login form

// Is the user trying to log out ?
if( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'logout' ) {
    $tedx_manager->logout();
}

if( $tedx_manager->isLogged() ) {
    //echo 'user logged<br />';
    $message = $tedx_manager->isGranted( "manageRights" );
    if( $message->getStatus() ) {
        //echo $message->getMessage().'<br />';
        // Nothing to do here.
    }
    // Else : No sufficient rights
    else {
        die("You don't have sufficient privileges to access this page.<br />
            <a href=\"../index.php\">Back to home</a><br />
            <a href=\"?action=logout\">Log out</a>");
    }
}
else {
    if ( isset($_REQUEST['action'] ) && $_REQUEST['action'] == 'login' ) {
        //echo 'User tries to login';
        // Nothing to do here.
    }
    else {
        //echo 'User not logged, and wants to login<br />';
        $_REQUEST['action'] = 'loginForm';
    }
}


// Gets and executes the action
if( isset( $_REQUEST['action'] ) ) {
    
    switch ( $_REQUEST['action'] ) {
    case 'showAllMembers':
        echo 'Show all the members';
        break;
    
    case 'registerMember':
        echo 'Register the changes for a member';
        break;
    
    case 'showAllUnits':
        echo 'Show all the units';
        break;
    
    case 'loginForm':
        loginForm();
        break;

    case 'login':
        $message = $tedx_manager->login( $_REQUEST['id'], $_REQUEST['password'] );
        if( $message->getStatus() ) {
            header( "Location: rightsManagement.php" );
        }
        else {
            header( "Location: rightsManagement.php?try=fail" );
        }
        break;
    
    case '':
        showMenu();
        break;
    
    default:
        showMenu();
        break;
    }
}
else {
    showMenu();
}


function loginForm(){
    if( isset( $_REQUEST['try'] ) && $_REQUEST['try'] == 'fail' ) {
        echo '<p style="color: crimson;"><strong>Login failed</strong></p>';
    }
    echo '<h2>Hello! You must login to manage rights</h2>';
    echo '<form method="POST">
        <label for="id">Login</label>
        <input type="texte" id="id" name="id" /><br />
        <label for="password">Password</label>
        <input type="password" id="password" name="password" /><br />
        <input type="hidden" id="action" name="action" value="login" />
        <input type="submit" value="login" />';
}

function showMenu(){
    echo '<h2>Welcome to the rights management page</h2>
    <p>Select one of the option to access the corresponding page</p>
    <ul>
        <li><a href="?action=showAllMembers">Show all the members</a></li>
        <li><a href="?action=showAllUnits">Show all the units</a></li>
        <li><a href="?action=logout">Log out</a></li>
    </ul>
    ';
}

?>
