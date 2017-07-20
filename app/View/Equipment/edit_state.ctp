<?php 
// File: app/View/Equipment/edit_state.ctp
?>
<div class="top">
	<h1><?php echo __('Edit NAC Exception/Tracking\'s Review State'); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('Equipment'); ?>
			<?php echo $this->Form->input('id', array('type' => 'hidden')); ?>
			
		    <fieldset>
		        <legend class="section"><?php echo __('Edit NAC Exception/Tracking\'s Review State'); ?></legend>
		        <?php
					echo $this->Form->input('Equipment.review_state_id', array(
						'label' => 'Review State',
						'options' => $review_states,
					));
		        ?>
		    </fieldset>
		<?php echo $this->Form->end(__('Update Review State')); ?>
	</div>
</div>
