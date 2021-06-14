<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index() {
		$d['pesan'] = $this->db->get('pesan')->result_array();
		$this->load->view('welcome_message', $d);
	}

	public function save_pesan()
	{
		$p = $this->input->post();

		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('pesan', 'Pesan', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('konfirm', '<div class="alert alert-danger">'.validation_errors().'</div>');
		} else {
			$this->db->insert('pesan', [
				'nama'=>$p['nama'],
				'email'=>$p['email'],
				'pesan'=>$p['pesan']
			]);

			$this->session->set_flashdata('konfirm', '<div class="alert alert-success">Pesan dikirim</div>');
		}

		redirect(base_url('#contact'));
	}
}
