<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\Registry\Registry;

JLoader::register('TagsHelperRoute', JPATH_BASE . '/components/com_tags/helpers/route.php');

$authorised = JFactory::getUser()->getAuthorisedViewLevels();

?>
<?php if (!empty($displayData)) : ?>
	<span><b>Tags:</b></span>
	<?php foreach ($displayData as $i => $tag) : ?>
		<?php if (in_array($tag->access, $authorised)) : ?>
			<?php $tagParams = new Registry($tag->params); ?>
			<?php $link_class = $tagParams->get('tag_link_class', 'label label-info'); ?>
			<a href="<?php echo JRoute::_(TagsHelperRoute::getTagRoute($tag->tag_id . ':' . $tag->alias)); ?>" class="w3-tag w3-yellow <?php echo $link_class; ?>">
				<?php echo $this->escape($tag->title); ?>
			</a>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>
