<?php

/**
 * Description of FSLocation
 *
 * @author Robin Jet-Pierre
 */

require_once(APP_DIR . '/core/model/Location.class.php');
require_once(APP_DIR . '/core/model/Message.class.php');

class FSLocation{
    /**
     *Returns a Locationwith the given No as Id
     *@param string $name the id of the Location
     *@return a Mesage with an existant Location
     */
    public function getLocation($name){
        $location = NULL;
        
        global $crud;
        $name = addslashes($name);
        $sql = "SELECT * FROM Location WHERE Name = '$name'";
        $data = $crud->getRow($sql);
        
        if($data){
            $argsLocation = array(
                'name'          => $data['Name'],
                'address'       => $data['Address'],
                'city'          => $data['City'],
                'country'       => $data['Country'],
                'direction'     => $data['Direction'],
                'isArchived'    => $data['IsArchived']
            );
        
            $location = new Location($argsLocation);

            $argsMessage = array(
                'messageNumber'     => 201,
                'message'           => 'Existant Location',
                'status'            => true,
                'content'           => $location
            );
            $message = new Message($argsMessage);
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

        $sql = "SELECT * FROM Location";
        $data = $crud->getRows($sql);
        
        if ($data){
            $locations = array();

            
            foreach($data as $row){
                $argsLocation = array(
                    'name'          => $row['Name'],
                    'address'       => $row['Address'],
                    'city'          => $row['City'],
                    'country'       => $row['Country'],
                    'direction'     => $row['Direction'],
                    'isArchived'    => $row['IsArchived']
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
                'message'       => 'Error while SELECT * FROM Location',
                'status'        => false,
                'content'       => NULL
            );
            $message = new Message($argsMessage);

            return $message;
        }
    }
    
       /**
     * Add a new Location in Database
     * @param $args Parameters of a Location
     * @return a Message containing the new Location
     */
    public function addLocation($args){
        global $crud;
        
        /*
         * Validate Location NotExistant
         */
        $aValidLocation = FSLocation::getLocation($args['Name']);
        
        /*
         * If already Inexistant Location
         */
        if(!($aValidLocation->getStatus())){ 
            /*0..1 Direction*/
            if($args['Direction']){
                $sql = "INSERT INTO Location (
                    Name, Address, City, Country, Direction) VALUES (
                        '".$args['Name']."', 
                        '".$args['Address']."', 
                        '".$args['City']."', 
                        '".$args['Country']."',
                        '".$args['Direction']."'
                );";
            }else{
                $sql = "INSERT INTO Location (
                    Name, Address, City, Country) VALUES (
                        '".$args['Name']."', 
                        '".$args['Address']."', 
                        '".$args['City']."', 
                        '".$args['Country']."'
                );";
            }
        }else{
            $sql="";
        };
        
        if($crud->exec($sql)){       
            $argsMessage = array(
                'messageNumber' => 205,
                'message'       => 'New Location added !',
                'status'        => true,
                'content'       => 1
            );
            $message = new Message($argsMessage);
            return $message;
        } else {
            $argsMessage = array(
                'messageNumber' => 206,
                'message'       => 'Error while inserting new Location',
                'status'        => false,
                'content'       => NULL
            );
            $message = new Message($argsMessage);

            return $message;
        }   
    }
    
 }
    
?>
