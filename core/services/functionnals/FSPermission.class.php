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
                'accessNo'      => $data['AccessNo'],
                'unitNo'        => $data['UnitNo'],
                'isArchived'    => $data['IsArchived']
            );
            
            $permission = new Permission($argsPermission);
            
            $argsMessage = array(
                'messageNumber' => 031,
                'message'       => 'Existing Permission',
                'status'        => true,
                'content'       => $permission
            );
            $message = new Message($argsMessage);
            return $message;
        } else {
            $argsMessage = array(
                'messageNumber' => 032,
                'message'       => 'Inexistant Permission',
                'status'        => false
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
                    'accessNo'      => $row['AccessNo'],
                    'unitNo'        => $row['UnitNo'],
                    'isArchived'    => $row['IsArchived'],
                );
            
                $permissions[] = new Permission($argsPermission);
            } //foreach

            $argsMessage = array(
                'messageNumber' => 033,
                'message'       => 'All Permissions selected',
                'status'        => true,
                'content'       => $permissions
            );
            $message = new Message($argsMessage);

            return $message;
        } else {
            $argsMessage = array(
                'messageNumber' => 034,
                'message'       => 'Error while SELECT * FROM Permission',
                'status'        => false
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
        
        $access = $args['access'];
        $unit = $args['unit'];

        // Validate Access
        $aValidAccess = FSAccess::getAccess($access->getNo());
        
        // If the Access exists
        if($aValidAccess->getStatus()){
            
            // Validate Unit
            $aValidUnit = FSUnit::getUnit($unit->getNo());
            
            // If the unit exists
            if ($aValidUnit->getStatus()){
                
                // Validate Permission
                $anInexistantPermission = FSPermission::getPermission( $args );
                
                if(!$anInexistantPermission->getStatus()){
                    
                    // Create new Permission
                    $sql = "INSERT INTO `Permission` (`AccessNo` ,`UnitNo`) VALUES (
                        '".$access->getNo()."', 
                        '".$unit->getNo()."'
                    );";
                    
                    if($crud->exec($sql) != 0){
                        
                        // Get created Permission
                        $aCreatedPermission = FSPermission::getPermission($args);

                        $argsMessage = array(
                            'messageNumber' => 035,
                            'message'       => 'Permission added',
                            'status'        => true,
                            'content'       => $aCreatedPermission
                        );
                        $message = new Message($argsMessage);
                        
                        
                    } else {
                        $argsMessage = array(
                            'messageNumber' => 036,
                            'message'       => 'Error while adding Permission',
                            'status'        => false
                        );
                        $message = new Message($argsMessage);
                    }// else
                    
                }
                // Else: Cannot add because already existing
                else {
                    $argsMessage = array(
                        'messageNumber' => 037,
                        'message'       => 'Permission already exists',
                        'status'        => false
                    );

                $message = new Message($argsMessage);
                }// else
                
            } else {
                $argsMessage = array(
                    'messageNumber' => 114,
                    'message'       => 'No matching Unit found',
                    'status'        => false
                );
            
            $message = new Message($argsMessage);
            }// else
        // Else: The Access doesn't exist
        } else {
            $argsMessage = array(
                'messageNumber' => 038,
                'message'       => 'No matching Access found',
                'status'        => FALSE,
            );
            
            $message = new Message($argsMessage);
        }// end
        
        return $message;
    }// End addPermission
    
    /**
     * Upsert a Permission
     * @global type $crud
     * @param type $args
     * @return type message
     */
    public static function upsertPermission( $args ) {
        $access = $args['access'];
        $unit   = $args['unit'];
        
        global $crud;
        
        $message;
        
        $messagePermission = FSPermission::getPermission( $args );
        
        // If the permission was already existing
        if( $messagePermission->getStatus() ) {
            
            $permission = $messagePermission->getContent();
            
            // If the permission was archived, we un-archived it
            if( $permission->getIsArchived() == 1 ) {
                $sql = "UPDATE Permission
                    SET
                    IsArchived = '0'
                    WHERE Permission.AccessNo = '".$access->getNo()."'
                    AND Permission.UnitNo = '".$unit->getNo()."'";
                
                // If the udpate was successfull
                if( $crud->exec($sql) == 1 ) {
                    
                    $aSettedPermission = FSPermission::getPermission( $args );
                    
                    $argsMessage = array(
                        'messageNumber' => 039,
                        'message' => 'Permission updated',
                        'status' => true,
                        'content' => $aSettedPermission
                    );
                    $message = new Message($argsMessage);
                }
                // Else : impossible to update permission
                else {
                    $argsMessage = array(
                        'messageNumber' => 040,
                        'message' => 'Error while updating permission',
                        'status' => false
                    );
                    $message = new Message($argsMessage);
                }
            }
            // Else : archive the permission
            else {
                $sql = "UPDATE Permission
                SET
                IsArchived = '1'
                WHERE Permission.AccessNo = '".$access->getNo()."'
                AND Permission.UnitNo = '".$unit->getNo()."'";
                
                // If the udpate was successfull
                if( $crud->exec($sql) == 1 ) {
                    
                    $aSettedPermission = FSPermission::getPermission( $args );
                    
                    $argsMessage = array(
                        'messageNumber' => 041,
                        'message' => 'Permission updated',
                        'status' => true,
                        'content' => $aSettedPermission
                    );
                    $message = new Message($argsMessage);
                }
                // Else : impossible to update permission
                else {
                    $argsMessage = array(
                        'messageNumber' => 040,
                        'message' => 'Error while updating permission',
                        'status' => false
                    );
                    $message = new Message($argsMessage);
                }
                
            }
        }
        // Else : otherwise, we create it
        else {
            $message = FSPermission::addPermission( $args );
        }
        
        return $messagePermission;
    }//function
    
    
}// class
?>
