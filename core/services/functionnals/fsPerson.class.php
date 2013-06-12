<?php
/**
 * Description of FSPerson
 *
 * @author Lauric Francelet
 */
class FSPerson {
    
    /**
     * Returns a Person with the given No as Id.
     * @param int $no The Id of the Person
     * @return a Message containing an existant Person
     */
    protected function getPerson($no) {
        $person = NULL;
        
        global $crud;
        
        $sql = "SELECT * FROM person WHERE no = $no";
        $data = $crud->getRow($sql);
        
        if($data){
            $argsPerson = array(
                'no'            => $data['no'],
                'name'          => $data['name'],
                'firstname'     => $data['firstname'],
                'dateOfBirth'   => $data['dateOfBirth'],
                'address'       => $data['address'],
                'city'          => $data['city'],
                'country'       => $data['country'],
                'phoneNumber'   => $data['phoneNumber'],
                'email'         => $data['email'],
                'description'   => $data['description'],
                'isArchived'    => $data['isArchived']
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
    public function getPersons(){
        global $crud;
        
        $sql = "SELECT * FROM person";
        $data = $crud->getRows($sql);
        
        if ($data){
            $persons = array();

            
            foreach($data as $row){
                $argsPerson = array(
                    'no'            => $row['no'],
                    'name'          => $row['name'],
                    'firstname'     => $row['firstname'],
                    'dateOfBirth'   => $row['dateOfBirth'],
                    'address'       => $row['address'],
                    'city'          => $row['city'],
                    'country'       => $row['country'],
                    'phoneNumber'   => $row['phoneNumber'],
                    'email'         => $row['email'],
                    'description'   => $row['description'],
                    'isArchived'    => $row['isArchived']
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
    public function addPerson($args){
        global $crud;
        
        $sql = "INSERT INTO `tedx`.`person` (
            `No`, `Name`, `Firstname`, `DateOfBirth`, `Address`, `City`, 
            `Country`, `PhoneNumber`, `Email`, `Description`, `IsArchived`) VALUES (
                NULL, 
                '".$args['name']."', 
                '".$args['firstname']."', 
                '".$args['dateOfBirth']."', 
                '".$args['address']."', 
                '".$args['city']."',
                '".$args['country']."',
                '".$args['phoneNumber']."', 
                '".$args['email']."',
                '".$args['description']."',
                '".$args['isArchived']."'
        );";
        
        if($crud->exec($sql)){
            
            
            $argsMessage = array(
                'messageNumber' => 105,
                'message'       => 'New Person added !',
                'status'        => true,
                'content'       => 1
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
