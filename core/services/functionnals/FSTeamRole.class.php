<?php


/**
 * Description of FSTeamRole
 *
 * @author rapou
 */
class FSTeamRole {
       /**
     *Returns a TeamRole with the given No as Id
     *@param string $name the id of the TeamRole
     *@return a Mesage with an existant TeamRole
     */
    public function getTeamRole($name){
        $location = NULL;
        
        global $crud;
        $name = addslashes($name);
        $sql = "SELECT * FROM TeamRole WHERE Name = '$name'";
        $data = $crud->getRow($sql);
        
        if($data){
            $argsLocation = array(
                'name'          => $data['Name'],
                'isMemberOf'    => $data['IsMemberOf'],
                'isArchived'    => $data['IsArchived']
            );
        
            $location = new TeamRole($argsTeamRole);

            $argsMessage = array(
                'messageNumber'     => 301,
                'message'           => 'Existant TeamRole',
                'status'            => true,
                'content'           => $teamRole
            );
            $message = new Message($argsMessage);
            return $message;
        }else{
            $argsMessage = array(
                'messageNumber'     => 302,
                'message'           => 'Inexistant TeamRole',
                'status'            => false,
                'content'           => NULL    
            );
            $message = new Message($argsMessage);
            return $message;
        }// else
    }// function

    /**
     * Returns all the TeamRoles of the database
     * @return A Message containing an array of TeamRoles
     */
    public function getTeamRoles(){
        global $crud;

        $sql = "SELECT * FROM TeamRole WHERE IsArchived = 0";
        $data = $crud->getRows($sql);
        
        if ($data){
            $locations = array();

            
            foreach($data as $row){
                $argsLocation = array(
                    'name'          => $row['Name'],
                    'isMemberOf'    => $row['IsMemberOf'],
                    'isArchived'    => $row['IsArchived']
                );
            
                $locations[] = new TeamRole($argsTeamRole);
            } //foreach

            $argsMessage = array(
                'messageNumber' => 303,
                'message'       => 'All TeamRoles selected',
                'status'        => true,
                'content'       => $teamRoles
            );
            $message = new Message($argsMessage);

            return $message;
        } else {
            $argsMessage = array(
                'messageNumber' => 304,
                'message'       => 'Error while SELECT * FROM TeamRole',
                'status'        => false,
                'content'       => NULL
            );
            $message = new Message($argsMessage);

            return $message;
        }// else
    }// function
}

?>
