<?php

	require_once("Rest.inc.php");
	require_once("db.php");
	require_once("functions.php");

	class API extends REST {

		private $functions = NULL;
		private $db = NULL;

		public function __construct() {
			$this->db = new DB();
			$this->functions = new functions($this->db);
		}

		public function check_connection() {
			$this->functions->checkConnection();
		}

		/*
		 * ALL API Related android client -------------------------------------------------------------------------
		*/

		public function get_home() {
			$this->functions->getHome();
		}

		public function get_recent_recipes() {
			$this->functions->getRecentRecipes();
		}

		public function get_recipe_detail() {
			$this->functions->getRecipeDetail();
		}

		public function get_category_index() {
	        $this->functions->getCategoryIndex();
	    }

		public function get_category_posts() {
	        $this->functions->getCategoryPosts();
	    }

	    public function get_search_results() {
	        $this->functions->getSearchResults();
	    }

	    public function get_search_results_rtl() {
	        $this->functions->getSearchResultsRTL();
	    }

	    public function get_total_views() {
	        $this->functions->getTotalViews();
	    }

	    public function get_ads() {
	        $this->functions->getAds();
	    }

	    public function get_settings() {
	        $this->functions->getSettings();
	    }

	    public function get_user_token() {
	        $this->functions->getUserToken();
	    }

		/*
		 * End of API Transactions ----------------------------------------------------------------------------------
		*/

		public function processApi() {
			if(isset($_REQUEST['x']) && $_REQUEST['x']!="") {
				$func = strtolower(trim(str_replace("/","", $_REQUEST['x'])));
				if((int)method_exists($this,$func) > 0) {
					$this->$func();
				} else {
					header( 'Content-Type: application/json; charset=utf-8' );
					echo 'processApi - method not exist';
					exit;
				}
			} else {
				header( 'Content-Type: application/json; charset=utf-8' );
				echo 'processApi - method not exist';
				exit;
			}
		}

	}

	// Initiiate Library
	$api = new API;
	if (isset($_GET['get_home'])) {
		$api->get_home();
	} else if (isset($_GET['get_recent_recipes'])) {
		$api->get_recent_recipes();
	}  else if (isset($_GET['get_recipe_detail'])) {
		$api->get_recipe_detail();
	} else if (isset($_GET['get_category_index'])) {
		$api->get_category_index();
	} else if (isset($_GET['get_category_posts'])) {
		$api->get_category_posts();
	} else if (isset($_GET['get_search_results'])) {
		$api->get_search_results();
	} else if (isset($_GET['get_search_results_rtl'])) {
		$api->get_search_results_rtl();
	} else if (isset($_GET['get_total_views'])) {
		$api->get_total_views();
	} else if (isset($_GET['get_ads'])) {
		$api->get_ads();
	} else if (isset($_GET['get_settings'])) {
		$api->get_settings();
	} else if (isset($_GET['get_user_token'])) {
		$api->get_user_token();
	} else {
		$api->processApi();
	}

?>
