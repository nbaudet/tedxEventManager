<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of QM_EventsCRUD
 *
 * @author Quentin
 */
require_once('../tedx-config.php');
require_once(APP_DIR.'/core/services/functionnals/FSLocation.class.php');
require_once(APP_DIR.'/core/services/functionnals/FSEvent.class.php');

$messageEvent = FSEvent::getEvent(1);
$anEvent = $messageEvent->getContent();

$messageLocation = $tedx_manager->getLocationFromEvent($anEvent);

if($messageLocation->getStatus()) {
    $aLocation = $messageLocation->getContent();           
    echo "Address of the Event numero 1 is : ".$aLocation->getAddress();
}
else
    echo "No location found";

?>
