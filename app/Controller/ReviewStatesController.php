<?php
App::uses('AppController', 'Controller');
/**
 * ReviewStates Controller
 *
 * @property ReviewStates $ReviewStates
 */
class ReviewStatesController extends AppController 
{
//
	public function index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array();
		$order = array('ReviewState.default' => 'desc', 'ReviewState.name' => 'asc');
		
		if ($this->request->is('requested')) 
		{
			$review_states = $this->ReviewState->find('all', array(
				'order' => $order,
			));
			
			// format for the menu_items
			$items = array();
			
			$items[] = array(
				'title' => __('All'),
				'url' => array('controller' => 'equipment', 'action' => 'index', 'admin' => false, 'plugin' => false)
			);
				
			foreach($review_states as $review_state)
			{
				$title = $review_state['ReviewState']['name'];
				
				if($review_state['ReviewState']['default'])
				{
//					$title = '- '. $title;
				}
				
				$items[] = array(
					'title' => $title,
					'url' => array('controller' => 'equipment', 'action' => 'review_state', $review_state['ReviewState']['id'], 'admin' => false, 'plugin' => false)
				);
			}
			return $items;
		}
		else
		{
			$this->ReviewState->recursive = 0;
			$this->paginate['order'] = $order;
			$this->paginate['conditions'] = $this->ReviewState->conditions($conditions, $this->passedArgs); 
			$this->set('review_states', $this->paginate());
		}
	}
	
	public function defaultname()
	{
		if ($this->request->is('requested')) 
		{
			return $this->ReviewState->field('name', array('default' => true));
		}
	}
	
//
	public function admin_index() 
	{
		$this->Prg->commonProcess();
		
		$conditions = array(
		);
		
		$this->ReviewState->recursive = -1;
		$this->paginate['order'] = array('ReviewState.name' => 'asc');
		$this->paginate['conditions'] = $this->ReviewState->conditions($conditions, $this->passedArgs); 
		$this->set('review_states', $this->paginate());
	}
	
	public function admin_add() 
	{
		if ($this->request->is('post'))
		{
			$this->ReviewState->create();
			
			if ($this->ReviewState->saveAssociated($this->request->data))
			{
				$this->Session->setFlash(__('The Review State has been saved'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The Review State could not be saved. Please, try again.'));
			}
		}
	}
	
	public function admin_edit($id = null) 
	{
		$this->ReviewState->id = $id;
		if (!$this->ReviewState->exists()) 
		{
			throw new NotFoundException(__('Invalid Review State'));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->ReviewState->saveAssociated($this->request->data)) 
			{
				$this->Session->setFlash(__('The Review State has been saved'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('The Review State could not be saved. Please, try again.'));
			}
		}
		else
		{
			$this->request->data = $this->ReviewState->read(null, $id);
		}
	}

//
	public function admin_default($id = null) 
	{
		$this->ReviewState->id = $id;
		if (!$this->ReviewState->exists()) 
		{
			throw new NotFoundException(__('Invalid Review State'));
		}
		
		// mark all as 0
		if(!$this->ReviewState->updateAll(array('ReviewState.default' => false), array('ReviewState.default' => true)))
		{
			$this->Session->setFlash(__('Unable to set the default.'));
			return $this->redirect($this->referer());
		}
		
		$this->ReviewState->id = $id;
		if ($this->ReviewState->saveField('default', true)) 
		{
			$this->Session->setFlash(__('Default Review State changes.'));
			return $this->redirect($this->referer());
		}
		
		$this->Session->setFlash(__('Unable to set the default.'));
		return $this->redirect($this->referer());
	}

//
	public function admin_delete($id = null) 
	{
		$this->ReviewState->id = $id;
		if (!$this->ReviewState->exists()) 
		{
			throw new NotFoundException(__('Invalid Review State'));
		}

		if ($this->ReviewState->delete()) 
		{
			$this->Session->setFlash(__('Review State deleted'));
			return $this->redirect($this->referer());
		}
		
		$this->Session->setFlash(__('Review State was not deleted'));
		return $this->redirect($this->referer());
	}
}