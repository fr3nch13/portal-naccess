<?php

$page_options = array();

$details = array(
	array('name' => __('Created'), 'value' => $this->Wrap->niceTime($org_group['OrgGroup']['created'])),
	array('name' => __('Modified'), 'value' => $this->Wrap->niceTime($org_group['OrgGroup']['modified'])),
);


$stats = array();
$tabs = array();
$stats[] = array(
	'id' => 'Users',
	'name' => __('Users'), 
	'ajax_count_url' => array('controller' => 'users', 'action' => 'group', $org_group['OrgGroup']['id'], 'admin' => true),
	'tab' => array('tabs', count($tabs)+1), // the tab to display
);
$tabs[] = array(
	'key' => 'Users',
	'title' => __('Users'),
	'url' => array('controller' => 'users', 'action' => 'group', $org_group['OrgGroup']['id'], 'admin' => true),
);

$stats[] = array(
	'id' => 'Equipment',
	'name' => __('Equipment'), 
	'ajax_count_url' => array('controller' => 'equipment', 'action' => 'group', $org_group['OrgGroup']['id'], 'admin' => true),
	'tab' => array('tabs', count($tabs)+1), // the tab to display
);
$tabs[] = array(
	'key' => 'Equipment',
	'title' => __('Equipment'),
	'url' => array('controller' => 'equipment', 'action' => 'group', $org_group['OrgGroup']['id'], 'admin' => true),
);

echo $this->element('Utilities.page_view', array(
	'page_title' => __('%s: %s', __('Org Group'), $org_group['OrgGroup']['name']),
	'page_options' => $page_options,
	'details' => $details,
	'stats' => $stats,
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
));