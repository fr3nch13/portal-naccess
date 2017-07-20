<?php
$stats = array(
	'total' => array('name' => __('Total'), 'value' => count($_equipment), 'color' => 'FFFFFF'),
	'EquipmentStatus.0' => array('name' => __('Equipment Tracking Initiated'), 'value' => 0, 'color' => '000000'),
);

foreach($equipmentStatuses as $equipmentStatus_id => $equipmentStatus_name)
{
	$stats['EquipmentStatus.'.$equipmentStatus_id] = array(
		'name' => $equipmentStatus_name,
		'value' => 0,
		'color' => substr(md5($equipmentStatus_name), 0, 6),
	);
}

foreach($_equipment as $equipment)
{
	if($equipment['EquipmentStatus']['id'])
	{
		$equipmentStatus_id = $equipment['EquipmentStatus']['id'];
		if(!isset($stats['EquipmentStatus.'.$equipmentStatus_id]))
		{
			$stats['EquipmentStatus.'.$equipmentStatus_id] = array(
				'name' => $equipment['EquipmentStatus']['name'],
				'value' => 0,
				'color' => substr(md5($equipment['EquipmentStatus']['name']), 0, 6),
				
			);
		}
		$stats['EquipmentStatus.'.$equipmentStatus_id]['value']++;
	}
	else
	{
		$stats['EquipmentStatus.0']['value']++;
	}	
}
$stats = Hash::sort($stats, '{s}.value', 'desc');

$pie_data = array(array(__('Status'), __('num %s', __('Equipment')) ));
$pie_options = array('slices' => array());
foreach($stats as $i => $stat)
{
	if($i == 'total')
	{
		$stats[$i]['pie_exclude'] = true;
		$stats[$i]['color'] = 'FFFFFF';
		continue;
	}
	if(!$stat['value'])
	{
		unset($stats[$i]);
		continue;
	}
	$pie_data[] = array($stat['name'], $stat['value'], $i);
	$pie_options['slices'][] = array('color' => '#'. $stat['color']);
}

$content = $this->element('Utilities.object_dashboard_chart_pie', array(
	'title' => '',
	'data' => $pie_data,
	'options' => $pie_options,
));

$content .= $this->element('Utilities.object_dashboard_stats', array(
	'title' => '',
	'details' => $stats,
));

echo $this->element('Utilities.object_dashboard_block', array(
	'title' => __('%s by %s', __('Equipment'), __('Status')),
	'content' => $content,
));