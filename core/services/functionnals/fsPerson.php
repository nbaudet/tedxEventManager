<?php
/**
 * Description of FSMember
 *
 * @author Nicolas Baudet <nicolas.baudet@heig-vd.ch>
 */
class FSMember {
    
    /**
     * Initializes and returns a Member if the received id and password
     * are correct. Otherwise, returns NULL.
     * @param string $id the username of our member
     * @param string $password the password of our member
     * @return a Member Object or NULL
     */
    protected function getMember ($id) {
        $member = NULL;
        
        // Récupère le stub de notre member et crée un member
        $stubMemberId = 'admin';
        $stubMemberPass = 'admin';
        
        $args = array(
            'id'         => $stubMemberId,
            'password'   => $stubMemberPass,
            'personNo'   => 1,
            'isArchived' => 0
        );
        $member = new Member($args);
        
        return $member;
    }
}

?>
