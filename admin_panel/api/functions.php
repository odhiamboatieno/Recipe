<?php

require_once("Rest.inc.php");
require_once("db.php");

class functions extends REST {
    
    private $mysqli = NULL;
    private $db = NULL;
    
    public function __construct($db) {
        parent::__construct();
        $this->db = $db;
        $this->mysqli = $db->mysqli;
    }

	public function checkConnection() {
			if (mysqli_ping($this->mysqli)) {
                $respon = array(
                    'status' => 'ok', 'database' => 'connected'
                );
                $this->response($this->json($respon), 200);
			} else {
                $respon = array(
                    'status' => 'failed', 'database' => 'not connected'
                );
                $this->response($this->json($respon), 404);
			}
	}

    public function getHome() {

    	include "../includes/config.php";
        $setting_qry    = "SELECT * FROM tbl_settings where id = '1'";
		$setting_result = mysqli_query($connect, $setting_qry);
		$settings_row   = mysqli_fetch_assoc($setting_result);
		$api_key    = $settings_row['api_key'];

		if (isset($_GET['api_key'])) {

			$access_key_received = $_GET['api_key'];

			if ($access_key_received == $api_key) {		

				$limit = 10;

				if($this->get_request_method() != "GET") $this->response('',406);

				$query_category = "SELECT DISTINCT c.cid, c.category_name, c.category_image, COUNT(DISTINCT r.recipe_id) as recipes_count
							  FROM tbl_category c LEFT JOIN tbl_recipes r ON c.cid = r.cat_id GROUP BY c.cid ORDER BY c.cid DESC LIMIT $limit";

				$query_featured = "SELECT DISTINCT n.recipe_id, n.recipe_title, n.cat_id, n.recipe_time, n.recipe_image, n.recipe_description, n.video_url, n.video_id, n.content_type, n.featured, n.tags, n.total_views, c.category_name, n.last_update FROM tbl_recipes n LEFT JOIN tbl_category c ON n.cat_id = c.cid WHERE n.featured = '1' GROUP BY n.recipe_id ORDER BY n.last_update DESC";

				$query_recent = "SELECT DISTINCT n.recipe_id, n.recipe_title, n.cat_id, n.recipe_time, n.recipe_image, n.recipe_description, n.video_url, n.video_id, n.content_type, n.featured, n.tags, n.total_views, c.category_name FROM tbl_recipes n LEFT JOIN tbl_category c ON n.cat_id = c.cid WHERE n.content_type = 'Post' GROUP BY n.recipe_id ORDER BY n.recipe_id DESC LIMIT $limit";

				$query_videos = "SELECT DISTINCT n.recipe_id, n.recipe_title, n.cat_id, n.recipe_time, n.recipe_image, n.recipe_description, n.video_url, n.video_id, n.content_type, n.featured, n.tags, n.total_views, c.category_name FROM tbl_recipes n LEFT JOIN tbl_category c ON n.cat_id = c.cid WHERE n.content_type != 'Post' GROUP BY n.recipe_id ORDER BY n.recipe_id DESC LIMIT $limit";
						  
				$recent = $this->get_list_result($query_recent);
				$category = $this->get_list_result($query_category);
				$featured = $this->get_list_result($query_featured);
				$videos = $this->get_list_result($query_videos);

				$respon = array('status' => 'ok', 'featured' => $featured, 'category' => $category, 'recent' => $recent, 'videos' => $videos);
				$this->response($this->json($respon), 200);

			} else {
				$respon = array( 'status' => 'failed', 'message' => 'Oops, API Key is Incorrect!');
				$this->response($this->json($respon), 404);
			}
		} else {
			$respon = array( 'status' => 'failed', 'message' => 'Forbidden, API Key is Required!');
			$this->response($this->json($respon), 404);
		}		

    }

    public function getRecentRecipes() {

    		include "../includes/config.php";
		    $setting_qry    = "SELECT * FROM tbl_settings where id = '1'";
		    $setting_result = mysqli_query($connect, $setting_qry);
		    $settings_row   = mysqli_fetch_assoc($setting_result);
		    $api_key    = $settings_row['api_key'];

			if (isset($_GET['api_key'])) {

				$access_key_received = $_GET['api_key'];
				$filter = $_GET['filter'];

				if ($access_key_received == $api_key) {

					if($this->get_request_method() != "GET") $this->response('',406);
						$limit = isset($this->_request['count']) ? ((int)$this->_request['count']) : 10;
						$page = isset($this->_request['page']) ? ((int)$this->_request['page']) : 1;
						
						$offset = ($page * $limit) - $limit;
						$count_total = $this->get_count_result("SELECT COUNT(DISTINCT n.recipe_id) FROM tbl_recipes n WHERE $filter ");
						$query = "SELECT DISTINCT n.recipe_id, 
									n.recipe_title, 
									n.cat_id,
									n.recipe_time, 
									n.recipe_image, 
									n.recipe_description,
									n.video_url,
									n.video_id, 
									n.content_type,
									n.featured,
									n.tags,
									n.total_views,
									c.category_name

								  FROM tbl_recipes n 

								  LEFT JOIN tbl_category c ON n.cat_id = c.cid

								  WHERE $filter

								  GROUP BY n.recipe_id 

								  ORDER BY n.recipe_id 

								  DESC LIMIT $limit OFFSET $offset";

						$posts = $this->get_list_result($query);
						$count = count($posts);
						$respon = array(
							'status' => 'ok', 'count' => $count, 'count_total' => $count_total, 'pages' => $page, 'posts' => $posts
						);
						$this->response($this->json($respon), 200);

				} else {
					$respon = array( 'status' => 'failed', 'message' => 'Oops, API Key is Incorrect!');
					$this->response($this->json($respon), 404);
				}
			} else {
				$respon = array( 'status' => 'failed', 'message' => 'Forbidden, API Key is Required!');
				$this->response($this->json($respon), 404);
			}

    }


	public function getRecipeDetail() {

    	$id = $_GET['id'];
    	include "../includes/config.php";
    	$setting_qry    = "SELECT cat_id FROM tbl_recipes WHERE recipe_id = $id";
		$setting_result = mysqli_query($connect, $setting_qry);
		$settings_row   = mysqli_fetch_assoc($setting_result);
		$category_id    = $settings_row['cat_id'];

		if($this->get_request_method() != "GET") $this->response('',406);

		$query_image = "SELECT recipe_id, recipe_image AS 'image_name', content_type, video_id, video_url FROM tbl_recipes WHERE recipe_id = $id UNION SELECT n.recipe_id, g.image_name, n.content_type, n.video_id, n.video_url FROM tbl_recipes n, tbl_recipes_gallery g WHERE n.recipe_id = g.recipe_id AND g.recipe_id = $id";

		$query_post = "SELECT DISTINCT n.recipe_id, 
						n.recipe_title, 
						n.cat_id,
						n.recipe_time, 
						n.recipe_image, 
						n.recipe_description,
						n.video_url,
						n.video_id, 
						n.content_type, 
						n.featured,
						n.tags,
						n.total_views,
						c.category_name

						FROM tbl_recipes n 

						LEFT JOIN tbl_category c ON n.cat_id = c.cid 

						WHERE n.recipe_id = $id

						GROUP BY n.recipe_id
								 
						LIMIT 1";

		$query_related = "SELECT DISTINCT n.recipe_id, 
						n.recipe_title, 
						n.cat_id,
						n.recipe_time, 
						n.recipe_image, 
						n.recipe_description,
						n.video_url,
						n.video_id, 
						n.content_type, 
						n.featured,
						n.tags,
						n.total_views,		
						c.category_name

						FROM tbl_recipes n 

						LEFT JOIN tbl_category c ON n.cat_id = c.cid

						WHERE n.recipe_id != $id AND n.cat_id = $category_id

						GROUP BY n.recipe_id 

						ORDER BY n.recipe_id 

						DESC LIMIT 5";

		$images = $this->get_list_result($query_image);
		$post = $this->get_one($query_post);
		$related = $this->get_list_result($query_related);

		$count = count($post);
		$respon = array(
			'status' => 'ok', 'post' => $post, 'images' => $images, 'related' => $related
		);
		$this->response($this->json($respon), 200);

    }
    
    public function getCategoryIndex() {

    	include "../includes/config.php";
        $setting_qry    = "SELECT * FROM tbl_settings where id = '1'";
		$setting_result = mysqli_query($connect, $setting_qry);
		$settings_row   = mysqli_fetch_assoc($setting_result);
		$api_key    = $settings_row['api_key'];

			if (isset($_GET['api_key'])) {

				$access_key_received = $_GET['api_key'];

				if ($access_key_received == $api_key) {

					if($this->get_request_method() != "GET") $this->response('',406);
					$count_total = $this->get_count_result("SELECT COUNT(DISTINCT cid) FROM tbl_category");

					$query = "SELECT DISTINCT c.cid, c.category_name, c.category_image, COUNT(DISTINCT r.recipe_id) as recipes_count
					  FROM tbl_category c LEFT JOIN tbl_recipes r ON c.cid = r.cat_id GROUP BY c.cid ORDER BY c.cid DESC";

					$news = $this->get_list_result($query);
					$count = count($news);
					$respon = array(
						'status' => 'ok', 'count' => $count, 'categories' => $news
					);
					$this->response($this->json($respon), 200);

				} else {
					$respon = array( 'status' => 'failed', 'message' => 'Oops, API Key is Incorrect!');
					$this->response($this->json($respon), 404);
				}
			} else {
				$respon = array( 'status' => 'failed', 'message' => 'Forbidden, API Key is Required!');
				$this->response($this->json($respon), 404);
			}

    }

    public function getCategoryPosts() {

    	include "../includes/config.php";
        $setting_qry    = "SELECT * FROM tbl_settings where id = '1'";
		$setting_result = mysqli_query($connect, $setting_qry);
		$settings_row   = mysqli_fetch_assoc($setting_result);
		$api_key    = $settings_row['api_key'];

			if (isset($_GET['api_key'])) {

				$access_key_received = $_GET['api_key'];

				if ($access_key_received == $api_key) {

			    	$id = $_GET['id'];
			    	$filter = $_GET['filter'];

					if($this->get_request_method() != "GET") $this->response('',406);
					$limit = isset($this->_request['count']) ? ((int)$this->_request['count']) : 10;
					$page = isset($this->_request['page']) ? ((int)$this->_request['page']) : 1;

					$offset = ($page * $limit) - $limit;
					$count_total = $this->get_count_result("SELECT COUNT(DISTINCT n.recipe_id) FROM tbl_recipes n WHERE n.cat_id = '$id' AND $filter ");

					$query_category = "SELECT distinct cid, category_name, category_image FROM tbl_category WHERE cid = '$id' ORDER BY cid DESC";

					$query_post = "SELECT DISTINCT n.recipe_id, 
									n.recipe_title, 
									n.cat_id,
									n.recipe_time, 
									n.recipe_image, 
									n.recipe_description,
									n.video_url,
									n.video_id, 
									n.content_type, 
									n.featured,
									n.tags,
									n.total_views,
									c.category_name

									FROM tbl_recipes n 

									LEFT JOIN tbl_category c ON n.cat_id = c.cid 

									WHERE c.cid = $id AND $filter

									GROUP BY n.recipe_id 
									ORDER BY n.recipe_id DESC 
											 
									LIMIT $limit OFFSET $offset";

					$category = $this->get_category_result($query_category);


					$post = $this->get_list_result($query_post);					
					$count = count($post);

					$respon = array(
						'status' => 'ok', 'count' => $count, 'count_total' => $count_total, 'pages' => $page, 'category' => $category, 'posts' => $post
					);
					$this->response($this->json($respon), 200);

				} else {
					$respon = array( 'status' => 'failed', 'message' => 'Oops, API Key is Incorrect!');
					$this->response($this->json($respon), 404);
				}
			} else {
				$respon = array( 'status' => 'failed', 'message' => 'Forbidden, API Key is Required!');
				$this->response($this->json($respon), 404);
			}


    }

    public function getSearchResults() {

    	include "../includes/config.php";
		    $setting_qry    = "SELECT * FROM tbl_settings WHERE id = '1'";
		    $setting_result = mysqli_query($connect, $setting_qry);
		    $settings_row   = mysqli_fetch_assoc($setting_result);
		    $api_key    = $settings_row['api_key'];

			if (isset($_GET['api_key'])) {

				$access_key_received = $_GET['api_key'];

				if ($access_key_received == $api_key) {

					$search = mysqli_real_escape_string($connect, $_GET['search']);

					if($this->get_request_method() != "GET") $this->response('',406);
					$limit = isset($this->_request['count']) ? ((int)$this->_request['count']) : 10;
					$page = isset($this->_request['page']) ? ((int)$this->_request['page']) : 1;

					$offset = ($page * $limit) - $limit;
					$count_total = $this->get_count_result("SELECT COUNT(DISTINCT n.recipe_id) FROM tbl_recipes n, tbl_category c WHERE n.cat_id = c.cid AND (n.recipe_title LIKE '%$search%' OR n.recipe_description LIKE '%$search%')");

					$query = "SELECT DISTINCT n.recipe_id, 
									n.recipe_title, 
									n.cat_id,
									n.recipe_time, 
									n.recipe_image, 
									n.recipe_description,
									n.video_url,
									n.video_id, 
									n.content_type, 
									n.featured,
									n.tags,
									n.total_views,
									c.category_name

								  FROM tbl_recipes n 

								  LEFT JOIN tbl_category c ON n.cat_id = c.cid 

								  WHERE n.cat_id = c.cid AND (n.recipe_title LIKE '%$search%' OR n.recipe_description LIKE '%$search%')

								  GROUP BY n.recipe_id 
								  ORDER BY n.recipe_id DESC

							LIMIT $limit OFFSET $offset";
	

					$post = $this->get_list_result($query);					

					$count = count($post);
					$respon = array(
						'status' => 'ok', 'count' => $count, 'count_total' => $count_total, 'pages' => $page, 'posts' => $post
					);
					$this->response($this->json($respon), 200);

				} else {
					$respon = array( 'status' => 'failed', 'message' => 'Oops, API Key is Incorrect!');
					$this->response($this->json($respon), 404);
				}
			} else {
				$respon = array( 'status' => 'failed', 'message' => 'Forbidden, API Key is Required!');
				$this->response($this->json($respon), 404);
			}

    }

    public function getSearchResultsRTL() {

    	include "../includes/config.php";
		    $setting_qry    = "SELECT * FROM tbl_settings WHERE id = '1'";
		    $setting_result = mysqli_query($connect, $setting_qry);
		    $settings_row   = mysqli_fetch_assoc($setting_result);
		    $api_key    = $settings_row['api_key'];

			if (isset($_GET['api_key'])) {

				$access_key_received = $_GET['api_key'];

				if ($access_key_received == $api_key) {

					$search = mysqli_real_escape_string($connect, $_GET['search']);

					if($this->get_request_method() != "GET") $this->response('',406);
					$limit = isset($this->_request['count']) ? ((int)$this->_request['count']) : 10;
					$page = isset($this->_request['page']) ? ((int)$this->_request['page']) : 1;

					$offset = ($page * $limit) - $limit;
					$count_total = $this->get_count_result("SELECT COUNT(DISTINCT n.recipe_id) FROM tbl_recipes n, tbl_category c WHERE n.cat_id = c.cid AND (n.recipe_title LIKE N'%$search%' OR n.recipe_description LIKE N'%$search%')");

					$query = "SELECT DISTINCT n.recipe_id, 
									n.recipe_title, 
									n.cat_id,
									n.recipe_time, 
									n.recipe_image, 
									n.recipe_description,
									n.video_url,
									n.video_id, 
									n.content_type, 
									n.featured,
									n.tags,
									n.total_views,
									c.category_name

								  FROM tbl_recipes n 

								  LEFT JOIN tbl_category c ON n.cat_id = c.cid 

								  WHERE n.cat_id = c.cid AND (n.recipe_title LIKE N'%$search%' OR n.recipe_description LIKE N'%$search%')

								  GROUP BY n.recipe_id 
								  ORDER BY n.recipe_id DESC

							LIMIT $limit OFFSET $offset";
	

					$post = $this->get_list_result($query);					

					$count = count($post);
					$respon = array(
						'status' => 'ok', 'count' => $count, 'count_total' => $count_total, 'pages' => $page, 'posts' => $post
					);
					$this->response($this->json($respon), 200);

				} else {
					$respon = array( 'status' => 'failed', 'message' => 'Oops, API Key is Incorrect!');
					$this->response($this->json($respon), 404);
				}
			} else {
				$respon = array( 'status' => 'failed', 'message' => 'Forbidden, API Key is Required!');
				$this->response($this->json($respon), 404);
			}

    }

	public function getTotalViews() {

		include "../includes/config.php";

		$jsonObj = array();	

		$query = "SELECT * FROM tbl_recipes WHERE recipe_id = '".$_GET['id']."'";
		$sql = mysqli_query($connect, $query) or die(mysqli_error());

		while ($data = mysqli_fetch_assoc($sql)) {
						 
			$row['recipe_id'] = $data['recipe_id'];
			$row['recipe_title'] = $data['recipe_title'];
			$row['total_views'] = $data['total_views'];
			 
			array_push($jsonObj, $row);
					
		}

		$view_qry = mysqli_query($connect, "UPDATE tbl_recipes SET total_views = total_views + 1 WHERE recipe_id = '".$_GET['id']."'");
			 
		$set['result'] = $jsonObj;
					
		header( 'Content-Type: application/json; charset=utf-8' );
		echo $val= str_replace('\\/', '/', json_encode($set, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();	

	}

	public function getAds() {

		include "../includes/config.php";
		$setting_qry    = "SELECT * FROM tbl_settings where id = '1'";
		$setting_result = mysqli_query($connect, $setting_qry);
		$settings_row   = mysqli_fetch_assoc($setting_result);
		$api_key    = $settings_row['api_key'];

		if (isset($_GET['api_key'])) {

			$access_key_received = $_GET['api_key'];

			if ($access_key_received == $api_key) {			

				if($this->get_request_method() != "GET") $this->response('',406);

				$query = "SELECT a.*, s.youtube_api_key, s.fcm_notification_topic, s.onesignal_app_id, s.more_apps_url FROM tbl_ads a, tbl_settings s WHERE a.id = 1 AND s.id = 1";

				$result = $this->get_one($query);
				$respon = array(
					'status' => 'ok', 'ads' => $result
				);
				$this->response($this->json($respon), 200);

			} else {
				die ('Oops, API Key is Incorrect!');
			}
		} else {
			die ('Forbidden, API Key is Required!');
		}			

	}

	public function getUserToken() {

		include "../includes/config.php";

		$user_unique_id = $_GET['user_unique_id'];

		if($this->get_request_method() != "GET") $this->response('', 406);

		$query_post = "SELECT * FROM tbl_fcm_token WHERE user_unique_id = $user_unique_id ";

		$post = $this->get_one($query_post);
		$count = count($post);
		$respon = array(
			'status' => 'ok', 'response' => $post
		);
		$this->response($this->json($respon), 200);
	}	

	public function getSettings() {

    	include "../includes/config.php";
		$setting_qry    = "SELECT * FROM tbl_settings where id = '1'";
		$setting_result = mysqli_query($connect, $setting_qry);
		$settings_row   = mysqli_fetch_assoc($setting_result);
		$api_key    = $settings_row['api_key'];

		if (isset($_GET['api_key'])) {

			$access_key_received = $_GET['api_key'];

			if ($access_key_received == $api_key) {

				if ($this->get_request_method() != "GET") $this->response('',406);

				$query = "SELECT * FROM tbl_settings WHERE id = 1";
				$result = $this->get_one($query);
			
				$respon = array(
					'status' => 'ok', 'post' => $result
				);
				$this->response($this->json($respon), 200);

			} else {
				$respon = array( 'status' => 'failed', 'message' => 'Oops, API Key is Incorrect!');
				$this->response($this->json($respon), 404);
			}
		} else {
			$respon = array( 'status' => 'failed', 'message' => 'Forbidden, API Key is Required!');
			$this->response($this->json($respon), 404);
		}

	}

    public function get_list_result($query) {
		$result = array();
		$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
		if($r->num_rows > 0) {
			while($row = $r->fetch_assoc()) {
				$result[] = $row;
			}
		}
		return $result;
	}

    public function get_count_result($query) {
		$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
		if($r->num_rows > 0) {
			$result = $r->fetch_row();
			return $result[0];
		}
		return 0;
	}

	private function get_category_result($query) {
		$result = array();
		$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
		if($r->num_rows > 0) {
			while($row = $r->fetch_assoc()) {
				$result = $row;
			}
		}
		return $result;
	}

	private function get_one($query) {
		$result = array();
		$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
		if($r->num_rows > 0) $result = $r->fetch_assoc();
		return $result;
	}
    
}

?>