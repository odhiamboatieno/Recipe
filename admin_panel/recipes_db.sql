-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2021 at 05:45 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `your_recipes_app_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `user_role` enum('100','101','102') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `username`, `password`, `email`, `full_name`, `user_role`) VALUES
(1, 'admin', 'd82494f05d6917ba02f7aaa29689ccb444bb73f20380876cb05d1f37537b7892', 'help.solodroid@gmail.com', 'Administrator', '100');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ads`
--

CREATE TABLE `tbl_ads` (
  `id` int(11) NOT NULL,
  `ad_status` varchar(5) NOT NULL DEFAULT 'on',
  `ad_type` varchar(45) NOT NULL DEFAULT 'admob',
  `admob_publisher_id` varchar(45) NOT NULL DEFAULT '0',
  `admob_app_id` varchar(255) NOT NULL DEFAULT '0',
  `admob_banner_unit_id` varchar(255) NOT NULL DEFAULT '0',
  `admob_interstitial_unit_id` varchar(255) NOT NULL DEFAULT '0',
  `admob_native_unit_id` varchar(255) NOT NULL DEFAULT '0',
  `admob_app_open_ad_unit_id` varchar(45) NOT NULL DEFAULT '0',
  `fan_banner_unit_id` varchar(255) NOT NULL DEFAULT '0',
  `fan_interstitial_unit_id` varchar(255) NOT NULL DEFAULT '0',
  `fan_native_unit_id` varchar(255) NOT NULL DEFAULT '0',
  `startapp_app_id` varchar(255) NOT NULL DEFAULT '0',
  `unity_game_id` varchar(45) NOT NULL DEFAULT '0',
  `unity_banner_placement_id` varchar(45) NOT NULL DEFAULT 'banner',
  `unity_interstitial_placement_id` varchar(45) NOT NULL DEFAULT 'video',
  `applovin_banner_ad_unit_id` varchar(45) NOT NULL DEFAULT '0',
  `applovin_interstitial_ad_unit_id` varchar(45) NOT NULL DEFAULT '0',
  `mopub_banner_ad_unit_id` varchar(45) NOT NULL DEFAULT '0',
  `mopub_interstitial_ad_unit_id` varchar(45) NOT NULL DEFAULT '0',
  `interstitial_ad_interval` int(11) NOT NULL DEFAULT 3,
  `native_ad_interval` int(11) NOT NULL DEFAULT 20,
  `native_ad_index` int(11) NOT NULL DEFAULT 4,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_ads`
--

INSERT INTO `tbl_ads` (`id`, `ad_status`, `ad_type`, `admob_publisher_id`, `admob_app_id`, `admob_banner_unit_id`, `admob_interstitial_unit_id`, `admob_native_unit_id`, `admob_app_open_ad_unit_id`, `fan_banner_unit_id`, `fan_interstitial_unit_id`, `fan_native_unit_id`, `startapp_app_id`, `unity_game_id`, `unity_banner_placement_id`, `unity_interstitial_placement_id`, `applovin_banner_ad_unit_id`, `applovin_interstitial_ad_unit_id`, `mopub_banner_ad_unit_id`, `mopub_interstitial_ad_unit_id`, `interstitial_ad_interval`, `native_ad_interval`, `native_ad_index`, `date_time`) VALUES
(1, 'on', 'admob', 'pub-3940256099942544', 'ca-app-pub-3940256099942544~3347511713', 'ca-app-pub-3940256099942544/6300978111', 'ca-app-pub-3940256099942544/1033173712', 'ca-app-pub-3940256099942544/2247696110', 'ca-app-pub-3940256099942544/3419835294', '0', '0', '0', '0', '0', 'banner', 'video', '0', '0', 'b195f8dd8ded45fe847ad89ed1d016da', '24534e1901884e398f1253216226017e', 3, 10, 5, '2021-10-02 03:41:01');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `cid` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`cid`, `category_name`, `category_image`) VALUES
(1, 'Drink', '7783-2018-08-13.jpg'),
(2, 'Desserts', '4589-2018-08-13.jpg'),
(3, 'Side Dish', '9321-2018-08-13.jpg'),
(4, 'Main Dish', '6386-2018-08-13.jpg'),
(5, 'Breakfast', '4845-2018-08-13.jpg'),
(6, 'Appetizers', '2378-2018-08-13.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_fcm_template`
--

CREATE TABLE `tbl_fcm_template` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT 'Notification',
  `message` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `link` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_fcm_template`
--

INSERT INTO `tbl_fcm_template` (`id`, `title`, `message`, `image`, `link`) VALUES
(28, 'Your Recipes App', 'Hello World, This is Your Recipes App, you can purchase it on Codecanyon officially.', '7597-2020-05-06.jpg', ''),
(30, 'Your Recipes App 4.0.0', 'New updated version available now on Codecanyon!', '9450-2020-05-06.jpg', 'https://codecanyon.net/item/your-recipes-app/13041482');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_fcm_token`
--

CREATE TABLE `tbl_fcm_token` (
  `id` int(11) NOT NULL,
  `token` text NOT NULL,
  `user_unique_id` varchar(255) NOT NULL,
  `app_version` varchar(255) NOT NULL,
  `os_version` varchar(255) NOT NULL,
  `device_model` varchar(255) NOT NULL,
  `device_manufacturer` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_license`
--

CREATE TABLE `tbl_license` (
  `id` int(11) NOT NULL,
  `purchase_code` varchar(255) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `buyer` varchar(255) NOT NULL,
  `license_type` varchar(45) NOT NULL,
  `purchase_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_recipes`
--

CREATE TABLE `tbl_recipes` (
  `recipe_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `recipe_title` varchar(255) NOT NULL,
  `recipe_time` varchar(45) NOT NULL DEFAULT '0',
  `recipe_description` text NOT NULL,
  `recipe_image` varchar(255) NOT NULL,
  `video_url` varchar(500) NOT NULL,
  `video_id` varchar(255) NOT NULL,
  `content_type` varchar(45) NOT NULL,
  `size` varchar(255) NOT NULL,
  `featured` int(11) NOT NULL DEFAULT 0,
  `tags` varchar(1000) NOT NULL DEFAULT '0',
  `total_views` int(11) NOT NULL DEFAULT 0,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_recipes`
--

INSERT INTO `tbl_recipes` (`recipe_id`, `cat_id`, `recipe_title`, `recipe_time`, `recipe_description`, `recipe_image`, `video_url`, `video_id`, `content_type`, `size`, `featured`, `tags`, `total_views`, `last_update`) VALUES
(1, 3, 'Lemon Carrot Juice', '15 Minutes', '<p><strong>SUMMARY :</strong></p>\r\n\r\n<p>Carrots including a suitable vegetable juices made. In order watery, choose carrots imports. Add lemon juice to taste more cohesive. The recipes that you must try.</p>\r\n\r\n<hr />\r\n<p><strong>INGREDIENTS :</strong></p>\r\n\r\n<ul>\r\n	<li>1 carrot diced import</li>\r\n	<li>1 red apple fruit cut into pieces</li>\r\n	<li>250 ml orange juice field</li>\r\n	<li>75 gram ice cubes</li>\r\n	<li>Fruit juice 1/2 lemon, take the water</li>\r\n</ul>\r\n\r\n<hr />\r\n<p><strong>DIRECTION :</strong></p>\r\n\r\n<ol>\r\n	<li>Masukan wortel dan apel dalam blender.</li>\r\n	<li>Tuang air jeruk. tambahkan es batu dan air jeruk lemon. Blender sampai rata.</li>\r\n	<li>Untuk 2 gelas</li>\r\n</ol>\r\n', '1534127956_5844-2015-09-25.jpg', '', 'cda11up', 'Post', '', 0, '', 1, '2020-06-17 07:07:14'),
(2, 3, 'Sweet Martabak', '25 Minutes', '<p><strong>SUMMARY :</strong></p>\r\n\r\n<p>Now you no longer need to buy a special sweet martabak to be able to enjoy it. Armed with the following recipe, you can make it yourself. Fill you can customize to taste.</p>\r\n\r\n<hr />\r\n<p><strong>INGREDIENTS :</strong></p>\r\n\r\n<p>Leather ingredients :</p>\r\n\r\n<ul>\r\n	<li>500 grams of cake flour</li>\r\n	<li>1 1/2</li>\r\n	<li>100 grams sugar</li>\r\n	<li>1 egg, beaten off</li>\r\n	<li>2 egg yolks, beaten off</li>\r\n	<li>1/4 teaspoon vanilla powder</li>\r\n	<li>1/2 teaspoon salt</li>\r\n	<li>650 ml of water</li>\r\n	<li>25 grams of salted butter</li>\r\n	<li>1 tablespoon sugar</li>\r\n	<li>Toblerone 50 gram chocolate, coarsely chopped</li>\r\n	<li>50 grams cashews, toasted, coarsely chopped</li>\r\n	<li>50 grams grated cheese</li>\r\n	<li>50 grams of sweetened condensed milk</li>\r\n</ul>\r\n\r\n<hr />\r\n<p><strong>DIRECTION :</strong></p>\r\n\r\n<ol>\r\n	<li>Leather, sifted flour and baking powder. Enter granulated sugar. Stir well. Add the beaten eggs, vanilla powder, and salt. Stir well.</li>\r\n	<li>Pour a little water,&nbsp;a little while shaken at low speed until smooth. Let stand 1 hour.</li>\r\n	<li>Set aside.</li>\r\n	<li>Heat the pan martabak. Sprinkle a few grains of sugar to see is hot or not. If the sugar dissolves immediately sign already hot enough.</li>\r\n	<li>Weigh 350 grams of dough. Add 1/4 teaspoon of baking powder. Stir well.</li>\r\n	<li>Pour in sweet martabak mold that has been heated over medium heat 15 minutes. Let foaming. Reduce heat. Allow to cavities. Sprinkle sugar. Close to mature.</li>\r\n	<li>Lift.</li>\r\n	<li>Spread butter. Sprinkle chocolate and nuts. On one side. One the other hand sprinkle the grated cheese.</li>\r\n	<li>Pour sweetened condensed milk on top. Cut two. Stacks. Spread butter on it.</li>\r\n	<li>To 3 trays</li>\r\n</ol>\r\n', '1534128040_3952-2015-09-25.jpg', '', 'cda11up', 'Post', '', 0, '', 1, '2020-08-21 16:47:11'),
(3, 5, 'Chocolate Donut', '55 Minutes', '<p><strong>SUMMARY :</strong></p>\r\n\r\n<p>This recipe can be your alternative to make your child become fond of fruit pumpkin. Krena this time pumpkin recipe creation this time with the donuts, so they can be more like it.</p>\r\n\r\n<hr />\r\n<p><strong>INGREDIENTS :</strong></p>\r\n\r\n<ul>\r\n	<li>300 grams of high-protein wheat flour</li>\r\n	<li>100 grams of steamed pumpkin, puree</li>\r\n	<li>30 grams sugar</li>\r\n	<li>1 1/2 teaspoon instant yeast</li>\r\n	<li>1 egg yolk</li>\r\n	<li>50 grams of instant coconut milk</li>\r\n	<li>85 ml of ice water</li>\r\n	<li>30 grams of margarine</li>\r\n	<li>1 tea spoon of salt</li>\r\n	<li>solid oil for frying</li>\r\n	<li>100 ml liquid milk</li>\r\n	<li>200 grams of dark cooking chocolate, chopped</li>\r\n	<li>100 grams of sugar donuts for sprinkling</li>\r\n</ul>\r\n\r\n<hr />\r\n<p><strong>DIRECTION :</strong></p>\r\n\r\n<ol>\r\n	<li>mix flour, pumpkin, sugar, and yeast. stir well.</li>\r\n	<li>add the egg yolks, milk, and ice water a little while diuleni until smooth.</li>\r\n	<li>enter margarine and salt. knead until elastic. let stand 15 minutes.</li>\r\n	<li>kempiskan dough. weigh 25 grams each. rounded and pipihkan dough.</li>\r\n	<li>ditabru put diloyangkan and wheat flour. let stand 45 minutes until fluffy.</li>\r\n	<li>fried in solid oils that have been heated until cooked.</li>\r\n	<li>contents: heat the liquid milk. add the pieces of dark cooking chocolate. stir until dissolved.</li>\r\n	<li>let it warm. insert in a plastic bag triangle.</li>\r\n	<li>puncture sides with chopsticks. given the contents.</li>\r\n	<li>serve with a sprinkle of sugar donuts.</li>\r\n	<li>for 26 pieces</li>\r\n</ol>\r\n', '1534169245_9096-2015-09-25.jpg', '', 'cda11up', 'Post', '', 0, '', 0, '2020-06-17 07:07:14'),
(4, 5, 'Chicken Porridge', '48 Minutes', '<p><strong>SUMMARY :</strong></p>\r\n\r\n<p>Fresh ingredients in these dishes can help source metabolism is right for your family. Cooking recipe this one requires some cooking techniques that can sisajikan appropriately. The following recipe more</p>\r\n\r\n<hr />\r\n<p><strong>INGREDIENTS :</strong></p>\r\n\r\n<p>Porridge Ingredients :</p>\r\n\r\n<ul>\r\n	<li>200 grams of rice</li>\r\n	<li>2,000 ml chicken broth from chicken bones</li>\r\n	<li>1 tea spoon of salt</li>\r\n	<li>1 bay leaf</li>\r\n</ul>\r\n\r\n<p>Kuah Ingredients :</p>\r\n\r\n<ul>\r\n	<li>2 pieces (320 grams) chicken thighs, crushed bones</li>\r\n	<li>2 cm ginger, crushed</li>\r\n	<li>1/2 tablespoon salt</li>\r\n	<li>1 block chicken broth</li>\r\n	<li>1,000 ml of water</li>\r\n	<li>2 tablespoons oil for frying</li>\r\n	<li>the oil for frying</li>\r\n</ul>\r\n\r\n<p>Ground spices :</p>\r\n\r\n<ul>\r\n	<li>6 red onions</li>\r\n	<li>3 cloves garlic</li>\r\n	<li>1/4 teaspoon nutmeg</li>\r\n	<li>1/2 teaspoon ground pepper</li>\r\n	<li>2 eggs hazelnut, toasted</li>\r\n	<li>1 cm turmeric fuel</li>\r\n	<li>1/2 teaspoon coriander</li>\r\n</ul>\r\n\r\n<hr />\r\n<p><strong>DIRECTION :</strong></p>\r\n\r\n<ol>\r\n	<li>Porridge: boiled rice, chicken broth, salt and bay leaf, stirring until soft and creamy. Set aside.</li>\r\n	<li>Sauce: heat the oil. Saute ground spices and ginger until fragrant. Add chicken. Stir until the color changes. Add water, salt and chicken broth block. Cook over low heat until boiling and berkaldu. Remove the chicken. Fried chicken until cooked. Suwir-shredded chicken.</li>\r\n	<li>Serve the porridge with broth, shredded chicken, and complementary.</li>\r\n	<li>Serves 6</li>\r\n</ol>\r\n', '1534169292_6466-2015-09-25.jpg', '', 'cda11up', 'Post', '', 1, '', 1, '2021-10-01 09:20:15'),
(5, 6, 'Pepe Cake', '60 Minutes', '<p><strong>SUMMARY :</strong></p>\r\n\r\n<p>Pepe Cake Betawi&nbsp;recipes suitable to present to your friends or practiced for relatives at home. Traditional Cake recipe ingredient is actually not too troublesome and complicated. You can get it easily. If this dish has made sure the result yahut and delicious</p>\r\n\r\n<hr />\r\n<p><strong>INGREDIENTS :</strong></p>\r\n\r\n<ul>\r\n	<li>500 grams of corn starch</li>\r\n	<li>25 grams of rice flour</li>\r\n	<li>1 1/2 teaspoon salt</li>\r\n	<li>800 ml coconut milk from coconuts 11/2</li>\r\n	<li>50 ml water suji leaf (30 leaves suji, 1lembar pandan leaves, and 1 drop of light green dye)</li>\r\n	<li>4 drops of red dye chili</li>\r\n	<li>Syrup Ingredients:</li>\r\n	<li>500 ml water</li>\r\n	<li>500 grams sugar</li>\r\n	<li>2 pieces of pandan leaves</li>\r\n	<li>10 lime leaves, remove the leaves bones</li>\r\n</ul>\r\n\r\n<hr />\r\n<p><strong>DIRECTION :</strong></p>\r\n\r\n<ol>\r\n	<li>Mix the corn starch, rice flour, and salt. Enter the coconut milk a little,&nbsp;a little, stirring until dissolved. Set aside.</li>\r\n	<li>Boil the syrup ingredients over low heat until sugar is dissolved and fragrant. Filter. Measure 750 ml. Let warm.</li>\r\n	<li>Pour a little into the mixture of corn starch. Stir well. Filter.</li>\r\n	<li>Take 500 ml of the batter. Add water suji leaf. Stir well. The rest leave it white.</li>\r\n	<li>Pour 100 ml of white batter into pan 20x20x7 cm dialas plastic. Steam for 5 minutes over medium heat. Pour again 100 ml of white dough. Steam for 5 minutes.</li>\r\n	<li>Pour 100 ml of green dough. Steam for 5 minutes. Do alternately with the order of 2 layers of white dough and 1 layer of green dough.</li>\r\n	<li>Finally pour 100 ml of white dough that has been added red dye chili.</li>\r\n	<li>Steam for 20 minutes over medium heat until cooked. Refrigerate. Cut into pieces.</li>\r\n	<li>For 24 pieces</li>\r\n</ol>\r\n', '1534169331_4791-2015-09-25.jpg', '', 'cda11up', 'Post', '', 0, '', 0, '2020-06-17 07:07:14'),
(6, 5, 'Fat Rice', '30 Minutes', '<p><strong>SUMMARY :</strong></p>\r\n\r\n<p>Indonesia and Malaysia does have a lot in common. Even until the food was a lot of the same. Despite its name, nasi lemak but this dish similar to rice or rice savory uduk.</p>\r\n\r\n<hr />\r\n<p><strong>INGREDIENTS :</strong></p>\r\n\r\n<ul>\r\n	<li>250 grams of rice, washed</li>\r\n	<li>325 ml coconut milk from coconuts 1/4</li>\r\n	<li>1 pandan leaves</li>\r\n	<li>1 stalk lemongrass, crushed</li>\r\n	<li>3/4 teaspoon salt</li>\r\n	<li>5 red onions, thinly sliced</li>\r\n	<li>100 grams of anchovy jeans, fried</li>\r\n	<li>1 tablespoon tamarind water 1 teaspoon of tamarind</li>\r\n	<li>100 ml water</li>\r\n	<li>6 red chilies</li>\r\n	<li>4 red onions</li>\r\n	<li>1 clove garlic</li>\r\n	<li>1/2 teaspoon shrimp paste</li>\r\n	<li>1/4 teaspoon salt</li>\r\n	<li>1/2 teaspoon brown sugar, finely combed</li>\r\n</ul>\r\n\r\n<hr />\r\n<p><strong>DIRECTION :</strong></p>\r\n\r\n<ol>\r\n	<li>Nasi lemak, Wash rice and drain. Heat the coconut milk. Add pandan leaves, lemon grass, and salt. Stir until boiling. Add rice. Stir until absorbed. Steamed over medium heat 30 minutes until done.</li>\r\n	<li>Fish sauce, saute ground spices and onion until fragrant. Add water and acidic water.</li>\r\n	<li>Stir well. Enter the anchovies. Stir until bandaged. Angkat.Tumis chili grind until fragrant and cooked.</li>\r\n	<li>Serve rice together with fish sauce, chili grind, hard boiled eggs, fried peanuts and cucumber slices.</li>\r\n</ol>\r\n', '1534169376_1761-2015-09-25.jpg', '', 'cda11up', 'Post', '', 0, '', 3, '2021-09-29 13:51:07'),
(7, 4, 'Sate Padang', '45 Minutes', '<p><strong>SUMMARY :</strong></p>\r\n\r\n<p>Sate Padang has a lot of variations of it. Although the manner of presentation is similar but apparently of Sate Padang long, Sate Padang Pariaman and Sate Padang city has the difference respectively.</p>\r\n\r\n<hr />\r\n<p><strong>INGREDIENTS :</strong></p>\r\n\r\n<ul>\r\n	<li>250 grams of cow intestine, boiled, cut into 3 cm</li>\r\n	<li>300 grams of beef brisket</li>\r\n	<li>1,250 ml of water</li>\r\n	<li>2 bay leaves turmeric</li>\r\n	<li>1 stalk lemongrass, take the white, crushed</li>\r\n	<li>1 sour fruit kandis</li>\r\n	<li>40 grams of rice flour and 50 ml of water, dissolve to thickener</li>\r\n	<li>25 grams of peanuts peeled, roasted, coarsely chopped</li>\r\n	<li>2 tablespoons fried onions for topping</li>\r\n	<li>10 fruit skewers</li>\r\n</ul>\r\n\r\n<hr />\r\n<p><strong>DIRECTION :</strong></p>\r\n\r\n<ol>\r\n	<li>Boiled beef brisket with water until cooked and tender. Lift. Cut into 2 &times; 2 cm.</li>\r\n	<li>Measure the broth 1,000 ml.</li>\r\n	<li>Boil the meat along the intestine, spices, turmeric leaf, lemongrass, and kandis acid. Cook until the broth to 500 ml with a small flame.</li>\r\n	<li>Prick-prick meat, and intestines alternately on skewers. Fuel until fragrant.</li>\r\n	<li>Boil again the rest of the stew. Thicken with rice flour solution. Cook until bubbling.</li>\r\n	<li>Add peanuts. Stir well. Lift.</li>\r\n	<li>Serve skewers along with gravy and a sprinkling of fried onions.</li>\r\n	<li>For 10 sticks</li>\r\n</ol>\r\n', '1534169420_2461-2015-09-25.jpg', '', 'cda11up', 'Post', '', 0, '', 0, '2020-06-17 07:07:14'),
(8, 4, 'Soto Banjar', '25 Minutes', '<p><strong>SUMMARY :</strong></p>\r\n\r\n<p>Banjarmasin has dishes that are worth to try. One of them is a very delicious soup banjo for us to eat while cold air. Do not forget to serve it with the sauce if you are a lover of spicy dishes.</p>\r\n\r\n<hr />\r\n<p><strong>INGREDIENTS :</strong></p>\r\n\r\n<ul>\r\n	<li>1 whole chicken,</li>\r\n	<li>2,500 ml of water</li>\r\n	<li>5 grains clove</li>\r\n	<li>5 cm cinnamon</li>\r\n	<li>2 tablespoons salt</li>\r\n	<li>1/2 teaspoon ground pepper</li>\r\n	<li>2 teaspoons sugar</li>\r\n	<li>2 tablespoons oil for frying</li>\r\n	<li>15 red onions</li>\r\n	<li>8 cloves garlic</li>\r\n	<li>2 cm ginger</li>\r\n</ul>\r\n\r\n<hr />\r\n<p><strong>DIRECTION :</strong></p>\r\n\r\n<ol>\r\n	<li>Boil chicken in water with cloves, and cinnamon until tender. Set aside.</li>\r\n	<li>Heat the oil. Stir&nbsp;fry until fragrant spices. Pour into a chicken stew.</li>\r\n	<li>Add salt, pepper, and sugar. Cook until done.</li>\r\n	<li>Remove the chicken. Suwir&nbsp;shredded.</li>\r\n	<li>Serve chicken soup together complementary.</li>\r\n	<li>Serves 8</li>\r\n</ol>\r\n\r\n<p>&nbsp;</p>\r\n', '1534169472_4539-2015-09-25.jpg', '', 'cda11up', 'Post', '', 0, '', 0, '2020-06-17 07:07:14'),
(9, 4, 'Kaledo', '50 Minutes', '<p><strong>SUMMARY :</strong></p>\r\n\r\n<p>Kaledo is one dish of Palu made from cow bone existing bone marrow and meat tetelan. Fry dish with spicy sour taste is taste better with a squeeze of lime juice.</p>\r\n\r\n<hr />\r\n<p><strong>INGREDIENTS :</strong></p>\r\n\r\n<ul>\r\n	<li>3 pieces of cow leg bones are still no meat</li>\r\n	<li>400 grams of meat soup</li>\r\n	<li>3,000 ml of water</li>\r\n	<li>2 stalks lemongrass, crushed</li>\r\n	<li>3 cm ginger, crushed</li>\r\n	<li>2 bay leaves</li>\r\n	<li>8 pieces of green chili, mashed</li>\r\n	<li>7 unripe tamarind fruit</li>\r\n	<li>2 tablespoons salt</li>\r\n	<li>&frac12; teaspoon ground pepper</li>\r\n	<li>1 tablespoon sugar</li>\r\n	<li>2 limes</li>\r\n	<li>2 tablespoons fried onions</li>\r\n</ul>\r\n\r\n<hr />\r\n<p><strong>DIRECTION :</strong></p>\r\n\r\n<ul>\r\n	<li>Boil water, cow bones, meat, lemongrass, ginger, and bay leaves until berkaldu and tender.</li>\r\n	<li>Enter chili, tamarind, salt, pepper, and sugar. Cook until absorbed.</li>\r\n	<li>Serve kaledo together lemon juice and a sprinkling of fried onions.</li>\r\n	<li>Serves 8</li>\r\n</ul>\r\n', '1534169506_6189-2015-09-25.jpg', '', 'cda11up', 'Post', '', 0, '', 0, '2020-06-17 07:07:14'),
(10, 4, 'Gulai Gajebo', '55 Minutes', '<p><strong>SUMMARY :</strong></p>\r\n\r\n<p>Day of special dishes this one is very fitting for you serve and serve the beloved family. This dish is made from beef.</p>\r\n\r\n<hr />\r\n<p><strong>INGREDIENTS :</strong></p>\r\n\r\n<ul>\r\n	<li>400 grams of beef</li>\r\n	<li>1,500 ml of water</li>\r\n	<li>2 stalks lemongrass, taken whiteness, crushed</li>\r\n	<li>4 lime leaves, boned</li>\r\n	<li>2 cm galangal, crushed</li>\r\n	<li>2 bay leaves</li>\r\n	<li>1 1/2 teaspoon salt</li>\r\n	<li>1 teaspoon sugar</li>\r\n	<li>1 teaspoon of sour water</li>\r\n	<li>200 ml coconut milk from 1 coconut</li>\r\n	<li>2 tablespoons oil for frying</li>\r\n</ul>\r\n\r\n<hr />\r\n<p><strong>DIRECTION :</strong></p>\r\n\r\n<ol>\r\n	<li>Boil the meat and water until 3/4 cooked. Measure 1200 ml of broth.</li>\r\n	<li>Cut the meat against the fiber.</li>\r\n	<li>Heat the oil. Saute ground spices, lemon grass, lime leaves, galangal, and bay leaves until fragrant.</li>\r\n	<li>Pour broth. Cook until boiling.</li>\r\n	<li>Add the meat. Stir well.</li>\r\n	<li>Enter the coconut milk, salt, sugar, and acid water. Cook until done.</li>\r\n	<li>Serves 8</li>\r\n</ol>\r\n', '1534169697_2716-2015-09-25.jpg', '', 'cda11up', 'Post', '', 0, '', 0, '2020-06-17 07:07:14'),
(11, 6, 'Jongkong Cart', '45 Minutes', '<p><strong>SUMMARY :</strong></p>\r\n\r\n<p>The cake recipe this one when cooked according to the instructions would be a special dish of course. With materials that is relatively simple for those of you looking for the market or supermarket. The following recipes are more</p>\r\n\r\n<hr />\r\n<p><strong>INGREDIENTS :</strong></p>\r\n\r\n<ul>\r\n	<li>350 grams of cake basket, sliced</li>\r\n	<li>900 ml coconut milk from 1 coconut</li>\r\n	<li>325 grams sugar</li>\r\n	<li>3/4 teaspoon salt</li>\r\n	<li>260 grams of rice flour</li>\r\n	<li>75 grams of corn starch</li>\r\n	<li>110 ml coconut milk from coconuts 1/4</li>\r\n	<li>110 ml water suji leaf (35 leaves suji and 4 pieces pandan leaves)</li>\r\n	<li>2 drops of dark green dye</li>\r\n	<li>150 grams of grated coconut rough</li>\r\n	<li>1/4 teaspoon salt</li>\r\n	<li>1 pandan leaves</li>\r\n</ul>\r\n\r\n<hr />\r\n<p><strong>DIRECTION :</strong></p>\r\n\r\n<ol>\r\n	<li>Boil the coconut milk, sugar, and salt, stirring until boiling. Refrigerate. Measure 625 ml coconut milk.</li>\r\n	<li>Pour the coconut milk stew a little,&nbsp;a little to the rice flour and sago flour, stirring until smooth. Divide the dough in half.</li>\r\n	<li>One part add the coconut milk and pastry basket. Stir well. Add the remaining water suji leaves and green dye. Stir well. For each 6 parts.</li>\r\n	<li>Heat the pan 24x10x7 cm were smeared with oil and plastic dialas.</li>\r\n	<li>Pour 1 portion of dough green (75gr). Steam for 5 minutes over medium heat. Pour 1 part of cookie dough basket (75gr). Steam for 5 minutes over medium heat. Do alternately until the dough runs out. Lastly steam over medium heat 20 minutes until done.</li>\r\n	<li>After cold cut into pieces and serve with grated coconut.</li>\r\n	<li>For 12 pieces</li>\r\n</ol>\r\n', '1534169724_1633-2015-09-25.jpg', '', 'cda11up', 'Post', '', 0, '', 0, '2020-06-17 07:07:14'),
(12, 2, 'Red Bean Ice', '20 Minutes', '<p><strong>SUMMARY :</strong></p>\r\n\r\n<p>Recipes How to Make Red Bean Ice might be a special dish that you will serve. To prosese-making and how to cook this dish of course there are steps you must take before. But do not worry because the cooking step is not so troublesome to your practice</p>\r\n\r\n<hr />\r\n<p><strong>INGREDIENTS :</strong></p>\r\n\r\n<ul>\r\n	<li>200 grams of fresh red beans</li>\r\n	<li>150 sugar</li>\r\n	<li>3 cm cinnamon</li>\r\n	<li>1 teaspoon cocoa powder</li>\r\n	<li>250 ml water</li>\r\n	<li>200 grams of cassava,</li>\r\n	<li>100 grams of sweetened condensed milk chocolate</li>\r\n	<li>500 grams of shaved ice</li>\r\n</ul>\r\n\r\n<hr />\r\n<p><strong>DIRECTION :</strong></p>\r\n\r\n<ol>\r\n	<li>Presto 15 minutes until soft red beans. Drain. Measure 350 ml of water boiled.</li>\r\n	<li>Mix the remaining water presto, water, sugar, cinnamon, and cocoa powder. Stir well. Simmer over medium heat, stirring until boiling.</li>\r\n	<li>Enter the red beans. Cook until thick.</li>\r\n	<li>Serve red beans in a glass. Add pieces of cassava, shaved ice, sweetened condensed milk and chocolate.</li>\r\n	<li>To 5 servings</li>\r\n</ol>\r\n\r\n<p>&nbsp;</p>\r\n', '1534169756_4272-2015-09-25.jpg', '', 'cda11up', 'Post', '', 0, '', 1, '2020-11-05 06:55:08'),
(13, 4, 'Pepes Milkfish', '50 Minutes', '<p><strong>SUMMARY :</strong></p>\r\n\r\n<p>The joy is not only a spiced milkfish marinade seep from perfect, but also because of the maturation process that dipresto making it easier for us to enjoy it without fear of thorns.</p>\r\n\r\n<hr />\r\n<p><strong>INGREDIENTS :</strong></p>\r\n\r\n<ul>\r\n	<li>2 tail fresh milkfish (400 g)</li>\r\n	<li>3 teaspoons instant yeast</li>\r\n	<li>1,000 ml of water</li>\r\n	<li>3 tablespoons of cooking oil</li>\r\n	<li>250 grams of lemon grass, banana leaves crushed to pedestal</li>\r\n	<li>10 red onions</li>\r\n	<li>5 cloves garlic</li>\r\n	<li>4 grains of walnut</li>\r\n	<li>6 cm turmeric, burned</li>\r\n	<li>1 tablespoon salt</li>\r\n	<li>4 bay leaves</li>\r\n	<li>4 cm galangal</li>\r\n	<li>10 sprigs of basil leaves</li>\r\n	<li>10 kaffir lime leaves, thinly sliced</li>\r\n	<li>10 pieces of cayenne intact</li>\r\n	<li>2 red tomatoes</li>\r\n	<li>4 lemongrass</li>\r\n</ul>\r\n\r\n<hr />\r\n<p><strong>DIRECTION :</strong></p>\r\n\r\n<ol>\r\n	<li>Stir spices and presto instant yeast.</li>\r\n	<li>Spread evenly throughout the milk. Let stand 1 hour.</li>\r\n	<li>Place the lemongrass in the bottom of the pan presto. Enter the fish. Pour water. Presto 2 1/2 hours.</li>\r\n	<li>Lift the milk and let cool.</li>\r\n	<li>Stir well spiced ground spices and seasoning slices. Lumurkan to the entire body of milkfish presto.</li>\r\n	<li>Take a piece of banana leaf. Wrap milkfish like Pepes. Steam for 40 minutes.</li>\r\n	<li>Grilled over the coals.</li>\r\n	<li>Serves 6</li>\r\n</ol>\r\n', '1534169793_3664-2015-09-25.jpg', '', 'cda11up', 'Post', '', 0, '', 0, '2020-06-17 07:07:14'),
(14, 4, 'Tempe Penyetan', '20 Minutes', '<p><strong>SUMMARY :</strong></p>\r\n\r\n<p>Recipe ingredients make this dish was not too troublesome and complicated. You can get it easily. If this dish has made sure the result yahut and delicious</p>\r\n\r\n<hr />\r\n<p><strong>INGREDIENTS :</strong></p>\r\n\r\n<ul>\r\n	<li>6 pieces of tempeh triangles, baked until fragrant</li>\r\n	<li>2 sprigs of basil, dipetiki for sprinkling</li>\r\n	<li>3 cloves garlic, fried</li>\r\n	<li>5 red onions, fried</li>\r\n	<li>12 curly red chilies, fried</li>\r\n	<li>2 pieces of red chili sauce, fried</li>\r\n</ul>\r\n\r\n<hr />\r\n<p><strong>DIRECTION :</strong></p>\r\n\r\n<ol>\r\n	<li>Grind the garlic, onion, red chili curly, red chili sauce, pecans, shrimp paste, salt and brown sugar until smooth. Enter tomatoes. Flat grind.</li>\r\n	<li>Put the sauce over the tempeh. Press tempeh until slightly bruised.</li>\r\n	<li>Serve along with a sprinkling of basil tempeh.</li>\r\n	<li>Serves 6</li>\r\n</ol>\r\n', '1534169822_6632-2015-09-25.jpg', '', 'cda11up', 'Post', '', 0, '', 0, '2020-06-17 07:07:14'),
(24, 2, 'Fresh Fruit Ice', '15 Minutes', '<p><strong>SUMMARY :</strong></p>\r\n\r\n<p>Recipe ingredients make this dish was not too troublesome and complicated. You can get it easily. If this dish has made sure the result yahut and delicious</p>\r\n\r\n<hr />\r\n<p><strong>INGREDIENTS :</strong></p>\r\n\r\n<ul>\r\n	<li>6 pieces of tempeh triangles, baked until fragrant</li>\r\n	<li>2 sprigs of basil, dipetiki for sprinkling</li>\r\n	<li>3 cloves garlic, fried</li>\r\n	<li>5 red onions, fried</li>\r\n	<li>12 curly red chilies, fried</li>\r\n	<li>2 pieces of red chili sauce, fried</li>\r\n	<li>1 red tomatoes, cut in 2 parts, fried</li>\r\n	<li>2 eggs hazelnut, fried</li>\r\n	<li>1/2 tablespoon shrimp paste, fried</li>\r\n	<li>1 tea spoon of salt</li>\r\n	<li>1 teaspoon brown sugar</li>\r\n</ul>\r\n\r\n<hr />\r\n<p><strong>DIRECTION :</strong></p>\r\n\r\n<ol>\r\n	<li>Grind the garlic, onion, red chili curly, red chili sauce, pecans, shrimp paste, salt and brown sugar until smooth. Enter tomatoes. Flat grind.</li>\r\n	<li>Put the sauce over the tempeh. Press tempeh until slightly bruised.</li>\r\n	<li>Serve along with a sprinkling of basil tempeh.</li>\r\n	<li>Serves 6</li>\r\n</ol>\r\n', '1534169847_6594-2015-09-26.jpg', '', 'cda11up', 'Post', '', 0, '', 0, '2020-06-17 07:07:14'),
(25, 1, 'Doger Ice', '10 Minutes', '<p><strong>SUMMARY :</strong></p>\r\n\r\n<p>Doger Ice very delicious when served in cold drinks like this. Not less delicious with soft green grass jelly and cold on the throat.</p>\r\n\r\n<hr />\r\n<p><strong>INGREDIENTS :</strong></p>\r\n\r\n<ul>\r\n	<li>200 grams of green grass jelly</li>\r\n	<li>500 ml of water kopyor</li>\r\n	<li>125 ml syrup frambozen</li>\r\n	<li>500 grams of shaved ice</li>\r\n	<li>600 ml coconut milk from coconuts 1/2</li>\r\n	<li>3/4 teaspoon salt</li>\r\n	<li>2 pieces of pandan leaves, tie knot</li>\r\n</ul>\r\n\r\n<hr />\r\n<p><strong>DIRECTION :</strong></p>\r\n\r\n<ol>\r\n	<li>Coconut milk, boiled milk, salt and pandan, stirring until boiling. Allow to cool</li>\r\n	<li>Spoon the green grass jelly. Add shaved ice. Flush with syrup and coconut milk.</li>\r\n	<li>To 5 servings</li>\r\n</ol>\r\n', '1534169925_1562-2015-09-25.jpg', '', 'cda11up', 'Post', '', 0, '', 1, '2020-08-21 16:15:02'),
(29, 1, 'Cincau Ice', '18 Minutes', '<p><strong>SUMMARY :</strong></p>\r\n\r\n<p>Cincau Ice feels very delicious when served in cold drinks like this. Not less delicious with soft green grass jelly and cold on the throat.</p>\r\n\r\n<hr />\r\n<p><strong>INGREDIENTS :</strong></p>\r\n\r\n<ul>\r\n	<li>200 grams of green grass jelly</li>\r\n	<li>500 ml of water kopyor</li>\r\n	<li>125 ml syrup frambozen</li>\r\n	<li>500 grams of shaved ice</li>\r\n	<li>600 ml coconut milk from coconuts 1/2</li>\r\n	<li>3/4 teaspoon salt</li>\r\n	<li>2 pieces of pandan leaves, tie knot</li>\r\n</ul>\r\n\r\n<hr />\r\n<p><strong>DIRECTION :</strong></p>\r\n\r\n<ol>\r\n	<li>Coconut milk, boiled milk, salt and pandan, stirring until boiling. Allow to cool</li>\r\n	<li>Spoon the green grass jelly. Add shaved ice. Flush with syrup and coconut milk.</li>\r\n	<li>To 5 servings</li>\r\n</ol>\r\n', '1534169953_4689-2015-09-25.jpg', '', 'cda11up', 'Post', '', 0, '', 0, '2020-06-17 07:07:14'),
(30, 6, 'French Fries', '20 Minutes', '<p><strong>SUMMARY :</strong></p>\r\n\r\n<p>You are wanted snacked on something, but did not have much time to make a snack. Easy. Create fries. To be more crunchy, dip first in the flour mixture. Serve with fresh sauces.</p>\r\n\r\n<hr />\r\n<p><strong>INGREDIENTS :</strong></p>\r\n\r\n<ul>\r\n	<li>500 grams of potatoes, cut into wedges</li>\r\n	<li>the oil for frying</li>\r\n	<li>100 grams of wheat flour</li>\r\n	<li>1/2 teaspoon salt</li>\r\n	<li>50 grams of wheat flour</li>\r\n	<li>1 tablespoon cornstarch</li>\r\n	<li>1/2 teaspoon baking powder</li>\r\n	<li>1/2 teaspoon oregano</li>\r\n	<li>1 tea spoon of salt</li>\r\n	<li>1/2 teaspoon chili powder</li>\r\n	<li>100 ml of ice water</li>\r\n</ul>\r\n\r\n<hr />\r\n<p><strong>DIRECTION :</strong></p>\r\n\r\n<ol>\r\n	<li>Dyers, stir the flour, cornstarch, baking powder, oregano, salt, chili powder and water ice. Enter oregano and chili powder. Stir well.</li>\r\n	<li>Potato dip into dye. Roll over the upholstery.</li>\r\n	<li>Fried in oil that has been heated until cooked.</li>\r\n	<li>Serve the potatoes together with the sauce.</li>\r\n	<li>Makes 4 servings</li>\r\n</ol>\r\n', '1534169975_0381-2015-09-25.jpg', '', 'cda11up', 'Post', '', 0, '', 2, '2020-08-21 16:11:49'),
(37, 6, 'Pumpkin Soup', '30 Minutes', '<p><strong>SUMMARY :</strong></p>\r\n\r\n<p>A perfect time for a spicy pumpkin soup! This soup comes together quickly, and has warm notes of ginger, curry, cumin, coriander, and black pepper.&nbsp;Great flavor additions that enhance not detract from the pumpkin.</p>\r\n\r\n<hr />\r\n<p><strong>INGREDIENTS :</strong></p>\r\n\r\n<ul>\r\n	<li>1&nbsp;Tbsp unsalted butter</li>\r\n	<li>1 1/2&nbsp;cups roughly chopped yellow onion</li>\r\n	<li>2&nbsp;cloves garlic, minced (about 2 teaspoons)</li>\r\n	<li>2 teaspoons&nbsp;minced, peeled fresh ginger</li>\r\n	<li>1 1/2&nbsp;teaspoons yellow curry powder</li>\r\n	<li>3/4&nbsp;teaspoon ground cumin</li>\r\n	<li>1/2 teaspoon ground coriander</li>\r\n	<li>Small pinch of cinnamon</li>\r\n	<li>1 teaspoon of kosher salt plus more to taste</li>\r\n	<li>4&nbsp;cups chicken stock (or vegetable broth for vegetarian option)</li>\r\n	<li>2 bay leaves</li>\r\n	<li>2&nbsp;(15 oz) cans 100 percent pumpkin or 3 1/2&nbsp;cups of chopped roasted pumpkin pur&eacute;e*</li>\r\n	<li>1 cup water</li>\r\n	<li>3&nbsp;Tbsp heavy whipping cream</li>\r\n	<li>1/8 teaspoon black pepper</li>\r\n	<li>Yogurt (for garnish)</li>\r\n</ul>\r\n\r\n<hr />\r\n<p><strong>DIRECTION :</strong></p>\r\n\r\n<ol>\r\n	<li>Melt&nbsp;butter&nbsp;in a large (5 to 6 quart), thick-bottomed pot over medium heat. Add the&nbsp;onions&nbsp;and&nbsp;saut&eacute; until softened, about 5 to 6&nbsp;minutes.&nbsp;Add the minced&nbsp;garlic&nbsp;and&nbsp;ginger, cook another minute.&nbsp;Add the&nbsp;curry powder,&nbsp;cumin,&nbsp;coriander,&nbsp;cinnamon, and&nbsp;salt. Cook for another 2 minutes.</li>\r\n	<li>Add the&nbsp;chicken stock&nbsp;and the&nbsp;bay leaves.&nbsp;Add the&nbsp;pumpkin pur&eacute;e&nbsp;and the&nbsp;water. Stir to combine. If the soup is too thick for your taste, add more stock or water to thin it.&nbsp;Increase heat to high. Bring to a boil and reduce heat to low, cover and simmer for 10 to 15 minutes.</li>\r\n	<li>Remove bay leaves. Use an immersion blender to pur&eacute;e the soup.</li>\r\n	<li>Right before serving, stir in the&nbsp;cream. Add&nbsp;black pepper&nbsp;and adjust seasonings to taste. Add more salt if necessary.&nbsp;Drizzle with plain&nbsp;yogurt&nbsp;that has been thinned with a little water and sprinkle with&nbsp;toasted pumpkin seeds&nbsp;to serve.</li>\r\n</ol>\r\n', '1534170206_2003-2015-11-15.jpg', '', 'cda11up', 'Post', '', 0, '', 1, '2020-08-21 16:11:21'),
(38, 4, 'Broiled Lobster', '25 Minutes', '<p><strong>SUMMARY :</strong></p>\r\n\r\n<p>Broiled lobster tail, the quintessential fancy dinner menu item. Unlike whole boiled or steamed lobster, which is almost impossible to eat delicately, with broiled lobster tail the work has already been done for you.</p>\r\n\r\n<hr />\r\n<p><strong>INGREDIENTS :</strong></p>\r\n\r\n<ul>\r\n	<li>2 lobster tails 6-8 ounces each, fresh or frozen</li>\r\n	<li>1/4 cup unsalted raw hazelnuts</li>\r\n	<li>8 Tbsp unsalted butter</li>\r\n	<li>2 Tbsp minced shallots</li>\r\n	<li>1 teaspoon chopped fresh parsley</li>\r\n	<li>1/4 teaspoon grated lemon zest</li>\r\n	<li>Pinch of salt</li>\r\n</ul>\r\n\r\n<hr />\r\n<p><strong>DIRECTION :</strong></p>\r\n\r\n<ol>\r\n	<li>Toast hazelnuts in a small skillet on medium to medium high heat. When fragrant and lightly browned, remove hazelnuts from pan and place in the center a dry, clean dish towel. Rub the hazelnuts together inside of the dish towel to remove as much of the papery dark skins as you can. Coarsely chop them and set aside.&nbsp;broiled-lobster-browned-butter-1 broiled-lobster-browned-butter-2 broiled-lobster-browned-butter-3 broiled-lobster-browned-butter-4</li>\r\n	<li>In a small stainless steel saucepan, melt the butter on medium heat. (Use stainless so you will easily be able to tell when the butter is browning.) After the butter melts, it will foam up, and recede. The milk solids will fall to the bottom of the pan. Continue to heat and the milk solids will start to brown giving the melted butter a wonderful nutty aroma. Let most of the milk solids brown and then remove from heat and strain through a fine mesh strainer into a bowl, to remove the browned milk solids. &nbsp;Remove 2 Tbsp of the melted browned butter and set aside (they will be brushed on to the lobster tails before broiling. (See more details in How to Brown Butter.)</li>\r\n	<li>To the remaining brown butter, add the chopped hazelnuts, parsley, shallots, lemon zest and salt. Set aside.&nbsp;broiled-lobster-4a broiled-lobster-4cbroiled-lobster-4b broiled-lobster-4d</li>\r\n	<li>Place rack in medium position in oven. Preheat broiler. Place a layer of foil over a broiling pan or roasting pan. Using kitchen shears or strong scissors, cut the top side of the lobster tail shells lengthwise, from open end to the base of the tail. To help make the shell easier to teal with, put the tail upside-down in the palm of your hand and squeeze to break the translucent bottom shell (see this useful video I found on YouTube). Grip the sides of the shell and pull open by about an inch or two. Using your finger, carefully wiggle between the lobster meat and the shell and separate the meat from the shell. &nbsp; Then gently pull the meat up through the crack you&#39;ve created, keeping the meat attached to the tail, and let the lobster meat sit on top of the shell. Place the tails on the foil-lined broiling pan.&nbsp;broiled-lobster-5a broiled-lobster-5b</li>\r\n	<li>Pull back the lobster meat to expose as much of it as possible. Brush the exposed lobster meat with the unadorned browned butter you set aside in step 2. Broil for 7 to 10 minutes until the meat is cooked through (less time for smaller lobster tails), and the shells are bright red. I recommend using a meat thermometer, which should read 145&deg;F when the lobster is done.</li>\r\n	<li>When the lobster tails are done, remove from oven and place on serving plates. Spoon the browned butter hazelnut sauce over the lobster meat of the lobster tails to serve.</li>\r\n</ol>\r\n', '1534170236_6285-2015-11-15.jpg', '', 'cda11up', 'Post', '', 1, '', 11, '2021-10-01 09:19:53'),
(43, 4, 'Miso Soup Recipe', '20 Minutes', '<p><strong>SUMMARY</strong></p>\r\n\r\n<p>Most Japanese meals are served with a bowl of steamed rice and a traditional Japanese soup called&nbsp;<strong>Miso Soup</strong>&nbsp;(味噌汁). Depending on the region, season, and personal preference, you can find many varieties of miso soup enjoyed in Japan. In addition to the classic tofu and wakame combination, we also use a lot of different ingredients to make the soup. That&rsquo;s why we can never get bored with it.</p>\r\n\r\n<p><strong>INGREDIENTS </strong>that are added BEFORE bringing dashi to a boil</p>\r\n\r\n<ul>\r\n	<li>Carrot</li>\r\n	<li>Clams</li>\r\n	<li>Daikon radish</li>\r\n	<li>Kabocha squash/pumpkin</li>\r\n	<li>Manila clams</li>\r\n	<li>Onion</li>\r\n	<li>Potato</li>\r\n	<li>Turnip</li>\r\n</ul>\r\n\r\n<p><strong>INGREDIENTS </strong>that are added AFTER dashi is boiling</p>\r\n\r\n<ul>\r\n	<li>Aburaage (deep-fried tofu pouch)</li>\r\n	<li>Bean sprouts</li>\r\n	<li>Cabbage/napa cabbage</li>\r\n	<li>Egg</li>\r\n	<li>Eggplant</li>\r\n	<li>Green onions/scallions</li>\r\n	<li>Mushrooms such as enoki, maitake, nameko, shiitake, shimeji, etc</li>\r\n	<li>Negi (long green onion/leeks)</li>\r\n	<li>Okra</li>\r\n	<li>Somen noodles</li>\r\n	<li>Spinach</li>\r\n	<li>Tofu (silken or medium firm)</li>\r\n	<li>Wakame seaweed</li>\r\n	<li>Yuba (soybean curd)</li>\r\n</ul>\r\n', '', 'https://www.youtube.com/watch?v=lH7pgsnyGrI', 'lH7pgsnyGrI', 'youtube', '', 1, '', 10, '2021-09-30 02:44:58'),
(44, 4, 'Bread Cone Samosa', '30 Minutes', '<p><strong>Ingredients</strong></p>\r\n\r\n<ul>\r\n	<li>Cooking oil 2 tbs</li>\r\n	<li>Chicken boneless small cubes 250g</li>\r\n	<li>Adrak lehsan paste (Ginger garlic paste) 1 tbs</li>\r\n	<li>Dahi (Yogurt) 23 tbs</li>\r\n	<li>Tandoori masala 1 &amp; &frac12; tbs</li>\r\n	<li>Bund gobhi (Cabbage) 1 &amp; &frac12; Cup</li>\r\n	<li>Hara pyaz (Green onion) chopped 1/4 Cup&nbsp;</li>\r\n	<li>Kali mirch (Black pepper) crushed 1 tsp</li>\r\n	<li>Namak (Salt) &frac12; tsp or to taste</li>\r\n	<li>Mayonnaise 3 tbs</li>\r\n	<li>Tomato ketchup 2 tbs</li>\r\n	<li>Maida (Allpurpose flour) 3 tbs&nbsp;</li>\r\n	<li>Water 2 tbs or as required &nbsp;</li>\r\n	<li>Bread slices fresh 1415&nbsp;</li>\r\n	<li>Mozzarella cheese grated as required&nbsp;</li>\r\n	<li>Anday (Eggs) 2</li>\r\n	<li>Water 2 tbs</li>\r\n	<li>Namak (Salt) 1/4 tsp or to taste&nbsp;</li>\r\n	<li>Kali mirch powder (Black pepper powder) &frac12; tsp</li>\r\n	<li>Breadcrumbs 1 Cup or as required&nbsp;</li>\r\n	<li>Cooking oil for frying&nbsp;</li>\r\n</ul>\r\n\r\n<p><strong>Directions</strong></p>\r\n\r\n<ul>\r\n	<li>In a wok,add cooking oil,chicken,ginger garlic paste,yogurt,tandoori masala,mix well and cook until chicken is done (approx. 1012 minutes) then cook on high flame until it dries up &amp; let it cool.</li>\r\n	<li>In a bowl,add cabbage,green onion,black pepper crushed,salt,mayonnaise,tomato ketchup and mix well.</li>\r\n	<li>Now add cooked tandoori chicken,mix well &amp; set aside.</li>\r\n	<li>In a small bowl,add allpurpose flour,water and whisk well until smooth.Flour slurry is ready!</li>\r\n	<li>Cut corners of bread slices and roll out with the help of rolling pin.</li>\r\n	<li>Brush flour slurry on one side of bread and fold bread slice to make a cone,add chicken filling (1 &amp; &frac12; tbs),mozzarella cheese (1tbs),apply flour slurry on the edges and bring the edges together and seal the edges properly.</li>\r\n	<li>In a bowl,add eggs,water,salt,black pepper powder and whisk well.</li>\r\n	<li>Now dip cones into beaten eggs and coat in breadcrumbs (makes 1415).&nbsp;</li>\r\n	<li>In wok,heat cooking oil and fry cones on medium flame until golden brown.</li>\r\n</ul>\r\n', '', 'https://www.youtube.com/watch?v=foYcuL-8vS4', 'foYcuL-8vS4', 'youtube', '', 0, '', 11, '2021-09-30 01:27:36'),
(45, 6, 'Chicken Paratha Roll', '28 Minutes', '<p><strong>Ingredients:</strong></p>\r\n\r\n<ul>\r\n	<li>Mon salwa Chicken nuggets 810&nbsp;</li>\r\n	<li>Cooking oil for frying&nbsp;</li>\r\n	<li>Cooking oil 23 tbs</li>\r\n	<li>Bund gobhi (Cabbage) 1 Cup</li>\r\n	<li>Shimla mirch (Capsicum) julienne 1 medium&nbsp;</li>\r\n	<li>Pyaz (Onion) sliced 1 medium&nbsp;</li>\r\n	<li>Lal mirch powder (Red chilli powder) 1 tsp or to taste&nbsp;</li>\r\n	<li>Garam masala powder &frac12; tsp</li>\r\n	<li>Kali mirch (Black pepper) crushed &frac12; tsp</li>\r\n	<li>Namak (Salt) &frac12; tsp or to taste</li>\r\n	<li>Hara dhania (Fresh coriander) chopped 12 tbs</li>\r\n	<li>Lemon juice 1 &amp; &frac12; tbs</li>\r\n	<li>Cream 100ml&nbsp;</li>\r\n	<li>Cheddar cheese grated 50g</li>\r\n	<li>Lal mirch (Red chilli) crushed 1 tsp</li>\r\n	<li>Lehsan powder (Garlic powder) &frac12; tsp</li>\r\n	<li>Namak (Salt) 1 pinch or to taste&nbsp;</li>\r\n	<li>Mon salwa plain paratha</li>\r\n</ul>\r\n\r\n<p><strong>Directions:</strong></p>\r\n\r\n<ul>\r\n	<li>In a wok,heat cooking oil and fry nuggets on medium low flame until golden brown (approx. 34 minutes).</li>\r\n	<li>In a wok,add cooking oil,cabbage,capsicum,onion and mix well.</li>\r\n	<li>Add red chilli powder,garam masala powder,black pepper crushed,salt,fresh coriander and mix well.</li>\r\n	<li>Add lemon juice and stir fry for 1 minute &amp; set aside.</li>\r\n	<li>Cream &amp; Cheese Sauce:</li>\r\n	<li>In a bowl,add cream,cheddar cheese,red chilli crushed,garlic powder,salt and microwave for 30 seconds then mix well &amp; set aside.&nbsp;</li>\r\n	<li>Heat griddle,place paratha,brush oil and cook from both sides until done.</li>\r\n	<li>Assembling:</li>\r\n	<li>On paratha,drizzle tomato ketchup,stir fried vegetables,fried chicken nuggets and drizzle prepared cream &amp; cheese sauce,warp in butter paper &amp; serve!</li>\r\n</ul>\r\n', '', 'https://www.youtube.com/watch?v=yHq12RVhupY', 'yHq12RVhupY', 'youtube', '', 0, '', 21, '2021-09-30 05:18:08'),
(46, 4, 'Javanese Fried Rice', '20 Minutes', '<p>In this rainy season, at night it&#39;s delicious to eat fried rice, when the weather outside the rain that never stops will make you confused as much as possible. Therefore I will give you a reliable fried rice recipe for you who are cold and hungry. Come on, immediately refer to and practice the fried rice recipe below</p>\r\n\r\n<p><strong>INGREDIENTS</strong><br />\r\n<strong>The main ingredient</strong></p>\r\n\r\n<ul>\r\n	<li>1.5 White Rice Dishes that are not too wet, let them cool first</li>\r\n	<li>3 Teaspoons Cooking Oil for sauteing seasonings</li>\r\n	<li>3 Sheets are sliced ​​roughly, or you can taste</li>\r\n	<li>1 Shallot stems sliced ​​approximately 1-2 CM</li>\r\n	<li>2 Shake the eggs in a bowl and add salt to taste</li>\r\n	<li>1 Spoon of Soy Sauce or give enough, this is only an estimate</li>\r\n	<li>2 Teaspoon Salt or give enough, this is only an estimate</li>\r\n	<li>1 Flavoring Teaspoons (Mincin, Masako, Roko) according to taste</li>\r\n	<li>2 Spoon the Fried Onion Tea or give it to taste, this is only an estimate</li>\r\n	<li>Ground spices</li>\r\n	<li>1 Red chili finely chopped or coarse according to taste</li>\r\n	<li>2 Cracked chili fruit</li>\r\n	<li>3 Siung Bawang Putih is mashed</li>\r\n	<li>4 Shallots are mashed</li>\r\n	<li>2 Candlenut Grind is smoothed</li>\r\n	<li>1/2 Spoon of Pepper Tea is mashed</li>\r\n	<li>1/2 Teaspoon Ebi roasted</li>\r\n</ul>\r\n\r\n<p><strong>Supplementary material</strong></p>\r\n\r\n<ul>\r\n	<li>1 Sliced ​​cucumber</li>\r\n	<li>1 Tomato sliced</li>\r\n	<li>5 Lettuce Sheets</li>\r\n</ul>\r\n\r\n<p><strong>INSTRUCTIONS</strong><br />\r\n<strong>Prepare the Saute / Roasted Seasoning</strong></p>\r\n\r\n<ul>\r\n	<li>Heat a frying pan containing 3 teaspoons of cooking oil, then saute the ingredients above.</li>\r\n	<li>Add ingredients (Red Chili, Rawit Chili, Garlic, Red Onion, Candlenut, Pepper, Ebi)</li>\r\n	<li>After the aroma comes out, input (Onion, Egg, Cabbage) stir well, if less oil can be added to taste</li>\r\n</ul>\r\n\r\n<p><strong>Enter Main Ingredients</strong></p>\r\n\r\n<ul>\r\n	<li>Put white rice into the pan, stir until evenly distributed.</li>\r\n	<li>Input (Salt, Sweet Soy, Flavoring Flavor,) Stir until evenly distributed. If it is less soy sauce, it can be added according to taste.</li>\r\n	<li>Add fried onions, stir until evenly distributed.</li>\r\n</ul>\r\n\r\n<p><strong>Serve</strong></p>\r\n\r\n<ul>\r\n	<li>If it is considered cooked and all the spices are evenly distributed, turn off the stove and ready to serve.</li>\r\n	<li>Prepare slices of cucumber, tomatoes and lettuce on a plate.</li>\r\n	<li>Print fried rice with a bowl like in the picture.</li>\r\n	<li>FINISH, java fried rice is ready to serve</li>\r\n</ul>\r\n', '1588779773_nasgor3.jpg', '', 'cda11up', 'Post', '', 1, '', 46, '2021-10-01 09:20:07');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_recipes_gallery`
--

CREATE TABLE `tbl_recipes_gallery` (
  `id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `image_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_recipes_gallery`
--

INSERT INTO `tbl_recipes_gallery` (`id`, `recipe_id`, `image_name`) VALUES
(4, 38, '1588779046_broiledlobster.jpg'),
(5, 6, '1588779307_nasilemak1.jpg'),
(6, 6, '1588779307_nasilemak2.jpg'),
(7, 46, '1588779773_nasgor2.jpg'),
(8, 46, '1588779773_nasgor1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

CREATE TABLE `tbl_settings` (
  `id` int(11) NOT NULL,
  `app_fcm_key` text NOT NULL,
  `api_key` varchar(255) NOT NULL,
  `package_name` varchar(255) NOT NULL DEFAULT 'com.app.yourrecipesapp',
  `onesignal_app_id` varchar(500) NOT NULL DEFAULT '0',
  `onesignal_rest_api_key` varchar(500) NOT NULL DEFAULT '0',
  `providers` varchar(45) NOT NULL DEFAULT 'onesignal',
  `protocol_type` varchar(10) NOT NULL DEFAULT 'http',
  `fcm_notification_topic` varchar(255) NOT NULL DEFAULT 'your_recipes_app_topic',
  `more_apps_url` text NOT NULL,
  `privacy_policy` text NOT NULL,
  `youtube_api_key` varchar(255) NOT NULL DEFAULT '0',
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_settings`
--

INSERT INTO `tbl_settings` (`id`, `app_fcm_key`, `api_key`, `package_name`, `onesignal_app_id`, `onesignal_rest_api_key`, `providers`, `protocol_type`, `fcm_notification_topic`, `more_apps_url`, `privacy_policy`, `youtube_api_key`, `last_update`) VALUES
(1, '0', 'cda11Uib7PLEA8pjKehSVfY0vdHsXI269J3MlqcGatWZBmxOgR', 'com.app.yourrecipesapp', '0', '0', 'firebase', 'http', 'your_recipes_app_topic', 'https://play.google.com/store/apps/developer?id=Solodroid', '<p><strong>Privacy Policy</strong></p>\r\n\r\n<p>Solodroid built the Your Recipes App app as a Free app. This SERVICE is provided by Solodroid at no cost and is intended for use as is.</p>\r\n\r\n<p>This page is used to inform visitors regarding our policies with the collection, use, and disclosure of Personal Information if anyone decided to use our Service.</p>\r\n\r\n<p>If you choose to use our Service, then you agree to the collection and use of information in relation to this policy. The Personal Information that we collect is used for providing and improving the Service. We will not use or share your information with anyone except as described in this Privacy Policy.</p>\r\n\r\n<p>The terms used in this Privacy Policy have the same meanings as in our Terms and Conditions, which is accessible at Your Recipes App unless otherwise defined in this Privacy Policy.</p>\r\n\r\n<p><strong>Information Collection and Use</strong></p>\r\n\r\n<p>For a better experience, while using our Service, we may require you to provide us with certain personally identifiable information. The information that we request will be retained by us and used as described in this privacy policy.</p>\r\n\r\n<p>The app does use third party services that may collect information used to identify you.</p>\r\n\r\n<p>Link to privacy policy of third party service providers used by the app</p>\r\n\r\n<ul>\r\n	<li><a href=\"https://www.google.com/policies/privacy/\" target=\"_blank\">Google Play Services</a></li>\r\n	<li><a href=\"https://support.google.com/admob/answer/6128543?hl=en\" target=\"_blank\">AdMob</a></li>\r\n	<li><a href=\"https://firebase.google.com/policies/analytics\" target=\"_blank\">Google Analytics for Firebase</a></li>\r\n	<li><a href=\"https://www.facebook.com/about/privacy/update/printable\" target=\"_blank\">Facebook</a></li>\r\n	<li><a href=\"https://unity3d.com/legal/privacy-policy\" target=\"_blank\">Unity</a></li>\r\n	<li><a href=\"https://onesignal.com/privacy_policy\" target=\"_blank\">One Signal</a></li>\r\n	<li><a href=\"https://www.applovin.com/privacy/\" target=\"_blank\">AppLovin</a></li>\r\n	<li><a href=\"https://www.startapp.com/privacy/\" target=\"_blank\">StartApp</a></li>\r\n</ul>\r\n\r\n<p><strong>Log Data</strong></p>\r\n\r\n<p>We want to inform you that whenever you use our Service, in a case of an error in the app we collect data and information (through third party products) on your phone called Log Data. This Log Data may include information such as your device Internet Protocol (&ldquo;IP&rdquo;) address, device name, operating system version, the configuration of the app when utilizing our Service, the time and date of your use of the Service, and other statistics.</p>\r\n\r\n<p><strong>Cookies</strong></p>\r\n\r\n<p>Cookies are files with a small amount of data that are commonly used as anonymous unique identifiers. These are sent to your browser from the websites that you visit and are stored on your device&#39;s internal memory.</p>\r\n\r\n<p>This Service does not use these &ldquo;cookies&rdquo; explicitly. However, the app may use third party code and libraries that use &ldquo;cookies&rdquo; to collect information and improve their services. You have the option to either accept or refuse these cookies and know when a cookie is being sent to your device. If you choose to refuse our cookies, you may not be able to use some portions of this Service.</p>\r\n\r\n<p><strong>Service Providers</strong></p>\r\n\r\n<p>We may employ third-party companies and individuals due to the following reasons:</p>\r\n\r\n<ul>\r\n	<li>To facilitate our Service;</li>\r\n	<li>To provide the Service on our behalf;</li>\r\n	<li>To perform Service-related services; or</li>\r\n	<li>To assist us in analyzing how our Service is used.</li>\r\n</ul>\r\n\r\n<p>We want to inform users of this Service that these third parties have access to your Personal Information. The reason is to perform the tasks assigned to them on our behalf. However, they are obligated not to disclose or use the information for any other purpose.</p>\r\n\r\n<p><strong>Security</strong></p>\r\n\r\n<p>We value your trust in providing us your Personal Information, thus we are striving to use commercially acceptable means of protecting it. But remember that no method of transmission over the internet, or method of electronic storage is 100% secure and reliable, and we cannot guarantee its absolute security.</p>\r\n\r\n<p><strong>Links to Other Sites</strong></p>\r\n\r\n<p>This Service may contain links to other sites. If you click on a third-party link, you will be directed to that site. Note that these external sites are not operated by us. Therefore, we strongly advise you to review the Privacy Policy of these websites. We have no control over and assume no responsibility for the content, privacy policies, or practices of any third-party sites or services.</p>\r\n\r\n<p><strong>Children&rsquo;s Privacy</strong></p>\r\n\r\n<p>These Services do not address anyone under the age of 13. We do not knowingly collect personally identifiable information from children under 13 years of age. In the case we discover that a child under 13 has provided us with personal information, we immediately delete this from our servers. If you are a parent or guardian and you are aware that your child has provided us with personal information, please contact us so that we will be able to do necessary actions.</p>\r\n\r\n<p><strong>Changes to This Privacy Policy</strong></p>\r\n\r\n<p>We may update our Privacy Policy from time to time. Thus, you are advised to review this page periodically for any changes. We will notify you of any changes by posting the new Privacy Policy on this page.</p>\r\n\r\n<p>This policy is effective as of 2021-09-29</p>\r\n\r\n<p><strong>Contact Us</strong></p>\r\n\r\n<p>If you have any questions or suggestions about our Privacy Policy, do not hesitate to contact us at help.solodroid@gmail.com.</p>\r\n', 'AIzaSyCbehD6DCeDZHaGl8SUWKh1koTiHwKcvKY', '2021-10-02 03:41:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_ads`
--
ALTER TABLE `tbl_ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `tbl_fcm_template`
--
ALTER TABLE `tbl_fcm_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_fcm_token`
--
ALTER TABLE `tbl_fcm_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_license`
--
ALTER TABLE `tbl_license`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_recipes`
--
ALTER TABLE `tbl_recipes`
  ADD PRIMARY KEY (`recipe_id`);

--
-- Indexes for table `tbl_recipes_gallery`
--
ALTER TABLE `tbl_recipes_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_ads`
--
ALTER TABLE `tbl_ads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_fcm_template`
--
ALTER TABLE `tbl_fcm_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tbl_fcm_token`
--
ALTER TABLE `tbl_fcm_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_license`
--
ALTER TABLE `tbl_license`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_recipes`
--
ALTER TABLE `tbl_recipes`
  MODIFY `recipe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `tbl_recipes_gallery`
--
ALTER TABLE `tbl_recipes_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
