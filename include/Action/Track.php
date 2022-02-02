<?php

namespace Action;

use Data;
use Fetch;

class Track extends AbstractAction
{
	/**
	 * Run tracker
	 */
	public function run(): void
	{
		foreach ($this->users as $user) {
			$data = new Data();
			$data->setPath($user, $this->type);
			$data->load();

			$fetch = new Fetch();
			$stats = $fetch->stats($user);

			$data->update(
				$this->getDate(),
				$stats->stats[0],
				$stats->stats[1]
			);
		}
	}

	/**
	 * Returns formated date
	 *
	 * @return string
	 */
	private function getDate(): string
	{
		switch($this->type) {
			case 'daily':
				return date(
					$this->dateFormats[$this->type],
					strtotime('-1 day')
				);
			case 'monthly':
				return date(
					$this->dateFormats[$this->type],
					strtotime('-1 month')
				);
			default:
				return date($this->dateFormats[$this->type]);
		}
	}
}
