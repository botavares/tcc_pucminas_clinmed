<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exames extends CI_Controller {
	public function __construct(){
		
		parent::__construct();
		$this->load->model('Consultas_model','Consultas');
		$this->load->model('Crud_model', 'Crud');
		$this->load->library( 'form_validation' );
	}
	
	
	public function formRecebimentoExame(){
		if(!$this->session->userdata('ds_status')){
			redirect('Home');
		}
		
		//pegar pacientes do médico que tem consultas em atendimento 1
		$idMedico = $this->session->userdata('fk_id_profissional');
		$examesAbertos = $this->Consultas->listarexamesAbertos($idMedico);
		$titulosTabela = array('Consulta','Cliente','Data','Forma de recebimento');
		
		$arrayView = array(
			"camada1"			=>	'telas',
			"camada2"			=>	'consultas',
			"pagina"			=>	'recebimentoExames',
			"usuario"			=>	$this->session->userdata('ds_nome_usuario'),
			"perfil"			=>	$this->session->userdata('ds_nivel'),
			"titulosTabela"		=>	$titulosTabela,
			"examesAbertos"		=>	$examesAbertos,
       );
        $this->load->view('layout',$arrayView);
	}
	
	public function registrarRecebimentoExame(){
		
		$numeroConsulta 	=	$this->input->post("numeroConsulta");
		$idPaciente 		=	$this->input->post("idPaciente");
		$idMedico			=	$this->input->post("idMedico");
		$dataRecebimento	=	$this->input->post("dataRecebimento");
		$origemRecebimento	=	$this->input->post("origemRecebimento");
		$status 			= 	"2";
		
		if($origemRecebimento == 1){
			$arquivo 			=	$_FILES["postarArquivo"]["name"];
			$caminhoReal 		=	realpath($_FILES["postarArquivo"]["tmp_name"]);
			$caminhoServidor 	=	"/var/www/hp/portal/documentos/";
			$host				=	"10.1.1.20";
			$user				=	"hp";
			$pass				=	"hp400";
			$novoNome 			= 	$numeroConsulta.'.pdf';
			$caminhoArquivo		=	"http://177.69.246.150/portal/documentos/".$novoNome;
		}else{
			$caminhoArquivo		=	"";
		}
		$redirect 			=	"Exames/formRecebimentoExame";if(!$this->session->userdata('ds_status')){
			redirect('Home');
		}
		
		
		
		$dadosRecebimentoExame = array(
			"ds_numero_consulta"	=>	$numeroConsulta,
			"fk_id_cliente"			=>	$idPaciente,
			"fk_id_medico"			=>	$idMedico,
			"ds_data_recebimento"	=>	$dataRecebimento,
			"ds_origem_recebimento"	=>	$origemRecebimento,
			"ds_caminho_arquivo"	=>	$caminhoArquivo,
			"ds_status"				=>	$status,
		);
		$this->form_validation->set_rules( 'origemRecebimento', 'Origem do recebimento do email', 'required' );
		
		if ( $this->form_validation->run() == true ) {
			
			$this->Crud->create( "tb_recebimentoexames", $dadosRecebimentoExame );
			if($origemRecebimento == 1){
            	postFile($host,$user,$pass,$caminhoServidor,$caminhoReal,$arquivo,$novoNome,$redirect);
			}
			redirect($redirect);

			
			/*
			$caminhoServidor = "/var/www/hp/portal/clinmed/external/doc/exames";
			$host	=	"10.1.1.22";
			$user	=	"pagina";
			$pass	=	"paginahp400";
			*/
			
		}
		
		
	}
	
	
	public function registrarExames(){
		
		$idCliente			=	$this->input->post("idCliente");
		$idMedico			=	$this->input->post("idMedico");
		$tipoAtendimento	=	$this->input->post("tipoAtendimento");
		
		$numeroConsulta 	=	$this->input->post("numeroConsulta");
		$idExames			=	$this->input->post("idExame");
		$dataRegistro		=	date("Y-m-d");
		if($idExames==NULL){
			//redirect("Medicos/iniciarConsultas/".$idCliente.'-'.$tipoAtendimento.'-'.$idConsulta);
			var_dump("Tá vazio");
		}else{
			foreach($idExames as $valExame){
				$dados = array(
					"ds_numero_consulta"	=>	$numeroConsulta,
					"fk_id_exame"			=>	$valExame,
					"ds_resultado_exame"	=>	"",
					"ds_data_registro"		=>	$dataRegistro,
				);
				//verificar se já tem exame para essa consulta
				$exameDuplicado = $this->Crud->readCond("tb_examesconsultas","ds_numero_consulta",$numeroConsulta,"fk_id_exame",$valExame);
				if(!$exameDuplicado){
					$this->Crud->create( "tb_examesconsultas", $dados );
				}
			}
			redirect("Medicos/iniciarConsultas/".$idCliente.'-'.$tipoAtendimento.'-'.$numeroConsulta.'-'.$idMedico);
			//$this->iniciarConsultas($idCliente.'-'.$tipoAtendimento.'-'.$numeroConsulta.'-'.$idMedico);
			
		}
	}
	
	public function registrarResultadoExame(){
		$idPedidoExame	=	$this->input->post("idPedidoExame");
		$resultadoExame	=	$this->input->post("resultadoExame");
		$numeroConsulta	=	$this->input->post("numeroConsulta");
		$idMedico		=	$this->input->post("idMedico");
		$idCliente		=	substr($numeroConsulta, -4);
		
		if(!empty($idPedidoExame)){
			$arrayDadosResultados = array(
				"ds_resultado_exame"	=>	$resultadoExame,
			);
			
			$this->form_validation->set_rules( 'resultadoExame', 'O resultado do exame é obrigatório.', 'required' );
			
		}else{
			print_r("id vazio");
		}
		if ( $this->form_validation->run() == true ) {
			$this->Crud->update( "tb_examesconsultas", $arrayDadosResultados, array( "pk_id_exameconsulta" => $idPedidoExame) );
			redirect("Medicos/iniciarConsultas/".$idCliente.'-'.'2'.'-'.$numeroConsulta.'-'.$idMedico);
			//$this->iniciarConsultas($idCliente.'-'.'2'.'-'.$numeroConsulta.'-'.$idMedico);
		}		
	}
	
	
	public function consultarExames(){
		$idExame = trim( $_POST[ 'idExame' ] );
		$dadosDoExame = $this->Consultas->listarDadosExames($idExame);
		if($dadosDoExame){
			jsonMe( $dadosDoExame );
		}else{
			$jsondt[] = array( 
				'retorno' => 'false',
			);
			jsonMe( $jsondt );
		}
		
	}
	
	public function excluirExame(){
		$idExame 			= $this->uri->segment(3);
		$idConsulta 		= $this->uri->segment(4);
		$tipoAtendimento 	= $this->uri->segment(5);
		$idMedico 			= $this->uri->segment(6);
		
		$idCliente	= substr($idConsulta, -4);
		
		if($idExame != NULL && $idConsulta != NULL){
			$this->Crud->delete( "tb_examesconsultas", array( "fk_id_exame" => $idExame,"ds_numero_consulta"=>$idConsulta ) );
			redirect("Medicos/iniciarConsultas/".$idCliente.'-'.$tipoAtendimento.'-'.$idConsulta.'-'.$idMedico);
		}
	}
	
	public function imprimirExames(){
		$numRegistroExames = $this->uri->segment(3);
		list($numeroConsulta,$idPaciente,$idMedico) = explode("-",$numRegistroExames);
		
		$dadosPaciente		=	$this->Crud->readBy("tb_clientes","pk_id_cliente",$idPaciente,"ds_nome_cliente");
		$dadosMedico		=	$this->Crud->readBy("tb_profissionais","pk_id_profissional",$idMedico,"ds_nome_profissional");
		$especialidade		=	$this->Crud->readBy("tb_especialidades","pk_id_especialidade",$dadosMedico[0]["fk_id_especialidade"],"ds_nome_especialidade");
		$exameMedico		=	$this->Consultas->listarExamesMedico($numeroConsulta);
		
		$dados = array(
			"brasao"				=>	FCPATH."external/img/brasao.jpg",
			"fundo"					=>	FCPATH."external/img/fundo.jpg",
			"dadosPaciente"			=>	$dadosPaciente,
			"dadosMedico"			=>	$dadosMedico,
			"especialidade"			=>	$especialidade,
			"exameMedico"			=>	$exameMedico,
		);
		imprimir($dados,"exame_medico","R");//"R = Retrato e P = paisagem"
	}
	
	
	
}