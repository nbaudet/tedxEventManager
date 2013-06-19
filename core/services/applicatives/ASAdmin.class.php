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
 * Description of ASAdmin
 *
 * @author rapou
 */
class ASAdmin {
    /**
     * The constructor that does nothing
     */
    public function __construct() {
        // Nothing
    }
    
    public static function registerOrganizer($args) {
        /*
          $argsPerson = array(
          'name'         => '',
          'firstname'    => '',
          'dateOfBirth'  => '',
          'address'      => '',
          'city'         => '',
          'country'      => '',
          'phoneNumber'  => '',
          'email'        => '',
          'description'  => '',
          'idmember'     => '',
          'password'     => '',
          );
         */
        // Arguments for adding a Person
        $argsPerson = array(
            'name' => $args['name'],
            'firstname' => $args['firstname'],
            'dateOfBirth' => $args['dateOfBirth'],
            'address' => $args['address'],
            'city' => $args['city'],
            'country' => $args['country'],
            'phoneNumber' => $args['phoneNumber'],
            'email' => $args['email'],
            'description' => $args['description']
        );

        // Add a Person
        $messageAddedPerson = FSPerson::addPerson($argsPerson);
        // If the Person is added, continue. 
        if ($messageAddedPerson->getStatus()) {
            $anAddedPerson = $messageAddedPerson->getContent();
            $messageAddedOrganizer = FSOrganizer::addOrganizer($anAddedPerson);
            if ($messageAddedOrganizer->getStatus()){
                // Arguments for adding a Member
                $argsMember = array(
                    'id' => $args['idmember'],
                    'password' => $args['password'],
                    'person' => $anAddedPerson
                );
                // Add a Member
                $messageAddedMember = FSMember::addMember($argsMember);
                // If the Member is added, continue.
                if ($messageAddedMember->getStatus()) {
                    $anAddedMember = $messageAddedMember->getContent();
                    // Get the Unit with the name 'Visitor' 
                    $messageUnit = FSUnit::getUnitByName('Organizer');
                    $participantUnit = $messageUnit->getContent();
                    // Arguments for adding a Membership
                    $argsMembership = array(
                        'member' => $anAddedMember,
                        'unit' => $participantUnit
                    );
                    // Add a Membership
                    $messageAddedMembership = FSMembership::addMembership($argsMembership);
                    // If the Membership is added, generate the message OK
                    if ($messageAddedMembership->getStatus()) {
                        $anAddedMembership = $messageAddedMembership->getContent();
                        $argsMessage = array(
                            'messageNumber' => 429,
                            'message' => 'Organizer registered',
                            'status' => true,
                            'content' => array('anAddedPerson' => $anAddedPerson, 'anAddedMember' => $anAddedMember, 'anAddedMembership' => $anAddedMembership)
                        );
                        $aRegisteredOrganizer = new Message($argsMessage);
                    } else {
                        // Else give the error message about non-adding Membership
                        $aRegisteredOrganizer = $messageAddedMembership;
                    }
                } else {
                    // Else give the error message about non-adding Member
                    $aRegisteredOrganizer = $messageAddedMember;
                }
            }else{
                // Else give the error message about non-adding Member
                $aRegisteredOrganizer = $messageAddedOrganizer;
            }
        } else {
            // Else give the error message about non-adding Person
            $aRegisteredOrganizer = $messageAddedPerson;
        }
        
        // Return the message Visitor Registed or not Registred
        return $aRegisteredOrganizer;
    }
    
    public static function addTeamRole($aName) {
        return FSTeamRole::addTeamRole($aName);   
    }
}

?>
