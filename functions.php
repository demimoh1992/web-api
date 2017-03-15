<?php

function pageStart($pageTitle) {
	$pageStartContent = <<<PAGESTART
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
	<title>$pageTitle</title>
	<link rel="stylesheet" href="js/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="js/slick-master/slick/slick.css"/>
  	<link rel="stylesheet" type="text/css" href="js/slick-master/slick/slick-theme.css"/>
	<link rel="stylesheet" href="index_css.css">
</head>
<body>

PAGESTART;
	$pageStartContent .="\n";
	return $pageStartContent;
}

function loggedin($forename, $surname) {
	$loggedinContent = <<<LOGGEDINSTART
	<div id="loggedin-content">
		<p>Hello $forename $surname!</p>
		<a href="logout.php" onclick="return confirm('Are you sure you want to logout?');"><button class="formsubmit">Logout</button></a>
	</div>

LOGGEDINSTART;
	$loggedinContent .="\n";
	return $loggedinContent;
}

function loggedin_not() {
	$loggedin_notContent = <<<LOGGEDINNOTSTART
	<div id="loggedin-content">

	</div>

LOGGEDINNOTSTART;
	$loggedin_notContent .="\n";
	return $loggedin_notContent;
}

function loginform() {
	$loginformContent = <<<LOGINFORMSTART
	<section id="maincont">
		<header>
			<h1>Please login to view the contents. </h1>
		</header>
		<article class="loginform-wrapper">
			<div class="loginform">
				<form class="form" method="post" action="logonProcess.php">
					<label for="userName">Username </label>
					<br />
					<input type="text" name="cc_memberID" class="login-input" placeholder="Username" required>
					<br />
					<label for="password">Password </label>
					<br />
					<input type="password" name="userPassword" class="login-input" placeholder="Password" required>
					<br />
					<button class="formsubmit" type="submit" >Login</button
					<br />
				</form>
			</div>
		</article>

	</section>

LOGINFORMSTART;
	$loginformContent .="\n";
	return $loginformContent;
}

function loginformAdmin() {
	$loginformAdminContent = <<<LOGINFORMADMINSTART
	<section id="maincont">
		<header>
			<h1>Please login as admin to view the contents. </h1>
		</header>
		<article class="loginform-wrapper">
			<div class="loginform">
				<form class="form" method="post" action="logonProcess.php">
					<label for="userName">Username </label>
					<br />
					<input type="text" name="cc_adminID" class="login-input" placeholder="Username" required>
					<br />
					<label for="password">Password </label>
					<br />
					<input type="password" name="userPassword" class="login-input" placeholder="Password" required>
					<br />
					<button class="formsubmit" type="submit">Login</button>
					<br />
				</form>
			</div>
		</article>

	</section>

LOGINFORMADMINSTART;
	$loginformAdminContent .="\n";
	return $loginformAdminContent;
}

function navStart() {
	$navStartContent = <<<NAVSTART
	<nav>
		<a href="index.php">Home</a> |
		<a href="#">About</a> |
		<a href="#">Support</a> |
	</nav>

NAVSTART;
	$navStartContent .="\n";
	return $navStartContent;
}

function mainStart() {
	$mainStartContent = <<<MAINSTART
	<main>

MAINSTART;
	$mainStartContent .="\n";
	return $mainStartContent;
}

function leftBar() {
	$leftBarContent = <<<LEFTBAR
		<section id="leftbar">
			<div id="secondnav">
				<ul>
					<li><a href="userPage.php">User Page</a></li>
					<li><a href="adminPage.php">Admin Page</a></li>
				</ul>
			</div>
			<div id="weather-wrapper">
				<div id="weather">
				</div>
			</div>
		</section>

LEFTBAR;
	$leftBarContent .="\n";
	return $leftBarContent;
}

function footer() {
	$footContent = <<< FOOT
	<footer id="footer">
        <div id="footer-copyright">
        	Copyright 2016 Demi Moh Web Design. All Rights Reserved.
        </div>
    </footer>
FOOT;
	$footContent .="\n";
	return $footContent;
}

function mainEnd() {
	$mainEndContent = <<<MAINEND
	</main>

MAINEND;
	$mainEndContent .="\n";
	return $mainEndContent;
}

function pageEnd() {
	$pageEndContent = <<<PAGEEND

</body>
</html>

PAGEEND;
	$pageEndContent .="\n";
	return $pageEndContent;
}


?>