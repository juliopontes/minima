<?php
/** 
 * @package     Minima
 * @subpackage  mod_mypanel
 * @author      Marco Barbosa
 * @copyright   Copyright (C) 2010 Marco Barbosa. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Include the module helper class.
require_once dirname(__FILE__).DS.'helper.php';

// Initialise variables.
$helper = ModMypanelHelper::getInstance();

// Render the module layout
require JModuleHelper::getLayoutPath('mod_mypanel');
