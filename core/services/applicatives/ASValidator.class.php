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
        //If event not empty
        if(isset($currentRegistration->getEvent())){
                        $messageValidEvent = FSEvent::getEvent($currentRegistration->getEventNo());
                        if($messageValidEvent->getStatus()){
                            $aValidEvent = $messageValidEvent->getContent();
                                if(isset($currentRegistration['participant'])){
                                        $messageValidParticipant = FSParticipant::getParticipant($currentRegistration->getParticipantPersonNo());
                                        if($messageValidParticipant->getStatus()){
                                            $aValidParticipant = $messageValidParticipant->getContent();
                                            $currentRegistration->setIsArchived(1);
                                            $messageArchiveRegistration = FSRegistration::archiveRegistration($currentRegistration);
                                            if($messageArchiveRegistration->getStatus()){
                                                 $argsRegistration = array(
                                                    'status'          => $newStatus, // String
                                                    'type'            => $currentRegistration->getType(), // String
                                                    'typeDescription' => $currentRegistration->getTypeDescription(), // Optionel - String
                                                    'event'           => $aValidEvent, // object Event
                                                    'participant'     => $aValidParticipant  // object Participant
                                                );
                                                $message = FSRegistration::addRegistration($argsRegistration);
                                            }else{
                                                $message = $messageArchiveRegistration;
                                            }
                                        }else{
                                            $message = $messageValidParticipant;
                                        }
                                }else{
                                    $argsMessage = array(
                                        'messageNumber'     => 208,
                                        'message'           => 'Inexistant Participant',
                                        'status'            => false,
                                        'content'           => NULL 
                                    );
                                    $message= new Message($argsMessage);
                                }
                        }else{
                            $message = $messageValidEvent;
                        }
                }else{
                    $argsMessage = array(
                        'messageNumber'     => 212,
                        'message'           => 'Inexistant Event',
                        'status'            => false,
                        'content'           => null
                    );
                    $message= new Message($argsMessage);
                }
        return $message; 
    }//function
    
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
    
}

?>
