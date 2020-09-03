<?php

namespace Action;

use Data;
use Fetch;

class Track extends AbstractAction {

	/**
	 * Run tracker
	 */
	public function run() {
		$data = new Data();
		$data->setPath($this->username, $this->type);
		$data->load();

		$fetch = new Fetch();
		$stats = $fetch->stats($this->username);

		$data->update(
			$this->getDate(),
			$stats->stats[0],
			$stats->stats[1]
		);
	}

	/**
	 * Returns formated date
	 *
	 * @return string
	 */
	private function getDate() {

		if ($this->type === 'monthly') {
			return date(
				$this->dateFormats[$this->type],
				strtotime('-1 month')
			);
		}

		return date($this->dateFormats[$this->type]);
	}
}
