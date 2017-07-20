<?php ?>
<!-- File: app/View/Equipments/multiselect_equipment_statue.ctp -->
<div class="top">
	<h1><?php echo __('Assign %s to %s', __('Equipment Status'), __('Equipment')); ?></h1>
</div>
<div class="center">
	<div class="posts form">
	<?php echo $this->Form->create('Equipment');?>
	    <fieldset>
	        <legend><?php echo __('Assign %s to %s', __('Equipment Status'), __('Equipment')); ?></legend>
	    	<?php
				echo $this->Form->input('equipment_status_id', array(
					'label' => __('Equipment Status'),
					'options' => $equipment_statuses,
				));
	    	?>
	    </fieldset>
	<?php echo $this->Form->end(__('Update')); ?>
	</div>
</div>
