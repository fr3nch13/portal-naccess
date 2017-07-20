<?php
App::uses('AppModel', 'Model');
/**
 * DiscoveryMethod Model
 *
 * @property Equipment $Equipment
 */
class DiscoveryMethod extends AppModel 
{

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
			'foreignKey' => 'discovery_method_id',
			'dependent' => false,
		)
	);

}
