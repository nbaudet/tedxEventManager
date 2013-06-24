<?php

require_once('../tedx-config.php');

////////////////////////////////////////////////////////
// Ajout de mots clés pour la personne 5, pour l'event 1
////////////////////////////////////////////////////////
/*$tedx_manager->login('admin', 'admin');

$aListOfValues = array ('saucisse', 'camembert', 'pain');
$aPerson       = $tedx_manager->getPerson(5)->getContent();
$anEvent       = $tedx_manager->getEvent(1)->getContent();

$args = array(
    'listOfValues' => $aListOfValues, //List of object values
    'person' => $aPerson, // object Person,
    'event' => $anEvent // object Event
);
$messageAjout = $tedx_manager->addKeywordsToAnEvent($args);
var_dump($messageAjout);*/


////////////////////////////////////////////////////////
// Affichage des participants à l'event 1
////////////////////////////////////////////////////////
showParticipant( 1 );


////////////////////////////////////////////////////////
// Fonction de Marine
////////////////////////////////////////////////////////
/*
 * Gets the participants with their motivations and keywords for an Event
 * and shows the registrations List for an Event
 */

function showParticipant($id) {
    global $tedx_manager;
    //to count the number of AcceptedRegistrations
    $numberOfAcceptedRegistrations = 0;
    //get the messageGetEvent to get the object anEvent with the specified id for using the function getRegistrationsByEvents()
    $messageGetEvent = $tedx_manager->getEvent($id);
    //test if messageGetEven exists

    if ($messageGetEvent->getStatus()) {
        //get the object anEvent with the specified id
        $anEvent = $messageGetEvent->getContent();

        //call to the function to get all the registrations of the anEvent
        $messageGetRegistrationsByEvent = $tedx_manager->getRegistrationsByEvent($anEvent);
        //test if there are some registrations or not

        if ($messageGetRegistrationsByEvent->getStatus()) {

            //creation of the array of RegistrationParticipantwithMotivations and keywords
            $registrationsParticipantsWithMotivations = array();


            //get all the registrations (array)
            $registrations = $messageGetRegistrationsByEvent->getContent();

            //for each registration, get the participant and his motivations related to anEvent
            foreach ($registrations as $aRegistration) {


                $aParticipant = $tedx_manager->getParticipant($aRegistration->getParticipantPersonNo())->getContent();

                // Get the last registration for a participant to an event
                $args = array(
                    'participant' => $aParticipant,
                    'event' => $anEvent);
                $messageGetLastRegistration = $tedx_manager->getLastRegistration($args);

                // Get the Registrations from Message
                $theLastRegistration = $messageGetLastRegistration->getContent();

                if ($theLastRegistration->getStatus() != 'Pending') {

                    if ($theLastRegistration->getStatus() == $aRegistration->getStatus()) {


                        //work on the motivations
                        //parameters for the function getMotivationsByParticipantForEvent($args);
                        $args = array(
                            'participant' => $aParticipant,
                            'event' => $anEvent
                        );
                        $messageGetMotivationsByParticipantForEvent = $tedx_manager->getMotivationsByParticipantForEvent($args);

                        //test if there are some motivations for $aParticipant related to the anEvent
                        if ($messageGetMotivationsByParticipantForEvent->getStatus()) {
                            //creation of an array of motivations
                            $motivations = $messageGetMotivationsByParticipantForEvent->getContent();
                        } else {
                            //no motivations, array empty
                            $motivations = array();
                        }//else
                        //work on the Keywords
                        //parameters for the function getKeywordsByPersonForEvent($args);
                        $args = array(
                            'person' => $aParticipant,
                            'event' => $anEvent
                        );
                        $messageGetKeywordsByPersonForEvent = $tedx_manager->getKeywordsByPersonForEvent($args);

                        //test if there are some keywords for $aParticipant related to the anEvent
                        if ($messageGetKeywordsByPersonForEvent->getStatus()) {
                            //creation of an array of keywords
                            $keywords = $messageGetKeywordsByPersonForEvent->getContent();
                        } else {
                            //no keywords, array empty
                            $keywords = array();
                        }//else
                        //fill the array $registrationsParticipantswithMotivations[] with the registration, the participant, his motivations and his keywords, related to anEvent
                        $registrationsParticipantswithMotivations[] = array(
                            'registration' => $theLastRegistration,
                            'participant' => $aParticipant,
                            'motivations' => $motivations,
                            'keywords' => $keywords
                        );
                        if ($theLastRegistration->getStatus() == 'Accepted') {
                            $numberOfAcceptedRegistrations++;
                        }
                    }
                }
            }//foreach
            //var_dump( $registrationsParticipantswithMotivations[1]['keywords'] );
            var_dump($registrationsParticipantswithMotivations[2]);
            //apply of the template validateParticipant.tpl and add of the var we need to use it
            Template::render('validateParticipant.tpl', array(
                'event' => $anEvent,
                'registrationsParticipantsWithMotivations' => $registrationsParticipantswithMotivations,
                'numberOfAcceptedRegistrations' => $numberOfAcceptedRegistrations
            ));
        } else {
            //error message: no registrations found
            Template::flash('Could not find registrations ' . $messageGetRegistrationsByEvent->getMessage());
        }//else
    } else {
        //error message: no event found
        Template::flash('Could not find event ' . $messageGetEvent->getMessage());
    }//else
}

//function
?>