<?php include('session.php'); ?>
<?php include('public/menubar.php'); ?>

<?php 
	if (isset($_GET['id'])) {
		$ID = $_GET['id'];
	} else {
		$ID = "";
	}
			
	// create array variable to handle error
	$error = array();

  $sql    = "SELECT * FROM tbl_fcm_template WHERE id = $ID";
  $result = mysqli_query($connect, $sql);
  $data   = mysqli_fetch_assoc($result);
			
  $setting_qry    = "SELECT * FROM tbl_settings WHERE id = '1'";
  $setting_result = mysqli_query($connect, $setting_qry);
  $settings_row   = mysqli_fetch_assoc($setting_result);

  $onesignal_app_id = $settings_row['onesignal_app_id']; 
  $onesignal_rest_api_key = $settings_row['onesignal_rest_api_key'];

  $protocol = (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://';
  $server_name = $_SERVER['SERVER_NAME'];

  $localhost_link = $protocol."10.0.2.2".dirname($_SERVER['REQUEST_URI']);
  $actual_link =  $protocol.$_SERVER['SERVER_NAME'].dirname($_SERVER['REQUEST_URI']);
 

  if (isset($_POST['submit'])) {

        $title = $_POST["title"];
        $message = $_POST["message"];
        $image = $_POST["image"];
        $post_id = $_POST['post_id'];
        $link = $_POST['link'];
        $unique_id = rand(1000, 9999);

        if ($server_name == 'localhost') {
            $big_image = $localhost_link.'/upload/notification/'.$image;  
        } else {
            $big_image = $actual_link.'/upload/notification/'.$image;  
        }

        $content = array("en" =>  $message);

        $fields = array(
          'app_id' => $onesignal_app_id,
          'included_segments' => array('All'),                                            
          'data' => array(
            "foo" => "bar",
            "link" => $link,
            "post_id" => $post_id,
            "unique_id" => $unique_id
          ),
          'headings'=> array("en" => $title),
          'contents' => $content,
          'big_picture' => $big_image         
        );

        $fields = json_encode($fields);
        print("\nJSON sent:\n");
        print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                   'Authorization: Basic '.$onesignal_rest_api_key));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);        
        
        $_SESSION['msg'] = "Congratulations, push notification sent...";
        header("Location:push-notification.php");
        exit; 

  }
  
?>

	<section class="content">

        <ol class="breadcrumb">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="push-notification.php">Manage Notification</a></li>
            <li class="active">Send Notification</a></li>
        </ol>

        <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                	<form method="post" enctype="multipart/form-data">
	                	<div class="card">
	                        <div class="header">
	                            <h2>SEND NOTIFICATION</h2>
	                        </div>
	                        <div class="body">

	                        	<div class="row clearfix">

			                        <div class="form-group col-sm-12">
			                            <div class="font-12">Title *</div>
			                            <div class="form-line">
			                                <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="<?php echo $data['title']; ?>" required>
			                            </div>
			                       	</div>

			                       	<div class="form-group col-sm-12">
			                            <div class="font-12">Message *</div>
			                            <div class="form-line">
			                                <input type="text" class="form-control" name="message" id="message" placeholder="Message" value="<?php echo $data['message']; ?>" required>
			                            </div>
			                       	</div>

			                       	<div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="file" class="dropify-image" data-max-file-size="1M" data-allowed-file-extensions="jpg jpeg png gif" data-default-file="upload/notification/<?php echo $data['image']; ?>" data-show-remove="false" disabled/>
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-12">
			                            <div class="font-12">Url (Optional)</div>
			                            <div class="form-line">
			                                <input type="text" class="form-control" name="link" id="link" placeholder="http://www.google.com" value="<?php echo $data['link']; ?>" >
			                            </div>
			                       	</div>
                              <input type="hidden" name="post_id" id="post_id" value="0" />
			                       	<input type="hidden" name="image" id="image" value="<?php echo $data['image']; ?>" />

                                    <div class="col-sm-12">
                                		<button class="btn bg-blue waves-effect pull-right" type="submit" name="submit">SEND NOW</button>
                            		</div>
										
		                       	</div>
		                    </div>
		                </div>
                	</form>
                </div>
            </div>
        </div>

    </section>

<?php include('public/footer.php'); ?>