<?php
require_once realpath(dirname(__FILE__)) .'/core.php'; 


/**
	This function works only if beContent is not installed correctly
**/
function init($usersEntity) {

	$config = Config::getInstance()->getConfigurations();
	if(!$usersEntity->retrieveAndLink() && Settings::getModMode())
	{
		$values_conditions=array();

		/**
		 * default User of the application
		*/
		
		$GLOBALS['usersEntity']->insertItem(array(
				"username" 	=> $config['defaultuser']['username'],
				"password"	=> md5($config['defaultuser']['password']),
				"email"		=> $config['defaultuser']['email'],
				"name"		=> $config['defaultuser']['name'],
				"surname"	=> $config['defaultuser']['surname'])
		);

		$GLOBALS['groupsEntity']->insertItem("1", "Administrator", "Administration Group.");
		$GLOBALS['usersGroupsRelation']->insertItem(null,$config['defaultuser']['username'],"1");

		/**
		 * System services category initialization
		*/

		$GLOBALS['servicecategoryEntity']->insertItem(array(
				"id" 		=> "1",
				"name"		=> "System",
				"position" 	=> "1")
		);




		$GLOBALS['servicecategoryEntity']->insertItem(array(
				"id" 		=> "2",
				"name"		=> "Content",
				"position" 	=> "2")
		);



		$GLOBALS['servicesEntity']->insertItem(array(
				"id"		=> "1",
				"name"		=> "Login",
				"script"	=> "admin-login.php",
				"entry"		=> "Login",
				"servicecategory" => "0",
				"visible"	=> "*",
				"des"		=> "Login service",
				"id_entities" => "",
				"position"	=> "1")
		);


		$GLOBALS['servicesEntity']->insertItem(array(
				"id"		=> "2",
				"name"		=> "Logout",
				"script"	=> "admin-logout.php",
				"entry"		=> "Logout",
				"servicecategory" => "0",
				"visible"	=> "*",
				"des"		=> "Logout service",
				"id_entities" => "",
				"position"	=> "2")
		);



		$GLOBALS['servicesEntity']->insertItem(array(
				"id"		=> "3",
				"name"		=> "User Management",
				"script"	=> "admin-users-manager.php",
				"entry"		=> "Users",
				"servicecategory" => "1",
				"visible"	=> "*",
				"des"		=> "",
				"id_entities" => "",
				"position"	=> "1")
		);

		$GLOBALS['servicesEntity']->insertItem(array(
				"id"		=> "4",
				"name"		=> "Group Management",
				"script"	=> "admin-groups-manager.php",
				"entry"		=> "Groups",
				"servicecategory" => "1",
				"visible"	=> "*",
				"des"		=> "",
				"id_entities" => "",
				"position"	=> "2")
		);

		$GLOBALS['servicesEntity']->insertItem(array(
				"id"		=> "5",
				"name"		=> "Service Management",
				"script"	=> "admin-services-manager.php",
				"entry"		=> "Services",
				"servicecategory" => "1",
				"visible"	=> "*",
				"des"		=> "",
				"id_entities" => "",
				"position"	=> "3")
		);

		$GLOBALS['servicesEntity']->insertItem(array(
				"id"		=> "6",
				"name"		=> "Service Category Management",
				"script"	=> "admin-servicecategory-manager.php",
				"entry"		=> "Service Categories",
				"servicecategory" => "1",
				"visible"	=> "*",
				"des"		=> "",
				"id_entities" => "",
				"position"	=> "4")
		);


		$GLOBALS['servicesEntity']->insertItem(array(
				"id"		=> "7",
				"name"		=> "Page Management",
				"script"	=> "admin-pages-manager.php",
				"entry"		=> "Pages",
				"servicecategory" => "2",
				"visible"	=> "*",
				"des"		=> "",
				"id_entities" => "",
				"position"	=> "1")
		);

		$GLOBALS['servicesEntity']->insertItem(array(
				"id"		=> "8",
				"name"		=> "Menu Management",
				"script"	=> "admin-menu-manager.php",
				"entry"		=> "Menu",
				"servicecategory" => "2",
				"visible"	=> "*",
				"des"		=> "",
				"id_entities" => "",
				"position"	=> "2")
		);

		$GLOBALS['servicesEntity']->insertItem(array(
				"id"		=> "10",
				"name"		=> "News",
				"script"	=> "admin-news-manager.php",
				"entry"		=> "News",
				"servicecategory" => "2",
				"visible"	=> "*",
				"des"		=> "",
				"id_entities" => "",
				"position"	=> "4")
		);

        $GLOBALS['servicesEntity']->insertItem(array(
                "id"		=> "11",
                "name"		=> "Image",
                "script"	=> "admin-image-manager.php",
                "entry"		=> "Image",
                "servicecategory" => "2",
                "visible"	=> "*",
                "des"		=> "",
                "id_entities" => "",
                "position"	=> "5")
        );

        $GLOBALS['servicesEntity']->insertItem(array(
                "id"		=> "12",
                "name"		=> "Slider",
                "script"	=> "admin-slider-manager.php",
                "entry"		=> "Slider",
                "servicecategory" => "2",
                "visible"	=> "*",
                "des"		=> "",
                "id_entities" => "",
                "position"	=> "6")
        );

        $GLOBALS['servicesEntity']->insertItem(array(
                "id"		=> "13",
                "name"		=> "File2Folder",
                "script"	=> "admin-file_folder-manager.php",
                "entry"		=> "File2Folder",
                "servicecategory" => "0",
                "visible"	=> "*",
                "des"		=> "",
                "id_entities" => "",
                "position"	=> "7")
        );

        $GLOBALS['servicesEntity']->insertItem(array(
                "id"		=> "14",
                "name"		=> "Video",
                "script"	=> "admin-video-manager.php",
                "entry"		=> "Video",
                "servicecategory" => "2",
                "visible"	=> "*",
                "des"		=> "",
                "id_entities" => "",
                "position"	=> "8")
        );

		$GLOBALS['servicesGroupsRelation']->insertItem(null,"1","1");
		$GLOBALS['servicesGroupsRelation']->insertItem(null,"2","1");
		$GLOBALS['servicesGroupsRelation']->insertItem(null,"3","1");
		$GLOBALS['servicesGroupsRelation']->insertItem(null,"4","1");
		$GLOBALS['servicesGroupsRelation']->insertItem(null,"5","1");
		$GLOBALS['servicesGroupsRelation']->insertItem(null,"6","1");
		$GLOBALS['servicesGroupsRelation']->insertItem(null,"7","1");
		$GLOBALS['servicesGroupsRelation']->insertItem(null,"8","1");
		$GLOBALS['servicesGroupsRelation']->insertItem(null,"9","1");
		$GLOBALS['servicesGroupsRelation']->insertItem(null,"10","1");
		$GLOBALS['servicesGroupsRelation']->insertItem(null,"11","1");
		$GLOBALS['servicesGroupsRelation']->insertItem(null,"12","1");
		$GLOBALS['servicesGroupsRelation']->insertItem(null,"13","1");
		$GLOBALS['servicesGroupsRelation']->insertItem(null,"14","1");

	}
}
init($usersEntity);