<?php

require_once(APP_DIR . '/core/model/Unit.class.php');
require_once(APP_DIR . '/core/model/Message.class.php');

/**
 * Description of FSUnit
 *
 * @author rapou
 */
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
     * Returns all the units of a member
     * @global Crud $crud A Crud Object
     * @param Member $member The member we are getting the units for.
     * @return Message The Units for a member
     */
    public static function getAllUnitsForMember(Member $member) {
        $unit = NULL;
        
        global $crud;
        
        $sql = "SELECT * FROM Member
            INNER JOIN Membership
            ON Member.ID = Membership.MemberID
            INNER JOIN Unit
            ON Membership.UnitNo = Unit.No
            WHERE Member.ID = '" . $member->getId() . "'";
        $data = $crud->getRows($sql);
        
        echo '<h1>asdfélkajsdfélkajsfd</h1>';
        var_dump($data);
        echo '<h1>asdfélkajsdfélkajsfd</h1>';
        
        // If we got the 
        if($data){
            $argsUnit = array(
                'no'      => $data['No'],
                'name'        => $data['Name'],
                'isArchived'    => $data['IsArchived']
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
        }
    }
}

?>
