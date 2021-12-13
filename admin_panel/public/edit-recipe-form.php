<?php 
    include 'fcm.php';
	include 'functions.php';
	require 'public/thumbnail_images.class.php';

if(isset($_GET['id'])) {

 		$qry 	= "SELECT * FROM tbl_recipes WHERE recipe_id ='".$_GET['id']."'";
		$result = mysqli_query($connect, $qry);
		$row 	= mysqli_fetch_assoc($result);

		$qry_gallery = "SELECT * FROM tbl_recipes_gallery WHERE recipe_id='".$_GET['id']."'";
		$wall_result = mysqli_query($connect, $qry_gallery);
 	}

	if(isset($_POST['submit'])) {
		$video_id = 'cda11up';
		if($_POST['upload_type'] == 'Upload') {
			if($_FILES['recipe_image']['name'] != '') {
				unlink('upload/'.$_POST['old_image']);
				$recipe_image = time().'_'.$_FILES['recipe_image']['name'];
				$pic2			 = $_FILES['recipe_image']['tmp_name'];
   				$tpath2			 = 'upload/'.$recipe_image;
				copy($pic2, $tpath2);
			} else {
				$recipe_image = $_POST['old_image'];
			}

			if($_FILES['video']['name'] != '') {

				unlink('upload/video'.$_POST['old_video']);
				$video 		= time().'_'.$_FILES['video']['name'];
				$pic1		= $_FILES['video']['tmp_name'];
				$tpath1		= 'upload/video/'.$video;
				copy($pic1, $tpath1);

				$bytes = $_FILES['video']['size'];

				if ($bytes >= 1073741824) {
					$bytes = number_format($bytes / 1073741824, 2) . ' GB';
				} else if ($bytes >= 1048576) {
					$bytes = number_format($bytes / 1048576, 2) . ' MB';
				} else if ($bytes >= 1024) {
					$bytes = number_format($bytes / 1024, 2) . ' KB';
				} else if ($bytes > 1) {
					$bytes = $bytes . ' bytes';
				} else if ($bytes == 1) {
					$bytes = $bytes . ' byte';
				} else {
					$bytes = '0 bytes';
				}
			} else {
			 $bytes = $_POST['old_size'];
			 $video = $_POST['old_video'];
			}

		} else if ($_POST['upload_type']=='Url') {

			if($_FILES['image']['name'] != '') {
				unlink('upload/'.$_POST['old_image']);
				$recipe_image = time().'_'.$_FILES['image']['name'];
				$pic2			 = $_FILES['image']['tmp_name'];
   				$tpath2			 = 'upload/'.$recipe_image;
				copy($pic2, $tpath2);
			} else {
				$recipe_image = $_POST['old_image'];
			}

			$video = $_POST['url_source'];

		} else if ($_POST['upload_type']=='Post') {

			if($_FILES['post_image']['name'] != '') {
				unlink('upload/'.$_POST['old_image']);
				$recipe_image = time().'_'.$_FILES['post_image']['name'];
				$pic2			 = $_FILES['post_image']['tmp_name'];
   				$tpath2			 = 'upload/'.$recipe_image;
				copy($pic2, $tpath2);
			} else {
				$recipe_image = $_POST['old_image'];
			}

			/**
			 * multiple upload
			 */
			$imageNames  = array();
			$imageFiles = functions::reArrayFiles($_FILES['imageoption']);


			foreach ($imageFiles as $imageFile) {
                if ($imageFile['error'] == 0) {
                    $newName = time() . '_' . $imageFile['name'];
                    $img     = $imageFile['tmp_name'];
                    $imgPath = 'upload/' . $newName;
                    copy($img, $imgPath);

                    $imageNames[] = $newName;
                }
			}

			$video = $_POST['url_source'];

		} else {
			$bytes = '';
			$video = $_POST['youtube'];
			$recipe_image = '';
			
			function youtube_id_from_url($url) {

    			$pattern = 
		        '%^# Match any youtube URL
		        (?:https?://)?  # Optional scheme. Either http or https
		        (?:www\.)?      # Optional www subdomain
		        (?:             # Group host alternatives
		          youtu\.be/    # Either youtu.be,
		        | youtube\.com  # or youtube.com
		          (?:           # Group path alternatives
		            /embed/     # Either /embed/
		          | /v/         # or /v/
		          | /watch\?v=  # or /watch\?v=
		          )             # End path alternatives.
		        )               # End host alternatives.
		        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
		        $%x'
		        ;

    			$result = preg_match($pattern, $url, $matches);

			    if (false !== $result) {
			        return $matches[1];
			    }

    			return false;

			}

			$video_id = youtube_id_from_url($_POST['youtube']);

		}
 
			$data = array(											 

				'cat_id'  			=> $_POST['cat_id'],			
				'recipe_title'  		=> addslashes($_POST['recipe_title']),
				'video_url'  		=> $video,									
				'video_id' 			=> $video_id,
				'recipe_image' 		=> $recipe_image,
				'recipe_time' 		=> $_POST['recipe_time'],
                'recipe_description'  => addslashes($_POST['recipe_description']),
				'content_type' 		=> $_POST['upload_type'],
				'size' 				=> $bytes,

			);	

			$hasil = Update('tbl_recipes', $data, "WHERE recipe_id = '".$_POST['id']."'");

			if ($hasil > 0) {
				if (isset($imageNames) && count($imageNames) > 0) {
					global $config;
					$last_id = $_POST['id'];
					$multi_sql = "INSERT INTO tbl_recipes_gallery (recipe_id, image_name) VALUE ";
					foreach ($imageNames as $imageName) {
						$multi_sql .= "('$last_id', '$imageName'),";
					}
					$multi_sql = trim($multi_sql, ',');
					mysqli_query($config, $multi_sql);
				}
			$_SESSION['msg'] = "";
			header( "Location:edit-recipe.php?id=".$_POST['id']);
			exit;
	}


	}

 	$sql_query = "SELECT * FROM tbl_category ORDER BY cid DESC";
	$category_result = mysqli_query($connect, $sql_query);

?>

<script type="text/javascript">

$(document).ready(function(e) {
    $("#upload_type").change(function() {
	var type=$("#upload_type").val();

		if (type == "youtube") {
			$("#video_upload").hide();
			$("#video_post").hide();
			$("#direct_url").hide();
			$("#youtube").show();
		}

		if (type == "Post") {
			$("#youtube").hide();
			$("#video_upload").hide();
			$("#direct_url").hide();
			$("#video_post").show();

			$("#multiple_images").show();
		}

		if (type == "Url") {
			$("#youtube").hide();
			$("#video_upload").hide();
			$("#video_post").hide();
			$("#direct_url").show();
		}

		if (type == "Upload") {
			$("#youtube").hide();
			$("#video_post").hide();
			$("#direct_url").hide();
			$("#video_upload").show();
		}							

	});

	$( window ).load(function() {
		var type=$("#upload_type").val();

			if (type == "youtube")	{
				$("#video_upload").hide();
				$("#direct_url").hide();
				$("#video_post").hide();
				$("#youtube").show();
			}

			if (type == "Url") {
				$("#youtube").hide();
				$("#video_upload").hide();
				$("#video_post").hide();
				$("#direct_url").show();
			}

			if (type == "Upload") {
				$("#youtube").hide();
				$("#direct_url").hide();
				$("#video_post").hide();
				$("#video_upload").show();
			}

			if (type == "Post") {
				$("#youtube").hide();
				$("#direct_url").hide();
				$("#video_upload").hide();
				$("#video_post").show();

				$("#multiple_images").show();
			}

	});

});	

</script>

   <section class="content">
   
        <ol class="breadcrumb">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="manage-recipe.php">Manage Recipes</a></li>
            <li class="active">Edit Recipe</a></li>
        </ol>

       <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                	<form id="form_validation" method="post" enctype="multipart/form-data">
                    <div class="card">
                        <div class="header">
                            <h2>EDIT RECIPE</h2>
                                <?php if(isset($_SESSION['msg'])) { ?>
                                    <br><div class='alert alert-info'>Recipe Successfully Updated...</div>
                                    <?php unset($_SESSION['msg']); } ?>
                        </div>
                        <div class="body">

                        	<div class="row clearfix">
                                
                                <div class="col-sm-5">

                                    <div class="form-group">
                                        <div class="font-12">Recipe Name</div>
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="recipe_title" id="recipe_title" placeholder="Recipe Name" value="<?php echo $row['recipe_title'];?>" required>
                                        </div>
                                    </div>
                                  	
                                    <div class="form-group">
                                        <div class="font-12">Cooking Time</div>
                                        <div class="form-line">
                                            <input type="text" name="recipe_time" id="recipe_time" class="form-control" placeholder="Cooking Time" value="<?php echo $row['recipe_time'];?>" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="font-12">Category</div>
                                        <select class="form-control show-tick" name="cat_id" id="cat_id">
                                           <?php 	
												while($r_c_row = mysqli_fetch_array($category_result)) {
													$sel = '';
													if ($r_c_row['cid'] == $row['cat_id']) {
													$sel = "selected";	
												}	
											?>
										    <option value="<?php echo $r_c_row['cid'];?>" <?php echo $sel; ?>><?php echo $r_c_row['category_name'];?></option>
										                <?php }?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <div class="font-12">Content Type</div>
                                        <select class="form-control show-tick" name="upload_type" id="upload_type">
                                        	<option <?php if($row['content_type'] == 'Post'){echo 'selected';} ?> value="Post">Recipe Post</option>
										    <option <?php if($row['content_type'] == 'youtube'){echo 'selected';} ?> value="youtube">Video Recipe (YouTube)</option>
										    <option <?php if($row['content_type'] == 'Url'){ echo 'selected';} ?> value="Url">Video Recipe (Url)</option>
										    <option <?php if($row['content_type'] == 'Upload'){ echo 'selected';} ?> value="Upload">Video Recipe (Upload)</option>
                                        </select>
                                    </div>

                                    <div id="video_post">

                                    	<div class="font-12 ex1">Image Primary ( jpg / png ) *</div>
                                        <div class="form-group">
                                           <input type="file" name="post_image" id="post_image" class="dropify-image" data-max-file-size="1M" data-allowed-file-extensions="jpg jpeg png gif" data-default-file="upload/<?php echo $row['recipe_image']; ?>" data-show-remove="false"/>
                                                <div class="div-error"><?php echo isset($error['post_image']) ? $error['post_image'] : '';?></div>
                                            <!-- <input type="file" name="post_image" id="post_image" /> -->
                                        </div>

                                        

                                        <div id="multiple_images">
	                                        <div>
		                            			<?php while ($wall_row = mysqli_fetch_array($wall_result)) { ?>
		                                         <img src="upload/<?php echo $wall_row['image_name'];?>" vspace="10" width="40%" alt="image">
		                                         <a href="delete-image.php?id=<?php echo $wall_row['id'];?>" onclick="return confirm('Are you sure want to delete this image?')"><img id="img" src="assets/images/delete.png" alt="delete"></a>
		                                        <?php } ?>
	                                 		</div>

	                                 		<div>
												<div class="font-12 ex1">Image Optional ( jpg / png )</div>
												<div class="form-group">
													<input type="file" name="imageoption[]" id="imageoptions"/>
												</div>
												<div class="multiupload"></div>
												<button type="button" id="addnewUpload" class="btn bg-blue waves-effect">ADD MORE</button>
											</div>
										</div>

                                    </div>
                                    
                                    <div id="youtube">
                                        <div class="form-group">
                                            <div class="font-12">Youtube URL</div>
                                            <div class="form-line">
                                                <input type="url" class="form-control" name="youtube" id="youtube" placeholder="https://www.youtube.com/watch?v=33F5DJw3aiU" value="<?php echo $row['video_url'];?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="direct_url">
                                        <div class="form-group">
                                            <input type="file" name="image" id="image" class="dropify-image" data-max-file-size="1M" data-allowed-file-extensions="jpg jpeg png gif" data-default-file="upload/<?php echo $row['recipe_image'];?>" data-show-remove="false"/>
                                        </div>
                                        <div class="form-group">
                                            <div class="font-12">Video URL</div>
                                            <div class="form-line">
                                                <input type="url" class="form-control" name="url_source" id="url_source" placeholder="http://www.xyz.com/recipe_title.mp4" value="<?php echo $row['video_url'];?>" required/>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="video_upload">
                                        <div class="form-group">
                                            <input type="file" id="recipe_image" name="recipe_image" id="recipe_image" class="dropify-image" data-max-file-size="1M" data-allowed-file-extensions="jpg jpeg png gif" data-default-file="upload/<?php echo $row['recipe_image'];?>" data-show-remove="false" />
                                        </div>

                                        <div class="form-group">
                                            <input type="file" id="video" name="video" id="video" class="dropify-video" data-allowed-file-extensions="3gp mp4 mpg wmv mkv m4v mov flv" data-default-file="upload/<?php echo $row['video_url'];?>" data-show-remove="false" />
                                        </div>
                                    </div>

                                </div>

                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <textarea class="form-control" name="recipe_description" id="recipe_description" class="form-control" cols="60" rows="10" required><?php echo $row['recipe_description'];?></textarea>
                                        <?php if ($ENABLE_RTL_MODE == 'true') { ?>
                                        <script>                             
                                            CKEDITOR.replace( 'recipe_description' );
                                            CKEDITOR.config.contentsLangDirection = 'rtl';
                                        </script>
                                        <?php } else { ?>
                                        <script>                             
                                            CKEDITOR.replace( 'recipe_description' );
                                        </script>
                                        <?php } ?>
                                    </div>

                                    <input type="hidden" name="old_image" value="<?php echo $row['recipe_image'];?>">
									<input type="hidden" name="old_video" value="<?php echo $row['video_url'];?>">
									<input type="hidden" name="old_size" value="<?php echo $row['size'];?>">
									<input type="hidden" name="id" value="<?php echo $row['recipe_id'];?>">

                                    <button type="submit" name="submit" class="btn bg-blue waves-effect pull-right">UPDATE</button>
                                    
                                </div>

                            </div>
                        </div>
                    </div>
                    </form>

                </div>
            </div>
            
        </div>

    </section>