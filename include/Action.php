<?php

use League\CLImate\CLImate;

abstract class Action {

	/** @var object $climate CLImate instance */
	protected CLImate $climate;

	/** @var array $updateTypes Update types */
	protected array $updateTypes = array('hourly', 'daily', 'monthly');

	/** @var array $dateFormats Date formats for update types */
	protected array $dateFormats = array(
		'hourly' => 'Y-m-d H',
		'daily' => 'Y-m-d',
		'monthly' => 'Y-m'
	);

	/** @param string $username URLTeam username */
	protected string $username = '';

	/** @param string $type Update type */
	protected string $type = '';

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->climate = new CLImate();
	}

	/**
	 * Set username
	 *
	 * @param string $username URLTeam username
	 */
	public function setUsername(string $username) {
		$this->username = $username;
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
