<?php
/**
 * @version		$Id: default.php 19808 2010-12-09 15:58:36Z chdemko $
 * @package		Joomla.Site
 * @subpackage	mod_languages
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('stylesheet', 'mod_languages/template.css', array(), true);
?>
<div class="mod-languages<?php echo $params->get('moduleclass_sfx') ?>">
<?php if ($headerText) : ?>
	<div class="pretext"><p><?php echo $headerText; ?></p></div>
<?php endif; ?>
		<ul>
<?php foreach($list as $language):?>
			<li>
				<a href="<?php echo $language->link;?>">
	<?php if ($params->get('image', 1)):?>
		<?php echo JHtml::_('image', 'mod_languages/'.$language->image.'.gif', $language->title, array('title'=>$language->title), true);?>
	<?php else:?>
		<?php echo $language->title;?>
	<?php endif;?>
				</a>
			</li>
<?php endforeach;?>
		</ul>
<?php if ($footerText) : ?>
	<div class="posttext"><p><?php echo $footerText; ?></p></div>
<?php endif; ?>
</div>
