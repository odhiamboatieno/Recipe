<?php
	include 'functions.php'; 
?>

	<?php

		if (isset($_GET['id'])) {
			$ID = $_GET['id'];
		} else {
			$ID = "";
		}

	    $category_data = array();

	    $sql_query = "SELECT image FROM tbl_fcm_template WHERE id = ?";

	    $stmt_category = $connect->stmt_init();
	    if ($stmt_category->prepare($sql_query)) {
	        // Bind your variables to replace the ?s
	        $stmt_category->bind_param('s', $ID);
	        // Execute query
	        $stmt_category->execute();
	        // store result
	        $stmt_category->store_result();
	        $stmt_category->bind_result($previous_category_image);
	        $stmt_category->fetch();
	        $stmt_category->close();
	    }		
			
		if (isset($_POST['btnEdit'])) {

			$title = $_POST['title'];
			$message = $_POST['message'];
			$link = $_POST['link'];

			$menu_image = $_FILES['category_image']['name'];
        	$image_error = $_FILES['category_image']['error'];
        	$image_type = $_FILES['category_image']['type'];

			// create array variable to handle error
			$error = array();

			if (empty($title)) {
				$error['title'] = " <span class='label label-danger'>Must Insert!</span>";
			}
				
			if (empty($message)) {
				$error['message'] = " <span class='label label-danger'>Must Insert!</span>";
			}

			// common image file extensions
	        $allowedExts = array("gif", "jpeg", "jpg", "png");

	        // get image file extension
	        error_reporting(E_ERROR | E_PARSE);
	        $extension = end(explode(".", $_FILES["category_image"]["name"]));

	        if (!empty($menu_image)) {
	            if (!(($image_type == "image/gif") ||
	                    ($image_type == "image/jpeg") ||
	                    ($image_type == "image/jpg") ||
	                    ($image_type == "image/x-png") ||
	                    ($image_type == "image/png") ||
	                    ($image_type == "image/pjpeg")) &&
	                !(in_array($extension, $allowedExts))
	            ) {

	                $error['category_image'] = " <span class='label label-danger'>Image type must jpg, jpeg, gif, or png!</span>";
	            }
	        }
				
			if (!empty($title) && !empty($message) && empty($error['category_image'])) {

            if (!empty($menu_image)) {

                // create random image file name
                $string = '0123456789';
                $file = preg_replace("/\s+/", "_", $_FILES['category_image']['name']);
                $function = new functions;
                $category_image = $function->get_random_string($string, 4) . "-" . date("Y-m-d") . "." . $extension;

                // delete previous image
                $delete = unlink('upload/notification/' . "$previous_category_image");

                // upload new image
                $upload = move_uploaded_file($_FILES['category_image']['tmp_name'], 'upload/notification/' . $category_image);

                $sql_query = "UPDATE tbl_fcm_template SET title = ?, message = ?, image = ?, link = ? WHERE id = ?";

                $upload_image = $category_image;
                $stmt = $connect->stmt_init();
                if ($stmt->prepare($sql_query)) {
                    // Bind your variables to replace the ?s
                    $stmt->bind_param('sssss', $title, $message, $upload_image, $link, $ID);
                    // Execute query
                    $stmt->execute();
                    // store result
                    $update_result = $stmt->store_result();
                    $stmt->close();
                }

            } else {				
					
				$sql_query = "UPDATE tbl_fcm_template SET title = ?, message = ?, link = ? WHERE id = ?";
					
				$stmt = $connect->stmt_init();
				if($stmt->prepare($sql_query)) {	
					// Bind your variables to replace the ?s
					$stmt->bind_param('ssss', $title, $message, $link, $ID);
					// Execute query
					$stmt->execute();
					// store result 
					$update_result = $stmt->store_result();
					$stmt->close();
				}
			
			}

	            // check update result
	            if ($update_result) {
	                //$error['update_notification'] = "<br><div class='alert alert-info'>Push Notification Template Successfully Updated...</div>";
		            $succes =<<<EOF
					<script>
					alert('Push Notification Template Successfully Updated...');
					window.location = 'push-notification.php';
					</script>
EOF;

					echo $succes;
	            } else {
	                $error['update_notification'] = "<br><div class='alert alert-danger'>Update Failed</div>";
	            }				

			}
				
		}
			
		// create array variable to store previous data
		$data = array();
		
		$sql_query = "SELECT id, title, message, image, link FROM tbl_fcm_template WHERE id = ?";
		
		$stmt = $connect->stmt_init();
		if($stmt->prepare($sql_query)) {	
			// Bind your variables to replace the ?s
			$stmt->bind_param('s', $ID);
			// Execute query
			$stmt->execute();
			// store result 
			$stmt->store_result();
			$stmt->bind_result($data['id'], 
					$data['title'],
					$data['message'],
					$data['image'],
					$data['link']
					);
			$stmt->fetch();
			$stmt->close();
		}
		
	?>

    <section class="content">

        <ol class="breadcrumb">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="push-notification.php">Manage Notification</a></li>
            <li class="active">Edit Notification Template</a></li>
        </ol>

       <div class="container-fluid">

            <div class="row clearfix">
            	
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    <form id="form_validation" method="post" enctype="multipart/form-data">
                    <div class="card">
                        <div class="header">
                            <h2>EDIT NOTIFICATION TEMPLATE</h2>
                                <?php echo isset($error['update_notification']) ? $error['update_notification'] : ''; ?>
                        </div>
                        <div class="body">

                            <div class="row clearfix">
                                
                                <div>
                                	<div class="form-group col-sm-12">
                                        <div class="form-line">
                                            <div class="font-12">Title</div>
                                            <input type="text" class="form-control" name="title" id="title" value="<?php echo $data['title']; ?>" required>
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <div class="form-line">
                                            <div class="font-12">Message</div>
                                            <input type="text" class="form-control" name="message" id="message" value="<?php echo $data['message']; ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                                <input type="file" name="category_image" id="category_image" class="dropify-image" data-max-file-size="2M" data-allowed-file-extensions="jpg jpeg png gif" data-default-file="upload/notification/<?php echo $data['image']; ?>" data-show-remove="false"/>
                                                <div class="div-error"><?php echo isset($error['category_image']) ? $error['category_image'] : '';?></div>
                                        </div>
                                    </div>

                                    <div class="form-group form-float col-sm-12">
                                        <div class="form-line">
                                            <div class="font-12">Url (Optional)</div>
                                            <input type="text" class="form-control" name="link" id="link" placeholder="http://www.your-url.com" value="<?php echo $data['link']; ?>" >
                                        </div>
                                    </div>                           

                                    <div class="col-sm-12">
                                         <button class="btn bg-blue waves-effect pull-right" type="submit" name="btnEdit">UPDATE</button>
                                    </div>

                                   
                                    
                                </div>

                            </div>
                        </div>
                    </div>
                    </form>

                </div>

            </div>
            
        </div>

    </section>