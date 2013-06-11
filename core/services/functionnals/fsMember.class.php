<?php
/**
 * Description of fsMember
 *
 * @author Nicolas Baudet <nicolas.baudet@heig-vd.ch>
 */
class fsMember {
    
    /**
     * Initializes and returns a Member if the MemberId and MemberPassword in
     * $_POST are correct. Otherwise, returns NULL.
     * @param string $id the username of our member
     * @param string $password the password of our member
     * @return Member ou NULL
     */
    /**
     * 
     * @param type $id
     * @param type $password
     * @return \Member
     */
    protected function getMember ($id, $password) {
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
