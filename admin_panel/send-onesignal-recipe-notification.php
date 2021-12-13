<?php include('session.php'); ?>
<?php include('public/menubar.php'); ?>
<style>
div.ex1 {
    margin-bottom: 8px;
}
</style>

<?php

  if (isset($_GET['id'])) {
    $ID = $_GET['id'];
  } else {
    $ID = "";
  }
      
  // create array variable to handle error
  $error = array();
      
  $sql    = "SELECT r.*, c.category_name FROM tbl_recipes r, tbl_category c WHERE r.cat_id = c.cid AND r.recipe_id = $ID";
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
        $post_id = $_POST['post_id'];
        $link = $_POST['link'];
        $unique_id = rand(1000, 9999);

        if ($data['content_type'] == 'youtube') {
          $big_image = 'https://img.youtube.com/vi/'.$data['video_id'].'/mqdefault.jpg';
        } else {
            if ($server_name == 'localhost') {
                $big_image = $localhost_link.'/upload/'.$data['recipe_image'];
            } else {
                $big_image = $actual_link.'/upload/'.$data['recipe_image'];
            } 
        }

        $content = array("en" => $message);

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
        header("Location:manage-recipe.php");
        exit; 

  }
  
?>

  <section class="content">

        <ol class="breadcrumb">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="manage-recipe.php">Manage Recipes</a></li>
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

                              <input type="hidden" name="post_id" id="post_id" value="<?php echo $data['recipe_id']; ?>" />
                              <input type="hidden" name="link" id="link" value="" />

                              <div class="form-group col-sm-12">
                                  <div class="font-12">Title *</div>
                                  <div class="form-line">
                                      <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="<?php echo $data['category_name']; ?>" required>
                                  </div>
                              </div>

                              <div class="form-group col-sm-12">
                                  <div class="font-12">Message *</div>
                                  <div class="form-line">
                                      <input type="text" class="form-control" name="message" id="message" placeholder="Message" value="<?php echo $data['recipe_title']; ?>" required>
                                  </div>
                              </div>

                              <div class="col-sm-6">
                                <div class="font-12 ex1">Image *</div>
                                        <div class="form-group">
                                          <?php if ($data['content_type'] == 'youtube') { ?>
                                            <input type="file" class="dropify-image" data-max-file-size="1M" data-allowed-file-extensions="jpg jpeg png gif" data-default-file="https://img.youtube.com/vi/<?php echo $data['video_id'];?>/mqdefault.jpg" data-show-remove="false" disabled/>
                                          <?php } else { ?>
                                              <input type="file" class="dropify-image" data-max-file-size="1M" data-allowed-file-extensions="jpg jpeg png gif" data-default-file="upload/<?php echo $data['recipe_image']; ?>" data-show-remove="false" disabled/>
                                          <?php } ?>
                                        </div>
                                    </div>

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