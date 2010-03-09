<div id="sort">
<?php echo __("Sort by")?>

<?php if (in_array("rank", $display)): ?>
<?php echo link_to(__('Rank', array(), 'messages'), '@dc_swish', array('query_string' => 'sort='.SwishManager::RANK.'&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'), 'title' => __('Sort by this field', array(), 'messages'))) ?>
<?php endif ?>

<?php if (in_array("path", $display)): ?>
|
<?php echo link_to(__('Path', array(), 'messages'), '@dc_swish', array('query_string' => 'sort='.SwishManager::PATH.'&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'), 'title' => __('Sort by this field', array(), 'messages'))) ?>
<?php endif ?>

<?php if (in_array("size", $display)): ?>
|
<?php echo link_to(__('Size', array(), 'messages'), '@dc_swish', array('query_string' => 'sort='.SwishManager::SIZE.'&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'), 'title' => __('Sort by this field', array(), 'messages'))) ?>
<?php endif ?>

<?php if (in_array("lastmod", $display)): ?>
|
<?php echo link_to(__('Last modified', array(), 'messages'), '@dc_swish', array('query_string' => 'sort='.SwishManager::MODIFIED.'&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'), 'title' => __('Sort by this field', array(), 'messages'))) ?>
<?php endif ?>
</div>
