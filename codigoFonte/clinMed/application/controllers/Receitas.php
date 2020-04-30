<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Receitas extends CI_Controller {
	public function __construct(){
		
		parent::__construct();
		$this->load->model('Consultas_model','Consultas');
		$this->load->model('Crud_model', 'Crud');
		$this->load->library( 'form_validation' );
	}
	
	public function consultarReceita(){
		$idReceita = trim( $_POST[ 'idReceita' ] );
		$dadosDaReceita = $this->Consultas->listarDadosReceita($idReceita);
		if($dadosDaReceita){
			jsonMe( $dadosDaReceita );
		}else{
			$jsondt[] = array( 
				'retorno' => 'false',
			);
			jsonMe( $jsondt );
		}
		
	}
	public function registrarReceita(){
		
		$idCliente			=	$this->input->post("idCliente");
		$idMedico			=	$this->input->post("idMedico");
		$tipoAtendimento	=	$this->input->post("tipoAtendimento");
		
		$numeroConsulta 	=	$this->input->post("numeroConsulta");
		$idMedicamento		=	$this->input->post("idMedicamento");
		$dataRegistro		=	date("Y-m-d");
		
		
		/*if($idConsulta == "" || $idConsulta==0){
			$this->session->set_flashdata( 'mensagemerror', 'A consulta ainda não foi gravada. Termine a consulta' );
			redirect(base_url()."Medicos/iniciarConsultas/".$idCliente.'-'.$tipoAtendimento.'-'.$numeroConsulta.'-'.$idMedico);
		}*/
		
		if($idMedicamento==NULL){
			
		}else{
			foreach($idMedicamento as $valMedicamento){
				$dados = array(
					"ds_numero_consulta"	=>	$numeroConsulta,
					"fk_id_profissional"	=>	$idMedico,
					"fk_id_cliente"			=>	$idCliente,
					"fk_id_medicamento"		=>	$valMedicamento,
					"ds_data_registro"		=>	$dataRegistro,
					
				);
				//verificar se já tem receita para essa consulta
				$receitaDuplicado = $this->Crud->readCond("tb_receitasconsultas","ds_numero_consulta",$numeroConsulta,"fk_id_medicamento",$valMedicamento);
				if(!$receitaDuplicado){
					$this->Crud->create( "tb_receitasconsultas", $dados );
				}
			}
			redirect(base_url()."Medicos/iniciarConsultas/".$idCliente.'-'.$tipoAtendimento.'-'.$numeroConsulta.'-'.$idMedico);
			
		}
	}
	
	public function excluirReceita(){
		$idMedicamento 		=	$this->uri->segment(3);
		$idConsulta 		=	$this->uri->segment(4);
		$tipoAtendimento 	=	$this->uri->segment(5);
		$idMedico			=	$this->uri->segment(6);
		
		$idCliente			= substr($idConsulta, -4);
		
		
		
		if($idMedicamento != NULL && $idConsulta != NULL){
			$this->Crud->delete( "tb_receitasconsultas", array( "fk_id_medicamento" => $idMedicamento,"ds_numero_consulta"=>$idConsulta ) );
			redirect(base_url()."Medicos/iniciarConsultas/".$idCliente.'-'.$tipoAtendimento.'-'.$idConsulta.'-'.$idMedico);
		}
	}
	
	public function imprimirReceita(){
		$numRegistroReceita = $this->uri->segment(3);
		$segundaVia 		= $this->uri->segment(4);
		
		list($numeroConsulta,$idPaciente,$idMedico) = explode("-",$numRegistroReceita);
		if($segundaVia == "true"){
			$dadosSegundaVia = array(
				"ds_numero_consulta"	=> 	$numeroConsulta,
				"fk_id_cliente"			=>	$idPaciente,
				"fk_id_profissional"	=>	$idMedico,
				"ds_nome_usuario"		=>	$this->session->userdata('ds_nome_usuario'),
				"fk_id_usuario"			=>	$this->session->userdata('pk_id_usuario'),
			);
			$this->Crud->create( "tb_impressosegundareceita", $dadosSegundaVia );
		}
		
		$dadosPaciente		=	$this->Crud->readBy("tb_clientes","pk_id_cliente",$idPaciente,"ds_nome_cliente");
		$dadosMedico		=	$this->Crud->readBy("tb_profissionais","pk_id_profissional",$idMedico,"ds_nome_profissional");
		$especialidade		=	$this->Crud->readBy("tb_especialidades","pk_id_especialidade",$dadosMedico[0]["fk_id_especialidade"],"ds_nome_especialidade");
		$receitaMedica		=	$this->Consultas->listarReceitaMedica($numeroConsulta);
		
		$dados = array(
			"brasao"				=>	FCPATH."external/img/brasao.jpg",
			"fundo"					=>	FCPATH."external/img/fundo.jpg",
			"dadosPaciente"			=>	$dadosPaciente,
			"dadosMedico"			=>	$dadosMedico,
			"especialidade"			=>	$especialidade,
			"receitaMedica"			=>	$receitaMedica,
		);
		imprimir($dados,"receita_medica","R");//"R = Retrato e P = paisagem"
	}
	
	public function registrarOrientacaoReceita(){
		$idReceita			=	$this->input->post("idReceita");
		$orientacaoReceita	=	$this->input->post("orientacaoReceita");
		$numeroConsulta		=	$this->input->post("numeroConsulta");
		$idMedico			=	$this->input->post("idMedico");
		$idCliente			=	substr($numeroConsulta, -4);
		
		if(!empty($idReceita)){
			$arrayDadosReceita = array(
				"ds_posologia"	=>	$orientacaoReceita,
			);
			
			$this->form_validation->set_rules( 'orientacaoReceita', 'Orientação da receita.', 'required' );
		}else{
			print_r("id vazio");
		}
		if ( $this->form_validation->run() == true ) {
			$this->Crud->update( "tb_receitasconsultas", $arrayDadosReceita, array( "pk_id_receita_consulta" => $idReceita) );
			redirect(base_url()."Medicos/iniciarConsultas/".$idCliente.'-'."2".'-'.$numeroConsulta.'-'.$idMedico);
			
		}		
	}
	
	public function formSegundaReceita(){
		if(!$this->session->userdata('ds_status')){
			redirect('Home');
		}
		
		$receitasExpedidas = $this->Consultas->listarReceitasExpedidas();
		
		$titulosTabela = array('Consulta','Cliente','Data da Consulta','Médico');
		
		$arrayView = array(
			"camada1"			=>	'telas',
			"camada2"			=>	'consultas',
			"pagina"			=>	'formImprimirSegundaReceita',
			"usuario"			=>	$this->session->userdata('ds_nome_usuario'),
			"perfil"			=>	$this->session->userdata('ds_nivel'),
			"titulosTabela"		=>	$titulosTabela,
			"receitasExpedidas"	=>	$receitasExpedidas,
       );
        $this->load->view('layout',$arrayView);
		
	}
}