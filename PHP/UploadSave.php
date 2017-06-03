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
	$save = ($_POST['savePost']); // This is where we store our save data.
	$ts = gmdate("Y-m-d\TH:i:s\Z");
	
	// We select the HASHED password inside the database, then we feed it our password from Unity,
	// Then we use password_verify at the bottom to determine if they are matched.
	if($stmt = $conn->prepare("SELECT Password FROM Acts WHERE User=:User")){
	$stmt->bindParam(":User",$username);
	$stmt->execute();

	// Result = the HASHED password, this will not give out a unhashed password.
	$result = $stmt->fetchColumn();

	// Now we verify it.
	if(password_verify($password,$result)){
		// Update/Create Save Data.
		if($stmt = $conn->prepare("SELECT User FROM Saves WHERE User=:User")){
			$stmt->bindParam(":User",$username);
			$stmt->execute();
			
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if(!$row){
				// Create first initial save.
				if($stmt = $conn->prepare("INSERT INTO Saves (User,SaveData,Timestamp) VALUES (?,?,?)")){
					$stmt->bindValue(1,$username);
					$stmt->bindValue(2,$save);
					$stmt->bindValue(3,$ts);
					$stmt->execute();
				}
			}else{
				// Update the save to the new current save.
			if($stmt = $conn->prepare("UPDATE Saves SET SaveData=:Save, Timestamp=:Timestamp WHERE User=:User")){
				$stmt->bindParam(":Save",$save);
				$stmt->bindParam(":Timestamp",$ts);
				$stmt->bindParam(":User",$username);
				$stmt->execute();
				}
			}
		}
		
		die('Verified'); // password MATCHES (HASH) (UPLOAD SUCCESSFUL!) - Tells Unity.
	}else{
		die('Incorrect');// Tells Unity Password wasn't successful, so to try again.
	}
}
?>