<?php

use Helper\File;

class Data {

	/** @var string $path Path of data file */
	private string $path = '';

	/** @var stdClass $data */
	private stdClass $data;

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
	public function setPath(string $username, string $type): void
	{
		$this->type = $type;
		$this->path = 'json/' . $username . '-' . $type . '.json';
	}

	/**
	 * Load and decode data
	 *
	 * @throws Exception if json decoding failed
	 */
	public function load(): void
	{
		$this->data = (object) [];

		if (File::exists($this->path) === true) {
			$contents = File::read($this->path);
			$data = json_decode($contents);

			if (is_null($data) === true) {
				throw new Exception('Failed to decode JSON file: ' . $this->path);
			}

			$this->data = (object) $data;
		}
	}

	/**
	 * Return data
	 *
	 * @return stdClass
	 */
	public function get(): stdClass
	{
		return $this->data;
	}

	/**
	 * Return file last modification time
	 *
	 * @return string
	 */
	public function getLastMod(): string
	{
		return date('Y-m-d H:i:s', (int) filemtime($this->path));
	}

	/**
	 * Update data
	 *
	 * @param string $time Time and date of update
	 * @param int $totalFound Total number of URLs found
	 * @param int $totalScanned Total number of URLs scanned
	 */
	public function update(string $time, int $totalFound, int $totalScanned): void
	{
		$found = 0;
		$scanned = 0;
		
		if (empty($this->data->stats) === false) {
			$lastKey = array_key_last($this->data->stats);
			$lastItem = $this->data->stats[$lastKey];

			$found = $totalFound - $lastItem->totalFound;
			$scanned = $totalScanned - $lastItem->totalScanned;
		}

		$this->data->stats[] = (object) [
			'date' => $time,
			'totalFound' => $totalFound,
			'found' => $found,
			'totalScanned' => $totalScanned,
			'scanned' => $scanned,
		];;

		$this->trim();
		$this->save();
	}

	/**
	 * Trim data array to most recent items per type
	 */
	private function trim(): void
	{
		if (count($this->data->stats) > $this->getMaxItemCount()) {
			unset($this->data->stats[0]);

			$this->data->stats = array_values($this->data->stats);
		}
	}

	/**
	 * Save data to file
	 */
	private function save(): void
	{
		$json = (string) json_encode($this->data);

		File::write($this->path, $json);
	}

	/**
	 * Returns max item count allowed for an update type
	 *
	 * @return int
	 */
	private function getMaxItemCount(): int
	{
		switch($this->type) {
			case 'daily':
				return $this->maxDailyItems;
			case 'monthly':
				return $this->maxMonthlyItems;
			default:
				return $this->maxHourlyItems;
		}
	}
}
