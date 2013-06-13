<?php
require_once(APP_DIR.'/core/model/Membership.class.php');
require_once(APP_DIR.'/core/model/Person.class.php');
require_once(APP_DIR.'/core/model/Member.class.php');
require_once(APP_DIR.'/core/model/Message.class.php');
require_once(APP_DIR.'/core/model/Unit.class.php');
require_once(APP_DIR.'/core/services/functionnals/FSMember.class.php');
require_once(APP_DIR.'/core/services/functionnals/FSMembership.class.php');
require_once(APP_DIR.'/core/services/functionnals/FSPerson.class.php');

/**
 * Description of ASFree
 *
 * @author rapou
 */
class ASFree {
    
    public function __construct() {
       
    }
    /**
     * Method registerVisitor from SA Free
     * @param type $args 
     * @return type 
     */
    public function registerVisitor($args){
        $argsPerson = array(
            'name'         => $args['name'],
            'firstname'    => $args['firstname'],
            'dateOfBirth'  => $args['dateOfBirth'],
            'address'      => $args['address'],
            'city'         => $args['city'],
            'country'      => $args['country'],
            'phoneNumber'  => $args['phoneNumber'],
            'email'        => $args['email']
        );
        $anAddedPerson = FSPerson::addPerson($argsPerson);
        if($anAddedPerson->getStatus()){
            $argsMember = array(
                'id'         => $args['id'],
                'password'   => $args['password'],
                'person'     =>  $anAddedPerson->getContent()
            );
            $anAddedMember = FSMember::addMember($argsMember);
            if($anAddedMember->getStatus()){
                $argsMembership = array(
                    'person'  => $anAddedMember,
                    // 'unit'    => FSUnit::getUnit('Visitor');
                );
                $anAddedMembership = FSMembership::addMembership($argsMembership);
                if($anAddedMembership->getStatus()){
                    $argsMessage = array(
                        'messageNumber' => 401,
                        'message'       => 'Visitor registered',
                        'status'        => true,
                        'content'       => $array($anAddedPerson, $anAddedMember, $anAddedMembership)
                    );
                    $aRegisteredVisitor = new Message($argsMessage);
                }else{
                    $aRegisteredVisitor = $anAddedMembership;
                }
            }else{
                $aRegisteredVisitor = $anAddedMember;
            }
        }else{
            $aRegisteredVisitor = $anAddedPerson;
        }
        return $aRegisteredVisitor;
    }
}

?>
