<?php

/**
 * Description of FSLocation
 *
 * @author Robin Jet-Pierre
 */
class FSLocation{
    /**
     *Returns a Locationwith the given No as Id
     *@param string $name the id of the Location
     *@return a Mesage with an existant Location
     */
    protected function getLocation($name){
        $location='';
        
        global $crud;
        
        $sql = "SELECT * FROM location WHERE name = $name";
        $data = $crud->getRow($sql);
        
        if($data){
            $argsLocation = array(
                'name'          => $data['name'],
                'address'       => $data['address'],
                'city'          => $data['city'],
                'country'       => $data['country'],
                'direction'     => $data['direction'],
                'isArchived'    => $data['isArchived']
            );
        
            $location = new Location($argsLocation);

            $argsMessage = array(
                'messageNumber'     => 201,
                'message'           => 'Existant Location',
                'status'            => true,
                'content'           => $location
            );
            $message = new Message($argMessage);
            return $message;
        }else{
            $argsMessage = array(
                'messageNumber'     => 202,
                'message'           => 'Inexistant Location',
                'status'            => false,
                'content'           => NULL    
            );
            $message = new Message($argsMessage);
            return $message;
        }
    }
}
?>
