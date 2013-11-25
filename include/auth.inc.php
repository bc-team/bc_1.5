<?php
require_once(realpath(dirname(__FILE__))."/entities.inc.php");
	

Class Auth {
	
	function isSuperuser() {
		
		$group = Auth::getSuperusergroup();
		$trovato = false;
		
		foreach($_SESSION['user']['services'] as $k => $v) {
			
			if($v['id_groups'] == $group) {				
				$trovato = true;
			}
		}
		
		return $trovato;
	}
	
	function isAdmin() {
		
		return $_SESSION['user']['admin'];
		
	}
	
	function getSuperusergroup() {
		
		$trovato = false;
		$i=0;
		while (($i<count($_SESSION['user']['services'])) and (!$trovato)) {
			if ($_SESSION['user']['services'][$i]['script'] == basename($_SERVER['SCRIPT_FILENAME'])) {
				$trovato = true;
				$result = $_SESSION['user']['services'][$i]['superuser_group'];
			}
			
			$i++;
		}
		
		return $result;
	}
	
	function getGroups() {
		
		foreach($_SESSION['user']['services'] as $v) {
			$groups[$v['id_groups']] = $v['id_groups'];
		}
		
		foreach($groups as $v) {
			$result[] = $v;
		}
		
		return $result;
	}
	
	static function getUser()
	{
		return $_SESSION['user']['username'];
	}
	
	/**
	 * this method will be connected to LDAP (when data structure will be available, c'mon UNIVAQ!)
	 * @param unknown $username
	 * @param unknown $password
	 */
	static function doAuth($username,$password)
	{
		
		$sys_user_Entity=$GLOBALS["sys_user"];
		$sys_service_Entity=$GLOBALS["sys_service"];
		$sys_servicecategory_Entity=$GLOBALS["sys_servicecategory"];
		$sys_group_Entity=$GLOBALS["sys_group"];
		$sys_user_group_Relation=$GLOBALS["sys_user_sys_group"];
		$sys_service_group_Relation=$GLOBALS["sys_service_sys_group"];
		
		$authorized=false;
		if ((isset($_POST['username'])) and (isset($_POST['password'])))
		{
				$where_conditions=array();
				$where_conditions["username"]=$username;
				$where_conditions["password"]=$password;
				
				$sys_user_Entity->retrieveAndLink($where_conditions);
				if($sys_user_Entity->loaded==true)
				{
					if($sys_user_Entity->instances[0]->getFieldValue("username")== $username
							&&
					   $sys_user_Entity->instances[0]->getFieldValue("password")== $password)
						$authorized=true;
				}
		}
		return $authorized;
	}
	
	static function doLogin() {
		
		$sys_users_Entity=$GLOBALS["sys_user"];
		$sys_service_Entity=$GLOBALS["sys_service"];
		$sys_servicecategory_Entity=$GLOBALS["sys_servicecategory"];
		$sys_group_Entity=$GLOBALS["sys_group"];
		
		$sys_user_group_Relation=$GLOBALS["sys_user_sys_group"];
		$sys_service_group_Relation=$GLOBALS["sys_service_sys_group"];

		$join_entities=array();
		$join_entities[]=$sys_user_group_Relation;
		$join_entities[]=$sys_group_Entity;
		$join_entities[]=$sys_service_group_Relation;
		$join_entities[]=$sys_service_Entity;
		
		$where_conditions=array();
		if(isset($_POST['username'])&&isset($_POST['password']))
		{
			$where_conditions["username"]=$_POST['username'];
			$where_conditions["password"]=md5($_POST['password']);
		}
		
		if (!isset($_SESSION['user'])) {

			
			$debug_action = "USER NOT LOGGED";
			
			if ((!isset($_POST['username'])) and (!isset($_POST['password']))) {
				if (!isset($_SESSION['HTTP_LOGIN'])){
					unset($GLOBALS['_SERVER']['PHP_AUTH_PW']);
					unset($GLOBALS['_SERVER']['PHP_AUTH_USER']);
				}
				if ((!isset($_SERVER['PHP_AUTH_USER'])) and (!isset($_SERVER['PHP_AUTH_PW']))) {					
					Header("Location: admin.php");
	      			exit;
				} else {
					$_POST['username'] = $_SERVER['PHP_AUTH_USER'];
					$_POST['password'] = $_SERVER['PHP_AUTH_PW'];
					$_SESSION['HTTP_LOGIN'] = false;			
				}
			}
			
			$name = addcslashes($_POST['username'],"'");
			
			$oid = mysql_query("SELECT * 
		                  	    FROM {$GLOBALS['usersEntity']->name}  
		                  	   WHERE username = '{$name}'
		                  	     AND password = MD5('{$_POST['password']}')");
			if (!$oid) {		
				
				echo "Error in database!<hr>";
				echo mysql_error();
					exit;		
			}
			
			
			//if (mysql_num_rows($oid) == 0)
			if(!self::doAuth($_POST['username'],md5($_POST['password'])))
			{
				Header("Location: error.php?id=loginError");
				exit;
			} else {
				$userdata = mysql_fetch_assoc($oid);
				$_SESSION['user']['username'] = $userdata['username'];
				$_SESSION['user']['name'] = $userdata['name'];
				$_SESSION['user']['surname'] = $userdata['surname'];
				$_SESSION['user']['email'] = $userdata['email'];

				
				$oid = mysql_query("SELECT DISTINCT {$GLOBALS['usersEntity']->name}.username, 
				                           {$GLOBALS['servicesEntity']->name}.entry AS serviceName,
				                           {$GLOBALS['servicesEntity']->name}.visible,
				                           {$GLOBALS['servicesEntity']->name}.entities AS entity,
				                           {$GLOBALS['servicesEntity']->name}.script,
				                           {$GLOBALS['servicesEntity']->name}.superuser_group,
				                           {$GLOBALS['servicecategoryEntity']->name}.name AS category,
				                           {$GLOBALS['entitiesEntity']->name}.name AS tableName,
				                           {$GLOBALS['usersGroupsRelation']->name}.id_sys_group
				                           
                                  FROM {$GLOBALS['usersEntity']->name}            
                             LEFT JOIN {$GLOBALS['usersGroupsRelation']->name} 
                                    ON {$GLOBALS['usersGroupsRelation']->name}.username_sys_user = {$GLOBALS['usersEntity']->name}.username
                             LEFT JOIN {$GLOBALS['groupsEntity']->name} 
                                    ON {$GLOBALS['groupsEntity']->name}.id = {$GLOBALS['usersGroupsRelation']->name}.id_{$GLOBALS['groupsEntity']->name}
                             LEFT JOIN {$GLOBALS['servicesGroupsRelation']->name} 
                                    ON {$GLOBALS['servicesGroupsRelation']->name}.id_{$GLOBALS['groupsEntity']->name} = {$GLOBALS['groupsEntity']->name}.id
                             LEFT JOIN {$GLOBALS['servicesEntity']->name} 
                                    ON {$GLOBALS['servicesEntity']->name}.id = {$GLOBALS['servicesGroupsRelation']->name}.id_{$GLOBALS['servicesEntity']->name}
                             LEFT JOIN {$GLOBALS['entitiesEntity']->name}
                                    ON {$GLOBALS['entitiesEntity']->name}.name = {$GLOBALS['servicesEntity']->name}.entities
                             LEFT JOIN {$GLOBALS['servicecategoryEntity']->name}
                                    ON {$GLOBALS['servicecategoryEntity']->name}.id = {$GLOBALS['servicesEntity']->name}.servicecategory
                    
                                 WHERE {$GLOBALS['usersEntity']->name}.username =  '{$_SESSION['user']['username']}'
                              ORDER BY {$GLOBALS['servicecategoryEntity']->name}.position, {$GLOBALS['servicesEntity']->name}.position");
				
				
				
				if (!$oid) 
				{
					echo "Error in database!<hr>";
					echo mysql_error();
					exit;
				}
				
				while ($data = $data = mysql_fetch_assoc($oid)){
						$_SESSION['user']['services'][] = $data;
						$_SESSION['user']['services'][$data['script']] = $data; 
						$_SESSION['user']['groups'][$data['id_sys_group']] = $data['id_sys_group'];
				}
				
				$lastlogin = Parser::getResult("
				                SELECT * 
				                  FROM {$GLOBALS['logEntity']->name} 
				                 WHERE username = '{$_SESSION['user']['username']}'
				                   AND operation = 'LOGIN'
				              ORDER BY date DESC
				                 LIMIT 1");
				
				if (isset($lastlogin)) {
					$lastLogin =  $lastlogin[0];
					$_SESSION['user']['lastlogin'] =$lastLogin['date'];
				} else {
					$_SESSION['user']['lastlogin'] = "";
				}
				$GLOBALS['logEntity']->insertItem(NULL, 
										  'LOGIN',
										  '',
										  '',
										  basename($_SERVER['SCRIPT_FILENAME']),
										  $_SESSION['user']['username'],
										  date("YmdHi"),
										  $_SERVER['HTTP_HOST']);
			}
		}
		else {
			$debug_action = "USER_LOGGED";
		}
		
		if (is_array($_SESSION['user']['services'])) {
			$debug_action = " services array ";
			
		} else {
			$debug_action = " services NOT array ";
		}
		
		$trovato = false;
		$error = 212;
		
		if (is_array($_SESSION['user']['services'])) {
			foreach ($_SESSION['user']['services'] as $k => $v) {
				
				$error = 217;
		
				if ($v['script'] == basename($_SERVER['SCRIPT_NAME'])) {
					$trovato = true;
					$currentService = $v;
						$error = 223;
				}
			}
		}

		if ((basename($_SERVER['SCRIPT_NAME'])=="error.php") or (basename($_SERVER['SCRIPT_NAME'])=="login.php") or (basename($_SERVER['SCRIPT_NAME'])=="logout.php")) {
				
			$trovato=true;
		
		}
			
		if (!$trovato) {		
			
			#echo $script;
			if (basename($_SERVER['SCRIPT_NAME']) != "ajax-manager.php") {
				
				Header("Location: error.php?id=priviledgeError&{$error}&{$debug_action}");
				exit;
			}
		} 
		
		
		
		///se abilitato il datafiltering///////////////////////////////////////
		
	
		
		if (isset($currentService['tableName'])) { // Data Filtering Check
			
			if ((isset($_REQUEST['page'])) and ($_REQUEST['page'] > 0) and ($_REQUEST['action'] == "edit")) {
				
				
				$result = mysql_query("select * from {$currentService['tableName']}");
				if (!$result) {
    				echo "Generic Database Error!";
    				exit;
				}
				
    			$meta = mysql_fetch_field($result, 0);
    			if (!$meta) {
        			echo "Metadata Error!";
    				exit;
    			}
    				
				$oid = mysql_query("SELECT username
			                          FROM {$currentService['tableName']}
             					     WHERE {$meta->name} = '{$_REQUEST['value']}' ");
				if (!$oid) {
					echo "Error in database!<hr>";
					echo mysql_error();
					exit;
				}
			
				$data = mysql_fetch_assoc($oid);
				
				if ($data['username'] != $_SESSION['user']['username']) {
					
						
					/* CHECK FOR SUPERUSER_GROUP */
					
					$superuser_group = Auth::getSuperusergroup();
					$mygroups = Auth::getGroups();
					
					echo Auth::isSuperuser();
					
					if (!in_array(Auth::getSuperusergroup(), Auth::getGroups()) and (!Auth::isAdmin())) {
							
							
						Header("Location: error.php?id=dataFiltering&289");	
						exit;
					} else {
						
						
						
					}
				}	
			}
		}
		$config = Config::getInstance()->getConfigurations();
		if (!isset($_SESSION['registered-user'])) { 
			$trovato = false;
		
			if (is_array($_SESSION['user']['services'])) {
				foreach($_SESSION['user']['services'] as $k => $v) {
					if($v['id_sys_group'] == $config['registered_usergroup']) {
				
						$script = $_SERVER['HTTP_REFERER'];
					
						$_SESSION['registered-user'] = true;
					
					
						Header("Location: {$script}");
						exit;
					}
				}
			}
		}
		
		
		////////////////////////////////////////////////////
		
		$_SESSION['user']['admin'] = false;
		if (is_array($_SESSION['user']['services'])) {
			foreach($_SESSION['user']['services'] as $k => $v) {
			
				if($v['id_sys_group'] == $config['admin_usergroup']) {				
					$_SESSION['user']['admin'] = true;
				}
			}
		}	
	}
	
	
	
	
}

Auth::doLogin();
