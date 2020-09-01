<?php

class Arguments {

	/** @var array $optArguments */
	protected array $optArguments = array('username:', 'hourly', 'daily');

	/** @var array $arguments */
	protected array $arguments = array(
		'username' => '',
		'update' => '',
	);

	/** @var array $extraArguments Extra arguments set by child classes */
	protected array $extraArguments = array();

	/** @var array $givenArguments Arguments passed to the script */
	protected array $givenArguments = array();

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->givenArguments = getopt('', $this->optArguments);

		$this->checkArguments();
	}

	/**
	 * Get argument value
	 *
	 * @param string $key Argument key
	 * @return mixed
	 */
	public function get(string $key) {
		if (isset($this->arguments[$key])) {
			return $this->arguments[$key];
		}

		return null;
	}

	/**
	 * Check arguments
	 *
	 * @throws Exception If no arguments given
	 */
	protected function checkArguments() {

		if (isset($this->givenArguments['username']) === false) {
			throw new Exception('Username required. Use --username');
		}

		$this->arguments['username'] = $this->givenArguments['username'];

		if (isset($this->givenArguments['hourly'])) {
			$this->arguments['update'] = 'hourly';

		} elseif (isset($this->givenArguments['daily'])) {
			$this->arguments['update'] = 'daily';

		} else {
			throw new Exception('No update type given. Use --hourly or --daily');
		}
	}
}
