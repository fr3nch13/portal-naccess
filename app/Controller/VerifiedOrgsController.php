<?php
App::uses('AppController', 'Controller');
/**
 * VerifiedOrgs Controller
 *
 * @property VerifiedOrgs $VerifiedOrg
 */
class VerifiedOrgsController extends AppController 
{

//
	public function admin_index() 
	{
	/**
	 * index method
	 *
	 * Displays all Verified Orgs
	 */
		$this->Prg->commonProcess();
		
/////////////////////////////
		$conditions = array(
		);
		
		$this->VerifiedOrg->recursive = -1;
		$this->paginate['order'] = array('VerifiedOrg.name' => 'asc');
		$this->paginate['conditions'] = $this->VerifiedOrg->conditions($conditions, $this->passedArgs); 
		$this->set('verified_orgs', $this->paginate());
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
			$this->VerifiedOrg->create();
			
			if ($this->VerifiedOrg->saveAssociated($this->request->data))
			{
				$this->Session->setFlash(__('The Verified Org has been saved'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The Verified Org could not be saved. Please, try again.'));
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
		$this->VerifiedOrg->id = $id;
		if (!$this->VerifiedOrg->exists()) 
		{
			throw new NotFoundException(__('Invalid Verified Org'));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->VerifiedOrg->saveAssociated($this->request->data)) 
			{
				$this->Session->setFlash(__('The Verified Org has been saved'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The Verified Org could not be saved. Please, try again.'));
			}
		}
		else
		{
			$this->request->data = $this->VerifiedOrg->read(null, $id);
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
	 
		$this->VerifiedOrg->id = $id;
		if (!$this->VerifiedOrg->exists()) 
		{
			throw new NotFoundException(__('Invalid Verified Org'));
		}

		if ($this->VerifiedOrg->delete()) 
		{
			$this->Session->setFlash(__('Verified Org deleted'));
			return $this->redirect($this->referer());
		}
		
		$this->Session->setFlash(__('Verified Org was not deleted'));
		return $this->redirect($this->referer());
	}
}
