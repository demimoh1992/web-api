<?php
	ini_set("session.save_path", "/home/unn_w13029619/sessionData");
	session_start();

	$_SESSION = array();

	session_unset();

	include 'database_conn.php';

	$cc_memberID = filter_has_var(INPUT_POST, 'cc_memberID') ? $_POST['cc_memberID']: null;
	$cc_adminID = filter_has_var(INPUT_POST, 'cc_adminID') ? $_POST['cc_adminID']: null;
	$userPassword  = filter_has_var(INPUT_POST, 'userPassword') ? $_POST['userPassword']: null;

	//sanitize the input by trimming
	$cc_memberID = trim($cc_memberID);
	$cc_adminID = trim($cc_adminID);
	$userPassword = trim($userPassword);

	//sanitize the input by removing tags
	$cc_memberID = filter_var($cc_memberID, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$cc_adminID = filter_var($cc_adminID, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$userPassword = filter_var($userPassword, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//sanitize the input by removing special characters
	$cc_memberID = filter_var($cc_memberID, FILTER_SANITIZE_SPECIAL_CHARS);
	$cc_adminID = filter_var($cc_adminID, FILTER_SANITIZE_SPECIAL_CHARS);
	$userPassword = filter_var($userPassword, FILTER_SANITIZE_SPECIAL_CHARS);

	/* Query the users database table to get the password hash for the username entered by the user in the logon form */
	$hashed = hash('sha1', $userPassword);

	if ($cc_memberID != null) {
		$sql = "SELECT password FROM cc_member WHERE cc_memberID = ?";

		// prepare the sql statement
		$stmt = mysqli_prepare($conn, $sql);

		/* Bind the $username entered by the user to the prepared statement. Note the gsh part indicates the data type used ? in this case a string */
		mysqli_stmt_bind_param($stmt, "s", $cc_memberID);

		// execute the query
		mysqli_stmt_execute($stmt);

		/* Get the password hash from the query results for the given username and store it in the variable indicated */
		mysqli_stmt_bind_result($stmt, $password);

		/* Check if a record was returned by the query. If yes, then there was a username matching what was entered in the logon form
		   and we can now test to see if the password entered in the logon form is the same as the stored (correct) one in the database. */

		//Modify script by adding a new session variable after the first.
		if (empty($errors)) {
			if (mysqli_stmt_fetch($stmt)) {
				//if (password_verify($userPassword, $storedPassword)) {
				if ($password == $hashed) {
					$_SESSION['uName'] = $cc_memberID;
					$_SESSION['logged-in'] = true;
					header('Location: userPage.php');
					exit;
				}
				else {
					header('Location: userPage.php?alert=true');
				}
			}
			else {
				header('Location: userPage.php?alert=true');
			}
		}

		mysqli_stmt_close($stmt);
		mysqli_close($conn);

	} else if ($cc_adminID != null) {
		$sql = "SELECT password FROM cc_admin WHERE cc_adminID = ?";

		// prepare the sql statement
		$stmt = mysqli_prepare($conn, $sql);

		/* Bind the $username entered by the user to the prepared statement. Note the gsh part indicates the data type used ? in this case a string */
		mysqli_stmt_bind_param($stmt, "s", $cc_adminID);

		// execute the query
		mysqli_stmt_execute($stmt);

		/* Get the password hash from the query results for the given username and store it in the variable indicated */
		mysqli_stmt_bind_result($stmt, $password);

		/* Check if a record was returned by the query. If yes, then there was a username matching what was entered in the logon form
		   and we can now test to see if the password entered in the logon form is the same as the stored (correct) one in the database. */

		//Modify script by adding a new session variable after the first.
		if (empty($errors)) {
			if (mysqli_stmt_fetch($stmt)) {
				//if (password_verify($userPassword, $storedPassword)) {
				if ($password == $hashed) {
					$_SESSION['aName'] = $cc_adminID;
					$_SESSION['logged-in'] = true;
					header('Location: adminPage.php');
					exit;
				}
				else {
					header('Location: adminPage.php?alert=true');
				}
			}
			else {
				header('Location: adminPage.php?alert=true');
			}
		}

		mysqli_stmt_close($stmt);
		mysqli_close($conn);
	}
?>
