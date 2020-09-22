<?php
class Migrations_c extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$table_data_path = APPPATH.'modules/trips/sql/table_data.php';
		include($table_data_path);

		$sql = $this->sql($result);
		echo "<pre>";
		echo $sql;
		echo "</pre>";
	}

	function sql($database_data)
	{
		ob_start();
		foreach ($database_data as $table_key => $table) {

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
		$result = ob_get_contents();

		ob_end_clean();

		return $result;



	}

	function tryecho($string)
	{
		if (isset($string)) {
			echo $string;
		}


	}

	function database_data()
	{
		// $database_data_path = APPPATH.'modules/trips/sql/database_data.php';
		// include($database_data_path);
		//
		// $array_code = $this->table_data($result);
		// echo "<pre>";
		// echo $array_code;
		// echo "</pre>";
	}

	function table_data($database_data)
	{
	}






}
