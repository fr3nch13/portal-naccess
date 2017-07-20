<?php ?>
<!-- File: app/View/Equipments/multiselect_review_state.ctp -->
<div class="top">
	<h1><?php echo __('Assign %s to %s', __('Review State'), __('Equipment')); ?></h1>
</div>
<div class="center">
	<div class="posts form">
	<?php echo $this->Form->create('Equipment');?>
	    <fieldset>
	        <legend><?php echo __('Assign %s to %s', __('Review State'), __('Equipment')); ?></legend>
	    	<?php
				echo $this->Form->input('review_state_id', array(
					'label' => __('Review State'),
					'options' => $review_states,
				));
	    	?>
	    </fieldset>
	<?php echo $this->Form->end(__('Update')); ?>
	</div>
</div>
