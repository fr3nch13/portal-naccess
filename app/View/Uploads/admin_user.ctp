<?php 
// File: app/View/Uploads/admin_user.ctp

$page_options = array(
//	$this->Html->link(__('Add a File'), array('action' => 'add')),
);
// content
$th = array();
	$th['Upload.type'] = array('content' => __('Type'), 'options' => array('sort' => 'Upload.type'));
	$th['Upload.filename'] = array('content' => __('File Name'), 'options' => array('sort' => 'Upload.filename'));
	$th['Equipment.id'] = array('content' => __('Equipment ID'), 'options' => array('sort' => 'Equipment.id'));
	$th['ExceptionUpdate.id'] = array('content' => __('Exception Update ID'), 'options' => array('sort' => 'ExceptionUpdate.id'));
	$th['Upload.created'] = array('content' => __('Uploaded'), 'options' => array('sort' => 'Upload.created'));
	$th['actions'] = array('content' => __('Actions'), 'options' => array('class' => 'actions'));

$td = array();
foreach ($uploads as $i => $upload)
{
	$td[$i] = array();
	$td[$i]['Upload.type'] = $this->Wrap->fileIcon($upload['Upload']['type']);
	$td[$i]['Upload.filename'] = $this->Html->link($upload['Upload']['filename'], array('controller' => 'uploads', 'action' => 'view', $upload['Upload']['id']));
	$td[$i]['Equipment.id'] = $this->Html->link($upload['Equipment']['id'], array('controller' => 'equipment', 'action' => 'view', $upload['Equipment']['id']));
	$td[$i]['ExceptionUpdate.id'] = $this->Html->link($upload['ExceptionUpdate']['id'], array('controller' => 'equipment', 'action' => 'view', $upload['Equipment']['id']));
	$td[$i]['Upload.created'] = $this->Wrap->niceTime($upload['Upload']['created']);
	
	$actions = $this->Html->link(__('View'), array('action' => 'view', $upload['Upload']['id']));
	$actions .= $this->Html->link(__('Download'), array('action' => 'download', $upload['Upload']['id']));
	$actions .= $this->Form->postLink(__('Delete'),array('action' => 'delete', $upload['Upload']['id']),array('confirm' => 'Are you sure?'));
	
	$td[$i]['actions'] = array(
		$actions,
		array('class' => 'actions'),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Files'),
	'page_options' => $page_options,
	'search_placeholder' => __('files'),
	'th' => $th,
	'td' => $td,
	));
?>