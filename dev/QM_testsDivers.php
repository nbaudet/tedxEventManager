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

$messageSlots = $tedx_manager->getSlotsFromEvent($anEvent);

if($messageSlots->getStatus()) {
    // get the Slots from message
    $slots = $messageSlots->getContent();
    
    // prepare a message
    $stringToDisplay = "Here are the slots : ";
    foreach($slots as $aSlot) {
        $stringToDisplay .= " ".$aSlot->getNo()." ";
    }//if
    // display the slots number
    echo $stringToDisplay;
}// if
else
    echo "No Slots found";

?>
