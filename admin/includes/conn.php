<?php
	$conn = new mysqli('localhost', 'root', '12345678', 'libsystem');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
?>