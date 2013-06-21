<?php

require_once(APP_DIR . '/core/model/TeamRole.class.php');

/**
 * Description of FSTeamRole
 *
 * @author Lauric
 */
class FSTeamRole {
       /**
     *Returns a TeamRole with the given No as Id
     *@param string $name the id of the TeamRole
     *@return a Mesage with an existant TeamRole
     */
    public static function getTeamRole($name){
        $teamRole = NULL;
        
        global $crud;
        $name = addslashes($name);
        $sql = "SELECT * FROM TeamRole WHERE Name = '$name'";
        $data = $crud->getRow($sql);
        
        if($data){
            $argsTeamRole = array(
                'name'          => $data['Name'],
                'isMemberOf'    => $data['IsMemberOf'],
                'isArchived'    => $data['IsArchived']
            );
        
            $teamRole = new TeamRole($argsTeamRole);

            $argsMessage = array(
                'messageNumber'     => 147,
                'message'           => 'Existant TeamRole',
                'status'            => true,
                'content'           => $teamRole
            );
            $return = new Message($argsMessage);

        }else{
            $argsMessage = array(
                'messageNumber'     => 148,
                'message'           => 'Inexistant TeamRole',
                'status'            => false,
                'content'           => NULL    
            );
            $return = new Message($argsMessage);

        }
        return $return;
    }// function

    /**
     * Returns all the TeamRoles of the database
     * @return A Message containing an array of TeamRoles
     */
    public static function getTeamRoles(){
        global $crud;

        $sql = "SELECT * FROM TeamRole WHERE IsArchived = 0";
        $data = $crud->getRows($sql);
        
        if ($data){
            $teamRoles = array();
 
            foreach($data as $row){
                $argsTeamRole = array(
                    'name'          => $row['Name'],
                    'isMemberOf'    => $row['IsMemberOf'],
                    'isArchived'    => $row['IsArchived']
                );
            
                $teamRoles[] = new TeamRole($argsTeamRole);
            } //foreach

            $argsMessage = array(
                'messageNumber' => 151,
                'message'       => 'All TeamRoles selected',
                'status'        => true,
                'content'       => $teamRoles
            );
            $return = new Message($argsMessage);

        } else {
            $argsMessage = array(
                'messageNumber' => 152,
                'message'       => 'Error while SELECT * FROM TeamRole',
                'status'        => false,
                'content'       => NULL
            );
            $return = new Message($argsMessage);

        }
        return $return;
        
    }// function
    
    /**
     * Checks non existance of new TeamRole to add, and calls the createTeamRole function
     * @param string $name
     * @return a Message containing the added TeamRole
     */
    public static function addTeamRole($name){

        // Validate Inexistant TeamRole
        $messageValidateTeamRole = FSTeamRole::getTeamRole($name);
        
        // Create new TeamRole 
        if (!$messageValidateTeamRole->getStatus()){
            
            $messageCreateTeamRole = FSTeamRole::createTeamRole($name);
            $return = $messageCreateTeamRole;
            
        } else {
            // Existant TeamRole
            $return = $messageValidateTeamRole;
        }
        
        return $return;
    } // END addTeamRole
    
    /**
     * Inserts a new TeamRole in database
     * @param string $name
     * @return a Message containing the created TeamRole
     */
    public static function createTeamRole($name){
        global $crud;
        
        $sql = "INSERT INTO TeamRole (Name) VALUES (
            '$name'
        )";
        
        $data = $crud->exec($sql);
        
        if ($data){
                        
            $messageCreateTeamRole = FSTeamRole::getTeamRole($name);
            
            if ($messageCreateTeamRole->getStatus()){
                $aCreatedTeamRole = $messageCreateTeamRole->getContent();
                $argsMessage = array(
                    'messageNumber' => 153,
                    'message'       => 'New TeamRole added !',
                    'status'        => true,
                    'content'       => $aCreatedTeamRole
            );
            
            $return = new Message($argsMessage);
            
            } else {
                $argsMessage = array(
                    'messageNumber' => 154,
                    'message'       => 'Error while inserting new TeamRole',
                    'status'        => false,
                    'content'       => NULL
                );
                $return = new Message($argsMessage);
            }
            return $return;                   
        }
    } // END createTeamRole
    
    /**
     * Set new parameters to a Motivation
     * @param Motivation $aMotivationToSet
     * @return Message containing the set Motivation */
    public static function setTeamRole($aTeamRoleToSet) {
        global $crud;
var_dump($aTeamRoleToSet);
        $aTeamRoleToSet = new TeamRole($aTeamRoleToSet);
        var_dump($aTeamRoleToSet);
        $aValideTeamRole = FSTeamRole::getTeamRole($aTeamRoleToSet->getName());
        $aValideIsMemberOfTeamRole = FSTeamRole::getTeamRole($aTeamRoleToSet->getIsMemberOf()->getName());
        //If Event valide
        if ($aValideTeamRole->getStatus()) {
            //If there is a Location Name given
            if (($aTeamRoleToSet->getIsMemberOf())) {
                //If this Location is valide
                if ($aValideIsMemberOfTeamRole->getStatus()) {
                    $sql = "UPDATE  Event SET  
                     IsMemberOf = '" . addslashes($aTeamRoleToSet->getIsMemberOf()) . "',
                     IsArchived = " . $aTeamRoleToSet->getIsArchived() . "
                     WHERE  TeamRole.Name = " . $aTeamRoleToSet->getName();
                } else {
                    $argsMessage = array(
                        'messageNumber' => 234,
                        'message' => 'Inexistant TeamRole for Is Member Of',
                        'status' => false,
                        'content' => NULL
                    );
                    $message = new Message($argsMessage);
                    return $message;
                };
            } else {
                $sql = "UPDATE  Event SET
                     IsArchived = " . $aTeamRoleToSet->getIsArchived() . "
                     WHERE  TeamRole.Name = " . $aTeamRoleToSet->getName();
            }

            //If query OK
            if ($crud->exec($sql) == 1) {
                $sql = "SELECT * FROM TeamRole 
                         WHERE Name = " . $aTeamRoleToSet->getName();

                $data = $crud->getRow($sql);

                
                    $argsTeamRole = array(
                        'name' => $anEventToSet->getName(),
                        'isMemberOf' => $anEventToSet->getIsMemberOf(),
                        'isArchived' => $anEventToSet->getIsArchived()
                    );
               

                $aSetTeamRole = new Event($argsTeamRole);

                $argsMessage = array(
                    'messageNumber' => 232,
                    'message' => 'TeamRole set !',
                    'status' => true,
                    'content' => $aSetTeamRole
                );
                $message = new Message($argsMessage);
            } else {
                $argsMessage = array(
                    'messageNumber' => 233,
                    'message' => 'Error while setting new Event',
                    'status' => false,
                    'content' => NULL
                );
                $message = new Message($argsMessage);
            }//End query ok  
        } else {
            $argsMessage = array(
                'messageNumber' => 235,
                'message' => 'Inexistant TeamRole',
                'status' => false,
                'content' => NULL
            );
            $message = new Message($argsMessage);
        }//End Event valide
        return $message;
    }//End Set TeamRole
}

?>
