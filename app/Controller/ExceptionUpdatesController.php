<?php
App::uses('AppController', 'Controller');
/**
 * ExceptionUpdates Controller
 *
 * @property ExceptionUpdates $ExceptionUpdate
 */
class ExceptionUpdatesController extends AppController 
{
	public function equipment($equipment_id = false) 
	{
	/**
	 * index method
	 *
	 * Displays all Exception Updates
	 */
		$this->Prg->commonProcess();
		
/////////////////////////////
		$conditions = array(
			'ExceptionUpdate.equipment_id' => $equipment_id,
		);
		
//		$this->ExceptionUpdate->clearCache();
		$this->ExceptionUpdate->recursive = 0;
		$this->ExceptionUpdate->contain('ExceptionUpdateAddedUser', 'ExceptionUpdateReleasedUser', 'ExceptionUpdateVerifiedUser', 'ExceptionUpdateReason', 'Upload');
		$this->paginate['order'] = array('ExceptionUpdate.created' => 'desc');
		$this->paginate['conditions'] = $this->ExceptionUpdate->conditions($conditions, $this->passedArgs); 
		$this->set('exception_updates', $this->paginate());
	}
	
	public function add($equipment_id = false) 
	{
	/**
	 * add method
	 *
	 * @return void
	 */
		if ($this->request->is('post'))
		{
			$this->ExceptionUpdate->create();
			// track who added the chain of custody
			$this->request->data['ExceptionUpdate']['added_user_id'] = AuthComponent::user('id');
			// track on the equipment who 'modified' the equipment, by adding this coc
			$this->request->data['Equipment']['modified_user_id'] = AuthComponent::user('id');
			
			if ($this->ExceptionUpdate->saveAssociated($this->request->data))
			{
				$redirect = array('controller' => 'equipment', 'action' => 'index');
				if(isset($this->request->data['ExceptionUpdate']['equipment_id']))
				{
					$redirect = array('controller' => 'equipment', 'action' => 'view', $this->request->data['ExceptionUpdate']['equipment_id']);					
				}
				
				$this->Session->setFlash(__('The Exception Update has been saved'));
				return $this->redirect($redirect);
			}
			else
			{
				$this->Session->setFlash(__('The Exception Update could not be saved. Please, try again.'));
			}
	 
	 		$equipment = $this->ExceptionUpdate->Equipment->find('first', array(
				'conditions' => array('Equipment.id' => $equipment_id),
				'recursive' => 0,
				'contain' => array('EquipmentDetail'),
			));
			
			$last_chain = $this->ExceptionUpdate->find('first', array(
				'conditions' => array('ExceptionUpdate.equipment_id' => $equipment_id),
				'order' => array('ExceptionUpdate.created' => 'desc'),
			));
		}
		else
		{
			if (!$equipment_id) 
			{
				throw new NotFoundException(__('Invalid Equipment'));
			}
			
			$this->ExceptionUpdate->Equipment->id = $equipment_id;
			if (!$this->ExceptionUpdate->Equipment->exists()) 
			{
				throw new NotFoundException(__('Invalid Equipment'));
			}
	 
	 		$equipment = $this->ExceptionUpdate->Equipment->find('first', array(
				'conditions' => array('Equipment.id' => $equipment_id),
				'recursive' => 0,
				'contain' => array('EquipmentDetail'),
			));
			
			$last_chain = $this->ExceptionUpdate->find('first', array(
				'conditions' => array('ExceptionUpdate.equipment_id' => $equipment_id),
				'order' => array('ExceptionUpdate.created' => 'desc'),
			));
			
			$this->request->data = array(
				'ExceptionUpdate' => array(
					'equipment_id' => $equipment_id,
					'released_user_id' => (isset($last_chain['ExceptionUpdate']['verified_user_id'])?$last_chain['ExceptionUpdate']['verified_user_id']:0),
					'released_user_other' => (isset($last_chain['ExceptionUpdate']['verified_user_other'])?$last_chain['ExceptionUpdate']['verified_user_other']:''),
					'verified_user_id' => AuthComponent::user('id'),
				),
				'Upload' => array('equipment_id' => $equipment_id),
				'Equipment' => array('id' => $equipment_id, 'equipment_status_id' => $equipment['Equipment']['equipment_status_id']),
			);
		}
		
		// get the equipment
		$this->set('equipment', $equipment);
			
		$this->set('last_chain', $last_chain);
		
		// get the obtain_reasons
		$this->set('exception_update_reasons', $this->ExceptionUpdate->ExceptionUpdateReason->find('list', array('order' => 'ExceptionUpdateReason.name')));
		
		// get a list of users
		$this->set('users', $this->ExceptionUpdate->ExceptionUpdateReleasedUser->find('list', array('order' => 'ExceptionUpdateReleasedUser.name')));
		
		// get the equipment statuses
		$this->set('equipment_statuses', $this->ExceptionUpdate->Equipment->EquipmentStatus->find('list', array('order' => 'EquipmentStatus.name')));
	}

//
	public function delete($id = null) 
	{
	/**
	 * delete method
	 *
	 * @param string $id
	 * @return void
	 */
		$this->ExceptionUpdate->id = $id;
		if (!$this->ExceptionUpdate->exists()) 
		{
			throw new NotFoundException(__('Invalid Exception Update'));
		}

		if ($this->ExceptionUpdate->delete()) 
		{
			$this->Session->setFlash(__('Exception Update deleted'));
			return $this->redirect($this->referer());
		}
		
		$this->Session->setFlash(__('Exception Update was not deleted'));
		return $this->redirect($this->referer());
	}
}