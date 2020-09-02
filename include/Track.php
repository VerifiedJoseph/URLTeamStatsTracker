<?php

class Track extends Action {
	
	/**
	 * Run tracker
	 */
	public function run() {
		$data = new Data();
		$data->setPath($this->username, $this->type);
		$data->load();

		$tdateTime = date($this->dateFormats[$this->type]);

		$fetch = new Fetch();
		$stats = $fetch->stats($this->username);

		$data->update(
			$tdateTime,
			$stats->stats[0],
			$stats->stats[1]
		);
	}
}
