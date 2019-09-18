<?php
class Nse_model extends CI_Model {
	function __construct(){
		// Call the Model constructor
		parent::__construct();
		$this->load->database();
	}
	
	function insert_data($data_type, $data){
		foreach ($data as $row) {
			if (array_key_exists('date', $row)) {
				$row['date'] = date('Y-m-d', strtotime($row['date']));
			}
			//Handle shortened volumes here
			if (array_key_exists('vol', $row) && strpos($row['vol'], 'M') !== false) {
				$row['vol'] = str_replace("M", "", $row['vol']) * 1000000;
			} else {
				$row['vol'] = str_replace(",", "", $row['vol']);
			}
			$this->db->from($data_type);
			$this->db->where('isin', $row['isin']);
			if ($data_type == 'trades') {
				$this->db->where('date', $row['date']);
			}
			$query = $this->db->get();
			if ($query->num_rows() === 0) {
				$this->db->insert($data_type, $row);
			}
		}
		//$this->db->insert_batch('securities', $securities);
	}
	
	function get_data($table){
		$securities = array();
		$query = $this->db->get($table);
		return $query->result();
	}
	
	function get_securities(){
		$securities = array();
		$query = $this->db->get('securities');
		foreach ($query->result() as $row) {
			if (!in_array($row->industry, array_keys($securities))) {
				$securities[$row->industry] = array();
			}
			$securities[$row->industry][$row->security_code] = $row->name;
			asort($securities[$row->industry]);
		}
		ksort($securities);
		return $securities;
	}
	
	function get_security($code){
		$query = $this->db->get('securities');
		foreach ($query->result() as $row) {
			if ($row->security_code == $code) {
				return $row;
			}
		}
		return false;
	}
	
	function get_security_data($post){
		$security_data = array();
		$security_data['dates'] = array();
		$security_data['high'] = array();
		$security_data['low'] = array();
		$security_data['vwap'] = array();
		$security_data['vol'] = array();
		$security = $this->get_security($post['security']);
		if ($security) {
			$this->db->from('trades');
			$this->db->where('isin', $security->isin);
			$this->db->where('date BETWEEN \''.$post['start'].'\' AND \''.$post['end'].'\'');
			$this->db->order_by('date', 'ASC');
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row){
					array_push($security_data['dates'], $row->date);
					array_push($security_data['high'], floatval($row->high));
					array_push($security_data['low'], floatval($row->low));
					array_push($security_data['vwap'], floatval($row->vwap));
					array_push($security_data['vol'], floatval($row->vol));
				}
			}
		}
		return $security_data;
	}
}