<?php
$stats = array(
	'total' => array('name' => __('Total'), 'value' => count($_equipment), 'color' => 'FFFFFF'),
	'DiscoveryMethod.0' => array('name' => __('No Discovery Method'), 'value' => 0, 'color' => '000000'),
);

foreach($discoveryMethods as $discoveryMethod_id => $discoveryMethod_name)
{
	$stats['DiscoveryMethod.'.$discoveryMethod_id] = array(
		'name' => $discoveryMethod_name,
		'value' => 0,
		'color' => substr(md5($discoveryMethod_name), 0, 6),
	);
}

foreach($_equipment as $equipment)
{
	if($equipment['DiscoveryMethod']['id'])
	{
		$discoveryMethod_id = $equipment['DiscoveryMethod']['id'];
		if(!isset($stats['DiscoveryMethod.'.$discoveryMethod_id]))
		{
			$stats['DiscoveryMethod.'.$discoveryMethod_id] = array(
				'name' => $equipment['DiscoveryMethod']['name'],
				'value' => 0,
				'color' => substr(md5($equipment['DiscoveryMethod']['name']), 0, 6),
			);
		}
		$stats['DiscoveryMethod.'.$discoveryMethod_id]['value']++;
	}
	else
	{
		$stats['DiscoveryMethod.0']['value']++;
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
	'title' => __('%s by %s', __('Equipment'), __('Discovery Method')),
	'content' => $content,
));