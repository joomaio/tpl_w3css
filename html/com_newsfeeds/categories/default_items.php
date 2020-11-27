<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_newsfeeds
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
  
JHtml::_('bootstrap.tooltip');

?>
<?php $class = ' class="first w3-container"'; ?>
<?php if ($this->maxLevelcat != 0 && count($this->items[$this->parent->id]) > 0) : ?>
	<?php foreach ($this->items[$this->parent->id] as $id => $item) : ?>
		<?php if ($this->params->get('show_empty_categories_cat') || $item->numitems || count($item->getChildren())) : ?>
			<?php if (!isset($this->items[$this->parent->id][$id + 1])) : ?>
				<?php $class = ' class="last w3-container"'; ?>
			<?php endif; ?>
			<div<?php echo $class; ?>>
				<?php $class = ' class="w3-container"'; ?>
					<div class="w3-card-2 card">
						<?php if (count($item->getChildren()) > 0 && $this->maxLevelcat > 1) : ?>
							<div class="cat-container w3-light-grey" onclick="addCategories('category-<?php echo $item->id; ?>')">
						<?php else : ?>
							<div class="cat-container w3-light-grey">
						<?php endif; ?>	
							<a class="category-title" href="<?php echo JRoute::_(NewsfeedsHelperRoute::getCategoryRoute($item->id, $item->language)); ?>">
								<?php echo $this->escape($item->title); ?>
							</a>
							<?php if ($this->params->get('show_cat_items_cat') == 1) : ?>
								<span class="w3-badge w3-blue cat-badge tip hasTooltip" title="<?php echo JHtml::_('tooltipText', 'COM_NEWSFEEDS_NUM_ITEMS'); ?>">
									<?php echo JText::_('COM_NEWSFEEDS_NUM_ITEMS'); ?>&nbsp;
									<?php echo $item->numitems; ?>
								</span>
							<?php endif; ?>
						</div>
				
						<?php if ($this->params->get('show_subcat_desc_cat') == 1) : ?>
							<?php if ($item->description) : ?>
								<div class="category-desc w3-container w3-white">
									<?php echo JHtml::_('content.prepare', $item->description, '', 'com_newsfeeds.categories'); ?>
								</div>
							<?php endif; ?>
						<?php endif; ?>
						<?php if (count($item->getChildren()) > 0 && $this->maxLevelcat > 1) : ?>
							<div class="w3-hide" id="category-<?php echo $item->id; ?>">
								<?php $this->items[$item->id] = $item->getChildren(); ?>
								<?php $this->parent = $item; ?>
								<?php $this->maxLevelcat--; ?>
								<?php echo $this->loadTemplate('items'); ?>
								<?php $this->parent = $item->getParent(); ?>
								<?php $this->maxLevelcat++; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>
