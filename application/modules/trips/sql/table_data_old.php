<?php

$result = array(
	array(
		"name" => "bugs",
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
				"name" => "title",
				"type" => "character varying",
				"length" => "(100)",
				"null" => "NOT NULL",
			),
			array(
				"name" => "description",
				"type" => "text",
			),
			array(
				"name" => "priority",
				"type" => "smallint",
				"default" => "DEFAULT 0",
				"null" => "NOT NULL",
			),
			array(
				"name" => "created",
				"type" => "DATETIME",
				"null" => "NULL",
			),
			array(
				"name" => "updated",
				"type" => "DATETIME",
				"null" => "NULL",
			),
			array(
				"name" => "status_id",
				"type" => "BIGINT",
				"collation" => "UNSIGNED",
			),
			array(
				"name" => "creator_id",
				"type" => "BIGINT",
				"collation" => "UNSIGNED",
			),
			array(
				"name" => "editor_id",
				"type" => "BIGINT",
				"collation" => "UNSIGNED",
			),
		),
	),
);

?>
