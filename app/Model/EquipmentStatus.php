<?php
App::uses('AppModel', 'Model');
/**
 * EquipmentStatus Model
 *
 * @property Equipment $Equipment
 */
class EquipmentStatus extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Equipment' => array(
			'className' => 'Equipment',
			'foreignKey' => 'equipment_status_id',
			'dependent' => false,
		)
	);
	
	public $emptyOption = 'Equipment Tracking Initiated';

	public function afterFind($results = array(), $primary = false)
	{
		foreach($results as $i => $result)
		{
			if(isset($result['EquipmentStatus']) and !isset($result['EquipmentStatus']['id']))
			{
				$results[$i]['EquipmentStatus']['id'] = 0;
				$results[$i]['EquipmentStatus']['name'] = __('Equipment Tracking Initiated');
			}
		}

		return parent::afterFind($results, $primary);
	}
}
