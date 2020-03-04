<?php
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/header.css">
</head>
<body>
<header id="header">
   <div class="topnav">
	<div class="login-container">
	<form class="search" method = "post" action="dom.php">
	 <label>Event search</label>
     <input type="text" placeholder="write location" name="location">
	 <input type="text" placeholder="TItle or Key word" name="keyword">
	 <button type="submit" name ="submit">search</button>
    </form>
    </div>
	<a class="active" href="index.php">Home</a>
	<a href="aboutus.php">About</a>
	<a href="contactus.php">Contact</a>
   </div>
</header>
