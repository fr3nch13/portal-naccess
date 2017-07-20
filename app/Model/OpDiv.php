<?php
App::uses('AppModel', 'Model');
/**
 * OpDiv Model
 *
 * @property Equipment $Equipment
 */
class OpDiv extends AppModel 
{
	public $displayField = 'name';
	
	public $validate = array(
		'slug' => array(
			'unique' => array(
				'rule' => array('Rule_uniqueSlug'),
				'required' => true,
				'message' => 'This field must be unique.',
			),
		),
	);
	
	public $hasMany = array(
		'Equipment' => array(
			'className' => 'Equipment',
			'foreignKey' => 'op_div_id',
			'dependent' => false,
		)
	);
	
	public $emptyOption = 'TBD';
	
	public function beforeValidate($options = array())
	{
		if(isset($this->data[$this->alias]['name']) and !isset($this->data[$this->alias]['slug']))
		{
			$this->data[$this->alias]['slug'] = strtolower(Inflector::slug($this->data[$this->alias]['name']));
		}
		return parent::beforeValidate($options);
	}
	
	public function Rule_uniqueSlug($check)
	{
		$existing_id = $this->field('id', $check);
		
		$invalidate = false;
		
		// only if the id isn't the current id
		if($existing_id)
		{
			// updating an existing record
			if(isset($this->data[$this->alias]['id']))
			{
				if($this->data[$this->alias]['id'] != $existing_id)
				{
					$invalidate = true;
				}
			}
			// new record
			else
			{
				$invalidate = true;
			}
		}
		
		if($invalidate)
		{
			// mark name name as invalid
			$this->validationErrors['name'] = array(
				$this->validate['slug']['unique']['message'],
			);
			return false;
		}
		return true;
	}
	
	public function nameToID($name = '')
	{
		$slug = strtolower(Inflector::slug($name));
		
		return $this->field('id', array('slug' => $slug));
	}
}
