<?php
/**
 * Description of FSAccess
 *
 * @author Nicolas Baudet <nicolas.baudet@heig-vd.ch>
 */

require_once(APP_DIR . '/core/model/Unit.class.php');
require_once(APP_DIR . '/core/model/Access.class.php');
require_once(APP_DIR . '/core/model/Message.class.php');

class FSAccess {
    
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
            INNER JOIN Permission
            ON Access.No = Permission.AccessNo
            AND Access.IsArchived = 0
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
    
} // class

?>
