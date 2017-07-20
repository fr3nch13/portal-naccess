<?php 
// File: app/View/Equipment/admin_discovery_method.ctp


$page_options = array(
//	$this->Html->link(__('Add Equipment'), array('action' => 'add')),
);

// content
$th = array(
	'Equipment.id' => array('content' => __('ID'), 'options' => array('sort' => 'Equipment.id')),
	'EquipmentDetail.example_ticket' => array('content' => __('Example'), 'options' => array('sort' => 'EquipmentDetail.example_ticket')),
	'EquipmentDetail.mac_address' => array('content' => __('MAC Address'), 'options' => array('sort' => 'EquipmentDetail.mac_address')),
	'EquipmentStatus.name' => array('content' => __('Status'), 'options' => array('sort' => 'EquipmentStatus.name')),
	'EquipmentAddedUser.name' => array('content' => __('Tracking Created By'), 'options' => array('sort' => 'EquipmentAddedUser.name')),
	'Equipment.created' => array('content' => __('Created'), 'options' => array('sort' => 'Equipment.created')),
	'UploadLatest.name' => array('content' => __('Last EU File')),
	'UploadLatestUser.name' => array('content' => __('Last EU File Added By')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($_equipment as $i => $equipment)
{
	$uploadLatest = '&nbsp;';
	$uploadLatestUser = '&nbsp;';
	if(isset($equipment['UploadLatest']['filename']))
	{
		$uploadLatest = $this->Html->link($equipment['UploadLatest']['filename'], array('controller' => 'uploads', 'action' => 'download', $equipment['UploadLatest']['id']));
	}
	if(isset($equipment['UploadLatestUser']['name']))
	{
		$tmp = array('User' => $equipment['UploadLatestUser']);
		$uploadLatestUser = $this->Html->link($tmp['User']['name']. $this->Avatar->view($tmp, 'tiny'), array('controller' => 'users', 'action' => 'view', $tmp['User']['id']), array('escape' => false, 'class' => 'avatar_tiny'));  
	}
	
	$tmp = array('User' => $equipment['EquipmentAddedUser']);
	$EquipmentAddedUser = $this->Html->link($tmp['User']['name']. $this->Avatar->view($tmp, 'tiny'), array('controller' => 'users', 'action' => 'view', $tmp['User']['id']), array('escape' => false, 'class' => 'avatar_tiny'));  
	
	$td[$i] = array(
		$this->Html->link($equipment['Equipment']['id'], array('action' => 'view', $equipment['Equipment']['id'])),
		$this->Html->link($equipment['EquipmentDetail']['example_ticket'], array('action' => 'view', $equipment['Equipment']['id'])),
		$equipment['EquipmentDetail']['mac_address'],
		$equipment['EquipmentStatus']['name'],
		$EquipmentAddedUser,
		$this->Wrap->niceTime($equipment['Equipment']['created']),
		$uploadLatest,
		$uploadLatestUser,
		array(
			$this->Html->link(__('View'), array('action' => 'view', $equipment['Equipment']['id'])). 
			$this->Html->link(__('Add EU'), array('controller' => 'exception_updates', 'action' => 'add', $equipment['Equipment']['id'])),
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Equipment in %s: %s', __('Discovery Method'), $discovery_method['DiscoveryMethod']['name']),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
));