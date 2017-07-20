<?php ?>
Are you sure you want to create an entry for Example ticket <?php echo $equipment['EquipmentDetail']['example_ticket']; ?>? 
A Equipment entry already exists for this ticket number entered on <?php echo $this->Wrap->niceTime($equipment['Equipment']['created']); ?> by <?php echo $equipment['EquipmentAddedUser']['name']; ?>