<?php
App::uses('AppController', 'Controller');
/**
 * Equipment Controller
 *
 * @property Equipment $Equipment
 */
class EquipmentController extends AppController 
{

	public function isAuthorized($user = array())
	{
		// All registered users can add and view equipment
		if (in_array($this->action, array('add', 'view', 'edit'))) 
		{
			return true;
		}
		
		// only the reviewer can change the state and delete
		if (in_array($this->action, array('toggle', 'edit_state', 'delete'))) 
		{
			if(in_array(AuthComponent::user('role'), array('admin', 'reviewer')))
			{
				return true;
			}
		}

		return parent::isAuthorized($user);
	}
	
	public function db_block_overview()
	{
		$_equipment = $this->Equipment->find('all');
		$this->set(compact('_equipment'));
	}
	
	public function db_block_statuses()
	{
		$equipmentStatuses = $this->Equipment->EquipmentStatus->find('list');
		$_equipment = $this->Equipment->find('all', array(
			'contain' => array('EquipmentStatus'),
		));
		$this->set(compact('_equipment', 'equipmentStatuses'));
	}
	
	public function db_block_types()
	{
		$equipmentTypes = $this->Equipment->EquipmentType->find('list');
		$_equipment = $this->Equipment->find('all', array(
			'contain' => array('EquipmentType'),
		));
		$this->set(compact('_equipment', 'equipmentTypes'));
	}
	
	public function db_block_discovery_methods()
	{
		$discoveryMethods = $this->Equipment->DiscoveryMethod->find('list');
		$_equipment = $this->Equipment->find('all', array(
			'contain' => array('DiscoveryMethod'),
		));
		$this->set(compact('_equipment', 'discoveryMethods'));
	}
	
	public function naccess($id = false)
	{
		// redirect to take care of the /naccess/naccess issue
		return $this->redirect(array('action' => 'index', $id));
	}

	public function index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array();
		if(AuthComponent::user('role') != 'admin')
		{
			$conditions['Equipment.org_group_id'] = AuthComponent::user('org_group_id');
		}
		
		$this->Equipment->recursive = 0;
		$this->Equipment->getLatestUpload = true;
//		$this->Equipment->contain('EquipmentVerifiedUser', 'EquipmentType');
		$this->paginate['order'] = array('Equipment.created' => 'desc');
		$this->paginate['conditions'] = $this->Equipment->conditions($conditions, $this->passedArgs); 
		$this->set('_equipment', $this->paginate());
	}

	public function review_state($review_state_id = null) 
	{
		$conditions = array();
		
		if($review_state_id)
		{
			$conditions['Equipment.review_state_id'] = $review_state_id;
		}
		else
		{
			$conditions['ReviewState.default'] = true;
		}
		
		if(AuthComponent::user('role') != 'admin')
		{
			$conditions['Equipment.org_group_id'] = AuthComponent::user('org_group_id');
		}
		
		$this->Equipment->recursive = 0;
		
		if ($this->request->is('requested')) 
		{
			$_equipment = $this->Equipment->find('all', array(
				'recursive' => 0,
				'conditions' => $conditions,
				'contain' => array('EquipmentDetail', 'ReviewState'),
			));
			
			// format for the menu_items
			$items = array();
			
			foreach($_equipment as $equipment)
			{
				$title = $equipment['Equipment']['id']. '-';
				
				$items[] = array(
					'title' => $equipment['Equipment']['id']. 
						' : '. (trim($equipment['EquipmentDetail']['asset_tag'])?$equipment['EquipmentDetail']['asset_tag']:__('(Empty)')). 
						' : '. (trim($equipment['EquipmentDetail']['example_ticket'])?$equipment['EquipmentDetail']['example_ticket']:__('(Empty)')). 
						' : '. (trim($equipment['EquipmentDetail']['mac_address'])?$equipment['EquipmentDetail']['mac_address']:__('(Empty)')),
					'url' => array('controller' => 'equipment', 'action' => 'view', $equipment['Equipment']['id'], 'admin' => false, 'plugin' => false)
				);
			}
			return $items;
		}
		else
		{
			$this->Prg->commonProcess();
			$this->Equipment->getLatestUpload = true;
			$this->paginate['order'] = array('Equipment.created' => 'desc');
			$this->paginate['conditions'] = $this->Equipment->conditions($conditions, $this->passedArgs); 
			$this->set('_equipment', $this->paginate());
			
			$this->set('review_state', $this->Equipment->ReviewState->read(null, $review_state_id));
		}
	}
	
	public function view($id = null) 
	{
		$this->Equipment->id = $id;
		if (!$this->Equipment->exists())
		{
			throw new NotFoundException(__('Invalid Equipment'));
		}
		
		// get the counts
		$this->Equipment->getCounts = array(
			'Upload' => array(
				'all' => array(
					'conditions' => array(
						'Upload.equipment_id' => $id,
					),
				),
			),
			'ExceptionUpdate' => array(
				'all' => array(
					'conditions' => array(
						'ExceptionUpdate.equipment_id' => $id,
					),
				),
			),
		);
		
		$this->Equipment->recursive = 1;
		$this->Equipment->contain(array('EquipmentDetail', 'EquipmentAddedUser', 'EquipmentModifiedUser', 'EquipmentStatus', 'EquipmentVerifiedUser', 'DiscoveryMethod', 'EquipmentType', 'OrgGroup', 'ReviewState', 'OpDiv')); // , 'VerifiedOrg'
		$this->set('equipment', $this->Equipment->read(null, $id));
	}

	public function add() 
	{
		if ($this->request->is('post'))
		{
			$this->Equipment->create();
			$this->request->data['Equipment']['added_user_id'] = AuthComponent::user('id');
			$this->request->data['Equipment']['org_group_id'] = AuthComponent::user('org_group_id');
			$this->request->data['Equipment']['review_state_id'] = $this->Equipment->ReviewState->defaultId();
			
			if ($this->Equipment->saveAssociated($this->request->data, array('validate' => 'first')))
			{
				$redirect = array('action' => 'view', $this->Equipment->id);
				if($this->Equipment->saveRedirect)
				{
					$redirect = $this->Equipment->saveRedirect;
				}
				$this->Session->setFlash(__('The Equipment has been saved'));
				return $this->redirect($redirect);
			}
			else
			{
				$this->Session->setFlash(__('The Equipment could not be saved. Please, try again.'));
			}
		}
		
		// get the equipment types
		$this->set('equipment_types', $this->Equipment->EquipmentType->find('list', array('order' => 'EquipmentType.name')));
		
		// get the opdiv
		$this->set('op_divs', $this->Equipment->OpDiv->find('list', array('order' => 'OpDiv.name')));
	}

	public function batch_add() 
	{
		if ($this->request->is('post'))
		{	
			if ($headers = $this->Equipment->batchGetHeaders($this->request->data))
			{
				$this->Session->write('Csv.headers', $headers);
				$this->Session->write('Csv.data', $this->request->data);
				$this->bypassReferer = true;
				return $this->redirect(array('action' => 'batch_review_headers'));
			}
			else
			{
				$this->Session->setFlash(__('The Equipment could not be saved. Please, try again.'));
			}
		}
		
		$this->request->data = $this->Session->read('Csv.data');
	}
	
	public function batch_review_headers() 
	{
		if ($this->request->is('post'))
		{
			$this->Session->write('Csv.header_map', $this->request->data);
			$this->bypassReferer = true;
			return $this->redirect(array('action' => 'batch_review_data'));
		}
		
		// verify the session headers were extracted
		if(!$headers = $this->Session->read('Csv.headers'))
		{
			$this->Session->setFlash(__('Unable to detect the headers from the CSV data.'));
			$this->bypassReferer = true;
			return $this->redirect(array('action' => 'batch_add'));
		}
		
		$this->set('headers', $headers);
		$this->set('csv_field_map', $this->Equipment->csv_field_map);
	}
	
	public function batch_review_data() 
	{
		// verify the session headers were extracted
		if(!$header_map = $this->Session->read('Csv.header_map'))
		{
			$this->Session->setFlash(__('Unable to detect the headers from the CSV data.'));
			$this->bypassReferer = true;
			return $this->redirect(array('action' => 'batch_add'));
		}
			
		if ($this->request->is('post'))
		{
			$data_append = array();
			$data_append['Equipment']['added_user_id'] = AuthComponent::user('id');
			$data_append['Equipment']['org_group_id'] = AuthComponent::user('org_group_id');
			$data_append['Equipment']['review_state_id'] = $this->Equipment->ReviewState->defaultId();
			
			if ($this->Equipment->batchSave($this->request->data, $data_append))
			{
				// clear the session
				$this->Session->delete('Csv');
				$this->Session->setFlash(__('The CSV Items been saved to Naccess'));
				$this->bypassReferer = true;
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->request->data = $this->Equipment->batchDataToFix;
				// update the session
				
				$this->Session->setFlash(__('Errors occurred. %s CSV Items Saved, %s CSV Items Needs Attention.', $this->Equipment->batchSaved, $this->Equipment->batchIssues));
			}
		}
		else
		{
			$this->request->data = $this->Equipment->batchMapCsv($this->Session->read('Csv.data'), $header_map);
			$validate_data = $this->request->data;
			$validate = $this->Equipment->validateMany($validate_data, array('deep' => 'true'));
		}
		
		// get the equipment types
		$this->set('equipment_types', $this->Equipment->EquipmentType->find('list', array('order' => 'EquipmentType.name')));
		
		// get the opdiv
		$this->set('op_divs', $this->Equipment->OpDiv->find('list', array('order' => 'OpDiv.name')));
	}

	public function edit($id = null) 
	{
		$this->Equipment->id = $id;
		if (!$this->Equipment->exists())
		{
			throw new NotFoundException(__('Invalid Equipment'));
		}
		if ($this->request->is('post') || $this->request->is('put'))
		{
			$this->request->data['Equipment']['modified_user_id'] = AuthComponent::user('id');

			if ($this->Equipment->saveAssociated($this->request->data))
			{
				$this->Session->setFlash(__('The Equipment has been updated'));
				return $this->redirect(array('action' => 'view', $this->Equipment->id));
			}
			else
			{
				$this->Session->setFlash(__('The Equipment could not be saved. Please, try again.'));
			}
		}
		else
		{
			$this->Equipment->recursive = 1;
			$this->Equipment->contain(array('EquipmentDetail', 'EquipmentAddedUser', 'EquipmentStatus', 'EquipmentVerifiedUser', 'DiscoveryMethod', 'EquipmentType')); // , 'VerifiedOrg'
			$this->request->data = $this->Equipment->read(null, $this->Equipment->id);
		}
		
		// get the users
		$this->set('users', $this->Equipment->EquipmentVerifiedUser->typeFormList(AuthComponent::user('org_group_id'), false));
		// get the equipment types
		$this->set('equipment_types', $this->Equipment->EquipmentType->typeFormList());
		// get the equipment statuses
		$this->set('equipment_statuses', $this->Equipment->EquipmentStatus->typeFormList());
		// get the verified_orgs
		$this->set('verified_orgs', $this->Equipment->VerifiedOrg->typeFormList());
		// get the discovery_methods
		$this->set('discovery_methods', $this->Equipment->DiscoveryMethod->typeFormList());
		// get the exception_update_reasons
		$this->set('exception_update_reasons', $this->Equipment->ExceptionUpdate->ExceptionUpdateReason->typeFormList());
		// get the org_groups
		$this->set('org_groups', $this->Equipment->OrgGroup->typeFormList());
		
		// get the opdiv
		$this->set('op_divs', $this->Equipment->OpDiv->find('list', array('order' => 'OpDiv.name')));
	}

	public function edit_state($id = null) 
	{
		$this->Equipment->id = $id;
		if (!$this->Equipment->exists())
		{
			throw new NotFoundException(__('Invalid Equipment'));
		}
		
		if ($this->request->is('post'))
		{
			$this->request->data['Equipment']['modified_user_id'] = AuthComponent::user('id');
			
			if ($this->Equipment->saveAssociated($this->request->data))
			{
				$this->Session->setFlash(__('The Equipment has been updated'));
				return $this->redirect(array('action' => 'view', $this->Equipment->id));
			}
			else
			{
				$this->Session->setFlash(__('The Equipment could not be saved. Please, try again.'));
			}
		}
		else
		{
			$this->request->data = $this->Equipment->read(null, $this->Equipment->id);
		}
		
		$this->set('review_states', $this->Equipment->ReviewState->find('list', array('order' => array('ReviewState.default' => 'desc', 'ReviewState.name' => 'asc')) ));
	}
	
	public function multiselect()
	{
	/*
	 * batch manage multiple items
	 */
		if (!$this->request->is('post'))
		{
			throw new MethodNotAllowedException();
		}
		
		if(!isset($this->request->data['Equipment']['multiselect_option']))
		{
			$this->Session->setFlash(__('The Equipments were NOT updated.'));
			return $this->redirect($this->referer());
		}
		
		if(!$this->request->data['Equipment']['multiselect_option'])
		{
			$this->Session->setFlash(__('The Equipments were NOT updated.'));
			return $this->redirect($this->referer());
		}
		
		$this->Session->write('Multiselect.Equipment', $this->request->data);
		
		// forward to a page where the user can choose a value
		$redirect = false;
		switch ($this->request->data['Equipment']['multiselect_option']) 
		{
			case 'review_state':
				$redirect = array('action' => 'multiselect_review_state');
				break;
			case 'equipment_status':
				$redirect = array('action' => 'multiselect_equipment_status');
				break;
			case 'op_div':
				$redirect = array('action' => 'multiselect_op_div');
				break;
		}
		
		if($redirect)
		{
			return $this->redirect($redirect);
		}
		
		$this->Session->setFlash(__('The Equipments were NOT updated.'));
		return $this->redirect($this->referer());
	}
	
	public function multiselect_review_state()
	{
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			$sessionData = $this->Session->read('Multiselect.Equipment');
			
			if($this->Equipment->multiselect($sessionData, $this->request->data, AuthComponent::user('id'))) 
			{
				$this->Session->delete('Multiselect.Equipment');
				$this->Session->setFlash(__('The Equipments were updated.'));
				return $this->redirect($this->Equipment->multiselectReferer());
			}
			else
			{
				$this->Session->setFlash(__('The Equipments were NOT updated.'));
			}
		}
		
		// get the object types
		$this->set('review_states', $this->Equipment->ReviewState->typeFormList());
	}
	
	public function multiselect_equipment_status()
	{
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			$sessionData = $this->Session->read('Multiselect.Equipment');
			
			if($this->Equipment->multiselect($sessionData, $this->request->data, AuthComponent::user('id'))) 
			{
				$this->Session->delete('Multiselect.Equipment');
				$this->Session->setFlash(__('The Equipments were updated.'));
				return $this->redirect($this->Equipment->multiselectReferer());
			}
			else
			{
				$this->Session->setFlash(__('The Equipments were NOT updated.'));
			}
		}
		
		// get the object types
		$this->set('equipment_statuses', $this->Equipment->EquipmentStatus->typeFormList());
	}
	
	public function multiselect_op_div()
	{
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			$sessionData = $this->Session->read('Multiselect.Equipment');
			
			if($this->Equipment->multiselect($sessionData, $this->request->data, AuthComponent::user('id')))
			{
				$this->Session->delete('Multiselect.Equipment');
				$this->Session->setFlash(__('The Equipments were updated.'));
				return $this->redirect($this->Equipment->multiselectReferer());
			}
			else
			{
				$this->Session->setFlash(__('The Equipments were NOT updated.'));
			}
		}
		
		// get the object types
		$this->set('op_divs', $this->Equipment->OpDiv->typeFormList());
	}
	
	public function validate_example()
	{
	/*
	 * Used to validate the example field
	 */
		$this->autoRender = FALSE;
		if($this->RequestHandler->isAjax())
		{
			$example_ticket = (isset($this->request->data['value'])?$this->request->data['value']:false);
			
			$id = false;
			if($example_ticket)
			{
				$equipment = $this->Equipment->find('first', array(
					'conditions' => array(
						'EquipmentDetail.example_ticket' => $example_ticket,
					),
					'recursive' => 0,
				));
			}
			if($equipment)
			{
				$this->autoRender = true;
				$this->layout = false;
				$this->set('equipment', $equipment);
			}

	   }
	}
	
	public function validate_mac()
	{
	/*
	 * Used to validate the mac address field
	 */
		$this->layout = false;
		if($this->RequestHandler->isAjax())
		{
			$mac_address = (isset($this->request->data['value'])?$this->request->data['value']:false);
			$mac_address = strtoupper($mac_address);
			$mac_address = preg_replace("/[^a-zA-Z0-9]/", "", $mac_address);
			
			if($mac_address == 'TBD')
			{
				$this->set('success', true);
				$this->set('mac_address', $mac_address);
				return $this->render();
			}
			
			$success = true;
			
			if(!$mac_address)
			{
				$this->set('success', $success);
				$this->set('message', __('Invalid MAC Address.'));
				$this->set('mac_address', $mac_address);
				return $this->render();
			}
			
			// see if it validates
			if(isset($this->request->data['id']))
			{
				$this->Equipment->EquipmentDetail->id = $this->request->data['id'];
			}
			$this->Equipment->EquipmentDetail->set(array(
				'mac_address' => $mac_address,
			));
			$this->Equipment->EquipmentDetail->validator()->remove('example_ticket');
			
			// this also checks the database to make sure it is unique
			if ($this->Equipment->EquipmentDetail->validates()) 
			{
				$success = true;
				$message = __('This Mac is valid and allowed.');
			}
			else
			{
				$success = false;
				$message = $this->Equipment->EquipmentDetail->validationErrors;
			}
			
			$this->set('success', $success);
			$this->set('mac_address', $mac_address);
			$this->set('message', $message);
			return $this->render();
	   }
	}
	
	public function toggle($field = null, $id = null)
	{
		if ($this->Equipment->toggleRecord($id, $field))
		{
			$this->Session->setFlash(__('The Equipment has been updated.'));
		}
		else
		{
			$this->Session->setFlash($this->Equipment->modelError);
		}
		
		return $this->redirect($this->referer());
	}

	public function admin_group($org_group_id = 0)
	{
		$this->Prg->commonProcess();
		
		$conditions = array('Equipment.org_group_id' => $org_group_id);
		
		$this->Equipment->recursive = 0;
		$this->paginate['order'] = array('Equipment.created' => 'asc');
		$this->paginate['conditions'] = $this->Equipment->conditions($conditions, $this->passedArgs); 
		$this->set('_equipment', $this->paginate());
		
		$this->set('org_group', $this->Equipment->OrgGroup->read(null, $org_group_id));
	}

	public function admin_discovery_method($discovery_method_id = null) 
	{
		$this->Equipment->DiscoveryMethod->id = $discovery_method_id;
		if (!$this->Equipment->DiscoveryMethod->exists())
		{
			throw new NotFoundException(__('Invalid Discovery Method'));
		}
		
		$conditions = array(
			'Equipment.discovery_method_id' => $discovery_method_id,
		);
		
		$this->Equipment->recursive = 0;
		
		$this->Prg->commonProcess();
		$this->Equipment->getLatestUpload = true;
		$this->paginate['order'] = array('Equipment.created' => 'desc');
		$this->paginate['conditions'] = $this->Equipment->conditions($conditions, $this->passedArgs); 
		$this->set('_equipment', $this->paginate());
		
		$this->set('discovery_method', $this->Equipment->DiscoveryMethod->read(null, $discovery_method_id));
	}

	public function admin_delete($id = null) 
	{
		$this->Equipment->id = $id;
		if (!$this->Equipment->exists()) 
		{
			throw new NotFoundException(__('Invalid Equipment'));
		}

		if ($this->Equipment->delete()) 
		{
			$this->Session->setFlash(__('Equipment deleted'));
			return $this->redirect(array('controller' => 'equipment', 'action' => 'index', 'admin' => false));
		}
		
		$this->Session->setFlash(__('Equipment was not deleted'));
		return $this->redirect($this->referer());
	}
}