<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{

    public function index()
    {
        // if ($this->authentication->is_signed_in())
		// {
			
        // }
        $data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));

        $this->load->view('components/header',$data);
        $this->load->view('home/index');
        $this->load->view('components/footer');
    }

    public function get_website_apps()
    {
        $data=$this->account_model->get_website_details();
        echo json_encode($data);
    }

    public function signIn()
    {
        $this->form_validation->set_error_delimiters('<span class="field_error">', '</span>');
		$this->form_validation->set_rules(array(
			array(
				'field' => 'si_username',
				'label' => 'Username',
				'rules' => 'trim|required'
			),
			array(
				'field' => 'si_password',
				'label' => 'Password',
				'rules' => 'trim|required'
			)
        ));
        
        if($this->form_validation->run() === TRUE)
        {
            if(!$user = $this->account_model->get_by_username_email($this->input->post('si_username', TRUE))) {
                $data['sign_in_username_err'] = 'Username does not exist';
            } else {
                $this->authentication->sign_in($user->id);
            }
        }

        $this->load->view('components/header');
        $this->load->view('components/signin');
        $this->load->view('components/footer');
    }

    public function signUp()
    {
        $this->form_validation->set_error_delimiters('<span class="field_error">', '</span>');
		$this->form_validation->set_rules(array(
			array(
				'field' => 'su_username', 
				'label' => 'Username', 
				'rules' => 'trim|required|alpha_dash|min_length[2]|max_length[24]'), 
			
			array(
				'field' => 'su_password', 
				'label' => 'Password', 
				'rules' => 'trim|required|min_length[6]')
        ));
        
        if($this->form_validation->run() === TRUE) 
        {
            if ($this->username_check($this->input->post('su_username')) === TRUE) {
				$data['su_username_err'] = 'Username is already in use!';
            } else {
                $this->account_model->create(
                    $this->input->post('su_username',TRUE),
                    $this->input->post('su_password',TRUE)
                );
                redirect('sign-in');
            }
        }

        $this->load->view('components/header');
        $this->load->view('components/signup');
        $this->load->view('components/footer');
    }

    public function signOut()
    {
        if ( ! $this->authentication->is_signed_in()) redirect('');

        $this->authentication->sign_out();
        redirect('');

    }

    public function windowsApps()
    {   
        // if ($this->authentication->is_signed_in()) {
        // }
        
        $data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
        
        $this->load->view('components/header',$data);
        $this->load->view('components/windowsapps');
        $this->load->view('components/footer');
    }

    public function websiteAppsPanel()
    {
        // if ($this->authentication->is_signed_in()) {
			
		// }
        $data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));

        $this->load->view('components/header',$data);
        $this->load->view('components/websiteapps');
        $this->load->view('components/footer');
    }

    public function websiteApps()
    {
        $this->_validate();
       
        $upload = $this->_do_upload();
        // $data['picture'] = $upload;

        $data = array(
            'website' => $this->input->post('website'),
            'description' => $this->input->post('description'),
            // 'picture' => $data['picture'] = $upload,
			'created_at' => mdate('%Y-%m-%d %H:%i:%s', now())
        );

        $result = $this->account_model->save_proj($data);
        
        echo json_encode(array("status" => TRUE));
    }

    public function photoSaved()
    {
        if ($_FILES['picture']['name'] != '')
        {
            
        }

        $result = $this->account_model->save_proj($data);
        echo json_encode(array("status" => TRUE));
    }

    public function _do_upload()
    {
        if (isset($_FILES['picture']))
        {
            $this->load->library('upload', array(
                // 'overwrite' => TRUE, 
                'upload_path' => PHOTO_FILE, 
                'allowed_types' => 'jpg|png|gif', 
                'max_size' => '0' // kilobytes
            ));

            if ( ! $this->upload->do_upload('picture')){
                $data['inputerror'][] = 'picture';
                $data['error_string'][] = 'upload error: '.$this->upload->display_errors('','');    //show ajax error
                $data['status'] = FALSE;
                echo json_encode($data);
                exit();
            } 
        //    $test = $this->upload->data('file_name');
        //    var_dump($test);
        //    die();
            return $this->upload->data('file_name');
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

    function username_check($username)
	{
		return $this->account_model->get_by_username($username) ? TRUE : FALSE;
    }
    
    public function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $ddata['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('website') == '')
        {
            $data['inputerror'][] = 'website';
            $data['error_string'][] = 'Link is required';
            $data['status'] = FALSE;
        }

        // if($this->input->post('photo') == '')
        // {
        //     $data['inputerror'][] = 'photo';
        //     $data['error_string'][] = 'Photo is required';
        //     $data['status'] = FALSE;
        // }

        if($this->input->post('description') == '')
        {
            $data['inputerror'][] = 'description';
            $data['error_string'][] = 'Description is required';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

}