<?php
	require_once('../includes/functions.php'); 
		
	$meess = new Meess();
	$meess->init($db = new Database());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Message2key</title>
	<link rel="stylesheet" href="css/style.css" type="text/css" /> 
</head>
<body>     
	<div class="content">
	
		<?php
			if (isset($_POST['message']) && !empty($_POST['message'])) {  
				 $meess->insert_message($_POST['message']); 
			} else if (isset($_POST['key']))  { 
				echo $meess->tryget_message($_POST['key']);
				 
			} else {	
		?>
		<fieldset>
		  <legend>Send message</legend>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="msgForm" >
			<h4><textarea id="msgField" name="message" cols="50" rows="3" style="resize: none;" class="textarea" >your message</textarea></h4>
			<input type="submit" name="submit" id="submitMsg" value="Message" class="submit" />
			</form>
		</fieldset>
		<div ><input id="moreOptions" type="checkbox" name="more" value="more" checked="yes" </div>
		<div id="showMoreOption">More Options</div>
		<div id="errorMsg"></div> 	
		<br />
		
		<fieldset>
		  <legend>Get message</legend>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="keyForm" >
			<h4><input type="text" name="key" id="keyField" cols="60" rows="10" style="resize: none;" value="insert key"></h4>
			<input type="submit" name="submit" value="Get message" class="submit" />
			</form>
		</fieldset>	 
		<div id="errorKey"></div> 	
		
		<?php } 
		?>
		
	</div>
	<script src="js/validate.js" ></script> 
</body> 
</html>    
