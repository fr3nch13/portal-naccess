<?php

$dashboard_blocks = array(
	'equipment_overview' => array('controller' => 'equipment', 'action' => 'db_block_overview', 'plugin' => false),
	'db_block_statuses' => array('controller' => 'equipment', 'action' => 'db_block_statuses', 'plugin' => false),
	'db_block_types' => array('controller' => 'equipment', 'action' => 'db_block_types', 'plugin' => false),
	'db_block_discovery_methods' => array('controller' => 'equipment', 'action' => 'db_block_discovery_methods', 'plugin' => false),
);

echo $this->element('Utilities.page_dashboard', array(
	'page_title' => __('Dashboard: %s', __('Overview')),
	'page_options_html' => $this->element('dashboard_options'),
	'dashboard_blocks' => $dashboard_blocks,
));