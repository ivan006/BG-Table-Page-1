<?php
class G_migrate extends MY_Controller
{

	function __construct()
	{
		parent::__construct();

		// $this->load->helper(array('form', 'url'));
		// $this->load->library('form_validation');
	}


	function sql_three()
	{
		$sql_two_path = APPPATH.'modules/g_relate/sql/sql_two.json';
		// include($sql_two_path);
		$sql_two = file_get_contents($sql_two_path);
		$sql_two = json_decode($sql_two, true);
		// $sql_two = json_encode($sql_two, JSON_PRETTY_PRINT);

		ob_start();
		foreach ($sql_two as $table_key => $table) {

			echo "CREATE TABLE `".$table_key."` "."(\n";
			echo "`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,\n";
			foreach ($table as $field_key => $field_value) {
				$fld = $field_value;
				echo "`";
				echo $field_key;
				echo "` ";
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
			echo "PRIMARY KEY (`id`)\n";
			echo ") ENGINE = InnoDB;\n";
			echo "\n";
		}
		?>

		<?php
		$sql = ob_get_contents();

		ob_end_clean();

		return $sql;
	}

	function sql_two()
	{
		$one_path = APPPATH.'modules/g_relate/sql/one.json';
		// include($one_path);
		$one = file_get_contents($one_path);
		$one = json_decode($one, true);
		// $one_json = json_encode($one, JSON_PRETTY_PRINT);

		$relationships = $this->relationships($one);
		$relationships_json = json_encode($relationships, JSON_PRETTY_PRINT);

		// echo "<pre>";
		// echo $relationships_json;
		// exit;

		$tables = array();
		$nth_table = 0;
		foreach ($relationships as $table_key => $table_value) {

			// $tables[$table_key]["name"] = $table_key;
			// $tables[$table_key]["primary_key"] = "id";
			// $tables[$table_key][] = array(
			// 	"name" => "id",
			// 	"type" => "BIGINT",
			// 	"collation" => "UNSIGNED",
			// 	"null" => "NOT NULL",
			// 	"a_i" => "AUTO_INCREMENT",
			// );

			$tables[$table_key] = array();

			foreach ($table_value["has_many"] as $rel_key => $rel_value) {
				$rel_value = $this->grammar_singular($rel_value);
				$tables[$table_key][$rel_value."_children"] = array(
				"type" => "BIGINT",
				"collation" => "UNSIGNED",
				);
			}
			foreach ($table_value["has_one"] as $rel_key => $rel_value) {
				$rel_value = $this->grammar_singular($rel_value);
				$tables[$table_key][$rel_value."_id"] = array(
				"type" => "BIGINT",
				"collation" => "UNSIGNED",
				);
			}
			foreach ($table_value["has_many_belong_many"] as $rel_key => $rel_value) {
				$table_key_singular = $this->grammar_singular($table_key);

				$rel_value = $this->grammar_singular($rel_value);
				$link_table = array(
					$table_key_singular,
					$rel_value
				);
				sort($link_table);
				$link_table = implode("_",$link_table);
				$link_table = $link_table."_links";

				$tables[$link_table][$rel_value."_id"] = array(
				"type" => "BIGINT",
				"collation" => "UNSIGNED",
				);


				$link_table = $this->grammar_singular($link_table);
				$tables[$table_key][$link_table."_children"] = array(
				"type" => "BIGINT",
				"collation" => "UNSIGNED",
				);
			}

			$nth_table = $nth_table+1;
		}
		$tables_json = json_encode($tables, JSON_PRETTY_PRINT);


		return $tables_json;
	}

	function relationships($one)
	{

		$result = array();
		foreach ($one as $table_key => $table_value) {
			$result[$table_key]["has_many"] = $table_value;
			$result[$table_key]["has_one"] = array();
			$result[$table_key]["has_many_belong_many"] = array();
		}

		foreach ($result as $table_key => $table_value) {
			foreach ($table_value["has_many"] as $foreign_key) {
				if (isset($result[$foreign_key])) {
					$has_many_key = array_search($table_key, $result[$foreign_key]["has_many"]);

					if ($has_many_key !== false) {
						// echo $table_key." in ".$foreign_key." has_many<br>";
						array_push($result[$foreign_key]["has_many_belong_many"], $table_key);
						unset($result[$foreign_key]["has_many"][$has_many_key]);
					} else {
						array_push($result[$foreign_key]["has_one"],$table_key);
					}
				}
			}
		}

		return $result;
	}

	function model_two()
	{
		$one_path = APPPATH.'modules/g_relate/sql/one.json';
		$one = file_get_contents($one_path);
		$one = json_decode($one, true);

		$relationships = $this->relationships($one);
		$relationships_json = json_encode($relationships, JSON_PRETTY_PRINT);


		ob_start();
		// foreach ($sql_two as $table_key => $table) {
		foreach ($relationships as $table_key => $table_value) {

			echo "class ".ucfirst($this->grammar_singular($table_key)) ." extends DataMapper {\n\n";
			echo "	public \$has_one = array(\n";
			if (isset($table_value["has_one"])) {
				foreach ($table_value["has_one"] as $relative_key => $relative_value) {
					echo "		\"";
					echo $this->grammar_singular($relative_value);
					echo "\",\n";

				}
			} else {
				echo "		// code...";
			}
			echo "	);\n\n";

			echo "	public \$has_many = array(\n";
			if (isset($table_value["has_many"])) {
				foreach ($table_value["has_many"] as $relative_key => $relative_value) {
					echo "		\"";
					echo $this->grammar_singular($relative_value);
					echo "\",\n";

				}
			} else {
				echo "		// code...";
			}
			echo "	);\n\n\n";
		}
		?>

		<?php
		$result = ob_get_contents();

		ob_end_clean();


		return $result;
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

	function grammar_plural( $string ) {
		if ($this->endsWith( $string, "y" )) {
			$string = substr($string, 0, -1)."ies";
		} else {
			$string = $string."s";
		}
		return $string;
	}
}
