<?php

require_once(APP_DIR . '/core/model/Unit.class.php');
require_once(APP_DIR . '/core/model/Message.class.php');


/**
 * FSUnit.class.php
 * 
 * Author : Raphael Schmutz
 * Date : 25.06.2013
 * 
 * Description : define the class FSUnit as definited in the model
 * 
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
    }//function
    
    
    /**
     * get Unit by name
     * @global Crud $crud
     * @param type $aName
     * @return \Message
     */
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
    }//function
    
    /**
     * Returns all the units of a member, or NULL if the member doesn't have 
     * any units
     * @global Crud $crud A Crud Object
     * @param Member $member The member we are getting the units for.
     * @return Message The Units for a member
     */
    public static function getUnitsFromMember(Member $member) {
        global $crud;
        // SQL statement
        $sql = "SELECT * FROM Membership
            INNER JOIN Unit
            ON Membership.UnitNo = Unit.No
            WHERE Membership.MemberID = '" . $member->getId() . "'
            AND Membership.IsArchived = 0";
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
     * get Units from Access
     * @global Crud $crud
     * @param Access $access
     * @return \Message
     */
    public static function getUnitsFromAccess( Access $access ) {
        global $crud;
        // SQL statement
        $sql = "SELECT * FROM Permission
            INNER JOIN Unit
            ON Permission.UnitNo = Unit.No
            INNER JOIN Access
            ON Access.No = Permission.AccessNo
            WHERE Permission.AccessNo = '" . $access->getNo() . "'
            AND Permission.IsArchived = 0
            ORDER BY Access.Service";

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
            //$units = 
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
    }//function
    
    
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
