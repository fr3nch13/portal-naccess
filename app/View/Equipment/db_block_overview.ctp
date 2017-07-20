<?php

$stats = array(
	'total' => array('name' => __('Total'), 'value' => count($_equipment)),
);

/*
$soon = strtotime('+1 week');
$now = time();

foreach($_equipment as $equipment)
{
	if(!isset($stats['active']))
		$stats['active'] = array('name' => __('Active'), 'value' => 0);
	
	if($equipment['Equipment']['expiration_date'] > date('Y-m-d H:i:s'))
		$stats['active']['value']++;
		
	if(!isset($stats['expired']))
		$stats['expired'] = array('name' => __('Expired'), 'value' => 0);
	
	if($equipment['Equipment']['expiration_date'] < date('Y-m-d H:i:s'))
		$stats['expired']['value']++;
		
	if(!isset($stats['expiring']))
		$stats['expiring'] = array('name' => __('Expiring soon'), 'value' => 0);
		
	if(!isset($stats['noexpire']))
		$stats['noexpire'] = array('name' => __('No expiration'), 'value' => 0);
	
	if($equipment['Equipment']['expiration_date'])
	{
		$expiration_date = strtotime($equipment['Equipment']['expiration_date']);
			
		if($expiration_date < $soon and $expiration_date > $now)
		{
			$stats['expiring']['class'] = 'warning';
			$stats['expiring']['value']++;
		}
	}
	else
	{
		$stats['noexpire']['value']++;
	}
		
	if(!isset($stats['reviewed']))
		$stats['reviewed'] = array('name' => __('Reviewed'), 'value' => 0);
	
	if($equipment['Equipment']['review_status_id'])
		$stats['reviewed']['value']++;
		
}
*/

$content = $this->element('Utilities.object_dashboard_stats', array(
	'title' => false,
	'details' => $stats,
));

echo $this->element('Utilities.object_dashboard_block', array(
	'title' => __('%s - Overview', __('NAC Exceptions/Tracking')),
	'content' => $content,
));