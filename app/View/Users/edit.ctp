<?php ?>
<!-- File: app/View/Users/edit.ctp -->

<div class="top">
	<h1><?php echo __('Edit Settings'); ?></h1>
</div>

<div class="center">
	<div class="tabs">
		<div id="tabs">
			<ul>
				<li><a href="#tabs-1"><?php echo __('Edit Details'); ?></a></li>
				<li><a href="#tabs-2"><?php echo __('Email Settings'); ?></a></li>
<!--				<li><a href="#tabs-3"><?php echo __('Change Password'); ?></a></li>
				<li><a href="#tabs-4"><?php echo __('Avatar'); ?></a></li>-->
			</ul>
			
			<div id="tabs-1">
				<div class="form">
					<?php echo $this->Form->create('User'); ?>
					<fieldset>
						<!--<legend><?php echo __('Edit Details'); ?></legend>-->
					<?php
						echo $this->Form->input('id', array('type' => 'hidden'));
//						echo $this->Form->input('name');
//						echo $this->Form->input('email');
						echo $this->Form->input('paginate_items', array(
							'between' => $this->Html->para('form_info', __('How many items should show up in a list by default.')),
							'options' => array(
								'10' => __('10'),
								'25' => __('25'),
								'50' => __('50'),
								'100' => __('100'),
								'150' => __('150'),
								'200' => __('200'),
								'500' => __('500 - May Load Slowly'),
								'1000' => __('1000 - May Load Slowly'),
							),
							'selected' => '25',
						));
					?>
					</fieldset>
					<?php echo $this->Form->end(__('Save Details'));?>
				</div>
			</div>
	
			<div id="tabs-2">
				<div class="form">
				<?php echo $this->Form->create('User'); ?>
					<fieldset>
						<legend><?php echo __('Email Settings'); ?></legend>
						<?php
							echo $this->Form->input('UserSetting.email_new', array(
								'label' => __('When new Equipment/Exception Update is added'),
								'between' => $this->Html->para('form_info', __('Get an email when a new equipment or exception update entry is entered.')),
								'options' => array(
									'0' => __('Never'),
									'1' => __('When I\'m involved.'),
									'2' => __('Always'),
								),
								'default' => '1',
							));
							echo $this->Form->input('UserSetting.email_updated', array(
								'label' => __('When Equipment/Exception Update is updated'),
								'between' => $this->Html->para('form_info', __('Get an email when a equipment or exception update entry is updated.')),
								'options' => array(
									'0' => __('Never'),
									'1' => __('When I\'m involved.'),
									'2' => __('Always'),
								),
								'default' => '1',
							));
/*** 
 // Copied from Media Tracker.
 // This is now a dynamic setting in Naccess
 // I have disabled this, as the 'updated' setting should catch this change
							echo $this->Form->input('UserSetting.email_closed', array(
								'label' => __('When Equipment is closed'),
								'between' => $this->Html->para('form_info', __('Get an email when a equipment entry is marked as closed.')),
								'options' => array(
									'0' => __('Never'),
									'1' => __('When I\'m involved.'),
									'2' => __('Always'),
								),
								'default' => '1',
							));
*/
							echo $this->Form->input('id', array('type' => 'hidden'));
							echo $this->Form->input('UserSetting.id', array('type' => 'hidden'));
						?>
					</fieldset>
				<?php echo $this->Form->end(__('Save Email Settings'));?>
				</div>
			</div>
			
<!--
			<div id="tabs-3">
				<div style="text-align:center;">
					<h3><?php 
						$accounts_link = Configure::read('OAuth.serverURI');
						$accounts_link .= '/users/edit?referer='. urlencode($this->Html->url(null, true));
						$accounts_link .= '#tabs-2';
						echo __(
							'To change your password, please visit the %s app.', 
							$this->Html->link(__('Accounts'), $accounts_link)
						);
					?></h3>
				</div>
			</div>
			
			<div id="tabs-4">
				<div class="form">
				<?php echo $this->Form->create('User', array('url' => array('action' => 'avatar'), 'type' => 'file'));?>
					<fieldset>
						<legend><?php echo __('Add/change Avatar'); ?></legend>
						<?php
							echo $this->Avatar->view($this->request->data, 'medium');
							echo $this->Form->input('id', array('type' => 'hidden'));
							echo $this->Form->input('photo', array('type' => 'file', 'label' => __('Upload Avatar Image')));
						?>
					</fieldset>
				<?php echo $this->Form->end(__('Upload Image'));?>
				</div>
			</div>
-->
		</div>
	</div>
</div>

<script type="text/javascript">
//<![CDATA[
	$(document).ready(function () {
		$( "#tabs" ).tabs({select:function (event, ui) {window.location.hash = ui.tab.hash;}});
	});
//]]>
</script>