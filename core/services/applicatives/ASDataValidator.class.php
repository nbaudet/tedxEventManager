<?php

require_once(APP_DIR . '/core/model/Message.class.php');

/**
 * ASDataValidator.class.php
 * 
 * Author : Lauric Francelet
 * 
 * Description : Class that checks the validity of the Datas. 
 * This class is not yet implemented, so it works as a Stub class. 
 * It will always return a True Message.
 * 
 */
class ASDataValidator {

    /**
     * The constructor that does nothing
     */
    public function __construct() {
        // Nothing
    }//construct
    
    /**
     * Checks the validity of the given $args. If the $args is not null,
     * then returns true, else false.
     * @param array $args
     * @return Message containing the same $args as the input
     */
    public static function checkData($args){
        if ($args != null){
            $argsMessage = array(
                'messageNumber' => 178,
                'message' => 'Valid Data',
                'status' => true,
                'content' => $args
            );
            $return = new Message($argsMessage);
        } else {
            $argsMessage = array(
                'messageNumber' => 179,
                'message' => 'Invalid Data',
                'status' => false,
                'content' => $args
            );
            $return = new Message($argsMessage);
        }
        return $return;
    }
    
    /**
     * Checks the validity of the given $args. If the $args is not null,
     * then returns true, else false.
     * @param array $args
     * @return Message containing the same $args as the input
     */
    public static function checkData($args, $args2){
        if ($args != null && $args2 != null){
            $argsMessage = array(
                'messageNumber' => 178,
                'message' => 'Valid Data',
                'status' => true,
                'content' => array ('$args' => $args, '$args2' => $args2)
            );
            $return = new Message($argsMessage);
        } else {
            $argsMessage = array(
                'messageNumber' => 179,
                'message' => 'Invalid Data',
                'status' => false,
                'content' => $args
            );
            $return = new Message($argsMessage);
        }
        return $return;
    }


}//class

?>
