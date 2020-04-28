<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cargos extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Crud_model', 'crud');
		$this->load->library( 'form_validation' );
    }
	
	
	public function index(){
		//Verificar se logado está
		if(!$this->session->userdata('ds_status')){
			redirect('Home');
		}
		//carregar cargos cadastrados
		$dadosCargos = $this->crud->read("tb_cargos","ds_nome_cargo");
		
		 $tituloTabelas = array(
            "Nome do Cargo"
        );
        $arrayView = array(
            "camada1"		=>	'telas',
            "camada2"		=>	'cargos',
            "pagina"		=>	'cargos',
            "usuario"		=>	$this->session->userdata('ds_nome_profissional'),
            "perfil"		=>	$this->session->userdata('ds_nivel'),
			"dadosCargos"	=>	$dadosCargos,
			"titulosTabela"	=>	$tituloTabelas,
        );
        $this->load->view('layout',$arrayView);
	}
	
	
	public function formCargos(){
		if(!$this->session->userdata('ds_status')){
			redirect('Home');
		}
		 $arrayView = array(
            "camada1"=>'telas',
            "camada2"=>'cargos',
            "pagina"=>'formCargos',
            "usuario"=>$this->session->userdata('ds_nome_profissional'),
            "perfil"=>$this->session->userdata('ds_nivel'),
        );
        $this->load->view('layout',$arrayView);
	}
	
	
	
	public function registrarDados(){
		$acao	=	$this->input->post("action");
		
		$dadosCargos	=	array(
			"ds_nome_cargo"			=> $this->input->post("nome"),
			"ds_ativar_agenda"		=> $this->input->post("dependeAgenda"),
			"ds_registro_conselho"	=> $this->input->post("registro"),
		);
		
		$this->form_validation->set_rules( 'nome', 'Nome do Cargo', 'required' );
		$this->form_validation->set_rules( 'dependeAgenda', 'Dependência de Agenda', 'required' );
		
		if ( $this->form_validation->run() == TRUE ) {
			if ( $acao == 'create' ) {
				$duplicidade = $this->crud->readBy( "tb_cargos", "ds_nome_cargo", $this->input->post("nome"),"ds_nome_cargo" );
				if ( !$duplicidade ) {
					$this->crud->create( "tb_cargos", $dadosCargos );
					redirect( 'Cargos' );
				} else {
					$this->session->set_flashdata( 'mensagemerror', 'Já existe um cargo com esse nome cadastrado!' );
					redirect( 'Cargos' );
				}
			}
			
			if ( $acao == 'update' ) {
				$this->crud->update( "tb_cargos", $dadosCargos, array( "pk_id_cargo" => $this->input->post( 'id' ) ) );
					redirect( 'Cargos' );
			}
			
		}else{
			if($this->input->post("action")=='create'){
				$this->formCargos();
			}else if($this->input->post("action")=='update'){
				$this->session->set_flashdata('mensagemerror', validation_errors());
				redirect('Cargos');
			}
		}
	}

	
	public function delete() {
		$codigo = $this->input->post( "chavePrimaria" );
		$verificarVinculo = $this->crud->readBy("tb_profissionais", "fk_id_cargo",$codigo,"fk_id_cargo");
		if(!$verificarVinculo){
			$this->crud->delete( "tb_cargos", array( "pk_id_cargo" => $codigo ) );
			redirect("Cargos");
		}else{
			$this->session->set_flashdata( 'mensagemerror', 'Não posso excluir cargos vínculados a profissionais cadastrados!' );
			redirect("Cargos");
		}
	}
	
	
	public function listarJSON(){
		$id = trim( $_POST[ 'id' ] );
		$data = $this->crud->readBy( "tb_cargos", "pk_id_cargo", $id, "ds_nome_cargo" );
		if(!$data){
			$data = array(
			'retorno'=>'false',
			);
		}
		
		jsonMe($data);
	}
}