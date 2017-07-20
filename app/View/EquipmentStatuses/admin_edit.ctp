<?php ?>
<!-- File: app/View/EquipmentStatus/admin_edit.ctp -->
<div class="top">
	<h1><?php echo __('Edit Equipment Status'); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('EquipmentStatus');?>
		    <fieldset>
		        <legend><?php echo __('Edit Equipment Status'); ?></legend>
		    	<?php
					echo $this->Form->input('id');
					echo $this->Form->input('name');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save Equipment Status')); ?>
	</div>
</div>