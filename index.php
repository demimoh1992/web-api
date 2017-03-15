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

?>

<?php
	if (isset($_SESSION['logged-in']) && $_SESSION['logged-in']) {
		require_once('functions.php');
		echo pageStart("Coast City Sports Centre Home Page");
		echo loggedin($forename, $surname);
		echo navStart();
		echo mainStart();
		echo leftBar();
	} else {
		require_once('functions.php');
		echo pageStart("Coast City Sports Centre Home Page");
		echo loggedin_not();
		echo navStart();
		echo mainStart();
		echo leftBar();
	}
?>
		<section id="maincont">
			<div class="carousel">
			    <div class="carousel-img"><img src="pictures/sports1.jpg" alt="coast" height="500px" width="100%" /></div>
			    <div class="carousel-img"><img src="pictures/sports2.jpg" alt="coast" height="500px" width="100%" /></div>
			    <div class="carousel-img"><img src="pictures/sports3.jpg" alt="coast" height="500px" width="100%" /></div>
			    <div class="carousel-img"><img src="pictures/sports4.jpg" alt="coast" height="500px" width="100%" /></div>
			    <div class="carousel-img"><img src="pictures/sports5.jpg" alt="coast" height="500px" width="100%" /></div>
			</div>
			<div id="carousel-button">
				<button class="prevArrow"> < </button>
				<button class="nextArrow"> > </button>
			</div>
			<header>
				<h1>Welcome to Coast City Sports Centre</h1>
			</header>
			<article class="index-intro">
				<p>Coast City Sports Centre offers various types of facilities, such as swimming pool, gym, racket courts for
				tennis, squash and badminton. The swimming and gym are available all of the time that the club is open, with
				no requirements to book their use, while the rest requires booking. CCSC operate a booking policy that specifies the
				minimum and maximum time that an individual booking can be made.</p>
			</article>
			<article class="index-intro">
				<p>The club offers individualised membership deals, which varying in price and the facilities that can be used by a member.</p>
				<div id="membership-wrapper">
					<div class="membership"><button style="background: url(pictures/membership-gold.png) center no-repeat no-repeat;"></button></div>
					<div class="membership"><button style="background: url(pictures/membership-silver.png) center no-repeat no-repeat;"></button></div>
					<div class="membership"><button style="background: url(pictures/membership-bronze.png) center no-repeat no-repeat;"></button></div>
				</div>
			</article>
		</section>

<?php
	echo mainEnd();
?>
	<script type="text/javascript" src="js/jquery-1.12.3.js"></script>
	<script type="text/javascript" src="js/jquery-migrate-1.3.0.js"></script>
	<script type="text/javascript" src="js/jquery-2.2.3.js"></script>
	<script type="text/javascript" src="js/jquery-ui.js"></script>
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
  	<script type="text/javascript" src="js/slick-master/slick/slick.min.js"></script>
  	<script type="text/javascript" src="js/date.format.js"></script>
	<script type="text/javascript" src="index.js"></script>
	<script type="text/javascript" src="weather.js"></script>
<?php
	echo footer();
	echo pageEnd();
?>