<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('bootstrap.tooltip');


// Load user_profile plugin language
$lang = JFactory::getLanguage();
$lang->load('plg_user_profile', JPATH_ADMINISTRATOR);

?>
<div class="profile-edit<?php echo $this->pageclass_sfx; ?>">
	<form id="member-profile" action="<?php echo JRoute::_('index.php?option=com_users&task=profile.save'); ?>" method="post" class="form-validate form-horizontal well" enctype="multipart/form-data">
		<?php foreach ($this->form->getFieldsets() as $group => $fieldset) : ?>
			<?php $fields = $this->form->getFieldset($group); ?>
			<?php if (count($fields)) : ?>
				<div class="w3-card-4 <?php echo $fieldset->label; ?>">
					<?php if (isset($fieldset->label)) : ?>
						<div class="w3-padding w3-light-grey w3-center">
							<span class="category-title"><?php echo JText::_($fieldset->label); ?></span>
						</div>
					<?php endif; ?>
					<div class="w3-padding">
					<?php foreach ($fields as $field) : ?>
						<?php if ($field->hidden) : ?>
							<?php echo $field->input; ?>
						<?php else : ?>
							<div class="profile-input">
								<div class="control-label">
									<?php echo $field->label; ?>
									<?php if (!$field->required && $field->type !== 'Spacer') : ?>
										<span class="optional">
											<?php echo JText::_('COM_USERS_OPTIONAL'); ?>
										</span>
									<?php endif; ?>
								</div>
								<div class="controls">
									<?php if ($field->fieldname === 'password1') : ?>
										<?php // Disables autocomplete ?>
										<input class="w3-input" type="password" style="display:none">
									<?php endif; ?>
									<?php echo $field->input; ?>
								</div>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
		<?php if (count($this->twofactormethods) > 1) : ?>
			<div class="w3-card-4">
				<div class="w3-padding w3-light-grey w3-center">
					<span class="category-title"><?php echo JText::_('COM_USERS_PROFILE_TWO_FACTOR_AUTH'); ?></span>
				</div>
				<div class="w3-padding">
					<div class="control-group">
						<div class="control-label">
							<label id="jform_twofactor_method-lbl" for="jform_twofactor_method" class="hasTooltip"
								title="<?php echo '<strong>' . JText::_('COM_USERS_PROFILE_TWOFACTOR_LABEL') . '</strong><br />' . JText::_('COM_USERS_PROFILE_TWOFACTOR_DESC'); ?>">
								<?php echo JText::_('COM_USERS_PROFILE_TWOFACTOR_LABEL'); ?>
							</label>
						</div>
						<div class="controls">
							<?php echo JHtml::_('select.genericlist', $this->twofactormethods, 'jform[twofactor][method]', array('onchange' => 'Joomla.twoFactorMethodChange()'), 'value', 'text', $this->otpConfig->method, 'jform_twofactor_method', false); ?>
						</div>
					</div>
					<div id="com_users_twofactor_forms_container">
						<?php foreach ($this->twofactorform as $form) : ?>
							<?php $style = $form['method'] == $this->otpConfig->method ? 'display: block' : 'display: none'; ?>
							<div id="com_users_twofactor_<?php echo $form['method']; ?>" style="<?php echo $style; ?>">
								<?php echo $form['form']; ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<div class="w3-card-4">
				<div class="w3-padding w3-light-grey w3-center">
					<span class="category-title"><?php echo JText::_('COM_USERS_PROFILE_OTEPS'); ?></span>
				</div>
				<div class="alert alert-info">
					<?php echo JText::_('COM_USERS_PROFILE_OTEPS_DESC'); ?>
				</div>
				<?php if (empty($this->otpConfig->otep)) : ?>
					<div class="alert alert-warning">
						<?php echo JText::_('COM_USERS_PROFILE_OTEPS_WAIT_DESC'); ?>
					</div>
				<?php else : ?>
					<?php foreach ($this->otpConfig->otep as $otep) : ?>
						<span class="span3">
							<?php echo substr($otep, 0, 4); ?>-<?php echo substr($otep, 4, 4); ?>-<?php echo substr($otep, 8, 4); ?>-<?php echo substr($otep, 12, 4); ?>
						</span>
					<?php endforeach; ?>
					<div class="clearfix"></div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<div class="control-group w3-center">
				<button type="submit" class="w3-button w3-green validate">
					<?php echo JText::_('JSUBMIT'); ?>
				</button>
				<a class="w3-button w3-red" href="<?php echo JRoute::_('index.php?option=com_users&view=profile'); ?>" title="<?php echo JText::_('JCANCEL'); ?>">
					<?php echo JText::_('JCANCEL'); ?>
				</a>
				<input type="hidden" name="option" value="com_users" />
				<input type="hidden" name="task" value="profile.save" />
		</div>
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
