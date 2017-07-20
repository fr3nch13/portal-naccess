<?php ?>
				<?php if (AuthComponent::user('id')): ?>
				<ul class="sf-menu">
					
					<li>
						<?php echo $this->Html->link(__('Create New NAC Exception/Tracking'), array('controller' => 'equipment', 'action' => 'add', 'admin' => false, 'plugin' => false), array('class' => 'top')); ?>
						<ul>
							<li><?php echo $this->Html->link(__('Create New Single Record'), array('controller' => 'equipment', 'action' => 'add', 'admin' => false, 'plugin' => false)); ?></li>
							<li><?php echo $this->Html->link(__('Create Many New Records'), array('controller' => 'equipment', 'action' => 'batch_add', 'admin' => false, 'plugin' => false)); ?></li>
						</ul>
					</li>
	<li>
		<?php echo $this->Html->link(__('Overviews'), '#', array('class' => 'top')); ?>
		<ul>
			<li><?php echo $this->Html->link(__('Overview'), array('controller' => 'main', 'action' => 'dashboard', 'admin' => false, 'plugin' => false)); ?></li>
			<li><?php echo $this->Html->link(__('My Overview'), array('controller' => 'main', 'action' => 'my_dashboard', 'admin' => false, 'plugin' => false)); ?></li>
		</ul>
	</li>
					<li>
						<?php 
							$defaultname = $this->requestAction(array('controller' => 'review_states', 'action' => 'defaultname', 'admin' => false, 'plugin' => false));
							echo $this->Html->link(__('Update %s NAC Exceptions/Tracking', $defaultname), '#', array('class' => 'top')); 
						?>
						<?php echo $this->element('Utilities.menu_items', array(
							'request_url' => array('controller' => 'equipment', 'action' => 'review_state', 'admin' => false, 'plugin' => false),
						));?>
					</li>
					<li>
						<?php echo $this->Html->link(__('View NAC Exceptions/Tracking'), '#', array('class' => 'top')); ?>
						<?php echo $this->element('Utilities.menu_items', array(
							'request_url' => array('controller' => 'review_states', 'action' => 'index', 'admin' => false, 'plugin' => false),
						));?>
					</li>
					<li>
						<?php echo $this->Html->link(__('View Files'), '#', array('class' => 'top')); ?>
						<ul>
							<li><?php echo $this->Html->link(__('All Files'), array('controller' => 'uploads', 'action' => 'index', 'admin' => false, 'plugin' => false)); ?></li>
							<li><?php echo $this->Html->link(__('I\'ve Uploaded'), array('controller' => 'uploads', 'action' => 'mine', 'admin' => false, 'plugin' => false)); ?></li>
						</ul>
					</li>
					
					<li><?php echo $this->Html->link(__('View Users'), array('controller' => 'users', 'action' => 'index', 'admin' => false, 'plugin' => false), array('class' => 'top')); ?></li>
					
					<?php echo $this->Common->loadPluginMenuItems(); ?>
					
					<?php if (AuthComponent::user('id') and AuthComponent::user('role') == 'admin'): ?>
					<li>
						<?php echo $this->Html->link(__('Admin'), '#', array('class' => 'top')); ?>
						<ul>
							<li><?php echo $this->Html->link(__('Files'), array('controller' => 'uploads', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
							<li><?php echo $this->Html->link(__('Equipment Types'), array('controller' => 'equipment_types', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
							<li><?php echo $this->Html->link(__('Equipment Statuses'), array('controller' => 'equipment_statuses', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
							<li><?php echo $this->Html->link(__('Discovery Methods'), array('controller' => 'discovery_methods', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
							<li><?php echo $this->Html->link(__('Verified Orgs'), array('controller' => 'verified_orgs', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
							<li><?php echo $this->Html->link(__('OPDIV/ICs'), array('controller' => 'op_divs', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
							<li><?php echo $this->Html->link(__('Exception Update Reasons'), array('controller' => 'exception_update_reasons', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
							<li><?php echo $this->Html->link(__('Review States'), array('controller' => 'review_states', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
							<li><?php echo $this->Html->link(__('DB Logs'), array('controller' => 'dblogs', 'action' => 'index', 'admin' => true, 'plugin' => 'dblogger')); ?></li>
							<?php echo $this->Common->loadPluginMenuItems('admin'); ?>
							<li><?php echo $this->Html->link(__('Users'), '#', array('class' => 'sub')); ?>
								<ul>
									<li><?php echo $this->Html->link(__('All %s', __('Users')), array('controller' => 'users', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
									<li><?php echo $this->Html->link(__('Login History'), array('controller' => 'login_histories', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
									<li><?php echo $this->Html->link(__('Org Groups'), array('controller' => 'org_groups', 'action' => 'index', 'admin' => true, 'plugin' => false)); ?></li>
								</ul>
							</li>
							<li><?php echo $this->Html->link(__('App Admin'), '#', array('class' => 'sub')); ?>
								<ul>
									<li><?php echo $this->Html->link(__('Config'), array('controller' => 'users', 'action' => 'config', 'admin' => true, 'plugin' => false)); ?></li>
									<li><?php echo $this->Html->link(__('Statistics'), array('controller' => 'users', 'action' => 'stats', 'admin' => true, 'plugin' => false)); ?></li>
									<li><?php echo $this->Html->link(__('Process Times'), array('controller' => 'proctimes', 'action' => 'index', 'admin' => true, 'plugin' => 'utilities')); ?></li> 
								</ul>
							</li>
						</ul>
					</li>
					<?php endif; ?>
				</ul>
				<?php endif; ?>