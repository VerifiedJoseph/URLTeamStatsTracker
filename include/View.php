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
	 */
	private function createTable(array $data) {
		$table = array();

		if (empty($data['data']) === false) {
			foreach($data['data'] as $index => $item) {
				$item['totalFound'] = number_format($item['totalFound']);
				$item['found'] = number_format($item['found']);
				$item['totalScanned'] = number_format($item['totalScanned']);
				$item['scanned'] = number_format($item['scanned']);

				$table[] = $item;

				if ($this->type === 'hourly' && count($table) === 24) {
					break;
				}
			}

			$climate = new League\CLImate\CLImate;
			$climate->table($table);
		} else {
			output('No data to display');
		}
	}
}
