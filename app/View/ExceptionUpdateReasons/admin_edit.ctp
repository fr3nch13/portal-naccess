<?php ?>
<!-- File: app/View/ExceptionUpdateReason/admin_edit.ctp -->
<div class="top">
	<h1><?php echo __('Edit Exception Update Reason'); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('ExceptionUpdateReason');?>
		    <fieldset>
		        <legend><?php echo __('Edit Exception Update Reason'); ?></legend>
		    	<?php
					echo $this->Form->input('id');
					echo $this->Form->input('name');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save Exception Update Reason')); ?>
	</div>
</div>