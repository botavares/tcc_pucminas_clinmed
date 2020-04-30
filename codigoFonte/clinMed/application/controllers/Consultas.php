<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consultas extends CI_Controller {
	public function __construct(){
		
		parent::__construct();
		$this->load->model('AgendaMedica_model', 'Agenda');
		$this->load->model('Profissionais_model', 'Profissionais');
		$this->load->model('Clientes_model', 'Clientes');
		$this->load->model('Consultas_model','Consultas');
		$this->load->model('Crud_model', 'Crud');
		$this->load->library( 'form_validation' );
    }

	
	public function formAtendimentoConsultas(){
		if(!$this->session->userdata('ds_status')){
			redirect('Home');
		}
		
		$medico 		=	$this->session->userdata('fk_id_profissional');
		$dadosDoMedico	=	$this->Profissionais->listarProfissionaisById($medico);
		$diaAtual		=	date('Y-m-d');
		
		
		if($this->uri->segment(3) == 2){
			$relacaoConsultas	=	$this->Agenda->consultasFinalizadasPorMedico($medico);
			$pagina 			= "consultasFinalizadas";
		}else{
			$relacaoConsultas	=	$this->Agenda->atendimentosDeHojePorMedico($medico,$diaAtual);
			$pagina 			= "atendimentoConsultas";
		}
		
		
		//clientes do médico para serem atendidos no dia:
		
		
		
		
		$titulosTabela = array('Cliente','Dia','Horário','Consulta/Retorno','Plano');
		
		$arrayView = array(
			"camada1"			=>	'telas',
			"camada2"			=>	'consultas',
			"pagina"			=>	$pagina,
			"usuario"			=>	$this->session->userdata('ds_nome_usuario'),
			"perfil"			=>	$this->session->userdata('ds_nivel'),
			"titulosTabela"		=>	$titulosTabela,
			"dadosDoMedico"		=>	$dadosDoMedico,
			"relacaoConsultas"	=>	$relacaoConsultas,
       );
        $this->load->view('layout',$arrayView);
	}
	
	/*=======================================================*/
	
	public function iniciarConsultas($registroConsulta=NULL){
		if(!$this->session->userdata('ds_status')){
			redirect('Home');
		}
		
		
		if($registroConsulta == ""){
			$numRegistroConsulta	=	$this->uri->segment(3);
		}else{
			$numRegistroConsulta	=	$registroConsulta;
			
		}
		
		list($idCliente,$tipoAtendimento,$idConsultaRecuperada,$idMedico) = explode("-",$numRegistroConsulta);
		$totalConsultasCliente 	=	$this->Crud->contarRegistros("tb_consultas","fk_id_cliente = ".$idCliente);
		
		$dadosDoMedico			=	$this->Crud->readBy("tb_profissionais","pk_id_profissional",$idMedico);
		$relacaoDeExamesMedico	=	$this->Crud->readORCond("tb_exames","fk_id_especialidade",$dadosDoMedico[0]["fk_id_especialidade"],"fk_id_especialidade","99","ds_nome_exame");
		
		
		
		$relacaoDeMedicamentos = $this->Crud->readORCond("tb_medicamentos","fk_id_especialidade",$dadosDoMedico[0]["fk_id_especialidade"],"fk_id_especialidade","99","ds_nome_Medicamento");
		
		//RECUPERAR EXAMES MÉDICOS CASO ESSA CONSULTA POSSUA
		$examesDaConsulta = $this->Consultas->listarExamesMedico($idConsultaRecuperada);
		//RECUPERAR RECEITAS CASO ESSA CONSULTA POSSUA
		$medicamentosDaConsulta = $this->Consultas->listarReceitaMedica($idConsultaRecuperada);
		
		
		
		$examesRecebidos	=	$this->Crud->readBy("tb_recebimentoexames","ds_numero_consulta",$idConsultaRecuperada,"ds_numero_consulta");
		if(!$examesRecebidos){
			$examesRecebidos="";
		}
		
		
		//SE ATENDIMENTO É CONSULTA
		if($tipoAtendimento == 1){
		
			$idConsulta			=	$idConsultaRecuperada;
			//VERIFICAR SE É PRIMEIRA CONSULTA NO SISTEMA
			
			if($totalConsultasCliente == 0){
				$primeiraConsulta = 	TRUE;
				$anamneseRecuperada = 	"";
				$consultaRecuperada = 	"";
				
			}else{
				if($this->Crud->readCond("tb_consultas","ds_numero_consulta",$idConsulta,"ds_tipo_atendimento","1","pk_id_consulta")){
					$primeiraConsulta 	= FALSE;
					$anamneseRecuperada = $this->recuperarAnamnese($idCliente);
					$consultaRecuperada = $this->recuperarConsulta($idCliente);
				}else{
					$primeiraConsulta 	= FALSE;
					$anamneseRecuperada = $this->recuperarAnamnese($idCliente);
					$consultaRecuperada = "";
				}
			}
		}
		//SE ATENDIMENTO É RETORNO
		if($tipoAtendimento == 2){
			$anamneseRecuperada =	$this->recuperarAnamnese($idCliente);
			$consultaRecuperada =	$this->recuperarConsulta($idCliente);
			$idConsulta			=	$idConsultaRecuperada;
			$primeiraConsulta	=	FALSE;
			
		}
		
		//INFORMAÇÃO SOBRE O CLIENTE/PACIENTE
		$cliente = $this->Crud->readBy("tb_clientes","pk_id_cliente",$idCliente,"ds_nome_cliente");
		$idCliente				=	$cliente[0]["pk_id_cliente"];
		$nomeCliente			=	$cliente[0]["ds_nome_cliente"];
		$dataNascimentoCliente	= 	$cliente[0]["ds_nascimento_cliente"];
		$sexoCliente			=	$cliente[0]["ds_sexo_cliente"];
		
		list($ano, $mes, $dia) = explode('-', $dataNascimentoCliente);
   		$hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
   		$nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);
   		$idadeCliente = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
		
		
		$arrayView = array(
			"camada1"				=>	'telas',
			"camada2"				=>	'consultas',
			"pagina"				=>	'formConsulta',
			"usuario"				=>	$this->session->userdata('ds_nome_usuario'),
			"perfil"				=>	$this->session->userdata('ds_nivel'),
			"primeiraConsulta"		=>	$primeiraConsulta,
			"idConsulta"			=>	$idConsulta,
			"idCliente"				=>	$idCliente,
			"idMedico"				=>	$idMedico,
			"nomeCliente"			=>	$cliente[0]["ds_nome_cliente"],
			"idade"					=>	$idadeCliente,
			"sexo"					=>	$sexoCliente,
			"tipoAtendimento"		=>	$tipoAtendimento, //Consulta ou Retorno
			"anamneseRecuperada"	=>	$anamneseRecuperada,
			"consultaRecuperada"	=>	$consultaRecuperada,
			"totalConsultasCliente"	=>	$totalConsultasCliente,
			"examesMedicos"			=>	$relacaoDeExamesMedico,
			"medicamentos"			=>	$relacaoDeMedicamentos,
			"examesDaConsulta"		=>	$examesDaConsulta,
			"examesRecebidos"		=>	$examesRecebidos,
			"medicamentosDaConsulta"=>	$medicamentosDaConsulta,
       );
        $this->load->view('layout',$arrayView);
		
	}
	
	
	/*=====================================================*/
	public function registrarAnamneseConsulta(){
		
		$idConsulta					=	$this->input->post("idConsulta");
		$idCliente					=	$this->input->post("idCliente");
		$idMedico					=	$this->input->post("idMedico");
		$tipoAtendimento			=	$this->input->post("tipoAtendimento");
		$totalConsultasCliente 		= 	$this->Crud->contarRegistros("tb_consultas","fk_id_cliente = ".$idCliente);
		
		
		if($tipoAtendimento == 1){
			if($totalConsultasCliente == 0){
				$registrarAnamnese	=	"salvar";
				$registrarConsulta	=	"salvar";
			}else
				
			if($totalConsultasCliente > 0){
				if($this->Crud->readCond("tb_consultas","ds_numero_consulta",$idConsulta,"ds_tipo_atendimento","1","pk_id_consulta")){
					$registrarAnamnese	=	"alterar";
					$registrarConsulta	=	"alterar";
				}else{
					$registrarAnamnese	=	"alterar";
					$registrarConsulta	=	"salvar";
				}
			}
		}
		if($tipoAtendimento == 2){
			$registrarAnamnese	=	"alterar";
			$registrarConsulta	=	"alterar";
		}
		
		
		$diabetes 					=	$this->input->post("diabetes");
		$oncologico 				=	$this->input->post("oncologico");
		$pressaoAlta 				=	$this->input->post("pressaoAlta");
		$pressaoBaixa 				=	$this->input->post("pressaoBaixa");
		$cardiaco 					=	$this->input->post("cardiaco");
		$outrosAntecedentes 		=	$this->input->post("outrosAntecedentes");
		$descreveOutrosAntecedentes =	$this->input->post("descreveOutrosAntecedentes");
		$usoMedicamentos 			=	$this->input->post("usoMedicamentos");
		$descreveMedicamento 		=	$this->input->post("descreveMedicamento");
		$alergiaMedicamento 		=	$this->input->post("alergiaMedicamento");
		$descreveMedicamentoAlergia=	$this->input->post("descreveMedicamentoAlergia");
		$fezCirurgia 				=	$this->input->post("fezCirurgia");
		$descreveCirurgia			=	$this->input->post("descreveCirurgia");
		$cicloMenstrual				=	$this->input->post("cicloMenstrual");
		$anticoncepcional			=	$this->input->post("anticoncepcional");
		$fumante					=	$this->input->post("fumante");
		$bebidaAlcoolica			=	$this->input->post("bebidaAlcoolica");
		$atividadeFisica			=	$this->input->post("atividadeFisica");
		$descreveAtividadeFisica 	=	$this->input->post("descreveAtividadeFisica");
		$restricaoAlimento 			=	$this->input->post("restricaoAlimento");
		$descreveRestricaoAlimento 	=	$this->input->post("descreveRestricaoAlimento");
		
		$dadosAnamnese = array(
			"ds_ultima_consulta"			=>	$idConsulta,
			"fk_id_cliente"					=>	$idCliente,
			"ds_diabetes" 					=>	$diabetes,
			"ds_oncologico"					=>	$oncologico,
			"ds_pressaoAlta" 				=>	$pressaoAlta,
			"ds_pressaoBaixa"	 			=>	$pressaoBaixa,
			"ds_cardiaco" 					=>	$cardiaco,
			"ds_outrosAntecedentes" 		=>	$outrosAntecedentes,
			"ds_descreveOutrosAntecedentes" =>	$descreveOutrosAntecedentes,
			"ds_usoMedicamentos" 			=>	$usoMedicamentos,
			"ds_descreveMedicamento" 		=>	$descreveMedicamento,
			"ds_alergiaMedicamento" 		=>	$alergiaMedicamento,
			"ds_descreveMedicamentoAlergia"	=>	$descreveMedicamentoAlergia,
			"ds_fezCirurgia" 				=>	$fezCirurgia,
			"ds_descreveCirurgia"			=>	$descreveCirurgia,
			"ds_cicloMenstrual"				=>	$cicloMenstrual,
			"ds_anticoncepcional"			=>	$anticoncepcional,
			"ds_fumante"					=>	$fumante,
			"ds_bebidaAlcoolica"			=>	$bebidaAlcoolica,
			"ds_atividadeFisica"			=>	$atividadeFisica,
			"ds_descreveAtividadeFisica" 	=>	$descreveAtividadeFisica,
			"ds_restricaoAlimento" 			=>	$restricaoAlimento,
			"ds_descreveRestricaoAlimento" 	=>	$descreveRestricaoAlimento,
		
		);
		
		$queixa 					=	$this->input->post("queixa");
		$temperatura 				=	$this->input->post("temperatura");
		$pressaoSanguinea			=	$this->input->post("pressaoSanguinea");
		$batimento					=	$this->input->post("batimento");
		$peso						=	$this->input->post("peso");
		$parecerMedico				=	$this->input->post("parecerMedico");
		$dataConsulta				=	date("Y-m-d");
		
		$dadosConsulta = array(
			"ds_numero_consulta"	=>	$idConsulta,
			"ds_tipo_atendimento"	=>	$tipoAtendimento,
			"fk_id_cliente"			=>	$idCliente,
			"fk_id_profissional"	=>	$idMedico,
			"ds_queixa"				=>	$queixa,
			"ds_temperatura" 		=>	$temperatura,
			"ds_pressaoSanguinea"	=>	$pressaoSanguinea,
			"ds_batimento"			=>	$batimento,
			"ds_peso"				=>	$peso,
			"ds_parecerMedico"		=>	$parecerMedico,
			"ds_data_consulta"		=>	$dataConsulta,
			"ds_status"				=>	1,
		);
		
		$this->form_validation->set_rules( 'queixa', 'Queixa do Paciente', 'required' );
		if($outrosAntecedentes==1){
			$this->form_validation->set_rules( 'descreveOutrosAntecedentes', 'Descrever outros antecedentes', 'required' );
		}
		
		if($usoMedicamentos==1){
			$this->form_validation->set_rules( 'descreveMedicamento', 'Descrever qual medicamento o paciente usa.', 'required' );
		}
		
		if($alergiaMedicamento==1){
			$this->form_validation->set_rules( 'descreveMedicamentoAlergia', 'Descreva qual medicamento o paciente tem alergia.', 'required' );
		}
		
		if($fezCirurgia==1){
			$this->form_validation->set_rules( 'descreveCirurgia', 'Descrever qual cirurgia o paciente fez.', 'required' );
		}
		
		if($atividadeFisica==1){
			$this->form_validation->set_rules( 'descreveAtividadeFisica', 'Descreva qual atividade física o paciente pratica.', 'required' );
		}
		
		if($restricaoAlimento==1){
			$this->form_validation->set_rules( 'descreveRestricaoAlimento', 'Descreva qual alimento o paciente evita comer.', 'required' );
		}
		$this->form_validation->set_rules( 'parecerMedico', 'Parecer do médico.', 'required');
		
		if ( $this->form_validation->run() == true ) {
			
			$duplicidade  = $this->Crud->readCond( "tb_consultas", "ds_numero_consulta", $idConsulta,"ds_tipo_atendimento",$tipoAtendimento,"ds_numero_consulta" );
			
			if($registrarConsulta == "salvar"){
				$this->Crud->create( "tb_consultas", $dadosConsulta );
				//$this->Crud->update( "tb_agendaconsultas",array("ds_dados_ultimaconsulta"=>$idConsulta), $dadosConsulta );
			}
			
			if($registrarAnamnese == "salvar"){
				$this->Crud->create( "tb_anamnese", $dadosAnamnese );
			}
			if($registrarAnamnese == "alterar"){
				$this->Crud->update( "tb_anamnese", $dadosAnamnese, array( "fk_id_cliente" => $idCliente) );
			}
			if($registrarConsulta == "alterar"){
				$this->Crud->update( "tb_consultas", $dadosConsulta, array( "fk_id_cliente" => $idCliente) );
			}

				$this->iniciarConsultas($idCliente.'-'.$tipoAtendimento.'-'.$idConsulta.'-'.$idMedico);
			
		}else{
			$this->iniciarConsultas($idCliente.'-'.$tipoAtendimento.'-'.$idConsulta.'-'.$idMedico);
		}
		
	}
	
	public function recuperarAnamnese($idCliente = NULL){
		$anamnese = $this->Crud->readBy("tb_anamnese","fk_id_cliente",$idCliente,"pk_id_anamnese");
		
		$arrayAnamnese =  array(
			"pk_id_anamnese"				=>	$anamnese[0]["pk_id_anamnese"],
			"fk_id_cliente"					=>	$anamnese[0]["fk_id_cliente"],
			"ds_ultima_consulta"			=>	$anamnese[0]["ds_ultima_consulta"],
			"ds_diabetes"					=>	$anamnese[0]["ds_diabetes"],
			"ds_oncologico"					=>	$anamnese[0]["ds_oncologico"],
			"ds_pressaoAlta"				=>	$anamnese[0]["ds_pressaoAlta"],
			"ds_pressaoBaixa"				=>	$anamnese[0]["ds_pressaoBaixa"],
			"ds_cardiaco"					=>	$anamnese[0]["ds_cardiaco"],
			"ds_outrosAntecedentes"			=>	$anamnese[0]["ds_outrosAntecedentes"],
			"ds_descreveOutrosAntecedentes"	=>	$anamnese[0]["ds_descreveOutrosAntecedentes"],
			"ds_usoMedicamentos"			=>	$anamnese[0]["ds_usoMedicamentos"],
			"ds_descreveMedicamento"		=>	$anamnese[0]["ds_descreveMedicamento"],
			"ds_alergiaMedicamento"			=>	$anamnese[0]["ds_alergiaMedicamento"],
			"ds_descreveMedicamentoAlergia"	=>	$anamnese[0]["ds_descreveMedicamentoAlergia"],
			"ds_fezCirurgia"				=>	$anamnese[0]["ds_fezCirurgia"],
			"ds_descreveCirurgia"			=>	$anamnese[0]["ds_descreveCirurgia"],
			"ds_cicloMenstrual"				=>	$anamnese[0]["ds_cicloMenstrual"],
			"ds_anticoncepcional"			=>	$anamnese[0]["ds_anticoncepcional"],
			"ds_fumante"					=>	$anamnese[0]["ds_fumante"],
			"ds_bebidaAlcoolica"			=>	$anamnese[0]["ds_bebidaAlcoolica"],
			"ds_atividadeFisica"			=>	$anamnese[0]["ds_atividadeFisica"],
			"ds_descreveAtividadeFisica"	=>	$anamnese[0]["ds_descreveAtividadeFisica"],
			"ds_restricaoAlimento"			=>	$anamnese[0]["ds_restricaoAlimento"],
			"ds_descreveRestricaoAlimento"	=>	$anamnese[0]["ds_descreveRestricaoAlimento"],
		);
		return $arrayAnamnese;
		
	}
	
	public function recuperarConsulta($idCliente = NULL){
		$consulta = $this->Crud->readBy("tb_consultas","fk_id_cliente",$idCliente,"ds_data_consulta DESC");
		
		$arrayConsulta = array(
			"ds_numero_consulta"	=>	$consulta[0]["ds_numero_consulta"],
			"ds_tipo_atendimento"	=>	$consulta[0]["ds_tipo_atendimento"],
			"fk_id_cliente"			=>	$consulta[0]["fk_id_cliente"],
			"ds_data_consulta"		=>	$consulta[0]["ds_data_consulta"],
			"ds_queixa"				=>	$consulta[0]["ds_queixa"],
			"ds_temperatura"		=>	$consulta[0]["ds_temperatura"],
			"ds_pressaosanguinea"	=>	$consulta[0]["ds_pressaosanguinea"],
			"ds_batimento"			=>	$consulta[0]["ds_batimento"],
			"ds_peso"				=>	$consulta[0]["ds_peso"],
			"ds_parecermedico"		=>	$consulta[0]["ds_parecermedico"],
			"ds_status"				=>	$consulta[0]["ds_status"],
		);
		return $arrayConsulta;
	}
	
	public function verificarNumeroConsulta(){
		$numeroConsulta = trim( $_POST[ 'numeroConsulta' ] );
		
		$consulta = $this->Crud->readBy("tb_consultas","ds_numero_consulta",$numeroConsulta,"pk_id_consulta");
		if($consulta){
			$jsondt[] = array( 
				'retorno' => 'true',
			);
			jsonMe( $jsondt );
		}else{
			$jsondt[] = array( 
				'retorno' => 'false',
			);
			jsonMe( $jsondt );
		}
	}
	
	
	
	
	
	
	
	public function formPacienteHistorico(){
		if(!$this->session->userdata('ds_status')){
			redirect('Home');
		}
		//clientes do médico para serem atendidos no dia:
		$medico		=	$this->session->userdata('fk_id_profissional');
		$pacientes	=	$this->Clientes->clientesMedico($medico);
		
		$titulosTabela = array('Registro','Cliente','CPF');
		
		$arrayView = array(
			"camada1"		=>	'telas',
			"camada2"		=>	'consultas',
			"pagina"		=>	'pacienteHistorico',
			"usuario"		=>	$this->session->userdata('ds_nome_usuario'),
			"perfil"		=>	$this->session->userdata('ds_nivel'),
			"titulosTabela"	=>	$titulosTabela,
			"medico"		=>	$medico,
			"pacientes"		=>	$pacientes
       );
        $this->load->view('layout',$arrayView);
	}
	
	public function historicoPaciente(){
		if(!$this->session->userdata('ds_status')){
			redirect('Home');
		}
		
		$idPaciente	=	$this->uri->segment(3);
		$idMedico	=	$this->uri->segment(4);
		$consultas	=	$this->Crud->readCond("tb_consultas","fk_id_cliente",$idPaciente,"fk_id_profissional",$idMedico,"ds_numero_consulta DESC");
		
		$paciente	=	$this->Crud->readBy("tb_clientes","pk_id_cliente",$idPaciente,"ds_nome_cliente");
		$medico		=	$this->Crud->readBy("tb_profissionais","pk_id_profissional",$idMedico,"ds_nome_profissional");
		
		$historico = array();
			foreach($consultas as $consulta){
			
				$dataConsulta	=	date("d/m/Y",strtotime($consulta["ds_data_consulta"]));
				$numeroConsulta =	$consulta["ds_numero_consulta"];
				$queixaConsulta =	$consulta["ds_queixa"];
				$exames			=	$this->Consultas->listarExamesMedico($numeroConsulta);
				$receita		=	$this->Consultas->listarReceitaMedica($numeroConsulta);
				$parecer		=	$consulta["ds_parecermedico"];

				$historico[$numeroConsulta]["data"]			=	$dataConsulta;
				$historico[$numeroConsulta]["idConsulta"]	=	$numeroConsulta;
				$historico[$numeroConsulta]["queixa"]		=	$queixaConsulta;
				$historico[$numeroConsulta]["exames"]		=	$exames;
				$historico[$numeroConsulta]["receita"]		=	$receita;
				$historico[$numeroConsulta]["parecer"]		=	$parecer;
			}
		
			$titulosHistorico = array('Consulta','Data da consulta','Queixa do paciente','Exames pedidos','Receita prescrita','Parecer Médico');
			$arrayHistorico = array(
				"camada1"			=>	'telas',
				"camada2"			=>	'clientes',
				"pagina"			=>	'historicos',
				"brasao"			=>	FCPATH."external/img/brasao.jpg",
				"fundo"				=>	FCPATH."external/img/fundo.jpg",
				"titulosHistorico"	=>	$titulosHistorico,
				"usuario"			=>	$this->session->userdata('ds_nome_usuario'),
				"perfil"			=>	$this->session->userdata('ds_nivel'),
				"paciente"			=>	$paciente,
				"medico"			=>	$medico,
				"historico"			=>	$historico,
			);
			if($this->uri->segment(5)=="imprimir"){
				imprimir($arrayHistorico,"historico_medico","P");
			}else{
			 	$this->load->view('layout',$arrayHistorico);
			}
			
		
		
		
	}
	public function finalizarConsulta(){
		if($this->uri->segment(3)==""){
			$numeroConsulta = $this->input->post("numeroConsulta");
		}else{
			$numeroConsulta = $this->uri->segment(3);
		}
		
		$dadosConsulta = array(
			"ds_status"	=>	"3",
		);
		print_r("Numero: ".$numeroConsulta);
		$this->Crud->update( "tb_consultas", $dadosConsulta, array( "ds_numero_consulta" => $numeroConsulta) );
		$this->Crud->update( "tb_agendaconsultas", $dadosConsulta, array( "ds_numero_consulta" => $numeroConsulta) );
		redirect("Medicos/formAtendimentoConsultas");
		
	}
	
}
	
	
	
