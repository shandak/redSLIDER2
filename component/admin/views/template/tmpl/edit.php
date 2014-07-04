<?php
/**
 * @package     RedSHOP.Backend
 * @subpackage  Template
 *
 * @copyright   Copyright (C) 2005 - 2013 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */
defined('_JEXEC') or die;

JHtml::_('rjquery.chosen', 'select');

$isNew = true;

if ($this->item->id)
{
	$isNew = false;
}
?>
<form enctype="multipart/form-data"
	action="index.php?option=com_redslider&task=template.edit&id=<?php echo $this->item->id; ?>"
	method="post" name="adminForm" class="form-validate form-horizontal" id="adminForm">
	<div class="row-fluid">
		<div class="control-group">
			<div class="control-label">
				<?php echo $this->form->getLabel('section'); ?>
			</div>
			<div class="controls">
				<?php echo $this->form->getInput('section'); ?>
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<?php echo $this->form->getLabel('title'); ?>
			</div>
			<div class="controls">
				<?php echo $this->form->getInput('title'); ?>
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<?php echo $this->form->getLabel('alias'); ?>
			</div>
			<div class="controls">
				<?php echo $this->form->getInput('alias'); ?>
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<?php echo $this->form->getLabel('published'); ?>
			</div>
			<div class="controls">
				<?php echo $this->form->getInput('published'); ?>
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<?php echo $this->form->getLabel('content'); ?>
			</div>
			<div class="controls">
				<?php echo $this->form->getInput('content'); ?>
				<?php if (count($this->templateTags)): ?>
				<div class='template_tags'>
					<div class="accordion" id="accordion_tag_default">
						<div class="accordion-heading">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion_tag_default" href="#collapseOne">
								<?php echo JText::_('COM_REDSLIDER_TEMPLATE_TAGS_DEFAULT_LBL'); ?>
							</a>
						</div>
						<div id="collapseOne" class="accordion-body collapse in">
							<div class="accordion-inner">
								<ul>
								<?php foreach ($this->templateTags as $tag => $tagDesc) : ?>
									<li>
										<span><?php echo $tag ?></span><?php echo $tagDesc ?>
									</li>
								<?php endforeach; ?>
								</ul>
							</div>
						</div>
					</div>
				<div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php echo $this->form->getInput('id'); ?>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>