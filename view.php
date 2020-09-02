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

include 'autoload.php';
require __DIR__ . '/vendor/autoload.php';

include 'include/output.php';

try {
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
	output($e->getMessage());
}
