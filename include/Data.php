<?php

class Data {

	/** @var string $path Path of data file */
	private string $path = '';

	/** @var array $data */
	private array $data = array(
		'data' => array()
	);

	/** @param string $type Update type */
	private string $type = '';

	/**
	 * Load and decode data
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
	 * @throws Exception If file open failed
	 */
	public function load() {

		if (file_exists($this->path) === true) {
			$pointer = fopen($this->path, 'r');

			if($pointer === false) {
				throw new Exception('Failed to open JSON file: ' . $this->path);
			}

			$contents = fread($pointer, filesize($this->path));
			fclose($pointer);

			$this->data = json_decode($contents, true);
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
	 * Update data
	 *
	 * @param string $time Time and date of update
	 * @param int $totalFound Total number of URLs found
	 * @param int $totalScanned Total number of URLs scanned
	 */
	public function update(string $time, int $totalFound, int $totalScanned) {

		if (empty($this->data['data']) === false) {
			$lastKey = array_key_last($this->data['data']);
			$lastItem = $this->data['data'][$lastKey];

			$found = $totalFound - $lastItem['totalFound'];
			$scanned = $totalScanned - $lastItem['totalScanned'];

		} else {
			$found = 0;
			$scanned = 0;
		}

		$item = array(
			'date' => $time,
			'totalFound' => $totalFound,
			'found' => $found,
			'totalScanned' => $totalScanned,
			'scanned' => $scanned,
		);
		$this->data['data'][] = $item;

		$this->save();
	}

	/**
	 * Save data to file
	 *
	 * @throws Exception If file open failed
	 * @throws Exception If file write failed
	 */
	private function save() {
		$pointer = fopen($this->path, 'w');

		if($pointer === false) {
			throw new Exception('Failed to open JSON file: ' . $this->path);
		}

		$json = json_encode($this->data);

		if(fwrite($pointer, $json) === false) {
			throw new Exception('Failed to write JSON file: ' . $this->path);
		}
	}
}
