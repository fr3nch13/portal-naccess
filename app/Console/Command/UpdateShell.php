<?php

class UpdateShell extends AppShell
{
	// the models to use
	public $uses = array('EquipmentDetail');
	
	public function startup() 
	{
		$this->clear();
		$this->out('Update Shell');
		$this->hr();
		return parent::startup();
	}
	
	public function getOptionParser()
	{
	/*
	 * Parses out the options/arguments.
	 * http://book.cakephp.org/2.0/en/console-and-shells.html#configuring-options-and-generating-help
	 */
	
		$parser = parent::getOptionParser();
		
		$parser->description(__d('cake_console', 'The Update Shell runs all needed jobs to update production\'s database.'));
		
		$parser->addSubcommand('update_mac_addresses', array(
			'help' => __d('cake_console', 'Update the mac addresses to the new standard of alpha-numeric.'),
		));
		
		return $parser;
	}
	
	public function update_mac_addresses()
	{
		$equipment_details = $this->EquipmentDetail->find('list', array('fields' => array('EquipmentDetail.id', 'EquipmentDetail.mac_address')));
		
		foreach($equipment_details as $id => $mac_address)
		{
//			if(preg_match('/[^0-9a-fA-F]+/i', $mac_address)) { pr('YUP'); }
			$mac_address = preg_replace('/[^0-9a-fA-F]+/', '', $mac_address);
			$this->EquipmentDetail->id = $id;
			$this->EquipmentDetail->saveField('mac_address', $mac_address);
		}
	}
}
?>