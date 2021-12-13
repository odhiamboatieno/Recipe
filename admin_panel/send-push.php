<?php include('session.php'); ?>
<?php include('includes/config.php'); ?>

<?php

class FCM {

    function __construct() {

    }
    
    public function send_notification($registatoin_ids, $data) {

        include "includes/config.php";
        $setting_qry    = "SELECT * FROM tbl_settings where id = '1'";
        $setting_result = mysqli_query($connect, $setting_qry);
        $settings_row   = mysqli_fetch_assoc($setting_result);
        $app_fcm_key    = $settings_row['app_fcm_key'];
        $protocol_type  = $settings_row['protocol_type'];

        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => array(
            'id' => $data['id'],
            'title' => $data['title'],
            'message' => $data['description'],
            'link' => $data['link'],
            'image' => $data['image']
            )
        );

        $headers = array(
            'Authorization:key =' . $app_fcm_key,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die("Curl failed: ".curl_error($ch));
        }
        curl_close($ch);
    }

}

    $result = $connect->query("SELECT * FROM tbl_fcm_token WHERE token IS NOT NULL AND token <> ''");

    $android_tokens = array();
    $x = 0;
    $i = 0;
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {

          $android_tokens[$i][] = $row["token"];
          $x++;
          // I need divide the array for 1000 push limit send in one time
          if ($x % 800 == 0) {
            $i++;
          } 
        }
    } else {
        $succes =<<<EOF
        <script>
        alert('You don not have users to receive push notification.');
            window.history.go(-1);
        </script>
EOF;

        echo $succes;
    }

    //$ip= $_SERVER['REMOTE_ADDR'];
    //$result_check = $conn->query("SELECT * FROM `notifications` WHERE notification_sender_ip = '$ip' && notification_date > DATE_SUB(NOW(),INTERVAL 5 MINUTE)");
    //if ($result_check->num_rows > 2) {
    //        die('Anti flood protection. You can send only 3 notifications every 5 minutes!. This is just a demo push panel, buy this from codecanyon and install into your hosting. Thanks!');
    //}

    $id = $_POST['id'];
    $title = $_POST['title'];
    $msg = $_POST['message'];
    $link = $_POST['link'];
    $image = $_POST['image'];

    if ($android_tokens != array()) {
        $fcm = new FCM();
        $data = array("id"=>$id, "title"=>$title, "description"=>$msg, "link"=>$link, "image"=>$image);
        foreach ($android_tokens as $tokens) {
          $result_android = $fcm->send_notification($tokens, $data);
          sleep(1);
        }
        
        $sql = "INSERT INTO notifications (notification_title, notification_text, notification_extra, notification_sender_ip) VALUES ('$title', '$msg', '$link', '{$_SERVER['REMOTE_ADDR']}')";
        mysqli_query($connect, $sql);

        $_SESSION['msg'] = "Congratulations, you have sent $x push notification...";
        header("Location:manage-recipe.php");
    }

    $connect->close();
    
?>