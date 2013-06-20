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
require_once( APP_DIR.'/core/services/functionnals/FSPermission.class.php' );
/*require_once( APP_DIR.'/core/model/Member.class.php' );
require_once( APP_DIR.'/core/model/Unit.class.php' );*/

echo '<h2>Session</h2>';
var_dump($_SESSION);
echo '<h2>Request</h2>';
var_dump($_REQUEST);


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
        echo '<p><a href="?action=seeMembersUnits">Return to members\' units</a><br />';
        echo '<a href="?">Go back</a></p>';
        showMember();
        break;
    
    case 'updateMember':
        echo '<h1>Register the changes for a member</h1>';
        echo '<p><a href="?action=seeMembersUnits">Return to members\' units</a><br />';
        echo '<a href="?">Go back</a></p>';
        updateMember();
        break;
    
    case 'seeAccessesUnits':
        echo '<h1>See the accesses\' units</h1>';
        echo '<p><a href="?">Go back</a></p>';
        $accesses = FSAccess::getAccesses()->getContent();
        showAccesses( $accesses );
        break;
    
    case 'displayAccess':
        echo '<p><a href="?action=seeAccessesUnits">Return to accesses\' units</a><br />';
        echo '<a href="?">Go back</a></p>';
        showAccess();
        break;
    
    case 'addAccess':
        addAccess();
        echo '<h1>See the accesses\' units</h1>';
        echo '<p><a href="?">Go back</a></p>';
        $accesses = FSAccess::getAccesses()->getContent();
        showAccesses( $accesses );
        break;
    
    case 'updateAccess':
        echo '<h1>Register the changes for an access</h1>';
        echo '<p><a href="?action=seeAccessesUnits">Return to accesses\' units</a><br />';
        echo '<a href="?">Go back</a></p>';
        updateAccess();
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
        <li><a href="?action=seeAccessesUnits">See the accesses\' units</a></li>
        <li><a href="?action=logout">Log out</a></li>
    </ul>
    ';
}


function showMembers( $members ) {
    $tabOfAllUnits = getUnitsAsString();
    
    // Construct the table to display
    echo '<table><tr>'.PHP_EOL;
    echo '<th>Login\Unit</th>';
    foreach($tabOfAllUnits as $unit){
        echo '<th>'.$unit.'</th>';
    }
    echo '<th>Update</th></tr>'.PHP_EOL;
    
    $lineColor = 0;
    foreach( $members as $member ) {
        
        echo '<tr style="background-color: '. ($lineColor++%2 == 0 ? 'lightgray' : 'whitesmoke') .';">'.PHP_EOL;
        
        $tabUnitsOfMember = getUnitsFromMember( $member );
        
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

function showAccesses( $accesses ) {
    
    // Echo a small for to add accesses to the application
    echo '<form method="POST">
            <fieldset style="width: 250px;">
                <legend>Add a new Access</legend>
                <input type="hidden" id="action" value="addAccess" />
                <label for="service">Access name:</label>
                <input type="text" id="service" name="service" /><br />
                <input type="submit" value="Add Access" />
            </fieldset>
        </form>';



    //$tabOfAllAccesses = FSAccess::getAccesses()->getContent();
    $tabOfAllUnits = getUnitsAsString();
    
    // Construct the table to display
    echo '<table><tr>'.PHP_EOL;
    echo '<th>Access\Unit</th>';
    foreach($tabOfAllUnits as $unit){
        echo '<th>'.$unit.'</th>';
    }
    echo '<th>Update</th></tr>'.PHP_EOL;
    
    $lineColor = 0;
    foreach( $accesses as $access ) {
        
        echo '<tr style="background-color: '. ($lineColor++%2 == 0 ? 'lightgray' : 'whitesmoke') .';">'.PHP_EOL;
        
        $tabUnitsOfAccess = getUnitsFromAccess( $access );
        
        echo '<td>'.$access->getService().'</td>';
        foreach ( $tabOfAllUnits as $unit ) {

            if( in_array( $unit, $tabUnitsOfAccess ) ) {
                echo '<td style="text-align: center;">&#10003;</td>';
            }
            else {
                echo '<td style="text-align: center; color: darkgray;">&#10005;</td>';
            }
        }
        echo '<td><a href="?action=displayAccess&AccessNo='.$access->getNo().'">Change units</a></td></tr>'.PHP_EOL;
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
        $tabUnitsOfMember = getUnitsFromMember( $member );
        
        $tabOfAllUnits = getUnitsAsString();
        
        echo '<h1>Change <em>'.$member->getId().'</em>\'s units</h1>';
        
        echo '<form method="POST" action="">
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


/**
 * Show the Units of an Access and enables to choose which ones are linked or not.
 */
function showAccess() {
    if( isset( $_REQUEST['AccessNo'] ) ) {
        $access = FSAccess::getAccess( $_REQUEST['AccessNo'] )->getContent();
        $tabUnitsOfAccess = getUnitsFromAccess( $access );
        
        $tabOfAllUnits = getUnitsAsString();
        
        echo '<h1>Change <em>'.$access->getService().'</em>\'s units</h1>';
        
        echo '<form method="POST" action="">
            <input type="hidden" id="action" name="action" value="updateAccess" />
            <input type="hidden" id="memberID" name="memberID" value="'.$access->getNo().'" />'.PHP_EOL;
        
        foreach ( $tabOfAllUnits as $unit ) {
            if( in_array( $unit, $tabUnitsOfAccess ) ) {
                echo '<input type="checkbox" id="'.$unit.'" name="'.$unit.'" checked />';
            }
            else {
                echo '<input type="checkbox" id="'.$unit.'" name="'.$unit.'" />';
            }
            echo '<label for="'.$unit.'">'.$unit.'</label>'.PHP_EOL;
            echo '<br />'.PHP_EOL;
        }
        
        echo '<input type="submit" value="Change Units" />
            </form>';
    }
    else {
        echo 'Error: no Access set.';
    }
}

function updateMember() {
    
    global $tedx_manager;
    
    $tabRequest = $_REQUEST;
    $memberID = $tabRequest['memberID'];
    unset($tabRequest['action']);
    unset($tabRequest['memberID']);
    $checkedUnits = $tabRequest;
    
    // Gets all the units a member is part of
    $member = FSMember::getMember($memberID)->getContent();
    $tabUnitsOfMember = getUnitsFromMember( $member );
    
    $tabOfAllUnits = getUnitsAsString();
    
    foreach( $tabOfAllUnits as $unit ) {
        // If the member was already granted this access
        if( in_array( $unit, $tabUnitsOfMember ) ) {
            // If it was checked
            if( isset( $checkedUnits[$unit] ) ) {
                // do nothing
                //echo $unit.' already granted<br />';
            }
            // Change this right
            else {
                // change the right
                echo 'Successfully changed the membership to '.$unit.'<br />';
                $objectUnit = FSUnit::getUnitByName($unit)->getContent();
                $args = array(
                    'member' => $member,
                    'unit'   => $objectUnit
                );
                FSMembership::upsertMembership( $args );
            }
        }
        
        // If this access was not yet granted
        else {
            // If it was checked
            if ( isset( $checkedUnits[$unit] ) ) {
                // change this right
                echo 'Successfully changed the membership to '.$unit.'<br />';
                $objectUnit = FSUnit::getUnitByName($unit)->getContent();
                $args = array(
                    'member' => $member,
                    'unit'   => $objectUnit
                );
                $message = FSMembership::upsertMembership( $args );
            }
            else {
                // do nothing
                //echo $unit.' already not granted<br />';
            }
            
        }
    }
    showMember();
}

function updateAccess() {
    
    global $tedx_manager;
    
    $tabRequest = $_REQUEST;
    $accessNo = $tabRequest['AccessNo'];
    unset($tabRequest['action']);
    unset($tabRequest['AccessNo']);
    $checkedUnits = $tabRequest;
    
    // Gets all the units a member is part of
    $access = FSAccess::getAccess($accessNo)->getContent();
    $tabUnitsOfAccess = getUnitsFromAccess( $access );
    
    $tabOfAllUnits = getUnitsAsString();
    
    foreach( $tabOfAllUnits as $unit ) {
        // If the access was already a privilege for this unit
        if( in_array( $unit, $tabUnitsOfAccess ) ) {
            // If it was checked
            if( isset( $checkedUnits[$unit] ) ) {
                // do nothing
                //echo $unit.' already granted<br />';
            }
            // Change this right
            else {
                // change the right
                echo 'Successfully changed the access to '.$unit.'<br />';
                $objectUnit = FSUnit::getUnitByName($unit)->getContent();
                $args = array(
                    'access' => $access,
                    'unit'   => $objectUnit
                );
                FSPermission::upsertPermission( $args );
            }
        }
        
        // If this access was not yet granted
        else {
            // If it was checked
            if ( isset( $checkedUnits[$unit] ) ) {
                // change this right
                echo 'Successfully changed the Permission to '.$unit.'<br />';
                $objectUnit = FSUnit::getUnitByName($unit)->getContent();
                $args = array(
                    'access' => $access,
                    'unit'   => $objectUnit
                );
                $message = FSPermission::upsertPermission( $args );
            }
            else {
                // do nothing
                //echo $unit.' already not granted<br />';
            }
            
        }
    }
    showAccess();
}

function addAccess() {
    if( isset( $_REQUEST['service'] )  && $_REQUEST['service'] != '' ) {
        $messageAdd = FSAccess::addAccess($AccessToAdd);
    }
    else {
        
    }
    return $messageAdd;
}

/**
 * Get all the existing units and make an array with their names
 * @return String Array of all the units' names
 */
function getUnitsAsString() {
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
function getUnitsFromMember( $member ) {
    $unitsOfMember = FSUnit::getUnitsFromMember( $member )->getContent();
    $tabUnitsOfMember = array();
    
    if( count( $unitsOfMember ) > 0 ) {
        foreach($unitsOfMember as $unit){
            $tabUnitsOfMember[] = $unit->getName();
        }
    }
    else {
        $tabUnitsOfMember[] = NULL;
    }
    return $tabUnitsOfMember;
}

function getUnitsFromAccess( $access ) {
    $unitsFromAccess = FSUnit::getUnitsFromAccess( $access )->getContent();
    $tabAccessesOfUnit = array();
    
    if( count( $unitsFromAccess ) > 0 ) {
        foreach($unitsFromAccess as $unit){
            $tabAccessesOfUnit[] = $unit->getName();
        }
    }
    else {
        $tabAccessesOfUnit[] = NULL;
    }
    return $tabAccessesOfUnit;
}

?>
