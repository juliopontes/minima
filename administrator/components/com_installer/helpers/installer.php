<?php
/**
 * @version		$Id: installer.php 18641 2010-08-26 04:53:38Z eddieajau $
 * @package		Joomla.Administrator
 * @subpackage	com_installer
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Installer helper.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_installer
 * @since		1.6
 */
class InstallerHelper
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param	string	The name of the active view.
	 */
	public static function addSubmenu($vName = 'install')
	{
		JSubMenuHelper::addEntry(
			JText::_('COM_INSTALLER_SUBMENU_INSTALL'),
			'index.php?option=com_installer',
			$vName == 'install'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_INSTALLER_SUBMENU_UPDATE'),
			'index.php?option=com_installer&view=update',
			$vName == 'update'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_INSTALLER_SUBMENU_MANAGE'),
			'index.php?option=com_installer&view=manage',
			$vName == 'manage'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_INSTALLER_SUBMENU_DISCOVER'),
			'index.php?option=com_installer&view=discover',
			$vName == 'discover'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_INSTALLER_SUBMENU_WARNINGS'),
			'index.php?option=com_installer&view=warnings',
			$vName == 'warnings'
		);
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_installer';

		$actions = array(
			'core.admin', 'core.manage', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}

		return $result;
	}
}