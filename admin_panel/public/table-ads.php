<?php
    
    include('public/fcm.php');

    $qry = "SELECT * FROM tbl_ads WHERE id = '1'";
    $result = mysqli_query($connect, $qry);
    $settings_row = mysqli_fetch_assoc($result);

    if(isset($_POST['submit'])) {

        $data = array(
            'ad_status'                         => $_POST['ad_status'],
            'ad_type'                           => $_POST['ad_type'],
            'admob_publisher_id'                => $_POST['admob_publisher_id'],
            'admob_app_id'                      => $_POST['admob_app_id'],
            'admob_banner_unit_id'              => $_POST['admob_banner_unit_id'],
            'admob_interstitial_unit_id'        => $_POST['admob_interstitial_unit_id'],
            'admob_native_unit_id'              => $_POST['admob_native_unit_id'],
            'admob_app_open_ad_unit_id'         => $_POST['admob_app_open_ad_unit_id'],
            'fan_banner_unit_id'                => $_POST['fan_banner_unit_id'],     
            'fan_interstitial_unit_id'          => $_POST['fan_interstitial_unit_id'],
            'fan_native_unit_id'                => $_POST['fan_native_unit_id'],
            'startapp_app_id'                   => $_POST['startapp_app_id'],
            'unity_game_id'                     => $_POST['unity_game_id'],
            'unity_banner_placement_id'         => $_POST['unity_banner_placement_id'],
            'unity_interstitial_placement_id'   => $_POST['unity_interstitial_placement_id'],
            'applovin_banner_ad_unit_id'        => $_POST['applovin_banner_ad_unit_id'],
            'applovin_interstitial_ad_unit_id'  => $_POST['applovin_interstitial_ad_unit_id'],
            'mopub_banner_ad_unit_id'           => $_POST['mopub_banner_ad_unit_id'],
            'mopub_interstitial_ad_unit_id'     => $_POST['mopub_interstitial_ad_unit_id'],
            'interstitial_ad_interval'          => $_POST['interstitial_ad_interval'],
            'native_ad_interval'                => $_POST['native_ad_interval'],
            'native_ad_index'                   => $_POST['native_ad_index']
        );

        $update = Update('tbl_ads', $data, "WHERE id = '1'");

        if ($update > 0) {
            $_SESSION['msg'] = "Changes saved...";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }

?>


<script type="text/javascript">

    $(document).ready(function(e) {

        $("#ad_status").change(function() {
            var status = $("#ad_status").val();
            if (status == "on") {
                $("#ad_status_on").show();
            } else {
                $("#ad_status_on").hide();
            }
                    
        });

        $( window ).load(function() {
            var status = $("#ad_status").val();
            if (status == "on") {
                $("#ad_status_on").show();
            } else {
                $("#ad_status_on").hide();
            }
        });

        $("#ad_type").change(function() {
            var type = $("#ad_type").val();
            if (type == "admob") {
                $("#admob_ad_network").show();
                $("#fan_ad_network").hide();
                $("#startapp_ad_network").hide();
                $("#unity_ad_network").hide();
                $("#applovin_ad_network").hide();
                $("#mopub_ad_network").hide();
            }
            if (type == "fan") {
                $("#admob_ad_network").hide();
                $("#fan_ad_network").show();
                $("#startapp_ad_network").hide();
                $("#unity_ad_network").hide();
                $("#applovin_ad_network").hide();
                $("#mopub_ad_network").hide();
            }
            if (type == "startapp") {
                $("#admob_ad_network").hide();
                $("#fan_ad_network").hide();
                $("#startapp_ad_network").show();
                $("#unity_ad_network").hide();
                $("#applovin_ad_network").hide();
                $("#mopub_ad_network").hide();
            }
            if (type == "unity") {
                $("#admob_ad_network").hide();
                $("#fan_ad_network").hide();
                $("#startapp_ad_network").hide();
                $("#unity_ad_network").show();
                $("#applovin_ad_network").hide();
                $("#mopub_ad_network").hide();
            }
            if (type == "applovin") {
                $("#admob_ad_network").hide();
                $("#fan_ad_network").hide();
                $("#startapp_ad_network").hide();
                $("#unity_ad_network").hide();
                $("#applovin_ad_network").show();
                $("#mopub_ad_network").hide();
            }
            if (type == "mopub") {
                $("#admob_ad_network").hide();
                $("#fan_ad_network").hide();
                $("#startapp_ad_network").hide();
                $("#unity_ad_network").hide();
                $("#applovin_ad_network").hide();
                $("#mopub_ad_network").show();
            }
        });

        $( window ).load(function() {
            var type = $("#ad_type").val();
            if (type == "admob") {
                $("#admob_ad_network").show();
                $("#fan_ad_network").hide();
                $("#startapp_ad_network").hide();
                $("#unity_ad_network").hide();
                $("#applovin_ad_network").hide();
                $("#mopub_ad_network").hide();
            }
            if (type == "fan") {
                $("#admob_ad_network").hide();
                $("#fan_ad_network").show();
                $("#startapp_ad_network").hide();
                $("#unity_ad_network").hide();
                $("#applovin_ad_network").hide();
                $("#mopub_ad_network").hide();
            }
            if (type == "startapp") {
                $("#admob_ad_network").hide();
                $("#fan_ad_network").hide();
                $("#startapp_ad_network").show();
                $("#unity_ad_network").hide();
                $("#applovin_ad_network").hide();
                $("#mopub_ad_network").hide();
            }
            if (type == "unity") {
                $("#admob_ad_network").hide();
                $("#fan_ad_network").hide();
                $("#startapp_ad_network").hide();
                $("#unity_ad_network").show();
                $("#applovin_ad_network").hide();
                $("#mopub_ad_network").hide();
            }
            if (type == "applovin") {
                $("#admob_ad_network").hide();
                $("#fan_ad_network").hide();
                $("#startapp_ad_network").hide();
                $("#unity_ad_network").hide();
                $("#applovin_ad_network").show();
                $("#mopub_ad_network").hide();
            }
            if (type == "mopub") {
                $("#admob_ad_network").hide();
                $("#fan_ad_network").hide();
                $("#startapp_ad_network").hide();
                $("#unity_ad_network").hide();
                $("#applovin_ad_network").hide();
                $("#mopub_ad_network").show();
            }
        });

    });

</script>

<section class="content">

    <ol class="breadcrumb breadcrumb-offset">
        <li><a href="dashboard.php">Dashboard</a></li>
        <li class="active">Manage Ads</a></li>
    </ol>

    <div class="container-fluid">

        <div class="row clearfix">

            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">

                <form method="post" enctype="multipart/form-data">

                    <div class="card corner-radius">
                        <div class="header">
                            <h2>MANAGE ADS</h2>
                            <div class="header-dropdown m-r--5">
                                <button type="submit" name="submit" class="btn bg-blue waves-effect">UPDATE</button>
                            </div>
                        </div>

                        <div class="body body-offset">

                            <?php if(isset($_SESSION['msg'])) { ?>
                                <div class='alert alert-info corner-radius'>
                                    <?php echo $_SESSION['msg']; ?>
                                </div>
                            <?php unset($_SESSION['msg']); }?>

                            <div class="row clearfix">

                                <div class="">

                                    <div class="form-group">
                                        <div style="padding-left: 15px; padding-right: 15px;">
                                            <div class="font-12">Ad Status</div>
                                            <select class="form-control show-tick" name="ad_status" id="ad_status">
                                                <?php if ($settings_row['ad_status'] == 'on') { ?>
                                                <option value="on" selected="selected">ON</option>
                                                <option value="off">OFF</option>
                                                <?php } else { ?>
                                                <option value="on">ON</option>
                                                <option value="off" selected="selected">OFF</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div id="ad_status_on">

                                        <div class="form-group">
                                            <div style="padding-left: 15px; padding-right: 15px;">
                                                <div class="font-12">Ad Network Type</div>
                                                <select class="form-control show-tick" name="ad_type" id="ad_type">
                                                <?php if ($settings_row['ad_type'] == 'admob') { ?>
                                                    <option value="admob" selected="selected">AdMob</option>
                                                    <option value="fan">Audience Network (Deprecated)</option>
                                                    <option value="startapp">StartApp</option>
                                                    <option value="unity">Unity Ads</option>
                                                    <option value="applovin">AppLovin's MAX</option>
                                                    <option value="mopub">Mopub</option>
                                                <?php } else if ($settings_row['ad_type'] == 'fan') { ?>
                                                    <option value="admob">AdMob</option>
                                                    <option value="fan" selected="selected">Audience Network (Deprecated)</option>
                                                    <option value="startapp">StartApp</option>
                                                    <option value="unity">Unity Ads</option>
                                                    <option value="applovin">AppLovin's MAX</option>
                                                    <option value="mopub">Mopub</option>
                                                <?php } else if ($settings_row['ad_type'] == 'startapp') { ?>
                                                    <option value="admob">AdMob</option>
                                                    <option value="fan">Audience Network (Deprecated)</option>
                                                    <option value="startapp" selected="selected">StartApp</option>
                                                    <option value="unity">Unity Ads</option>
                                                    <option value="applovin">AppLovin's MAX</option>
                                                    <option value="mopub">Mopub</option>
                                                <?php } else if ($settings_row['ad_type'] == 'unity') { ?>
                                                    <option value="admob">AdMob</option>
                                                    <option value="fan">Audience Network (Deprecated)</option>
                                                    <option value="startapp">StartApp</option>
                                                    <option value="unity" selected="selected">Unity Ads</option>
                                                    <option value="applovin">AppLovin's MAX</option>
                                                    <option value="mopub">Mopub</option>
                                                <?php } else if ($settings_row['ad_type'] == 'applovin') { ?>
                                                    <option value="admob">AdMob</option>
                                                    <option value="fan">Audience Network (Deprecated)</option>
                                                    <option value="startapp">StartApp</option>
                                                    <option value="unity">Unity Ads</option>
                                                    <option value="applovin" selected="selected">AppLovin's MAX</option>
                                                    <option value="mopub">Mopub</option>
                                                <?php } else if ($settings_row['ad_type'] == 'mopub') { ?>
                                                    <option value="admob">AdMob</option>
                                                    <option value="fan">Audience Network (Deprecated)</option>
                                                    <option value="startapp">StartApp</option>
                                                    <option value="unity">Unity Ads</option>
                                                    <option value="applovin">AppLovin's MAX</option>
                                                    <option value="mopub" selected="selected">Mopub</option>
                                                <?php } ?>
                                            </select>
                                            </div>
                                        </div>

                                        <div id="admob_ad_network">

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="form-line">
                                                        <div class="font-12">AdMob Publisher ID</div>
                                                        <input type="text" class="form-control" name="admob_publisher_id" id="admob_publisher_id" value="<?php echo $settings_row['admob_publisher_id'];?>" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                        <div class="font-12">AdMob App ID</div>
                                                        <div class="ex2">Important : Your <b>AdMob App ID</b> must be added programmatically inside Android Studio Project in the <b>res/value/ads.xml</b></div>
                                                        <a href="" data-toggle="modal" data-target="#modal-admob-app-id"><button class="btn bg-blue waves-effect" style="margin-top: 5px;">VIEW IMPLEMENTATION</button></a>
                                                        <input type="hidden" class="form-control" name="admob_app_id" id="admob_app_id" value="<?php echo $settings_row['admob_app_id'];?>" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="form-line">
                                                        <div class="font-12">AdMob Banner Unit ID</div>
                                                        <input type="text" class="form-control" name="admob_banner_unit_id" id="admob_banner_unit_id" value="<?php echo $settings_row['admob_banner_unit_id'];?>" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="form-line">
                                                        <div class="font-12">AdMob Interstitial Unit ID</div>
                                                        <input type="text" class="form-control" name="admob_interstitial_unit_id" id="admob_interstitial_unit_id" value="<?php echo $settings_row['admob_interstitial_unit_id'];?>" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="form-line">
                                                        <div class="font-12">AdMob Native Unit ID</div>
                                                        <input type="text" class="form-control" name="admob_native_unit_id" id="admob_native_unit_id" value="<?php echo $settings_row['admob_native_unit_id'];?>" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="form-line">
                                                        <div class="font-12">AdMob App Open Ads Unit ID</div>
                                                        <input type="text" class="form-control" name="admob_app_open_ad_unit_id" id="admob_app_open_ad_unit_id" value="<?php echo $settings_row['admob_app_open_ad_unit_id'];?>" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div id="fan_ad_network">

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="form-line">
                                                        <div class="font-12">FAN Banner Unit ID</div>
                                                        <input type="text" class="form-control" name="fan_banner_unit_id" id="fan_banner_unit_id" value="<?php echo $settings_row['fan_banner_unit_id'];?>" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="form-line">
                                                        <div class="font-12">FAN Interstitial Unit ID</div>
                                                        <input type="text" class="form-control" name="fan_interstitial_unit_id" id="fan_interstitial_unit_id" value="<?php echo $settings_row['fan_interstitial_unit_id'];?>" required>
                                                    </div>
                                                </div>
                                                
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="form-line">
                                                        <div class="font-12">FAN Native Unit ID</div>
                                                        <input type="text" class="form-control" name="fan_native_unit_id" id="fan_native_unit_id" value="<?php echo $settings_row['fan_native_unit_id'];?>" required>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                        <div id="startapp_ad_network">

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="form-line">
                                                        <div class="font-12">StartApp App ID</div>
                                                        <input type="text" class="form-control" name="startapp_app_id" id="startapp_app_id" value="<?php echo $settings_row['startapp_app_id'];?>" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div id="unity_ad_network">

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="form-line">
                                                        <div class="font-12">Unity Game ID</div>
                                                        <input type="text" class="form-control" name="unity_game_id" id="unity_game_id" value="<?php echo $settings_row['unity_game_id'];?>" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="form-line">
                                                        <div class="font-12">Unity Banner Placement ID</div>
                                                        <input type="text" class="form-control" name="unity_banner_placement_id" id="unity_banner_placement_id" value="<?php echo $settings_row['unity_banner_placement_id'];?>" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="form-line">
                                                        <div class="font-12">Unity Interstitial Placement ID</div>
                                                        <input type="text" class="form-control" name="unity_interstitial_placement_id" id="unity_interstitial_placement_id" value="<?php echo $settings_row['unity_interstitial_placement_id'];?>" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div id="applovin_ad_network">

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                        <div class="font-12">AppLovin SDK Key</div>
                                                        <div class="ex2">Important : Your <b>AppLovin SDK Key</b> must be added programmatically inside Android Studio Project in the <b>res/value/ads.xml</b></div>
                                                        <a href="" data-toggle="modal" data-target="#modal-applovin-sdk-key"><button class="btn bg-blue waves-effect" style="margin-top: 5px;">VIEW IMPLEMENTATION</button></a>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="form-line">
                                                        <div class="font-12">AppLovin Banner Ad ID</div>
                                                        <input type="text" class="form-control" name="applovin_banner_ad_unit_id" id="applovin_banner_ad_unit_id" value="<?php echo $settings_row['applovin_banner_ad_unit_id'];?>" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="form-line">
                                                        <div class="font-12">AppLovin Interstitial Ad ID</div>
                                                        <input type="text" class="form-control" name="applovin_interstitial_ad_unit_id" id="applovin_interstitial_ad_unit_id" value="<?php echo $settings_row['applovin_interstitial_ad_unit_id'];?>" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div id="mopub_ad_network">

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="form-line">
                                                        <div class="font-12">Mopub Banner Ad Unit ID</div>
                                                        <input type="text" class="form-control" name="mopub_banner_ad_unit_id" id="mopub_banner_ad_unit_id" value="<?php echo $settings_row['mopub_banner_ad_unit_id'];?>" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="form-line">
                                                        <div class="font-12">Mopub Interstitial Ad Unit ID</div>
                                                        <input type="text" class="form-control" name="mopub_interstitial_ad_unit_id" id="mopub_interstitial_ad_unit_id" value="<?php echo $settings_row['mopub_interstitial_ad_unit_id'];?>" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="form-line">
                                                        <div class="font-12">Interstitial Ad Interval</div>
                                                        <input type="number" class="form-control" name="interstitial_ad_interval" id="interstitial_ad_interval" value="<?php echo $settings_row['interstitial_ad_interval'];?>" required>
                                                    </div>
                                                </div>    
                                            </div>

                                            <input type="hidden" class="form-control" name="native_ad_interval" id="native_ad_interval" value="<?php echo $settings_row['native_ad_interval'];?>" required>

                                            <input type="hidden" class="form-control" name="native_ad_index" id="native_ad_index" value="<?php echo $settings_row['native_ad_index'];?>" required>                

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">

                <div class="card corner-radius">
                    <div class="header">
                        <h2>ANNOUNCEMENT</h2>
                    </div>

                    <div class="body body-offset">

                        <div class="row clearfix" style="padding-right: 10px;">

                            <ol>
                                <li><b>Facebook Audience Network</b> will only use bidding for Android apps starting September 30, 2021. Placement ID from Waterfall are <b>deprecated</b> now. So, put Audience Network placement ID from admin panel is no longer used, you need to setup for Bidding with Partner Mediation.</li>
                                <br>

                                <li>If you choose to use <b>Facebook Audience Network</b> Open Bidding, please select <b>Ad Network Type</b> to be <b>AdMob</b>, <b>AppLovin</b> or <b>Mopub</b>, These Ad Networks support being a Mediation Partner although it's still a Beta version.</li>
                                <br>

                                <li><b>AdMob</b> as a Bidding Mediation Partner for Audience Network :
                                    <br>* The official documentation can be seen <a href="https://developers.facebook.com/docs/audience-network/bidding/partner-mediation/admob" target="_blank"><b>Here</b></a>
                                    <br>* See AdMob's guidance on how to set up for <a href="https://developers.google.com/admob/android/mediation/facebook?fbclid=IwAR3E_IRcUqQmTjqdW_3dq6vPbodTQqUtQgmk_lCgjizr8T1MR7Bh1Qa1Oic" target="_blank"><b>Android</b></a> (Step 1 & 2)
                                </li>
                                <br>

                                <li><b>AppLovin</b> as a Bidding Mediation Partner for Audience Network :
                                    <br>* The official documentation can be seen <a href="https://developers.facebook.com/docs/audience-network/bidding/partner-mediation/max" target="_blank"><b>Here</b></a>
                                    <br>* See AdMob's guidance on how to set up for <a href="https://dash.applovin.com/documentation/mediation/android/mediation-setup/facebook" target="_blank"><b>Android</b></a>
                                </li>
                                <br>


                                <li><b>Mopub</b> as a Bidding Mediation Partner for Audience Network :
                                    <br>* The official documentation can be seen <a href="https://developers.facebook.com/docs/audience-network/bidding/partner-mediation/mopub" target="_blank"><b>Here</b></a>
                                </li>
                                <br>

                                <li>Supported Ad Formats :
                                    <br>* <b>AdMob</b> : Banner, Interstitial, Native, App Open
                                    <br>* <b>StartApp</b> : Banner, Interstitial, Native
                                    <br>* <b>Unity Ads</b> : Banner, Interstitial
                                    <br>* <b>AppLovin'S MAX</b> : Banner, Interstitial
                                    <br>* <b>Mopub</b> : Banner, Interstitial
                                    <br>* <b>Audience Network</b> : Open Bidding with AdMob, AppLovin's MAX or Mopub as mediation partner 
                                </li>

                            </ol>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>