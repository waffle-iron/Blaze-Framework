<?php
/**
 * Blaze Framework
 * PHP Framework
 *
 * @version 0.1
 * @author George Willaman
 */
class Blaze {
    private $db;
    protected $user;
    protected $pass;
    protected $DBName;
    public $errors; // Array of errors
    private static $frameworkName = 'Blaze Framework Version 0.1';

    public function __construct ( $db_user, $password, $dbname) {
      $this->db_user = $db_user;
      $this->pass = $password;
      $this->DBName = $dbname;
      try {
        $DB_con = new PDO("mysql:host=localhost" . ";dbname=" . $dbname, $db_user, $password);
        $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        die($e->getMessage());
      }
      $this->db = $DB_con;
    }
    
    public static function IsPost($post){
      if(isset($_POST[$post])){
        return true;
      } else {
        return false;
      }
    }
    
    public function CountTable($tablename){
      $stmt = $this->db->prepare("SELECT count(*) FROM $tablename");
      $stmt->execute();
      return $stmt->fetchColumn();
    }

    public function query($query){
      $stmt = $this->db->prepare($query);
      $stmt->execute();
      return $stmt->fetchColumn();
    }
    
    public static function RemoveSession($session_name){
      unset($_SESSION[$session_name]);
    }
    
    public static function DestroySession(){
      session_destroy();
    }
    
    public static function GetPostArray(){
      print_r($_POST);
    }

    public static function GetPostKey($name){
      return $_POST[$name];
    }
  
    public static function SetCookie($name,$value,$exp_time){
      setcookie($name, $value, $exp_time); // setcookie($name, $value, time() + (86400 * 30)); 
    }
  
    public static function SetSession($name,$value){
      $_SESSION[$name] = $value;
    }
  
    public static function hashedPassword($password){
      return password_hash($password, PASSWORD_DEFAULT);
    }
  
    public static function passCorrect($password,$hashedPassword){
      if(password_verify($password, $hashedPassword)) {
        //Password is correct, return true
        return true;
      } 
    }
    
   public function AddError($id, $msg){
     if(isset($this->errors[$id]) && !is_array($this->errors[$id])){
       $this->errors[$id] = array($msg);
     } else {
       $this->errors[$id][] = $msg;
     }
   }
    
   public function passMatch($pass1, $pass2, $id) {
     if($pass1 !== $pass2){
       $this->AddError($id, 'The passwords you entered do not match.');
       return false;
     }
     return true;
   }

   public function emailValid($val, $id = 'email') {
     if(!preg_match("/^([_a-z0-9+-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,24})$/i", $val)){
       $this->AddError($id, 'The email address you entered is not valid.');
       return false;
     }
       return true;
   }

}
?>