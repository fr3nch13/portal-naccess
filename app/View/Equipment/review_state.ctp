<?php 
// File: app/View/Equipment/review_state.ctp


$page_options = array(
	$this->Html->link(__('Create New NAC Exception/Tracking'), array('action' => 'add')),
	$this->Html->link(__('Create Many New NAC Exception/Tracking'), array('action' => 'batch_add')),
);

// content
$th = array(
	'Equipment.id' => array('content' => __('ID'), 'options' => array('sort' => 'Equipment.id')),
	'EquipmentDetail.example_ticket' => array('content' => __('Example'), 'options' => array('sort' => 'EquipmentDetail.example_ticket')),
	'EquipmentDetail.tickets' => array('content' => __('Other Tickets'), 'options' => array('sort' => 'EquipmentDetail.tickets')),
	'EquipmentDetail.mac_address' => array('content' => __('MAC Address'), 'options' => array('sort' => 'EquipmentDetail.mac_address')),
	'EquipmentDetail.ip_address' => array('content' => __('IP Address'), 'options' => array('sort' => 'EquipmentDetail.ip_address')),
	'EquipmentDetail.asset_tag' => array('content' => __('Asset Tag'), 'options' => array('sort' => 'EquipmentDetail.asset_tag')),
	'EquipmentStatus.name' => array('content' => __('Status'), 'options' => array('sort' => 'EquipmentStatus.name')),
	'EquipmentAddedUser.name' => array('content' => __('Tracking Created By'), 'options' => array('sort' => 'EquipmentAddedUser.name')),
	'UploadLatest.name' => array('content' => __('Last NAC Exception Form')),
	'EquipmentModifiedUser.name' => array('content' => __('Last Updated By'), 'options' => array('sort' => 'EquipmentModifiedUser.name')),
	'Equipment.created' => array('content' => __('Created'), 'options' => array('sort' => 'Equipment.created')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
	'multiselect' => true,
);

$td = array();
foreach ($_equipment as $i => $equipment)
{
	$uploadLatest = '&nbsp;';
	if(isset($equipment['UploadLatest']['filename']))
	{
		$uploadLatest = $this->Html->link($equipment['UploadLatest']['filename'], array('controller' => 'uploads', 'action' => 'download', $equipment['UploadLatest']['id']));
	}
	$EquipmentModifiedUser = '&nbsp;';
	if(isset($equipment['EquipmentModifiedUser']['name']))
	{
		$tmp = array('User' => $equipment['EquipmentModifiedUser']);
		$EquipmentModifiedUser = $this->Html->link($tmp['User']['name']. $this->Avatar->view($tmp, 'tiny'), array('controller' => 'users', 'action' => 'view', $tmp['User']['id']), array('escape' => false, 'class' => 'avatar_tiny'));  
	}
	
	$tmp = array('User' => $equipment['EquipmentAddedUser']);
	$EquipmentAddedUser = $this->Html->link($tmp['User']['name']. $this->Avatar->view($tmp, 'tiny'), array('controller' => 'users', 'action' => 'view', $tmp['User']['id']), array('escape' => false, 'class' => 'avatar_tiny'));  
	
	$td[$i] = array(
		$this->Html->link($equipment['Equipment']['id'], array('action' => 'view', $equipment['Equipment']['id'])),
		$this->Html->link($equipment['EquipmentDetail']['example_ticket'], array('action' => 'view', $equipment['Equipment']['id'])),
		$equipment['EquipmentDetail']['tickets'],
		$equipment['EquipmentDetail']['mac_address'],
		$equipment['EquipmentDetail']['ip_address'],
		$equipment['EquipmentDetail']['asset_tag'],
		$equipment['EquipmentStatus']['name'],
		$EquipmentAddedUser,
		$uploadLatest,
		$EquipmentModifiedUser,
		$this->Wrap->niceTime($equipment['Equipment']['created']),
		array(
			$this->Html->link(__('View'), array('action' => 'view', $equipment['Equipment']['id'])). 
			$this->Html->link(__('Edit'), array('action' => 'edit', $equipment['Equipment']['id'])).
			$this->Html->link(__('Add NAC Form'), array('controller' => 'exception_updates', 'action' => 'add', $equipment['Equipment']['id'])), 
			array('class' => 'actions'),
		),
		'multiselect' => $equipment['Equipment']['id'],
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('%s NAC Exceptions/Tracking', $review_state['ReviewState']['name']),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	// multiselect options
	'use_multiselect' => true,
	'multiselect_options' => array(
		'review_state' => __('Assign %s', __('Review State')),
		'equipment_status' => __('Assign %s', __('Equipment Status')),
		'op_div' => __('Assign %s', __('OPDIV/IC')),
	),
	'multiselect_referer' => array(
		'admin' => false,
		'controller' => 'equipment',
		'action' => 'review_state',
		$this->params['pass'][0],
	),
	));
?>