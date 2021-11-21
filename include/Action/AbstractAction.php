<?php

namespace Action;

use League\CLImate\CLImate;

abstract class AbstractAction {

	/** @var CLImate $climate CLImate instance */
	protected CLImate $climate;

	/** @var array $updateTypes Update types */
	protected array $updateTypes = array('hourly', 'daily', 'monthly');

	/** @var array $dateFormats Date formats for update types */
	protected array $dateFormats = array(
		'hourly' => 'Y-m-d H',
		'daily' => 'Y-m-d',
		'monthly' => 'Y-m'
	);

	/** @param string $users URLTeam users */
	protected array $users = array();

	/** @param string $type Update type */
	protected string $type = '';

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->climate = new CLImate();
	}

	/**
	 * Set users
	 *
	 * @param array $users URLTeam users
	 */
	public function setUsers(array $users) {
		$this->users = $users;
	}

	/**
	 * Set update type
	 *
	 * @param string $type Update type
	 */
	public function setUpdateType(string $type) {
		$this->type = $type;
	}
}
