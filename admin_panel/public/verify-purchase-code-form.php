<?php include 'includes/config.php' ?>
<?php include 'language.php' ?>
<?php include 'functions.php' ?>
<?php include 'fcm.php'; ?>
<?php include 'variables.php' ?>

<!DOCTYPE html>
<html>
 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo $app_name; ?></title>
    <!-- Favicon-->
    <link rel="icon" href="assets/images/favicon.png" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="assets/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="assets/plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="assets/plugins/morrisjs/morris.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- Wait Me Css -->
    <link href="assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" />

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="assets/css/theme.css" rel="stylesheet" />

    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="assets/css/time-picker.css" rel="stylesheet" />

     <!-- JQuery DataTable Css -->
    <link href="assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    

    <link href="assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
    <!-- Latest compiled and minified CSS -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css"> -->

    <!-- Sweetalert Css -->
    <link href="assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" />
       <!-- Light Gallery Plugin Css -->
    <link href="assets/plugins/light-gallery/css/lightgallery.css" rel="stylesheet">

    <link href="assets/css/sticky-footer.css" rel="stylesheet">

    <link href="assets/css/dropify.css" type="text/css" rel="stylesheet">

    <?php if ($ENABLE_RTL_MODE == 'true') { ?>
    <link href="assets/css/rtl.css" rel="stylesheet">
    <?php } ?>

   <script type="text/javascript">
  tinymce.init({
    selector: '#tinymce',
    fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
    theme: "modern",
    menubar: false,
    plugins: [
            'advlist autolink lists charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime nonbreaking save directionality',
            'emoticons template paste textcolor colorpicker textpattern', 'link image'
        ],
        toolbar1: 'insertfile undo redo | forecolor backcolor | bold italic fontselect fontsizeselect  | alignleft aligncenter alignright alignjustify | outdent indent | media link | image',
        
        image_advtab: true, file_browser_callback: RoxyFileBrowser


  });

  function RoxyFileBrowser(field_name, url, type, win) {
              var roxyFileman = 'fileman/index.html';
              if (roxyFileman.indexOf("?") < 0) {     
                roxyFileman += "?type=" + type;   
              }
              else {
                roxyFileman += "&type=" + type;
              }
              roxyFileman += '&input=' + field_name + '&value=' + win.document.getElementById(field_name).value;
              if(tinyMCE.activeEditor.settings.language){
                roxyFileman += '&langCode=' + tinyMCE.activeEditor.settings.language;
              }
              tinyMCE.activeEditor.windowManager.open({
                 file: roxyFileman,
                 title: 'Image Upload',
                 width: 850, 
                 height: 650,
                 resizable: "yes",
                 plugins: "media",
                 inline: "yes",
                 close_previous: "no"  
              }, {     window: win,     input: field_name    });
              return false; 
            }
  </script>

<style>
    div.uppercase {
        text-transform: uppercase;
    }
</style> 
        
</head>

<?php

    $error = false;

    if (isset($_POST['submit'])) {

        $data = array(
            'purchase_code' => $_POST['edt_purchase_code'],
            'item_id'       => $_POST['edt_item_id'],
            'item_name'     => $_POST['edt_item_name'],
            'buyer'         => $_POST['edt_buyer'],
            'license_type'  => $_POST['edt_license'],
            'purchase_date' => $_POST['edt_purchase_date']
            );

        $qry = Insert('tbl_license', $data);

        $succes =<<<EOF
            <script>
                alert('Thank you..');
                window.location = 'dashboard.php';
            </script>
EOF;
        echo $succes;

    }

    if (isset($_POST['verify'])) {

        $product_code = $_POST['item_purchase_code'];

        $url = "https://api.envato.com/v3/market/author/sale?code=".$product_code;
        $curl = curl_init($url);

        $header = array();
        $header[] = 'Authorization: Bearer '.$var_personal_token;
        $header[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.11; rv:41.0) Gecko/20100101 Firefox/41.0';
        $header[] = 'timeout: 20';
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER,$header);

        $envatoRes = curl_exec($curl);
        curl_close($curl);
        $envatoRes = json_decode($envatoRes);

        if (isset($envatoRes->item->name)) {
            $data = array(
                'item_id' => $envatoRes->item->id,
                'item_name' => $envatoRes->item->name,
                'buyer' => $envatoRes->buyer,
                'license' => $envatoRes->license,
                'purchase_date' => $envatoRes->sold_at,
                'purchase_count' => $envatoRes->purchase_count
            );

            if ($data['item_id'] != $var_item_id) {
                  $result['msg'] = '<div class="alert alert-danger">Whoops! The purchase code provided is for a different item!</div>';
            } else {
                $result['msg'] = '<div class="alert alert-success">License Found!</div>';
                $result['start'] = '<br><table class="table table-hover">';
                $result['purchase_code'] = '<tr><td>Purchase Code</td><td>:</td><td>'.$product_code.'</td>';
                $result['item_id'] = '<tr><td>Item ID</td><td>:</td><td>'.$data['item_id'].'</td>';
                $result['item_name'] = '<tr><td>Item Name</td><td>:</td><td>'.$data['item_name'].'</td>';
                $result['buyer'] = '<tr><td>Buyer</td><td>:</td><td>'.$data['buyer'].'</td>';
                $result['license'] = '<tr><td>License</td><td>:</td><td>'.$data['license'].'</td>';
                $result['purchase_date'] = '<tr><td>Purchase Date</td><td>:</td><td>'.$data['purchase_date'].'</td>';
                $result['purchase_count'] = '<tr><td>Purchase Count</td><td>:</td><td>'.$data['purchase_count'].'</td>';
                $result['end'] = '</table>';

                $result['edt_purchase_code'] = $product_code;
                $result['edt_item_id'] = $data['item_id'];
                $result['edt_item_name'] = $data['item_name'];
                $result['edt_buyer'] = $data['buyer'];
                $result['edt_license'] = $data['license'];
                $result['edt_purchase_date'] = $data['purchase_date'];
                $result['show_button'] = '<button type="submit" name="submit" class="btn bg-blue btn-block btn-lg waves-effect">SUBMIT</button>';
            }
        } else { 
            $result['msg'] = '<div class="alert alert-danger">Whoops! Invalid purchase code!</div>';
        }

    }    

?>

<body class="theme-blue">
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="verify-purchase-code.php"><div class="uppercase"><?php echo $app_name; ?></div></a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="logout.php"><i class="material-icons">power_settings_new</i>Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section class="container">
        <br><br><br><br><br>
        <br><br><br>
        <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    <div class="card">
                        <?php echo isset($result['msg']) ? $result['msg'] : '';?>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                <center>

                                    <form method="post" id="form_validation">
                                        <div>
                                            <h4><img src="assets/images/ic_envato.png" width="24" height="24"> Please Verify your Purchase Code to Continue Using Admin Panel.</h4>
                                                <hr>
                                                <br>
                                        </div>
                                        <div class="col-sm-10">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="item_purchase_code" id="item_purchase_code" placeholder="Your item purchase code here" value="" required>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="col-sm-2">
                                        <button type="submit" name="verify" class="btn bg-blue btn-circle waves-effect waves-circle waves-float"><i class="material-icons">search</i></button>
                                        </div>
                                    </form>

                                    <?php echo isset($result['start']) ? $result['start'] : ''; ?>
                                    <?php echo isset($result['purchase_code']) ? $result['purchase_code'] : ''; ?>
                                    <?php echo isset($result['item_id']) ? $result['item_id'] : ''; ?>
                                    <?php echo isset($result['item_name']) ? $result['item_name'] : ''; ?>
                                    <?php echo isset($result['buyer']) ? $result['buyer'] : ''; ?>
                                    <?php echo isset($result['license']) ? $result['license'] : ''; ?>
                                    <?php echo isset($result['purchase_date']) ? $result['purchase_date'] : ''; ?>
                                    <?php echo isset($result['end']) ? $result['end'] : ''; ?>

                                    <form method="post" id="form_validation">
                                        <input type="hidden" name="edt_purchase_code" value="<?php echo isset($result['edt_purchase_code']) ? $result['edt_purchase_code'] : ''; ?>">
                                        <input type="hidden" name="edt_item_id" value="<?php echo isset($result['edt_item_id']) ? $result['edt_item_id'] : ''; ?>">
                                        <input type="hidden" name="edt_item_name" value="<?php echo isset($result['edt_item_name']) ? $result['edt_item_name'] : ''; ?>">
                                        <input type="hidden" name="edt_buyer" value="<?php echo isset($result['edt_buyer']) ? $result['edt_buyer'] : ''; ?>">
                                        <input type="hidden" name="edt_license" value="<?php echo isset($result['edt_license']) ? $result['edt_license'] : ''; ?>">
                                        <input type="hidden" name="edt_purchase_date" value="<?php echo isset($result['edt_purchase_date']) ? $result['edt_purchase_date'] : ''; ?>">

                                        <?php echo isset($result['show_button']) ? $result['show_button'] : ''; ?>
                                    </form>

                                    <br>
                                    <div class="col-sm-12">
                                    <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="_blank"><b>Where Is My Purchase Code?</b></a>
                                    <br>
                                    <a href="https://codecanyon.net/item/your-recipes-app/13041482" target="_blank"><b>Don't Have Purchase Code? I Want to Purchase it first.</b></a>
                                    </div>
                                </center>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            
        </div>
       
    </section>