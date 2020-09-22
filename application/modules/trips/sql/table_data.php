<?php

$result = array(
	array(
		"name" => "trips",
		"primary_key" => "id",
		"fields" => array(
			array(
				"name" => "id",
				"type" => "BIGINT",
				"collation" => "UNSIGNED",
				"null" => "NOT NULL",
				"a_i" => "AUTO_INCREMENT",
			),
			array(
				"name" => "event_children",
				"type" => "BIGINT",
				"collation" => "UNSIGNED",
			),
			// non-relationship
		),
	),
	array(
		"name" => "events",
		"primary_key" => "id",
		"fields" => array(
			array(
				"name" => "id",
				"type" => "BIGINT",
				"collation" => "UNSIGNED",
				"null" => "NOT NULL",
				"a_i" => "AUTO_INCREMENT",
			),
			array(
				"name" => "product_id",
				"type" => "BIGINT",
				"collation" => "UNSIGNED",
			),
			// non-relationship

		),
	),
	array(
		"name" => "products",
		"primary_key" => "id",
		"fields" => array(
			array(
				"name" => "id",
				"type" => "BIGINT",
				"collation" => "UNSIGNED",
				"null" => "NOT NULL",
				"a_i" => "AUTO_INCREMENT",
			),
			array(
				"name" => "organization_id",
				"type" => "BIGINT",
				"collation" => "UNSIGNED",
			),
			array(
				"name" => "event_children",
				"type" => "BIGINT",
				"collation" => "UNSIGNED",
			),
			// non-relationship

		),
	),
	array(
		"name" => "organizations",
		"primary_key" => "id",
		"fields" => array(
			array(
				"name" => "id",
				"type" => "BIGINT",
				"collation" => "UNSIGNED",
				"null" => "NOT NULL",
				"a_i" => "AUTO_INCREMENT",
			),
			array(
				"name" => "products_children",
				"type" => "BIGINT",
				"collation" => "UNSIGNED",
			),
			// non-relationship

		),
	),
);

?>
