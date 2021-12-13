<?php 
		if(isset($_GET['id'])) {
			$ID = $_GET['id'];
		}else{
			$ID = "";
		}
			
		// create array variable to handle error
		$error = array();
			
		// create array variable to store data from database
		$data = array();
		
		// get data from reservation table
		$sql_query = "SELECT * FROM tbl_recipes WHERE recipe_id = ?";
		
		$stmt = $connect->stmt_init();
		if($stmt->prepare($sql_query)) {	
			// Bind your variables to replace the ?s
			$stmt->bind_param('s', $ID);
			// Execute query
			$stmt->execute();
			// store result 
			$stmt->store_result();
			$stmt->bind_result(
					$data['recipe_id'], 
					$data['cat_id'],
					$data['recipe_title'],
					$data['recipe_time'],
					$data['recipe_description'],
					$data['recipe_image'],
					$data['video_url'],
					$data['video_id'],
					$data['content_type'],
					$data['size'],
					$data['featured'],
					$data['tags'],
					$data['total_views'],
					$data['last_update']
					);
			$stmt->fetch();
			$stmt->close();
		}

    if (isset($_GET['delete-recipe'])) {
		        $success =<<<EOF
		            <script>
		                alert('Please remove it from featured before delete this recipe');
		                window.history.go(-1);
		            </script>
EOF;
       			echo $success;
				exit;
    }

			
	?>

	<section class="content">

        <ol class="breadcrumb">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="manage-recipe.php">Manage Recipes</a></li>
            <li class="active">Recipe Detail</a></li>
        </ol>

        <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                	<form method="post">
                	<div class="card">
                        <div class="header">
                            <h2>RECIPE DETAIL</h2>
                            <div class="header-dropdown m-r--5">
								<a href="edit-recipe.php?id=<?php echo $data['recipe_id'];?>"><i class="material-icons">mode_edit</i></a>

								<?php if ($data['featured'] == '0') { ?>
									<a href="delete-recipe.php?id=<?php echo $data['recipe_id'];?>" onclick="return confirm('Are you sure want to delete this Recipe?')" >
										<i class="material-icons">delete</i>
									</a>
								<?php } else { ?>
									<a href="recipe-detail.php?delete-recipe=<?php echo $data['recipe_id'];?>"><i class="material-icons">delete</i></a>
								<?php } ?>
								
                            </div>
                        </div>
                        <div class="body">

                        	<div class="row clearfix">
                        	<div class="form-group form-float col-sm-12">
                        		<p>
									<h4>
										<?php echo $data['recipe_title']; ?>
									</h4>
								</p>
								<p>
									<?php echo $data['recipe_time']; ?> 

								</p>

								<?php if ($data['content_type'] == 'youtube') { ?>
									<p><img style="max-width:40%" src="https://img.youtube.com/vi/<?php echo $data['video_id'];?>/mqdefault.jpg" ></p>
					            <?php } else { ?>
					            	<p><img style="max-width:40%" src="upload/<?php echo $data['recipe_image']; ?>" ></p>
					            <?php } ?>

								<p><?php echo $data['recipe_description']; ?></p>
								
                	</form>

							</div>
                        	</div>
                        </div>
                    </div>

                </div>

            </div>
            
        </div>

    </section>