<?php

use Helper\File;

class Data {

	/** @var string $path Path of data file */
	private string $path = '';

	/** @var array $data */
	private array $data = array(
		'data' => array()
	);

	/** @param string $type Update type */
	private string $type = '';

	/** @param int $maxHourlyItems Max number of hourly items to keep */
	private int $maxHourlyItems = 24;

	/** @param int $maxDailyItems Max number of daily items to keep */
	private int $maxDailyItems = 30;

	/** @param int $maxMonthlyItems Max number of monthly items to keep */
	private int $maxMonthlyItems = 12;

	/**
	 * Set path
	 *
	 * @param string $username URLTeam username
	 * @param string $type Update type
	 */
	public function setPath(string $username, string $type) {
		$this->type = $type;
		$this->path = 'json/' . $username . '-' . $type . '.json';
	}

	/**
	 * Load and decode data
	 *
	 * @throws Exception if json decoding failed
	 */
	public function load() {

		if (File::exists($this->path) === true) {
			$contents = File::read($this->path);
			$data = json_decode($contents, true);

			if (is_null($data) === true) {
				throw new Exception('Failed to decode JSON file: ' . $this->path);
			}

			$this->data = $data;
		}
	}

	/**
	 * Return data
	 *
	 * @return array
	 */
	public function get() {
		return $this->data;
	}

	/**
	 * Return file last modification time
	 *
	 * @return string
	 */
	public function getLastMod() {
		return date('Y-m-d H:i:s', filemtime($this->path));
	}

	/**
	 * Update data
	 *
	 * @param string $time Time and date of update
	 * @param int $totalFound Total number of URLs found
	 * @param int $totalScanned Total number of URLs scanned
	 */
	public function update(string $time, int $totalFound, int $totalScanned) {
		$found = 0;
		$scanned = 0;
		
		if (empty($this->data['data']) === false) {
			$lastKey = array_key_last($this->data['data']);
			$lastItem = $this->data['data'][$lastKey];

			$found = $totalFound - $lastItem['totalFound'];
			$scanned = $totalScanned - $lastItem['totalScanned'];
		}

		$item = array(
			'date' => $time,
			'totalFound' => $totalFound,
			'found' => $found,
			'totalScanned' => $totalScanned,
			'scanned' => $scanned,
		);
		$this->data['data'][] = $item;

		$this->trim();
		$this->save();
	}

	/**
	 * Trim data array to most recent items per type
	 */
	private function trim() {

		if (count($this->data['data']) > $this->getMaxItemCount()) {
			unset($this->data['data'][0]);

			$this->data['data'] = array_values($this->data['data']);
		}
	}

	/**
	 * Save data to file
	 */
	private function save() {
		$json = json_encode($this->data);

		File::write($this->path, $json);
	}

	/**
	 * Returns max item count allowed for an update type
	 *
	 * @return int
	 */
	private function getMaxItemCount() {
		switch($this->type) {
			case 'daily':
				return $this->maxDailyItems;
				break;
			case 'monthly':
				return $this->maxMonthlyItems;
				break;
			default:
				return $this->maxHourlyItems;
		}
	}
}
