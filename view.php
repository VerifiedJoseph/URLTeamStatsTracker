<?php
/*
	View stats for a tracked URLTeam user
	Created: 2020-09-01

	Parameters:
	--username
	--hourly
	--daily
	--monthly
*/

use League\CLImate\CLImate;

include 'autoload.php';
require __DIR__ . '/vendor/autoload.php';

try {
	$climate = new CLImate();
	$arguments = new Arguments();

	$view = new View();
	$view->setUsername(
		$arguments->get('username')
	);

	$view->setUpdateType(
		$arguments->get('update')
	);

	$view->get();

} catch (Exception $e) {
	$climate->out($e->getMessage());
}
