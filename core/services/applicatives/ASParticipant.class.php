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
    
    // Add Keyword To An Event For A Person
    public static function addKeywordsToAnEvent($args) {
    /*  -----------------------------------------------
        $args = array(
           'listOfValues' => array('values'),
           'event'        => $anEvent,
           'person'       => $aPerson
        );
        ----------------------------------------------- */
        $listOfValues = $args['listOfValues'];
        $anEvent = $args['event'];
        $aPerson = $args['person'];
        $i = 0; 
        foreach($listOfValues as $value){
            $messageNbKeywords = FSKeyword::countKeywordsByPersonForEvent(array('event' => $anEvent, 'person' => $aPerson));
            if($messageNbKeywords->getStatus()){
                $messageValidKeyword = FSKeyword::getKeyword(array('value'=> $value, 'event'=> $anEvent, 'person' => $aPerson));
                if(!$messageValidKeyword->getStatus()){
                    $messageAddKeyword = FSKeyword::addKeyword(array('value'=> $value, 'event'=> $anEvent, 'person' => $aPerson));
                    $messages[$i] = $messageAddKeyword;
                }else{
                    $aValidKeyword = $messageValidKeyword->getContent();
                    if($aValidKeyword->getIsArchived() == 1){
                        $aValidKeyword->setIsArchived(0);
                        $messageSetKeyword = FSKeyword::setKeyword($aValidKeyword);
                        $messages[$i] = $messageSetKeyword;
                    }else{
                        // Message Keyword déjà existant. 
                    }
                }
            }else{
                $messages[$i] = $messageNbKeywords;
            }
            $i++;
        }
        return $messages; 
    }//function
    
}

?>
