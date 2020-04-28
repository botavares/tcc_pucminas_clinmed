<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DiasAtendimento extends CI_Controller {
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
	
		$dados = $this->Agenda->AgendaMedicaDias();
		$diasMedico = array();
		foreach($dados as $row){
			$codMed = $row["pk_id_profissional"];
			$codDia = $row["pk_id_diasatendimento"];
			switch($row["ds_dia_semana"]){
				case 1:
					$nomeDia = "ds_segunda";
					break;
				case 2:
					$nomeDia = "ds_terca";
					break;
				case 3:
					$nomeDia = "ds_quarta";
					break;
				case 4:
					$nomeDia = "ds_quinta";
					break;
				case 5:
					$nomeDia = "ds_sexta";
					break;
			}
			
			$diasMedico[$codMed]["pk_id_profissional"] = $codMed;
			$diasMedico[$codMed]["ds_nome_profissional"] = $row["ds_nome_profissional"];
			$diasMedico[$codMed]["$nomeDia"] = $row["ds_turno_atendimento"];
		}

		$tituloTabelas = array(
        	"Médico","Segunda-Feira","Terça-Feira","Quarta-Feira","Quinta-Feira","Sexta-Feira"
		);
        $arrayView = array(
            "camada1"		=>	'telas',
            "camada2"		=>	'agendaMedica',
            "pagina"		=>	'diasAtendimento',
            "usuario"		=>	$this->session->userdata('ds_nome_usuario'),
            "perfil"		=>	$this->session->userdata('ds_nivel'),
			"dados"			=>	$diasMedico,
			"titulosTabela"	=>	$tituloTabelas,
        );
        $this->load->view('layout',$arrayView);
	}
	
	/*====================================================
	Função:	Persistir dados dos dias de atendimentos médicos
	Nome:	registrarDiasAtendimento
	======================================================*/
	public function registrarDiasAtendimento(){
			$medico		=	$this->input->post("selectMedico");
			$this->form_validation->set_rules( 'selectMedico', 'Médico', 'required' );
			if ( $this->form_validation->run() == true ) {
				for($i = 1; $i <=5 ; $i++ ){
					$diaSemana = $i;
					$turno = $this->input->post("opt-".$i);

					$dados = array(
						"fk_id_profissional"	=>	$medico,
						"ds_dia_semana"			=>	$diaSemana,
						"ds_turno_atendimento"	=>	$turno,
					);

					if($this->crud->create( "tb_diasatendimento", $dados )){

					}
				}
			}else{
				$this->session->set_flashdata('mensagemerror', validation_errors());
			}
			redirect( 'DiasAtendimento' );
	}
	/*====================================================
	Função:	Alterar dados dos dias de atendimentos médicos
	Nome:	alterarDiasAtendimento
	======================================================*/	
	public function alterarDiasAtendimento(){
		$medico		=	$this->input->post("selectMedico");
		$diaSemana	=	$this->input->post("diaSemana");
		$turno		=	$this->input->post("turno");
			$dados = array(
			"fk_id_profissional"	=>	$medico,
			"ds_dia_semana"			=>	$diaSemana,
			"ds_turno_atendimento"	=>	$turno,
		);
		$this->form_validation->set_rules( 'turno', 'turno de trabalho', 'required' );
		if ( $this->form_validation->run() == true ) {
			$this->crud->update( "tb_diasatendimento", $dados, array( "pk_id_diasatendimento" => $this->input->post( 'id' ) ) );
			redirect( 'DiasAtendimento' );
		}else{
			$this->session->set_flashdata('mensagemerror', validation_errors());
			redirect('DiasAtendimento');
		}
	}
	
	
	/*====================================================
	Função: Abrir o formulário para os dias da semana
	Nome: formDiasSemana
	Última Modificação: 03/09/2019
	======================================================*/
	public function formDiasSemana(){
		if(!$this->session->userdata('ds_status')){
			redirect('Home');
		}
		$dados = $this->Agenda->medicosSemRegistroAtendimento("tb_diasatendimento");
		if(!$dados){
			$this->session->set_flashdata( 'mensagemerror', 'Não existe novos médicos para cadastrar dias de atendimento!' );
					redirect( 'DiasAtendimento' );
		}else{
			$arrayView = array(
			   "camada1"	=> 'telas',
			   "camada2"	=> 'agendaMedica',
			   "pagina"		=> 'formDiasAtendimento',
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
	Última Modificação: 30/09/2019
	======================================================*/
	public function listarDiasAtendimento(){
		$id = trim( $_POST[ 'id' ] );
		$dia = trim( $_POST[ 'dia' ] );
		$data = $this->Agenda->diasAtendimentoDoMedico($id,$dia);
		
		if(!$data){
			$data = array(
			'retorno'=>'false',
			);
		}
		
		// jsonMe é um 'helper' criado por mim e está localizado no arquivo clinica_helper na pasta application/helpers
		jsonMe($data); 
	}
	
	/*====================================================
	Função: Apagar registro de uma tabela
	Nome: deletarDiasAtendimento
	======================================================*/
	public function deletarDiasAtendimento() {
		$codigo = $this->input->post( "chavePrimaria" );
		$this->crud->delete( "tb_diasatendimento", array( "fk_id_profissional" => $codigo ) );
		redirect("DiasAtendimento");
	}
	
	
}