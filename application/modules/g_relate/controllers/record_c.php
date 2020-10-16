<?php
class Record_c extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		// $this->load->model('trip');
		// $this->load->library('../modules/trips/controllers/g_tbls');
		$this->load->library('g_tbls');
		$this->load->library('g_migrate');
	}

	public function index($table, $record_id)
	{
		$overview_table_singular = $this->g_migrate->grammar_singular($table);


		$header["title"] = $overview_table_singular." ".$record_id;
		$body = array();
		$body["overview"]["plural"] = $table;
		$body["overview"]["singular"] = $overview_table_singular;
		$record = $this->g_tbls->fetch_where($body["overview"]["plural"], "id", $record_id)["posts"][0];

		$haystack = "id";
		$needle = $record_id;
		$body["data_endpoint"] = "fetch_where/h/$haystack/n/$needle";
		$body["overview"]["type"] = "overview";
		$dont_scan = "";

		$body["rows"] = $this->relations($body["overview"], $record, $dont_scan);


		// header('Content-Type: application/json');
		// echo json_encode($body, JSON_PRETTY_PRINT);
		// exit;





		$this->load->view('table_header_v', $header);
		$this->load->view('table_block_v', $body);

		foreach ($body["rows"]["all"] as $key => $value) {
			if (!empty($value)) {
				// code...
				$this->load->view('table_block_v', $value);
			}
		}
		$this->load->view('table_footer_v');

	}


	public function suffix_remover($value, $suffix)
	{

		$suffix_strlen = strlen($suffix);
		$result = substr($value, 0, -$suffix_strlen);
		return $result;

	}

	public function specialty_explode($haystack)
	{


		$needle = "/(.*?)_specialty_(.*)/i";
		$check_match = preg_match($needle, $haystack, $reg_results);
		if ($check_match) {
			$result = array(
				$reg_results[2],
				$reg_results[1]
			);
		} else {
			$result = array(
				$haystack,
				""
			);
		}
		return $result;

	}

	public function specialty_implode($specialty, $table)
	{
		if ($specialty !== "") {
			$result = $specialty."_specialty_".$table;
		} else {
			$result = $table;
		}
		return $result;

	}

	public function relations($parent_name, $parent_record, $dont_scan)
	{
		$rows = $this->g_tbls->table_rows($parent_name["plural"]);
		foreach ($rows as $key => $value) {
			if ($key !== $dont_scan) {
				if ($this->g_migrate->endsWith($key, "_id")) {

					$suffix = "_id";
					$name["singular"] = $this->suffix_remover($key, $suffix);

					$specialty_explode = $this->specialty_explode($name["singular"]);

					$name["singular"] = $specialty_explode[0];
					$specialty = $specialty_explode[1];

					$rel_name = $this->specialty_implode($specialty, $name["singular"]);

					// var_dump($specialty);
					// var_dump($name["singular"]);
					// var_dump($rel_name);

					$name["plural"] = $this->g_migrate->grammar_plural($name["singular"]);

					if (!empty($parent_record)) {
						$haystack = "id";
						$needle = $parent_record[$rel_name."_id"];
						$data_endpoint = "fetch_where/h/$haystack/n/$needle";

					} else {
						$data_endpoint = "";
					}


					$name["type"] = "owner";
					$sub_rows["all"] = $this->g_tbls->table_rows($name["plural"]);

					$sub_rows["visible"] = array();
					foreach ($sub_rows["all"] as $sub_rows_key => $sub_rows_value) {
						// if (!$this->g_migrate->endsWith($join_merge_key, "_children") && $parent_name["singular"]."_id" !== $join_merge_key) {
						if (!$this->g_migrate->endsWith($sub_rows_key, "_children")) {
							$sub_rows["visible"][$sub_rows_key] = $sub_rows_value;
						}
					}

					$result["all"][$key] = array(
						"overview" => $name,
						"rows" => $sub_rows,
						"data_endpoint" => $data_endpoint,
					);


				} elseif ($this->g_migrate->endsWith($key, "_children")) {

					$suffix = "_children";
					$name["singular"] = $this->suffix_remover($key, $suffix);

					$name["plural"] = $this->g_migrate->grammar_plural($name["singular"]);

					if ($this->g_migrate->endsWith($name["plural"], "_links")) {


						if (!empty($parent_record)) {
							$haystack = $parent_name["singular"]."_id";
							$needle = $parent_record["id"];
							$data_endpoint = "fetch_where/h/$haystack/n/$needle";

						} else {
							$data_endpoint = "";
						}

						$name["type"] = "reusable_items";
						// $sub_rows = $this->g_tbls->table_rows($name["plural"]);

						$record = array();
						$dont_scan = $parent_name["singular"]."_id";

						$sub_rows = $this->relations($name, $record, $dont_scan);



						$lookup_table = array();
						$rel_rows = array();
						foreach ($sub_rows["all"] as $sub_row_key => $sub_row_value) {
							if (!empty($sub_row_value)) {
								$rel_rows[] = $sub_row_value;
							}
						}
						if (!empty($rel_rows)) {
							$lookup_table = $rel_rows[0];
						}

						$join["lookup"] = $lookup_table;
						$join_merge = array_merge(array_keys($lookup_table["rows"]["all"]), array_keys($sub_rows["all"]));
						$join_merge = array_unique($join_merge);
						$join_merge = array_flip($join_merge);
						foreach ($join_merge as $join_merge_key => $join_merge_value) {
							$join_merge[$join_merge_key] = array();
						}

						// $join["join"] = $join_merge;
						$join["data_endpoint"] = "fetch_join_where/t/".$lookup_table["overview"]["plural"]."\/h/".$parent_name["singular"]."_id/n/".$parent_record["id"];

						$join["rows"]["visible"] = array();
						foreach ($join_merge as $join_merge_key => $join_merge_value) {
							// if (!$this->g_migrate->endsWith($join_merge_key, "_children") && $parent_name["singular"]."_id" !== $join_merge_key) {
							if (!$this->g_migrate->endsWith($join_merge_key, "_children")) {
								$join["rows"]["visible"][$join_merge_key] = $join_merge_value;
							}
						}

						$join["rows"]["all"] = $join_merge;
						$join["overview"] = $lookup_table["overview"];

						$result["all"][$key] = array(
							"overview" => $name,
							"rows" => $sub_rows,
							"data_endpoint" => $data_endpoint,
							"join" => $join,
						);





					} else {

						if (!empty($parent_record)) {
							$haystack = $parent_name["singular"]."_id";
							$needle = $record_id;

							$data = "fetch_where/h/$haystack/n/$needle";

						} else {
							$data_endpoint = "";
						}
						$name["type"] = "dedicated_items";

						$sub_rows["all"] = $this->g_tbls->table_rows($name["plural"]);

						$sub_rows["visible"] = array();
						foreach ($sub_rows["all"] as $sub_rows_key => $sub_rows_value) {
							// if (!$this->g_migrate->endsWith($join_merge_key, "_children") && $parent_name["singular"]."_id" !== $join_merge_key) {
							if (!$this->g_migrate->endsWith($sub_rows_key, "_children")) {
								$sub_rows["visible"][$sub_rows_key] = $sub_rows_value;
							}
						}



						$result["all"][$key] = array(
						"overview" => $name,
						"rows" => $sub_rows,
						"data_endpoint" => $data_endpoint,
						);

					}
				}
			} else {
				$result["all"][$key] = array();
			}
		}

		$result["visible"] = array();
		foreach ($rows as $key => $value) {
			// if (!$this->g_migrate->endsWith($key, "_children") && $parent_name["singular"]."_id" !== $key) {
			if (!$this->g_migrate->endsWith($key, "_children")) {
				$result["visible"][$key] = $value;
			}
		}

		return $result;

	}


}
