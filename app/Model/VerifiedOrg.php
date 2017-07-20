<?php
App::uses('AppModel', 'Model');
/**
 * VerifiedOrg Model
 *
 * @property Equipment $Equipment
 */
class VerifiedOrg extends AppModel {

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
			'foreignKey' => 'verified_org_id',
			'dependent' => false,
		)
	);

}
