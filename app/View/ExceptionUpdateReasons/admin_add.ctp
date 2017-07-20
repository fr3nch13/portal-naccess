<?php ?>
<!-- File: app/View/ExceptionUpdateReason/admin_add.ctp -->
<div class="top">
	<h1><?php echo __('Add Exception Update Reason'); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('ExceptionUpdateReason');?>
		    <fieldset>
		        <legend><?php echo __('Add Exception Update Reason'); ?></legend>
		    	<?php
					echo $this->Form->input('name');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save Exception Update Reason')); ?>
	</div>
</div>