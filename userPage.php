<?php
	ini_set("session.save_path", "/home/unn_w13029619/sessionData");
	session_start();

	setcookie("userName", "", time() + 3600);

	include 'database_conn.php';

	if (isset($_SESSION['logged-in']) && $_SESSION['logged-in']) {
		if (isset($_SESSION['uName'])) {
			$userName = $_SESSION['uName'];

			$sqlUsername = "SELECT * FROM cc_member WHERE cc_memberID = '$userName'";
			$sqlUsernameR = mysqli_query($conn, $sqlUsername) or die(mysqli_error($conn));

			while ($row = mysqli_fetch_assoc($sqlUsernameR)) {
				$surname = $row['surname'];
				$forename = $row['forename'];
				$address = $row['address'];
				$cc_gradeID = $row['cc_gradeID'];
			}
		} else if (isset($_SESSION['aName'])) {
			$adminName = $_SESSION['aName'];

			$sqlAdminname = "SELECT * FROM cc_admin WHERE cc_adminID = '$adminName'";
			$sqlAdminnameR = mysqli_query($conn, $sqlAdminname) or die(mysqli_error($conn));

			if ($sqlAdminnameR) {
				$forename = "Admin";
				$surname = "Staff";
			}
		}
	}

	$alert = filter_has_var(INPUT_GET, 'alert') ? $_GET['alert']: null;
	$twitter_logged = filter_has_var(INPUT_GET, 'twitter') ? $_GET['twitter']: null;

	if ($alert == true) {
		echo "<script type='text/javascript'>alert('Incorrect login details');</script>";
	}

	if ($twitter_logged == "logged") {
		$twitterstatus = "loggedin";
		$_SESSION['twitter'] = $twitterstatus;
	}
?>

<?php
	if (isset($_SESSION['logged-in']) && $_SESSION['logged-in']) {
		require_once('functions.php');
		echo pageStart("Coast City Sports Centre User Page");
		echo loggedin($forename, $surname);
		echo navStart();
		echo mainStart();
		echo leftBar();
	} else {
		require_once('functions.php');
		echo pageStart("Coast City Sports Centre User Page");
		echo loggedin_not();
		echo navStart();
		echo mainStart();
		echo leftBar();
		echo loginform();
		echo mainEnd();
		echo "<script type=\"text/javascript\" src=\"js/jquery-1.12.3.js\"></script>";
		echo "<script type=\"text/javascript\" src=\"js/date.format.js\"></script>";
		echo "<script type=\"text/javascript\" src=\"weather.js\"></script>";
		echo footer();
		echo pageEnd();
		return false;
	}
?>
		<section id="maincont">
			<header><h1>User Page</h1></header>
			<article>
				<div class="twitter_login">
					<?php
						if (!isset($_SESSION['twitter'])) {
							echo "<a href=\"twitter_login.php\"><img src=\"pictures/twitter_button.png\" alt=\"Twitter Login button\" /></a>";
							echo "<p>Login twitter to view twitter related sections!</p>";
						}
					?>
				</div>
			</article>

			<div id="main-left">
				<article class="userpage-article">
					<header>Google Map</header>
					<div id="googleMap">
					</div>
				</article>
			</div>

			<?php
				if (!isset($_SESSION['twitter'])) {
					echo "</section>";
					echo mainEnd();
					echo "<script type=\"text/javascript\" src=\"js/jquery-1.12.3.js\"></script>";
					echo "<script type=\"text/javascript\" src=\"js/date.format.js\"></script>";
					echo "<script type=\"text/javascript\" src=\"weather.js\"></script>";
					echo "<script type=\"text/javascript\" src=\"http://maps.googleapis.com/maps/api/js?key=AIzaSyB0_mCIxQQGau1qivbxjIk1Oc8l5DotheQ&sensor=false\"></script>";
					echo "<script type=\"text/javascript\" src=\"map.js\"></script>";
					echo footer();
					echo pageEnd();
					return false;
				}
			?>
			<div id="main-right">
				<article class="userpage-article">
				<header>Post tweets</header>
					<form method="post" action="tweeting_API.php">
					    <textarea cols="54" rows="4" name="message" id="message"></textarea>
					    <br />
					    <button class="tweet-button" type="submit" name="submit">Tweet!</button>
					</form>
				</article>

				<!-- NOT NEEDED
				<article class="userpage-article">
				<header>Tweet list</header>
					<ul id="tweet-list">
					</ul>
				</article>
				-->

				<article class="userpage-article">
				<header>Tweet related to #CM0677</header>
					<button class="tweet-button" onclick="refresh();">Refresh</button></a>
					<div id ="search-list">
					</div>
				</article>
			</div>

		</section>

<?php
	echo mainEnd();
?>
	<script type="text/javascript" src="js/jquery-1.12.3.js"></script>
	<script type="text/javascript" src="js/jquery-2.2.3.js"></script>
	<script type="text/javascript" src="js/jquery-ui.js"></script>
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/date.format.js"></script>
	<script type="text/javascript" src="weather.js"></script>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyB0_mCIxQQGau1qivbxjIk1Oc8l5DotheQ&sensor=false"></script>
	<script type="text/javascript" src="map.js"></script>
	<script type="text/javascript" src="tweets.js"></script>

<?php
	echo footer();
	echo pageEnd();
?>