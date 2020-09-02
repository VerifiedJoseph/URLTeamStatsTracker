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
	}
}
