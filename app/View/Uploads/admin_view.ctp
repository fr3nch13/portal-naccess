<?php 
// File: app/View/Uploads/admin_view.ctp

$details = array();

$tmp = array('User' => $upload['User']);
$User = $this->Html->link($tmp['User']['name']. $this->Avatar->view($tmp, 'tiny'), array('controller' => 'users', 'action' => 'view', $tmp['User']['id']), array('escape' => false, 'class' => 'avatar_tiny'));  

$details[] = array('name' => __('Owner'), 'value' => $User);
$details[] = array('name' => __('Equipment Id'), 'value' => $this->Html->link($upload['Equipment']['id'], array('controller' => 'equipment', 'action' => 'view', $upload['Equipment']['id'])));
$details[] = array('name' => __('EU ID'), 'value' => $this->Html->link($upload['ExceptionUpdate']['id'], array('controller' => 'equipment', 'action' => 'view', $upload['Equipment']['id'])));
$details[] = array('name' => __('MD5'), 'value' => $this->Html->link($upload['Upload']['md5'], array('controller' => 'uploads', 'action' => 'index', 'q' => $upload['Upload']['md5'])) );
$details[] = array('name' => __('Type'), 'value' => $upload['Upload']['type']);
$details[] = array('name' => __('Mime Type'), 'value' => $upload['Upload']['mimetype']);
$details[] = array('name' => __('Created'), 'value' => $this->Wrap->niceTime($upload['Upload']['created']));


$page_options = array();
$page_options[] = $this->Html->link(__('Download'), array('action' => 'download', $upload['Upload']['id']));
$page_options[] = $this->Form->postLink(__('Delete'),array('action' => 'delete', $upload['Upload']['id']),array('confirm' => 'Are you sure?'));

$stats = array(
/* disabled
	array(
		'id' => 'tagsUpload',
		'name' => __('Tags'), 
		'value' => $upload['Upload']['counts']['Tagged.all'], 
		'tab' => array('tabs', '5'), // the tab to display
	),
*/
);

$tabs = array(
/* disabled
	array(
		'key' => 'tags',
		'title' => __('Tags'),
		'url' => array('plugin' => 'tags', 'controller' => 'tags', 'action' => 'tagged', 'upload', $upload['Upload']['id']),
	),
*/
);
echo $this->element('Utilities.page_view', array(
	'page_title' => __('File'). ': '. $upload['Upload']['filename'],
	'page_options' => $page_options,
	'details' => $details,
	////'stats' => $stats,
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
));

?>
