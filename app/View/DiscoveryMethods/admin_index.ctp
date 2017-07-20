<?php 
// File: app/View/DiscoveryMethods/index.ctp


$page_options = array(
	$this->Html->link(__('Add Discovery Method'), array('action' => 'add')),
);

// content
$th = array(
	'DiscoveryMethod.name' => array('content' => __('Discovery Method'), 'options' => array('sort' => 'DiscoveryMethod.name')),
	'DiscoveryMethod.count' => array('content' => __('# Equipment')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($discovery_methods as $i => $discovery_method)
{
	$td[$i] = array(
		$this->Html->link($discovery_method['DiscoveryMethod']['name'], array('action' => 'view', $discovery_method['DiscoveryMethod']['id'])),
		$discovery_method['DiscoveryMethod']['counts']['Equipment.all'],
		array(
			$this->Html->link(__('View'), array('action' => 'view', $discovery_method['DiscoveryMethod']['id'])).
			$this->Html->link(__('Edit'), array('action' => 'edit', $discovery_method['DiscoveryMethod']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $discovery_method['DiscoveryMethod']['id']),array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Discovery Methods'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	));
?>