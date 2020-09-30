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
		$data['rows'] = $this->g_tbls->table_rows($table);
		$data['table'] = $table;
		$data["record_id"] = $record_id;
		$table_singular = $this->g_migrate->grammar_singular($table);
		$data['title'] = $table_singular." ".$record_id;



		// header('Content-Type: application/json');
		// echo json_encode($data['rows']);
		// exit;

		$children_groups = $this->relationships($data['rows'], "_children");
		$parent_groups = $this->relationships($data['rows'], "_id");


		$this->load->view('table_header_v', $data);

		$data["group_name"] = "overview";
		$haystack = "id";
		$data["table_fetch"] = "fetch_where/h/$haystack/n/$record_id";
		$this->load->view('table_block_v', $data);

		foreach ($children_groups as $key => $value) {

			
			$needle = $record_id;
			$haystack = $value['table_singular']."_id";
			$group_name = $table_singular."_childlren";

			$data = $this->table_data($value, $group_name, $needle, $haystack);


			$this->load->view('table_block_v', $data);
		}

		$overview_haystack = "id";
		$overview_needle = $record_id;
		$overview = $this->g_tbls->fetch_where($table, $overview_haystack, $overview_needle)["posts"][0];

		foreach ($parent_groups as $key => $value) {

			$needle = $overview[$value['foreign_key']];
			$haystack = "id";
			$group_name = $value['table_singular']."_parent";

			$data = $this->table_data($value, $group_name, $needle, $haystack);

			$this->load->view('table_block_v', $data);
		}

		$this->load->view('table_footer_v');

	}

	public function relationships($rows, $suffix)
	{

		$result = array();
		foreach ($rows as $key => $value) {
			if ($this->g_migrate->endsWith($value, $suffix)) {
				$suffix_strlen = strlen($suffix);
				$value_singular = substr($value, 0, -$suffix_strlen);
				$relation_table = $this->g_migrate->grammar_plural($value_singular);
				$result[$key]['table'] = $relation_table;
				$result[$key]['table_singular'] = $value_singular;
				$result[$key]['foreign_key'] = $value;
			}
		}
		return $result;

	}

	public function table_data($relationship_group, $group_name, $needle, $haystack)
	{

		$data = array();
		$data['rows'] = $this->g_tbls->table_rows($relationship_group['table']);
		$data['table'] = $relationship_group['table'];
		$data['group_name'] = $group_name;
		$data["table_fetch"] = "fetch_where/h/$haystack/n/$needle";
		return $data;

	}


}
