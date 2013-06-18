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

        $sql = "SELECT * FROM Person WHERE No = $no AND IsArchived = 0";
        $data = $crud->getRow($sql);

        if ($data) {
            $argsPerson = array(
                'no' => $data['No'],
                'name' => $data['Name'],
                'firstname' => $data['Firstname'],
                'dateOfBirth' => $data['DateOfBirth'],
                'address' => $data['Address'],
                'city' => $data['City'],
                'country' => $data['Country'],
                'phoneNumber' => $data['PhoneNumber'],
                'email' => $data['Email'],
                'description' => $data['Description'],
                'isArchived' => $data['IsArchived']
            );

            $person = new Person($argsPerson);

            $argsMessage = array(
                'messageNumber' => 101,
                'message' => 'Existant Person',
                'status' => true,
                'content' => $person
            );
            $message = new Message($argsMessage);
            return $message;
        } else {
            $argsMessage = array(
                'messageNumber' => 102,
                'message' => 'Inexistant Person',
                'status' => false,
                'content' => NULL
            );
            $message = new Message($argsMessage);
            return $message;
        }
    }

    /**
     * Returns a Person with the given Email as Email.
     * @param int $email The Email of the Person
     * @return a Message containing an existant Person
     */
    public static function getPersonByEmail($email) {
        $person = NULL;

        global $crud;

        $sql = "SELECT * FROM Person WHERE Email = '" . $email . "' AND IsArchived = 0";
        $data = $crud->getRow($sql);

        if ($data) {
            $argsPerson = array(
                'no' => $data['No'],
                'name' => $data['Name'],
                'firstname' => $data['Firstname'],
                'dateOfBirth' => $data['DateOfBirth'],
                'address' => $data['Address'],
                'city' => $data['City'],
                'country' => $data['Country'],
                'phoneNumber' => $data['PhoneNumber'],
                'email' => $data['Email'],
                'description' => $data['Description'],
                'isArchived' => $data['IsArchived']
            );

            $person = new Person($argsPerson);

            $argsMessage = array(
                'messageNumber' => 101,
                'message' => 'Existant Person',
                'status' => true,
                'content' => $person
            );
        } else {
            $argsMessage = array(
                'messageNumber' => 102,
                'message' => 'Inexistant Person',
                'status' => false,
                'content' => NULL
            );
        }
        $message = new Message($argsMessage);
        return $message;
    }

    /**
     * Returns all the Persons of the database
     * @return A Message containing an array of Persons
     */
    public static function getPersons() {
        global $crud;

        $sql = "SELECT * FROM Person WHERE IsArchived = 0";
        $data = $crud->getRows($sql);

        if ($data) {
            $persons = array();

            foreach ($data as $row) {
                $argsPerson = array(
                    'no' => $row['No'],
                    'name' => $row['Name'],
                    'firstname' => $row['Firstname'],
                    'dateOfBirth' => $row['DateOfBirth'],
                    'address' => $row['Address'],
                    'city' => $row['City'],
                    'country' => $row['Country'],
                    'phoneNumber' => $row['PhoneNumber'],
                    'email' => $row['Email'],
                    'description' => $row['Description'],
                    'isArchived' => $row['IsArchived']
                );

                $persons[] = new Person($argsPerson);
            } //foreach

            $argsMessage = array(
                'messageNumber' => 103,
                'message' => 'All Persons selected',
                'status' => true,
                'content' => $persons
            );
            $message = new Message($argsMessage);

            return $message;
        } else {
            $argsMessage = array(
                'messageNumber' => 104,
                'message' => 'Error while SELECT * FROM person',
                'status' => false,
                'content' => NULL
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
    public static function addPerson($args) {
        global $crud;

        if (!isset($args['description']) || $args['description'] == '') {
            $description = NULL;
        } else {
            $description = addslashes($args['description']);
        }
        $sql = "INSERT INTO `Person` (`Name`, `Firstname`, `DateOfBirth`, `Address`, `City`, `Country`, `PhoneNumber`, `Email`, `Description`) VALUES ('" . addslashes($args['name']) . "', '" . addslashes($args['firstname']) . "', '" . addslashes($args['dateOfBirth']) . "', '" . addslashes($args['address']) . "', '" . addslashes($args['city']) . "', '" . addslashes($args['country']) . "', '" . addslashes($args['phoneNumber']) . "', '" . addslashes($args['email']) . "', '" . $description . "')";

        $messageFreeEmail = self::checkFreeEmail($args['email']);
        if ($messageFreeEmail->getStatus()) {
            $aFreeEmail = $messageFreeEmail->getContent();
            if ($crud->exec($sql) == 1) {

                $sql = "SELECT * FROM Person WHERE Email = '" . $aFreeEmail . "'";
                $data = $crud->getRow($sql);

                $argsPerson = array(
                    'no' => $data['No'],
                    'name' => $data['Name'],
                    'firstname' => $data['Firstname'],
                    'dateOfBirth' => $data['DateOfBirth'],
                    'address' => $data['Address'],
                    'city' => $data['City'],
                    'country' => $data['Country'],
                    'phoneNumber' => $data['PhoneNumber'],
                    'email' => $aFreeEmail,
                    'description' => $data['Description'],
                    'isArchived' => $data['IsArchived']
                );

                $person = new Person($argsPerson);

                $argsMessage = array(
                    'messageNumber' => 105,
                    'message' => 'New Person added !',
                    'status' => true,
                    'content' => $person
                );
                $message = new Message($argsMessage);
                return $message;
            } else {
                $argsMessage = array(
                    'messageNumber' => 106,
                    'message' => 'Error while inserting new Person',
                    'status' => false,
                    'content' => NULL
                );
                $message = new Message($argsMessage);
            }
        } else {
            $message = $messageFreeEmail;
        }
        return $message;
    }

// END addPerson

    /**
     * Set new parameters to a Person
     * @param Person $aPersonToSet
     * @return Message containing the setted Person
     */
    public static function setPerson($aPersonToSet) {
        global $crud;
        $messageFreeEmail = self::checkFreeEmail($aPersonToSet->getEmail(), $aPersonToSet->getNo());
        if ($messageFreeEmail->getStatus()) {
            $aFreeEmail = $messageFreeEmail->getContent();
            $sql = "UPDATE  Person SET  
                Name =          '" . $aPersonToSet->getName() . "',
                Firstname =     '" . $aPersonToSet->getFirstname() . "',
                DateOfBirth =   '" . $aPersonToSet->getDateOfBirth() . "',
                Address =       '" . $aPersonToSet->getAddress() . "',
                City =          '" . $aPersonToSet->getCity() . "',
                Country =       '" . $aPersonToSet->getCountry() . "',
                PhoneNumber =   '" . $aPersonToSet->getPhoneNumber() . "',
                Email =         '" . $aFreeEmail . "',
                Description =   '" . $aPersonToSet->getDescription() . "',
                IsArchived =    '" . $aPersonToSet->getIsArchived() . "'
                WHERE  Person.No = " . $aPersonToSet->getNo();

            if ($crud->exec($sql) == 1) {
                $sql = "SELECT * FROM Person WHERE No = " . $aPersonToSet->getNo();
                $data = $crud->getRow($sql);

                $argsPerson = array(
                    'no' => $data['No'],
                    'name' => $data['Name'],
                    'firstname' => $data['Firstname'],
                    'dateOfBirth' => $data['DateOfBirth'],
                    'address' => $data['Address'],
                    'city' => $data['City'],
                    'country' => $data['Country'],
                    'phoneNumber' => $data['PhoneNumber'],
                    'email' => $data['Email'],
                    'description' => $data['Description'],
                    'isArchived' => $data['IsArchived']
                );

                $aSettedPerson = new Person($argsPerson);

                $argsMessage = array(
                    'messageNumber' => 131,
                    'message' => 'Person setted !',
                    'status' => true,
                    'content' => $aSettedPerson
                );
                $message = new Message($argsMessage);
            } else {
                $argsMessage = array(
                    'messageNumber' => 132,
                    'message' => 'Error while setting new Person',
                    'status' => false,
                    'content' => NULL
                );
                $message = new Message($argsMessage);
            }
        } else {
            $message = $messageFreeEmail;
        }
        return $message;
    }

// END setPerson

    /**
     * Search in the existing persons for their ID, and returns the persons that
     * have an ID similar to the needle.
     * @global PDO Object $crud
     * @param string $needle The string to look for
     * @return Message "Persons found", "No person found" or "Missing search argument"
     */
    public static function searchPersonByName($needle = NULL) {
        // get database manipulator
        global $crud;

        // We search for the given needle in the database
        if (isset($needle) && $needle != '') {
            $sql = "SELECT * FROM Person
                WHERE concat(Name, ' ', Firstname) LIKE '%" . $needle . "%'
                ORDER BY Person.No";
            $data = $crud->getRows($sql);
            // If $data, sets message
            if ($data) {
                $arrayOfPersons = array();
                foreach ($data as $person) {
                    $argsPerson = array(
                        'no' => $person['No'],
                        'name' => $person['Name'],
                        'firstname' => $person['Firstname'],
                        'dateOfBirth' => $person['DateOfBirth'],
                        'address' => $person['Address'],
                        'city' => $person['City'],
                        'country' => $person['Country'],
                        'phoneNumber' => $person['PhoneNumber'],
                        'email' => $person['Email'],
                        'description' => $person['Description'],
                        'isArchived' => $person['IsArchived']
                    );
                    $aFoundPerson = new Person($argsPerson);
                    $arrayOfPersons[] = $aFoundPerson;
                }//foreach
                $argsMessage = array(
                    'messageNumber' => 018,
                    'message' => 'Persons found',
                    'status' => true,
                    'content' => $arrayOfPersons
                );
            }//if
            // Else : No person found with this needle
            else {
                // Sets Message No person found
                $argsMessage = array(
                    'messageNumber' => 019,
                    'message' => 'No person found',
                    'status' => false
                );
            }//else
        }//if
        //Else : There was no needle
        else {
            $argsMessage = array(
                'messageNumber' => 017,
                'message' => 'Missing search argument',
                'status' => false
            );
        }
        // Returns the message
        $message = new Message($argsMessage);
        return $message;
    }

//searchPersonByName

    /**
     * Check if email is already used
     * @param type $email
     * @return $Message the free email
     */
    private static function checkFreeEmail($email, $no) {
        $messagePersonWithEmail = self::getPersonByEmail($email);
        if ($messagePersonWithEmail->getStatus() == false) {
            $argsMessage = array(
                'messageNumber' => 421,
                'message' => 'The email is free',
                'status' => true,
                'content' => $email
            );
        } else {
            $aPersonWithEmail = $messagePersonWithEmail->getContent();
            if (isset($no) and $no == $aPersonWithEmail->getNo()) {
                $argsMessage = array(
                    'messageNumber' => 421,
                    'message' => 'The email is free',
                    'status' => true,
                    'content' => $email
                );
            } else {
                $argsMessage = array(
                    'messageNumber' => 422,
                    'message' => 'The email is occuped',
                    'status' => false,
                    'content' => $aPersonWithEmail
                );
            }
        }
        $message = new Message($argsMessage);
        return $message;
    }
    
    /**
     * Search message with args
     * @param type $args
     * @return type message     
     */
    public static function searchPersons($args){
        // crud
        global $crud;
        
        // return value
        $message ;
        
        // if args are supplied
        if( isset ($args['where']) ) 
            $where  = $args['where'];
        else
            $where = '1=1';
        // optional args
        if(isset($args['orderBy'])) {
            $orderBy  = 'ORDER BY '.$args['orderBy'];
            if( isset( $args['orderByType'] ) )
                $orderBy .= ' '.$args['orderByType'];
        }// if
        else
            $orderBy = '';

        // optional typePerson
        if(isset($args['personType']))
            $personType = $args['personType'];
        else
            $personType = 'all';

        $sql = "SELECT * FROM Person";

        // Check each case for personType
        switch($personType){
            case 'participant': // case participant => join table participant
                $sql .= " INNER JOIN Participant AS TypePerson ON TypePerson.PersonNo = Person.No ";
                break;
            case 'speaker': // case speaker => join table participant
                $sql .= " INNER JOIN Speaker AS TypePerson ON TypePerson.PersonNo = Person.No";

            case 'organizer': // case speaker => join table participant
                $sql .= " INNER JOIN Organizer AS TypePerson ON TypePerson.PersonNo = Person.No";

            case 'all':
            default:
                $sql .= " AS TypePerson";
                break;
        }// switch

        // Ending SQL statement
        $sql .= " WHERE TypePerson.IsArchived = 0 AND $where $orderBy";

        echo '<h3>'.$sql.'</h3>';
        // exec query
        $data = $crud->getRows($sql);

        // if query returned results
        if($data) {

            $persons = array();

            // make object for each row
            foreach($data as $row){
                $argsPerson = array(
                    'no'          => $row['No'],
                    'name'        => $row['Name'],
                    'firstname'   => $row['Firstname'],
                    'dateOfBirth' => $row['DateOfBirth'],
                    'address'     => $row['Address'],
                    'city'        => $row['City'],
                    'country'     => $row['Country'],
                    'phoneNumber' => $row['PhoneNumber'],
                    'email'       => $row['Email'],
                    'description' => $row['Description'],
                    'isArchived'  => $row['IsArchived']
                );

                $persons[] = new Person($argsPerson);
            } //foreach


            $argsMessage = array(
                'messageNumber' => 502,
                'message'       => 'Person Founds',
                'status'        => true,
                'content'       => $persons
            );
            $message = new Message($argsMessage);

        }else {
            $argsMessage = array(
                'messageNumber' => 503,
                'message'       => 'Person not found',
                'status'        => false,
                'content'       => NULL
            );
            $message = new Message($argsMessage);
        }// else
        
        // return message
        return $message;
    }// function

}// class

?>
