<?php
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
            'messageNumber' => 405,
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
        
        $aValidMember = $this->getMember($argsMember['id']);
        
        $aFreePerson = $this->checkFreePerson($aValidPerson->getContent());
        
        $aCreatedMember = $this->createMember($aValidMember->getContent(), $aFreePerson->getContent());
        
        $argsMessage = array(
            'messageNumber' => 404,
            'message'       => 'a create Member',
            'status'        => true,
            'content'       => $aCreatedMember
        );
        $messageOK = new Message( $argsMessage );
        return $messageOK;
    }
    
    private function checkFreePerson($aPerson){
        
        
        $argsMessage = array(
            'messageNumber' => 403,
            'message'       => 'The Person is free',
            'status'        => true,
            'content'       => $aPerson
        );
        
        $messageOK = new Message( $argsMessage );
        return $messageOK;
    }
    
    private function createMember($aValidMember){
        
        
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
