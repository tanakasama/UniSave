<?php

	//Created by - David Watts. (C)Warhead-Designz 2016 All Rights Reserved.


	$servername = "localhost";	// < This could be different if you have a webhost.
	$server_username = "";// Might look something like (ActName_UserName)
	$server_password = "";
	$dbName = ""; // Might look something like (ActName_DatabaseName)

	//Connection
	$conn = new PDO ("mysql:host=$servername;dbname=$dbName", $server_username, $server_password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	//Check Connection
	if(!$conn){
		die("Connection failed.");
	}
	
	$username = ($_POST['usernamePost']);
	$password = ($_POST['passwordPost']);
	$rowE = "";
	
	// We select the HASHED password inside the database, then we feed it our password from Unity,
	// Then we use password_verify at the bottom to determine if they are matched.
	if($stmt = $conn->prepare("SELECT Password FROM Acts WHERE User=:User")){
	$stmt->bindParam(":User",$username);
	$stmt->execute();
	// Result = the HASHED password, this will not give out an unhashed password.
	$result = $stmt->fetchColumn();
	}
	

	
	// Now we verify it.
	if(password_verify($password,$result)){
		// Load the saved data to the users device.
		if($stmtt = $conn->prepare("SELECT SaveData FROM Saves WHERE User=:User")){
		$stmtt->bindParam(":User",$username);
		$stmtt->execute();
		$rowE = $stmtt->fetchColumn();
			if(!$rowE){
				echo'No Data Found.';
			}else{
				echo $rowE; // Send the load data to the client.
			}
		}
	}else{
		die('Incorrect');// Tells Unity the password wasn't successful, so to try again.
	}

?>