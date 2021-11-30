<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

public function __construct()
	{
		parent::__construct();
		$this->load->library('file_upload');
		$this->load->library('session');
	}
	
	public function index()
	{
		$this->load->view('welcome_message');
	}
	
	public function image_upload()
	{
		$is_upload = $this->file_upload->do_image_upload('image');
		if($is_upload['file_name'] == FALSE) //if error occured show error message
		{
			$this->session->set_flashdata('image_message', $is_upload['error']);
			redirect('welcome');
		}
		else
		{
			$this->session->set_flashdata('image_message', $is_upload);
			redirect('welcome');
		}
	}
	
	public function video_upload()
	{
		$is_upload = $this->file_upload->do_video_upload('video');
		if($is_upload['file_name'] == FALSE) //if error occured show error message
		{
			$this->session->set_flashdata('video_message', $is_upload['error']);
			redirect('welcome');
		}
		else
		{
			$this->session->set_flashdata('video_message', $is_upload);
			redirect('welcome');
		}
	}
	
	public function image_resize()
	{
		$is_upload = $this->file_upload->create_other_size($this->input->post('image_resize'));
		if($is_upload === TRUE) //if file resized
		{
			$this->session->set_flashdata('image_resize_message', 'File resized successfully');
			redirect('welcome');
		}
		else
		{
			$this->session->set_flashdata('image_resize_message', $is_upload);
			redirect('welcome');
		}
	}
	
	public function image_thumb()
	{
		$is_upload = $this->file_upload->create_thumbnail($this->input->post('image_thumb'));
		if($is_upload === TRUE) //if thumb created
		{
			$this->session->set_flashdata('image_thumb_message', 'thumbnail created successfully');
			redirect('welcome');
		}
		else
		{
			$this->session->set_flashdata('image_thumb_message', $is_upload);
			redirect('welcome');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */