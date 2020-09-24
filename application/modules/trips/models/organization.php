<?php

class Organization extends DataMapper {

	public $has_one = array(
	);

	public $has_many = array(
		"product",
	);

	public function insert_name()
	{
	}
}
