<?php ?>
<!-- File: app/View/EquipmentType/admin_edit.ctp -->
<div class="top">
	<h1><?php echo __('Edit Equipment Type'); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('EquipmentType');?>
		    <fieldset>
		        <legend><?php echo __('Edit Equipment Type'); ?></legend>
		    	<?php
					echo $this->Form->input('id');
					echo $this->Form->input('name');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save Equipment Type')); ?>
	</div>
</div>