<?php
/**
 * Message.class.php
 * 
 * Author : Guillaume Lehmann
 * Date : 11.06.2013
 * 
 * Description : a message is an object that contains information and transits
 * between the layers of the application.
 * The messages take a part in some of the controls of the application.
 * 
 */
class Message {
    
    /*
     * The message ID, possibly unique
     * Check the CODx to verify which number to set
     * 
     */
    private $messageNumber;

    /*
     * The String value of the message
     */
    private $message;
    
    /*
     * Status of the message : a boolean indicating if everything is OK or if
     * there was an error.
     */
    private $status;

     /**
     * Constructs object Message
     * 
     * @param type $array of parameters that correspond to the class's properties
     */
    protected function __construct($args = NULL) {
        if(!is_array($array))
            throw new Exception('No parameters');
            
        $this->messageNumber = $args['messageNumber'];
        $this->message       = $args['message'];
        $this->status        = $args['status']; 
    }
    
    /**
     * Returns the message number
     * @return Message
     */
    public function getMessageNumber(){
        return $this->messageNumber;
    }
    
    /**
     * Returns the value of the message
     * @return String
     */
    public function getMessage(){
        return $this->message;
    }
    
    /**
     * Returns the boolean status of the message.
     * TRUE : Everything went OK
     * FALSE : There was an error
     * @return Boolean
     */
    public function getStatus(){
        return $this->status;
    }
}
?>
