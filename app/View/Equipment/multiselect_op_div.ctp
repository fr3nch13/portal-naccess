<?php ?>
<!-- File: app/View/Equipments/multiselect_op_div.ctp -->
<div class="top">
	<h1><?php echo __('Assign %s to %s', __('OPDIV/IC'), __('Equipment')); ?></h1>
</div>
<div class="center">
	<div class="posts form">
	<?php echo $this->Form->create('Equipment');?>
	    <fieldset>
	        <legend><?php echo __('Assign %s to %s', __('OPDIV/IC'), __('Equipment')); ?></legend>
	    	<?php
				echo $this->Form->input('op_div_id', array(
					'label' => __('OPDIV/IC'),
					'options' => $op_divs,
				));
	    	?>
	    </fieldset>
	<?php echo $this->Form->end(__('Update')); ?>
	</div>
</div>
