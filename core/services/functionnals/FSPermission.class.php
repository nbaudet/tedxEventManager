<?php
/**
 * The Permission functionnal service lets you add/update/archive Permissions,
 * which are links between the tables Access and Unit.
 *
 * @author Nicolas Baudet <nicolas.baudet@heig-vd.ch>
 */
require_once(APP_DIR . '/core/model/Permission.class.php');
require_once(APP_DIR . '/core/model/Access.class.php');

class FSPermission {
    
    /**
     * Returns a Permission with the given AccessNo and UnitNo as Id.
     * @param Access $AccessNo The No of an Access
     * @param Unit $unitNo The No of a Unit
     * @return a Message containing an existing Permission OR an error
     */
    public static function getPermission( $args ) {
        $permission = NULL;
        $access = $args['access'];
        $unit = $args['unit'];
        
        global $crud;
        
        $sql = "SELECT * FROM Permission
            WHERE AccessNo = '".$access->getNo()."'
            AND UnitNo = ".$unit->getNo();
        
        $data = $crud->getRow($sql);
        
        if($data){
            $argsPermission = array(
                'AccessNo'      => $data['AccessNo'],
                'unitNo'        => $data['UnitNo'],
                'isArchived'    => $data['IsArchived']
            );
            
            $permission = new Permission($argsPermission);
            
            $argsMessage = array(
                'messageNumber' => 107,
                'message'       => 'Existing Permission',
                'status'        => true,
                'content'       => $permission
            );
            $message = new Message($argsMessage);
            return $message;
        } else {
            $argsMessage = array(
                'messageNumber' => 108,
                'message'       => 'Inexistant Permission',
                'status'        => false,
                'content'       => NULL
            );
            $message = new Message($argsMessage);
            return $message;
        }// else
    }// function
    
    /**
     * Returns all the Permissions of the database
     * @return A Message containing an array of Permissions
     */
    public static function getPermissions(){
        global $crud;
        
        $sql = "SELECT * FROM Permission
            WHERE Permission.IsArchived = 0";
        $data = $crud->getRows($sql);
        
        if ($data){
            $permissions = array();

            foreach($data as $row){
                $argsPermission = array(
                    'memberId'      => $row['MemberID'],
                    'unitNo'        => $row['UnitNo'],
                    'isArchived'    => $row['IsArchived'],
                );
            
                $permissions[] = new MemberShip($argsPermission);
            } //foreach

            $argsMessage = array(
                'messageNumber' => 109,
                'message'       => 'All Permissions selected',
                'status'        => true,
                'content'       => $permissions
            );
            $message = new Message($argsMessage);

            return $message;
        } else {
            $argsMessage = array(
                'messageNumber' => 110,
                'message'       => 'Error while SELECT * FROM Permission',
                'status'        => false,
                'content'       => NULL
            );
            $message = new Message($argsMessage);

            return $message;
        }// else
    }// function
    
    /**
     * Add a new Permission in Database
     * @param $args Parameters of a Permission
     * @return a Message containing the new Permission
     */
    public static function addPermission($args){
        global $crud;
        $return = null;
        $member = $args['member'];
        $unit = $args['unit'];

        // Validate Member
        $aValidMember = FSMember::getMember($member->getId());
        
        if($aValidMember->getStatus()){
            
            // Validate Unit
            $aValidUnit = FSUnit::getUnit($unit->getNo());
            
            if ($aValidUnit->getStatus()){
                
                // Validate Permission
                $anInexistantPermission = FSPermission::getPermission($args);
                
                if(!$anInexistantPermission->getStatus()){
                    
                    // Create new Permission
                    $sql = "INSERT INTO `Permission` (`MemberID` ,`UnitNo`) VALUES (
                        '".$member->getId()."', 
                        '".$unit->getNo()."'
                    );";
                    
                    if($crud->exec($sql) != 0){
                        
                        // Get created Permission
                        $aCreatedPermission = FSPermission::getPermission($args);

                        $argsMessage = array(
                            'messageNumber' => 111,
                            'message'       => 'New Permission added !',
                            'status'        => true,
                            'content'       => $aCreatedPermission
                        );
                        $return = new Message($argsMessage);
                        
                        
                    } else {
                        $argsMessage = array(
                            'messageNumber' => 112,
                            'message'       => 'Error while inserting new Permission',
                            'status'        => false,
                            'content'       => NULL
                        );
                        $return = new Message($argsMessage);
                    }// else
                    
                } // End Create new Permission
                else {
                    $argsMessage = array(
                        'messageNumber' => 114,
                        'message'       => 'Permission already existant !',
                        'status'        => FALSE,
                        'content'       => null
                    );

                $return = new Message($argsMessage);
                }// else
                
            } else {
                $argsMessage = array(
                    'messageNumber' => 114,
                    'message'       => 'No matching Unit found',
                    'status'        => FALSE,
                    'content'       => null
                );
            
            $return = new Message($argsMessage);
            }// else
            
        } else {
            $argsMessage = array(
                'messageNumber' => 113,
                'message'       => 'No matching Member found',
                'status'        => FALSE,
                'content'       => null
            );
            
            $return = new Message($argsMessage);
            
        }// end
        
        return $return;
        
    }// End addPermission
    
    
    public static function setPermission( Member $access, Unit $unit ) {
        $args = array(
            'access' => $access,
            'unit'   => $unit
        );
        $messagePermission = FSPermission::getPermission( $args );
        var_dump($messagePermission);
    }
    
    
}// class
?>
