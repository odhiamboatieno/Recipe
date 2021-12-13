<?php
	include 'functions.php';
	include 'fcm.php';
?>

<?php

    $setting_query = "SELECT * FROM tbl_settings where id = '1'";
    $setting_result = mysqli_query($connect, $setting_query);
    $setting_row = mysqli_fetch_assoc($setting_result);

	$sql_featured = "SELECT COUNT(*) as num FROM tbl_recipes WHERE featured = 1";
	$total_featured = mysqli_query($connect, $sql_featured);
	$total_featured = mysqli_fetch_array($total_featured);
	$total_featured = $total_featured['num'];

    if (isset($_GET['add'])) {

    	if ($total_featured >= 10) {
	        $failed =<<<EOF
	            <script>
	                alert('You have reached the maximum number of featured recipes!');
	                window.location = 'manage-recipe.php';
	            </script>
EOF;
        echo $failed;
    	} else {

    		$data = array('featured' => '1');	
			$hasil = Update('tbl_recipes', $data, "WHERE recipe_id = '".$_GET['add']."'");

			if ($hasil > 0) {
		        $success =<<<EOF
		            <script>
		                alert('Success added to featured recipes');
		                window.location = 'manage-recipe.php';
		            </script>
EOF;
       			echo $success;
				exit;
			}
		}
    }

    if (isset($_GET['remove'])) {
		$data = array('featured' => '0');	
		$hasil = Update('tbl_recipes', $data, "WHERE recipe_id = '".$_GET['remove']."'");

			if ($hasil > 0) {
		        $success =<<<EOF
		            <script>
		                alert('Removed from featured recipes');
		                window.location = 'manage-recipe.php';
		            </script>
EOF;
       			echo $success;
				exit;
			}
    }

?>

	<?php 
		// create object of functions class
		$function = new functions;
		
		// create array variable to store data from database
		$data = array();
		
		if(isset($_GET['keyword'])) {	
			// check value of keyword variable
			$keyword = $function->sanitize($_GET['keyword']);
			$bind_keyword = "%".$keyword."%";
		} else {
			$keyword = "";
			$bind_keyword = $keyword;
		}
			
		if (empty($keyword)) {
			$sql_query = "SELECT n.recipe_id, n.recipe_title, n.recipe_image, n.recipe_time, c.category_name, n.video_id, n.content_type, n.featured
					FROM tbl_recipes n
						LEFT JOIN tbl_category c ON n.cat_id = c.cid
					GROUP BY n.recipe_id  
					ORDER BY n.recipe_id DESC";
		} else {
			$sql_query = "SELECT n.recipe_id, n.recipe_title, n.recipe_image, n.recipe_time, c.category_name, n.video_id, n.content_type, n.featured
					FROM tbl_recipes n
						LEFT JOIN tbl_category c ON n.cat_id = c.cid
					WHERE n.recipe_title LIKE ? 
					GROUP BY n.recipe_id  
					ORDER BY n.recipe_id DESC";
		}
		
		
		$stmt = $connect->stmt_init();
		if ($stmt->prepare($sql_query)) {	
			// Bind your variables to replace the ?s
			if (!empty($keyword)) {
				$stmt->bind_param('s', $bind_keyword);
			}
			// Execute query
			$stmt->execute();
			// store result 
			$stmt->store_result();
			$stmt->bind_result( 
					$data['recipe_id'],
					$data['recipe_title'],
					$data['recipe_image'],
					$data['recipe_time'],
					$data['category_name'],
					$data['video_id'],
					$data['content_type'],
					$data['featured']
					);
			// get total records
			$total_records = $stmt->num_rows;
		}
			
		// check page parameter
		if (isset($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}
						
		// number of data that will be display per page		
		$offset = 10;
						
		//lets calculate the LIMIT for SQL, and save it $from
		if ($page) {
			$from 	= ($page * $offset) - $offset;
		} else {
			//if nothing was given in page request, lets load the first page
			$from = 0;	
		}	
		
		if (empty($keyword)) {
			$sql_query = "SELECT n.recipe_id, n.recipe_title, n.recipe_image, n.recipe_time, c.category_name, n.video_id, n.content_type, n.featured
					FROM tbl_recipes n 
						LEFT JOIN tbl_category c ON n.cat_id = c.cid
					GROUP BY n.recipe_id  
					ORDER BY n.recipe_id DESC LIMIT ?, ?";
		} else {
			$sql_query = "SELECT n.recipe_id, n.recipe_title, n.recipe_image, n.recipe_time, c.category_name, n.video_id, n.content_type, n.featured
					FROM tbl_recipes n
						LEFT JOIN tbl_category c ON n.cat_id = c.cid
					WHERE n.recipe_title LIKE ? 
					GROUP BY n.recipe_id  
					ORDER BY n.recipe_id DESC LIMIT ?, ?";
		}
		
		$stmt_paging = $connect->stmt_init();
		if ($stmt_paging ->prepare($sql_query)) {
			// Bind your variables to replace the ?s
			if (empty($keyword)) {
				$stmt_paging ->bind_param('ss', $from, $offset);
			} else {
				$stmt_paging ->bind_param('sss', $bind_keyword, $from, $offset);
			}
			// Execute query
			$stmt_paging ->execute();
			// store result 
			$stmt_paging ->store_result();
			$stmt_paging->bind_result(
				$data['recipe_id'],
				$data['recipe_title'],
				$data['recipe_image'],
				$data['recipe_time'],
				$data['category_name'],
				$data['video_id'],
				$data['content_type'],
				$data['featured']
			);
			// for paging purpose
			$total_records_paging = $total_records; 
		}

		// if no data on database show "No Reservation is Available"
		if ($total_records_paging == 0) {
	
	?>

    <section class="content">

        <ol class="breadcrumb">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li class="active">Manage Recipes</a></li>
        </ol>

       <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>MANAGE RECIPES</h2>
                            <div class="header-dropdown m-r--5">
                                <a href="add-recipe.php"><button type="button" class="btn bg-blue waves-effect">ADD NEW RECIPE</button></a>
                            </div>
                        </div>

                        <div class="body table-responsive">
	                        
	                        <form method="get">
	                        	<div class="col-sm-10">
									<div class="form-group form-float">
										<div class="form-line">
											<input type="text" class="form-control" name="keyword" placeholder="Search by title...">
										</div>
									</div>
								</div>
								<div class="col-sm-2">
					                <button type="submit" name="btnSearch" class="btn bg-blue btn-circle waves-effect waves-circle waves-float"><i class="material-icons">search</i></button>
								</div>
							</form>
										
							<table class='table table-hover table-striped'>
								<thead>
									<tr>
										<th width="40%">Recipe Name</th>
										<th width="10%">Image</th>
										<th width="10%">Time</th>
										<th width="10%">Category</th>
										<th width="5%">Featured</th>
										<th width="10%"><center>Type</center></th>
										<th width="15%"><center>Action</center></th>
									</tr>
								</thead>

								
							</table>

							<div class="col-sm-10">Wopps! No data found with the keyword you entered.</div>

						</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

	<?php 
		// otherwise, show data
		} else {
			$row_number = $from + 1;
	?>

    <section class="content">

        <ol class="breadcrumb">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li class="active">Manage Recipes</a></li>
        </ol>

       <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>MANAGE RECIPES</h2>
                            <div class="header-dropdown m-r--5">
                                <a href="add-recipe.php"><button type="button" class="btn bg-blue waves-effect">ADD NEW RECIPE</button></a>
                            </div>
                            <br>
                                <?php if(isset($_SESSION['msg'])) { ?>
                                    <div class='alert alert-info'>
                                        <?php echo $_SESSION['msg']; ?>
                                    </div>
                                <?php unset($_SESSION['msg']); }?>
                        </div>

                        <div class="body table-responsive">
	                        
	                        <form method="get">
	                        	<div class="col-sm-10">
									<div class="form-group form-float">
										<div class="form-line">
											<input type="text" class="form-control" name="keyword" placeholder="Search by title...">
										</div>
									</div>
								</div>
								<div class="col-sm-2">
					                <button type="submit" name="btnSearch" class="btn bg-blue btn-circle waves-effect waves-circle waves-float"><i class="material-icons">search</i></button>
								</div>
							</form>
										
							<table class='table table-hover table-striped'>
								<thead>
									<tr>
										<th width="40%">Recipe Name</th>
										<th width="10%">Image</th>
										<th width="10%">Time</th>
										<th width="10%">Category</th>
										<th width="5%">Featured</th>
										<th width="10%"><center>Type</center></th>
										<th width="15%"><center>Action</center></th>
									</tr>
								</thead>

								<?php 
									while ($stmt_paging->fetch()) { ?>
										<tr>
											<td><?php echo $data['recipe_title'];?></td>

							            	<td>
							            		<?php
													if ($data['content_type'] == 'youtube') {			
										      	?>
										      		<img src="https://img.youtube.com/vi/<?php echo $data['video_id'];?>/mqdefault.jpg" height="48px" width="60px"/>
										      	<?php } else { ?>
							            			<img src="upload/<?php echo $data['recipe_image'];?>" height="48px" width="60px"/>
							            		<?php } ?>
							            	</td>

											<td><?php echo $data['recipe_time'];?></td>
											<td><?php echo $data['category_name'];?></td>

							            	<td><center>
							            		<?php if ($data['featured'] == '0') { ?>
							            			<a href="manage-recipe.php?add=<?php echo $data['recipe_id'];?>" onclick="return confirm('Add to featured recipes?')" ><i class="material-icons" style="color:grey">lens</i></a>
							            		<?php } else { ?>
							            			<a href="manage-recipe.php?remove=<?php echo $data['recipe_id'];?>" onclick="return confirm('Remove from featured recipes?')" ><i class="material-icons" style="color:#2196f3">lens</i></a>
							            		<?php } ?>
											</center></td>

											<td><center>
                                                <?php if ($data['content_type'] == 'Post') { ?>
                                                    <span class="label bg-green">RECIPE</span>
                                                 <?php } else { ?>
                                                    <span class="label bg-red">VIDEO</span>
                                                <?php } ?>	
											</center></td>
											<td><center>

						                        <?php if ($setting_row['providers'] == 'onesignal') { ?>
						                        <a href="send-onesignal-recipe-notification.php?id=<?php echo $data['recipe_id'];?>">
						                            <i class="material-icons">notifications_active</i>
						                        </a>
						                        <?php } else { ?>
						                        <a href="send-fcm-recipe-notification.php?id=<?php echo $data['recipe_id'];?>">
						                            <i class="material-icons">notifications_active</i>
						                        </a>
						                        <?php } ?>	

									            <a href="recipe-detail.php?id=<?php echo $data['recipe_id'];?>">
									                <i class="material-icons">launch</i>
									            </a>

									            <a href="edit-recipe.php?id=<?php echo $data['recipe_id'];?>">
									                <i class="material-icons">mode_edit</i>
									            </a>

									            <a href="delete-recipe.php?id=<?php echo $data['recipe_id'];?>" onclick="return confirm('Are you sure want to delete this Recipe?')" >
										            <i class="material-icons">delete</i>
										        </a>
									            
									        </center></td>
										</tr>
								<?php 
									}
								?>
							</table>

							<h4><?php $function->doPages($offset, 'manage-recipe.php', '', $total_records, $keyword); ?></h4>
							<?php 
								}
							?>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </section>