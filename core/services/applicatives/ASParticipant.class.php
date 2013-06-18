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
 * Description of ASParticipant
 *
 * @author rapou
 */
class ASParticipant {
    //Show a Keyword
    public static function getKeyword($args) {
        $aKeyword = FSUnit::getUnit($args);
        return $aKeyword;    
    }//function 
    
    //Show all Keywords of a Person
    public static function getKeywordsByPerson($aPerson) {
        $keywords = FSKeyword::getKeywordsByPerson($aPerson); 
        return $keywords; 
    }//function
     //Show all Keywords of a Person for an Event
    public static function getKeywordsByPersonForEvent($args) {
        $keywords = FSKeyword::getKeywordsByPersonForEvent($args); 
        return $keywords; 
    }//function
}

?>
