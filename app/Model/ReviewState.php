<?php
App::uses('AppModel', 'Model');
/**
 * ReviewState Model
 *
 * @property Equipment $Equipment
 */
class ReviewState extends AppModel 
{

	public $displayField = 'name';
	
	public $validate = array(
		'default' => array(
			'boolean' => array(
				'rule' => array('boolean'),
			),
		),
	);
	
	public $hasMany = array(
		'Equipment' => array(
			'className' => 'Equipment',
			'foreignKey' => 'review_state_id',
			'dependent' => false,
		)
	);
	
	public function defaultId()
	{
		return $this->field('id', array('default' => true));
	}

}
