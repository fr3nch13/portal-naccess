<?php 
// File: app/View/VerifiedOrgs/admin_add.ctp
?>
<div class="top">
	<h1><?php echo __('Add Verified Org'); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('VerifiedOrg');?>
		    <fieldset>
		        <legend><?php echo __('Add Verified Org'); ?></legend>
		    	<?php
					echo $this->Form->input('name');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save Verified Org')); ?>
	</div>
</div>