<?php

namespace Action;

use Data;
use Exception;

class View extends AbstractAction {

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

		$this->climate->br();
		$this->climate->out('Last mod: ' . $data->getLastMod());
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

		$this->climate->table($table);
	}

	/**
	 * Create, output averages and other stats
	 *
	 * @param array $data Data from file
	 */
	private function createStats(array $data) {
		$multiply = 100; // Multiply decimal by
		$columnCount = 2;

		$lastKey = array_key_last($data['data']);
		$itemCount = count($data['data']);

		// Calculate difference
		$found = $data['data'][$lastKey]['totalFound'] - $data['data'][0]['totalFound'];
		$scanned = $data['data'][$lastKey]['totalScanned'] - $data['data'][0]['totalScanned'];

		// Calculate percentage of scanned URLs found
		if ($found > 0) {
			$percentFound = round($found / $scanned * $multiply);
		} else {
			$percentFound = 0;
		}

		// Calculate mean averages
		$foundAverage = floor($found / $itemCount);
		$scannedAverage = floor($scanned / $itemCount);

		$columns = array(
			'Scanned: ' . number_format($scanned),
			'Found: ' . number_format($found) . ' (' . $percentFound . '%)',
			'Average: ' . number_format($scannedAverage),
			'Average: ' . number_format($foundAverage),
		);

		$this->climate->br();
		$this->climate->columns($columns, $columnCount);
	}
}
