<?php

namespace Action;

use Data;
use stdClass;
use Exception;

class View extends AbstractAction
{
	/**
	 * Get view
	 */
	public function get(): void
	{
		foreach ($this->users as $user) {
			$data = new Data();
			$data->setPath($user, $this->type);
			$data->load();

			$this->climate->out('User: ' . $user);

			$this->createTable(
				$data->get()
			);

			$this->createStats(
				$data->get()
			);

			$this->climate->br();
			$this->climate->out('Last mod: ' . $data->getLastMod());
			$this->climate->br();
		}
	}

	/**
	 * Create table using CLImate
	 *
	 * @param stdClass $data Data from file
	 *
	 * @throws Exception if data array is empty
	 */
	private function createTable(stdClass $data): void
	{
		if (isset($data->stats) === false) {
			throw new Exception('No data to display');
		}

		$table = array();

		foreach($data->stats as $item) {
			$row = array();
			$row['date'] = $item->date;
			$row['found'] = number_format($item->found);
			$row['total_found'] = number_format($item->totalFound);
			$row['scanned'] = number_format($item->scanned);
			$row['total_scanned'] = number_format($item->totalScanned);

			$table[] = $row;
		}

		$this->climate->table($table);
	}

	/**
	 * Create, output averages and other stats
	 *
	 * @param stdClass $data Data from file
	 */
	private function createStats(\stdClass $data): void
	{
		$multiply = 100; // Multiply decimal by
		$columnCount = 2;

		$lastKey = array_key_last($data->stats);
		$itemCount = count($data->stats);

		// Calculate difference
		$found = $data->stats[$lastKey]->totalFound - $data->stats[0]->totalFound;
		$scanned = $data->stats[$lastKey]->totalScanned - $data->stats[0]->totalScanned;

		$percentFound = 0;

		// Calculate percentage of scanned URLs found
		if ($found > 0) {
			$percentFound = round($found / $scanned * $multiply);
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
