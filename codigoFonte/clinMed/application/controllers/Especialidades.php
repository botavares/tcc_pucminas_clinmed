<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Especialidades extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Crud_model', 'Crud');
		$this->load->library( 'form_validation' );
    }
	
	
	public function index(){
		//Verificar se logado está
		if(!$this->session->userdata('ds_status')){
			redirect('Home');
		}
		//carregar Especialidades cadastrados
		$dadosEspecialidades = $this->Crud->read("tb_especialidades","ds_nome_especialidade");
		
		 $tituloTabelas = array(
            "Nome da Especialidade"
        );
        $arrayView = array(
            "camada1"				=>	'telas',
            "camada2"				=>	'especialidades',
            "pagina"				=>	'especialidades',
            "usuario"				=>	$this->session->userdata('ds_nome_profissional'),
            "perfil"				=>	$this->session->userdata('ds_nivel'),
			"dadosEspecialidades"	=>	$dadosEspecialidades,
			"titulosTabela"			=>	$tituloTabelas,
        );
        $this->load->view('layout',$arrayView);
	}
	
	
	public function formEspecialidades(){
		if(!$this->session->userdata('ds_status')){
			redirect('Home');
		}
		 $arrayView = array(
            "camada1"=>'telas',
            "camada2"=>'especialidades',
            "pagina"=>'formEspecialidades',
            "usuario"=>$this->session->userdata('ds_nome_profissional'),
            "perfil"=>$this->session->userdata('ds_nivel'),
        );
        $this->load->view('layout',$arrayView);
	}
	
	
	
	public function registrarDados(){
		$acao	=	$this->input->post("action");
		
		$dadosEspecialidades	=	array(
			"ds_nome_especialidade"			=> $this->input->post("nome"),
			
		);
		
		$this->form_validation->set_rules( 'nome', 'Nome da Especialidade', 'required' );
		
		
		if ( $this->form_validation->run() == TRUE ) {
			if ( $acao == 'create' ) {
				$duplicidade = $this->Crud->readBy( "tb_especialidades", "ds_nome_especialidade", $this->input->post("nome"),"ds_nome_especialidade" );
				if ( !$duplicidade ) {
					$this->Crud->create( "tb_especialidades", $dadosEspecialidades );
					redirect( 'Especialidades');
				} else {
					$this->session->set_flashdata( 'mensagemerror', 'Já existe uma especialidade com esse nome cadastrado!' );
					redirect( 'Especialidades');
				}
			}
			
			if ( $acao == 'update' ) {
				$this->Crud->update( "tb_especialidades", $dadosEspecialidades, array( "pk_id_especialidade" => $this->input->post( 'id' ) ) );
					redirect( 'Especialidades');
			}
			
		}else{
			if($this->input->post("action")=='create'){
				$this->formEspecialidades();
			}else if($this->input->post("action")=='update'){
				$this->session->set_flashdata('mensagemerror', validation_errors());
				redirect('Especialidades');
			}
		}
	}

	
	public function delete() {
		$codigo = $this->input->post( "chavePrimaria" );
		$verificarVinculo = $this->Crud->readBy("tb_profissionais", "fk_id_especialidade",$codigo,"fk_id_especialidade");
		if(!$verificarVinculo){
			$this->Crud->delete( "tb_especialidades", array( "pk_id_especialidade" => $codigo ) );
			redirect("Especialidades");
		}else{
			$this->session->set_flashdata( 'mensagemerror', 'Não posso excluir especialidade vínculados a profissionais cadastrados!' );
			redirect("Especialidades");
		}
	}
	
	
	public function listarJSON(){
		$id = trim( $_POST[ 'id' ] );
		$data = $this->Crud->readBy( "tb_especialidades", "pk_id_especialidade", $id, "ds_nome_especialidade" );
		if(!$data){
			$data = array(
			'retorno'=>'false',
			);
		}
		
		jsonMe($data);
	}
}