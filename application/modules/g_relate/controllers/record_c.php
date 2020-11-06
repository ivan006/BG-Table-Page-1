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

		$body["overview"]["foreign_plural"] = $table;
		$body["overview"]["foreign_singular"] = $overview_table_singular;
		$record = $this->g_tbls->fetch_where($body["overview"]["foreign_plural"], "id", $record_id)["posts"][0];
		$body["overview"]["rel_name"] = $body["overview"]["foreign_singular"];
		$body["overview"]["specialty"] = "";

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

	public function relations($parent_overview, $parent_record, $dont_scan)
	{
		$rows = $this->g_tbls->table_rows($parent_overview["foreign_plural"]);
		foreach ($rows as $key => $value) {
			if ($key !== $dont_scan) {
				if ($this->g_migrate->endsWith($key, "_id")) {

					$suffix = "_id";
					$overview["rel_name"] = $this->suffix_remover($key, $suffix);

					$specialty_explode = $this->g_migrate->specialty_explode($overview["rel_name"]);

					$overview["foreign_singular"] = $specialty_explode[0];
					$overview["specialty"] = $specialty_explode[1];

					$overview["foreign_plural"] = $this->g_migrate->grammar_plural($overview["foreign_singular"]);

					if (!empty($parent_record)) {
						$haystack = "id";
						$needle = $parent_record[$overview["rel_name"]."_id"];
						$data_endpoint = "fetch_where/h/$haystack/n/$needle";

					} else {
						$data_endpoint = "";
					}


					$overview["type"] = "owner";
					$sub_rows["all"] = $this->g_tbls->table_rows($overview["foreign_plural"]);

					$sub_rows["visible"] = array();
					foreach ($sub_rows["all"] as $sub_rows_key => $sub_rows_value) {
						// if (!$this->g_migrate->endsWith($join_merge_key, "_children") && $parent_overview["foreign_singular"]."_id" !== $join_merge_key) {
						if (!$this->g_migrate->endsWith($sub_rows_key, "_children")) {
							$sub_rows["visible"][$sub_rows_key] = $sub_rows_value;
						}
					}

					$result["all"][$key] = array(
						"overview" => $overview,
						"rows" => $sub_rows,
						"data_endpoint" => $data_endpoint,
					);


				} elseif ($this->g_migrate->endsWith($key, "_children")) {

					$suffix = "_children";
					$overview["rel_name"] = $this->suffix_remover($key, $suffix);

					$specialty_explode = $this->g_migrate->specialty_explode($overview["rel_name"]);

					$overview["foreign_singular"] = $specialty_explode[0];
					$overview["specialty"] = $specialty_explode[1];

					$overview["foreign_plural"] = $this->g_migrate->grammar_plural($overview["foreign_singular"]);

					if ($this->g_migrate->endsWith($overview["foreign_plural"], "_links"))
					{


						if (!empty($parent_record)) {
							$haystack = $parent_overview["foreign_singular"]."_id";
							$needle = $parent_record["id"];
							$data_endpoint = "fetch_where/h/$haystack/n/$needle";

						} else {
							$data_endpoint = "";
						}

						$overview["type"] = "reusable_items";
						// $sub_rows = $this->g_tbls->table_rows($overview["foreign_plural"]);

						$record = array();
						// $dont_scan = $parent_overview["foreign_singular"]."_id";
						$dont_scan = "";

						$sub_rows = $this->relations($overview, $record, $dont_scan);



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
						$join["data_endpoint"] = "fetch_join_where/t/".$lookup_table["overview"]["foreign_plural"]."/h/".$parent_overview["foreign_singular"]."_id/n/".$parent_record["id"];

						$join["rows"]["visible"] = array();
						foreach ($join_merge as $join_merge_key => $join_merge_value) {
							// if (!$this->g_migrate->endsWith($join_merge_key, "_children") && $parent_overview["foreign_singular"]."_id" !== $join_merge_key) {
							if (!$this->g_migrate->endsWith($join_merge_key, "_children")) {
								$join["rows"]["visible"][$join_merge_key] = $join_merge_value;
							}
						}

						$join["rows"]["all"] = $join_merge;
						$join["overview"] = $lookup_table["overview"];

						$result["all"][$key] = array(
							"overview" => $overview,
							"rows" => $sub_rows,
							"data_endpoint" => $data_endpoint,
							"join" => $join,
						);





					} else {
						// var_dump($parent_overview);

						if (!empty($parent_record)) {
							$spec_prefix = $this->g_migrate->specialty_prefix($overview["specialty"]);
							$foreign_rel_name = $spec_prefix.$parent_overview["foreign_singular"];
							$haystack = $foreign_rel_name."_id";
							$needle = $parent_record["id"];

							$data_endpoint = "fetch_where/h/$haystack/n/$needle";

						} else {
							$data_endpoint = "";
						}
						$overview["type"] = "dedicated_items";

						$sub_rows["all"] = $this->g_tbls->table_rows($overview["foreign_plural"]);

						$sub_rows["visible"] = array();
						foreach ($sub_rows["all"] as $sub_rows_key => $sub_rows_value) {
							// if (!$this->g_migrate->endsWith($join_merge_key, "_children") && $parent_overview["foreign_singular"]."_id" !== $join_merge_key) {
							if (!$this->g_migrate->endsWith($sub_rows_key, "_children")) {
								$sub_rows["visible"][$sub_rows_key] = $sub_rows_value;
							}
						}



						$result["all"][$key] = array(
						"overview" => $overview,
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
			// if (!$this->g_migrate->endsWith($key, "_children") && $parent_overview["foreign_singular"]."_id" !== $key) {
			if (!$this->g_migrate->endsWith($key, "_children")) {
				$result["visible"][$key] = $value;
			}
		}

		return $result;

	}



	public function mergetest()
	{
		$result = $this->g_tbls->mergetest();
		header('Content-Type: application/json');
		echo json_encode($result, JSON_PRETTY_PRINT);
	}


}
