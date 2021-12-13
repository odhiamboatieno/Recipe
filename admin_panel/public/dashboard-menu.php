<?php

  $sql_featured = "SELECT COUNT(*) as num FROM tbl_recipes WHERE featured = '1'";
  $total_featured = mysqli_query($connect, $sql_featured);
  $total_featured = mysqli_fetch_array($total_featured);
  $total_featured = $total_featured['num'];

  $sql_category = "SELECT COUNT(*) as num FROM tbl_category";
  $total_category = mysqli_query($connect, $sql_category);
  $total_category = mysqli_fetch_array($total_category);
  $total_category = $total_category['num'];

  $sql_recipes = "SELECT COUNT(*) as num FROM tbl_recipes";
  $total_recipes = mysqli_query($connect, $sql_recipes);
  $total_recipes = mysqli_fetch_array($total_recipes);
  $total_recipes = $total_recipes['num'];

  $sql_fcm = "SELECT COUNT(*) as num FROM tbl_fcm_template";
  $total_fcm = mysqli_query($connect, $sql_fcm);
  $total_fcm = mysqli_fetch_array($total_fcm);
  $total_fcm = $total_fcm['num'];

?>

    <section class="content">

    <ol class="breadcrumb">
        <li><a href="dashboard.php"><?php echo $menu_dashboard; ?></a></li>
        <li class="active"><?php echo $home; ?></a></li>
    </ol>

        <div class="container-fluid">
             
             <div class="row">

                <a href="manage-featured.php">
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="card demo-color-box bg-blue waves-effect col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <br>
                            <div class="color-name uppercase"><?php echo $menu_featured; ?></div>
                            <div class="color-name"><i class="material-icons">star</i></div>
                            <div class="color-class-name">Total <?php echo $total_featured; ?> Featured</div>
                            <br>
                        </div>
                    </div>
                </a>

                <a href="manage-category.php">
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="card demo-color-box bg-blue waves-effect col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <br>
                            <div class="color-name uppercase"><?php echo $menu_category; ?></div>
                            <div class="color-name"><i class="material-icons">view_list</i></div>
                            <div class="color-class-name">Total <?php echo $total_category; ?> Categories</div>
                            <br>
                        </div>
                    </div>
                </a>

               <a href="manage-recipe.php">
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="card demo-color-box bg-blue waves-effect col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <br>
                            <div class="color-name uppercase"><?php echo $menu_recipes; ?></div>
                            <div class="color-name"><i class="material-icons">restaurant</i></div>
                            <div class="color-class-name">Total <?php echo $total_recipes; ?> Recipes</div>
                            <br>
                        </div>
                    </div>
                </a>

                <a href="push-notification.php">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="card demo-color-box bg-blue waves-effect col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <br>
                            <div class="color-name uppercase"><?php echo $menu_notification; ?></div>
                            <div class="color-name"><i class="material-icons">notifications</i></div>
                            <div class="color-class-name">Total <?php echo $total_fcm; ?> Templates</div>
                            <br>
                        </div>
                    </div>
                </a>

                <a href="manage-ads.php">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="card demo-color-box bg-blue waves-effect col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <br>
                            <div class="color-name uppercase"><?php echo $menu_ads; ?></div>
                            <div class="color-name"><i class="material-icons">monetization_on</i></div>
                            <div class="color-class-name"><?php echo $manage_ads; ?></div>
                            <br>
                        </div>
                    </div>
                </a>

                <a href="members.php">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="card demo-color-box bg-blue waves-effect col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <br>
                            <div class="color-name uppercase"><?php echo $menu_administrator; ?></div>
                            <div class="color-name"><i class="material-icons">people</i></div>
                            <div class="color-class-name"><?php echo $privileges; ?></div>
                            <br>
                        </div>
                    </div>
                </a>

                <a href="settings.php">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="card demo-color-box bg-blue waves-effect col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <br>
                            <div class="color-name uppercase"><?php echo $menu_setting; ?></div>
                            <div class="color-name"><i class="material-icons">settings</i></div>
                            <div class="color-class-name"><?php echo $settings; ?></div>
                            <br>
                        </div>
                    </div>
                </a>

            </div>
            
        </div>

    </section>