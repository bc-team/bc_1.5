<?php

/**
 * @access public
 */
class back extends Tag {
	
	private $_intrisicState;

	/**
	 * @access public
	 * @param aExtrinsicState
	 * @ParamType aExtrinsicState 
	 */
	public function doIt($parameters) {
		
			$servicecategoryEntity = $GLOBALS['sys_servicecategory'];
			$servicesEntity = $GLOBALS['sys_service'];
			$servicesGroupsRelation = $GLOBALS['sys_service_sys_group'];
			$groupsEntity = $GLOBALS['sys_group'];
			$usersGroupsRelation = $GLOBALS['sys_user_sys_group'];
			$menuTemplate = new Skinlet("menu_admin");
			$menu = new Content($servicecategoryEntity, $servicesEntity, $servicesGroupsRelation, $groupsEntity, $usersGroupsRelation);
			$menu->setOrderFields("position");
			$menu->setFilter("username_sys_user", $_SESSION['user']['username']);
			$menu->apply($menuTemplate);
		
		return $menuTemplate->get();
	
	}
}
?>