<?php 
// File: app/View/EquipmentTypes/index.ctp


$page_options = array(
	$this->Html->link(__('Add Equipment Type'), array('action' => 'add')),
);

// content
$th = array(
	'EquipmentType.name' => array('content' => __('Equipment Type'), 'options' => array('sort' => 'EquipmentType.name')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($equipment_types as $i => $equipment_type)
{
	$td[$i] = array(
		$equipment_type['EquipmentType']['name'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $equipment_type['EquipmentType']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $equipment_type['EquipmentType']['id']),array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Equipment Types'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	));
?>