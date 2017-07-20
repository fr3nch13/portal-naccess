<?php
App::uses('AppModel', 'Model');
/**
 * ExceptionUpdate Model
 *
 * @property Equipment $Equipment
 * @property ReleasedUser $ReleasedUser
 * @property VerifiedUser $VerifiedUser
 * @property ExceptionUpdateReason $ExceptionUpdateReason
 */
class ExceptionUpdate extends AppModel 
{

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'equipment_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'verified_user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'exception_update_reason_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed


/**
 * hasMany associations
 *
 * @var array
 */
	public $hasOne = array(
		'Upload' => array(
			'className' => 'Upload',
			'foreignKey' => 'exception_update_id',
			'dependent' => true,
		),
	);
	
/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Equipment' => array(
			'className' => 'Equipment',
			'foreignKey' => 'equipment_id',
		),
		'ExceptionUpdateAddedUser' => array(
			'className' => 'User',
			'foreignKey' => 'added_user_id',
		),
		'ExceptionUpdateReleasedUser' => array(
			'className' => 'User',
			'foreignKey' => 'released_user_id',
		),
		'ExceptionUpdateVerifiedUser' => array(
			'className' => 'User',
			'foreignKey' => 'verified_user_id',
		),
		'ExceptionUpdateReason' => array(
			'className' => 'ExceptionUpdateReason',
			'foreignKey' => 'exception_update_reason_id',
		)
	);
	
	public $actsAs = array(
		'Dblogger.Dblogger' // log all changes to the database
	);
	
	// used to map column names to readable states
	public $mappedFields = array(
		'equipment_id' => array('name' => 'Equipment', 'value' => 'Equipment.id'),
		'added_user_id' => array('name' => 'Created By', 'value' => 'ExceptionUpdateAddedUser.email'),
		'released_user_id' => array('name' => 'Equipment Released By', 'value' => 'ExceptionUpdateReleasedUser.email'),
		'released_user_other' => array('name' => 'Equipment Released By (Other)'),
		'verified_user_id' => array('name' => 'Equipment Verified By', 'value' => 'ExceptionUpdateVerifiedUser.email'),
		'verified_user_other' => array('name' => 'Equipment Verified By (Other)'),
		'exception_update_reason_id' => array('name' => 'Reason', 'value' => 'ExceptionUpdateReason.name'),
	);
	
	public function beforeValidate($options = array())
	{
		// see if the file uploaded ok
		// if there is no id, then it's being created
		if(isset($this->data['Upload']))
		{
			// make sure [file] exists
			if(isset($this->data['Upload']['file']))
			{
				$this->data['Upload'] = array_merge($this->data['Upload']['file'], $this->data['Upload']);
				unset($this->data['Upload']['file']);
			}
			
			if($this->data['Upload']['error'] == 4)
			{
				unset($this->data['Upload']);
			}
		}
		return parent::beforeValidate($options);
	}
	
	public function afterFind($results = array(), $primary = false)
	{
		
		foreach($results as $i => $result)
		{
			if(isset($result['EquipmentStatus']) and !isset($result['EquipmentStatus']['id']))
			{
				$results[$i]['EquipmentStatus']['id'] = 0;
				$results[$i]['EquipmentStatus']['name'] = 'Equipment tracking initiated';
			}
		}

		return parent::afterFind($results, $primary);
	}
}
