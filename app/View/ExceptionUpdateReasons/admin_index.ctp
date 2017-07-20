<?php 
// File: app/View/ExceptionUpdateReasons/index.ctp


$page_options = array(
	$this->Html->link(__('Add Exception Update Reason'), array('action' => 'add')),
);

// content
$th = array(
	'ExceptionUpdateReason.name' => array('content' => __('Exception Update Reason'), 'options' => array('sort' => 'ExceptionUpdateReason.name')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
foreach ($exception_update_reasons as $i => $exception_update_reason)
{
	$td[$i] = array(
		$exception_update_reason['ExceptionUpdateReason']['name'],
		array(
			$this->Html->link(__('Edit'), array('action' => 'edit', $exception_update_reason['ExceptionUpdateReason']['id'])).
			$this->Html->link(__('Delete'), array('action' => 'delete', $exception_update_reason['ExceptionUpdateReason']['id']),array('confirm' => 'Are you sure?')), 
			array('class' => 'actions'),
		),
	);
}

echo $this->element('Utilities.page_index', array(
	'page_title' => __('Exception Update Reasons'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	));
?>