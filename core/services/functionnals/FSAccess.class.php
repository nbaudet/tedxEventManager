<?php
/**
 * Manages the accesses to the API.
 *
 * @author Nicolas Baudet <nicolas.baudet@heig-vd.ch>
 */

require_once(APP_DIR . '/core/model/Unit.class.php');
require_once(APP_DIR . '/core/model/Access.class.php');
require_once(APP_DIR . '/core/model/Message.class.php');

class FSAccess {
    
    /**
     * Adds a new Access in Database
     * @param Mixed $args Parameters of an Access
     * @return Message a message containing the new Access
     */
    public static function addAccess( $args ) {
        global $crud;

        // Verify that the access doesn't exist in the database
        $arrayExistingAccesses = FSAccess::getAccessesAsString()->getContent();
        $accessExists = in_array( $args['Service'], $arrayExistingAccesses );

        // If it exists, we send an error message
        if( $accessExists ) {

            $argsMessage = array(
                'messageNumber' => 027,
                'message'       => 'Already existing Access',
                'status'        => FALSE
            );
            
            $message = new Message($argsMessage);
        }
        // Else: we add the Access
        else {
            
            $sql = "INSERT INTO `Access` (`Service` ,`Type`, `IsArchived`) VALUES (
                        '".$args['Service']."', 
                        '".$args['Type']."',
                        '0'
                    );";
            
            // If add was successfull
            if( $crud->insertReturnLastId( $sql ) ) {
            
                $argsMessage = array(
                    'messageNumber' => 028,
                    'message'       => 'Access added',
                    'status'        => TRUE,
                    //'content'       => $anAddedAccess
                );

                $message = new Message($argsMessage);
            }
            // Else: Add was not successfull

        }// else
        return $message;
    }// End addAccess
    
    /**
     * Returns the access with the specified ID.
     * /!\ Consider that it returns even archived Accesses! Be carefull.
     * @global PDO Object $crud Database Manipulator
     * @param int $accessNo The ID of the access we want
     * @return Message Access found OR No access found
     */
    public static function getAccess( $accessNo ) {
        global $crud;
        
        $sql = "SELECT * FROM Access
            WHERE Access.No = '".$accessNo."'";
        
        $data = $crud->getRow( $sql );
        
        if( $data ) {
            $argsAccess = array (
                'no'         => $data['No'],
                'service'    => $data['Service'],
                'type'       => $data['Type'],
                'isArchived' => $data['IsArchived']
            );
            $access = new Access( $argsAccess );
            
            $args = array(
                'messageNumber' => 025,
                'message'       => 'Access found',
                'status'        => true,
                'content'       => $access
            );
            $message= new Message( $args );
        }
        else {
            $args = array(
                'messageNumber' => 026,
                'message'       => 'No access found',
                'status'        => false
            );
            $message= new Message( $args );
        }
        return $message;
    }
    
    /**
     * Returns the access with this service name, or an error.
     * @global PDO Object $crud
     * @param Mixed $args an array with a 'Service' line setted with the name
     *        of a service
     * @return Message a Message
     */
    public static function getAccessByservice( $args ) {
        global $crud;
        
        $sql = "SELECT * FROM Access
            WHERE Access.Service = '".$args['Service']."'";
        
        $data = $crud->getRow( $sql );
        
        if( $data ) {
            $argsAccess = array (
                'no'         => $data['No'],
                'service'    => $data['Service'],
                'type'       => $data['Type'],
                'isArchived' => $data['IsArchived']
            );
            $access = new Access( $argsAccess );
            
            $args = array(
                'messageNumber' => 025,
                'message'       => 'Access found',
                'status'        => true,
                'content'       => $access
            );
            $message= new Message( $args );
        }
        else {
            $args = array(
                'messageNumber' => 026,
                'message'       => 'No access found',
                'status'        => false
            );
            $message= new Message( $args );
        }
        return $message;
    }
    
    /**
     * Returns all the accesses for a unit, or NULL of a unit doesn't have
     * any access
     * @global type $crud
     * @param Unit $unit The unit we are getting the accesses for
     * @return mixed Array of Accesses Names OR NULL
     */
    public static function getAccessesFromUnit( $unit ) {
        global $crud;

        // SQL Statement to get the accesses for a specified UNIT
        // /!\ NEED IsArchived = 0 OTHERWISE PRIVILEGES DON'T WORK!
        $sql = "SELECT Access.Service FROM Unit
            INNER JOIN Permission
            ON Unit.No = Permission.UnitNo
            INNER JOIN Access
            ON Permission.AccessNo = Access.No
            WHERE Unit.No = '" . $unit->getNo() . "'
            AND Access.IsArchived = 0";
        
        $data = $crud->getRows($sql);
        
        // If we got the Accesses, we give them back to the caller
        if( $data ) {
            
            $accesses = array();
            
            foreach( $data as $access ) {
                $accesses[] = $access['Service'];
            }// foreach
            
            $args = array(
                'messageNumber' => 011,
                'message'       => 'Accesses found',
                'status'        => true,
                'content'       => $accesses
            );
            $message= new Message($args);
            
        }// if
        // Else : we give NULL back
        else {
            $args = array(
                'messageNumber' => 012,
                'message'       => 'Accesses not found',
                'status'        => false,
                'content'       => null
            );
            $message= new Message($args);
        }// else
        
        return $message;
    }// function
    
    
    public static function getAccessesAsString() {
        global $crud;
        
        // SQL Statement to get the accesses for a specified UNIT
        // /!\ NEED IsArchived = 0 OTHERWISE PRIVILEGES DON'T WORK!
        $sql = "SELECT * FROM Access
            INNER JOIN Permission
            ON Access.No = Permission.AccessNo
            AND Access.IsArchived = 0";
        
        $data = $crud->getRows($sql);
        
        // If we got the Accesses, we give them back to the caller
        if( $data ) {
            
            $accesses = array();
            
            foreach( $data as $access ) {
                $accesses[] = $access['Service'];
            }// foreach
            
            $args = array(
                'messageNumber' => 011,
                'message'       => 'Accesses found',
                'status'        => true,
                'content'       => $accesses
            );
            $message= new Message($args);
            
        }// if
        // Else : we give NULL back
        else {
            $args = array(
                'messageNumber' => 012,
                'message'       => 'Accesses not found',
                'status'        => false,
                'content'       => null
            );
            $message= new Message($args);
        }// else
        
        return $message;
    }// function
    
    
    public static function getAccesses() {
        global $crud;
        
        // SQL Statement to get the accesses for a specified UNIT
        // /!\ NEED IsArchived = 0 OTHERWISE PRIVILEGES DON'T WORK!
        $sql = "SELECT * FROM Access
            WHERE Access.IsArchived = 0
            ORDER BY Access.Service";
        
        $data = $crud->getRows($sql);

        // If we got the Accesses, we give them back to the caller
        if( $data ) {
            $accesses = array();
            
            foreach( $data as $access ) {
                $argsAccess = array (
                    'no'         => $access['No'],
                    'service'    => $access['Service'],
                    'type'       => $access['Type'],
                    'isArchived' => $access['IsArchived']
                );
                $newAccess = new Access ( $argsAccess );
                
                // We only want unique values
                if( !in_array ( $newAccess, $accesses ) ) {
                    $accesses[] = $newAccess;
                }
            }// foreach
            
            $args = array(
                'messageNumber' => 011,
                'message'       => 'Accesses found',
                'status'        => true,
                'content'       => $accesses
            );
            $message= new Message($args);
            
        }// if
        // Else : we give NULL back
        else {
            $args = array(
                'messageNumber' => 012,
                'message'       => 'Accesses not found',
                'status'        => false,
                'content'       => null
            );
            $message= new Message($args);
        }// else
        
        return $message;
    }// function
    
    
    /**
     * Functionnal Service setAccess
     * @param Access $accessToSet The Access to update
     * @return Message $message anAddedAccess OR an Error
     */
    public static function setAccess( $accessToSet ) {
        // get database manipulator
        global $crud;

        // Check if an access with same No exists
        $noAccess = $accessToSet->getNo();
        $messageAccess = FSAccess::getAccess($noAccess);
        
        // If the Access exists
        if( $messageAccess->getStatus() ) {
            $access = $messageAccess->getContent();
            // If the access was archived, we un-archive it
            if( $access->getIsArchived() == 1 ) {
                
                $sql = "UPDATE Access SET
                    `Service` = '".$accessToSet->getService()."',
                    `Type` = '".$accessToSet->getType()."',
                    `IsArchived` = '0'
                    WHERE Access.No = '".$accessToSet->getNo()."'";
                
                // If it was successful
                if( $crud->exec( $sql ) != 0 ) {
                
                    $args = array(
                        'messageNumber' => 029,
                        'message'       => 'Access successfully udpated',
                        'status'        => true,
                        'content'       => $anAccessToSet
                    );
                    $message= new Message( $args );
                }
                // Else: unarchiving unsuccessfull
                else {
                    $args = array(
                        'messageNumber' => 030,
                        'message'       => 'Problem while updating access',
                        'status'        => false
                    );
                    $message= new Message( $args );
                }
                
            }
            // Else: archive the access
            else {
                $sql = "UPDATE Access SET
                    `Service` = '".$accessToSet->getService()."',
                    `Type` = '".$accessToSet->getType()."',
                    `IsArchived` = '1'
                    WHERE Access.No = '".$accessToSet->getNo()."'";
                
                // If it was successful
                if( $crud->exec( $sql ) != 0 ) {
                
                    $args = array(
                        'messageNumber' => 029,
                        'message'       => 'Access successfully udpated',
                        'status'        => true,
                        'content'       => $anAccessToSet
                    );
                    $message= new Message( $args );
                }
                // Else: archiving unsucessfull
                else {
                    $args = array(
                        'messageNumber' => 030,
                        'message'       => 'Problem while updating access',
                        'status'        => false
                    );
                    $message= new Message( $args );
                }
            }
        }
        // Else: return an error
        else {
            $args = array(
                'messageNumber' => 026,
                'message'       => 'No access found',
                'status'        => false
            );
            $message= new Message( $args );
        }
        
        
        return $message;
    }// function
    
    public static function deleteAccess( $accessToDelete ) {
        
        global $crud;
        
        // Delete the Permission
        $sql = "DELETE FROM Permission
            WHERE Permission.AccessNo = '".$accessToDelete->getNo()."'";
        
        // If Memberships were deleted
        if( $crud->exec( $sql ) != 0 ) {
            
            // Delete Access
            $sql = "DELETE FROM Access
            WHERE Access.No = '".$accessToDelete->getNo()."'";
            
            // If delete Access was OK
            if( $crud->exec( $sql ) != 0 ) {

                $args = array(
                    'messageNumber' => 042,
                    'message'       => 'Access and Permissions deleted',
                    'status'        => true
                );
                $message= new Message( $args );
            }
            // Else: delete Access was not OK
            else {
                $args = array(
                    'messageNumber' => 043,
                    'message'       => 'Permissions deleted but not Access',
                    'status'        => false
                );
                $message= new Message( $args );
            }
        }
        // Else: the permission couldn't be deleted
        else {
            $args = array(
                'messageNumber' => 044,
                'message'       => 'Error while deleting Permissions of Access',
                'status'        => false
            );
            $message= new Message( $args );
        }
        return $message;
    }
} // class

?>
