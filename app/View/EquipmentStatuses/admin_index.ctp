<?php 
// File: app/View/EquipmentStatuses/index.ctp


$page_options = array(
	$this->Html->link(__('Add Equipment Status'), array('action' => 'add')),
);

// content
$th = array(
	'EquipmentStatus.name' => array('content' => __('Equipment Status'), 'options' => array('sort' => 'EquipmentStatus.name')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($equipment_statuses as $i => $equipment_status)
{
	$td[$i] = array(
		$equipment_status['EquipmentStatus']['name'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $equipment_status['EquipmentStatus']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $equipment_status['EquipmentStatus']['id']),array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Equipment Statuses'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	));
?>