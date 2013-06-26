<?php

require_once(APP_DIR . '/core/model/Location.class.php');
require_once(APP_DIR . '/core/model/Message.class.php');


/**
 * FSLocation.class.php
 * 
 * Author : Robin Jet-Pierre
 * Date : 25.06.2013
 * 
 * Description : define the class FSLocation as definited in the model
 * 
 */
class FSLocation{
    /**
     *Returns a Locationwith the given No as Id
     *@param string $name the id of the Location
     *@return a Mesage with an existant Location
     */
    public static function getLocation($name){
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
        }// else
    }// function

    
    /**
     * Returns all the Locations of the database
     * @return A Message containing an array of Locations
     */
    public static function getLocations(){
        global $crud;

        $sql = "SELECT * FROM Location WHERE IsArchived = 0";
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
        }// else
    }// function
  
    
    /**
     * Add a new Location in Database
     * @param $args Parameters of a Location
     * @return a Message containing the new Location
     */
    public static function addLocation($args){
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
            if(isset($args['Direction'])){
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
        }// else   
    }// function
    
    
    /**
     * get Location linked to the event
     * @param type $event
     * @return type message
     */
    public static function getLocationFromEvent($event){
        // object crud
        global $crud; 
        
        
        // if args isn't null
        if($event != null) {
            $sql = "SELECT * FROM Location INNER JOIN Event ON Location.Name = Event.LocationName WHERE Event.LocationName = '".addslashes($event->getLocationName())."'";
        
            $data = $crud->getRow($sql);
            
            if( $data ) { // if found, constuct object & send message
                
                $argsLocation = array(
                'name'          => $data['Name'],
                'address'       => $data['Address'],
                'city'          => $data['City'],
                'country'       => $data['Country'],
                'direction'     => $data['Direction'],
                'isArchived'    => $data['IsArchived']
            );
                // object Location
                $location = new Location($argsLocation);
                
                // Sending message
                $argsMessage = array(
                        'messageNumber' => 201,
                        'message'       => 'Existant Location',
                        'status'        => true,
                        'content'       => $location
                );
                $message = new Message($argsMessage);
                
            }// if
            else {
                 $argsMessage = array(
                    'messageNumber' => 505,
                    'message'       => 'No Location found',
                    'status'        => false,
                    'content'       => NULL
                );
                $message = new Message($argsMessage);
            }// else
        }// if
        else { // error message
            $argsMessage = array(
                'messageNumber' => 504,
                'message'       => 'Event is null',
                'status'        => false,
                'content'       => NULL
            );
            $message = new Message($argsMessage);
        }// else
        
        // return message
        return $message;
    }// function
    
    
     /**
     * Set new parameters to a Location
     * @param Location $aLocationToSet
     * @return Message containing the setted Location
     */
    public static function setLocation($aLocationToSet) {
        global $crud;
        $messageValidLocation = self::getLocation($aLocationToSet->getName());
        if ($messageValidLocation->getStatus()) {
            $aValidLocation = $messageValidLocation->getContent();
            $sql = "UPDATE  Location SET  
                Address =     '" . $aLocationToSet->getAddress() . "',
                City =   '" . $aLocationToSet->getCity() . "',
                Country =       '" . $aLocationToSet->getCountry() . "',
                Direction =          '" . $aLocationToSet->getDirection() . "',
                IsArchived =    " . $aLocationToSet->getIsArchived() . "
                WHERE  Location.Name = '" . $aValidLocation->getName() . "'";

            if ($crud->exec($sql) == 1) {

                $aSettedLocation = FSLocation::getLocation($aLocationToSet->getName())->getContent();

                $argsMessage = array(
                    'messageNumber' => 451,
                    'message' => 'Location setted !',
                    'status' => true,
                    'content' => $aSettedLocation
                );
                $message = new Message($argsMessage);
            } else {
                $argsMessage = array(
                    'messageNumber' => 132,
                    'message' => 'Error while setting Location',
                    'status' => false,
                    'content' => NULL
                );
                $message = new Message($argsMessage);
            }
        } else {
            $message = $messageValidLocation;
        }
        return $message;
    }//function
    
 }// class
    
?>
