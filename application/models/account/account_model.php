<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_model extends CI_Model {	
    function create($username, /*$email = NULL,*/ $password)
	{

		$this->db->insert('a3m_account', array(
            'username' => $username, 
            'password' => md5($password), 
            'createdon' => mdate('%Y-%m-%d %H:%i:%s', now())));

		return $this->db->insert_id();
	}

	function get_website_details(){
		$data=$this->db->get('app_details');
		return $data->result();
	}

	public function saveProject($data)
	{
		// $this->db->insert('app_details', array(
		// 	'title' => $title, 
		// 	'website' => $website, 
		// 	'description' => $description, 
		// 	'created_at' => mdate('%Y-%m-%d %H:%i:%s', now())
		// ));

		// return $this->db->insert_id();
		$this->db->insert('app_details',$data);
		return $this->db->insert_id();
	}

	function save_proj($data)
	{
		$this->db->insert('app_details',$data);

		return $this->db->insert_id();
	}

	function get_by_username($username)
	{
		return $this->db->get_where('a3m_account', array('username' => $username))->row();
	}

	function get_by_username_email($username_email)
	{
		return $this->db->from('a3m_account')->where('username', $username_email)->get()->row();
	}

	function update_last_signed_in_datetime($account_id)
	{
		$this->load->helper('date');

		$this->db->update('a3m_account', array('lastsignedinon' => mdate('%Y-%m-%d %H:%i:%s', now())), array('id' => $account_id));
	}

	function get_by_id($account_id)
	{
		return $this->db->get_where('a3m_account', array('id' => $account_id))->row();
	}
}