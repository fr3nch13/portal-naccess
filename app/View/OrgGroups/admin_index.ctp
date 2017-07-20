<?php 
// File: app/View/OrgGroups/index.ctp


$page_options = array(
);

// content
$th = array(
	'OrgGroup.name' => array('content' => __('Org Group'), 'options' => array('sort' => 'OrgGroup.name')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($org_groups as $i => $org_group)
{
	$td[$i] = array(
		$org_group['OrgGroup']['name'],
		array(
			$this->Html->link(__('View'), array('action' => 'view', $org_group['OrgGroup']['id'])), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Org Groups'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	));
?>