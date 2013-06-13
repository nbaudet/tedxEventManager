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
    public static function getAllUnitsForMember(Member $member) {
        global $crud;
        
        $sql = "SELECT Unit.Name FROM Member
            INNER JOIN Membership
            ON Member.ID = Membership.MemberID
            INNER JOIN Unit
            ON Membership.UnitNo = Unit.No
            WHERE Member.ID = '" . $member->getId() . "'";
        
        $data = $crud->getRows($sql);
        
        // If we got the units, we give them back to the caller
        if( $data ) {
            
            $units = array();
            
            foreach( $data as $unit ) {
                $units[] = $unit['Name'];
            }
            
            return $units;
        }
        // Else : we give NULL back
        else {
            return NULL;
        }
    }
    
    /**
     * Returns all the unit Numbers of a member, or NULL if the member doesn't 
     * have any units
     * @global Crud $crud A Crud Object
     * @param Member $member The member we are getting the units for.
     * @return Message The Units for a member
     */
    public static function getAllUnitsNumbersForMember(Member $member) {
        global $crud;
        
        $sql = "SELECT Unit.No FROM Member
            INNER JOIN Membership
            ON Member.ID = Membership.MemberID
            INNER JOIN Unit
            ON Membership.UnitNo = Unit.No
            WHERE Member.ID = '" . $member->getId() . "'";
        
        $data = $crud->getRows($sql);
        
        // If we got the units, we give them back to the caller
        if( $data ) {
            
            $units = array();
            
            foreach( $data as $unit ) {
                $units[] = $unit['No'];
            }
            
            return $units;
        }
        // Else : we give NULL back
        else {
            return NULL;
        }
    }
}

?>
