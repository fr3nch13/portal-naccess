<?php 
// File: app/View/Equipment/edit.ctp
?>
<div class="top">
	<h1><?php echo __('Edit NAC Exception/Tracking'); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('Equipment'); ?>
			<?php echo $this->Form->input('id', array('type' => 'hidden')); ?>
			<?php echo $this->Form->input('EquipmentDetail.id', array('type' => 'hidden')); ?>
			
			<?php if(in_array(AuthComponent::user('role'), array('admin'))): ?>
			<fieldset>
		        <legend class="section"><?php echo __('Admin Details'); ?></legend>
		        <?php
					echo $this->Form->input('Equipment.org_group_id', array(
						'label' => 'Org Group',
						'options' => $org_groups,
						'empty' => __('None'),
//						'div' => array('class' => 'half'),
					));
		        ?>
		    </fieldset>
			<?php endif;?>
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
		        <legend class="section"><?php echo __('Discovery Details'); ?></legend>
		    	<?php
					echo $this->Form->input('Equipment.verified_user_id', array(
						'label' => 'Verified By',
						'options' => $users,
						'default' => AuthComponent::user('id'),
						'empty' => __('[ Select ]'),
					));
					
					echo $this->Wrap->divClear();
					
					echo $this->Form->input('Equipment.discovery_method_id', array(
						'label' => array(
							'text' => __('Discovery Method'),
						),
						'options' => $discovery_methods,
						'empty' => __('NA/None/Unknown/Other'),
						'div' => array('class' => 'half'),
					));
					
					echo $this->Form->input('Equipment.discovered', array(
						'label' => array(
							'text' => __('First Discovered'),
						),
						'div' => array('class' => 'half'),
					));
					
					echo $this->Wrap->divClear();
		    	?>
		    </fieldset>
		    
		    <fieldset>
		        <legend class="section"><?php echo __('Additional Equipment Details'); ?></legend>
		    	<?php
					
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
					
					echo $this->Form->input('EquipmentDetail.loc_building', array(
						'label' => array(
							'text' => __('Equipment Primary Building'),
						),
						'div' => array('class' => 'half'),
					));
					
					echo $this->Form->input('EquipmentDetail.loc_room', array(
						'label' => array(
							'text' => __('Equipment Primary Room'),
						),
						'div' => array('class' => 'half'),
					));
					
					echo $this->Wrap->divClear();
					
					echo $this->Form->input('EquipmentDetail.cust_info', array(
						'label' => array(
							'text' => __('Additional Equipment Details'),
						),
//						'div' => array('class' => 'half'),
					));
					
		        ?>
		    </fieldset>
		    
		    <fieldset>
		        <legend class="section"><?php echo __('Equipment Details'); ?></legend>
		    	<?php
					
					echo $this->Form->input('EquipmentDetail.mac_address', array(
						'label' => array(
							'text' => __('Associated MAC Address'),
						),
						'div' => array('class' => 'third'),
					));
					
					echo $this->Form->input('EquipmentDetail.ip_address', array(
						'label' => array(
							'text' => __('Associated IP Address'),
						),
						'div' => array('class' => 'third'),
					));
					
					echo $this->Form->input('EquipmentDetail.asset_tag', array(
						'label' => array(
							'text' => __('Associated Asset Tag'),
						),
						'div' => array('class' => 'third'),
					));
					
					echo $this->Wrap->divClear();
					
					echo $this->Form->input('Equipment.equipment_status_id', array(
						'label' => array(
							'text' => __('Equipment Status'),
						),
						'options' => $equipment_statuses,
						'empty' => __('Equipment Tracking Initiated'),
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
					
					echo $this->Form->input('Equipment.serial', array(
						'label' => array(
							'text' => __('Serial Number'),
						),
						'div' => array('class' => 'third'),
					));
					
					echo $this->Form->input('Equipment.make', array(
						'label' => array(
							'text' => __('Make'),
						),
						'div' => array('class' => 'third'),
					));
					
					echo $this->Form->input('Equipment.model', array(
						'label' => array(
							'text' => __('Model'),
						),
						'div' => array('class' => 'third'),
					));
					
					echo $this->Wrap->divClear();
					
					echo $this->Form->input('EquipmentDetail.details', array(
						'label' => array(
							'text' => __('Notes (Any notes/details you would like to include. This field is optional.)'),
						),
					));
					
					echo $this->Wrap->divClear();
		        ?>
		    </fieldset>
		<?php echo $this->Form->end(__('Update NAC Exception/Tracking')); ?>
	</div>
</div>

<!-- // check to make sure mac address is unique -->
<script type="text/javascript">

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
				data: { field: obj.attr('id'), value: obj.val(), id: '<?php echo $this->request->data["Equipment"]["id"]; ?>' },
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
