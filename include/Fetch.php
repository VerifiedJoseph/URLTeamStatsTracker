<?php

use Curl\Curl;

class Fetch
{
	/** @var string $endpoint Stats endpoint */
	private string $endpoint = 'https://tracker.archiveteam.org:1338/api/stats/';

	/** @var int $maxRetries Number of max retries */
	private int $maxRetries = 3;

	/** @var int $retryDelay Number of seconds to delay each retry */
	private int $retryDelay = 5;

	/**
	 * Fetch stats for a username
	 *
	 * @param string $username URLTeam username
	 *
	 * @return mixed
	 *
	 * @throws Exception if cURL error occurred.
	 * @throws Exception if HTTP error occurred.
	 */
	public function stats(string $username): mixed
	{
		$url = $this->endpoint . $username;

		$curl = new Curl();

		$curl->setRetry(function ($instance) {
			if ($instance->retries < $this->maxRetries) {
				sleep($this->retryDelay);
				return true;
			}
			return false;
		});

		$curl->get($url);

		if ($curl->getCurlErrorCode() !== 0) {
			throw new Exception('Error: ' . $curl->getCurlErrorCode() . ': ' . $curl->getErrorMessage());
		}

		if ($curl->getHttpStatusCode() !== 200) {
			throw new Exception('Failed to fetch: ' . $url . ' (' . $curl->getHttpStatusCode() . ')');
		}

		return $curl->response;
	}
}
