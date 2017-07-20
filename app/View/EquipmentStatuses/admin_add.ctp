<?php ?>
<!-- File: app/View/EquipmentStatus/admin_add.ctp -->
<div class="top">
	<h1><?php echo __('Add Equipment Status'); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('EquipmentStatus');?>
		    <fieldset>
		        <legend><?php echo __('Add Equipment Status'); ?></legend>
		    	<?php
					echo $this->Form->input('name');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save Equipment Status')); ?>
	</div>
</div>