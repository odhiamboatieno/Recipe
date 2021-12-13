<?php

	include_once ('includes/config.php');

	if (!$_POST['user_android_token'] || $_POST['user_android_token'] == '') {
	    die("Error: token required");
	}

	$token = $_POST['user_android_token'];
	$unique_id = $_POST['user_unique_id'];
	$app_version = $_POST['user_app_version'];
	$os_version = $_POST['user_os_version'];
	$device_model = $_POST['user_device_model'];
	$device_manufacturer = $_POST['user_device_manufacturer'];

	$sql = "INSERT INTO tbl_fcm_token (token, user_unique_id, app_version, os_version, device_model, device_manufacturer) VALUES ('$token', '$unique_id', '$app_version', '$os_version', '$device_model', '$device_manufacturer')";

	if (mysqli_query($connect, $sql)) {
	    echo "New record created successfully";
	} else {
	    echo "Error: " . $sql . "<br>" . mysqli_error($connect);
	}

	$connect->close();

?>