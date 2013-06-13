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
        
        $argsMember = array(
            'id'         => $data['ID'],
            'password'   => $data['Password'],
            'personNo'   => $data['PersonNo'],
            'isArchived' => $data['IsArchived']
        );
        
        $aValidMember = new Member($argsMember);
        
        $argsMessage = array(
            'messageNumber' => 407,
            'message'       => 'The Member is existing',
            'status'        => true,
            'content'       => $aValidMember
        );
 
        $messageOK = new Message( $argsMessage );
        return $messageOK;
    }
    
    protected function addMember($argsMember) {
        // get database manipulator
        global $crud;
        
        
        $argsMember = array(
            'id'         => '',
            'password'   => '',
            'person'   => '',
            'isArchived' => ''
        );
        
        $noPerson = $argsMember['person']->getNo();
        $aValidPerson = FSPerson::getPerson($noPerson);
        
        $anInvalidMember = self::getMember($argsMember['id']);
        
        $aPersonToCheck = $aValidPerson->getContent();
        $aFreePerson = self::checkFreePerson($aPersonToCheck);
        
        $aCreatedMember = $this->createMember($aFreePerson->getContent());
        
        $argsMessage = array(
            'messageNumber' => 406,
            'message'       => 'a create Member',
            'status'        => true,
            'content'       => $aCreatedMember
        );
        $messageOK = new Message( $argsMessage );
        return $messageOK;
    }
    
    public static function checkFreePerson($aPerson){
        global $crud;
        
        $aPersonNo = $aPerson->getNo();
        $sql = "SELECT * FROM Person INNER JOIN Member ON Person.No = Member.PersonNo WHERE Person.No = $aPersonNo";
        
        $data = $crud->getRow($sql);
        if(isset($data)){
            $argsMessage = array(
                'messageNumber' => 405,
                'message'       => 'The Person is occuped',
                'status'        => false,
                'content'       => NULL
            );
        }else{
            $argsMessage = array(
                'messageNumber' => 404,
                'message'       => 'The Person is free',
                'status'        => true,
                'content'       => $aPerson
            );
        }
        $message = new Message( $argsMessage );
        return $message;
    }
    
    private function createMember($aValidMember){
        
        $sql = "INSERT INTO Member FROM Person INNER JOIN Member ON Person.No = Member.PersonNo WHERE Person.No = $aPersonNo";
        $data = $crud->getRow($sql);
        
        $argsMessage = array(
            'messageNumber' => 403,
            'message'       => 'The Person is free',
            'status'        => true,
            'content'       => $aValidMember
        );
        
        $messageOK = new Message( $argsMessage );
        return $messageOK;
    }
    
    
}
?>
