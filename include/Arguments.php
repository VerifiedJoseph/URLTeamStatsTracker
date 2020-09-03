<?php

class Arguments {

	/** @var array $optArguments */
	private array $optArguments = array('username:', 'hourly', 'daily', 'monthly');

	/** @var array $arguments */
	private array $arguments = array(
		'username' => '',
		'update' => '',
	);

	/** @var array $extraArguments Extra arguments set by child classes */
	private array $extraArguments = array();

	/** @var array $givenArguments Arguments passed to the script */
	private array $givenArguments = array();

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
	 * @throws Exception If no username argument is given
	 * @throws Exception If no update type argument is given
	 */
	private function checkArguments() {

		if (isset($this->givenArguments['username']) === false) {
			throw new Exception('Username required. Use --username');
		}

		$this->arguments['username'] = $this->givenArguments['username'];

		if (isset($this->givenArguments['hourly'])) {
			$this->arguments['update'] = 'hourly';

		} elseif (isset($this->givenArguments['daily'])) {
			$this->arguments['update'] = 'daily';

		} elseif (isset($this->givenArguments['monthly'])) {
			$this->arguments['update'] = 'monthly';

		} else {
			throw new Exception('No update type given. Use --hourly, --daily or --monthly');
		}
	}
}
