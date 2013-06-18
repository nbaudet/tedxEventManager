<?php
/**
 * rightsManagement.php enables admin users to set the units and their privile-
 * ges, and assign members to units.
 *
 * @author Nicolas Baudet <nicolas.baudet@heig-vd.ch>
 */
require_once( '../tedx-config.php' );
require_once( APP_DIR.'/core/services/functionnals/FSMember.class.php' );
require_once( APP_DIR.'/core/services/functionnals/FSUnit.class.php' );
require_once( APP_DIR.'/core/model/Member.class.php' );
require_once( APP_DIR.'/core/model/Unit.class.php' );

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
        die("<h2>You don't have sufficient privileges to access this page.</h2>
            <p><a href=\"../index.php\">Back to home</a><br />
            <a href=\"?action=logout\">Log out</a></p>");
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
    case 'seeMembersUnits':
        echo '<h1>See the members\' units</h1>';
        echo '<p><a href="?">Go back</a></p>';
        $members = FSMember::getMembers()->getContent();
        showMembers( $members );
        break;
    
    case 'displayMember':
        echo '<h1>Members\' units</h1>';
        echo '<p><a href="?">Go back</a></p>';
        showMember();
        break;
    
    case 'updateMember':
        echo '<h1>Register the changes for a member</h1>';
        echo '<p><a href="?">Go back</a></p>';
        updateMember();
        break;
    
    case 'seeUnitsAccesses':
        echo '<h1>See the units\' accesses</h1>';
        echo '<p><a href="?">Go back</a></p>';
        break;
    
    case 'updateUnit':
        echo '<h1>Register the changes for a unit</h1>';
        echo '<p><a href="?">Go back</a></p>';
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
    //var_dump($_SESSION);
    echo '<h2>Welcome to the rights management page</h2>
    <p>Select one of the option to access the corresponding page</p>
    <ul>
        <li><a href="?action=seeMembersUnits">See the members\' units</a></li>
        <li><a href="?action=seeUnitsAccesses">See the units\' accesses</a></li>
        <li><a href="?action=logout">Log out</a></li>
    </ul>
    ';
}


function showMembers( $members ) {
    $tabOfAllUnits = getAllUnits();
    
    // Construct the table to display
    echo '<table><tr>'.PHP_EOL;
    echo '<th>Login\Units</th>';
    foreach($tabOfAllUnits as $unit){
        echo '<th>'.$unit.'</th>';
    }
    echo '<th>Update</th></tr>'.PHP_EOL;
    
    $lineColor = 0;
    foreach( $members as $member ) {
        
        echo '<tr style="background-color: '. ($lineColor++%2 == 0 ? 'lightgray' : 'whitesmoke') .';">'.PHP_EOL;
        
        $tabUnitsOfMember = getAllUnitsFromMember( $member );
        
        echo '<td>'.$member->getID().'</td>';
        foreach ( $tabOfAllUnits as $unit ) {

            if( in_array( $unit, $tabUnitsOfMember ) ) {
                echo '<td style="text-align: center;">&#10003;</td>';
            }
            else {
                echo '<td style="text-align: center; color: darkgray;">&#10005;</td>';
            }
        }
        echo '<td><a href="?action=displayMember&memberID='.$member->getID().'">Change rights</a></td></tr>'.PHP_EOL;
    }
    echo '</table>'.PHP_EOL;
}

/**
 * Show the Units of a Member in a form, so you can choose which one the member
 * is going to be part of.
 */
function showMember() {
    if( isset( $_REQUEST['memberID'] ) ) {
        $member = FSMember::getMember( $_REQUEST['memberID'] )->getContent();
        
        $tabOfAllUnits = getAllUnits();
        
        $tabUnitsOfMember = getAllUnitsFromMember( $member );
        
        echo '<form method="POST">
            <input type="hidden" id="action" name="action" value="updateMember" />
            <input type="hidden" id="memberID" name="memberID" value="'.$member->getId().'" />'.PHP_EOL;
        
        foreach ( $tabOfAllUnits as $unit ) {
            if( in_array( $unit, $tabUnitsOfMember ) ) {
                echo '<input type="checkbox" id="'.$unit.'" name="'.$unit.'" checked />';
            }
            else {
                echo '<input type="checkbox" id="'.$unit.'" name="'.$unit.'" />';
            }
            echo '<label for="'.$unit.'">'.$unit.'</label>'.PHP_EOL;
            echo '<br />'.PHP_EOL;
        }
        
        echo '<input type="submit" value="Change rights" />
            </form>';
    }
    else {
        echo 'Error: no member set.';
    }
}


function updateMember() {
    var_dump($_REQUEST);
}

/**
 * Get all the existing units and make an array
 * @return Mixed Array of all the units
 */
function getAllUnits() {
    $units = FSUnit::getAllUnits()->getContent();
    $tabOfAllUnits = array();
    foreach ( $units as $unit) {
        $tabOfAllUnits[] = $unit->getName();
    }
    return $tabOfAllUnits;
}

/**
 * Get all the units of a member and make an array
 * @param Member The member to get the units from.
 * @return Mixed An array with units
 */
function getAllUnitsFromMember( $member ) {
    $unitsOfMember = FSUnit::getAllUnitsFromMember( $member )->getContent();
    $tabUnitsOfMember = array();
    foreach($unitsOfMember as $unit){
        $tabUnitsOfMember[] = $unit->getName();
    }
    return $tabUnitsOfMember;
}

?>
