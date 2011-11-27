<?php 

class Database{
	
	 
	public function init(){
			
	}
	
	public function connect(){
		$this->connection = mysql_connect("localhost","user","pass");
		$this->database = mysql_select_db("openmessage", $this->connection);
		if (!$this->connection){
			die('Could not connect: ' . mysql_error());
		}
	}
	
	public function get_connection(){
		return $this->connection;
	}
	
	public function disconnect(){
		$this->connection = mysql_close();
	}
}


class Meess{

	function init($db){
		$this->db = $db;
		$this->db->connect();
		$this->set_shared_key();
	}
	
	
	function __destruct(){
		$this->db->disconnect();
	}

	function result($query) {
		$result = mysql_query($query, $this->db->get_connection()) or die(mysql_error());
		return $result;
	}	
	
	function set_shared_key(){
		# hard coding the shared key
		$this->mainkey = "secretkey";
	}
	function get_shared_key(){
		if($this->mainkey){			
			return $this->mainkey;
		}
	}
	
	function insert_message($form_message) {
		#$mainkey = "secretkey"; // $this->makekey(); 
		$mainkey = $this->get_shared_key();
		$this->makekey();
		$key = $this->get_user_key();
		$encrypted_message = $this->encrypt_message($form_message, $key);
		$encrypted_key = $this->encrypt_message($key, $mainkey);
		$sql = sprintf("INSERT INTO openmessage.messages 
				(id, message, keyvalue, date) 
				VALUES (NULL,'%s', '%s', CURRENT_TIMESTAMP)", $encrypted_message, $encrypted_key);
		if (!mysql_query($sql,$this->db->get_connection())) {
		  die('Error: ' . mysql_error());
		}
		echo $this->output_message_insert();
	}

	function output_message_insert() { 
		$expire = mktime(0, 0, 0, date("m"), date("d")+1, date("Y"));
		return 	"<fieldset>
				 <legend> Ok </legend>
				 <div class=\"message\">The message-key is: ". $this->get_user_key() ."<br />	 
										The message will expire in 12 h at ". $this->datetime_to_text($expire) ."</div>
				 </fieldset>";
	}

	function keyexists($key) {
		$result = $this->getbykey($key); 
		if (!empty ($result)) {
			return true; 
		} 
		return false;
	}

	function getbykey($key) {
		
		$sql = "SELECT * FROM messages WHERE keyvalue = 1";
						#WHERE `keyvalue` = 6237486 
						#LIMIT 1";
		$query = mysql_query($sql);
		$result = mysql_fetch_assoc($query);
		return $result;
		
	}

	/**
	 * Generate a unique key
	 **/
	function makekey() {
		$i = 0;
		$n = rand(10e16, 10e20);	
		$n = base_convert($n, 10, 36);	
		
		while($this->keyexists($n)){
			$this->makekey();
			echo ++$i;
		}
		
		$this->set_user_key($n);
	}

	function encrypt_message($form_message, $key) {
		 $encrypted_message = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $form_message, MCRYPT_MODE_CBC, md5(md5($key))));
		 return $encrypted_message;
	 }
		 
	function decrypt_message($database_message, $key) { 
		 $database_message = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($database_message), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
		 return $database_message;	 
	 }


	// find a message by id
	function sql_find_by_id($id) {
		$sql = sprintf("SELECT * FROM messages
						WHERE id=%s 
						LIMIT 1",
						mysql_real_escape_string($id));
		$result = $this->result($sql);
		$message = mysql_fetch_assoc($result);
		return $message;
	}


	// find a message 
	function sql_find_message($message) {
		$sql = sprintf("SELECT * FROM messages
						WHERE message=%s 
						LIMIT 1",
						mysql_real_escape_string($message));
		$result = $this->result($sql);
		$message = mysql_fetch_assoc($result);
		return $message;
	}

	// delete by message id
	function delete($id) {
	  $sql = "DELETE FROM messages";
	  $sql .= " WHERE id=". mysql_real_escape_string($id);
	  $sql .= " LIMIT 1";
	  mysql_query($sql) 
	  or die(mysql_error()); 

	}

	// check if the message and password is ok   
	function tryget_message($key) {
	  $mainkey = "secretkey"; // $this->makekey(); 
	  $key = mysql_real_escape_string($key);
	  $encrypted_key = $this->encrypt_message($key, $mainkey);
	  $sql  = "SELECT * FROM messages ";
	  $sql .= "WHERE keyvalue = '$encrypted_key' ";
	  $sql .= "LIMIT 1";
	  $result = mysql_query($sql, $this->db->get_connection()) or die(mysql_error());
	  $row = mysql_fetch_assoc($result);
	  if (isset ($row['message'])) {
		$message = $this->decrypt_message($row['message'], $key); 
		$id = $row['id']; 
		return $this->output_message_for_key($message); 

		} else {
			return $this->error_message("Sorry No message could be extracted");
		}
	}

	function error_message($message) { 
		return 	"<fieldset>
				 <legend> Error </legend>
				 <div class=\"message_red\">". $message ."</div><br />
				 </fieldset>";
				}

	function output_message_for_key($message) { 
		return 	"<fieldset>
				 <legend> Message: </legend>
				 <div class=\"message\"> ". $message ."<br /></div>
				 <div class=\"message_red\">- This message has now expired. </div>
				 </fieldset>";
	}

	function datetime_to_text($datetime) {
	  $dtime = strtotime($datetime);
	  return strftime("%B %d, %Y at %I:%M %p", $dtime);
	}

	function getkey($message) {
		$row = $this->sql_find_message($message);
		return $row['keyvalue']; 
	}
		
	function geturl($id) {
		return "someurl"; 
	}

	function set_user_key($key){
		$this->user_key = $key;
	}
	function get_user_key(){
		return $this->user_key;
	}

}
