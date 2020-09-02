<?php

class View extends Action {

	/**
	 * Get view
	 */
	public function get() {
		$data = new Data();
		$data->setPath($this->username, $this->type);
		$data->load();

		$this->createTable(
			$data->get()
		);

		$this->createStats(
			$data->get()
		);
	}

	/**
	 * Create table using CLImate
	 *
	 * @param array $data Data from file
	 *
	 * @throws Exception if data array is empty
	 */
	private function createTable(array $data) {
		$table = array();

		if (empty($data['data'])) {
			throw new Exception('No data to display');
		}

		foreach($data['data'] as $index => $item) {
			$item['totalFound'] = number_format($item['totalFound']);
			$item['found'] = number_format($item['found']);
			$item['totalScanned'] = number_format($item['totalScanned']);
			$item['scanned'] = number_format($item['scanned']);

			$table[] = $item;
		}

		$climate = new League\CLImate\CLImate;
		$climate->table($table);
	}

	/**
	 * Create, output averages and other stats
	 *
	 * @param array $data Data from file
	 */
	private function createStats(array $data) {
		$lastKey = array_key_last($data['data']);
		$itemCount = count($data['data']);

		$found = $data['data'][$lastKey]['totalFound'] - $data['data'][0]['totalFound'];
		$scanned = $data['data'][$lastKey]['totalScanned'] - $data['data'][0]['totalScanned'];

		$foundAverage = floor($found / $itemCount);
		$scannedAverage = floor($scanned / $itemCount);

		output('');

		$columns = array(
			'Scanned: ' . number_format($scanned),
			'Found: ' . number_format($found),
			'Average: ' . number_format($scannedAverage),
			'Average: ' . number_format($foundAverage),
		);

		$climate = new League\CLImate\CLImate;
		$climate->columns($columns, 2);
	}
}
