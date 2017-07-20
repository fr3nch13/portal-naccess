<?php
App::uses('AppModel', 'Model');
/**
 * Equipment Model
 *
 * @property EquipmentDetail $EquipmentDetail
 * @property EquipmentType $EquipmentType
 * @property VerifiedUser $VerifiedUser
 * @property ExceptionUpdate $ExceptionUpdate
 */
class Equipment extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'equipment_type_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'status' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'quantity' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasOne associations
 *
 * @var array
 */
	public $hasOne = array(
		'EquipmentDetail' => array(
			'className' => 'EquipmentDetail',
			'foreignKey' => 'equipment_id',
			'dependent' => true,
		)
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'EquipmentStatus' => array(
			'className' => 'EquipmentStatus',
			'foreignKey' => 'equipment_status_id',
			'plugin_snapshot' => true,
		),
		'EquipmentAddedUser' => array(
			'className' => 'User',
			'foreignKey' => 'added_user_id',
		),
		'EquipmentModifiedUser' => array(
			'className' => 'User',
			'foreignKey' => 'modified_user_id',
		),
		'EquipmentVerifiedUser' => array(
			'className' => 'User',
			'foreignKey' => 'verified_user_id',
		),
		'VerifiedOrg' => array(
			'className' => 'VerifiedOrg',
			'foreignKey' => 'verified_org_id',
			'plugin_snapshot' => true,
		),
		'DiscoveryMethod' => array(
			'className' => 'DiscoveryMethod',
			'foreignKey' => 'discovery_method_id',
			'plugin_snapshot' => true,
		),
		'ReviewState' => array(
			'className' => 'ReviewState',
			'foreignKey' => 'review_state_id',
			'plugin_snapshot' => true,
		),
		'OrgGroup' => array(
			'className' => 'OrgGroup',
			'foreignKey' => 'org_group_id',
		),
		'OpDiv' => array(
			'className' => 'OpDiv',
			'foreignKey' => 'op_div_id',
			'plugin_snapshot' => true,
		),
	);
	
	public $hasAndBelongsToMany = array(
		'EquipmentType' => array(
			'className' => 'EquipmentType',
			'joinTable' => 'equipment_equipment_types',
			'foreignKey' => 'equipment_id',
			'associationForeignKey' => 'equipment_type_id',
			'unique' => 'keepExisting',
		),
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ExceptionUpdate' => array(
			'className' => 'ExceptionUpdate',
			'foreignKey' => 'equipment_id',
			'dependent' => true,
		),
		'Upload' => array(
			'className' => 'Upload',
			'foreignKey' => 'equipment_id',
			'dependent' => true,
		),
	);
	
	public $actsAs = array(
		'Dblogger.Dblogger', // log all changes to the database
		'Snapshot.Stat' => array(
			'entities' => array(
				'all' => array(),
				'created' => array(),
				'modified' => array(),
			),
		),
	);
	
	// define the fields that can be searched
	public $searchFields = array(
		'Equipment.id',
		'Equipment.make',
		'Equipment.model',
		'Equipment.serial',
//		'EquipmentDetail.irt_ticket',
		'EquipmentDetail.example_ticket',
		'EquipmentDetail.asset_tag',
		'EquipmentDetail.mac_address',
		'EquipmentDetail.fo_case_num',
		'EquipmentDetail.loc_building',
		'EquipmentDetail.loc_room',
		'EquipmentDetail.tickets',
		'EquipmentDetail.details',
		'EquipmentDetail.owner',
		'EquipmentDetail.cust_info',
		'EquipmentDetail.ip_address',
		'EquipmentStatus.name',
//		'VerifiedOrg.name',
		'EquipmentAddedUser.name',
		'EquipmentAddedUser.email',
		'EquipmentVerifiedUser.name',
		'EquipmentVerifiedUser.email',
//		'ReviewState.name',
	);
	
	// fields that are boolean and can be toggled
	public $toggleFields = array('review_state');
	
	// used to map column names to readable states
	public $mappedFields = array(
		'review_state_id' => array('name' => 'Review State', 'value' => 'ReviewState.name'),
		'equipment_status_id' => array('name' => 'Equipment Status', 'value' => 'EquipmentStatus.name'),
		'verified_user_id' => array('name' => 'Verified By User', 'value' => 'EquipmentVerifiedUser.email'),
		'verified_org_id' => array('name' => 'Verified By Org', 'value' => 'VerifiedOrg.name'),
		'added_user_id' => array('name' => 'Created By', 'value' => 'EquipmentAddedUser.email'),
		'modified_user_id' => array('name' => 'Last Updated By', 'value' => 'EquipmentModifiedUser.email'),
		'discovery_method_id' => array('name' => 'Discovery Reason', 'value' => 'DiscoveryMethod.name'),
	);
	
	public $getLatestUpload = false;
	
	public $csv_field_map = array(
		'EquipmentDetail.mac_address' => 'MAC Address',
		'EquipmentDetail.ip_address' => 'IP Address',
		'EquipmentDetail.asset_tag' => 'Asset Tag', 
		'EquipmentDetail.example_ticket' => 'Example Ticket',
		'EquipmentDetail.tickets' => 'Other Tickets',
		'EquipmentDetail.apo' => 'Associated Project Officer, COR or COTR', 
		'EquipmentDetail.tech_poc' => 'Technical POC', 
		'Equipment.op_div_id' => 'OPDIV/IC',
	);
	
	public $batchSaved = 0;
	public $batchIssues = 0;
	public $batchDataToFix = array();
	
	
	public $multiselectOptions = array('review_state', 'equipment_status', 'op_div');
	
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
		
		if(isset($this->data['Equipment']['op_div_id']) and !$this->data['Equipment']['op_div_id'])
		{
			$this->data['Equipment']['op_div_id'] = 0;
		}
		return parent::beforeValidate($options);
	}
	
	public function afterFind($results = array(), $primary = false)
	{
		if($this->getLatestUpload)
		{
			foreach($results as $i => $result)
			{
				$equipment_id = (isset($result['Equipment']['id'])?$result['Equipment']['id']:false);
				if(!$equipment_id) continue;
				
				$uploadLatest = $this->Upload->find('first', array(
					'recursive' => 0,
					'contain' => array('User'),
					'conditions' => array(
						'Upload.equipment_id' => $equipment_id,
					),
					'order' => array(
						'Upload.created' => 'desc',
					),
				));
				$results[$i]['UploadLatest'] = (isset($uploadLatest['Upload'])?$uploadLatest['Upload']:array());
				$results[$i]['UploadLatestUser'] = (isset($uploadLatest['User'])?$uploadLatest['User']:array());
			}
		}
		return parent::afterFind($results, $primary);
	}
	
	public function afterSave($created = false, $options = array())
	{
		if($created and isset($this->data['Equipment']['id']) and $this->data['Equipment']['id'] > 0)
		{
			// newly created equipment, generate the first chain of custody
			$ExceptionUpdateData = array(
				'ExceptionUpdate' => array(
					'equipment_id' => $this->data['Equipment']['id'],
					'released_user_id' => 0,
					'released_user_other' => (isset($this->data['Equipment']['owner'])?$this->data['Equipment']['owner']:0),
					'verified_user_id' => (isset($this->data['Equipment']['verified_user_id'])?$this->data['Equipment']['verified_user_id']:0),
					'added_user_id' => (isset($this->data['Equipment']['added_user_id'])?$this->data['Equipment']['added_user_id']:0),
					'exception_update_reason_id' => (isset($this->data['Equipment']['exception_update_reason_id'])?$this->data['Equipment']['exception_update_reason_id']:0),
				),
			);
			$this->ExceptionUpdate->create();
			$this->ExceptionUpdate->data = $ExceptionUpdateData;
			$this->ExceptionUpdate->save($this->ExceptionUpdate->data);
		}
		return parent::afterSave($created);
	}
	
	public function isOwnedBy($id, $user_id) 
	{
	/*
	 * Checks if a user is the owner of this object
	 * Overrides the one in the AppModel
	 */
		return $this->field('id', array('id' => $id, 'added_user_id' => $user_id)) === $id;
	}
	
	public function batchGetHeaders($data = array())
	{
		if(!isset($data[$this->alias]['csv']))
		{
			$this->invalidate['csv'] = array(_('No CSV data available'));
			return false;
		}
		
		$data[$this->alias]['csv'] = trim($data[$this->alias]['csv']);
		
		$lines = explode("\n", $data[$this->alias]['csv']);
		$_headers = str_getcsv(array_shift($lines));
		$headers = array();
		foreach($_headers as $i => $header)
		{
			$header = trim($header);
			$header_key = strtolower(Inflector::slug($header));
			$header_value = Inflector::humanize($header_key);
			if(!$header_key) unset($headers[$i]);
			$headers[$header_key] = $header_value;
		}
		return $headers;
	}
	
	public function batchMapCsv($data = array(), $header_map = array())
	{
		if(!isset($data[$this->alias]['csv']))
		{
			$this->invalidate['csv'] = array(_('No CSV data available'));
			return false;
		}
		
		$header_map = Set::flatten($header_map);
		$header_map = array_flip($header_map);
		
		$data[$this->alias]['csv'] = trim($data[$this->alias]['csv']);
		
		$lines = explode("\n", $data[$this->alias]['csv']);
		$headers = str_getcsv(array_shift($lines));
		
		// clean up the headers
		foreach($headers as $i => $header)
		{
			$headers[$i] = strtolower(Inflector::slug($header));
		}
		
		$item_map = array();
		$cnt = 0;
		foreach($lines as $line)
		{
			$item = str_getcsv($line);
			foreach($headers as $i => $header)
			{
				if(isset($item[$i]) and trim($item[$i]))
				{
					$item_map[$cnt][$header] = $item[$i];
				}
			}
			$cnt++;
		}
		
		$items = array();
		$cnt = 0;
		foreach($item_map as $item_map_item)
		{
			$item = array();
			foreach($header_map as $theirs => $ours)
			{
				$item[$ours] = '';
				if(isset($item_map_item[$theirs])) $item[$ours] = $item_map_item[$theirs];
			}
			
			if($item)
			{
				$items[$cnt] = $item;
				$cnt++;
			}
		}
		
		$items = Set::flatten($items);
		$items = Hash::expand($items, '.');
		
		foreach($items as $i => $item)
		{
			// clean up the mac address 
			if(isset($item['EquipmentDetail']['mac_address']))
			{
				$item['EquipmentDetail']['mac_address'] = strtoupper($item['EquipmentDetail']['mac_address']);
				$items[$i]['EquipmentDetail']['mac_address'] = preg_replace("/[^a-zA-Z0-9]/", "", $item['EquipmentDetail']['mac_address']);
			}
			
			// check/validate the Operational Devisions
			if(!isset($item['EquipmentDetail']['op_div_other']))
			{
				$items[$i]['EquipmentDetail']['op_div_other'] = '';
			}
			
			if(isset($item['Equipment']['op_div_id']))
			{
				if($op_div_id = $this->OpDiv->nameToID($item['Equipment']['op_div_id']))
				{
					$items[$i]['Equipment']['op_div_id'] = $op_div_id;
				}
				else
				{
					$items[$i]['Equipment']['op_div_id'] = 0;
					$items[$i]['EquipmentDetail']['op_div_other'] = $item['Equipment']['op_div_id'];
				}
			}
		}
		
		return $items;
	}
	
	public function batchSave($data = array(), $data_append = array())
	{
		foreach($data as $i => $item)
		{
			$item = array_merge_recursive($item, $data_append);
			$data[$i] = $item;
			
			if(isset($data[$i]['Equipment']['op_div_id']) and !$data[$i]['Equipment']['op_div_id'])
			{
				$data[$i]['Equipment']['op_div_id'] = 0;
			}
		}
		
		$data_to_save = array();
		$_data = $data;
		$errors = false;
		$return = false;
		
		if($validate = $this->validateMany($_data, array('deep' => 'true')))
		{
			// all were fine
			$data_to_save = $data;
			$return = true;
		}
		else
		{
			// items needs to be fixed
			$data_to_fix = array();
			$errors = $this->validationErrors;
			foreach($errors as $i => $error_data)
			{
				if(isset($data[$i]))
				{
					$data_to_fix[$i] = $data[$i];
					unset($data[$i]);
				}
				$data_to_save = $data;
			}
			$this->batchIssues = count($data_to_fix);
			$this->batchDataToFix = $data_to_fix;
		}
		
		// save the ones that can be saved
		$this->batchSaved = 0;
		foreach($data as $i => $item)
		{
			if($this->saveAssociated($item))
			{
				$this->batchSaved++;
			}
			else
			{
				$this->batchDataToFix[$i] = $item;
				$this->batchIssues++;
				$return = true;
			}
		}
		
		$this->validationErrors = $errors;
		
		return $return;
	}
	
	public function snapshotStats()
	{
		$entities = $this->Snapshot_dynamicEntities();
		return array();
	}
	
}
