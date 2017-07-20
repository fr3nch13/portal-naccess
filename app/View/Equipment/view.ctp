<?php 
// File: app/View/Equipment/view.ctp

$page_options = array(
	$this->Html->link(__('Edit'), array('action' => 'edit', $this->params['pass'][0])),
);

if(in_array(AuthComponent::user('role'), array('admin', 'reviewer')))
{
	$review_state = ($equipment['ReviewState']['id']?$equipment['ReviewState']['name']:'Unknown');
	$review_state = __('%s - Click to change', $review_state);
	$page_options[] = $this->Html->link($review_state, array('action' => 'edit_state', $equipment['Equipment']['id']));
}

if(in_array(AuthComponent::user('role'), array('admin')))
{
	$page_options[] = $this->Html->link(__('Delete'), array('action' => 'delete', $equipment['Equipment']['id'], 'admin' => true), array('confirm' => Configure::read('Dialogues.deleteequipment')));
}

$details_left = array();
$details_left[] = array('name' => __('ID'), 'value' => $equipment['Equipment']['id']);
$details_left[] = array('name' => __('Example'), 'value' => $equipment['EquipmentDetail']['example_ticket']);
$details_left[] = array('name' => __('MAC Address'), 'value' => $equipment['EquipmentDetail']['mac_address']);
$details_left[] = array('name' => __('Equipment Status'), 'value' => $equipment['EquipmentStatus']['name']);
$details_left[] = array('name' => __('Other Tickets'), 'value' => $this->Wrap->descView($equipment['EquipmentDetail']['tickets']));

$details_right = array();

$tmp = array('User' => $equipment['EquipmentAddedUser']);
$EquipmentAddedUser = $this->Html->link($tmp['User']['name']. $this->Avatar->view($tmp, 'tiny'), array('controller' => 'users', 'action' => 'view', $tmp['User']['id']), array('escape' => false, 'class' => 'avatar_tiny'));  
$EquipmentModifiedUser = '';
if($equipment['EquipmentModifiedUser']['id'])
{
	$tmp = array('User' => $equipment['EquipmentModifiedUser']);
	$EquipmentModifiedUser = $this->Html->link($tmp['User']['name']. $this->Avatar->view($tmp, 'tiny'), array('controller' => 'users', 'action' => 'view', $tmp['User']['id']), array('escape' => false, 'class' => 'avatar_tiny'));  
}
$details_right[] = array('name' => __('Created'), 'value' => $this->Wrap->niceTime($equipment['Equipment']['created']));
$details_right[] = array('name' => __('Created By'), 'value' => $EquipmentAddedUser);
$details_right[] = array('name' => __('Last Updated'), 'value' => $this->Wrap->niceTime($equipment['Equipment']['modified']));
$details_right[] = array('name' => __('Last Updated By'), 'value' => $EquipmentModifiedUser);
$details_right[] = array('name' => __('NAC Review State'), 'value' =>  $equipment['ReviewState']['name']);

$additional_details = array();

$equipment_types = Set::classicExtract($equipment['EquipmentType'], '{n}.name');
if(!$equipment_types) $equipment_types = array('N/A');

$EquipmentVerifiedUser = '';
if($equipment['EquipmentVerifiedUser']['id'])
{
	$tmp = array('User' => $equipment['EquipmentVerifiedUser']);
	$EquipmentVerifiedUser = $this->Html->link($tmp['User']['name']. $this->Avatar->view($tmp, 'tiny'), array('controller' => 'users', 'action' => 'view', $tmp['User']['id']), array('escape' => false, 'class' => 'avatar_tiny'));  
}
$additional_details[] = array('name' => __('FO Case #'), 'value' => $equipment['EquipmentDetail']['fo_case_num']);
$additional_details[] = array('name' => __('Equipment Serial #'), 'value' => $equipment['Equipment']['serial']);
$additional_details[] = array('name' => __('Equipment Types'), 'value' => implode(', ', $equipment_types));
$additional_details[] = array('name' => __('Ip Address'), 'value' => $equipment['EquipmentDetail']['ip_address']);
$additional_details[] = array('name' => __('Asset Tag'), 'value' => $equipment['EquipmentDetail']['asset_tag']);
$additional_details[] = array('name' => __('Owner'), 'value' => $equipment['EquipmentDetail']['owner']);
$additional_details[] = array('name' => __('Loc (bld-rm)'), 'value' => $equipment['EquipmentDetail']['loc_building']. '-'. $equipment['EquipmentDetail']['loc_room']);
//$additional_details[] = array('name' => __('Equipment Type'), 'value' => $equipment['EquipmentType']['name']);
$additional_details[] = array('name' => __('Make/Model'), 'value' => $equipment['Equipment']['make']. '/'. $equipment['Equipment']['model']);
$additional_details[] = array('name' => __('Verified By User'), 'value' => $EquipmentVerifiedUser);
//$additional_details[] = array('name' => __('Verified By Org'), 'value' => $equipment['VerifiedOrg']['name']);
$additional_details[] = array('name' => __('Discovery Method'), 'value' => $equipment['DiscoveryMethod']['name']);
$additional_details[] = array('name' => __('Discovered'), 'value' => $this->Wrap->niceTime($equipment['Equipment']['discovered']));
if(in_array(AuthComponent::user('role'), array('admin')))
{
	$additional_details[] = array('name' => __('Org Group'), 'value' => $equipment['OrgGroup']['name']);
}

if(isset($equipment['OpDiv']['id']) and $equipment['OpDiv']['id'])
{
	$additional_details[] = array('name' => __('Associated OPDIV/IC'), 'value' => $equipment['OpDiv']['name']);
}
else
{
	$additional_details[] = array('name' => __('Associated OPDIV/IC (Other)'), 'value' => $equipment['EquipmentDetail']['op_div_other']);
}

$additional_details[] = array('name' => __('Additional Details'), 'value' => $this->Wrap->descView($equipment['EquipmentDetail']['cust_info']));

$stats = array(
	array(
		'id' => 'exceptionUpdate',
		'name' => __('NAC Exception Form'), 
		'value' => $equipment['Equipment']['counts']['ExceptionUpdate.all'], 
		'tab' => array('ui-tabs', '1'), // the tab to display
	),
	array(
		'id' => 'uploadsEquipment',
		'name' => __('NAC Forms'), 
		'value' => $equipment['Equipment']['counts']['Upload.all'], 
		'tab' => array('ui-tabs', '2'), // the tab to display
	),
);
		
$tabs = array();
$tabs[] = array(
	'key' => 'exceptionUpdate',
	'title' => __('NAC Exception Forms'),
	'url' => array('controller' => 'exception_updates', 'action' => 'equipment', $equipment['Equipment']['id']),
);
$tabs[] = array(
	'key' => 'details',
	'title' => __('Additional Equipment Details'),
	'content' => $this->element('Utilities.details', array(
		'title' => __('Additional Details'),
		'details' => $additional_details,
	)),
);
$tabs[] = array(
	'key' => 'uploadsEquipment',
	'title' => __('Files'),
	'url' => array('controller' => 'uploads', 'action' => 'equipment', $equipment['Equipment']['id']),
);
$tabs[] = array(
	'key' => 'description',
	'title' => __('Notes'),
	'content' => $this->Wrap->descView($equipment['EquipmentDetail']['details']),
);


echo $this->element('Utilities.page_compare', array(
	'page_title' => __('Equipment Details'),
	'page_options' => $page_options,
	'details_left_title' => ' ',
	'details_left' => $details_left,
	'details_right_title' => ' ',
	'details_right' => $details_right,
	//'stats' => $stats,
	'tabs_id' => 'tabs',
	'tabs' => $tabs,
));

?>