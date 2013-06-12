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
     * @return a Message with an existant Person
     */
    protected function getPerson($no) {
        $person = NULL;
        
        global $crud;
        
        $sql = "SELECT * FROM person WHERE no = $no";
        $data = $crud->query($sql);
        
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
                'status'        => true,
                'content'       => NULL
            );
            $message = new Message($argsMessage);
            return $message;
        }
    }
    
    
}

?>
