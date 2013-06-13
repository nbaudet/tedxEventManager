<?php
/**
 * Description of FSPerson
 *
 * @author Lauric Francelet
 */

require_once(APP_DIR . '/core/model/Person.class.php');
require_once(APP_DIR . '/core/model/Message.class.php');


class FSPerson {
    
    /**
     * Returns a Person with the given No as Id.
     * @param int $no The Id of the Person
     * @return a Message containing an existant Person
     */
    public static function getPerson($no) {
        $person = NULL;
        
        global $crud;
        
        $sql = "SELECT * FROM Person WHERE No = $no";
        $data = $crud->getRow($sql);
        
        if($data){
            $argsPerson = array(
                'no'            => $data['No'],
                'name'          => $data['Name'],
                'firstname'     => $data['Firstname'],
                'dateOfBirth'   => $data['DateOfBirth'],
                'address'       => $data['Address'],
                'city'          => $data['City'],
                'country'       => $data['Country'],
                'phoneNumber'   => $data['PhoneNumber'],
                'email'         => $data['Email'],
                'description'   => $data['Description'],
                'isArchived'    => $data['IsArchived']
            );
            
            $person = new Person($argsPerson);
            
            $argsMessage = array(
                'messageNumber' => 101,
                'message'       => 'Existant Person',
                'status'        => true,
                'content'       => $person
            );
            $message = new Message($argsMessage);
            return $message;
        } else {
            $argsMessage = array(
                'messageNumber' => 102,
                'message'       => 'Inexistant Person',
                'status'        => false,
                'content'       => NULL
            );
            $message = new Message($argsMessage);
            return $message;
        }
    }
    
    /**
     * Returns all the Persons of the database
     * @return A Message containing an array of Persons
     */
    public static function getPersons(){
        global $crud;
        
        $sql = "SELECT * FROM Person";
        $data = $crud->getRows($sql);
        
        if ($data){
            $persons = array();

            foreach($data as $row){
                $argsPerson = array(
                    'no'            => $row['No'],
                    'name'          => $row['Name'],
                    'firstname'     => $row['Firstname'],
                    'dateOfBirth'   => $row['DateOfBirth'],
                    'address'       => $row['Address'],
                    'city'          => $row['City'],
                    'country'       => $row['Country'],
                    'phoneNumber'   => $row['PhoneNumber'],
                    'email'         => $row['Email'],
                    'description'   => $row['Description'],
                    'isArchived'    => $row['IsArchived']
                );
            
                $persons[] = new Person($argsPerson);
            } //foreach

            $argsMessage = array(
                'messageNumber' => 103,
                'message'       => 'All Persons selected',
                'status'        => true,
                'content'       => $persons
            );
            $message = new Message($argsMessage);

            return $message;
        } else {
            $argsMessage = array(
                'messageNumber' => 104,
                'message'       => 'Error while SELECT * FROM person',
                'status'        => false,
                'content'       => NULL
            );
            $message = new Message($argsMessage);

            return $message;
        }
    }
    
    /**
     * Add a new Person in Database
     * @param $args Parameters of a Person
     * @return a Message containing the new Person
     */
    public static function addPerson($args){
        global $crud;
        
        if(!isset($args['description']) || $args['description'] == ''){
            $description = NULL;
        }else{
            $description = $args['description'];
        }
        $sql = "INSERT INTO `Person` (`Name`, `Firstname`, `DateOfBirth`, `Address`, `City`, `Country`, `PhoneNumber`, `Email`, `Description`) VALUES ('".$args['name']."', '".$args['firstname']."', '".$args['dateOfBirth']."', '".$args['address']."', '".$args['city']."', '".$args['country']."', '".$args['phoneNumber']."', '".$args['email']."', '".$description."')";
        
        var_dump($sql);
        if($crud->exec($sql) == 1){
            
            $sql = "SELECT * FROM Person WHERE Email = '" . $args['email'] . "'";
            $data = $crud->exec($sql);
            
            $argsPerson = array(
                'no'            => $data['No'],
                'name'          => $data['Name'],
                'firstname'     => $data['Firstname'],
                'dateOfBirth'   => $data['DateOfBirth'],
                'address'       => $data['Address'],
                'city'          => $data['City'],
                'country'       => $data['Country'],
                'phoneNumber'   => $data['PhoneNumber'],
                'email'         => $data['Email'],
                'description'   => $data['Description'],
                'isArchived'    => $data['IsArchived']
            );
            
            $person = new Person($argsPerson);
            
            $argsMessage = array(
                'messageNumber' => 105,
                'message'       => 'New Person added !',
                'status'        => true,
                'content'       => $person
            );
            $message = new Message($argsMessage);
            return $message;
        } else {
            $argsMessage = array(
                'messageNumber' => 106,
                'message'       => 'Error while inserting new Person',
                'status'        => false,
                'content'       => NULL
            );
            $message = new Message($argsMessage);

            return $message;
        }
        
    }
    
}

?>
