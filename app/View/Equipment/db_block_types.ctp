<?php
$stats = array(
	'total' => array('name' => __('Total'), 'value' => count($_equipment), 'color' => 'FFFFFF'),
	'EquipmentType.0' => array('name' => __('No Type'), 'value' => 0, 'color' => '000000'),
);

foreach($equipmentTypes as $equipmentType_id => $equipmentType_name)
{
	$equipmentType_name = preg_replace('/(Government|Contractor)\s+Furnished\s+Equipment/i', '$1', $equipmentType_name);
	$stats['EquipmentType.'.$equipmentType_id] = array(
		'name' => $equipmentType_name,
		'value' => 0,
		'color' => substr(md5($equipmentType_name), 0, 6),
	);
}

foreach($_equipment as $equipment)
{
	foreach($equipment['EquipmentType'] as $equipmentType)
	{
		if($equipmentType['id'])
		{
			$equipmentType_id = $equipmentType['id'];
			
			if(!isset($stats['EquipmentType.'.$equipmentType_id]))
			{
				$stats['EquipmentType.'.$equipmentType_id] = array(
					'name' => $equipmentType['name'],
					'value' => 0,
					'color' => substr(md5($equipmentType['name']), 0, 6),
					
				);
			}
			$stats['EquipmentType.'.$equipmentType_id]['value']++;
		}
		else
		{
			$stats['EquipmentType.0']['value']++;
		}
	}
}
$stats = Hash::sort($stats, '{s}.value', 'desc');

$pie_data = array(array(__('Type'), __('num %s', __('Equipment')) ));
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
	'title' => __('%s by %s', __('Equipment'), __('Type')),
	'content' => $content,
));