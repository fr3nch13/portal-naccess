<?php ?>
<!-- File: app/View/DiscoveryMethod/admin_add.ctp -->
<div class="top">
	<h1><?php echo __('Add Discovery Method'); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('DiscoveryMethod');?>
		    <fieldset>
		        <legend><?php echo __('Add Discovery Method'); ?></legend>
		    	<?php
					echo $this->Form->input('name');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save Discovery Method')); ?>
	</div>
</div>