<?php

require_once(APP_DIR . '/core/model/Member.class.php');
require_once(APP_DIR . '/core/model/Person.class.php');
require_once(APP_DIR . '/core/model/Message.class.php');
require_once(APP_DIR . '/core/services/functionnals/FSPerson.class.php');

/**
 * Description of FSMember
 *
 * @author Nicolas Baudet <nicolas.baudet@heig-vd.ch>
 */
class FSMember {

    /**
     * Initializes and returns a Message with the Member if the received id and
     * password are correct. Otherwise, returns NULL.
     * @param string $id the username of our member
     * @param string $password the password of our member
     * @return a Member Object or NULL
     */
    public static function getMember($id) {
        $member = NULL;

        // get database manipulator
        global $crud;

        $sql = "SELECT * FROM Member WHERE Member.ID = '" . $id . "'";
        $data = $crud->getRow($sql);
        // If $data, return content
        if ($data) {
            // Send Message Valid Member
            $argsMember = array(
                'id' => $data['ID'],
                'password' => $data['Password'],
                'personNo' => $data['PersonNo'],
                'isArchived' => $data['IsArchived']
            );
            $aValidMember = new Member($argsMember);
            $argsMessage = array(
                'messageNumber' => 409,
                'message' => 'The Member is valid',
                'status' => true,
                'content' => $aValidMember
            );
        } else {
            // Send Message Inexistant Member
            $argsMessage = array(
                'messageNumber' => 408,
                'message' => 'The Member is inexistant',
                'status' => false,
                'content' => NULL
            );
        }
        // Return message
        $message = new Message($argsMessage);
        return $message;
    }

    /**
     * Functionnal Service addMember
     * @param type $argsMember the properties of a Member
     * @return type $message anAddedMember
     */
    public static function addMember($argsMember) {
        // get database manipulator
        global $crud;

        /**
         * Valider Person
         */
        $noPerson = $argsMember['person']->getNo();
        $aValidPerson = FSPerson::getPerson($noPerson);
        if ($aValidPerson->getStatus() == TRUE) {
            /**
             * Valid Inexistence of Member
             */
            $anInvalidMember = self::getMember($argsMember['id']);
            if ($anInvalidMember->getStatus() == FALSE) {
                $aPersonToCheck = $aValidPerson->getContent();
                $aFreePerson = self::checkFreePerson($aPersonToCheck);
                /**
                 * Check CI Free person
                 */
                if ($aFreePerson->getStatus() == TRUE) {
                    /**
                     * Create Member
                     */
                    $aCreatedMember = self::createMember($argsMember['id'], $argsMember['password'], $aFreePerson->getContent());
                    if ($aCreatedMember->getStatus()) {
                        /**
                         * Message Member created
                         */
                        $argsMessage = array(
                            'messageNumber' => 406,
                            'message' => 'The Member is created',
                            'status' => true,
                            'content' => $aCreatedMember->getContent()
                        );
                        $message = new Message($argsMessage);
                    } else {
                        /**
                         * Message Member no-created.
                         */
                        $message = $aCreatedMember;
                    }
                } else {
                    /**
                     * Message Person used.
                     */
                    $message = $aFreePerson;
                }
            } else {
                /**
                 * Message Member valid.
                 */
                $message = $anInvalidMember;
            }
        } else {
            /**
             * Message Person inexistant.
             */
            $message = $aValidPerson;
        }
        return $message;
    }

    /**
     * Check if the Person had already a Member associate
     * @global type $crud
     * @param type $aPerson
     * @return \Message
     */
    private static function checkFreePerson($aPerson) {
        // get database manipulator
        global $crud;

        // Get the Person with his member
        $aPersonNo = $aPerson->getNo();
        $sql = "SELECT * FROM Person INNER JOIN Member ON Person.No = Member.PersonNo WHERE Person.No = $aPersonNo";
        $data = $crud->getRow($sql);

        // Create the message       
        if ($data) {
            $argsMessage = array(
                'messageNumber' => 405,
                'message' => 'The Person is occuped',
                'status' => false,
                'content' => NULL
            );
        } else {
            $argsMessage = array(
                'messageNumber' => 404,
                'message' => 'The Person is free',
                'status' => true,
                'content' => $aPerson
            );
        }

        // Return the message
        $message = new Message($argsMessage);
        return $message;
    }

    /**
     * Create a Persistant Member
     * @global type $crud
     * @param type $id
     * @param type $pass
     * @param type $person
     * @return \Message
     */
    private static function createMember($id, $pass, $person) {
        // get database manipulator
        global $crud;

        // Insert the Member with password in MD5
        $pass = md5($pass);
        $sql = "INSERT INTO Member (ID, Password, PersonNo) VALUES ('" . $id . "', '" . $pass . "', " . $person->getNo() . ")";
        $data = $crud->exec($sql);

        // Get the Member just added
        $aCreatedMember = self::getMember($id);

        // Create the message
        if ($aCreatedMember->getStatus()) {
            $argsMessage = array(
                'messageNumber' => 403,
                'message' => 'The Member is created',
                'status' => true,
                'content' => $aCreatedMember->getContent()
            );
        } else {
            $argsMessage = array(
                'messageNumber' => 407,
                'message' => 'The Member is not created',
                'status' => false,
                'content' => $aCreatedMember->getContent()
            );
        }

        // Return the message
        $message = new Message($argsMessage);
        return $message;
    }

    /**
     * Search in the existing members for their ID, and returns the members that
     * have an ID similar to the needle.
     * @global PDO Object $crud
     * @param string $needle The string to look for
     * @return Message "Members found", "No members found" or "Missing search argument"
     */
    public static function searchMemberByID($needle = NULL) {
        // get database manipulator
        global $crud;

        // We search for the given needle in the database
        if (isset($needle) && $needle != '') {
            $sql = "SELECT * FROM Member
                WHERE Member.ID LIKE '%" . $needle . "%'
                ORDER BY Member.ID";
            $data = $crud->getRows($sql);
            // If $data, sets message
            if ($data) {
                $arrayOfMembers = array();
                foreach ($data as $member) {
                    $argsMember = array(
                        'id' => $member['ID'],
                        'password' => 'nope', // Password not necessary for a search result
                        'personNo' => $member['PersonNo'],
                        'isArchived' => $member['IsArchived']
                    );
                    $aFoundMember = new Member($argsMember);
                    $arrayOfMembers[] = $aFoundMember;
                }//foreach
                $argsMessage = array(
                    'messageNumber' => 015,
                    'message' => 'Members found',
                    'status' => true,
                    'content' => $arrayOfMembers
                );
            }//if
            // Else : No member found with this needle
            else {
                // Sets Message No member found
                $argsMessage = array(
                    'messageNumber' => 016,
                    'message' => 'No member found',
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



    /**
     * Set new parameters to a Member
     * @param Member $aMemberToSet
     * @return Message containing the setted Member
     */
    public static function setMember($aMemberToSet) {
        global $crud;

        $aValidMember = self::getMember($aMemberToSet->getId());

        if (isset($aValidMember)) {
            $sql = "UPDATE  Member SET  
                Password =          '" . $aMemberToSet->getPassword() . "',
                PersonNo =     '" . $aMemberToSet->getPersonNo() . "',
                IsArchived =   '" . $aMemberToSet->getIsArchived() . "'
                    WHERE  Member.ID = " . $aValidMember;
        } else {
            $argsMessage = array(
                'messageNumber' => 408,
                'message' => 'An Inexistant Member',
                'status' => false,
                'content' => NULL
            );
            $message = new Message($argsMessage);
        }

        if ($crud->exec($sql) == 1) {

            $sql = "SELECT * FROM Member WHERE ID = " . $aValidMember;
            $data = $crud->getRow($sql);

            $argsMember = array(
                'id' => $data['id'],
                'password' => $data['password'],
                'personNo' => $data['personNo'],
                'isArchived' => $data['IsArchived']
            );

            $aSettedMember = new Member($argsMember);

            $argsMessage = array(
                'messageNumber' => 223,
                'message' => 'Member setted !',
                'status' => true,
                'content' => $aSettedMember
            );
            $message = new Message($argsMessage);
            return $message;
        } else {
            $argsMessage = array(
                'messageNumber' => 224,
                'message' => 'Error while setting new Member',
                'status' => false,
                'content' => NULL
            );
            $message = new Message($argsMessage);
        }
        return $message;
    }// END setMember
}

?>
