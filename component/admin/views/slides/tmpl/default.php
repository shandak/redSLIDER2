<?php
/**
 * @package     RedSLIDER.Backend
 * @subpackage  Slide
 *
 * @copyright   Copyright (C) 2014 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */
defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('rdropdown.init');
JHtml::_('rbootstrap.tooltip');
JHtml::_('rjquery.chosen', 'select');

$saveOrderLink = 'index.php?option=com_redslider&task=slides.saveOrderAjax&tmpl=component';
$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');
$ordering = ($listOrder == 's.ordering');
$saveOrder = ($listOrder == 's.ordering' && strtolower($listDirn) == 'asc');
$search = $this->state->get('filter.search');

$user = JFactory::getUser();
$userId = $user->id;

if ($saveOrder)
{
JHTML::_('rsortablelist.sortable', 'table-items', 'adminForm', strtolower($listDirn), $saveOrderLink, false, true);
}

?>
<script type="text/javascript">
	Joomla.submitbutton = function (pressbutton)
	{
		submitbutton(pressbutton);
	}

	submitbutton = function (pressbutton)
	{
		var form = document.adminForm;
		if (pressbutton)
		{
			form.task.value = pressbutton;
		}

		if (pressbutton == 'slides.delete')
		{
			var r = confirm('<?php echo JText::_("COM_REDSLIDER_SLIDES_DELETE")?>');
			if (r == true)    form.submit();
			else return false;
		}
		form.submit();
	}
</script>
<form action="index.php?option=com_redslider&view=slides" class="admin" id="adminForm" method="post" name="adminForm">
	<?php
	echo RLayoutHelper::render(
		'searchtools.default',
		array(
			'view' => $this,
			'options' => array(
				'searchField' => 'search',
				'searchFieldSelector' => '#filter_search',
				'limitFieldSelector' => '#list_slides_limit',
				'activeOrder' => $listOrder,
				'activeDirection' => $listDirn
			)
		)
	);
	?>
	<?php if (empty($this->items)) : ?>
	<div class="alert alert-info">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<div class="pagination-centered">
			<h3><?php echo JText::_('COM_REDSLIDER_NOTHING_TO_DISPLAY'); ?></h3>
		</div>
	</div>
	<?php else : ?>
	<table class="table table-striped" id="table-items">
		<thead>
			<tr>
				<th width="10" align="center">
					<?php echo '#'; ?>
				</th>
				<th width="10">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
				</th>
				<th width="30" nowrap="nowrap">
					<?php echo JHTML::_('rsearchtools.sort', 'JSTATUS', 's.published', $listDirn, $listOrder); ?>
				</th>
				<th width="1" align="center">
				</th>
				<th class="title" width="auto">
					<?php echo JHTML::_('rsearchtools.sort', 'COM_REDSLIDER_SLIDE', 's.title', $listDirn, $listOrder); ?>
				</th>
				<th class="title" width="auto">
					<?php echo JHTML::_('rsearchtools.sort', 'COM_REDSLIDER_GALLERY', 'gallery_title', $listDirn, $listOrder); ?>
				</th>
				<th class="title" width="auto">
					<?php echo JHTML::_('rsearchtools.sort', 'COM_REDSLIDER_TEMPLATE', 'template_title', $listDirn, $listOrder); ?>
				</th>
				<?php if ($search == ''): ?>
				<th width="auto">
					<?php echo JHtml::_('rgrid.sort', null, 's.ordering', $listDirn, $listOrder, null, 'asc', '', 'icon-sort'); ?>
				</th>
				<?php endif; ?>
				<th width="10" nowrap="nowrap">
					<?php echo JHTML::_('rsearchtools.sort', 'COM_REDSLIDER_ID', 's.id', $listDirn, $listOrder); ?>
				</th>
			</tr>
		</thead>
		<tbody>

		<?php $n = count($this->items); ?>

		<?php foreach ($this->items as $i => $row) : ?>

		<?php $orderkey = array_search($row->id, $this->ordering[0]); ?>

			<tr>
				<td><?php echo $this->pagination->getRowOffset($i); ?></td>
				<td><?php echo JHtml::_('grid.id', $i, $row->id); ?></td>
				<td>
					<?php echo JHtml::_('rgrid.published', $row->published, $i, 'slides.', true, 'cb'); ?>
				</td>
				<td>
					<?php if ($row->checked_out) : ?>
						<?php
						$editor = JFactory::getUser($row->checked_out);
						$canCheckin = $row->checked_out == $userId || $row->checked_out == 0;
						echo JHtml::_('rgrid.checkedout', $i, $editor->name, $row->checked_out_time, 'slides.', $canCheckin);
						?>
					<?php endif; ?>
				</td>
				<td>
					<?php if ($row->checked_out) : ?>
						<?php echo $row->title; ?>
					<?php else : ?>
						<?php echo JHtml::_('link', 'index.php?option=com_redslider&task=slide.edit&id=' . $row->id, $row->title); ?>
					<?php endif; ?>
				</td>
				<td><?php echo $row->gallery_title; ?></td>
				<td><?php echo $row->template_title; ?></td>
				<?php if ($search == ''): ?>
				<td class="order nowrap center">
					<span class="sortable-handler hasTooltip <?php echo ($saveOrder) ? '' : 'inactive'; ?>">
					<i class="icon-move"></i>
					</span>
					<input type="text" style="display:none" name="order[]" value="<?php echo $orderkey + 1;?>" class="text-area-order" />
				</td>
				<?php endif; ?>
				<td>
					<?php echo $row->id; ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<?php echo $this->pagination->getPaginationLinks(null, array('showLimitBox' => false)); ?>
	<?php endif; ?>
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
	<?php echo JHtml::_('form.token'); ?>
</form>