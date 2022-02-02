<?php

namespace Helper;

class Validate 
{
	/** @var string $usernameRegex Username validation regex */
	private static string $usernameRegex = '/^([A-Za-z0-9_-]+)$/';

	/**
	 * Validate a username
	 *
	 * @param string $username URLTeam username
	 * @return boolean
	 */
	public static function username(string $username): bool
	{
		if (preg_match(self::$usernameRegex, $username)) {
			return true;
		}

		return false;
	}
}
