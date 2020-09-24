<?php

class Event extends DataMapper {

	public $has_one = array(
		"trip",
		"product",
	);

	public $has_many = array(
	);

	public function insert_name()
	{
	}
}
