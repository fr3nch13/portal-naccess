<?php
App::uses('AppController', 'Controller');
/**
 * OrgGroups Controller
 *
 * @property OrgGroups $OrgGroup
 */
class OrgGroupsController extends AppController 
{

//
	public function admin_index() 
	{
	/**
	 * index method
	 *
	 * Displays all Org Groups
	 */
		$this->Prg->commonProcess();
		
/////////////////////////////
		$conditions = array(
		);
		
		$this->OrgGroup->recursive = -1;
		$this->paginate['order'] = array('OrgGroup.name' => 'asc');
		$this->paginate['conditions'] = $this->OrgGroup->conditions($conditions, $this->passedArgs); 
		$this->set('org_groups', $this->paginate());
	}

//
	public function admin_view($id = 0)
	{
		$this->OrgGroup->recursive = 0;
		$this->set('org_group', $this->OrgGroup->read(null, $id));
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
			$this->OrgGroup->create();
			
			if ($this->OrgGroup->saveAssociated($this->request->data))
			{
				$this->Session->setFlash(__('The Org Group has been saved'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The Org Group could not be saved. Please, try again.'));
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
		$this->OrgGroup->id = $id;
		if (!$this->OrgGroup->exists()) 
		{
			throw new NotFoundException(__('Invalid Org Group'));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->OrgGroup->saveAssociated($this->request->data)) 
			{
				$this->Session->setFlash(__('The Org Group has been saved'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The Org Group could not be saved. Please, try again.'));
			}
		}
		else
		{
			$this->request->data = $this->OrgGroup->read(null, $id);
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
	 
		$this->OrgGroup->id = $id;
		if (!$this->OrgGroup->exists()) 
		{
			throw new NotFoundException(__('Invalid Org Group'));
		}

		if ($this->OrgGroup->delete()) 
		{
			$this->Session->setFlash(__('Org Group deleted'));
			return $this->redirect($this->referer());
		}
		
		$this->Session->setFlash(__('Org Group was not deleted'));
		return $this->redirect($this->referer());
	}
}
