<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// We don't have the password or email info stored in sessions so instead we can get the results from the database.
$stmt = $con->prepare('SELECT password, email, color, id, floor, type1, firstname, lastname FROM accounts WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email, $color, $id, $floor, $type, $firstname, $lastname);
$stmt->fetch();
$stmt->close();

if ($type=='necp') {
	header('Location: necpprofile.php');
	}
		else {
		echo'';
	}
?>
<!DOCTYPE html>
<html>
	<head>
	<link rel="icon" type="image/x-icon" href="favicon-32x32.png">
		<meta charset="utf-8">
		<title>Profile Page</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin">
	<nav class="navtop">
			<div>
				<h1>Card System</h1>
				<a href="homestudent.php"><i class="fas fa-home"></i>Home</a>
				<a href="yourcard.php"><i class="fas fa-id-card"></i>Your Card</a>
                <a href="studentprofile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
			<h2>Profile Page</h2>
			<div>
				<p>Your account details are below:</p>
				<table>
					<tr>
						<td>Name:</td>
						<td><?=$firstname?> <?=$lastname?></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><?=$email?></td>
					</tr>
					<tr>
						<td>ID Number:</td>
						<td><?=$id?></td>
					</tr>
					<tr>
						<td>Your Card Color:</td>
						<td><?=$color?></td>
					</tr>
					<tr>
						<td>Your Floor Number:</td>
						<td><?=$floor?></td>
					</tr>
				</table>
			</div>
		</div>
<hr style="height:5px;background-color:black;border-width:0;color:gray;">
<p style="text-align:center; font-size: 19px;">Developed by Nico Minnich, Justin Xia, and Henry Cooper</p>
	</body>
</html>