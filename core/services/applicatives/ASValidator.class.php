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
        if ($messageValidEvent->getStatus()) {
            $aValidEvent = $messageValidEvent->getContent();
            $messageValidParticipant = FSParticipant::getParticipant($currentRegistration->getParticipantPersonNo());
            if ($messageValidParticipant->getStatus()) {
                $aValidParticipant = $messageValidParticipant->getContent();
                $currentRegistration->setIsArchived(1);
                $messageArchiveRegistration = FSRegistration::archiveRegistration($currentRegistration);
                if ($messageArchiveRegistration->getStatus()) {
                    $argsRegistration = array(
                        'status' => $newStatus, // String
                        'type' => $currentRegistration->getType(), // String
                        'typeDescription' => $currentRegistration->getTypeDescription(), // Optionel - String
                        'event' => $aValidEvent, // object Event
                        'participant' => $aValidParticipant  // object Participant
                    );
                    $message = FSRegistration::addRegistration($argsRegistration);
                } else {
                    $message = $messageArchiveRegistration;
                }
            } else {
                $message = $messageValidParticipant;
            }
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
    public static function cancelRegistration( $registration ) {
        $args = array('currentRegistration' => $aRegistration, 'newStatus' => 'Pending');
        return self::changeRegistrationStatus($args);
    }

}

?>
