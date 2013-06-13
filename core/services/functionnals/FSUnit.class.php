<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

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
    
    public static function getUnitById($aNo) {
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
                'messageNumber' => 150,
                'message'       => 'Existant Unit',
                'status'        => true,
                'content'       => $unit
            );
            $message = new Message($argsMessage);
            return $message;
        } else {
            $argsMessage = array(
                'messageNumber' => 151,
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
                'messageNumber' => 150,
                'message'       => 'Existant Unit',
                'status'        => true,
                'content'       => $unit
            );
            $message = new Message($argsMessage);
            return $message;
        } else {
            $argsMessage = array(
                'messageNumber' => 151,
                'message'       => 'Inexistant Unit',
                'status'        => false,
                'content'       => NULL
            );
            $message = new Message($argsMessage);
            return $message;
        }
    }
}

?>
