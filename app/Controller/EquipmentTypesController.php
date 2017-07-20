<?php
App::uses('AppController', 'Controller');
/**
 * EquipmentTypes Controller
 *
 * @property EquipmentTypes $EquipmentType
 */
class EquipmentTypesController extends AppController 
{
	public function equipment($equipment_id = null) 
	{
	/**
	 * index method
	 *
	 * Displays all Equipment Types
	 */
		$this->EquipmentType->Equipment->id = $equipment_id;
		if (!$this->EquipmentType->Equipment->exists())
		{
			throw new NotFoundException(__('Invalid Equipment'));
		}
		$this->Prg->commonProcess();
		
/////////////////////////////
		$conditions = array('EquipmentEquipmentType.equipment_id' => $equipment_id);
		
		$this->EquipmentType->EquipmentEquipmentType->recursive = 0;
		$this->paginate['order'] = array('EquipmentType.name' => 'asc');
		$this->paginate['conditions'] = $this->EquipmentType->EquipmentEquipmentType->conditions($conditions, $this->passedArgs); 
		$this->set('equipment_equipment_types', $this->paginate());
	}

//
	public function admin_index() 
	{
	/**
	 * index method
	 *
	 * Displays all Equipment Types
	 */
		$this->Prg->commonProcess();
		
/////////////////////////////
		$conditions = array(
		);
		
		$this->EquipmentType->recursive = -1;
		$this->paginate['order'] = array('EquipmentType.name' => 'asc');
		$this->paginate['conditions'] = $this->EquipmentType->conditions($conditions, $this->passedArgs); 
		$this->set('equipment_types', $this->paginate());
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
			$this->EquipmentType->create();
			
			if ($this->EquipmentType->saveAssociated($this->request->data))
			{
				$this->Session->setFlash(__('The Equipment Type has been saved'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The Equipment Type could not be saved. Please, try again.'));
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
		$this->EquipmentType->id = $id;
		if (!$this->EquipmentType->exists()) 
		{
			throw new NotFoundException(__('Invalid Equipment Type'));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->EquipmentType->saveAssociated($this->request->data)) 
			{
				$this->Session->setFlash(__('The Equipment Type has been saved'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The Equipment Type could not be saved. Please, try again.'));
			}
		}
		else
		{
			$this->request->data = $this->EquipmentType->read(null, $id);
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
	 
		$this->EquipmentType->id = $id;
		if (!$this->EquipmentType->exists()) 
		{
			throw new NotFoundException(__('Invalid Equipment Type'));
		}

		if ($this->EquipmentType->delete()) 
		{
			$this->Session->setFlash(__('Equipment Type deleted'));
			return $this->redirect($this->referer());
		}
		
		$this->Session->setFlash(__('Equipment Type was not deleted'));
		return $this->redirect($this->referer());
	}
}
