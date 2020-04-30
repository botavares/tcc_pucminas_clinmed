<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct(){
		
		parent::__construct();
		
    }

	
	public function index(){
	
		$arrayView	=	array(
			"camada1"	=>	'telas',
			"camada2"	=>	'login',
			"pagina"	=>	'login',
		);
		$this->load->view('layoutLogin',$arrayView);
	}
	
	/*=================================================
		Função: Iniciar a área de trabalho
		09/01/2018
	==================================================*/
	public function iniciar(){
		
		if(!$this->session->userdata('ds_status')){
			redirect('Home');
		}
		
		$arrayView	=	array(
				"camada1"	=>	'telas',
				"camada2"	=>	'',
				"pagina"	=>	'principal',
				"usuario"	=>	$this->session->userdata('ds_nome_profissional'),
			);
			$this->load->view('layout',$arrayView);
	}
	
}
