<?php 
// File: app/View/ExceptionUpdates/equipment.ctp

$page_options = array(
	$this->Html->link(__('Add NAC Exception Form'), array('action' => 'add', $this->params['pass'][0])),
);

// content
$th = array(
	'ExceptionUpdate.id' => array('content' => __('ID'), 'options' => array('sort' => 'ExceptionUpdate.id')),
	'ExceptionUpdate.created' => array('content' => __('Time'), 'options' => array('sort' => 'ExceptionUpdate.created')),
	'ExceptionUpdateReleasedUser.name' => array('content' => __('Form Received From'), 'options' => array('sort' => 'ExceptionUpdateReleasedUser.name')),
	'ExceptionUpdateVerifiedUser.name' => array('content' => __('Equipment Verified By'), 'options' => array('sort' => 'ExceptionUpdateVerifiedUser.name')),
	'ExceptionUpdateReason.name' => array('content' => __('Reason'), 'options' => array('sort' => 'ExceptionUpdateReason.name')),
	'Upload.filename' => array('content' => __('NAC Form'), 'options' => array('sort' => 'Upload.filename')),
	'ExceptionUpdateAddedUser.name' => array('content' => __('NAC Form Created By'), 'options' => array('sort' => 'ExceptionUpdateAddedUser.name')),
	'actions' => array('content' => __('Actions'), 'options' => array('class' => 'actions')),
);

$td = array();
$i = 0;
$role = AuthComponent::user('role');
foreach ($exception_updates as $exception_update)
{
	$released_by = ' ';
	if($exception_update['ExceptionUpdate']['released_user_id'])
	{
		$tmp = array('User' => $exception_update['ExceptionUpdateReleasedUser']);
		$released_by = $this->Html->link($tmp['User']['name']. $this->Avatar->view($tmp, 'tiny'), array('controller' => 'users', 'action' => 'view', $tmp['User']['id']), array('escape' => false, 'class' => 'avatar_tiny'));
	}
	else
	{
		$released_by .= $exception_update['ExceptionUpdate']['released_user_other'];
	}
	$verified_by = ' ';
	if($exception_update['ExceptionUpdate']['verified_user_id'])
	{
		$tmp = array('User' => $exception_update['ExceptionUpdateVerifiedUser']);
		$verified_by .= $this->Html->link($tmp['User']['name']. $this->Avatar->view($tmp, 'tiny'), array('controller' => 'users', 'action' => 'view', $tmp['User']['id']), array('escape' => false, 'class' => 'avatar_tiny'));
	}
	else
	{
		$verified_by .= $exception_update['ExceptionUpdate']['verified_user_other'];
	}
	$options = '';
	if($exception_update['Upload']['filename'])
	{
		$options .= $this->Html->link(__('Download'), array('controller' => 'uploads', 'action' => 'download', $exception_update['Upload']['id']));
	}
	if(in_array(AuthComponent::user('role'), array('admin', 'reviewer')))
	{
		$options .= $this->Html->link(__('Delete'), array('action' => 'delete', $exception_update['ExceptionUpdate']['id']),array('confirm' => Configure::read('Dialogues.deletecoc')));
	}
	
	$tmp = array('User' => $exception_update['ExceptionUpdateAddedUser']);
	
	$td[$i] = array(
		$exception_update['ExceptionUpdate']['id'],
		$this->Wrap->niceTime($exception_update['ExceptionUpdate']['created']),
		$released_by,
		$verified_by,
		$exception_update['ExceptionUpdateReason']['name'],
		$this->Html->link($exception_update['Upload']['filename'], array('controller' => 'uploads', 'action' => 'view', $exception_update['Upload']['id'])),
		$this->Html->link($tmp['User']['name']. $this->Avatar->view($tmp, 'tiny'), array('controller' => 'users', 'action' => 'view', $tmp['User']['id']), array('escape' => false, 'class' => 'avatar_tiny')),
		array(
			$options, 
			array('class' => 'actions'),
		),
	);

	$i++;
	$td[$i] = array(
		'&nbsp;', 
		__('Notes: '). $exception_update['ExceptionUpdate']['notes'],
	);

	$i++;
}
echo $this->element('Utilities.page_index', array(
	'page_title' => __('NAC Exception Forms'),
	'search_placeholder' => __('NAC Exception Forms'),
	'page_options' => $page_options,
	'th' => $th,
	'td' => $td,
	));
?>