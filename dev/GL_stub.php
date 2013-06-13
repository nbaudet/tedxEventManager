<?php

require_once '../core/controller/Tedx_manager.class.php';


class GL_stub {
    
    
    
    private $test; 
    
    public function __construct() {
        
        $this->test = new Tedx_manager(); 
        
      $this->test(); 
    }
    
    
  public function test() {
      
      
          $args = array(
            'messageNumber' => 001,
            'message'       => 'aRegisteredVisitor',
            'status'        => true
        
        );
      
      $this->test->addTeamRole($args); 
      
      
      
  }
    
    
}

?>
