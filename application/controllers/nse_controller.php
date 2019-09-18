<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set('auto_detect_line_endings', TRUE);

class Nse_controller extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('functions');
		$this->load->helper(array('form', 'url', 'functions'));
		$this->load->model('nse_model');
	}

	public function index($type="price", $security_code="", $start="", $end=""){
		$types = array(
				"price",
				"volume"
		);

		if (!in_array($type, $types)) {
			show_404();
		}

		$data = array();
		$data['securities'] = $this->nse_model->get_securities();
		$data['type'] = $type;
		$data['company'] = $security_code;
		$data['start'] = $start;
		$data['end'] = $end;
		$data['title'] = "NSE Securities Performance";

		$this->load->view('templates/header', $data);

		$company = $this->nse_model->get_security($security_code);
		if ($company && $security_code != "") {
			$data['industry'] = $company->industry;
			$data['name'] = $company->name;
			$data['security_data'] = $this->nse_model->get_security_data(array('security'=>$company->security_code, 'start'=>$start,'end'=>$end));

			$this->load->view($type."_widget", $data);
		}
		$this->load->view('templates/footer', $data);
	}

	public function widget($security, $start="", $end="") {
		$data = array();
		$isin = false;
		$data['security_name'] = "";
		if ($start != "") {
			$start_date = new DateTime("@$start");
			$start = $start_date->format("Y-m-d");
			if ($end != "") {
				$end_date = new DateTime("@$end");
				$end = $end_date->format("Y-m-d");
			} else {
				$end = date("Y-m-d");
			}
		} else {
			$start = date("Y-m-d", strtotime("-6 months"));
			$end = date("Y-m-d");
		}
		//$start = ($start == "") ? date("Y-m-d", strtotime("-6 months")) : date_format(date_create($start), "Y-m-d");
		//$end = ($end == "") ? date("Y-m-d") : date_format(date_create($end), "Y-m-d");
		$securities =  $this->nse_model->get_data('securities');
		$securities_array = array();
		foreach ($securities as $row) {
			if ($row->security_code == $security) {
				$isin = $row->isin;
				$data['security_name'] = $row->name;
				break;
			}
		}
		if (!$isin) {
			show_404();
		}

		$data['security_data'] = $this->nse_model->get_security_data(array('isin'=>$isin, 'start'=>$start,'end'=>$end));
		$this->load->view('volumes_widget', $data);
	}

	public function insert($data_type){
		//create associative array of data to insert
		if (file_exists("resources/data/$data_type.csv" )) {
			${$data_type} = array_map("str_getcsv", file("resources/data/$data_type.csv", FILE_SKIP_EMPTY_LINES));
			$keys = array_shift(${$data_type});
			foreach (${$data_type} as $i=>$row) {
				${$data_type}[$i] = array_combine($keys, $row);
			}
			$this->nse_model->insert_data($data_type, ${$data_type});
		}
		$this->index();
	}

	public function insert_scrapped(){
		//get list of files in scrapped directory
		$scrapped_files = array_diff(scandir("resources/data/scrapped"), array('..', '.'));

		//first parse securities data for associating ISINs
		$securities = array_map("str_getcsv", file("resources/data/shares.csv", FILE_SKIP_EMPTY_LINES));
		$keys = array_shift($securities);
		foreach ($securities as $i=>$row){
			$securities[$i] = array_combine($keys, $row);
		}

		//parse data in directory
		foreach ($scrapped_files as $file) {
			$trades = array();
			$scrapped_data = array_map("str_getcsv", file("resources/data/scrapped/$file", FILE_SKIP_EMPTY_LINES));
			$scrapped_data_keys = array_shift($scrapped_data);
			foreach ($scrapped_data as $i=>$row) {
				array_pop($row);
				//print_r($row);echo count(array_unique($row))."<br>";
				if (count(array_unique($row)) > 1) {
					$scrapped_data[$i] = array_combine($scrapped_data_keys, $row);

					$isin = "";
					foreach ($securities as $security) {
						if ($security['security_code'] == $scrapped_data[$i]['CODE']) {
							//extract relevant columns to use in trades
							array_push($trades, array(
									"isin" => $security['isin'],
									"date" => explode(".", $file)[0],
									"high" => $scrapped_data[$i]['High'],
									"low" => $scrapped_data[$i]['Low'],
									"vwap" => $scrapped_data[$i]['Price'],
									"vol" => $scrapped_data[$i]['Volume']
							));
						}
					}
				} else {
					unset($scrapped_data[$i]);
				}
			}
			$this->nse_model->insert_data("trades", $trades);
		}

		//create associative array of data to insert
		/*if(file_exists("resources/data/$data_type.csv" )){
			${$data_type} = array_map("str_getcsv", file("resources/data/$data_type.csv", FILE_SKIP_EMPTY_LINES));
			$keys = array_shift(${$data_type});
			foreach (${$data_type} as $i=>$row){
				${$data_type}[$i] = array_combine($keys, $row);
			}
			$this->nse_model->insert_data($data_type, ${$data_type});
		}
		$this->index();*/
	}

	public function security_data(){
		$output = array();

		if (!empty($this->input->post())) {
			$output = $this->nse_model->get_security_data($this->input->post());
			//print_r($output);
		}

		$this->output
		->set_header('Access-Control-Allow-Origin: *')
		->set_header('Access-Control-Allow-Methods: GET')
		->set_header('Pragma: no-cache')
		->set_header('Access-Control-Allow-Credentials: true')
		->set_header('Access-Control-Allow-Headers:X-Requested-With, authorization')
		->set_content_type('text/json')
		->set_content_type('application/json')
		->set_output(json_encode($output));
	}
}
