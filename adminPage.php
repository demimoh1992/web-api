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

	if ($alert == true) {
		echo "<script type='text/javascript'>alert('Incorrect login details');</script>";
	}

?>

<?php
	if (isset($_SESSION['logged-in']) && $_SESSION['logged-in']) {
		if (isset($_SESSION['aName'])) {
			require_once('functions.php');
			echo pageStart("Coast City Sports Centre Admin Page");
			echo loggedin($forename, $surname);
			echo navStart();
			echo mainStart();
			echo leftBar();
		} else if (isset($_SESSION['uName'])) {
			require_once('functions.php');
			echo pageStart("Coast City Sports Centre User Page");
			echo loggedin($forename, $surname);
			echo navStart();
			echo mainStart();
			echo leftBar();
			echo loginformAdmin();
			echo mainEnd();
			echo "<script type=\"text/javascript\" src=\"js/jquery-1.12.3.js\"></script>";
			echo "<script type=\"text/javascript\" src=\"js/date.format.js\"></script>";
			echo "<script type=\"text/javascript\" src=\"weather.js\"></script>";
			echo footer();
			echo pageEnd();
			return false;
		}
	} else {
		require_once('functions.php');
		echo pageStart("Coast City Sports Centre Admin Page");
		echo loggedin_not();
		echo navStart();
		echo mainStart();
		echo leftBar();
		echo loginformAdmin();
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
			<header><h1>Admin Page</h1></header>
			<div id="tabs">
			 	<ul>
					<li><a href="#tabs-1">Member List</a></li>
					<li><a href="#tabs-2">Member Management</a></li>
				</ul>
				<div id="tabs-1">
					<h2>Member List</h2>
						<article>
							<table id="myTable" class="tablesorter">
								<thead>
								<tr>
									<th width="10%">Forename</th>
									<th width="10%">Surname</th>
									<th width="10%">Member Grade</th>
								</tr>
								</thead>
								<tbody>
								<?php
								include 'database_conn.php';

								$sql = "SELECT * FROM cc_member";
								$result = mysqli_query($conn, $sql) or die (mysqli_error($conn));

								while ($row = mysqli_fetch_assoc($result)) {
									$surname = $row['surname'];
									$forename = $row['forename'];
									$cc_gradeID = $row['cc_gradeID'];

									echo "<tr>";
									echo "<td>" . $forename . "</td>";
									echo "<td>" . $surname . "</td>";
									echo "<td>" . $cc_gradeID . "</td>";
									echo "</tr>";
								}
								?>
								</tbody>
							</table>
						</article>
				</div>
				<div id="tabs-2">
					<h2>Member Management</h2>
					<article>
							<table>
								<tr>
									<th width="10%">Forename</th>
									<th width="10%">Surname</th>
									<th width="20%">Address</th>
									<th width="10%">Member Grade</th>
								</tr>
								<?php
								include 'database_conn.php';

								$sql = "SELECT * FROM cc_member";
								$result = mysqli_query($conn, $sql) or die (mysqli_error($conn));

								while ($row = mysqli_fetch_assoc($result)) {
									$cc_memberID = $row['cc_memberID'];
									$surname = $row['surname'];
									$forename = $row['forename'];
									$address = $row['address'];
									$cc_gradeID = $row['cc_gradeID'];

									echo "<tr>";
									echo "<td contenteditable=\"true\" onBlur=\"saveDatabase(this, 'forename', '" . $cc_memberID . "')\" onClick=\"showEditor(this);\">" . $forename . "</td>";
									echo "<td contenteditable=\"true\" onBlur=\"saveDatabase(this, 'surname', '" . $cc_memberID . "')\" onClick=\"showEditor(this);\">" . $surname . "</td>";
									echo "<td contenteditable=\"true\" onBlur=\"saveDatabase(this, 'address', '" . $cc_memberID . "')\" onClick=\"showEditor(this);\">" . $address . "</td>";
									echo "<td contenteditable=\"true\" onBlur=\"saveDatabase(this, 'cc_gradeID', '" . $cc_memberID . "')\" onClick=\"showEditor(this);\">" . $cc_gradeID . "</td>";
									echo "</tr>";
								}
								?>
							</table>
						</article>
				</div>
			</div>
		</section>


<?php
echo mainEnd();
?>

	<script type="text/javascript" src="js/jquery-1.12.3.js"></script>
	<script type="text/javascript" src="js/jquery-2.2.3.js"></script>
	<script type="text/javascript" src="js/jquery.tablesorter.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui.js"></script>
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/date.format.js"></script>
	<script type="text/javascript" src="weather.js"></script>
	<script type="text/javascript" src="adminmanagement.js"></script>

<?php
echo pageEnd();
?>