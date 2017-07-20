<?php
// File: app/View/Uploads/add.ctp
?>
<div class="top">
	<h1><?php echo __('Add File'); ?></h1>
<!--	<?php if(isset($equipment)):?><h2><?php // echo __('Equipment: %s', $equipment['Equipment']['id']. ' : '. (trim($equipment['EquipmentDetail']['example_ticket'])?$equipment['EquipmentDetail']['example_ticket']:__('(Empty)')). ' : '. (trim($equipment['EquipmentDetail']['irt_ticket'])?$equipment['EquipmentDetail']['irt_ticket']:__('(Empty)')). ' : '. (trim($equipment['EquipmentDetail']['mac_address'])?$equipment['EquipmentDetail']['mac_address']:__('(Empty)'))); ?></h2><?php endif;?> -->
	<?php if(isset($equipment)):?><h2><?php echo __('Equipment: %s', $equipment['Equipment']['id']. ' : '. (trim($equipment['EquipmentDetail']['example_ticket'])?$equipment['EquipmentDetail']['example_ticket']:__('(Empty)')). ' : '. ' : '. (trim($equipment['EquipmentDetail']['mac_address'])?$equipment['EquipmentDetail']['mac_address']:__('(Empty)'))); ?></h2><?php endif;?> 
</div>
<div class="center">
	<div class="posts form">
		<?php echo $this->Form->create('Upload', array('type' => 'file'));?>
		    <fieldset>
		        <legend><?php echo __('Add File'); ?></legend>
		    	<?php
					
					$max_temp_upload = (int)(ini_get('upload_max_filesize'));
					$max_post = (int)(ini_get('post_max_size'));
					$memory_limit = (int)(ini_get('memory_limit'));
					$temp_upload_mb = min($max_temp_upload, $max_post, $memory_limit);
					
					echo $this->Form->input('file', array(
						'type' => 'file',
						'between' => __('(Max file size is %sM).', $temp_upload_mb),
					));
					echo $this->Form->input('Upload.equipment_id', array('type' => 'hidden'));
					echo $this->Form->input('Upload.exception_update_id', array('type' => 'hidden'));
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Upload File')); ?>
	</div>
</div>
