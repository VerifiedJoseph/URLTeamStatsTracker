<?php
/*
	Track stats for URLTeam users

	Parameters:
	--user		Track a single user.
	--users 	Track multiple users (separate each username with a comma).
	--hourly
	--daily
	--monthly
*/

use Action\Track;
use League\CLImate\CLImate;

require __DIR__ . '/vendor/autoload.php';

try {
	$climate = new CLImate();
	$arguments = new Arguments();

	$track = new Track();
	$track->setUsers(
		$arguments->get('users')
	);

	$track->setUpdateType(
		$arguments->get('updateType')
	);

	$track->run();

} catch (Exception $e) {
	$climate->out($e->getMessage());
}
