<?php
App::uses('AppModel', 'Model');
/**
 * EquipmentDetail Model
 *
 * @property Equipment $Equipment
 * @property DiscoveryMethod $DiscoveryMethod
 */
class EquipmentDetail extends AppModel {

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
		'discovery_method_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'mac_address' => array(
            'Rule_MacAddress' => array(
            	'rule' => 'Rule_MacAddress',
            	'required'   => true,
            	'allowEmpty' => false,
//				'message'    => 'This must be a unique value, there may already be a record with this MAC address.',
            ),
		),
		'example_ticket' => array(
			'alphaNumeric'   => array(
				'rule'       => 'alphaNumeric',
				'required'   => true,
				'allowEmpty' => false,
				'message'    => 'This field is required, and only allows numbers and letters. (you may have a space at the end of the string).',
            ),
		),
	);
	
	public $belongsTo = array(
		'Equipment' => array(
			'className' => 'Equipment',
			'foreignKey' => 'equipment_id',
		),
	);
	
	public $actsAs = array(
		'Dblogger.Dblogger', // log all changes to the database
	);
	
	public function Rule_MacAddress($check)
	{
		if(!isset($check['mac_address']))
		{
			return __('The MAC Address isn\'t set.');
		}
		
		$mac_address = $check['mac_address'];
		$mac_address = strtoupper(trim($mac_address));
		
		if($mac_address == 'TBD') return true;
		
		// check to make sure it's a mac address using the Extractor Behavior
		$type = $this->EX_discoverType($check['mac_address']);
		if($type != 'mac')
		{
			return __('The given MAC Address isn\'t detected as a valid MAC Address. (0-9, A-F, no : or -)');
		}
		
		// check to make sure it's unique
		if($exists = $this->findByMacAddress($mac_address))
		{
			if($this->id and $exists[$this->alias]['id'] == $this->id)
				return true;
			return __('This must be a unique value, there is already be a record with this MAC Address.');
		}
		
		
		return true;
	}
}
