<?php
	define("DB_SERVER", "localhost");
	define("DB_USER", "php");
	define("DB_PASS", "havefun39!");
	define("DB_NAME", "george_cms");

	// 1. Create a database connection
	$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	// Test if connection occurred.
	if (mysqli_connect_errno()){
		die("Database connection failed: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
	}
?>