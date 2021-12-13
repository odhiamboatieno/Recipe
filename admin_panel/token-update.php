<?php

	include_once ('includes/config.php');

	if (!$_POST['user_android_token'] || $_POST['user_android_token'] == '') {
	    die("Error: token required");
	}

	$user_android_token = $_POST['user_android_token'];
	$user_unique_id = $_POST['user_unique_id'];

	$sql = " UPDATE tbl_fcm_token SET token = '$user_android_token' WHERE user_unique_id = '$user_unique_id' ";
	
	if (mysqli_query($connect, $sql)) {
	    echo "Record updated successfully";
	} else {
	    echo "Error: " . $sql . "<br>" . mysqli_error($connect);
	}

	$connect->close();

?>