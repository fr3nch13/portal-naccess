<?php 
// File: app/View/OpDivs/index.ctp


$page_options = array(
	$this->Html->link(__('Add %s', __('OPDIV/IC')), array('action' => 'add')),
);

// content
$th = array(
	'OpDiv.name' => array('content' => __('OPDIV/IC'), 'options' => array('sort' => 'OpDiv.name')),
	'OpDiv.slug' => array('content' => __('Slug'), 'options' => array('sort' => 'OpDiv.slug')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($op_divs as $i => $op_div)
{
	$td[$i] = array(
		$op_div['OpDiv']['name'],
		$op_div['OpDiv']['slug'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $op_div['OpDiv']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $op_div['OpDiv']['id']),array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('OPDIV/ICs'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	));
?>