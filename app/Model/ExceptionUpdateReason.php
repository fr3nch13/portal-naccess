<?php
App::uses('AppModel', 'Model');
/**
 * ExceptionUpdateReason Model
 *
 * @property ExceptionUpdate $ExceptionUpdate
 */
class ExceptionUpdateReason extends AppModel 
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
		'ExceptionUpdate' => array(
			'className' => 'ExceptionUpdate',
			'foreignKey' => 'exception_update_reason_id',
			'dependent' => false,
		)
	);

	public function afterFind($results = array(), $primary = false)
	{
		
		foreach($results as $i => $result)
		{
			if(isset($result['ExceptionUpdateReason']) and !isset($result['ExceptionUpdateReason']['id']))
			{
				$results[$i]['ExceptionUpdateReason']['id'] = 0;
				$results[$i]['ExceptionUpdateReason']['name'] = 'Equipment Tracking Initiated';
			}
		}

		return parent::afterFind($results, $primary);
	}
}
