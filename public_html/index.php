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
	<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" /> 
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
		  <legend>Insert message</legend>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<h4><textarea name="message" cols="50" rows="3" style="resize: none;" class="textarea" ></textarea></h4>
			<input type="submit" name="submit" value="Message" class="submit" />
			</form>
		</fieldset>	
		<fieldset>
		  <legend>Get message</legend>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<h4><input type="text" name="key" cols="60" rows="10" style="resize: none;"></h4>
			<input type="submit" name="submit" value="Get message" class="submit" />
			</form>
		</fieldset>	 
		<?php } 
		?>
		
	</div>
</body> 
</html>    

<?php

?>

