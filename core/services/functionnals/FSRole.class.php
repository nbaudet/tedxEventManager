<?php
require_once(APP_DIR . '/core/model/Message.class.php');
require_once(APP_DIR . '/core/model/Role.class.php');

/**
 * Description of FSRole
 *
 * @author Lauric
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
        $eventNo = $args['event']->getNo();
        $organizerNo = $args['organizer']->getNo();
        
        $sql = "SELECT * FROM Role WHERE Name = '$name' AND EventNo = $eventNo 
            AND OrganizerPersonNo = $organizerNo AND IsArchived = 0";
        
        $data = $crud->getRow($sql);
        
        if($data){
            $argsRole = array (
                'name'              => $data['Name'],
                'eventNo'           => $data['EventNo'],
                'organizerPersonNo' => $data['OrganizerPersonNo'],
                'level'             => $data['Level'],
                'isArchived'        => $data['IsArchived'],
            );
 
            $role = new Role( $argsRole ) ;
            
            $argsMessage = array(
                'messageNumber' => 161,
                'message'       => 'Existant Role',
                'status'        => true,
                'content'       => $role
            );
            $return = new Message($argsMessage);
            
        } else {
            $argsMessage = array(
                'messageNumber' => 162,
                'message'       => 'Inexistant Role',
                'status'        => false,
                'content'       => NULL
            );
            $return = new Message($argsMessage);
        } // else
        
        return $return;
    }// END getRole
    
    /**
     * Returns all the Roles of the database
     * @return A Message containing an array of Roles
     */
    public static function getRoles(){
        global $crud;
        
        $sql = "SELECT * FROM Role WHERE IsArchived = 0;";
        $data = $crud->getRows($sql);
        
        if ($data){
            $roles = array();

            foreach($data as $row){
                $argsRole = array (
                    'name'              => $row['Name'],
                    'eventNo'           => $row['EventNo'],
                    'organizerPersonNo' => $row['OrganizerPersonNo'],
                    'level'             => $row['Level'],
                    'isArchived'        => $row['IsArchived'],
                );
            
                $roles[] = new Role($argsRole);
            } //foreach

            $argsMessage = array(
                'messageNumber' => 163,
                'message'       => 'All Roles selected',
                'status'        => true,
                'content'       => $roles
            );
            $return = new Message($argsMessage);
            
        } else {
            $argsMessage = array(
                'messageNumber' => 164,
                'message'       => 'Error while SELECT * FROM Role',
                'status'        => false,
                'content'       => NULL
            );
            $return = new Message($argsMessage);
        }// else
        
        return $return;
    }// function
    
    /**
     * Add a new Role in Database
     * @param $args Parameters of a Role
     * @return a Message containing the new Role
     */
    public static function addRole($args){
        
        // Validate non existing Role
        $messageValidateRole = FSRole::getRole($args);
        
        if(!$messageValidateRole->getStatus()){
            $messageCreateRole = FSRole::createRole($args);
            
            if($messageCreateRole->getStatus()){
                $aCreatedRole = $messageCreateRole->getContent();
                
                $argsMessage = array(
                    'messageNumber' => 165,
                    'message'       => 'New Role created !',
                    'status'        => true,
                    'content'       => $aCreatedRole
                );
                $return = new Message($argsMessage);
            
            } else {
                $argsMessage = array(
                    'messageNumber' => 166,
                    'message'       => 'Error while inserting new Role',
                    'status'        => false,
                    'content'       => NULL
                );
                $return = new Message($argsMessage);
            }
            
        } else {
            $return = $messageValidateRole;
        }       
            
        return $return;                            
    }// END addRole
    
    
    /**
     * Adds a new Role in Database
     * @param array $args
     * @return a Message containing the created Role
     */
    public static function createRole($args){
        global $crud;
        $event = $args['event'];
        $organizer = $args['organizer'];
        $name = addslashes($args['name']);
        
        $sql = "INSERT INTO Role (Name, EventNo, OrganizerPersonNo, Level) VALUES (
            '".$name."',
            ".$event->getNo().",
            ".$organizer->getNo().",
            ".$args['level']."
        )";
        
        
        if($crud->exec($sql)){
            
            $aCreatedRole = FSRole::getRole($args)->getContent();
            
            $argsMessage = array(
                'messageNumber' => 165,
                'message'       => 'New Role added !',
                'status'        => true,
                'content'       => $aCreatedRole
            );
            $return = new Message($argsMessage);

        } else {
            $argsMessage = array(
                'messageNumber' => 165,
                'message'       => 'Error while inserting new Role',
                'status'        => false,
                'content'       => NULL
            );
            $return = new Message($argsMessage);
        }// else
        return $return;
    } // END createRole
    
}

?>
