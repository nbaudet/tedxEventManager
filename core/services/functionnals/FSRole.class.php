<?php

require_once(APP_DIR . '/core/model/Message.class.php');
require_once(APP_DIR . '/core/model/Role.class.php');
require_once(APP_DIR . '/core/model/Event.class.php');
require_once(APP_DIR . '/core/model/Organizer.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSOrganizer.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSEvent.class.php');


/**
 * FSRole.class.php
 * 
 * Author : Lauric Francelet
 * Date : 25.06.2013
 * 
 * Description : define the class FSRole as definited in the model
 * 
 */
class FSRole {

    /**
     * Returns a Role with the given Name, EventNo and OrganizerPersonNo as Id.
     * @param array of params 
     * @return a Message containing an existant Role
     */
    public static function getRole($args) {
        $role = NULL;
        global $crud;

        $name = addslashes($args['name']);
        $event = $args['event'];
        $organizer = $args['organizer'];
        
        
        //If Event is set
        if (isset($event)) {
            $aValideEvent = FSEvent::getEvent($event->getNo());
            //If Valid Event              
            if ($aValideEvent) {
                $eventNo = $args['event']->getNo();
                //If Organizer not empty
                if (isset($organizer)) {
                    $aValidOrganizer = FSOrganizer::getOrganizer($organizer->getNo());
                    //If Organizer valid  
                    if ($aValidOrganizer) {
                        $organizerNo = $args['organizer']->getNo();
                        $sql = "SELECT * FROM Role WHERE Name = '$name' AND EventNo = $eventNo 
                                            AND OrganizerPersonNo = $organizerNo AND IsArchived = 0";

                        $data = $crud->getRow($sql);

                        if ($data) {
                            $argsRole = array(
                                'name' => $data['Name'],
                                'eventNo' => $data['EventNo'],
                                'organizerPersonNo' => $data['OrganizerPersonNo'],
                                'level' => $data['Level'],
                                'isArchived' => $data['IsArchived'],
                            );

                            $role = new Role($argsRole);

                            $argsMessage = array(
                                'messageNumber' => 161,
                                'message' => 'Existant Role',
                                'status' => true,
                                'content' => $role
                            );
                            $return = new Message($argsMessage);
                        } else {
                            $argsMessage = array(
                                'messageNumber' => 162,
                                'message' => 'Inexistant Role',
                                'status' => false,
                                'content' => NULL
                            );
                            $return = new Message($argsMessage);
                        } // else
                    } else {
                        $argsMessage = array(
                            'messageNumber' => 162,
                            'message' => 'Not Valid Organizer',
                            'status' => false,
                            'content' => NULL
                        );
                        $return = new Message($argsMessage);
                    }
                } else {
                    $argsMessage = array(
                        'messageNumber' => 162,
                        'message' => 'Inexistant Organizer',
                        'status' => false,
                        'content' => NULL
                    );
                    $return = new Message($argsMessage);
                }
            } else {
                $argsMessage = array(
                    'messageNumber' => 162,
                    'message' => 'Not Valid Event',
                    'status' => false,
                    'content' => NULL
                );
                $return = new Message($argsMessage);
            }
        } else {
            $argsMessage = array(
                'messageNumber' => 162,
                'message' => 'Inexistant Event',
                'status' => false,
                'content' => NULL
            );
            $return = new Message($argsMessage);
        }
        return $return;
    }//function


    /**
     * Returns all the Roles of the database
     * @return A Message containing an array of Roles
     */
    public static function getRoles() {
        global $crud;

        $sql = "SELECT * FROM Role WHERE IsArchived = 0;";
        $data = $crud->getRows($sql);

        if ($data) {
            $roles = array();

            foreach ($data as $row) {
                $argsRole = array(
                    'name' => $row['Name'],
                    'eventNo' => $row['EventNo'],
                    'organizerPersonNo' => $row['OrganizerPersonNo'],
                    'level' => $row['Level'],
                    'isArchived' => $row['IsArchived'],
                );

                $roles[] = new Role($argsRole);
            } //foreach

            $argsMessage = array(
                'messageNumber' => 163,
                'message' => 'All Roles selected',
                'status' => true,
                'content' => $roles
            );
            $return = new Message($argsMessage);
        } else {
            $argsMessage = array(
                'messageNumber' => 164,
                'message' => 'Error while SELECT * FROM Role',
                'status' => false,
                'content' => NULL
            );
            $return = new Message($argsMessage);
        }// else

        return $return;
    }//function


    /**
     * Add a new Role in Database
     * @param $args Parameters of a Role
     * @return a Message containing the new Role
     */
    public static function addRole($args) {
        $anEvent = $args['event'];
        $anOrganizer = $args['organizer'];
        $aName = $args['name'];
        $aLevel = $args['level'];

        $messageValidEvent = FSEvent::getEvent($anEvent->getNo());
        if ($messageValidEvent->getStatus()) {
            $aValidEvent = $messageValidEvent->getContent();
            $messageValidOrganizer = FSOrganizer::getOrganizer($anOrganizer->getNo());
            if ($messageValidOrganizer->getStatus()) {
                $aValidOrganizer = $messageValidOrganizer->getContent();
                $argsRole = array(
                    'event' => $aValidEvent,
                    'organizer' => $aValidOrganizer,
                    'name' => $aName,
                    'level' => $aLevel
                );
                // Validate non existing Role
                $messageValidateRole = FSRole::getRole($argsRole);
                if (!$messageValidateRole->getStatus()) {
                    $messageCreateRole = FSRole::createRole($argsRole);
                    if ($messageCreateRole->getStatus()) {
                        $aCreatedRole = $messageCreateRole->getContent();

                        $argsMessage = array(
                            'messageNumber' => 165,
                            'message' => 'New Role created !',
                            'status' => true,
                            'content' => $aCreatedRole
                        );
                        $return = new Message($argsMessage);
                    } else {
                        $argsMessage = array(
                            'messageNumber' => 166,
                            'message' => 'Error while inserting new Role',
                            'status' => false,
                            'content' => NULL
                        );
                        $return = new Message($argsMessage);
                    }
                } else {
                    $return = $messageValidateRole;
                }
            } else {
                $return = $messageValidOrganizer;
            }
        } else {
            $return = $messageValidEvent;
        }

        return $return;
    }//function


    /**
     * Adds a new Role in Database
     * @param array $args
     * @return a Message containing the created Role
     */
    public static function createRole($args) {
        global $crud;
        $event = $args['event'];
        $organizer = $args['organizer'];
        $name = addslashes($args['name']);

        $sql = "INSERT INTO Role (Name, EventNo, OrganizerPersonNo, Level) VALUES (
            '" . $name . "',
            " . $event->getNo() . ",
            " . $organizer->getNo() . ",
            " . $args['level'] . "
        )";


        if ($crud->exec($sql)) {

            $aCreatedRole = FSRole::getRole($args)->getContent();

            $argsMessage = array(
                'messageNumber' => 165,
                'message' => 'New Role added !',
                'status' => true,
                'content' => $aCreatedRole
            );
            $return = new Message($argsMessage);
        } else {
            $argsMessage = array(
                'messageNumber' => 166,
                'message' => 'Error while inserting new Role',
                'status' => false,
                'content' => NULL
            );
            $return = new Message($argsMessage);
        }// else
        return $return;
    }//function


    /**
     * Set Role
     * @global type $crud
     * @param type $aRoleToSet
     * @return type message
     */
    public static function setRole($aRoleToSet) {
        global $crud;
        $messageValidEvent = FSEvent::getEvent($aRoleToSet->getEventNo());
        if ($messageValidEvent->getStatus()) {
            $aValidEvent = $messageValidEvent->getContent();
            $messageValidOrganizer = FSOrganizer::getOrganizer($aRoleToSet->getOrganizerPersonNo());
            if ($messageValidOrganizer->getStatus()) {
                $aValidOrganizer = $messageValidOrganizer->getContent();
                $argsRole = array(
                    'event' => $aValidEvent,
                    'organizer' => $aValidOrganizer,
                    'name' => $aRoleToSet->getName()
                );
                $messageValidRole = FSRole::getRole($argsRole);
                if ($messageValidRole->getStatus()) {
                    $aValidRole = $messageValidRole->getContent();

                    $sql = "UPDATE  Role SET  
                        Level =   " . $aRoleToSet->getLevel() . ",
                        IsArchived =    '" . $aRoleToSet->getIsArchived() . "'
                        WHERE  Role.Name = '" . $aValidRole->getName() . "' 
                        AND Role.EventNo = " . $aValidEvent->getNo() . "
                        AND Role.OrganizerPersonNo = " . $aValidOrganizer->getNo();

                    if ($crud->exec($sql) == 1) {
                        $sql = "SELECT * FROM Role 
                        WHERE Role.Name = " . $aValidRole->getName() . "' 
                        AND Role.EventNo = " . $aValidEvent->getNo() . "
                        AND Role.OrganizerPersonNo = " . $aValidOrganizer->getNo();

                        $data = $crud->getRow($sql);

                        $argsRole = array(
                            'name' => $data['Name'],
                            'organizerPersonNo' => $data['OrganizerPersonNo'],
                            'eventNo' => $data['EventNo'],
                            'level' => $data['Level'],
                            'isArchived' => $data['IsArchived']
                        );

                        $aSetRole = new Role($argsRole);

                        $argsMessage = array(
                            'messageNumber' => 434,
                            'message' => 'Role set !',
                            'status' => true,
                            'content' => $aSetRole
                        );
                        $message = new Message($argsMessage);
                    } else {
                        $argsMessage = array(
                            'messageNumber' => 435,
                            'message' => 'Error while setting Role',
                            'status' => false,
                            'content' => NULL
                        );
                        $message = new Message($argsMessage);
                    }
                } else {
                    $message = $messageValidRole;
                }
            } else {
                $message = $messageValidOrganizer;
            }
        } else {
            $message = $messageValidEvent;
        }
        return $message;
    }//function

    
    /**
     * Returns all the Roles of an Event
     * @param Event $event
     * @return a Message containing an array of Roles
     */
    public static function getRolesByEvent($event) {
        global $crud;

        $sql = "SELECT * FROM Role WHERE IsArchived = 0 AND EventNo = " . $event->getNo();

        $data = $crud->getRows($sql);

        if ($data) {
            $roles = array();

            foreach ($data as $row) {
                $argsRole = array(
                    'name' => $row['Name'],
                    'eventNo' => $row['EventNo'],
                    'organizerPersonNo' => $row['OrganizerPersonNo'],
                    'level' => $row['Level'],
                    'isArchived' => $row['IsArchived'],
                );

                $roles[] = new Role($argsRole);
            } //foreach

            $argsMessage = array(
                'messageNumber' => 167,
                'message' => 'All Roles By Event selected',
                'status' => true,
                'content' => $roles
            );
            $return = new Message($argsMessage);
        } else {
            $argsMessage = array(
                'messageNumber' => 168,
                'message' => 'Error while SELECT * FROM Role By Event',
                'status' => false,
                'content' => NULL
            );
            $return = new Message($argsMessage);
        }
        return $return;
    }

    
    /**
     * Returns all the Roles of an Organizer
     * @param Event $event
     * @return a Message containing an array of Roles
     */
    public static function getRolesByOrganizer($organizer) {
        global $crud;

        $sql = "SELECT * FROM Role WHERE IsArchived = 0 AND OrganizerPersonNo = " . $organizer->getNo();

        $data = $crud->getRows($sql);

        if ($data) {
            $roles = array();

            foreach ($data as $row) {
                $argsRole = array(
                    'name' => $row['Name'],
                    'eventNo' => $row['EventNo'],
                    'organizerPersonNo' => $row['OrganizerPersonNo'],
                    'level' => $row['Level'],
                    'isArchived' => $row['IsArchived'],
                );

                $roles[] = new Role($argsRole);
            } //foreach

            $argsMessage = array(
                'messageNumber' => 169,
                'message' => 'All Roles By Organizer selected',
                'status' => true,
                'content' => $roles
            );
            $return = new Message($argsMessage);
        } else {
            $argsMessage = array(
                'messageNumber' => 170,
                'message' => 'Error while SELECT * FROM Role By Organizer',
                'status' => false,
                'content' => NULL
            );
            $return = new Message($argsMessage);
        }
        return $return;
    }//function

}//class

?>
