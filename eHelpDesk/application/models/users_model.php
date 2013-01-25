<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//Eventhough its already loaded within tank_auth, sometimes we need
//to call one of our model's method, e.g. read(), to check an existence
//of a specific record or so
class Users_model extends MY_Model {
	
	function __construct() {
	
		parent::__construct();
		
	}
	
	//Since users table modified column is updated by default, i had to override update() to remove handling update column
	public function update($where, $new_values)
	{
		$this->db->where($where)->update($this->_table, $new_values);
		return (($this->db->affected_rows() > 0) ? $this->db->affected_rows() : FALSE);	
	}
}
