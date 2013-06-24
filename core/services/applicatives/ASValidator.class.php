<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once(APP_DIR . '/core/services/functionnals/FSAccess.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSEvent.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSKeyword.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSLocation.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSMember.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSMembership.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSOrganizer.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSParticipant.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSParticipation.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSRegistration.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSRole.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSSlot.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSSpeaker.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSTeamRole.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSUnit.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSPerson.class.php');

/**
 * Description of ASValidator
 *
 * @author rapou
 */
class ASValidator {

    /**
     * The constructor that does nothing
     */
    public function __construct() {
        // Nothing
    }

    // Change the status of the current registration.
    private static function changeRegistrationStatus($args) {
        $currentRegistration = $args['currentRegistration'];
        $newStatus = $args['newStatus'];

        $messageValidEvent = FSEvent::getEvent($currentRegistration->getEventNo());
        // Validate Event
        if ($messageValidEvent->getStatus()) {
            $aValidEvent = $messageValidEvent->getContent();
            $messageValidParticipant = FSParticipant::getParticipant($currentRegistration->getParticipantPersonNo());
            // Validate Participant
            if ($messageValidParticipant->getStatus()) {
                $aValidParticipant = $messageValidParticipant->getContent();
                $currentRegistration->setIsArchived(1);
                $messageArchiveRegistration = FSRegistration::archiveRegistration($currentRegistration);
                // If Registration was archived successfully
                if ($messageArchiveRegistration->getStatus()) {
                    /* If a Registration with similar Status, Participant and
                     * Event already exists, update its IsArchived to 0, other-
                     * wise, add a new Registration */
                    $newRegistration = $currentRegistration;
                    $newRegistration->setIsArchived(0);
                    $newRegistration->setStatus( $newStatus );
                    $argsPreexistingRegistration = array (
                        'event'        => $aValidEvent,
                        'participant'  => $aValidParticipant,
                        'registration' => $newRegistration,
                        'status'       => $newStatus
                    );
                    $messagePreExistingRegistration = FSRegistration::getRegistration($argsPreexistingRegistration);
                    if( $messagePreExistingRegistration->getStatus() ) {
                        $message = FSRegistration::setRegistration($newRegistration);
                    }
                    // Else: just add the Registration
                    else {
                        $argsRegistration = array(
                            'status'          => $newStatus, // String
                            'type'            => $currentRegistration->getType(), // String
                            'typeDescription' => $currentRegistration->getTypeDescription(), // Optionel - String
                            'event'           => $aValidEvent, // object Event
                            'participant'     => $aValidParticipant  // object Participant
                        );
                        $message = FSRegistration::addRegistration($argsRegistration);
                    }
                // Else: Error while archiving
                } else {
                    $message = $messageArchiveRegistration;
                }
            // Else: Invalid participant
            } else {
                $message = $messageValidParticipant;
            }
        // Else: Invalid Event
        } else {
            $message = $messageValidEvent;
        }
        return $message;
    }

//function
    // 
    public static function acceptRegistration($aRegistration) {
        $args = array('currentRegistration' => $aRegistration, 'newStatus' => 'Accepted');
        return self::changeRegistrationStatus($args);
    }

    //
    public static function rejectRegistration($aRegistration) {
        $args = array('currentRegistration' => $aRegistration, 'newStatus' => 'Rejected');
        return self::changeRegistrationStatus($args);
    }
    
    /**
     * Lets the validator cancel an acceptation or a rejection.
     * @param Registration $registration a Registration
     * @return Message a message with the registration or null.
     */
    public static function cancelRegistration( $aRegistration ) {
        $args = array('currentRegistration' => $aRegistration, 'newStatus' => 'Sent');
        return self::changeRegistrationStatus($args);
    }

}

?>
