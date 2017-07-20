<?php
App::uses('AppModel', 'Model');
/**
 * OrgGroup Model
 *
 * @property User $User
 */
class OrgGroup extends AppModel 
{

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notBlank'),
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'org_group_id',
			'dependent' => false,
		),
		'Equipment' => array(
			'className' => 'Equipment',
			'foreignKey' => 'org_group_id',
			'dependent' => false,
		)
	);
	
	public function beforeDelete($cascade = true)
	{
		// set the org_group_id for the has many to 0
		foreach($this->hasMany as $model => $info)
		{
			$this->{$model}->updateAll(
				array($model. '.'. $info['foreignKey'] => 0),
				array($model. '.'. $info['foreignKey'] => $this->id)
			);
		}
		return parent::beforeDelete($cascade = true);
	}
	
	public function read($fields = null, $id = null)
	{
		if($id == 0)
		{
			return $this->Common_readGlobalObject();
		}
		return parent::read($fields, $id);
	}
}
