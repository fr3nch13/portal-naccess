<?php
App::uses('AppModel', 'Model');
/**
 * EquipmentType Model
 *
 * @property Equipment $Equipment
 */
class EquipmentType extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

	
	public $hasAndBelongsToMany = array(
		'Equipment' => array(
			'className' => 'Equipment',
			'joinTable' => 'equipment_equipment_types',
			'foreignKey' => 'equipment_id',
			'associationForeignKey' => 'equipment_type_id',
			'unique' => 'keepExisting',
			'with' => 'EquipmentEquipmentTypes',
		),
	);
}
