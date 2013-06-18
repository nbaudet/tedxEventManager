<?php

/**
 * Description of FSAffectation
 *
 * @author L'eau Rik
 */

require_once(APP_DIR . '/core/model/Affectation.class.php');
require_once(APP_DIR . '/core/model/Organizer.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSOrganizer.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSTeamRole.class.php');
require_once(APP_DIR . '/core/model/Message.class.php');


class FSAffectation{
    
    /**
     *Returns an Affectation with the given TeamRoleName and OrganizerNo as Id
     *@param int $organizerNo the id of the Speaker
     *@param int $tameRoleName the id of the Event
     *@return a Message with an existant Affectation
     */
    public static function getAffectation($args){
        $affectation = NULL;
        global $crud;
        
        $teamRole = $args['teamRole'];
        $organizer = $args['organizer'];

        $sql = "SELECT * FROM Affectation
                WHERE TeamRole = " . $teamRole>getName(). " AND
                OrganizerPersonNo = " . $organizer->getNo(). " AND
                IsArchived = 0";

        $data = $crud->getRow($sql);
        
        if($data){
            $argsAffectation = array(
                'teamRoleName'            => $data['TeamRoleName'],
                'organizerPersonNo'    => $data['OrganizerPersonNo'],
                'isArchived'    => $data['IsArchived']
            );
        
            $affectation = new Affectation($argsAffectation);

            $argsMessage = array(
                'messageNumber'     => 143,
                'message'           => 'Existant Affectation',
                'status'            => true,
                'content'           => $affectation
            );
            $return = new Message($argsMessage);
        }else{
            
            $argsMessage = array(
                'messageNumber'     => 144,
                'message'           => 'Inexistant Affectation',
                'status'            => false,
                'content'           => NULL    
            );
            $return = new Message($argsMessage);
        }
        return $return;
    }

    /**
     * Returns all the Affectations of the database
     * @return A Message containing an array of Affectations
     */
    public static function getAffectations(){
        global $crud;

        $sql = "SELECT * FROM Affectation as Af
            INNER JOIN TeamRole as Tr ON Tr.Name = Af.TeamRoleName
            INNER JOIN Organizer as Org ON Org.PersonNo = Af.OrganizerPersonNo WHERE Af.IsArchived = 0;";
        $data = $crud->getRows($sql);
        
        if ($data){
            $affectations = array();

            foreach($data as $row){
                $argsAffectation = array(
                    'teamRoleName'      => $row['TeamRoleName'],
                    'organizerPersonNo' => $row['OrganizerPersonNo'],
                    'isArchived'        => $row['IsArchived']
                  );
            
                $affectations[] = new Affectation($argsAffectation);
            } //foreach

            $argsMessage = array(
                'messageNumber' => 145,
                'message'       => 'All Affectations selected',
                'status'        => true,
                'content'       => $affectations
            );
            $return = new Message($argsMessage);
        } else {
            $argsMessage = array(
                'messageNumber' => 146,
                'message'       => 'Error while SELECT * FROM Affectations',
                'status'        => false,
                'content'       => NULL
            );
            $return = new Message($argsMessage);
        }
        return $return;
    }
    
    /**
     * Add a new Affectation in Database
     * @param $args Parameters of an Affectation
     * @return a Message containing the new Affectation
     */
    public static function addCoOrganization($args){
        
        $teamRole = $args['teamRole'];
        $organizer = $args['organizer'];
        
        // Validate Existant Organizer
        $messageValidOrganizer = FSOrganizer::getOrganizer($organizer->getNo());
        
        if($messageValidOrganizer->getStatus()){
            $aValidOrganizer = $messageValidOrganizer->getContent();
            
            // Validate TeamRole
            $messageValidTeamRole = FSTeamRole::getTeamRole($teamRole->getName());
            
            if($messageValidTeamRole->getStatus()){
                $aValidTeamRole = $messageValidTeamRole->getContent();

                // Validate Inexistant Affectation
                $argsAffectation = array(
                    'teamRole' => $aValidTeamRole,
                    'organizer' => $aValidOrganizer
                );
                    
                $messageValidAffectation = FSAffectation::getAffectation($argsAffectation);
                if($messageValidAffectation->getStatus() == false){
                     $messageCreateAffectation = self::createAffectation($argsAffectation);
                        // Create final message - Message Affectation added or not added.
                        $return = $messageCreateAffectation;
                    }else{
                        // Generate Message - Valid Affectation 
                        $return = $messageValidAffectation;
                    }
 
            }else{
                // Generate Message - Invalid TeamRole
                $return = $messageValidTeamRole;
            }
        }else{
            // Generate Message - Invalid Organizer
            $return = $messageValidOrganizer;
        }
        return $return;
    }
    
    
    /**
     * Create a new Affectation in Database
     * @param type $args
     * @return a Message containing the created Affectation
     */
    private static function createAffectation($args){
        global $crud;
        $teamRole = $args['teamRole'];
        $organizer = $args['organizer'];
        
        $sql = "INSERT INTO Affectation (
            TeamRoleName, OrganizerPersonNo) VALUES (
            '".$teamRole->getName()."',
            ".$organizer->getNo()."
        )";
        $crud->exec($sql);
        
        // Validate Existant Affectation
        $argsAffectation = array(
            'teamRole' => $args['teamRole'],
            'organizer' => $args['organizer']
        );
        $messageValidAffectation = self::getAffectation($argsAffectation);
        if($messageValidAffectation->getStatus()){
            $aValidAffectation = $messageValidAffectation->getContent();
            // Generate message - Message Affectation added.
            $argsMessage = array(
                'messageNumber' => 149,
                'message'       => 'New Affectation added !',
                'status'        => true,
                'content'       => $aValidAffectation
            );
            $return = new Message($argsMessage);
        }else{
            // Generate Message - Participation not Added            
            $argsMessage = array(
                    'messageNumber' => 150,
                    'message'       => 'Error while inserting new Affectation',
                    'status'        => false,
                    'content'       => NULL
                );
            $return = new Message($argsMessage);
        }
        return $return;
    } // END createAffectation
    
    
    /** Returns All Event by Speaker
     * @param a Speaker
     * @return a Message conainting an array of Event
     */
    public static function getEventsBySpeaker($speaker){   
        global $crud;
        
        $sql = "SELECT EventNo FROM CoOrganization 
            WHERE SpeakerPersonNo = ".$speaker->getNo()." AND IsArchived = 0";
        
        $data = $crud->getRows($sql);
        
        if($data){
            $events = array();
            
            foreach($data as $row){
                $events[] = FSEvent::getEvent($row['EventNo'])->getContent();
            }//foreach
            
            $argsMessage = array(
                'messageNumber' => 139,
                'message'       => 'All Events for a Speaker selected',
                'status'        => true,
                'content'       => $events
            );
            
            $return = new Message($argsMessage);
            
        }else{
            echo "argh";
            $argsMessage = array(
                'messageNumber' => 140,
                'message'       => 'Error while SELECT * FROM Events WHERE ...',
                'status'        => false,
                'content'       => NULL
            );
            
            $return = new Message($argsMessage);
        }
        
        return $return;
    } // END getEventBySpeaker
     
     /** Returns All Speakers for an Event
     * @param an Event
     * @return a Message conainting an array of Speakers
     */
    public static function getSpeakersByEvent($event){   
        global $crud;
        
        $sql = "SELECT SpeakerPersonNo FROM CoOrganization 
            WHERE EventNo = ".$event->getNo()." AND IsArchived = 0";
        
        $data = $crud->getRows($sql);
        
        if($data){
            $speakers = array();
            var_dump($data);
            foreach($data as $row){
                $speakers[] = FSSpeaker::getSpeaker($row['SpeakerPersonNo'])->getContent();
            }//foreach
            
            $argsMessage = array(
                'messageNumber' => 141,
                'message'       => 'All Speakers for an Event selected',
                'status'        => true,
                'content'       => $speakers
            );
            
            $return = new Message($argsMessage);
            
        }else{
            echo "argh";
            $argsMessage = array(
                'messageNumber' => 142,
                'message'       => 'Error while SELECT * FROM Events WHERE ...',
                'status'        => false,
                'content'       => NULL
            );
            
            $return = new Message($argsMessage); 
        }
        
        return $return;
    } // END getSpeakersByEvent
    
 }
    
?>
