<?php
	$conn = new mysqli('localhost', 'root', '123456', 'libsystem');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
?>
