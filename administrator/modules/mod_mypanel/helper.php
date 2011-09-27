<?php
/** 
 * @package     Minima
 * @subpackage  mod_mypanel
 * @author      Marco Barbosa e Júlio Pontes
 * @copyright   Copyright (C) 2010 Marco Barbosa. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

/**
 * @package     Minima
 * @subpackage  mod_mypanel
 */
class ModMypanelHelper
{
	protected $_config;
	protected $_cache;

	public function __construct( $config = array() )
	{
		$config['cache_request'] = isset($config['cache_request']) ? $config['cache_request'] : false ;
		$config['cache_time'] = isset($config['cache_time']) ? $config['cache_time'] : 600 ;
		$config['pages'] = 9;
		
		$this->_config = $config;
		
		jimport('joomla.cache.cache');
		$this->_cache = JCache::getInstance();
		$this->_cache->setCaching($config['cache_request']);
		$this->_cache->setLifeTime($config['cache_time']);
	}
	
	public function getInstance()
	{
		static $instance;
		
		if (!isset( $instance )) {
			$instance = new ModMypanelHelper();
		}
		
		return $instance;
	}
	
	public function getNumPages()
	{
		return ceil( count($this->_data) / $this->_config['pages']);
	}
	
	public function getItems()
	{
		$request_key = md5(__CLASS__);
		$cache_group = 'mypanel';
		
		$this->_data = $this->_cache->get($request_key,$cache_group);
		
		if (empty($this->_data))
		{
			$this->_data = $this->_loadExtensions();
			$this->_cache->store($this->_data,$request_key,$cache_group);
		}
		
		$this->loadLanguages();
		
		return $this->_data;
	}
	
	public function _loadExtensions()
	{
		// Initialise variables.
		$db = JFactory::getDbo();
		$query  = $db->getQuery(true);
		$user   = JFactory::getUser();
		
		$query->select('e.extension_id, e.name, e.element, m.img');
		$query->from('#__extensions AS e');
		
		$query->leftJoin('#__menu AS m ON (m.component_id = e.extension_id AND m.client_id = 1 AND m.type = "component" AND m.parent_id = 1)');
		
		$query->where('e.enabled = 1');
		$query->where('e.element LIKE("%com_%")');
		
		$query->group('e.`extension_id`');
		
		$query->order('e.name');
		
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		
		$data = array();
		
		foreach($rows as $row)
		{
			$xml = $this->getComponentXml($row);
			
			$description = JText::_(strtoupper($row->element).'_XML_DESCRIPTION');
			
			//component object
			$component = new stdclass;
			$component->name = ($xml) ? $xml->name : $row->name ;
			$component->description = (strpos($description,'_XML_DESCRIPTION') >= 0) ? JText::_('TPL_MINIMA_NODESCRIPTION') : JString::substr($description,0,100) ;
			$component->image = $this->getExtensionImage($row);
			$component->link = 'index.php?option='.$row->element;
			$component->className = ( (strpos($row->img,'class') == 0) && !is_null($row->img) ) ? 'icon-48-'.substr($row->img,6) : 'icon-48-generic';
			$component->element = $row->element;
			
			array_push($data,$component);
		}
		
		return $data;
	}
	
	public function getExtensionImage($row)
	{
		$img = (is_file($row->img)) ? $row->img : '' ;
		
		return $img;
	}
	
	public function getComponentXml($row)
	{
		$paths = array(
			JPATH_ADMINISTRATOR .DS. 'components' .DS. $row->element,
			JPATH_SITE .DS. 'components' .DS. $row->element
		);
		
		jimport('joomla.filesystem.path');
		$xmlFilesInDir = JPath::find($paths,$row->element.'.xml$');
		
		if ($xmlFilesInDir !== false)
		{
			$xmlFilesInDir = JApplicationHelper::parseXMLInstallFile($xmlFilesInDir);
		}
		
		return $xmlFilesInDir;
	}
	
	public function loadLanguages()
	{
		// Initialise variables.
        $lang   = JFactory::getLanguage();
        
		foreach($this->_data as $row)
		{
			$lang->load($row->element, JPATH_BASE);
			$lang->load($row->element, JPATH_ADMINISTRATOR);
		}
	}
}
