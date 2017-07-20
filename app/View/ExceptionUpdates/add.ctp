<?php
// File: app/View/ExceptionUpdates/add.ctp
?>
<div class="top">
	<h1><?php echo __('Add NAC Exception Form'); ?></h1>
<!--	<?php if(isset($equipment)):?><h2><?php // echo __('Equipment: %s', $equipment['Equipment']['id']. ' : '. (trim($equipment['EquipmentDetail']['example_ticket'])?$equipment['EquipmentDetail']['example_ticket']:__('(Empty)')). ' : '. (trim($equipment['EquipmentDetail']['irt_ticket'])?$equipment['EquipmentDetail']['irt_ticket']:__('(Empty)')). ' : '. (trim($equipment['EquipmentDetail']['mac_address'])?$equipment['EquipmentDetail']['mac_address']:__('(Empty)'))); ?></h2><?php endif;?> --> 
	<?php if(isset($equipment)):?><h2><?php echo __('Equipment: %s', $equipment['Equipment']['id']. ' : '. (trim($equipment['EquipmentDetail']['example_ticket'])?$equipment['EquipmentDetail']['example_ticket']:__('(Empty)')). ' : '. ' : '. (trim($equipment['EquipmentDetail']['mac_address'])?$equipment['EquipmentDetail']['mac_address']:__('(Empty)'))); ?></h2><?php endif;?>
</div>
<div class="center">
	<div class="posts form">
		<?php echo $this->Form->create('ExceptionUpdate', array('type' => 'file'));?>
		    <fieldset>
		        <legend><?php echo __('Add NAC Exception Form'); ?></legend>
		    	<?php
		    		
					echo $this->Form->input('equipment_id', array('type' => 'hidden'));
					
/*
		    		echo $this->Form->input('released_user_id', array(
						'label' => array(
							'text' => __('Equipment Released By'),
						),
						'options' => $users,
						'empty' => array('0' => __('Other (Enter Name Below)')),
						'div' => array('class' => 'third'),
					));
*/
					
		    		echo $this->Form->input('verified_user_id', array(
						'label' => array(
							'text' => __('NAC Exception Form Received By'),
						),
						'options' => $users,
						'div' => array('class' => 'half'),
					));
					
					echo $this->Form->input('exception_update_reason_id', array(
						'label' => array(
							'text' => __('Exception Update Reason'),
						),
						'options' => $exception_update_reasons,
						'div' => array('class' => 'half'),
					));
					
					echo $this->Wrap->divClear();
					
/*
		    		echo $this->Form->input('released_user_other', array(
						'label' => array(
							'text' => __('Equipment Released By (Other)'),
						),
						'div' => array('class' => 'third'),
					));
*/
					
		    		echo $this->Form->input('released_user_other', array(
						'label' => array(
							'text' => __('NAC Exception Form Received From'),
						),
						'div' => array('class' => 'half'),
					));
					
					echo $this->Form->input('Equipment.id', array('type' => 'hidden'));
					echo $this->Form->input('Equipment.equipment_status_id', array(
						'label' => array(
							'text' => __('Equipment Status'),
						),
						'options' => $equipment_statuses,
						'div' => array('class' => 'half'),
					));;
					
					echo $this->Wrap->divClear();
					
					echo $this->Form->input('notes', array(
						'label' => array(
							'text' => __('Notes (Any notes/details you would like to include. This field is optional.)'),
						),
					));
					
					echo $this->Wrap->divClear();
	
					$max_temp_upload = (int)(ini_get('upload_max_filesize'));
					$max_post = (int)(ini_get('post_max_size'));
					$memory_limit = (int)(ini_get('memory_limit'));
					$temp_upload_mb = min($max_temp_upload, $max_post, $memory_limit);
					
					echo $this->Form->input('Upload.file', array(
						'type' => 'file',
						'between' => __('(Max file size is %sM).', $temp_upload_mb),
					));
					
					echo $this->Form->input('Upload.equipment_id', array('type' => 'hidden'));
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Add Exception Update')); ?>
	</div>
</div>
