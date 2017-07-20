<?php
// File: app/View/Equipment/add.ctp
?>
<div class="top">
	<h1><?php echo __('Create New NAC Exception/Tracking'); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('Equipment', array('type' => 'file', 'id' => 'AddEquipmentForm'));?>
		    <fieldset>
		        <legend class="section"><?php echo __('Ticket Details'); ?></legend>
		        <?php
					
					echo $this->Form->input('EquipmentDetail.example_ticket', array(
						'label' => array(
							'text' => __('Example Ticket'),
						),
						'div' => array('class' => 'half'),
					));
					
					echo $this->Form->input('EquipmentDetail.tickets', array(
						'label' => array(
							'text' => __('Other Related Tickets'),
						),
						'div' => array('class' => 'half'),
						'type' => 'text',
					));
		        ?>
		    </fieldset>
		    
		    <fieldset>
		        <legend class="section"><?php echo __('Equipment Details'); ?></legend>
		    	<?php
					
					echo $this->Form->input('Equipment.equipment_status_id', array(
						'type' => 'hidden',
						'value' => 0,
					));
					
					echo $this->Form->input('EquipmentDetail.mac_address', array(
						'label' => array(
							'text' => __('Associated MAC Address'),
						),
						'div' => array('class' => 'half'),
					));
					
					echo $this->Form->input('EquipmentDetail.asset_tag', array(
						'label' => array(
							'text' => __('Equipment Serial Number or Example Asset Tag'),
						),
						'div' => array('class' => 'half'),
					));
					
					echo $this->Wrap->divClear();
					
					echo $this->Form->input('EquipmentDetail.ip_address', array(
						'label' => array(
							'text' => __('Associated IP Address'),
						),
						'div' => array('class' => 'half'),
					));
					
					echo $this->Form->input('EquipmentType', array(
						'label' => array(
							'text' => __('Equipment Type(s)'),
						),
						'options' => $equipment_types,
						'multiple' => false,
						'div' => array('class' => 'half'),
					));
					
					echo $this->Wrap->divClear();
					
					echo $this->Form->input('EquipmentDetail.apo', array(
						'label' => array(
							'text' => __('Associated Project Officer, COR or COTR'),
						),
						'div' => array('class' => 'third'),
					));
					
					echo $this->Form->input('EquipmentDetail.tech_poc', array(
						'label' => array(
							'text' => __('Technical POC'),
						),
						'div' => array('class' => 'third'),
					));
	
	echo $this->Form->input('Equipment.op_div_id', array(
		'label' => array(
			'text' => __('OPDIV/IC'),
		),
		'div' => array('class' => 'third'),
		'options' => $op_divs,
		'empty' => __('None/Other'),
	));
					
					echo $this->Wrap->divClear();
					
					echo $this->Form->input('EquipmentDetail.details', array(
						'label' => array(
							'text' => __('Notes (Any notes/details you would like to include. This field is optional.)'),
						),
						'rows' => '8',
						'style' => 'height:8em;',
					));
		        ?>
		    </fieldset>
		    
		    <fieldset>
		        <legend class="section"><?php echo __('NAC Exception Form Upload (optional)'); ?></legend>
		    	<?php
					
					$max_upload = (int)(ini_get('upload_max_filesize'));
					$max_post = (int)(ini_get('post_max_size'));
					$memory_limit = (int)(ini_get('memory_limit'));
					$upload_mb = min($max_upload, $max_post, $memory_limit);
					
					echo $this->Form->input('Upload.file', array(
						'type' => 'file',
						'between' => __('(Max file size is %sM).', $upload_mb),
					));
					// track if the file is associated with a new equipment.
					echo $this->Form->input('Upload.file.new_equipment', array('type' => 'hidden', 'value' => '1'));
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save NAC Exception/Tracking')); ?>
	</div>
</div>

<!-- // check to make sure mac address is unique -->
<script type="text/javascript">

var submitResults = false;

$(document).ready(function()
{
	$('#EquipmentDetailMacAddress').blur(function()
	{
		var obj = $('#EquipmentDetailMacAddress');
		var myMac = obj.val();
		myMac=myMac.toUpperCase();
		myMac=myMac.replace(/ /g,".");
		myMac=myMac.replace(/[^a-zA-Z0-9\.]+/g,"");
		obj.val( myMac );
		
		if(obj.val().length)
		{
			var jqxhr = $.ajax({
				type: 'POST',
				url: "<?php echo $this->Html->url(array('controller' => 'equipment', 'action' => 'validate_mac')); ?>",
				dataType: 'json',
				data: { field: obj.attr('id'), value: obj.val() },
			});
			jqxhr.fail(function( jqXHR, textStatus, errorThrown ) { console.log(textStatus.success) });
			jqxhr.done(function(data, textStatus, jqXHR){ 
				if (data.hasOwnProperty('success'))
				{
					var message = 'Invalid mac address';
					if(!data.success)
					{
						if (data.hasOwnProperty('message'))
						{
							message = data.message;
						}
						alert(message);
						obj.focus();
					}
				}
			});
		}
	});
	
	// validate Mac address on submit as well
	$('#AddEquipmentForm').submit(function()
	{
		var obj = $('#EquipmentDetailMacAddress');
		
		var myMac = obj.val();
		myMac=myMac.toUpperCase();
		myMac=myMac.replace(/ /g,".");
		myMac=myMac.replace(/[^a-zA-Z0-9\.]+/g,"");
		obj.val( myMac );
		
		if(obj.val().length)
		{
			var jqxhr = $.ajax({
				type: 'POST',
				url: "<?php echo $this->Html->url(array('controller' => 'equipment', 'action' => 'validate_mac')); ?>",
				dataType: 'json',
				data: { field: obj.attr('id'), value: obj.val() },
			});
			jqxhr.fail(function( jqXHR, textStatus, errorThrown ) { console.log(textStatus.success) });
			jqxhr.done(function(data, textStatus, jqXHR){ 
				if (data.hasOwnProperty('success'))
				{
					var message = 'Invalid mac address';
					if(!data.success)
					{
						if (data.hasOwnProperty('message'))
						{
							message = data.message;
						}
						alert(message);
						obj.focus();
					}
				}
			});
		}
	});
});//ready

</script>
