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
    public function getLocation($name){
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

    /**
     * Returns all the Locations of the database
     * @return A Message containing an array of Locations
     */
    public function getLocations(){
        global $crud;
        
        $sql = "SELECT * FROM location";
        $data = $crud->getRows($sql);
        
        if ($data){
            $locations = array();

            
            foreach($data as $row){
                $argsLocation = array(
                    'name'          => $data['name'],
                    'address'       => $data['address'],
                    'city'          => $data['city'],
                    'country'       => $data['country'],
                    'direction'     => $data['direction'],
                    'isArchived'    => $data['isArchived']
                );
            
                $locations[] = new Location($argsLocation);
            } //foreach

            $argsMessage = array(
                'messageNumber' => 203,
                'message'       => 'All Locations selected',
                'status'        => true,
                'content'       => $locations
            );
            $message = new Message($argsMessage);

            return $message;
        } else {
            $argsMessage = array(
                'messageNumber' => 204,
                'message'       => 'Error while SELECT * FROM location',
                'status'        => false,
                'content'       => NULL
            );
            $message = new Message($argsMessage);

            return $message;
        }
    }
 }
    
?>
