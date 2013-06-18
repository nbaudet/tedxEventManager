<?php
/**
 * Description of FSUnit
 *
 * @author rapou
 */

require_once(APP_DIR . '/core/model/Unit.class.php');
require_once(APP_DIR . '/core/model/Message.class.php');

class FSUnit {
    /**
     * The constructor that does nothing
     */
    public function __construct() {
        // Nothing
    }
    
    public static function getUnit($aNo) {
        $unit = NULL;
        
        global $crud;
        
        $sql = "SELECT * FROM Unit WHERE Unit.No = $aNo";
        $data = $crud->getRow($sql);
        
        if($data){
            $argsUnit = array(
                'no'      => $data['No'],
                'name'        => $data['Name'],
                'isArchived'    => $data['IsArchived'],
            );
            
            $unit = new Unit($argsUnit);
            
            $argsMessage = array(
                'messageNumber' => 400,
                'message'       => 'Existant Unit',
                'status'        => true,
                'content'       => $unit
            );
            $message = new Message($argsMessage);
            return $message;
        } else {
            $argsMessage = array(
                'messageNumber' => 401,
                'message'       => 'Inexistant Unit',
                'status'        => false,
                'content'       => NULL
            );
            $message = new Message($argsMessage);
            return $message;
        }
    }
    
    public static function getUnitByName($aName) {
        $unit = NULL;
        
        global $crud;
        
        $sql = "SELECT * FROM Unit WHERE Unit.Name = '" . $aName . "'";
        $data = $crud->getRow($sql);
        
        if($data){
            $argsUnit = array(
                'no'      => $data['No'],
                'name'        => $data['Name'],
                'isArchived'    => $data['IsArchived'],
            );
            
            $unit = new Unit($argsUnit);
            
            $argsMessage = array(
                'messageNumber' => 400,
                'message'       => 'Existant Unit',
                'status'        => true,
                'content'       => $unit
            );
            $message = new Message($argsMessage);
            return $message;
        } else {
            $argsMessage = array(
                'messageNumber' => 401,
                'message'       => 'Inexistant Unit',
                'status'        => false,
                'content'       => NULL
            );
            $message = new Message($argsMessage);
            return $message;
        }
    }
    
    /**
     * Returns all the units of a member, or NULL if the member doesn't have 
     * any units
     * @global Crud $crud A Crud Object
     * @param Member $member The member we are getting the units for.
     * @return Message The Units for a member
     */
    public static function getAllUnitsFromMember(Member $member) {
        global $crud;
        // SQL statement
        $sql = "SELECT * FROM Member
            INNER JOIN Membership
            ON Member.ID = Membership.MemberID
            INNER JOIN Unit
            ON Membership.UnitNo = Unit.No
            WHERE Member.ID = '" . $member->getId() . "'
            AND Unit.IsArchived = 0";
        // exec query
        $data = $crud->getRows($sql);
        
        // If we got the units, we give them back to the caller
        if( $data ) {
            // list of units
            $units = array();
            
            foreach( $data as $row ) {
                $argsUnit = array(
                    'no'            => $row['No'],
                    'name'          => $row['Name'],
                    'isArchived'    => $row['IsArchived'],
                );

                $aUnit = new Unit($argsUnit);
                // put into array $units
                $units[] = $aUnit;
            }// foreach
            
            // message units found
            $args = array(
                'messageNumber' => 013,
                'message'       => 'Units founds',
                'status'        => true,
                'content'       => $units
            );
            $message= new Message($args);
            
        }// if
        //
        else {
            // message units not found
            $args = array(
                'messageNumber' => 014,
                'message'       => 'Units not founds',
                'status'        => false,
                'content'       => null
            );
            $message= new Message($args);
        }// else
        
        return $message;
    }// function
    
    
    /**
     * A way to get all the units in the database.
     * @global Crud $crud
     * @return Message with all the units
     */
    public static function getAllUnits() {
        
        global $crud;
        // SQL statement
        $sql = "SELECT * FROM Unit
            WHERE Unit.IsArchived = 0
            ORDER BY Unit.No";
        // exec query
        $data = $crud->getRows($sql);
        
        // If we got the units, we give them back to the caller
        if( $data ) {
            // list of units
            $units = array();
            
            foreach( $data as $row ) {
                $argsUnit = array(
                    'no'            => $row['No'],
                    'name'          => $row['Name'],
                    'isArchived'    => $row['IsArchived'],
                );

                $aUnit = new Unit($argsUnit);
                // put into array $units
                $units[] = $aUnit;
            }// foreach
            
            // message units found
            $args = array(
                'messageNumber' => 013,
                'message'       => 'Units founds',
                'status'        => true,
                'content'       => $units
            );
            $message= new Message($args);
            
        }// if
        //
        else {
            // message units not found
            $args = array(
                'messageNumber' => 014,
                'message'       => 'Units not founds',
                'status'        => false,
                'content'       => null
            );
            $message= new Message($args);
        }// else
        return $message;
    }// function
    
}// class

?>
