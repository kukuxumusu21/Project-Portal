<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function index()
	{
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));

		$projects = $this->account_model->get_website_details();
		$data['all_projects'] = array();
		foreach ($projects as $a) 
		{
			$a_data = array();
			$a_data['title'] = $a->title;
			$a_data['website'] = $a->website;
			$a_data['description'] = $a->description;
			$a_data['picture'] = $a->picture;
			$a_data['created_at'] = $a->created_at;
			// $a_data['added_points'] = '';
			// $a_data['deducted_points'] = '';
			// $a_data['remarks'] = '';
			// $a_data['created_at'] = '';

			// foreach ($points_data as $b) 
			// {
			// 	if($b->points_id == $a->user_id) 
			// 	{
			// 		$a_data['added_points'] = $b->added_points;
			// 		$a_data['deducted_points'] = $b->deducted_points;
			// 		$a_data['remarks'] = $b->remarks;
			// 		$a_data['created_at'] = $b->created_at;
			// 	}
			// }

			$data['all_projects'][] = $a_data;
		}
		$this->load->view('components/header',$data);
		
		$this->load->view('components/index');
	}

	public function addProject()
	{
		// $this->form_validation->set_error_delimiters('<div class="field_error">', '</div>');
		// $this->form_validation->set_rules(array(
		// 	array(
		// 		'field' => 'prj_title', 
		// 		'label' => 'Title', 
		// 		'rules' => 'trim|required'
		// 	),
		// 	array(
		// 		'field' => 'prj_website', 
		// 		'label' => 'Website', 
		// 		'rules' => 'trim|required'
		// 	),
		// 	// array(
		// 	// 	'field' => 'profile_username', 
		// 	// 	'label' => 'lang:profile_username', 
		// 	// 	'rules' => 'trim|required'
		// 	// ),
		// 	array(
		// 		'field' => 'prj_description', 
		// 		'label' => 'Description', 
		// 		'rules' => 'trim|required'
		// 	),
		// ));

		// if($this->form_validation->run() === TRUE) {
		// 	if($this->check_link($this->input->post('prj_website')) === TRUE) {
		// 		$data['prj_website_err'] = 'Invalid link inputted';
		// 	}
		// 	else {
		// 		$app_data = $this->account_model->saveProject(
		// 			$this->input->post('prj_title',TRUE),
		// 			$this->input->post('prj_website',TRUE),
		// 			$this->input->post('prj_description',TRUE)
		// 		);
		// 	}
		// }
		$this->_validate();
        $data = array(
        	'app_id' => random_string('alnum',5),
            'title' => $this->input->post('prj_title'),
            'website' => $this->input->post('prj_website'),
            'description' => $this->input->post('prj_description'),
            'created_at' => mdate('%Y-%m-%d %H:%i:%s', now())
        );
        if(!empty($_FILES['picture']['name']))
        {
            $upload = $this->_do_upload();
            $data['picture'] = $upload;
        }

        $insert = $this->account_model->saveProject($data);
		echo json_encode(array("status" => TRUE));
	}

	// private function _do_upload()
	// {
	// 	// if($_FILES["picture"]["name"])
	// 	// {
	// 		// $output = '';
	// 		$config["upload_path"] = 'upload/';
	// 		$config["allowed_types"] = 'gif|jpg|png';
	// 		$config['max_size'] = 0;
	// 		$this->load->library('upload', $config);
	// 		$this->upload->initialize($config);
	// 		for($count = 0; $count<count($_FILES["picture"]["name"]); $count++)
	// 		{
	// 			$_FILES["file"]["name"] = $_FILES["picture"]["name"][$count];
	// 			$_FILES["file"]["type"] = $_FILES["picture"]["type"][$count];
	// 			$_FILES["file"]["tmp_name"] = $_FILES["picture"]["tmp_name"][$count];
	// 			$_FILES["file"]["error"] = $_FILES["picture"]["error"][$count];
	// 			$_FILES["file"]["size"] = $_FILES["picture"]["size"][$count];
	// 			if($this->upload->do_upload('picture')) {
	// 				$this->upload->data();
	// 			} else {
	// 				$data['inputerror'][] = 'picture';
	// 	            $data['error_string'][] = 'upload error: '.$this->upload->display_errors('','');    //show ajax error
	// 	            $data['status'] = FALSE;
	// 	            echo json_encode($data);
	// 	            exit();
	// 			}
	// 		}
	// 		// echo $output; 
	// 	// }
	// }
	private function _do_upload()
    {
        $config['upload_path']      = 'upload/';
        $config['allowed_types']    = 'gif|jpg|png';
        $config['max_size']         = 0;  //set max size in kb
        // $config['max_width']        = 1000;
        // $config['max_height']       = 1000;
        $config['file_name']        = round(microtime(true)*100);       //just milisecond timestamp for unique name

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('picture'))     //upload and validate
        {
            $data['inputerror'][] = 'picture';
            $data['error_string'][] = 'upload error: '.$this->upload->display_errors('','');    //show ajax error
            $data['status'] = FALSE;
            echo json_encode($data);
            exit();
        }
        return $this->upload->data('file_name');
    }

	public function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $ddata['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('prj_title') == '') {
        	$data['inputerror'][] = 'prj_title';
            $data['error_string'][] = 'Title is required';
            $data['status'] = FALSE;
        }
        if($this->input->post('prj_website') == '') {
            $data['inputerror'][] = 'prj_website';
            $data['error_string'][] = 'Link is required';
            $data['status'] = FALSE;
        } 
        if($this->input->post('prj_description') == '') {
        	$data['inputerror'][] = 'prj_description';
            $data['error_string'][] = 'Description is required';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

	function check_link($url)
	{
		$pattern = "/^((ht|f)tp(s?)\:\/\/|~/|/)?([w]{2}([\w\-]+\.)+([\w]{2,5}))(:[\d]{1,5})?/";
		if (!preg_match($pattern, $url))
		{
			return FALSE;
		}
		return TRUE;
	}
}