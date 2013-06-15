<?php
/**
 * Description of FSPerson
 *
 * @author Lauric Francelet
 */

require_once(APP_DIR . '/core/model/Membership.class.php');
require_once(APP_DIR . '/core/model/Member.class.php');

class FSMembership {
    
    /**
     * Returns a Membership with the given memberID and unitNo as Id.
     * @param String $memberID The Id of a Member
     * @param int $unitNo The Id of a Unit
     * @return a Message containing an existant Membership
     */
    public static function getMembership($args) {
        $membership = NULL;
        $member = $args['member'];
        $unit = $args['unit'];
        
        global $crud;
        
        $sql = "SELECT * FROM Membership WHERE MemberID = '".$member->getId()."' AND UnitNo = ".$unit->getNo();
        
        $data = $crud->getRow($sql);
        
        if($data){
            $argsMembership = array(
                'memberId'      => $data['MemberID'],
                'unitNo'        => $data['UnitNo'],
                'isArchived'    => $data['IsArchived'],
            );
            
            $membership = new Membership($argsMembership);
            
            $argsMessage = array(
                'messageNumber' => 107,
                'message'       => 'Existant membership',
                'status'        => true,
                'content'       => $membership
            );
            $message = new Message($argsMessage);
            return $message;
        } else {
            $argsMessage = array(
                'messageNumber' => 108,
                'message'       => 'Inexistant Membership',
                'status'        => false,
                'content'       => NULL
            );
            $message = new Message($argsMessage);
            return $message;
        }// else
    }// function
    
    /**
     * Returns all the Memberships of the database
     * @return A Message containing an array of Memberships
     */
    public static function getMemberships(){
        global $crud;
        
        $sql = "SELECT * FROM Membership";
        $data = $crud->getRows($sql);
        
        if ($data){
            $memberships = array();

            foreach($data as $row){
                $argsMembership = array(
                    'memberId'      => $row['MemberID'],
                    'unitNo'        => $row['UnitNo'],
                    'isArchived'    => $row['IsArchived'],
                );
            
                $memberships[] = new MemberShip($argsMembership);
            } //foreach

            $argsMessage = array(
                'messageNumber' => 109,
                'message'       => 'All Memberships selected',
                'status'        => true,
                'content'       => $memberships
            );
            $message = new Message($argsMessage);

            return $message;
        } else {
            $argsMessage = array(
                'messageNumber' => 110,
                'message'       => 'Error while SELECT * FROM membership',
                'status'        => false,
                'content'       => NULL
            );
            $message = new Message($argsMessage);

            return $message;
        }// else
    }// function
    
    /**
     * Add a new Membership in Database
     * @param $args Parameters of a Membership
     * @return a Message containing the new Membership
     */
    public static function addMembership($args){
        global $crud;
        $return = null;
        $member = $args['member'];
        $unit = $args['unit'];

        // Validate Member
        $aValidMember = FSMember::getMember($member->getId());
        
        if($aValidMember->getStatus()){
            
            // Validate Unit
            $aValidUnit = FSUnit::getUnit($unit->getNo());
            
            if ($aValidUnit->getStatus()){
                
                // Validate Membership
                $anInexistantMembership = FSMembership::getMembership($args);
                
                if(!$anInexistantMembership->getStatus()){
                    
                    // Create new Membership
                    $sql = "INSERT INTO `Membership` (`MemberID` ,`UnitNo`) VALUES (
                        '".$member->getId()."', 
                        '".$unit->getNo()."'
                    );";
                    
                    if($crud->exec($sql) != 0){
                        
                        // Get created Membership
                        $aCreatedMembership = FSMembership::getMembership($args);

                        $argsMessage = array(
                            'messageNumber' => 111,
                            'message'       => 'New Membership added !',
                            'status'        => true,
                            'content'       => $aCreatedMembership
                        );
                        $return = new Message($argsMessage);
                        
                        
                    } else {
                        $argsMessage = array(
                            'messageNumber' => 112,
                            'message'       => 'Error while inserting new Membership',
                            'status'        => false,
                            'content'       => NULL
                        );
                        $return = new Message($argsMessage);
                    }// else
                    
                } // End Create new Membership
                else {
                    $argsMessage = array(
                        'messageNumber' => 114,
                        'message'       => 'Membership already existant !',
                        'status'        => FALSE,
                        'content'       => null
                    );

                $return = new Message($argsMessage);
                }// else
                
            } else {
                $argsMessage = array(
                    'messageNumber' => 114,
                    'message'       => 'No matching Unit found',
                    'status'        => FALSE,
                    'content'       => null
                );
            
            $return = new Message($argsMessage);
            }// else
            
        } else {
            $argsMessage = array(
                'messageNumber' => 113,
                'message'       => 'No matching Member found',
                'status'        => FALSE,
                'content'       => null
            );
            
            $return = new Message($argsMessage);
            
        }// end
        
        return $return;
        
    }// End addMembership
    
    
}// class

?>
