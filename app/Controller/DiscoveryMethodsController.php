<?php
App::uses('AppController', 'Controller');
/**
 * DiscoveryMethods Controller
 *
 * @property DiscoveryMethods $DiscoveryMethod
 */
class DiscoveryMethodsController extends AppController 
{

//
	public function admin_index() 
	{
	/**
	 * index method
	 *
	 * Displays all Discovery Methods
	 */
		$this->Prg->commonProcess();
		
/////////////////////////////
		$conditions = array(
		);
		
		// get the counts
		$this->DiscoveryMethod->getCounts = array(
			'Equipment' => array(
				'all' => array(),
			),
		);
		
		$this->DiscoveryMethod->recursive = -1;
		$this->paginate['order'] = array('DiscoveryMethod.name' => 'asc');
		$this->paginate['conditions'] = $this->DiscoveryMethod->conditions($conditions, $this->passedArgs); 
		$this->set('discovery_methods', $this->paginate());
	}
	
//
	public function admin_view($id = null) 
	{
		$this->DiscoveryMethod->id = $id;
		if (!$this->DiscoveryMethod->exists())
		{
			throw new NotFoundException(__('Invalid Discovery Method'));
		}
		
		// get the counts
		$this->DiscoveryMethod->getCounts = array(
			'Equipment' => array(
				'all' => array(
					'conditions' => array(
						'Equipment.discovery_method_id' => $id,
					),
				),
			),
		);
		
		$this->DiscoveryMethod->recursive = -1;
		$this->set('discovery_method', $this->DiscoveryMethod->read(null, $id));
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
			$this->DiscoveryMethod->create();
			
			if ($this->DiscoveryMethod->saveAssociated($this->request->data))
			{
				$this->Session->setFlash(__('The Discovery Method has been saved'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The Discovery Method could not be saved. Please, try again.'));
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
		$this->DiscoveryMethod->id = $id;
		if (!$this->DiscoveryMethod->exists()) 
		{
			throw new NotFoundException(__('Invalid Discovery Method'));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->DiscoveryMethod->saveAssociated($this->request->data)) 
			{
				$this->Session->setFlash(__('The Discovery Method has been saved'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The Discovery Method could not be saved. Please, try again.'));
			}
		}
		else
		{
			$this->request->data = $this->DiscoveryMethod->read(null, $id);
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
	 
		$this->DiscoveryMethod->id = $id;
		if (!$this->DiscoveryMethod->exists()) 
		{
			throw new NotFoundException(__('Invalid Discovery Method'));
		}

		if ($this->DiscoveryMethod->delete()) 
		{
			$this->Session->setFlash(__('Discovery Method deleted'));
			return $this->redirect($this->referer());
		}
		
		$this->Session->setFlash(__('Discovery Method was not deleted'));
		return $this->redirect($this->referer());
	}
}
