<?php





 /**
     * Returns All Event by Speaker
     * @param a Speaker
     * @return a Message conainting an array of Event
     */
    public static function getEventsBySpeaker($speaker){   
        global $crud;
        
        $sql = "SELECT * FROM Event as E
            INNER JOIN CoOrganization as CO ON E.No = CO.EventNO
            INNER JOIN Speaker as S ON CO. SpeakerPersonNo = S.PersonNo
            WHERE CO.SpeakerPersonNo = ". $speaker->getNo() ." 
                AND E.IsArchived = 0
                AND CO.IsArchived = 0
                AND S.IsArchived = 0";
        
        $data = $crud->getRows($sql);
        
        if($data){
            $events = array();
            
            foreach($data as $row){
                $argsEvent = array(
                    'no'            => $row['No'],
                    'mainTopic'       => $row['MainTopic'],
                    'description'    => $row['Description'],
                    'startingDate' => $row['StartingDate'],
                    'endingDate'  => $row['EndingDate'],
                    'startingTime'    => $row['StartingTime'],
                    'endingTime'    => $row['EndingTime'],
                    'isArchived'    => $row['IsArchived'],
                );
                $events[] = new Event($argsEvent);
            }//foreach
            
            $argsMessage = array(
                'messageNumber' => 223,
                'message'       => 'All Events for a Speaker selected',
                'status'        => true,
                'content'       => $events
            );
            
            $return = new Message($argsMessage);
            
        }else{
            $argsMessage = array(
                'messageNumber' => 224,
                'message'       => 'Error while SELECT * FROM Events WHERE ...',
                'status'        => false,
                'content'       => NULL
            );
            
            $return = new Message($argsMessage);
            
        }
        
        return $return;
        
    }





















/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../tedx-config.php');
require_once(APP_DIR .'/core/services/functionnals/FSPerson.class.php');
require_once(APP_DIR .'/core/services/functionnals/FSMembership.class.php');
require_once(APP_DIR .'/core/services/functionnals/FSUnit.class.php');
require_once(APP_DIR .'/core/services/functionnals/FSMember.class.php');
require_once(APP_DIR .'/core/services/functionnals/FSEvent.class.php');
require_once(APP_DIR .'/core/services/functionnals/FSSlot.class.php');
require_once(APP_DIR .'/core/services/functionnals/FSSpeaker.class.php');
require_once(APP_DIR .'/core/services/functionnals/FSParticipant.class.php');
require_once(APP_DIR .'/core/services/functionnals/FSOrganizer.class.php');

require_once(APP_DIR .'/core/model/Member.class.php');
require_once(APP_DIR .'/core/model/Unit.class.php');


//var_dump(FSPerson::getPerson(1));
//var_dump(FSMembership::getMembership("admin",1));
//var_dump(FSPerson::getPersons());



//$member = FSMember::getMember('admin')->getContent();
//var_dump($member);

//$unit = FSUnit::getUnit(2)->getContent();
//var_dump($unit);

//$argsMembership = array ('member' => $member, 'unit' => $unit);

//var_dump(FSMembership::getMembership($argsMembership));
//var_dump(FSMembership::addMembership($argsMembership));

//$event = FSEvent::getEvent(1)->getContent();
//var_dump($event);

/*$argsSlot = array (
    'no'    => '1',
    'event' => $event
);*/

//$slot = FSSlot::getSlot($argsSlot)->getContent();
//var_dump($slot);

//var_dump(FSSlot::getSlotsByEvent($event));

//var_dump(FSSlot::getSlots());


//var_dump(FSSpeaker::getSpeaker(6));
//var_dump(FSSpeaker::getSpeakers());
//var_dump(FSParticipant::getParticipant(8));
//var_dump(FSParticipant::getParticipants());


//var_dump(FSOrganizer::getOrganizer(2));
//var_dump(FSOrganizer::getOrganizers());

//$aPerson = FSPerson::getPerson(5)->getContent();
//var_dump(FSOrganizer::addOrganizer($aPerson));
//var_dump(FSOrganizer::getOrganizers());

/*var_dump($aPerson = FSPerson::getPerson(8)->getContent());

$argsPerson = array (
    'no'           => 8,
    'name'         => 'Jubin',
    'firstname'    => 'Alberto',
    'dateOfBirth'  => '1961-03-11',
    'address'      => 'Rue des Alpes, 22',
    'city'         => 'Lausanne',
    'country'      => 'Switzerland',
    'phoneNumber'  => '0798867275',
    'email'        => 'rsz@tedx.com',
    'description'  => 'Petit Jubin aime PAS les frittes',
    'isArchived'   => 0,
);
 
$aPersonToSet = new Person( $argsPerson ) ;

var_dump($messageSettedPerson = FSPerson::setPerson($aPersonToSet));*/

$event = FSEvent::getEvent(1)->getContent();

$argsSlot = array (
    'event'         => $event,
    'happeningDate' => '2000-02-02',
    'startingTime'  => '07:00:00',
    'endingTime'    => '08:00:00'
);

var_dump(FSSlot::addSlot($argsSlot));

?>


