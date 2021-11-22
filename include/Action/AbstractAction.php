<?php

namespace Action;

use League\CLImate\CLImate;

abstract class AbstractAction {

	/** @var CLImate $climate CLImate instance */
	protected CLImate $climate;

	/** @var array<int, string> $updateTypes Update types */
	protected array $updateTypes = array('hourly', 'daily', 'monthly');

	/** @var array<string, string> $dateFormats Date formats for update types */
	protected array $dateFormats = array(
		'hourly' => 'Y-m-d H',
		'daily' => 'Y-m-d',
		'monthly' => 'Y-m'
	);

	/** @param array $users URLTeam users */
	protected array $users = array();

	/** @param string $type Update type */
	protected string $type = '';

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->climate = new CLImate();
	}

	/**
	 * Set users
	 *
	 * @param array<int, string> $users URLTeam users
	 */
	public function setUsers(array $users): void
	{
		$this->users = $users;
	}

	/**
	 * Set update type
	 *
	 * @param string $type Update type
	 */
	public function setUpdateType(string $type): void
	{
		$this->type = $type;
	}
}
