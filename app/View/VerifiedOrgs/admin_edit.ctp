<?php 
// File: app/View/VerifiedOrgs/admin_edit.ctp
?>
<div class="top">
	<h1><?php echo __('Edit Verified Org'); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('VerifiedOrg');?>
		    <fieldset>
		        <legend><?php echo __('Edit Verified Org'); ?></legend>
		    	<?php
					echo $this->Form->input('id');
					echo $this->Form->input('name');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save Verified Org')); ?>
	</div>
</div>