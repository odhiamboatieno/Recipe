<?php

	if (isset($_GET['id'])) {
		$ID = $_GET['id'];
	} else {
		$ID = "";
	}

	$sql_recipes = "SELECT COUNT(*) as num FROM tbl_recipes WHERE cat_id = $ID";
  	$total_recipes = mysqli_query($connect, $sql_recipes);
  	$total_recipes = mysqli_fetch_array($total_recipes);
  	$total_recipes = $total_recipes['num'];

  	if ($total_recipes > 0) {

	    $failed =<<<EOF
	            <script>
	                alert('This category cannot be deleted because it has active Recipes!');
	                window.location = 'manage-category.php';
	            </script>
EOF;
        echo $failed;

  	} else {

		// get image file from table
		$sql_query = "SELECT category_image FROM tbl_category WHERE cid = ?";

		$stmt = $connect->stmt_init();
		if ($stmt->prepare($sql_query)) {
			// Bind your variables to replace the ?s
			$stmt->bind_param('s', $ID);
			// Execute query
			$stmt->execute();
			// store result
			$stmt->store_result();
			$stmt->bind_result($category_image);
			$stmt->fetch();
			$stmt->close();
		}

		// delete image file from directory
		$delete = unlink('upload/category/'."$category_image");

		// delete data from menu table
		$sql_query = "DELETE FROM tbl_category WHERE cid = ?";

		$stmt = $connect->stmt_init();
		if ($stmt->prepare($sql_query)) {
			// Bind your variables to replace the ?s
			$stmt->bind_param('s', $ID);
			// Execute query
			$stmt->execute();
			// store result
			$delete_category_result = $stmt->store_result();
			$stmt->close();
		}

		// get image file from table
		$sql_query = "SELECT recipe_image FROM tbl_recipes WHERE cat_id = ?";

		// create array variable to store menu image
		$image_data = array();

		$stmt_menu = $connect->stmt_init();
		if ($stmt_menu->prepare($sql_query)) {
			// Bind your variables to replace the ?s
			$stmt_menu->bind_param('s', $ID);
			// Execute query
			$stmt_menu->execute();
			// store result
			$stmt_menu->store_result();
			$stmt_menu->bind_result($image_data['recipe_image']);
		}

		// delete all menu image files from directory
		while ($stmt_menu->fetch()) {
			$recipe_image = $image_data[recipe_image];
			$delete_image = unlink('upload/'."$recipe_image");
		}

		$stmt_menu->close();

		// delete data from menu table
		$sql_query = "DELETE FROM tbl_recipes WHERE cat_id = ?";

		$stmt = $connect->stmt_init();
		if ($stmt->prepare($sql_query)) {
			// Bind your variables to replace the ?s
			$stmt->bind_param('s', $ID);
			// Execute query
			$stmt->execute();
			// store result
			$delete_menu_result = $stmt->store_result();
			$stmt->close();
		}

		// if delete data success back to reservation page
		if ($delete_category_result && $delete_menu_result) {
			header("location: manage-category.php");
		}

	}

?>
