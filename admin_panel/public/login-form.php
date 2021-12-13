<?php

    include 'includes/config.php';
    include 'public/language.php';
    include 'variables.php';

    // start session
    //session_start();

    $verify_qry    = "SELECT * FROM tbl_license ORDER BY id DESC LIMIT 1";
    $verify_result = mysqli_query($connect, $verify_qry);
    $verify_row   = mysqli_fetch_assoc($verify_result);
    $item_id    = $verify_row['item_id'];

    // if user click Login button
    if(isset($_POST['btnLogin'])) {

        // get username and password
        $username = $_POST['username'];
        $password = $_POST['password'];

        // set time for session timeout
        $currentTime = time() + 25200;
        $expired = 3600;

        // create array variable to handle error
        $error = array();

        // check whether $username is empty or not
        if(empty($username)) {
            $error['username'] = "*Username should be filled.";
        }

        // check whether $password is empty or not
        if(empty($password)) {
            $error['password'] = "*Password should be filled.";
        }

        // if username and password is not empty, check in database
        if(!empty($username) && !empty($password)) {

            // change username to lowercase
            $username = strtolower($username);

            //encript password to sha256
            $password = hash('sha256',$username.$password);

            // get data from user table
            $sql_query = "SELECT * FROM tbl_admin WHERE username = ? AND password = ?";

            $stmt = $connect->stmt_init();
            if($stmt->prepare($sql_query)) {
                // Bind your variables to replace the ?s
                $stmt->bind_param('ss', $username, $password);
                // Execute query
                $stmt->execute();
                /* store result */
                $stmt->store_result();
                $num = $stmt->num_rows;
                // Close statement object
                $stmt->close();
                if($num == 1) {
                    if ($item_id == $var_item_id) {
                        $_SESSION['user'] = $username;
                        $_SESSION['timeout'] = $currentTime + $expired;
                        header("location: dashboard.php");
                    } else {
                        $_SESSION['user'] = $username;
                        $_SESSION['timeout'] = $currentTime + $expired;
                        header("location: verify-purchase-code.php");
                    }

                } else {
                    $error['failed'] = "Invalid Username or Password!";
                }
            }

        }
    }
?>

    <div class="login-box ">
        <div class="card">
            <div class="body">
                <form method="POST">
                    <center>
                        <img src="assets/images/ic_launcher.png" width="100px" height="100px">
                        <br>
                        <div class="custom-padding1"><div class="uppercase"><?php echo $app_name; ?></div></div>
                        <div class="custom-padding2 col-pink"><?php echo isset($error['failed']) ? $error['failed'] : '';?></div>
                    </center>
                    
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="username" placeholder="Username" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 p-t-5"></div>
                        <div class="col-xs-4">
                            <button class="btn btn-block bg-blue waves-effect" type="submit" name="btnLogin">LOGIN</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>