<?php



/**
 * Message.class.php
 * 
 * Author : Guillaume Lehmann
 * Date : 11.06.2013
 * 
 * Description : define the class Message as definited in the model
 * 
 */
class Message {
    
    /*
     * Result Criteria
     * 
     */
    private $messageNumber;

    /*
     * 
     */
    private $message;
    
    /*
     * The status of the message : a boolean 
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
    
    public function getMessageNumber(){
        return $this->messageNumber;
    }
    
    public function getMessage(){
        return $this->message;
    }
    
    public function getStatus(){
        return $this->status;
    }
}
?>
