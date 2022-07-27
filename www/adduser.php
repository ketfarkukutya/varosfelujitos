<?php
include('config.php');
	
	// $username = 'admin';
	// $password = 'ketfarku2018';
	// $userid = 0;
	
	// $q1 = "INSERT INTO User 
			// (UserName, UserEmail, UserStatus, Created)
			// VALUES
			// ('$username', '',1,now())";
		// mysqli_query($conn, $q1);
		// echo("Error description: " . mysqli_error($conn) . "<br />");
	// $content = mysqli_query($conn,"
		// SELECT Id FROM User WHERE LOWER(UserName) = '$username' ORDER BY Created DESC LIMIT 1");
	// while($content <> null && $row = mysqli_fetch_assoc($content))
	// {
		// $userid = $row["Id"];
	// }

	// // $password = hash('ketfarku2018', $password);
	
	// $q1 = "INSERT INTO Login 
		// (UserId, Password, Created)
		// VALUES
		// ('$userid', '$password', now())";
	// mysqli_query($conn, $q1);
	// echo("Error description: " . mysqli_error($conn) . "<br />");


// $query = "DROP TABLE Issue";
// DBQuery ($query, "Issue table Dropped");
// echo("Error description: " . mysqli_error($conn) . "<br />");

// $query = "
// CREATE TABLE Issue (
// Id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
// Title NVARCHAR(1000) NOT NULL,
// Type NVARCHAR(1000) NOT NULL,
// Description TEXT NOT NULL,
// SolutionIdee TEXT NOT NULL,
// Address NVARCHAR(1000) NOT NULL,
// Latitude NVARCHAR(1000) NOT NULL,
// Longitude NVARCHAR(1000) NOT NULL,
// Cost NVARCHAR(1000) NOT NULL DEFAULT '',
// FacebookEventDate DATETIME NULL,
// FacebookEvent NVARCHAR(1000) NOT NULL DEFAULT '',
// Status INT(10) NOT NULL,
// AssignedUser INT(10) NOT NULL,
// ApplicantUser INT(10) NOT NULL,
// Created DATETIME,
// Fixed DATETIME NULL,
// LastUpdated TIMESTAMP
// )";
// DBQuery ($query, "Issue table Created");
// echo("Error description: " . mysqli_error($conn) . "<br />");

// // ---------------------------------------------------------------------

// $query = "DROP TABLE Status";
// DBQuery ($query, "Status table Dropped");
// echo("Error description: " . mysqli_error($conn) . "<br />");

// $query = "
// CREATE TABLE Status (
// Id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
// StatusName NVARCHAR(1000) NOT NULL
// )";
// DBQuery ($query, "Status table Created");
// echo("Error description: " . mysqli_error($conn) . "<br />");

// // ---------------------------------------------------------------------

// $query = "DROP TABLE Picture";
// DBQuery ($query, "Picture table Dropped");
// echo("Error description: " . mysqli_error($conn) . "<br />");

// $query = "
// CREATE TABLE Picture (
// Id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
// Title NVARCHAR(1000) NOT NULL,
// Link NVARCHAR(1000) NOT NULL,
// Type INT(10) NOT NULL DEFAULT 0,
// Issue INT(10) NOT NULL,
// Created DATETIME
// )";
// DBQuery ($query, "Picture table Created");
// echo("Error description: " . mysqli_error($conn) . "<br />");

// // ---------------------------------------------------------------------

// $query = "DROP TABLE User";
// DBQuery ($query, "User table Dropped");
// echo("Error description: " . mysqli_error($conn) . "<br />");

// $query = "
// CREATE TABLE User (
// Id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
// UserName NVARCHAR(1000) NOT NULL,
// UserEmail NVARCHAR(1000) NOT NULL,
// UserStatus INT(1) NOT NULL,
// Created DATETIME,
// LastLogin DATETIME
// )";
// DBQuery ($query, "User table Created");
// echo("Error description: " . mysqli_error($conn) . "<br />");

// $query = "DROP TABLE Login";
// DBQuery ($query, "Login table Dropped");
// echo("Error description: " . mysqli_error($conn) . "<br />");

// $query = "
// CREATE TABLE Login (
// Id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
// UserId INT(10) NOT NULL,
// Password NVARCHAR(1000) NOT NULL,
// Created DATETIME
// )";
// DBQuery ($query, "Login table Created");
// echo("Error description: " . mysqli_error($conn) . "<br />");

// // ---------------------------------------------------------------------

// $query = "DROP TABLE Session";
// DBQuery ($query, "Session table Dropped");
// echo("Error description: " . mysqli_error($conn) . "<br />");

// $query = "
// CREATE TABLE Session (
// Id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
// UserId INT(6) NOT NULL,
// SessionId NVARCHAR(1000) NOT NULL,
// ClientIp NVARCHAR(1000) NOT NULL,
// Created DATETIME,
// LastUsed DATETIME
// )";
// DBQuery ($query, "Session table Created");
// echo("Error description: " . mysqli_error($conn) . "<br />");


// // ---------------------------------------------------------------------

// $query = "DROP TABLE Comment";
// DBQuery ($query, "Comment table Dropped");
// echo("Error description: " . mysqli_error($conn) . "<br />");

// $query = "
// CREATE TABLE Comment (
// Id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
// Text NVARCHAR(1000) NOT NULL,
// User INT(10) NOT NULL,
// Issue INT(10) NOT NULL,
// Created DATETIME
// )";
// DBQuery ($query, "Comment table Created");
// echo("Error description: " . mysqli_error($conn) . "<br />");

	// $username = 'admin';
	// $password =  'ketfarku2018';
	// $userid = 0;
	
	// $q1 = "INSERT INTO User 
			// (UserName, UserEmail, UserStatus, Created)
			// VALUES
			// ('$username', '',1,now())";
		// mysqli_query($conn, $q1);
	
	// $content = mysqli_query($conn,"
		// SELECT Id FROM User WHERE LOWER(UserName) = '$username' ORDER BY Created DESC LIMIT 1");
	// while($content <> null && $row = mysqli_fetch_assoc($content))
	// {
		// $userid = $row["Id"];
	// }

	// $q1 = "INSERT INTO Login 
		// (UserId, Password, Created)
		// VALUES
		// ('$userid', '$password', now())";
	// mysqli_query($conn, $q1);

?>

