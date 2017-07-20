<?php
App::uses('AppController', 'Controller');
/**
 * OpDivs Controller
 *
 * @property OpDivs $OpDiv
 */
class OpDivsController extends AppController 
{

//
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->OpDiv->recursive = -1;
		$this->paginate['order'] = array('OpDiv.name' => 'asc');
		$this->paginate['conditions'] = $this->OpDiv->conditions($conditions, $this->passedArgs); 
		$this->set('op_divs', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->OpDiv->create();
			
			if ($this->OpDiv->saveAssociated($this->request->data))
			{
				$this->Session->setFlash(__('The %s has been saved', __('OPDIV/IC')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('OPDIV/IC')));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		$this->OpDiv->id = $id;
		if (!$this->OpDiv->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('OPDIV/IC')));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->OpDiv->saveAssociated($this->request->data)) 
			{
				$this->Session->setFlash(__('The %s has been saved', __('OPDIV/IC')));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.', __('OPDIV/IC')));
			}
		}
		else
		{
			$this->request->data = $this->OpDiv->read(null, $id);
		}
	}

//
	public function admin_delete($id = null) 
	{
	 
		$this->OpDiv->id = $id;
		if (!$this->OpDiv->exists()) 
		{
			throw new NotFoundException(__('Invalid %s', __('OPDIV/IC')));
		}

		if ($this->OpDiv->delete()) 
		{
			$this->Session->setFlash(__('%s deleted', __('OPDIV/IC')));
			return $this->redirect($this->referer());
		}
		
		$this->Session->setFlash(__('%s was not deleted', __('OPDIV/IC')));
		return $this->redirect($this->referer());
	}
}
