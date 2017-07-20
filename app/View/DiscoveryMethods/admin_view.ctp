<?php 
// File: app/View/DiscoveryMethod/view.ctp

$page_options = array(
	$this->Html->link(__('Edit'), array('action' => 'edit', $this->params['pass'][0])),
	$this->Html->link(__('Delete'), array('action' => 'delete', $discovery_method['DiscoveryMethod']['id'], 'admin' => true), array('confirm' => 'Are you sure?')),
);

$details = array();
$details[] = array('name' => __('ID'), 'value' => $discovery_method['DiscoveryMethod']['id']);
$details[] = array('name' => __('Created'), 'value' => $this->Wrap->niceTime($discovery_method['DiscoveryMethod']['created']));
$details[] = array('name' => __('Last Updated'), 'value' => $this->Wrap->niceTime($discovery_method['DiscoveryMethod']['modified']));

$stats = array(
	array(
		'id' => 'equipment',
		'name' => __('Equipment'), 
		'value' => $discovery_method['DiscoveryMethod']['counts']['Equipment.all'], 
		'tab' => array('ui-tabs', '1'), // the tab to display
	),
);
		
$tabs = array();
$tabs[] = array(
	'key' => 'equipment',
	'title' => __('Equipment'),
	'url' => array('controller' => 'equipment', 'action' => 'discovery_method', $discovery_method['DiscoveryMethod']['id']),
);

echo $this->element('Utilities.page_view', array(
	'page_title' => __('%s: %s', __('Discovery Method'), $discovery_method['DiscoveryMethod']['name']),
	'page_options' => $page_options,
	'details' => $details,
	'stats' => $stats,
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
));