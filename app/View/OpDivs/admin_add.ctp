<?php 
// File: app/View/OpDivs/admin_add.ctp
?>
<div class="top">
	<h1><?php echo __('Add %s', __('OPDIV/IC')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('OpDiv');?>
		    <fieldset>
		        <legend><?php echo __('Add %s', __('OPDIV/IC')); ?></legend>
		    	<?php
					echo $this->Form->input('name');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save %s', __('OPDIV/IC'))); ?>
	</div>
</div>