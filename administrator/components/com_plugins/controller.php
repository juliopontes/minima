<?php
/**
 * @version		$Id: controller.php 19296 2010-10-30 09:46:52Z infograf768 $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * Plugins master display controller.
 *
 * @package		Joomla.Administrator
 * @subpackage	Plugins
 * @since		1.5
 */
class PluginsController extends JController
{
	/**
	 * Method to display a view.
	 *
	 * @param	boolean			If true, the view output will be cached
	 * @param	array			An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController		This object to support chaining.
	 * @since	1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		require_once JPATH_COMPONENT.'/helpers/plugins.php';

		// Load the submenu.
		PluginsHelper::addSubmenu(JRequest::getWord('view', 'plugins'));

		$view		= JRequest::getWord('view', 'plugins');
		$layout 	= JRequest::getWord('layout', 'default');
		$id			= JRequest::getInt('extension_id');

		// Check for edit form.
		if ($view == 'plugin' && $layout == 'edit' && !$this->checkEditId('com_plugins.edit.plugin', $id)) {
			// Somehow the person just went to the form - we don't allow that.
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
			$this->setMessage($this->getError(), 'error');
			$this->setRedirect(JRoute::_('index.php?option=com_plugins&view=plugins', false));

			return false;
		}

		parent::display();
	}
}