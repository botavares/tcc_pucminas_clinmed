<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HorariosAtendimento extends CI_Controller {
	public function __construct(){
		
		parent::__construct();
		$this->load->model('AgendaMedica_model', 'Agenda');
		$this->load->model('profissionais_model', 'Profissionais');
		$this->load->model('Crud_model', 'crud');
		$this->load->library( 'form_validation' );
    }

	
	public function index(){
		//Verificar se logado está
		if(!$this->session->userdata('ds_status')){
			redirect('Home');
		}
	
		$dados = $this->Agenda->agendaMedicaHorarios();
		$tituloTabelas = array(
        	"Médico","Matutino","Vespertino"
		);
        $arrayView = array(
            "camada1"		=>	'telas',
            "camada2"		=>	'agendaMedica',
            "pagina"		=>	'horariosAtendimento',
            "usuario"		=>	$this->session->userdata('ds_nome_usuario'),
            "perfil"		=>	$this->session->userdata('ds_nivel'),
			"dados"			=>	$dados,
			"titulosTabela"	=>	$tituloTabelas,
        );
        $this->load->view('layout',$arrayView);
	}
	
	/*====================================================
	Função: Gravar na base de dados do dia de atendimento
	Nome: createDiasAtendimento
	======================================================*/
	public function registrarHorariosAtendimento(){
		$acao = $this->input->post("action");
		$entradaMatutino	=	strtotime( $this->input->post("entradaMatutino") );
        $saidaMatutino		=	strtotime( $this->input->post("saidaMatutino") );
		$entradaVespertino	=	strtotime( $this->input->post("entradaVespertino") );
        $saidaVespertino	=	strtotime( $this->input->post("saidaVespertino") );
		$tempoConsulta		=	$this->input->post("tmpConsulta");
		
		
		
        $qtdAtendimentosManha	=	(($saidaMatutino - $entradaMatutino)/$tempoConsulta)/60%60;
		$qtdAtendimentosTarde	=	(($saidaVespertino - $entradaVespertino)/$tempoConsulta)/60%60;
		
		$dados = array(
			"fk_id_profissional" 		=>	$this->input->post("selectMedico"),
			"ds_horarioini_matutino" 	=>	$this->input->post("entradaMatutino"),
			"ds_horariofim_matutino" 	=>	$this->input->post("saidaMatutino"),
			"ds_horarioini_vespertino" 	=>	$this->input->post("entradaVespertino"),
			"ds_horariofim_vespertino" 	=>	$this->input->post("saidaVespertino"),
			"ds_tempo_consulta"			=>	$tempoConsulta,
			"ds_qtdatendmanha" 			=>	$qtdAtendimentosManha,
			"ds_qtdatendtarde" 			=>	$qtdAtendimentosTarde,
		);

		$this->form_validation->set_rules( 'selectMedico', 'Nome do médico', 'required' );
		$this->form_validation->set_rules( 'entradaMatutino', 'Entrada do Matutino', 'required' );
		$this->form_validation->set_rules( 'saidaMatutino', 'Saída do Matutino', 'required' );
		
		if($saidaMatutino <= $entradaMatutino){
			$this->form_validation->set_rules( 'saidaMatutino', 'Saída do Matutino', 
											  'greater_than_equal_to['.$this->input->post("entradaMatutino").']' );
		}
		
		$this->form_validation->set_rules( 'entradaVespertino', 'Início do Vespertino', 'required' );
		if($saidaVespertino <= $entradaVespertino){
			$this->form_validation->set_rules( 'saidaMatutino', 'Saída do Matutino', 
											  'greater_than_equal_to['.$this->input->post("entradaMatutino").']' );
		}
		
		$this->form_validation->set_rules( 'saidaVespertino', 'Fim do Vespertino', 'required' );
		$this->form_validation->set_rules( 'tmpConsulta', 'Tempo médio da consulta', 'required' );

		if ( $this->form_validation->run() == true ) {
			
			if ( $acao == 'create' ) {
				$duplicidade = $this->crud->readBy( "tb_horariosatendimento", "fk_id_profissional",
												   $this->input->post("selectMedico"),"fk_id_profissional" );
					if ( !$duplicidade ) {
						$this->crud->create( "tb_horariosatendimento", $dados );
						redirect( 'HorariosAtendimento' );
					} else {
						$this->session->set_flashdata( 'mensagemerror', 'Já existem horários cadastrados para esse médico!' );
						redirect( 'HorariosAtendimento' );
					}
			}
			if ( $acao == 'update' ) {
				$this->crud->update( "tb_horariosatendimento", $dados, array( "pk_id_horarios" => $this->input->post( 'id' ) ) );
				redirect( 'HorariosAtendimento' );
			}
		}else{
			if($this->input->post("action")=='create'){
				$this->formHorariosAtendimento();
			}else if($this->input->post("action")=='update'){
				$this->session->set_flashdata('mensagemerror', validation_errors());
				redirect('HorariosAtendimento/formHorariosAtendimento');
			}
		}
	}
	
	/*====================================================
	Função: Abrir o formulário para horários de atendimento
	Nome: formHorariosAtendimento
	======================================================*/
	public function formHorariosAtendimento(){
		if(!$this->session->userdata('ds_status')){
			redirect('Home');
		}
		$dados = $this->Agenda->medicosSemRegistroAtendimento("tb_horariosatendimento");
		if(!$dados){
			$this->session->set_flashdata( 'mensagemerror', 'Não existe novos médicos para cadastrar horários de atendimento!' );
					redirect( 'HorariosAtendimento' );
		}else{
			$arrayView = array(
			   "camada1"	=> 'telas',
			   "camada2"	=> 'agendaMedica',
			   "pagina"		=> 'formHorariosAtendimento',
			   "usuario"	=> $this->session->userdata('ds_nome_usuario'),
			   "perfil"		=> $this->session->userdata('ds_nivel'),
			   "dados" 		=> $dados
		   );
			$this->load->view('layout',$arrayView);
		}
	}
	
	/*====================================================
	Função: listar informações e retornar em json
	Nome: listarDiasAtendimento
	======================================================*/
	public function listarHorariosAtendimento(){
		$id = trim( $_POST[ 'id' ] );
		$data = $this->Agenda->horariosDoMedico($id);
		
		if(!$data){
			$jsondt = array( 
				array(
					'retorno' => 'false'
				),
			);
			echo json_encode( $jsondt );
		}else{
			jsonMe($data);
		}
	}
	
	/*====================================================
	Função: Apagar registro de uma tabela
	Nome: deletarHorariosAtendimento
	======================================================*/
	public function deletarHorariosAtendimento() {
		$codigo = $this->input->post( "chavePrimaria" );
		$this->crud->delete( "tb_horariosatendimento", array( "fk_id_profissional" => $codigo ) );
		redirect("HorariosAtendimento");
	}
	
}