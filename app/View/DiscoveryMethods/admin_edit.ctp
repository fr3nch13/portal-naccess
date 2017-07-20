<?php ?>
<!-- File: app/View/DiscoveryMethod/admin_edit.ctp -->
<div class="top">
	<h1><?php echo __('Edit Discovery Method'); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('DiscoveryMethod');?>
		    <fieldset>
		        <legend><?php echo __('Edit Discovery Method'); ?></legend>
		    	<?php
					echo $this->Form->input('id');
					echo $this->Form->input('name');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save Discovery Method')); ?>
	</div>
</div>