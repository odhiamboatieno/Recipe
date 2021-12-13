<?php include('session.php'); ?>
<?php include("public/menubar.php"); ?>
<link href="assets/css/bootstrap-select.css" rel="stylesheet">
<script src="assets/js/ckeditor/ckeditor.js"></script>

<?php

    include('public/fcm.php');

	$qry = "SELECT * FROM tbl_settings WHERE id = '1'";
	$result = mysqli_query($connect, $qry);
	$settings_row = mysqli_fetch_assoc($result);

    $server_url = (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['REQUEST_URI']);
    $applicationId = $settings_row['package_name'];
    $plain_text = $server_url.'_applicationId_'.$applicationId;
    $__encode = base64_encode($plain_text);
    $_encode = base64_encode($__encode);
    $encode = base64_encode($_encode);

    $_decode = base64_decode($encode);
    $decode = base64_decode($_decode);    

	if(isset($_POST['submit'])) {

	    $sql_query = "SELECT * FROM tbl_settings WHERE id = '1'";
	    $img_res = mysqli_query($connect, $sql_query);
	    $img_row=  mysqli_fetch_assoc($img_res);

	    $data = array(
            'app_fcm_key' => $_POST['app_fcm_key'],
            'api_key' => $_POST['api_key'],
            'package_name' => $_POST['package_name'],
            'fcm_notification_topic' => $_POST['fcm_notification_topic'],
            'onesignal_app_id' => $_POST['onesignal_app_id'],
	        'onesignal_rest_api_key' => $_POST['onesignal_rest_api_key'],
            'providers' => $_POST['providers'],
	        'privacy_policy' => $_POST['privacy_policy'],
            'youtube_api_key' => $_POST['youtube_api_key'],
            'more_apps_url' => $_POST['more_apps_url']

	    );

	    $update_setting = Update('tbl_settings', $data, "WHERE id = '1'");

        if ($update_setting > 0) {
            $_SESSION['msg'] = "Changes saved...";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
	}

?>


    <section class="content">

        <ol class="breadcrumb">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li class="active">Settings</a></li>
        </ol>

       <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    <form method="post" id="form_validation" enctype="multipart/form-data">
                    <div class="card">
                        <div class="header">
                            <h2>SETTINGS</h2>
                            <div class="header-dropdown m-r--5">
                                <button type="submit" name="submit" class="btn bg-blue waves-effect">SAVE SETTINGS</button>
                            </div>
                        </div>
                        <div class="body">

                            <?php if(isset($_SESSION['msg'])) { ?>
                                <div class='alert alert-info corner-radius'>
                                    <?php echo $_SESSION['msg']; ?>
                                </div>
                            <?php unset($_SESSION['msg']); }?>                            

                            <div class="row clearfix">
                            <div class="col-sm-12">

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <div class="font-12"><b>applicationId (Package Name)</b></div>
                                            <input type="text" class="form-control" name="package_name" id="package_name" value="<?php echo $settings_row['package_name'];?>" required>
                                        </div>
                                        <div class="help-info pull-left"><a href="" data-toggle="modal" data-target="#modal-package-name">What is my package name?</a></div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <div class="font-12"><b>Server Key (Auto Generated)</b></div>
                                            <textarea rows="2" class="form-control"><?php echo $encode; ?></textarea>
                                        </div>
                                        <div class="help-info pull-left"><font color="#337ab7">This is an auto generated key depending on your server url and applicationId</font></div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <div class="font-12"><b>Rest API Key</b></div>
                                            <input type="text" class="form-control" name="api_key" id="api_key" value="<?php echo $settings_row['api_key'];?>" required>
                                        </div>
                                        <div class="help-info pull-left"><a href="" data-toggle="modal" data-target="#modal-api-key">Where I have to put my API Key?</a> | <a href="change-api-key.php"><span class="label bg-blue">CHANGE API KEY</span></a></div>
                                    </div>
                                </div>


                                <div class="col-sm-12">
                                    <div class="form-group">
                                            <div class="font-12"><b>Push Notification Provider</b></div>
                                                <select class="form-control show-tick" name="providers" id="providers">
                                                        <?php if ($settings_row['providers'] == 'onesignal') { ?>
                                                            <option value="onesignal" selected="selected">OneSignal</option>
                                                            <option value="firebase">Firebase Cloud Messaging (FCM)</option>
                                                        <?php } else { ?>
                                                            <option value="onesignal">OneSignal</option>
                                                            <option value="firebase" selected="selected">Firebase Cloud Messaging (FCM)</option>
                                                        <?php } ?>
                                                </select>
                                        <div class="help-info pull-left"><font color="#337ab7">Choose your provider for sending push notification</font></div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <div class="font-12"><b>FCM Server Key</b></div>
                                            <input type="text" class="form-control" name="app_fcm_key" id="app_fcm_key" value="<?php echo $settings_row['app_fcm_key'];?>" required>
                                        </div>
                                        <div class="help-info pull-left"><a href="" data-toggle="modal" data-target="#modal-server-key">How to obtain your FCM Server Key?</a></div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <div class="font-12"><b>FCM Notification Topic</b></div>
                                            <input type="text" class="form-control" name="fcm_notification_topic" id="fcm_notification_topic" value="<?php echo $settings_row['fcm_notification_topic'];?>" required>
                                        </div>
                                        <div class="help-info pull-left"><font color="#337ab7">FCM notification topic must be written in lowercase without space (use underscore)</font></div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <div class="font-12"><b>OneSignal APP ID</b></div>
                                            <input type="text" class="form-control" name="onesignal_app_id" id="onesignal_app_id" value="<?php echo $settings_row['onesignal_app_id'];?>" required>
                                        </div>
                                        <div class="help-info pull-left"><a href="" data-toggle="modal" data-target="#modal-onesignal">Where do I get my OneSignal app id?</a></div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <div class="font-12"><b>OneSignal Rest API Key</b></div>
                                            <input type="text" class="form-control" name="onesignal_rest_api_key" id="onesignal_rest_api_key" value="<?php echo $settings_row['onesignal_rest_api_key'];?>" required>
                                        </div>
                                        <div class="help-info pull-left"><a href="" data-toggle="modal" data-target="#modal-onesignal">Where do I get my OneSignal Rest API Key?</a></div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <div class="font-12"><b>YouTube API Key</b></div>
                                            <input type="text" class="form-control" name="youtube_api_key" id="youtube_api_key" value="<?php echo $settings_row['youtube_api_key'];?>" required>
                                        </div>
                                        <div class="help-info pull-left"><a href="" data-toggle="modal" data-target="#modal-youtube-api-key">How to obtain your YouTube API Key?</a></div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <div class="font-12"><b>More Apps Url</b></div>
                                            <input type="text" class="form-control" name="more_apps_url" id="more_apps_url" value="<?php echo $settings_row['more_apps_url'];?>" required>
                                        </div>
                                        <div class="help-info pull-left"><font color="#337ab7">More apps url for your other applications</font></div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    
                                    <div class="form-group">
                                        <div class="form-line">
                                            <div class="font-12 ex1"><b>Privacy Policy</b></div>
                                            <textarea class="form-control" name="privacy_policy" id="privacy_policy" class="form-control" cols="60" rows="10" required><?php echo $settings_row['privacy_policy'];?></textarea>

                                            <?php if ($ENABLE_RTL_MODE == 'true') { ?>
                                            <script>                             
                                                CKEDITOR.replace( 'privacy_policy' );
                                                CKEDITOR.config.contentsLangDirection = 'rtl';
                                            </script>
                                            <?php } else { ?>
                                            <script>                             
                                                CKEDITOR.replace( 'privacy_policy' );
                                                CKEDITOR.config.height = 400; 
                                            </script>
                                            <?php } ?>

                                        </div>
                                    </div>
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


<?php include('public/footer.php'); ?>