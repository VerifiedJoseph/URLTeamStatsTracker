<?php
/*
	Track stats for a URLTeam user
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

include 'include/output.php';

try {
	$climate = new CLImate();
	$arguments = new Arguments();

	$track = new Track();
	$track->setUsername(
		$arguments->get('username')
	);

	$track->setUpdateType(
		$arguments->get('update')
	);

	$track->run();

} catch (Exception $e) {
	$climate->out($e->getMessage());
}
