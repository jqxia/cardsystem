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
$stmt = $con->prepare('SELECT password, email FROM accounts WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html>
	<head>
	<style>
      table,

      td {
        text-align: center;
        vertical-align: middle;
      }
	  table.center {
  margin-left: auto; 
  margin-right: auto;
	}
    </style>
		<meta charset="utf-8">
		<title>Home Page</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<script type="text/javascript">
    function ShowHideDiv(chkPassport) {
        var dvPassport = document.getElementById("dvPassport");
        dvPassport.style.display = chkPassport.checked ? "block" : "none";
    }
	</script>
<script type="text/javascript">
function destinationselect(val){
 var element=document.getElementById('box');
 if(val=='pick a color'||val=='others')
   element.style.display='block';
 else  
   element.style.display='none';
}

</script>
	</head>
	<!--menu-->
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Submit a form to sign out.</h1>
                <a href="home.php"><i class="fas fa-home"></i></i>Home</a>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
			<h2>Home Page</h2>
			<p>Welcome back, <?=$email?>!</p>
		</div>
		<!--end menu-->
<table class="center"><!--start form-->
<form style="text-align:center;" action="insert.php" method="POST">
<tr><td><input type="text" name="id" placeholder="Type id number here"></td></tr>
<tr><td><select name="destination" onchange='destinationselect(this.value);' required> 
    <option selected hidden value="">Select Code</option>
	<option>Please select a destination.</option>
    <option value="atrium" name="destination">Atrium</option>
    <option value="ballgym" name="destination">Ball Gym</option>
    <option value="bracken" name="destination">Bracken Library</option>
    <option value="burris" name="destination">Burris</option>
    <option value="goldform" name="destination">Gold Form</option>
    <option value="north" name="destination">North</option>
    <option value="quad" name="destination">Quad</option>
    <option value="tally" name="destination">Student Center/Tally</option>
    <option value="village" name="destination">Village</option>
    <option value="others" name="destination">Other</option>
  </select></td></tr>
<tr><td><input type="text" name="destination" placeholder="Type destination here" id="box" style='display:none;'></td></tr>
<tr><td><label for="return1">Excpected time of return:</label>
<input type="time" id="return1" name="return1" required></td></tr>
<tr><td><label for="chkPassport">
    <input type="checkbox" name="companion" id="chkPassport" onclick="ShowHideDiv(this)">
    Check the box if you have a companion. (Ignore for NECPS)
</label>
<div id="dvPassport" style="display: none">
	Companion Name:
    <input type="text" name="companion" id="txtPassportNumber">
</div><!--end of companion--></td></tr>
<tr><td>
<p>Do you need Special Permission (SP)?</p>
<input type="radio" id="sp" name="sp" value="y" required>
<label for="yes">YES</label>
<input type="radio" id="no" name="sp" value="n" required>
<label for="no">NO</label></td></tr>
<tr><td><p>Click sumbit to finish</p></td></tr>
<tr><td><input type="submit" value="Submit" name="submit"></td></tr>
</form><!--end of the form--></table>
<hr style="height:5px;background-color:black;border-width:0;color:gray;">
<p style="text-align:center;">Developed by Justin Xia, Nico Minnich, and Henry Copper</p>
	</body>
</html>