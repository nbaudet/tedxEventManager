<?php


/**
 * Crud.class.php
 * 
 * Author : Quentin Mathey
 * Date : 12.06.2013
 * 
 * Description : define the CRUD object which will interact with the database
 * 
 */
class Crud {
    
    
    /**
     * DB location
     * @var type string 
     */
    private $location; 
    
    /**
     * DB name
     * @var type string 
     */
    private $name; 
    
    
    /**
     * DB user
     * @var type string 
     */
    private $user; 
    
    /**
     * DB password
     * @var type string 
     */
    private $password; 
    
    /**
     * object PDO
     * @var type string 
     */
    private $dbh; 
    
    
    
    /**
     * Constructs object Slot
     * 
     * @param type $array of parameters that correspond to the classes properties
     */
    public function __construct($array = null){
        // if parameters are specified
        if(isset($array)){
            $this->location = $array['location'];
            $this->name     = $array['name'];
            $this->user     = $array['user'];
            $this->password = $array['password'];
        }// if
        else {
            $this->location = DB_LOCATION;
            $this->name     = DB_NAME;
            $this->user     = DB_USER;
            $this->password = DB_PASSWORD;
        }// else
        
        
        // try connecting to the database
        try {
            $this->dbh = new PDO('mysql:host='.$this->location.';dbname='.$this->name, $this->user, $this->password);
   
        } catch (PDOException $e) { 
            print "DATABASE CONNECTION ERROR !: " . $e->getMessage() .'mysql:host='.$this->location.';dbname='.$this->name .' // USER : '.$this->user . ' PASSWORD : ' . $this->password;
            die();
        } // catch
     
    }//construct
     
    /**
     * return a single row
     * @param type $sql
     * @return row
     */
    public function getRow($sql){
        // exec the query
        $rawData = $this->dbh->query($sql);
        $data = array();
        $return = false;
        
        
        
        if($rawData != false && $rawData->rowCount() > 0){
            foreach($rawData as $row) {
                $data[] = $row;
            }// foreach
            
            $return = $data[0];
        }
        
        // return first row
        return $return;
        
    }// function
    
    /**
     * return an array of rows
     * @param type $sql
     * @return array() including rows
     */
    public function getRows($sql){
        // exec the query
        $rawData = $this->dbh->query($sql);
        $data = array();
        
        if($rawData != false && $rawData->rowCount()){
            foreach($rawData as $row) {
                $data[] = $row;
            }// foreach            
        }// if

        // return first row
        return $data;
    }// function
    
    /**
     * Execute SQL statement
     * @param type $sql
     * @return number of lines affected
     */
    public function exec($sql){
        
        /* Exécute une requête préparée en passant un tableau de valeurs */
        $sth = $this->dbh->prepare($sql);
        
        return $sth->execute();
    }// function
    
    /**
     * Can Insert SQL and return last ID from table
     * @param type $sql
     * @return type int otherwise false
     */
    public function insertReturnLastId($sql){
        $return ; 
        // transaction
        $this->dbh->beginTransaction();
            $queryReturn = $this->dbh->query($sql);
            // catch last id
            $return = $this->dbh->lastInsertId();
        $this->dbh->commit();
        
        // If query failed
        if($queryReturn == false) {
            $return = false;
        }// if
        
        // return last id commited
        return $return;
    }// function
    
}//class
?>
