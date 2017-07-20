<?php
App::uses('AppController', 'Controller');
/**
 * EquipmentStatuses Controller
 *
 * @property EquipmentStatuses $EquipmentStatus
 */
class EquipmentStatusesController extends AppController 
{

//
	public function admin_index() 
	{
	/**
	 * index method
	 *
	 * Displays all Equipment Statuses
	 */
		$this->Prg->commonProcess();
		
/////////////////////////////
		$conditions = array(
		);
		
		$this->EquipmentStatus->recursive = -1;
		$this->paginate['order'] = array('EquipmentStatus.name' => 'asc');
		$this->paginate['conditions'] = $this->EquipmentStatus->conditions($conditions, $this->passedArgs); 
		$this->set('equipment_statuses', $this->paginate());
	}
	
	public function admin_add() 
	{
	/**
	 * add method
	 *
	 * @return void
	 */
		if ($this->request->is('post'))
		{
			$this->EquipmentStatus->create();
			
			if ($this->EquipmentStatus->saveAssociated($this->request->data))
			{
				$this->Session->setFlash(__('The Equipment Status has been saved'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The Equipment Status could not be saved. Please, try again.'));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
	/**
	 * edit method
	 *
	 * @param string $id
	 * @return void
	 */
		$this->EquipmentStatus->id = $id;
		if (!$this->EquipmentStatus->exists()) 
		{
			throw new NotFoundException(__('Invalid Equipment Status'));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->EquipmentStatus->saveAssociated($this->request->data)) 
			{
				$this->Session->setFlash(__('The Equipment Status has been saved'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The Equipment Status could not be saved. Please, try again.'));
			}
		}
		else
		{
			$this->request->data = $this->EquipmentStatus->read(null, $id);
		}
	}

//
	public function admin_delete($id = null) 
	{
	/**
	 * delete method
	 *
	 * @param string $id
	 * @return void
	 */
		$this->EquipmentStatus->id = $id;
		if (!$this->EquipmentStatus->exists()) 
		{
			throw new NotFoundException(__('Invalid Equipment Status'));
		}

		if ($this->EquipmentStatus->delete()) 
		{
			$this->Session->setFlash(__('Equipment Status deleted'));
			return $this->redirect($this->referer());
		}
		
		$this->Session->setFlash(__('Equipment Status was not deleted'));
		return $this->redirect($this->referer());
	}
}
