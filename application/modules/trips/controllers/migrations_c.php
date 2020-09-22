<?php
class Migrations_c extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	function sql()
	{
		$tables_path = APPPATH.'modules/trips/sql/tables.json';
		// include($tables_path);
		$tables = file_get_contents($tables_path);
		$tables = json_decode($tables, true);
		// $tables = json_encode($tables, JSON_PRETTY_PRINT);

		ob_start();
		foreach ($tables as $table_key => $table) {

			echo "CREATE TABLE `".$table["name"]."` "."(\n";

			foreach ($table["fields"] as $field_key => $field_value) {
				$fld = $field_value;
				if (isset($fld["name"])) {
					echo "`";
					echo $fld["name"];
					echo "` ";
				}
				if (isset($fld["type"])) {
					echo $fld["type"];
					// echo " ";
				}
				if (isset($fld["length"])) {
					echo $fld["length"];
					echo " ";
				}	else {
					echo " ";
				}
				if (isset($fld["collation"])) {
					echo $fld["collation"];
					echo " ";
				}
				if (isset($fld["default"])) {
					echo $fld["default"];
					echo " ";
				}
				if (isset($fld["null"])) {
					echo $fld["null"];
					echo " ";
				}
				if (isset($fld["comments"])) {
					echo $fld["comments"];
					echo " ";
				}
				if (isset($fld["a_i"])) {
					echo $fld["a_i"];
					echo " ";
				}
				if (isset($fld["virtuality"])) {
					echo $fld["virtuality"];
					echo " ";
				}
				echo ",\n";

			}
			if (isset($table["primary_key"])) {
				echo "PRIMARY KEY (`".$table["primary_key"]."`)\n";
			}
			echo ") ENGINE = InnoDB;\n";
			echo "\n";
		}
		?>

		<?php
		$sql = ob_get_contents();

		ob_end_clean();

		echo "<pre>";
		echo $sql;
		echo "</pre>";
	}



	function tables()
	{
		$database_path = APPPATH.'modules/trips/sql/database.json';
		// include($database_path);
		$database = file_get_contents($database_path);
		$database = json_decode($database, true);
		// $database_json = json_encode($database, JSON_PRETTY_PRINT);

		$relationships = array();
		foreach ($database as $table_key => $table_value) {
			$relationships[$table_key]["children"] = $table_value;
			$relationships[$table_key]["parents"] = array();
		}
		foreach ($relationships as $table_key => $table_value) {
			foreach ($table_value["children"] as $relative_key => $relative_value) {
				if (isset($relationships[$relative_value])) {
					array_push($relationships[$relative_value]["parents"],$table_key);
				}
			}
		}
		$relationships_json = json_encode($relationships, JSON_PRETTY_PRINT);

		$tables = array();
		$nth_table = 0;
		foreach ($relationships as $table_key => $table_value) {

			$tables[$nth_table]["name"] = $table_key;
			$tables[$nth_table]["primary_key"] = "id";
			$tables[$nth_table]["fields"][] = array(
				"name" => "id",
				"type" => "BIGINT",
				"collation" => "UNSIGNED",
				"null" => "NOT NULL",
				"a_i" => "AUTO_INCREMENT",
			);
			foreach ($table_value["children"] as $rel_key => $rel_value) {
				$rel_value = $this->grammar_singular($rel_value);
				$tables[$nth_table]["fields"][] = array(
					"name" => $rel_value."_children",
					"type" => "BIGINT",
					"collation" => "UNSIGNED",
				);
			}
			foreach ($table_value["parents"] as $rel_key => $rel_value) {
				$rel_value = $this->grammar_singular($rel_value);
				$tables[$nth_table]["fields"][] = array(
					"name" => $rel_value."_id",
					"type" => "BIGINT",
					"collation" => "UNSIGNED",
				);
			}

			$nth_table = $nth_table+1;
		}
		$tables_json = json_encode($tables, JSON_PRETTY_PRINT);


		echo "<pre>";
		echo $tables_json;
		echo "</pre>";
	}

	function endsWith( $haystack, $needle ) {
		$length = strlen( $needle );
		if( !$length ) {
			return true;
		}
		return substr( $haystack, -$length ) === $needle;
	}

	function grammar_singular( $string ) {
		if ($this->endsWith( $string, "ies" )) {
			$string = substr($string, 0, -3)."y";
		} elseif ($this->endsWith( $string, "s" )) {
			$string = substr($string, 0, -1);
		}
		return $string;
	}









}
