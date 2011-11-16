<?php
// ta bort alla utgånga meddelanden 

function clean_messages() {
	$date = date("Y-m-d H:i:s", strtotime("-12 hours")); // 2011-11-12 13:08:07
    $sql = "DELETE FROM messages
					WHERE `date` >= '".$date."'";
	echo $sql."\n";
	//mysql_query($sql) 
	//or die(mysql_error()); 
}

clean_messages();

?>
