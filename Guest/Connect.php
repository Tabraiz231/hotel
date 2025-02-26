<?php

	$servername = "localhost";
	$username = "root";
	$password = "";
	$database = "grand_palace";


		$conn = mysqli_connect($servername,$username,$password,$database) or die("Cannot connect to Database".mysqli_connect_error());

?>