<?php
App::uses('AppController', 'Controller');
/**
 * ExceptionUpdateReasons Controller
 *
 * @property ExceptionUpdateReasons $ExceptionUpdateReason
 */
class ExceptionUpdateReasonsController extends AppController 
{

//
	public function admin_index() 
	{
	/**
	 * index method
	 *
	 * Displays all Exception Update Reasons
	 */
		$this->Prg->commonProcess();
		
/////////////////////////////
		$conditions = array(
		);
		
		$this->ExceptionUpdateReason->recursive = -1;
		$this->paginate['order'] = array('ExceptionUpdateReason.name' => 'asc');
		$this->paginate['conditions'] = $this->ExceptionUpdateReason->conditions($conditions, $this->passedArgs); 
		$this->set('exception_update_reasons', $this->paginate());
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
			$this->ExceptionUpdateReason->create();
			
			if ($this->ExceptionUpdateReason->saveAssociated($this->request->data))
			{
				$this->Session->setFlash(__('The Exception Update Reason has been saved'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The Exception Update Reason could not be saved. Please, try again.'));
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
		$this->ExceptionUpdateReason->id = $id;
		if (!$this->ExceptionUpdateReason->exists()) 
		{
			throw new NotFoundException(__('Invalid Exception Update Reason'));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->ExceptionUpdateReason->saveAssociated($this->request->data)) 
			{
				$this->Session->setFlash(__('The Exception Update Reason has been saved'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The Exception Update Reason could not be saved. Please, try again.'));
			}
		}
		else
		{
			$this->request->data = $this->ExceptionUpdateReason->read(null, $id);
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
	 
		$this->ExceptionUpdateReason->id = $id;
		if (!$this->ExceptionUpdateReason->exists()) 
		{
			throw new NotFoundException(__('Invalid Exception Update Reason'));
		}

		if ($this->ExceptionUpdateReason->delete()) 
		{
			$this->Session->setFlash(__('Exception Update Reason deleted'));
			return $this->redirect($this->referer());
		}
		
		$this->Session->setFlash(__('Exception Update Reason was not deleted'));
		return $this->redirect($this->referer());
	}
}
