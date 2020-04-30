<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PlanosSaude extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Crud_model', 'Crud');
		$this->load->model('Profissionais_model', 'Profissionais');
		$this->load->model('Consultas_model', 'Consultas');
		$this->load->library( 'form_validation' );
    }
	
	
	public function index(){
		//Verificar se logado está
		if(!$this->session->userdata('ds_status')){
			redirect('Home');
		}
		
		$dadosPlanos = $this->Crud->read("tb_planosaude","ds_nome_plano");
		$tituloTabelas = array(
            "Nome do Plano", "Telefones"
        );
        $arrayView = array(
            "camada1"		=>	'telas',
            "camada2"		=>	'planoSaude',
            "pagina"		=>	'planos',
            "usuario"		=>	$this->session->userdata('ds_nome_profissional'),
            "perfil"		=>	$this->session->userdata('ds_nivel'),
			"dadosPlanos"	=>	$dadosPlanos,
			"titulosTabela"	=>	$tituloTabelas,
        );
        $this->load->view('layout',$arrayView);
	}
	
	
	public function formPlanosSaude(){
		if(!$this->session->userdata('ds_status')){
			redirect('Home');
		}
		 $arrayView = array(
            "camada1"=>'telas',
            "camada2"=>'planoSaude',
            "pagina"=>'formPlanos',
            "usuario"=>$this->session->userdata('ds_nome_profissional'),
            "perfil"=>$this->session->userdata('ds_nivel'),
        );
        $this->load->view('layout',$arrayView);
	}
	
	
	public function planosEMedicos(){
		//Verificar se logado está
		if(!$this->session->userdata('ds_status')){
			redirect('Home');
		}
		$dadosPlanos = $this->Crud->read("tb_planosaude","ds_nome_plano");
		$dadosMedicos = $this->Profissionais->listarMedicosEspecialidades();
		
		
		$tituloTabelas = array(
            "Nome do Médico", "Especialidade"
        );
        $arrayView = array(
            "camada1"		=>	'telas',
            "camada2"		=>	'planoSaude',
            "pagina"		=>	'planosEMedicos',
            "usuario"		=>	$this->session->userdata('ds_nome_profissional'),
            "perfil"		=>	$this->session->userdata('ds_nivel'),
			"dadosPlanos"	=>	$dadosPlanos,
			"dadosMedicos"	=>	$dadosMedicos,
			"titulosTabela"	=>	$tituloTabelas,
        );
        $this->load->view('layout',$arrayView);
	}
	
	
	public function encontrarMedicosPlanos(){
		$id = trim( $_POST[ 'id' ] );
		$data = $this->Consultas->listarMedicosPlanos($id);
		if(!$data){
			$data[] = array(
			'retorno'=>'false',
			);
			
		}
		jsonMe($data); 
		
		
	}
	
	public function registrarDados(){
		$acao	=	$this->input->post("action");
		
		$dadosPlanos	=	array(
			"ds_nome_plano"			=> $this->input->post("nome"),
			"ds_numero_ans"			=> $this->input->post("numeroAns"),
			"ds_telefone"			=> $this->input->post("telefone"),
		);
		
		$this->form_validation->set_rules( 'nome', 'Nome do Plano', 'required' );
		$this->form_validation->set_rules( 'numeroAns', 'Número de registro na ANS', 'required' );
		
		if ( $this->form_validation->run() == TRUE ) {
			if ( $acao == 'create' ) {
				$duplicidade = $this->Crud->readBy( "tb_planosaude", "ds_nome_plano", $this->input->post("nome"),"ds_nome_plano" );
				if ( !$duplicidade ) {
					$this->Crud->create( "tb_planosaude", $dadosPlanos );
					redirect( 'PlanosSaude' );
				} else {
					$this->session->set_flashdata( 'mensagemerror', 'Já existe um plano de saúde com esse nome cadastrado!' );
					redirect( 'PlanosSaude' );
				}
			}
			
			if ( $acao == 'update' ) {
				$this->Crud->update( "tb_planosaude", $dadosPlanos, array( "pk_id_plano" => $this->input->post( 'id' ) ) );
					redirect( 'PlanosSaude' );
			}
			
		}else{
			if($this->input->post("action")=='create'){
				$this->formPlanos();
			}else if($this->input->post("action")=='update'){
				$this->session->set_flashdata('mensagemerror', validation_errors());
				redirect('PlanosSaude');
			}
		}
	}

	public function registrarVinculoMedicoPlano(){
		
		$idPlano			=	$this->input->post("idPlano");
		$idMedico			=	$this->input->post("idMedico");
		$acao				=	$this->input->post("action");
		
		
		if($idPlano==NULL && $acao =="create"){
			$this->session->set_flashdata( 'mensagemerror', 'Não encontrei planos para registrar' );
			redirect("PlanosSaude/planosEMedicos");
		}else{
			foreach($idPlano as $plano){
				$dados = array(
					"fk_id_plano"			=>	$plano,
					"fk_id_profissional"	=>	$idMedico,
				);
				
				if($acao == "create"){
					$planoDuplicado = $this->Crud->readCond("tb_medicosplanos","fk_id_profissional",$idMedico,"fk_id_plano",$plano);
					if(!$planoDuplicado){
						$this->Crud->create( "tb_medicosplanos", $dados );
					}
				}
				
				if($acao == "delete"){
					$this->Crud->delete( "tb_medicosplanos", array( "pk_id_medicosplanos" => $plano ) );
				}
			}
			redirect("PlanosSaude/planosEMedicos");
			
		}
	}
	
	public function delete() {
		$codigo = $this->input->post( "chavePrimaria" );
		$verificarVinculoMedico 	= $this->Crud->readBy("tb_medicosplanos", "fk_id_plano",$codigo,"fk_id_plano");
		$verificarVinculoCliente 	= $this->Crud->readBy("tb_clientes", "ds_plano_saude",$codigo,"ds_plano_saude");
		
		if(!$verificarVinculoMedico|| $verificarVinculoCliente ){
			$this->Crud->delete( "tb_planosaude", array( "pk_id_plano" => $codigo ) );
			redirect("PlanosSaude");
		}else{
			$this->session->set_flashdata( 'mensagemerror', 'Não posso excluir Plano vínculados a um médico ou a clientes! Desvincule primeiro.' );
			redirect("PlanosSaude");
		}
	}
	
	
	public function listarJSON(){
		$id = trim( $_POST[ 'id' ] );
		$data = $this->Crud->readBy( "tb_planosaude", "pk_id_plano", $id, "ds_nome_plano" );
		if(!$data){
			$retorno = array(
			'retorno'=>'false',
			);
			foreach($retorno as $k=>$v){
				$data	->	$k = $v;
			}
			
		}
		jsonMe($data); 
	}
}