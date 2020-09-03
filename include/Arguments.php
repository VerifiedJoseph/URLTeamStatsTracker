<?php

use Helper\Validate;

class Arguments {

	/** @var array $optArguments */
	private array $optArguments = array('username:', 'hourly', 'daily', 'monthly');

	/** @var array $arguments */
	private array $arguments = array(
		'username' => '',
		'update' => '',
	);

	/**
	 * Constructor
	 */
	public function __construct() {
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
	 * @throws Exception If invalid username is given
	 * @throws Exception If no update type argument is given
	 */
	private function checkArguments() {
		$args = getopt('', $this->optArguments);

		if (isset($args['username']) === false) {
			throw new Exception('Username required. Use --username');
		}

		if (Validate::username($args['username']) === false) {
			throw new Exception('Invalid username given.');
		}

		$this->arguments['username'] = $args['username'];

		if (isset($args['hourly'])) {
			$this->arguments['update'] = 'hourly';

		} elseif (isset($args['daily'])) {
			$this->arguments['update'] = 'daily';

		} elseif (isset($args['monthly'])) {
			$this->arguments['update'] = 'monthly';

		} else {
			throw new Exception('No update type given. Use --hourly, --daily or --monthly');
		}
	}
}
