<?php 
// File: app/View/VerifiedOrgs/index.ctp


$page_options = array(
	$this->Html->link(__('Add Verified Org'), array('action' => 'add')),
);

// content
$th = array(
	'VerifiedOrg.name' => array('content' => __('Verified Org'), 'options' => array('sort' => 'VerifiedOrg.name')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($verified_orgs as $i => $verified_org)
{
	$td[$i] = array(
		$verified_org['VerifiedOrg']['name'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $verified_org['VerifiedOrg']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $verified_org['VerifiedOrg']['id']),array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Verified Orgs'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	));
?>