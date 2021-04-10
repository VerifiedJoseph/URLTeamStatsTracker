<?php

use Helper\Validate;

class Arguments {

	/** @var array $optArguments */
	private array $optArguments = array('user:', 'users:', 'hourly', 'daily', 'monthly');

	/** @var array $arguments */
	private array $arguments = array(
		'users' => array(),
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
	 * @throws Exception if no user or users argument is given
	 * @throws Exception if an invalid username is given
	 * @throws Exception if no update type argument is given
	 */
	private function checkArguments() {
		$args = getopt('', $this->optArguments);

		if (isset($args['user']) === false && isset($args['users']) === false) {
			throw new Exception("User(s) required. \nUse \"--user\" to track a single user or \"--users\" track multiple users (separate each username with a comma).");
		}

		if (isset($args['user'])) {
			if (Validate::username($args['user']) === false) {
				throw new Exception('Invalid username given.');
			}

			$this->arguments['users'][] = $args['user'];
		}

		if (isset($args['users'])) {
			$users = explode(',', $args['users']);

			foreach ($users as $user) {

				if (Validate::username($user) === false) {
					throw new Exception('Invalid username given: ' . $user);
				}

				$this->arguments['users'][] = trim($user);
			}
		}

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
