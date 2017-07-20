<?php ?>
<!-- File: app/View/Users/admin_add.ctp -->
<div class="top">
	<h1><?php echo __('Add User'); ?></h1>
</div>
<div class="center">
	<div class="posts form">
	<?php echo $this->Form->create('User');?>
	    <fieldset>
	        <legend><?php echo __('Add User'); ?></legend>
	    	<?php
				echo $this->Form->input('name', array('default' => ''));
				echo $this->Form->input('email', array('default' => ''));
				//echo $this->Form->input('password', array('default' => ''));
				echo $this->Form->input('active');
				echo $this->Form->input('role', array(
					'options' => array(
						'admin' => __('Admin'), 
						'reviewer' => __('Reviewer'), 
						'regular' => __('Regular')
					),
					'selected' => 'regular',
				));
					
				echo $this->Form->input('User.org_group_id', array(
					'label' => array(
						'text' => __('Org Group'),
					),
					'options' => $org_groups,
					'empty' => __('None'),
				));
				
				echo $this->Form->input('paginate_items', array(
					'between' => $this->Html->para('form_info', __('How many items should show up in a list by default.')),
					'options' => array(
						'10' => '10',
						'25' => '25',
						'50' => '50',
						'100' => '100',
						'150' => '150',
						'200' => '200',
					),
					'selected' => '25',
				));
				
				echo $this->Form->input('UserSetting.email_new', array('value' => 1, 'type' => 'hidden'));
				echo $this->Form->input('UserSetting.email_changed', array('value' => 1, 'type' => 'hidden'));
				echo $this->Form->input('UserSetting.email_closed', array('value' => 1, 'type' => 'hidden'));
	    	?>
	    </fieldset>
	<?php echo $this->Form->end(__('Save User')); ?>
	</div>
</div>