<?php

use Curl\Curl;

class Fetch {

	/** @var array $endpoint Stats endpoint */
	private string $endpoint = 'https://tracker.archiveteam.org:1338/api/stats/';

	/**
	 * Fetch stats for a username
	 *
	 * @param string $username URLTeam username
	 */
	public function stats(string $username) {
		$url = $this->endpoint . $username;

		$curl = new Curl();
		$curl->get($url);

		if ($curl->getCurlErrorCode() !== 0) {
			throw new Exception('Error: ' . $curl->getCurlErrorCode() . ': ' . $curl->getErrorMessage());
		}

		if ($curl->getHttpStatusCode() !== 200) {
			throw new Exception('Failed to fetch: ' . $url);
		}

		return $curl->response;
	}
}
