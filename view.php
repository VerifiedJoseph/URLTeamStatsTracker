<?php
/*
	View stats for tracked URLTeam users

	Parameters:
	--user		Views stats for a single user.
	--users		Views stats for multiple users (separate each username with a comma).
	--hourly
	--daily
	--monthly
*/

use Action\View;
use League\CLImate\CLImate;

require __DIR__ . '/vendor/autoload.php';

try {
	$climate = new CLImate();
	$arguments = new Arguments();

	$view = new View();
	$view->setUsers(
		$arguments->get('users')
	);

	$view->setUpdateType(
		$arguments->get('updateType')
	);

	$view->get();

} catch (Exception $e) {
	$climate->out($e->getMessage());
}
