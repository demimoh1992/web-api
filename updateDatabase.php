<?php

	//update the database according to the data sent by ajax post
	//from admin - member management table
	include 'database_conn.php';

	$column_name = $_POST["column_name"];
	$editedValue = $_POST["editedValue"];
	$row_id = $_POST["row_id"];

	$column_name = trim($column_name);
	$editedValue = trim($editedValue);
	$row_id = trim($row_id);

	$column_name = filter_var($column_name, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$editedValue = filter_var($editedValue, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$row_id = filter_var($row_id, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	$column_name = mysqli_real_escape_string($conn, $column_name);
	$editedValue = mysqli_real_escape_string($conn, $editedValue);
	$row_id = mysqli_real_escape_string($conn, $row_id);

	$column_name = filter_var($column_name, FILTER_SANITIZE_SPECIAL_CHARS);
	$editedValue = filter_var($editedValue, FILTER_SANITIZE_SPECIAL_CHARS);
	$row_id = filter_var($row_id, FILTER_SANITIZE_SPECIAL_CHARS);

	$sql = "UPDATE cc_member
	SET $column_name = '$editedValue'
	WHERE cc_memberID = '$row_id'";

	$result = mysqli_query($conn, $sql) or die (mysqli_error($conn));

?>