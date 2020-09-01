<?php

abstract class Action {

	/** @var array $updateTypes Update types */
	protected array $updateTypes = array('hourly', 'daily');

	/** @var array $dateFormats Date formats for update types */
	protected array $dateFormats = array(
		'hourly' => 'Y-m-d H',
		'daily' => 'Y-m-d'
	);

	/** @param string $username URLTeam username */
	protected string $username = '';

	/** @param string $type Update type */
	protected string $type = '';

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
