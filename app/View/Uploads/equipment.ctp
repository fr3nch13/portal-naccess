<?php 
// File: app/View/Uploads/equipment.ctp
$page_options = array(
	$this->Html->link(__('Add a File'), array('action' => 'add', $this->params['pass'][0])),
);

// content
$th = array();
	$th['Upload.type'] = array('content' => __('Type'), 'options' => array('sort' => 'Upload.type'));
	$th['Upload.filename'] = array('content' => __('File Name'), 'options' => array('sort' => 'Upload.filename'));
	$th['User.name'] = array('content' => __('Owner'), 'options' => array('sort' => 'User.name'));
	$th['ExceptionUpdate.id'] = array('content' => __('Exception Update ID'), 'options' => array('sort' => 'ExceptionUpdate.id'));
	$th['Upload.created'] = array('content' => __('Uploaded'), 'options' => array('sort' => 'Upload.created'));
	$th['actions'] = array('content' => __('Actions'), 'options' => array('class' => 'actions'));

$td = array();
foreach ($uploads as $i => $upload)
{
	$tmp = array('User' => $upload['User']);
	$User = $this->Html->link($tmp['User']['name']. $this->Avatar->view($tmp, 'tiny'), array('controller' => 'users', 'action' => 'view', $tmp['User']['id']), array('escape' => false, 'class' => 'avatar_tiny'));
	
	$td[$i] = array();
	$td[$i]['Upload.type'] = $this->Wrap->fileIcon($upload['Upload']['type']);
	$td[$i]['Upload.filename'] = $this->Html->link($upload['Upload']['filename'], array('controller' => 'uploads', 'action' => 'view', $upload['Upload']['id']));
	$td[$i]['User.name'] = $User;
	$td[$i]['ExceptionUpdate.id'] = $upload['ExceptionUpdate']['id'];
	$td[$i]['Upload.created'] = $this->Wrap->niceTime($upload['Upload']['created']);
	
	$actions = $this->Html->link(__('View'), array('action' => 'view', $upload['Upload']['id']));
	$actions .= $this->Html->link(__('Download'), array('action' => 'download', $upload['Upload']['id']));
	$actions .= $this->Html->link(__('Delete'), array('action' => 'delete', $upload['Upload']['id']), null, __('Are you sure you enat to delete this %s?', 'Equipment File'));
	
	$td[$i]['actions'] = array(
		$actions,
		array('class' => 'actions'),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Equipment Files'),
	'page_options' => $page_options,
	'search_placeholder' => __('Files'),
	'th' => $th,
	'td' => $td,
	));
?>