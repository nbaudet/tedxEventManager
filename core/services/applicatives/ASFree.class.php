<?php
require_once(APP_DIR.'/core/model/Membership.class.php');
require_once(APP_DIR.'/core/model/Person.class.php');
require_once(APP_DIR.'/core/model/Member.class.php');
require_once(APP_DIR.'/core/model/Message.class.php');
require_once(APP_DIR.'/core/model/Unit.class.php');
require_once(APP_DIR.'/core/services/functionnals/FSUnit.class.php');
require_once(APP_DIR.'/core/services/functionnals/FSMember.class.php');
require_once(APP_DIR.'/core/services/functionnals/FSMembership.class.php');
require_once(APP_DIR.'/core/services/functionnals/FSPerson.class.php');

/**
 * Description of ASFree
 *
 * @author rapou
 */
class ASFree {
    
    /**
     * The constructor that does nothing
     */
    public function __construct() {
        // Nothing
    }
    
    /**
     * Method registerVisitor from SA Free
     * @param type $args 
     * @return type 
     */
    public function registerVisitor($args){
        /**
         * Arguments for adding a Person
         */
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
        
        /**
         * Add a Person
         */
        $anAddedPerson = FSPerson::addPerson($argsPerson);
        
        /**
         * If the Person is added, continue. 
         */
        if($anAddedPerson->getStatus()){
            /**
             * Arguments for adding a Member
             */
            $argsMember = array(
                'id'         => $args['idmember'],
                'password'   => $args['password'],
                'person'     => $anAddedPerson->getContent()
            );
            /**
             * Add a Member
             */
            $anAddedMember = FSMember::addMember($argsMember);
            
            /**
             * If the Member is added, continue.
             */
            if($anAddedMember->getStatus()){
                /**
                 * Get the Unit with the name 'Visitor' 
                 */
                $aUnit = FSUnit::getUnitByName('Visitors'); // A editer quand Unit a le bon nom de Visitor
                /**
                 * Arguments for adding a Membership
                 */
                $argsMembership = array(
                    'member'  => $anAddedMember,
                    'unit' => $aUnit
                );
                /**
                 * Add a Membership
                 */
                $anAddedMembership = FSMembership::addMembership($argsMembership);
                /**
                 * If the Membership is added, generate the message OK
                 */
                if($anAddedMembership->getStatus()){
                    $argsMessage = array(
                        'messageNumber' => 402,
                        'message'       => 'Visitor registered',
                        'status'        => true,
                        'content'       => array($anAddedPerson, $anAddedMember, $anAddedMembership)
                    );
                    $aRegisteredVisitor = new Message($argsMessage);
                }else{
                    /**
                     * Else give the error message about non-adding Membership
                     */
                    $aRegisteredVisitor = $anAddedMembership;
                }
            }else{
                /**
                 * Else give the error message about non-adding Member
                 */
                $aRegisteredVisitor = $anAddedMember;
            }
        }else{
            /**
             * Else give the error message about non-adding Person
             */
            $aRegisteredVisitor = $anAddedPerson;
        }
        /**
         * Return the message Visitor Registed or not Registred
         */
        return $aRegisteredVisitor;
    }
}

?>
